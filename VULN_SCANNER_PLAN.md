# Dealership Vulnerability Scanning Feature — Implementation Plan

## Project Context

This is a new feature inside an existing **Laravel multi-tenant dealership compliance platform**. Not a standalone product, not a SaaS for MSPs — a vulnerability scanning capability bolted into the platform our dealership tenants already use for compliance workflows.

**Existing stack** (do not change these):
- Laravel (latest stable, follow existing patterns in the codebase)
- `stancl/tenancy` with **multi-database architecture** — central DB + one DB per tenant
- MySQL (central + tenant DBs)
- Redis (queues, cache, tenant isolation)
- DigitalOcean droplets, deployed via Ploi
- Existing five-role hierarchy: admins, consultants, owners, managers, employees
- Existing entities: tenants (dealerships), stores, employees, compliance dashboards, audit forms

**What this feature is *not*:** A clone of CYRISMA, Tenable, or Qualys. We are not building a multi-tenant MSP scanning product. We have direct tenants (dealerships), not channel partners with their own clients. The scope is dramatically smaller than a commercial vuln management platform.

---

## Goal

Give each dealership the ability to:
1. Register their public-facing assets (domains, websites, public IPs).
2. Have those assets scanned automatically on a weekly cadence + on-demand.
3. See findings in plain language tied to **FTC Safeguards Rule** (16 CFR § 314) compliance.
4. Generate PDF reports for their compliance file.
5. Get notified when a critical issue appears.

The killer differentiator vs. generic scanners: **FTC Safeguards Rule mapping for the auto-dealer vertical**. Dealerships are required by the FTC to maintain a written infosec program with regular risk assessments. A finding labeled "this affects your compliance with § 314.4(c)(2)" is more valuable to our users than a CVSS score they don't understand.

---

## Phase 1 Scope (this plan)

External attack surface scanning of dealership-owned assets:
- Domain/subdomain enumeration
- Port and service detection
- TLS/SSL audit
- HTTP header hygiene
- Known-CVE matching against detected service versions
- Templated checks via Nuclei

## Phase 2 (NOT in scope yet — design with this in mind but do not build)

Internal network scanning via a lightweight agent installed on a dealership PC. Carries auth + posture data back. We'll revisit this after Phase 1 is in production for ~3 months.

---

## Explicitly Out of Scope (do not build these)

These were considered and intentionally cut. If they seem necessary, flag it rather than building:

- ❌ Scanner node registry, heartbeats, lease/reaper systems. Overkill for our scale.
- ❌ Multi-region scanner pools.
- ❌ Per-tenant queue fairness / weighting. We have dozens of tenants, not thousands.
- ❌ A separate "Security" section in the UI. Findings live in the existing compliance dashboard.
- ❌ Generic compliance framework support (NIST CSF, PCI, HIPAA, etc.). FTC Safeguards only. We can add others later if a tenant asks.
- ❌ Custom risk scoring formula. Use CVSS + CISA KEV flag. Build custom scoring later if needed.

---

## Architectural Decisions

### Database split: central vs tenant

- **Central DB** holds **shared reference data** that doesn't belong to any tenant: CVE catalog (NVD feed), CPE data, FTC Safeguards Rule control catalog and finding-mapping rules.
- **Tenant DB** holds everything tenant-specific: assets, scope authorizations, scans, findings, evidence.
- Cross-DB references (e.g., `findings.cve_id` → `central.cves.cve_id`) use string FKs without DB-level constraints. Indexed for lookup. Cache hot CVE lookups in Redis.

### Scanner runtime — Go worker

A dedicated DigitalOcean droplet (`scanner-1`) runs a **standalone Go worker
binary** that owns the entire scan pipeline. The Go worker is not a Laravel
queue consumer — it speaks its own JSON protocol over Redis.

Installed on `scanner-1`:
- The Go worker binary (`/usr/local/bin/dealership-scanner`), managed by `systemd`.
- `nuclei` / `httpx` / `subfinder` (ProjectDiscovery, installed via Go).
- `nmap`
- `sslyze`
- A `nuclei` templates directory, refreshed nightly by systemd timer.

**Do not install scanning tools on the main application droplet.** Outbound
scanning traffic from the app server is a bad idea operationally and
reputationally.

### Why a Go worker (and what we give up)

| Concern | Laravel-shellout (previous draft) | Go worker (chosen) |
|---|---|---|
| Concurrency | One scan per PHP process, blocks the queue worker | Goroutine per scan target, bounded by a worker pool |
| Memory profile | PHP holds CLI output in memory while parsing | Streaming line-by-line decode, low constant memory |
| Crash recovery | Lost on PHP fatal | Redis consumer group + `XACK` only after persist |
| Deployment | Same Ploi pipeline as app | Separate binary + systemd unit + release script |
| Debugging | Reuses Laravel tooling (Sentry/Telescope) | Own log shipping (Sentry Go SDK) |

We accept the deployment overhead because scan volume and the streaming-parse
pattern justify it. If volume stays small, that overhead never pays off — but
the call has been made.

### Communication protocol (Laravel ⟷ Go)

Two Redis streams + a small heartbeat key. No HTTP/gRPC.

```
scanning:dispatch       (Laravel → Go)   scan jobs to run
scanning:results        (Go → Laravel)   parsed findings + status updates
scanning:heartbeat      (Go → Redis)     periodic worker liveness for monitoring
```

**Dispatch message shape** (Laravel writes one `XADD` entry per scan):

```json
{
  "scan_id": 12345,
  "tenant_id": "muller-acura",
  "scan_uuid": "9e..." ,
  "scan_type": "external_vuln",
  "authorization_id": 42,
  "authorization_scope": {
    "ips": ["203.0.113.4"],
    "cidrs": [],
    "domains": ["mullermca.com"]
  },
  "targets": [
    {"asset_id": 88, "type": "domain", "value": "mullermca.com"}
  ],
  "config": { "nuclei_severity": ["medium","high","critical"], "rate_limit": 50 },
  "dispatched_at": "2026-05-11T18:30:00Z"
}
```

**Result message shape** (Go writes many `XADD` entries per scan — one per
finding, plus status transitions):

```json
{ "kind": "status", "scan_id": 12345, "tenant_id": "muller-acura", "status": "running" }
{ "kind": "finding", "scan_id": 12345, "tenant_id": "muller-acura", "asset_id": 88, "source": "nuclei", "source_check_id": "tls-version", "title": "...", "severity": "high", "cvss_score": 7.4, "raw_evidence": {"...": "..."} }
{ "kind": "status", "scan_id": 12345, "tenant_id": "muller-acura", "status": "completed", "summary": {"findings_count": 17, "highest_severity": "high"} }
```

**Why streams, not lists:**
- `XREADGROUP` + consumer groups give per-message acknowledgement, so a Go
  worker that crashes mid-scan doesn't drop the dispatch — `XAUTOCLAIM` from
  another worker picks it up after a timeout.
- Backfill / replay is possible without ad-hoc tooling (`XRANGE`).
- Laravel reads `scanning:results` with `XREAD` from a lightweight long-running
  process (`php artisan scanning:consume-results`) running on the app server.

### Authorization gating — non-negotiable

Scope verification is the responsibility of **both** sides:

