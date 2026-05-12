# Scanner Protocol

Wire contract between this Laravel app and the separate `dealership-scanner`
Go repo. Both sides MUST implement the rules below identically. If the two
sides ever diverge, the Go side is authoritative and the Laravel side is the
bug — the Go side is the last line of defence before network activity.

When you change this doc, also update the same section in the Go repo's
`README.md` (or `docs/protocol.md`) and bump `PROTOCOL_VERSION` on both sides.

---

## Transport

Redis streams. No HTTP, no gRPC.

```
scanning:dispatch       (Laravel → Go)   scan jobs to run
scanning:results        (Go → Laravel)   findings + status updates + violations
scanning:heartbeat      (Go → Redis)     liveness key, updated every 10s, TTL 60s
```

Each stream entry has two fields:

- `protocol_version`: string. Currently `"1"`. Refuse to consume any other
  value (log loudly, leave the entry unACKed).
- `payload`: JSON-encoded string, shape defined below per stream + kind.

## Consumer group + ack semantics

- Stream `scanning:dispatch`. Consumer group `scanner`. One consumer per
  running Go binary instance, named from `os.Hostname()`.
- `XREADGROUP GROUP scanner <name> BLOCK 5000 COUNT 1 STREAMS scanning:dispatch >`.
- ACK (`XACK`) only after the scan has either completed or failed AND the
  terminal `status` message has been published to `scanning:results`. Never
  ACK on consume — a crashed worker would lose the dispatch.
- Run `XAUTOCLAIM` on a timer (every 30s on the Go side; every minute on the
  Laravel side for the results stream) to recover messages from crashed
  peers. Min-idle 60 seconds.

## Heartbeat

Go worker sets `scanning:heartbeat` to the current unix timestamp every 10
seconds with TTL 60 seconds. Laravel scheduled task watches the key; alert
ops if it's missing for >2 minutes.

---

## Dispatch message (Laravel → Go)

```json
{
  "scan_id": 12345,
  "scan_uuid": "9e7c1f2a-...",
  "tenant_id": "muller-acura",
  "scan_type": "external_vuln",
  "authorization_id": 42,
  "authorization_scope": {
    "ips": ["203.0.113.4"],
    "cidrs": ["198.51.100.0/24"],
    "domains": ["mullermca.com"]
  },
  "targets": [
    {"asset_id": 88, "type": "domain", "value": "mullermca.com"}
  ],
  "config": {
    "nuclei_severity": ["medium", "high", "critical"],
    "rate_limit": 50
  },
  "dispatched_at": "2026-05-12T18:30:00Z"
}
```

Target `type` is one of: `ip`, `ip_range`, `domain`, `url`.

## Result messages (Go → Laravel)

```json
// kind: status (running)
{
  "kind": "status",
  "scan_id": 12345,
  "tenant_id": "muller-acura",
  "scan_uuid": "9e7c1f2a-...",
  "status": "running",
  "at": "2026-05-12T18:31:00Z"
}

// kind: status (terminal — completed)
{
  "kind": "status",
  "scan_id": 12345,
  "tenant_id": "muller-acura",
  "scan_uuid": "9e7c1f2a-...",
  "status": "completed",
  "summary": {
    "findings_count": 17,
    "by_severity": {"critical": 1, "high": 4, "medium": 8, "low": 4},
    "highest_severity": "critical",
    "targets_completed": 1
  },
  "at": "2026-05-12T18:55:00Z"
}

// kind: finding
{
  "kind": "finding",
  "scan_id": 12345,
  "tenant_id": "muller-acura",
  "asset_id": 88,
  "source": "nuclei",
  "source_check_id": "tls-version-tls10",
  "title": "TLS 1.0 enabled",
  "description": "...",
  "severity": "high",
  "cvss_score": 7.4,
  "cve_id": "CVE-2014-3566",
  "port": 443,
  "protocol": "tcp",
  "service": "https",
  "version_detected": null,
  "raw_evidence": {"matched_at": "https://mullermca.com:443", "matcher_name": "..."}
}

// kind: violation — Go refused to scan because target failed scope verification
{
  "kind": "violation",
  "scan_id": 12345,
  "tenant_id": "muller-acura",
  "asset_id": 88,
  "reason": "domain_not_in_scope" | "cidr_not_contained" | "cidr_partial_overlap" | "public_suffix_scope",
  "target": {"type": "domain", "value": "out-of-scope.example.com"},
  "at": "2026-05-12T18:31:05Z"
}
```

A `kind: "violation"` arriving on the Laravel side is treated as a P1
incident, not a routine event. Laravel pre-validated the target with the
same contract below; receiving a violation means the two sides have drifted
or a bug bypassed the Laravel-side check.

