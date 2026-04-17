# Upgrade Checklist — `shift-172092` → `upgrade`

Target stack: PHP 8.3, Laravel 13, Livewire 4, Filament 4 (forms + notifications), Tailwind 4, Flux / Flux Pro.

## Completed

### Shift (Laravel 10 → 11 baseline)
- [x] Apply code style
- [x] `optional()` → nullsafe operator
- [x] Remove unnecessary `$model` property
- [x] Adopt class-based routes
- [x] Move / slim `resources/lang`
- [x] Remove default `app` files
- [x] Shift core files
- [x] Streamline config files
- [x] Set new ENV variables
- [x] Default new `bootstrap/app.php`
- [x] Re-register HTTP middleware
- [x] Consolidate service providers
- [x] Re-register service providers
- [x] Re-register exception handling
- [x] Re-register routes
- [x] Re-register scheduled commands
- [x] Bump Composer dependencies
- [x] Adopt anonymous migrations
- [x] Convert `$casts` property to `casts()` method
- [x] Adopt Laravel type hints
- [x] Mark base controller `abstract`
- [x] Remove `createApplication`
- [x] Shift cleanup pass

### Laravel 13 + stack bump
- [x] Repair `bootstrap/app.php` middleware block + Spatie Permission aliases
- [x] Laravel 13 upgrade + package bumps
- [x] Filament Forms v5 migration
- [x] `dispatchBrowserEvent()` → Livewire 4 `dispatch()`
- [x] Remove `wire-elements/pro`; replace modals / slide-overs with Flux
- [x] Remove Vapor packages (cli, core, ui)
- [x] Remove Vonage, `spatie/laravel-onboard`, `spatie/laravel-ray`

### Frontend / JS
- [x] Drop manual Alpine plugin registration for `focus`, `mask`, `persist`, `collapse` (bundled in Livewire 4) — fixes `Cannot redefine property: $persist`

## In progress / uncommitted

- [ ] `composer.json` — pending review
- [ ] `resources/views/components/central-sidebar-menu.blade.php` — pending review
- [ ] `resources/js/app.js` — Alpine plugin fix (uncommitted)

## Follow-up (post-merge, per-page PRs)

- [ ] Smoke-test every Livewire page for JS / render errors (`browser-logs`)
- [ ] Replace remaining custom modal/slide-over markup with polished Flux equivalents
- [ ] Audit forms for Filament v5 schema / action API quirks
- [ ] Tailwind 4 pass: verify `@tailwindcss/*` plugins, custom theme config, dark-mode variants
- [ ] Redesign pages using full Flux component library (tables, kanban, date-pickers, etc.)
- [ ] Run full test suite; repair/retire stale tests
- [ ] Confirm Horizon, Nightwatch, Telescope boot cleanly on new stack