1. **Laravel side, before dispatch**: confirms the `ScanAuthorization` is
   active, runs the scope containment contract below against every target,
   builds the authoritative `authorization_scope` blob, and embeds it in the
   dispatch message. The Go worker never queries the DB for scope — it trusts
   what Laravel told it.
2. **Go side, before any network touch**: for every target the orchestrator
   handles, re-runs the exact same containment contract against the embedded
   `authorization_scope`. On mismatch: do not run, publish a
   `kind: "violation"` result message, terminate the scan.

Defence in depth: Laravel could in theory be tricked into dispatching an
out-of-scope target via a bug; the Go worker refusing to scan it is the last
line. Both sides MUST implement the rules identically — if they diverge, the
Go side is authoritative and the Laravel side is the bug.

### Scope containment contract

The rules below define what counts as "in scope" for a target. They are
identical on both sides. Cross-published verbatim in
`docs/scanner-protocol.md` so the Go repo and this repo can't drift.

**IP / IP-range targets:**

- Target must be **contained within ONE entry** in `authorization_scope.cidrs`
  (or equal to one entry in `authorization_scope.ips`). Single-CIDR
  containment, not union containment. A target that spans two authorised
  CIDRs is out of scope, even if every address in the target is covered by
  the union. (Concrete example: auth has `10.0.0.0/8` and `192.168.0.0/16`;
  a target of `10.5.0.0/16` is in scope, a target spanning both blocks is
  not.)
- Partial overlap is treated as out-of-scope on both sides. A `/4` target is
  not "in scope" of a `/8` authorisation even if the `/8` is one of the
  blocks the `/4` covers — the `/4` also covers blocks that were never
  authorised.
- A `/32` target is a single IP. It passes if it's contained in any
  `authorization_scope.cidrs` entry **or** equals any
  `authorization_scope.ips` entry. Whichever check passes first wins.
- Containment math uses `net/netip.Prefix.Contains` on the Go side and the
  PHP equivalent (`Symfony\Component\HttpFoundation\IpUtils::checkIp` or a
  small `netip`-style helper) on the Laravel side. Both produce the same
  result for valid input; reject invalid CIDRs at scope-authorisation
  signing time.

**Domain / URL targets:**

- Target must equal one entry in `authorization_scope.domains`, or be a
  subdomain of one (suffix match with a leading dot — `api.example.com`
  matches scope `example.com`, but `api-example.com` does not).
- Refuse a scope that is itself a public suffix (e.g., `co.uk`). Check with
  the public-suffix-list package — `golang.org/x/net/publicsuffix` on Go,
  an equivalent library or curated denylist on Laravel.
- For a URL target, extract the hostname and apply the domain rule. Path /
  query / port are ignored for scope purposes.

**Enforcement points on the Laravel side:**

1. `TriggerScanRequest::rules()` — validate that every target the user picks
   for this scan satisfies the contract against the bound
   `ScanAuthorization`'s `scope`. Reject with a clear message:
   `Target {value} is not contained within the active authorisation.`
2. `TriggerScan` Action — re-check defensively before writing the `Scan`
   row and dispatching. Protects against any path that bypasses the form
   (API, future scheduled scans, console commands, etc.).
3. `SignScopeAuthorizationRequest` — validate every CIDR in the scope blob
   parses cleanly and isn't a public suffix; reject malformed entries at
   sign time so they never reach a scan.

A Laravel-side rejection at point 1 or 2 returns a 422 to the user with the
specific bad target. The scan row is never created. If a bug ever lets one
through and the Go worker rejects it instead, the `kind: "violation"` result
message is logged as a P1 — that's a contract violation between the two
sides, not a routine event.

### Tenancy & scanning

Scans are dispatched per-tenant. The dispatch message carries `tenant_id`. The
Laravel result-consumer command initialises tenant context
(`tenancy()->initialize($tenant)`) before persisting each batch of result
messages. Find an existing tenant-aware command/job in the codebase and
mirror that pattern — don't hand-roll a new one.

---

## Legal / Safety — Non-Negotiable

Even though tenants are scanning their **own** assets, scope authorization is still load-bearing:

1. Before any scan runs, a dealership owner or manager must sign a scope authorization record specifying exactly which assets are in scope.
2. Authorizations are stored with full audit trail: signing user, IP, timestamp, terms text, signature hash.
3. Authorizations expire (default 1 year) and must be re-signed.
4. The scanner job must verify the target is within an active authorization before touching it. If not, reject and log loudly.
5. All scan activity is auditable — who, what, when.

This protects both the platform and the dealership. Do not allow any code path that scans without a valid authorization.

---

## Database Schema

### Central DB migrations (`database/migrations/`)

```php
// create_cves_table.php
Schema::create('cves', function (Blueprint $table) {
    $table->id();
    $table->string('cve_id')->unique();           // CVE-2024-12345
    $table->text('description');
    $table->decimal('cvss_v3_score', 3, 1)->nullable();
    $table->string('cvss_v3_vector')->nullable();
    $table->string('severity')->nullable();        // critical/high/medium/low
    $table->decimal('epss_score', 6, 5)->nullable();
    $table->boolean('in_cisa_kev')->default(false);
    $table->timestamp('kev_added_at')->nullable();
    $table->json('cpe_matches')->nullable();
    $table->json('references')->nullable();
    $table->timestamp('published_at');
    $table->timestamp('modified_at');
    $table->timestamps();

    $table->index('severity');
    $table->index('in_cisa_kev');
    $table->index('cvss_v3_score');
});

// create_cpes_table.php — denormalize for fast vendor/product/version lookups
Schema::create('cpes', function (Blueprint $table) {
    $table->id();
    $table->string('cpe23')->index();
    $table->string('vendor')->index();
    $table->string('product')->index();
    $table->string('version')->nullable();
    $table->foreignId('cve_id')->constrained('cves')->cascadeOnDelete();
    $table->timestamps();

    $table->index(['vendor', 'product', 'version']);
});

// create_ftc_safeguards_controls_table.php — control catalog
Schema::create('ftc_safeguards_controls', function (Blueprint $table) {
    $table->id();
    $table->string('control_id')->unique();        // "314.4(c)(2)"
    $table->string('title');
    $table->text('description');
    $table->text('plain_language');                // for end users
    $table->timestamps();
});

// create_finding_compliance_rules_table.php — rules that map findings to controls
Schema::create('finding_compliance_rules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('ftc_safeguards_control_id')->constrained();
    $table->json('match_rules');                   // {source: 'nuclei', tags: ['ssl','tls']}
    $table->string('priority')->default('medium');
    $table->timestamps();
});
```

### Tenant DB migrations (`database/migrations/tenant/`)

