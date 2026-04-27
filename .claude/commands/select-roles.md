---
description: Select explicit role-based access control
---

You are about to build a new function for Joe's multi-tenant dealership compliance platform (Laravel + stancl/tenancy).

The user's request: $ARGUMENTS

**Before writing any code**, you must confirm which roles have access. Render exactly this checklist in your response and stop — wait for the user's reply before proceeding:

---

I'll build: *(restate what you understood in one sentence)*

**Which roles should have access?** Reply with the ones to include:

- [ ] Consultant
- [ ] Owner
- [ ] CFO
- [ ] GM
- [ ] GSM
- [ ] Qualified Individual
- [ ] Manager
- [ ] Employee
- [ ] Porter/Driver

---

Once the user replies with their selections:

1. Confirm the selected roles back to them in one line.
2. Implement the function using the platform's existing authorization pattern — policies, Gates, or middleware as appropriate to the context. Match whatever convention is already in use in the surrounding code.
3. If the function touches tenant data, ensure tenant scoping is respected (stancl/tenancy central vs. tenant context).
4. Note any roles that were *excluded* and confirm they will be denied at the authorization layer, not just hidden in the UI.
5. If tests exist for similar functions, add a matching test that covers both an allowed role and a denied role.

Do not skip the checklist step, even if the user's request seems to imply specific roles. Always confirm explicitly.