---

## Scope containment contract

This is the heart of the safety story. Both Laravel and Go run these rules
**before any network activity**.

### IP / IP-range targets

- Target must be **contained within ONE entry** in
  `authorization_scope.cidrs` (or equal to one entry in
  `authorization_scope.ips`). Single-CIDR containment, not union containment.
  A target that spans two authorised CIDRs is out of scope, even if every
  address in the target is covered by the union.
  - Auth `["10.0.0.0/8", "192.168.0.0/16"]`, target `10.5.0.0/16` →
    **in scope**.
  - Auth `["10.0.0.0/8", "192.168.0.0/16"]`, target spanning both blocks →
    **out of scope** (`cidr_not_contained`).
- Partial overlap is treated as out-of-scope. A `/4` target is not "in
  scope" of a `/8` authorisation even if the `/8` is one of the blocks the
  `/4` covers — the `/4` also covers blocks that were never authorised
  (`cidr_partial_overlap`).
- A `/32` target is a single IP. It passes if it's contained in any
  `authorization_scope.cidrs` entry **or** equals any
  `authorization_scope.ips` entry. Whichever check passes first wins.
- Containment math uses `net/netip.Prefix.Contains` on the Go side. The
  Laravel side implements the same semantics (helper around PHP's
  `inet_pton` + bit comparison, or `Symfony\Component\HttpFoundation\IpUtils::checkIp4`
  / `checkIp6`). Both produce identical results for valid input.
- Reject invalid CIDRs at scope-authorisation signing time
  (`SignScopeAuthorizationRequest`), not at dispatch.

### Domain / URL targets

- Target must equal one entry in `authorization_scope.domains`, or be a
  subdomain of one (suffix match with a **leading dot**).
  - Scope `example.com`, target `api.example.com` → **in scope**.
  - Scope `example.com`, target `api-example.com` → **out of scope**.
- Refuse a scope entry that is itself a public suffix (e.g., `co.uk`,
  `s3.amazonaws.com`). Check with `golang.org/x/net/publicsuffix` on Go and
  an equivalent library or curated denylist on Laravel. A public-suffix
  scope entry rejects at signing time
  (`SignScopeAuthorizationRequest`) — it never reaches a dispatch.
- For a URL target, extract the hostname and apply the domain rule. Path,
  query, port are ignored for scope purposes.

### Violation reasons (Go publishes these verbatim)

- `cidr_not_contained` — target IP/CIDR isn't fully contained in any single
  authorised CIDR (and isn't an exact `ips` match).
- `cidr_partial_overlap` — variant of the above; the target *partially*
  overlaps an authorised CIDR but covers addresses outside it. Surfaced
  separately because it's the most dangerous failure mode and worth its own
  alert classifier.
- `domain_not_in_scope` — target hostname is neither equal to nor a
  subdomain of any authorised domain.
- `public_suffix_scope` — sanity check; should never fire if the Laravel
  side rejects at signing time.

---

## Enforcement points

### Laravel side

1. **`SignScopeAuthorizationRequest`** — every CIDR parses cleanly; no
   public-suffix domain entries; reject at sign time so they never reach a
   scan.
2. **`TriggerScanRequest::rules()`** — validate every target the user picks
   for this scan satisfies the contract against the bound
   `ScanAuthorization`'s `scope`. Reject with a clear message:
   `Target {value} is not contained within the active authorisation.`
3. **`TriggerScan` Action** — re-check defensively before writing the
   `Scan` row and dispatching. Protects against any path that bypasses the
   form (API, future scheduled scans, console commands).

### Go side

1. **`internal/scope/cidr.go`** — `Contains(authCidr, targetCidr)` and
   `EqualOrInIPs(ips, target)`. Single-CIDR semantics; no union math. Table-
   driven tests cover every combo (in-scope `/32`, contained CIDR, partial
   overlap, union span, exact match, `0.0.0.0/0` edge cases).
2. **`internal/scope/domain.go`** — suffix match with a leading dot;
   public-suffix-list refusal. Table-driven tests cover the
   `api-example.com` near-miss.
3. **Orchestrator** — every target is run through `scope.Verify(...)` before
   any executor is invoked. On rejection, publish `kind: "violation"` with
   the matching reason and continue to the next target.

---

## Versioning

- `protocol_version` is a string. Currently `"1"`.
- Bump on any breaking schema change to either dispatch or result payloads,
  or any change to the containment / suffix-match rules.
- Both sides hard-fail on unknown versions. Don't try to best-effort an
  unknown payload — leave the message unACKed and let a fresh deploy pick
  it up.
- Document every version bump in both repos' CHANGELOG and tag a synchronised
  release of Laravel + Go.