```php
// create_asset_groups_table.php
Schema::create('asset_groups', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->foreignId('store_id')->nullable()->constrained();
    $table->timestamps();
});

// create_assets_table.php
Schema::create('assets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('asset_group_id')->nullable()->constrained()->nullOnDelete();
    $table->string('type');                        // ip | ip_range | domain | url
    $table->string('value');
    $table->string('label')->nullable();
    $table->json('tags')->nullable();
    $table->json('metadata')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamp('first_seen_at');
    $table->timestamp('last_seen_at');
    $table->timestamps();

    $table->unique(['type', 'value']);
    $table->index('type');
});

// create_scan_authorizations_table.php
Schema::create('scan_authorizations', function (Blueprint $table) {
    $table->id();
    $table->uuid('auth_uuid')->unique();
    $table->foreignId('authorized_by_user_id')->constrained('users');
    $table->string('authorized_by_name');          // snapshot
    $table->string('authorized_by_title');
    $table->json('scope');                         // {ips: [...], cidrs: [...], domains: [...]}
    $table->text('terms_accepted_text');
    $table->string('signature_hash');
    $table->ipAddress('signed_from_ip');
    $table->timestamp('signed_at');
    $table->timestamp('expires_at');
    $table->timestamp('revoked_at')->nullable();
    $table->timestamps();

    $table->index('expires_at');
});

// create_scans_table.php
Schema::create('scans', function (Blueprint $table) {
    $table->id();
    $table->uuid('scan_uuid')->unique();
    $table->foreignId('scan_authorization_id')->constrained();
    $table->foreignId('initiated_by_user_id')->constrained('users');
    $table->string('scan_type');                   // external_discovery | external_vuln | full
    $table->json('config');
    $table->string('status');                      // queued | running | completed | failed | cancelled
    $table->timestamp('queued_at');
    $table->timestamp('started_at')->nullable();
    $table->timestamp('completed_at')->nullable();
    $table->integer('progress_percent')->default(0);
    $table->json('summary')->nullable();
    $table->text('error_message')->nullable();
    $table->timestamps();

    $table->index('status');
    $table->index(['status', 'queued_at']);
});

// create_scan_targets_table.php
Schema::create('scan_targets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('scan_id')->constrained()->cascadeOnDelete();
    $table->foreignId('asset_id')->constrained();
    $table->string('status');
    $table->json('result_summary')->nullable();
    $table->timestamps();
});

// create_scan_findings_table.php — per-scan snapshot of every finding seen
// during that scan. Append-only; never updated. The deduped current-state
// row lives in `findings`. PDF reports read from this table.
Schema::create('scan_findings', function (Blueprint $table) {
    $table->id();
    $table->foreignId('scan_id')->constrained()->cascadeOnDelete();
    $table->foreignId('finding_id')->constrained(); // the deduped record
    $table->foreignId('asset_id')->constrained();
    $table->string('severity');                    // snapshot — finding row may
    $table->decimal('cvss_score', 3, 1)->nullable(); // be re-rated later
    $table->json('raw_evidence')->nullable();      // payload received from Go
    $table->foreignId('finding_evidence_id')->nullable()->constrained();
    $table->timestamp('detected_at');
    $table->timestamps();

    $table->index(['scan_id', 'severity']);
    $table->index(['asset_id', 'detected_at']);
    $table->unique(['scan_id', 'finding_id']);     // one snapshot per scan
});

// create_findings_table.php
Schema::create('findings', function (Blueprint $table) {
    $table->id();
    $table->uuid('finding_uuid')->unique();
    $table->foreignId('scan_id')->constrained();
    $table->foreignId('asset_id')->constrained();
    $table->string('source');                      // nuclei | nmap | sslyze | header_check
    // NB: MySQL allows multiple NULLs in a unique index, so the dedup
    // columns below must be NOT NULL with sentinel defaults — otherwise
    // findings with NULL port (TLS, header, etc.) duplicate on rescan.
    $table->string('source_check_id')->default('');
    $table->string('cve_id')->nullable()->index(); // string FK to central.cves
    $table->string('title');
    $table->text('description');
    $table->text('plain_language_summary')->nullable();
    $table->string('severity');
    $table->decimal('cvss_score', 3, 1)->nullable();
    $table->unsignedSmallInteger('port')->default(0);
    $table->string('protocol')->nullable();
    $table->string('service')->nullable();
    $table->string('version_detected')->nullable();
    $table->json('compliance_impact')->nullable(); // [{framework: 'ftc_safeguards', control_id: '314.4(c)(2)'}]
    $table->string('status')->default('open');     // open | triaged | false_positive | accepted_risk | remediated
    $table->foreignId('assigned_to_user_id')->nullable()->constrained('users');
    $table->timestamp('first_detected_at');
    $table->timestamp('last_detected_at');
    $table->timestamp('remediated_at')->nullable();
    $table->timestamps();

    $table->index(['asset_id', 'status']);
    $table->index(['severity', 'status']);
    $table->unique(['asset_id', 'source', 'source_check_id', 'port'], 'unique_finding_per_asset');
});

// create_finding_evidence_table.php
Schema::create('finding_evidence', function (Blueprint $table) {
    $table->id();
    $table->foreignId('finding_id')->constrained()->cascadeOnDelete();
    $table->string('kind');                        // request | response | raw_output
    $table->string('storage_disk');                // 'spaces'
    $table->string('storage_path');
    $table->integer('size_bytes');
    $table->timestamps();
});
```

**Schema notes:**

- **Two-table model: `findings` (current state) + `scan_findings` (per-scan
  snapshots).** Every scan run inserts one `scan_findings` row per finding
  it observed. The `findings` row itself is deduped on
  `(asset_id, source, source_check_id, port)` so the dashboard's "open issues"
  view stays clean. PDF reports query `scan_findings` joined to `findings` so
  every report reflects exactly what *that scan run* saw.
- `source_check_id` and `port` on `findings` are NOT NULL with sentinel
  defaults (`''` and `0`) because MySQL allows multiple NULLs in a unique
  index — otherwise findings without a port (TLS, headers) would duplicate
  on every rescan.
- `findings.compliance_impact` is JSON, denormalized at finding-creation time
  from the central rules. This lets us render compliance impact without
  crossing DBs on every page load. **Plan a backfill command** for when
  `finding_compliance_rules` is edited — denormalized rows do not
  self-update.
- `scan_findings.severity` and `scan_findings.cvss_score` are *snapshots* of
  what was true at scan time. The `findings` row's severity may be re-rated
  later (e.g., CVSS revisions in NVD); the historical PDF must still show
  what the scan reported on the day. Don't fall back to `findings.severity`
  in the report query.
- Keep raw scanner output in Spaces (DO's S3-equivalent), not in MySQL.
  Reference via `finding_evidence` (deduped, lookup by hash) and link
  per-scan via `scan_findings.finding_evidence_id` if the payload matters
  for the report.
- Every model in this feature gets `$fillable` (or `$guarded`), a `casts()`
  method for JSON/date/boolean columns, and a Policy. `Asset`, `Scan`,
  `ScanAuthorization`, `Finding`, and `ScanFinding` are mass-assignment
  magnets — guard them.

---

## Implementation Approach

### Phase 1 server setup

Provision a new droplet (`scanner-1`) separate from app servers:

```bash
# install scanner tools (Ubuntu 24)
apt update && apt install -y nmap sslyze
# Go-based tools
go install -v github.com/projectdiscovery/nuclei/v3/cmd/nuclei@latest
go install -v github.com/projectdiscovery/httpx/cmd/httpx@latest
go install -v github.com/projectdiscovery/subfinder/v2/cmd/subfinder@latest
nuclei -update-templates
```

Deploy the Go worker binary + systemd unit:

```bash
# /etc/systemd/system/dealership-scanner.service
[Unit]
Description=Dealership Vulnerability Scanner Worker
After=network.target

[Service]
Type=simple
ExecStart=/usr/local/bin/dealership-scanner
EnvironmentFile=/etc/dealership-scanner/env
Restart=on-failure
RestartSec=5s
User=scanner
Group=scanner

[Install]
WantedBy=multi-user.target
```

No `php artisan queue:work` runs on `scanner-1`. The droplet runs only the
Go worker + the nuclei templates updater timer. Laravel's queue workers stay
on the app server.

### Repo layout for the Go worker

Lives **outside** this Laravel repo, in its own repository — different
language, different deploy cadence, different test stack. Recommended:

```
dealership-scanner/           # separate git repo
├── cmd/scanner/main.go       # entrypoint, reads config, starts worker pool
├── internal/
│   ├── redis/                # XREADGROUP consumer + result publisher
│   ├── orchestrator/         # per-scan pipeline driver
│   ├── executors/            # nuclei, httpx, nmap, sslyze wrappers
│   ├── scope/                # CIDR + domain match (defence in depth)
│   └── findings/             # finding normaliser before publish
├── go.mod
└── Makefile
```

The Laravel repo gets a small `docs/scanner-protocol.md` describing the JSON
message shapes so the two repos stay in sync. The doc MUST also reproduce the
"Scope containment contract" section verbatim — both sides have to implement
the same rules byte-for-byte, and the protocol doc is the single source of
truth that gets read in both repos. Version both sides on the protocol
(`protocol_version` field in every message); drop messages with an unknown
version and log loudly.

### Queue structure (Laravel side)

```
Redis streams (Laravel ⟷ Go):
- scanning:dispatch   → scan jobs dispatched by Laravel, consumed by Go
- scanning:results    → findings + status produced by Go, consumed by Laravel
- scanning:heartbeat  → Go worker liveness

Redis queues (internal Laravel):
- default             → existing app jobs
- scanning-ingest     → IngestFindingJob batches dispatched from the results
                        consumer (separated so a slow ingest can't block other
                        Laravel jobs)
```

The flow:

1. User triggers scan → controller calls `TriggerScan` Action.
2. Action creates the `Scan` row (status `queued`) and dispatches
   `DispatchScanToWorker` — a tiny job that `ShouldDispatchAfterCommit` and
   does a single `XADD scanning:dispatch *` with the JSON payload above.
3. Go worker on `scanner-1` `XREADGROUP`s the message, verifies scope,
   executes the pipeline, streams findings + status into `scanning:results`,
   `XACK`s the dispatch on completion.
4. A long-running Laravel command (`php artisan scanning:consume-results`)
   on the app server `XREADGROUP`s `scanning:results`, initialises tenancy,
   and dispatches `IngestFindingJob` (one per finding message) or
   `UpdateScanStatusJob` (per status message) to the `scanning-ingest` queue.
5. `IngestFindingJob` does CVE lookup, compliance mapping, dedup, persist
   — same as before.

The Laravel results consumer is a Horizon-managed long-running command (not a
Job class). It owns one Redis consumer per Laravel process and uses Horizon
supervisor configuration to keep N consumers alive. Crashes are restarted by
Horizon; `XAUTOCLAIM` (run periodically by the consumer) sweeps up messages
left orphaned by another consumer's crash.

### `DispatchScanToWorker` skeleton

Laravel doesn't run the scan; it publishes a message and trusts the Go worker
to pick it up. The job is a thin dispatch shim with the legal gate and the
Redis write.

```php
namespace App\Jobs\Scanning;

use App\Domain\Tenant\Scanning\Exceptions\AuthorizationExpiredException;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldDispatchAfterCommit;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class DispatchScanToWorker implements ShouldQueue, ShouldBeUnique, ShouldDispatchAfterCommit
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 30;     // dispatch should be fast; if it's not, fail loud
    public int $tries = 3;        // safe to retry: idempotent on scan_uuid
    public int $uniqueFor = 600;  // dedup window for the dispatch itself

    public function __construct(public string $tenantId, public int $scanId) {}

    public function uniqueId(): string
    {
        return "dispatch-scan:{$this->tenantId}:{$this->scanId}";
    }

    public function handle(): void
    {
        $tenant = Tenant::findOrFail($this->tenantId);
        tenancy()->initialize($tenant);

        $scan = Scan::with('scanTargets.asset', 'scanAuthorization')
            ->findOrFail($this->scanId);

        // Legal gate — non-negotiable. The Go worker re-checks scope per target,
        // but we never even hand it a scan it shouldn't run.
        if (! $scan->scanAuthorization->isValid()) {
            $scan->update([
                'status' => 'failed',
                'error_message' => 'Authorization invalid/expired',
                'completed_at' => now(),
            ]);

            throw new AuthorizationExpiredException(); // implements ShouldntReport
        }

        $payload = $this->buildPayload($scan, $tenant);

        Redis::connection('scanner')->xAdd(
            'scanning:dispatch',
            '*',
            [
                'protocol_version' => '1',
                'payload' => json_encode($payload, JSON_THROW_ON_ERROR),
            ],
        );

        $scan->update(['status' => 'dispatched']);
    }

    // If the Redis write fails (network blip, eviction, etc.) we still need to
    // surface that as a failed scan row instead of leaving it stuck in 'queued'.
    public function failed(\Throwable $exception): void
    {
        tenancy()->initialize(Tenant::findOrFail($this->tenantId));

        Scan::query()
            ->whereKey($this->scanId)
            ->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
                'completed_at' => now(),
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function buildPayload(Scan $scan, Tenant $tenant): array
    {
        $auth = $scan->scanAuthorization;

        return [
            'scan_id' => $scan->id,
            'scan_uuid' => $scan->scan_uuid,
            'tenant_id' => $tenant->id,
            'scan_type' => $scan->scan_type,
            'authorization_id' => $auth->id,
            'authorization_scope' => $auth->scope,
            'targets' => $scan->scanTargets->map(fn ($t) => [
                'asset_id' => $t->asset->id,
                'type' => $t->asset->type,
                'value' => $t->asset->value,
            ])->all(),
            'config' => $scan->config,
            'dispatched_at' => now()->toIso8601String(),
        ];
    }
}
```

### Results consumer (`scanning:consume-results`)

Long-running artisan command on the app server, managed by Horizon's
`supervisor` block (one process per Horizon worker). Pseudocode:

```php
namespace App\Console\Commands\Scanning;

class ConsumeScanResults extends Command
{
    protected $signature = 'scanning:consume-results {--consumer=default}';

    public function handle(): int
    {
        $consumer = $this->option('consumer');
        $redis = Redis::connection('scanner');

        // Bootstrap: create the consumer group once (idempotent).
        $redis->command('XGROUP', ['CREATE', 'scanning:results', 'laravel', '$', 'MKSTREAM']);

        while (! $this->shouldStop()) {
            $entries = $redis->command('XREADGROUP', [
                'GROUP', 'laravel', $consumer,
                'BLOCK', 5000,
                'COUNT', 50,
                'STREAMS', 'scanning:results', '>',
            ]);

            foreach ($entries ?? [] as [$id, $fields]) {
                try {
                    $this->dispatchToIngest($fields);
                    $redis->command('XACK', ['scanning:results', 'laravel', $id]);
                } catch (\Throwable $e) {
                    // Do not XACK — XAUTOCLAIM will retry from another consumer.
                    report($e);
                }
            }
        }

        return self::SUCCESS;
    }

    private function dispatchToIngest(array $fields): void
    {
        $message = json_decode($fields['payload'], true, flags: JSON_THROW_ON_ERROR);

        match ($message['kind']) {
            'status' => UpdateScanStatusJob::dispatch($message)->onQueue('scanning-ingest'),
            'finding' => IngestFindingJob::dispatch($message)->onQueue('scanning-ingest'),
            'violation' => RecordScopeViolationJob::dispatch($message)->onQueue('scanning-ingest'),
            default => report(new \RuntimeException('Unknown result kind: '.$message['kind'])),
        };
    }
}
```

Horizon `supervisors` config gets a new entry:

```php
'scanner-results' => [
    'command' => 'php artisan scanning:consume-results',
    'processes' => 2,
    'tries' => 1,           // crash-and-restart is fine; messages aren't ACKed until handled
    'balance' => 'simple',
],
```

A scheduled task runs `XAUTOCLAIM` every minute to recover messages from
crashed consumers:

```php
Schedule::call(fn () => Redis::connection('scanner')->command(
    'XAUTOCLAIM',
    ['scanning:results', 'laravel', 'reaper', 60_000, '0-0', 'COUNT', 100],
))
    ->everyMinute()
    ->withoutOverlapping()
    ->onOneServer();
```

### `IngestFindingJob` + `UpdateScanStatusJob`

Both implement `ShouldQueue` + `ShouldDispatchAfterCommit`. `IngestFindingJob`
does **two writes** per result message, inside one DB transaction:

1. **Upsert into `findings`** — `updateOrCreate` keyed on
   `(asset_id, source, source_check_id, port)`. On hit, bump
   `last_detected_at` and `status = open` (revives a remediated finding if it
   reappears). On insert, set `first_detected_at`, resolve `compliance_impact`
   from `finding_compliance_rules`, and do the CVE lookup against
   `central.cves` (cached via `Cache::flexible()` with `cve` tag).
2. **Insert into `scan_findings`** — append-only snapshot of what this scan
   saw, including `severity` + `cvss_score` at scan time, and a reference to
   `finding_evidence` if raw output is present in the message.

`scan_findings` has `unique(scan_id, finding_id)` so the same message
arriving twice (e.g., consumer retry after a crash before `XACK`) is a no-op,
not a duplicate row. `findOrCreate` style insert.

Implements `failed()` to mark the **scan** with a partial-ingest error — the
finding row itself stays, but the scan's `status` is set to `failed` with a
note. The PDF report should not be generatable for a partial scan.

`UpdateScanStatusJob` flips the scan row to `running` / `completed` / `failed`
and stamps `started_at` / `completed_at`. When transitioning to `completed`:

- Materialises `scans.summary` (aggregate counts pulled from
  `scan_findings`): `findings_total`, `by_severity`, `by_source`,
  `highest_severity`, `targets_completed`.
- Dispatches `NotifyCriticalFindings` (queued notification) if any
  critical-severity findings were recorded.

Persisting the summary on the scan row means the listing page and the PDF
header can render without re-aggregating from `scan_findings`.

### Other job hygiene

- All scan-related notifications implement `ShouldQueue`. `HasLocalePreference`
  on the recipient honours their language.
- Outbound HTTP calls inside scan tooling (e.g. CVE enrichment) live on the Go
  side now — rate-limited there, not via Laravel `RateLimited` middleware.
- Bulk per-scan summary work uses `Bus::batch()` so the "scan completed"
  notification only fires once every ingestion job for that scan has cleared.

### Orchestration responsibilities (Go side)

The Go worker's orchestrator lives in the **separate `dealership-scanner`
repo** — not in this Laravel codebase. Responsibilities:

- For each scan target, verify it's in scope against the embedded
  `authorization_scope` (CIDR membership for IPs, suffix match for domains).
  Defence in depth — Laravel already gated, but Go re-checks.
- Run the pipeline: discovery (subfinder) → port scan (nmap) → service
  detection (httpx) → vuln templates (nuclei) → TLS audit (sslyze) → header
  checks.
- Stream each tool's output line-by-line (`nuclei -jsonl`, `httpx -json`,
  `nmap -oX -` parsed incrementally). Bounded memory; goroutine per target.
- For each parsed normalised finding, `XADD scanning:results` with a JSON
  `kind: "finding"` message. Status transitions are published the same way.
- On a `protocol_version` mismatch (Laravel publishes v2 in the future), log
  loudly and refuse to consume the message — let `XAUTOCLAIM` reassign it
  after a fresh deploy.

Outline of the Go internal structure (in the scanner repo, not here):

```
internal/orchestrator/
    pipeline.go       # ordered stage execution per target
    target.go         # per-target state machine
    publisher.go      # XADD-driven Redis publisher with batched flushes
internal/executors/
    nuclei.go
    httpx.go
    nmap.go
    sslyze.go
internal/scope/
    cidr.go           # net/netip CIDR containment
    domain.go         # suffix match with public-suffix-list awareness
```

### Laravel-side Action classes

**Write paths use single-purpose Action classes**, mirroring the existing
`app/Domain/Tenant/Audits/...` convention in this codebase. Controllers stay
thin and delegate. FormRequests expose `toData()`; Actions consume the array.

```
app/Domain/Tenant/Scanning/
├── Actions/
│   ├── CreateAsset.php
│   ├── SignScopeAuthorization.php   # captures IP, hash, expires_at
│   ├── RevokeScopeAuthorization.php
│   ├── TriggerScan.php              # creates Scan row, dispatches RunScanJob
│   ├── IngestFinding.php            # CVE lookup + compliance map + dedup
│   ├── UpdateFindingStatus.php      # triage: false_positive / accepted_risk / remediated
│   └── BackfillComplianceImpact.php # called when finding_compliance_rules change
├── Data/
│   ├── AssetData.php
│   ├── ScanAuthorizationData.php
│   ├── FindingDetail.php
│   └── ScanSummary.php
└── Queries/
    ├── ListAssets.php
    ├── ListFindings.php
    ├── LoadFindingDetail.php
    └── BuildRiskDashboard.php
```

**Form Requests** under `app/Http/Requests/Tenant/Scanning/`:
- `StoreAssetRequest`
- `UpdateAssetRequest`
- `SignScopeAuthorizationRequest`
- `TriggerScanRequest`
- `UpdateFindingStatusRequest`

Each exposes a `toData()` method that returns a strictly typed array. Use
`$request->validated()` — never `$request->all()`.

**Policies** for every model: `AssetPolicy`, `ScanPolicy`,
`ScanAuthorizationPolicy`, `FindingPolicy`. Controllers call
`$this->authorize('create', Scan::class)` / `$this->authorize('update', $finding)`
rather than scattering role checks. The five-role hierarchy is enforced at the
Policy layer, not in route middleware or controllers.

Cross-DB lookups (`Finding.cve_id` → `central.cves`) and tenant-context jobs
are exactly where N+1 sneaks in. Enable `Model::preventLazyLoading()` in
`AppServiceProvider::boot()` for non-production environments so violations
surface in test runs.

### NVD feed ingestion

Separate scheduled job, runs nightly:
```
app/Console/Commands/IngestNvdFeed.php
```
Pull NVD 2.0 API delta feed (last 24h), upsert into `central.cves` and `central.cpes`. CISA KEV is a separate small daily pull.

**HTTP client requirements** — NVD has aggressive rate limits and uneven latency, so the call must be defensive:

```php
Http::timeout(30)
    ->connectTimeout(10)
    ->retry([1, 5, 10], throw: false)
    ->withHeaders(['apiKey' => config('services.nvd.api_key')])
    ->throw()
    ->get($url);
```

In tests: `Http::preventStrayRequests()` plus `Http::fake()` with canned NVD payloads. **Do not** hit the real API from CI.

**Scheduler entry:**

```php
Schedule::command('nvd:ingest')
    ->dailyAt('02:00')
    ->withoutOverlapping()        // ingestion can run long; don't pile up
    ->onOneServer()               // multi-droplet deploy
    ->environments(['production']) // never in dev/CI
    ->runInBackground();
```

**Caching strategy** — `Cache::flexible()` for hot CVE lookups so a stale value serves while a refresh happens in the background, with cache **tags** so the nightly ingest can invalidate only what changed:

```php
Cache::tags(['cve'])->flexible("cve:{$id}", [86400, 172800], fn () => $this->load($id));
// On ingest: Cache::tags(['cve'])->flush();
```

---

## Scan history + on-demand PDF

The two-table model (`findings` + `scan_findings`) is the foundation. The
flow:

1. **Every scan persists its full result set.** When a scan completes, every
   finding observed during that run lives in `scan_findings` with the
   severity / CVSS score / raw evidence it had **at scan time**. This is the
   permanent record. Nothing downstream is allowed to mutate `scan_findings`.
2. **PDF reports are generated lazily**, on demand, from those stored rows.
   Generation is a separate user action (or scheduled email) — never part of
   the scan-completion pipeline. A scan that finishes at 3am does not trigger
   a PDF render at 3am; the user requests one when they want it.
3. **The compliance dashboard always reflects current state** via the
   `findings` table. The PDF for "May 11, 2026 scan" reflects what that scan
   saw, even if some findings were later re-rated, remediated, or marked as
   false-positive.

### `GenerateScanReportPdf` action

Mirrors `StreamAuditPdf` for the existing audit reports — uses
`spatie/laravel-pdf` with the Browsershot driver.

```
app/Domain/Tenant/Scanning/Actions/
└── GenerateScanReportPdf.php
```

```php
namespace App\Domain\Tenant\Scanning\Actions;

use App\Models\Tenant\Scan;
use Spatie\LaravelPdf\PdfBuilder;
use function Spatie\LaravelPdf\Support\pdf;

class GenerateScanReportPdf
{
    public function handle(Scan $scan): PdfBuilder
    {
        abort_unless($scan->status === 'completed', 422, 'Scan is not complete.');

        $scan->loadMissing([
            'scanAuthorization',
            'initiatedBy',
            'scanFindings.finding',
            'scanFindings.asset',
            'scanFindings.findingEvidence',
        ]);

        return pdf()
            ->driver('browsershot')
            ->view('tenant.scanning.pdf.scan-report', [
                'scan' => $scan,
                'findingsByControl' => $this->groupByFtcControl($scan),
                'highestSeverity' => $scan->summary['highest_severity'] ?? null,
            ])
            ->name($this->buildFilename($scan))
            ->footerView('pdf.scan-report-footer');
    }

    private function groupByFtcControl(Scan $scan): array
    {
        // Re-group scan_findings by their compliance_impact entries so the
        // PDF organises findings under each cited Safeguards Rule control.
        return $scan->scanFindings
            ->flatMap(fn ($sf) => collect($sf->finding->compliance_impact ?? [])
                ->map(fn ($impact) => ['control_id' => $impact['control_id'], 'scan_finding' => $sf]))
            ->groupBy('control_id')
            ->all();
    }

    private function buildFilename(Scan $scan): string
    {
        $store = tenant('name') ?? 'dealership';

        return mb_strtolower(str_replace(' ', '-', $store))
            .'-vuln-scan-'.$scan->completed_at->format('Ymd')
            .'-'.$scan->scan_uuid.'.pdf';
    }
}
```

### Routes for PDF download

```
GET /scans/{scan}/report      → ScanController@downloadReport
                                returns PdfBuilder (streams inline)
```

A `Scan` PDF is generated fresh every time it's requested. If repeated
downloads become hot, cache the rendered file in Spaces keyed on the scan
UUID — but only when there's actual evidence of load. Until then, render
on demand and keep the path simple.

### Scheduled email reports (later sprint)

`ScheduledScanReportEmail` notification implements `ShouldQueue`, renders the
PDF via `GenerateScanReportPdf->handle()`, and attaches it. Drives off the
`Scan.completed_at` watermark per asset group — the user picks a cadence
(monthly / quarterly) per asset group on the asset CRUD page.

---

## FTC Safeguards Mapping (the differentiator)

### Overview

A translation layer that turns each raw scanner finding into "this affects
your compliance with FTC Safeguards Rule § 314.4(c)(x)" — in plain English a
dealership owner can act on. It's the killer differentiator over generic vuln
scanners: dealerships don't care about CVSS scores, they care about whether
their FTC compliance is at risk.

**The loop:**

```
scanner finds an issue
        ↓
   evaluator matches it against curated rules
        ↓
finding row gets cited control(s) + plain-language summary
        ↓
shows up in dashboard, PDF report, and owner risk panel
```

**Four moving parts:**

1. **Control catalog** — the eight § 314.4(c) subsections (access controls,
   encryption, MFA, secure disposal, etc.), each with the regulation text
   plus a one-sentence plain-English version.
2. **Rule set** — "if finding looks like X, cite control Y." A few dozen
   rules covering the common scanner outputs (TLS issues, exposed admin
   ports, missing security headers, CISA KEV CVEs, etc.).
3. **Evaluator** — small service that runs at scan-ingest time, walks the
   rules, attaches the matching controls to the finding.
4. **Surfaces** — dashboard, owner panel, PDF report — all read the same
   denormalized mapping off the finding row.

**Key design decisions:**

- **Denormalize at ingest, not at render.** When a finding lands, we resolve
  and store the compliance impact immediately. Pages don't recompute on
  every load.
- **Versioned + backfillable.** Rules will get edited; old findings get
  re-evaluated by an explicit backfill command, not magic.
- **Historical snapshots are frozen.** A PDF for the May 2026 scan reflects
  what § 314.4(c)(3) said *that day*, even if the rule wording shifts later.
  Snapshot lives on `scan_findings.compliance_impact`, not the deduped
  `findings` row.
- **Per-tenant overrides.** A dealership can mark a finding "not applicable
  to us" without distorting the global rule set
  (`finding_compliance_overrides` table).
- **Content is the actual product.** The engine is straightforward. The rule
  authoring and plain-language wording is the work, owned by a
  compliance-aware reviewer, not engineering alone.

**Why it matters:**

1. **Plain language first.** Owners see "your website allows outdated
   encryption the FTC considers inadequate" — not "TLS 1.0 enabled, CVSS
   7.4."
2. **Direct compliance tie-in.** Every finding cites a specific subsection
   of the rule a dealership is already required to comply with.
3. **PDF report drops into the existing compliance file.** Auditor-ready, no
   translation needed.

Everything else in this plan (scanner pipeline, Go worker, queue plumbing) is
plumbing. **This layer is the reason the feature ships.**

### Implementation detail

Seed `ftc_safeguards_controls` with the actual rule sections. The relevant ones for tech findings:

- **314.4(c)(1)** — access controls
- **314.4(c)(2)** — inventory of data, personnel, devices, systems, facilities
- **314.4(c)(3)** — encryption of customer info at rest and in transit
- **314.4(c)(4)** — secure development
- **314.4(c)(5)** — multi-factor authentication
- **314.4(c)(6)** — secure disposal
- **314.4(c)(7)** — change management
- **314.4(c)(8)** — monitor and log authorized user activity

Seed `finding_compliance_rules` with mappings like:

```json
{
  "ftc_safeguards_control_id": "314.4(c)(3)",
  "match_rules": {
    "source": "nuclei",
    "tags_any": ["ssl", "tls", "weak-cipher"]
  }
}
```

```json
{
  "ftc_safeguards_control_id": "314.4(c)(3)",
  "match_rules": {
    "source": "sslyze",
    "issue_type": "weak_cipher"
  }
}
```

Confirm the exact rule wording with the dealership compliance content already in the platform — there may be existing language to align with.

---

## UX Principles

- **Findings live in the existing compliance dashboard**, not a new "Security" tab. Add a "Technical Findings" panel or section next to the existing audit/compliance widgets.
- **Stack**: Inertia + Vue + Flux UI pages from day one. The platform is in the middle of migrating Livewire → Inertia (see `CLAUDE.md` / `shift-172092` branch) — do not introduce new Livewire components. Pages live under `resources/js/pages/tenant/scanning/`.
- **Plain-language summaries always come first.** Technical detail (CVSS, CVE, port) is collapsible/secondary.
  - Bad: "TLS 1.0 enabled, CVSS 7.4, CVE-2014-3566"
  - Good: "Your website allows outdated encryption that the FTC considers inadequate. This affects your compliance with Safeguards Rule § 314.4(c)(3)."
- **Owner-facing risk dashboard.** Surface critical/high findings counts in the existing owner dashboard so they can't miss them.
- **On-demand PDF report.** Every scan's full result set is stored permanently
  in `scan_findings` at ingestion time. PDF generation is a separate user
  action (or scheduled email) that streams a report off those stored rows via
  `GenerateScanReportPdf` — never part of the scan-completion pipeline. The
  report groups findings by FTC control. Built on `spatie/laravel-pdf`, the
  same engine `StreamAuditPdf` uses for OSHA/BodyShop/GLBA reports. See the
  "Scan history + on-demand PDF" section above for the model.
- **Notifications.** Email on new critical finding. Notification class implements `ShouldQueue`. If user has `HasLocalePreference`, respect it. Use `assertQueued()` not `assertSent()` in tests.

---

## Build Sequence

### Sprint 1 — Foundation
- Central DB migrations: `cves`, `cpes`, `ftc_safeguards_controls`, `finding_compliance_rules`
- Tenant DB migrations: all scanning tables
- Models + relationships + `$fillable` + `casts()` + Policies for every entity
- Seed `ftc_safeguards_controls` and initial `finding_compliance_rules`
- NVD feed ingestion command with the HTTP-client + Cache requirements above
- `Schedule::command('nvd:ingest')` with `withoutOverlapping`/`onOneServer`/`environments(['production'])`/`runInBackground`
- `BackfillComplianceImpact` Action stubbed (called when rules change)
- `Model::preventLazyLoading()` in non-production
- Tests: migrations work, models load + cast correctly, feed ingestion idempotent and `Http::preventStrayRequests()` clean, Policies deny non-privileged roles, multi-tenant isolation holds

### Sprint 2 — Asset + Authorization UX
- Asset CRUD UI (add domain/IP/URL, group by store)
- Scope authorization workflow: legal acceptance flow, signature capture, expiration tracking, re-sign prompt
- Asset list view inside compliance dashboard
- Tests: scope contains/does-not-contain logic, authorization expiry handling

### Sprint 3a — Go worker (separate `dealership-scanner` repo)
- New Go repo, `go.mod`, CI (golangci-lint, `go test`), release Makefile producing a static binary.
- Redis consumer using `XREADGROUP` + `XACK` + `XAUTOCLAIM` recovery.
- `internal/scope/` CIDR + domain match — covered by table-driven tests.
- `internal/executors/` for nuclei and httpx (defer nmap + sslyze to 3c).
- `internal/orchestrator/` pipeline + per-target goroutine pool with rate-limiting.
- Publishes `kind: "status"` + `kind: "finding"` + `kind: "violation"` to `scanning:results`.
- Sentry Go SDK integration (separate Sentry project; same org).
- Systemd unit + `EnvironmentFile` for Redis credentials, nuclei templates path.
- Smoke test against a domain we own, run by hand on the droplet.

### Sprint 3b — Laravel side of the protocol
- Provision `scanner-1` droplet via Ploi (no `php artisan queue:work` on it).
- `DispatchScanToWorker` job with `ShouldDispatchAfterCommit`, `ShouldBeUnique`, `failed()`.
- `scanning:consume-results` artisan command + Horizon supervisor config.
- `IngestFindingJob` + `UpdateScanStatusJob` + `RecordScopeViolationJob`.
- `XAUTOCLAIM` reaper scheduled task.
- CVE lookup with `Cache::flexible()` + cache tags + dedup on the unique constraint.
- Compliance mapping (denormalises `compliance_impact` on finding insert).
- `docs/scanner-protocol.md` describing message shapes — synced manually with the Go repo.
- Tests:
  - `Queue::fake()` covers `DispatchScanToWorker` writes the right Redis payload.
  - `Redis::fake()` (or a real Redis in feature tests) covers the consumer command.
  - Scope-violation messages create the right audit log row and never persist a finding.
  - Dedup updates `last_detected_at` on rescan.

### Sprint 3c — Remaining executors + hardening
- nmap, sslyze, basic HTTP header check on the Go side.
- Rate-limiting per target (nuclei `-rate-limit 50` default; configurable per asset).
- Worker pool sizing knobs in the systemd `EnvironmentFile`.
- Graceful shutdown: on `SIGTERM`, finish in-flight scans up to `shutdown_timeout`, then republish unfinished targets so another worker can pick them up.
- Heartbeat key (`scanning:heartbeat`) updated every 10s; Laravel scheduled task alerts if no heartbeat for >2 minutes.
- Tests on both sides: feature tests in Laravel that round-trip a fake scanner publishing canned `scanning:results` messages; Go tests for executor parsing.

### Sprint 4 — Scan Scheduling + Result UX
- On-demand scan trigger from UI
- Weekly scheduled scans per asset
- Findings view in compliance dashboard with plain-language summaries
- Finding triage workflow (false-positive, accepted-risk, remediated states)
- Add nmap, sslyze, basic HTTP header checks
- Tests: scheduled scans dispatch correctly, status transitions valid

### Sprint 5 — Reporting + Notifications
- `GenerateScanReportPdf` action reading off `scan_findings` (per-scan
  snapshot, not the deduped `findings` table).
- Blade template `tenant.scanning.pdf.scan-report` with findings grouped by
  FTC control, scoped to one scan at a time.
- `ScanController@downloadReport` route + Vue page link from the scan
  history list — one-click PDF download.
- Email notification on new critical finding (`ShouldQueue`,
  `HasLocalePreference`).
- Scheduled-email pipeline scaffolded behind a feature flag (default off).
  Cadence chosen per asset group on the asset CRUD page.
- Owner dashboard widget showing critical/high counts from `scans.summary`.
- Tests: report renders for a completed scan, refuses for an
  in-progress / failed scan, scheduled-email assertion via `Notification::fake()`.

### Post-launch (deferred)
- Internal scanning agent (Phase 2)
- Authenticated/credentialed scans
- Additional compliance frameworks if customer-requested
- Migration to dedicated Go worker if Laravel-shellout starts to struggle

---

## Operational Notes

- **Egress IP.** Scanner-1's public IP is what targets see. Tenants may need to allowlist it in their own firewalls. Document this and surface it in the UI: "Your scans originate from `X.X.X.X` — add this to any allowlists."
- **Politeness.** Rate-limit per target on the Go side. Don't hammer a dealership's small marketing site with 200 concurrent nuclei requests. `nuclei -rate-limit 50` is a safe default; expose as a per-asset setting later if needed.
- **Audit log.** Every scan run logs: who, when, what target, which authorization. Use `spatie/laravel-activitylog` (already installed) — `LogsActivity` trait on `Scan` + `ScanAuthorization`. Scope-violation messages from the Go worker route through `RecordScopeViolationJob` and create an activity-log entry tagged `scanner.scope_violation`.
- **Backups.** Findings should be in the regular tenant DB backup. CVE catalog in central can be rebuilt from NVD if lost — don't waste backup budget on it.
- **Go worker liveness.** Scheduled Laravel task checks `scanning:heartbeat` every minute; if no update for >2 minutes, alert ops (Slack / email). Same channel that surfaces other infra alerts.
- **Cross-repo coordination.** Protocol changes require a synchronised release (Laravel + Go worker). Pin both sides on `protocol_version` and refuse unknown versions loudly. Document the change in `docs/scanner-protocol.md` (Laravel repo) and the Go repo's CHANGELOG.

---

## Decisions to Confirm Before Starting

These are the open questions that need a human call before Sprint 1:

1. **Scanner droplet sizing.** Start with 2vCPU/4GB or 4vCPU/8GB? Depends on expected concurrent scan load. (Recommendation: start at 4vCPU/8GB — Go workers will run more concurrent scans than Laravel-shellout would have, so we want headroom from day one.)
2. **Go worker repo location.** Same GitHub org, new repo (`dealership-scanner`)? Or monorepo with this Laravel app? (Recommendation: separate repo. Different language, different deploy cadence, separate CI.)
3. **Redis connection.** Reuse the existing Redis or stand up a dedicated `scanner` Redis with its own auth? (Recommendation: reuse with a separate ACL user scoped to `scanning:*` streams. Less infra, sufficient isolation.)
4. **Authorization expiration period.** 1 year default, configurable per dealership? (Recommendation: 1 year, non-configurable initially.)
5. **Who can sign authorizations?** Owners only, or managers too? (Likely owners only — confirm with product.)
6. **Protocol versioning policy.** Hard-fail on unknown `protocol_version`, or warn and process best-effort? (Recommendation: hard-fail. Loud failures beat silent drift between repos.)

---

## Conventions

Follow existing Laravel patterns in the codebase. If you're unsure how queued
jobs handle tenancy, find an existing job (`GenerateOshaPdfJob`,
`ViolationAuditController`) and mirror it.

### Hard rules (laravel-best-practices)

- **Models.** Every model defines `$fillable` (or `$guarded`) and a `casts()`
  method for JSON / date / boolean columns. JSON columns use `array` cast.
- **Policies.** Every entity (`Asset`, `Scan`, `ScanAuthorization`, `Finding`)
  has a Policy. Controllers call `$this->authorize(...)` — no inline role
  checks in controllers.
- **Form Requests.** Validation happens in FormRequest classes with
  `validated()` + `toData()`. Never use `$request->all()`.
- **Single-purpose Action classes** under `app/Domain/Tenant/Scanning/Actions/`.
  Controllers stay under 10 lines per method and delegate to Actions.
- **Queue jobs.** `ShouldDispatchAfterCommit` for any job that depends on
  freshly-inserted rows. `ShouldBeUnique` for scan dispatch. `failed()`
  implemented on every job that mutates state. `retry_after` > `timeout` in
  `config/queue.php` for the `scanning` connection.
- **Notifications.** `ShouldQueue` on every notification. `assertQueued()` in
  tests, not `assertSent()`.
- **HTTP client.** Every external HTTP call uses explicit
  `timeout()` + `connectTimeout()` + `retry()` + `throw()`. Tests use
  `Http::fake()` + `Http::preventStrayRequests()`.
- **Scheduled tasks.** NVD ingestion uses `withoutOverlapping()`,
  `onOneServer()`, `environments(['production'])`, `runInBackground()`.
- **Caching.** Hot CVE lookups use `Cache::flexible()` with cache tags so the
  nightly ingest can `Cache::tags(['cve'])->flush()`.
- **Lazy-loading guard.** `Model::preventLazyLoading()` in
  `AppServiceProvider::boot()` for non-production. Cross-DB lookups are exactly
  where N+1 sneaks in.
- **Exceptions.** Legitimate-rejection paths (expired authorization) throw an
  exception that implements `ShouldntReport` so Sentry doesn't get noisy.

### Reuse, don't rebuild

These are already in the stack — wire into them rather than introducing a
parallel system:

- **Activity log.** `spatie/laravel-activitylog` is installed. Use the
  `LogsActivity` trait on `Scan`, `ScanAuthorization`, `Asset`,
  `Finding` (only on status transitions). Don't roll a custom audit log.
- **PDF generation.** `spatie/laravel-pdf` with the Browsershot driver is
  installed and used by the existing audit-PDF flow. Match that pattern.
- **Authorization gates.** The five-role hierarchy is wired via
  `spatie/laravel-permission`. Use it in Policies (`$user->hasRole(...)` /
  `Gate::before` for super-admin).
- **Tenant context.** Find an existing tenant-aware job (e.g.,
  `Generate*PdfJob`) and copy how it handles `tenancy()->initialize()` and
  failure cleanup — don't hand-roll a new pattern.

### Testing

- `LazilyRefreshDatabase` not `RefreshDatabase` (speed).
- `Http::fake()` + `Http::preventStrayRequests()` for NVD ingestion tests.
- `Queue::fake()` + `assertPushed` for scan dispatch.
- `Bus::fake()` + `assertChained` / `assertBatched` for the find-then-ingest
  flow.
- Multi-tenant isolation is non-negotiable: every test that creates
  assets/findings/scans must verify the data does not appear in a second
  tenant's DB.
- Plain-language summaries on findings are a hard product requirement, not
  nice-to-have. Every finding that surfaces in the UI needs one. Tests should
  assert the field is present.
- Scope verification runs before *any* network activity. There is no fast
  path. Include a test that proves a `ScopeVerifier` rejection prevents the
  executor from being called.

### Dependencies

No new Composer or npm dependencies without flagging them. The stack is
opinionated; additions need justification. In particular:

- Don't add a generic "scanner registry" or "node heartbeat" package — see the
  Out of Scope section.
- Don't add a Go PDF microservice. The Go worker is for **scanning only**; PDF
  generation continues to use `spatie/laravel-pdf` on the Laravel side.
- Don't introduce new Livewire components — the migration is going the other
  direction.
- The Go worker lives in a separate repo (`dealership-scanner`) with its own
  CI and release pipeline. Don't add Go code to this Laravel repo. The only
  Laravel-side artefact of the protocol is `docs/scanner-protocol.md` — keep
  it tightly synced with the Go repo's message structs.
