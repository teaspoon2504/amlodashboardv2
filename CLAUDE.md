# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

AMLO Dashboard — an AML/CFT (Anti-Money Laundering / Countering Financing of Terrorism) monitoring system built with Laravel 11 and Blade + Alpine.js. Production-ready for shared hosting (no Node.js runtime required).

## Quick Start

```bash
# Build assets (requires Node.js — do once after cloning)
npm install && npm run build

# Run migrations with seed data
php artisan migrate:fresh --seed

# Start dev server
php artisan serve
```

Demo accounts (all password: `password`):
- `superadmin@amlo.com` → Head Office (HO)
- `lead@amlo.com` → Team Lead
- `amlo@amlo.com` → AMLO Officer

## Build Commands

```bash
npm run build       # Production asset build (writes to public/build/)
npm run dev         # Dev server with hot reload
php artisan serve   # Laravel dev server
php artisan migrate:fresh --seed   # Reset DB + seed
```

## Architecture

### Role Hierarchy
- **HO** (Head Office) — top-level: create/read/update/delete all tasks, set targets per Regional Office
- **Lead** (Team Lead) — per Regional Office: give feedback, set targets per Officer
- **Officer** (AMLO Officer) — per branch: update `amount_done`, add description

### Data Model
```
regional_offices ─── team_leads (1:1)
     │
     └── branch_offices ─── officers
                                │
                    tasks ◄─────┴─── task_categories
```

Tasks link `regional_office`, `team_lead`, `officer`, `branch_office`, `task_category`.

### Route Protection
All routes use `auth` middleware + `role` middleware (defined in `app/Http/Middleware/RoleMiddleware.php`). Roles: `ho`, `lead`, `officer`.

## Key Files

| Purpose | Path |
|---|---|
| Routes | `routes/web.php` |
| Layout | `resources/views/layouts/app.blade.php` |
| Auth layout | `resources/views/layouts/auth.blade.php` |
| Login page | `resources/views/login.blade.php` |
| Dashboards | `resources/views/dashboard/{officer,lead,ho}.blade.php` |
| Task views | `resources/views/tasks/{index,create,edit}.blade.php` |
| Monitoring views | `resources/views/monitoring/{regional-office,officer}.blade.php` |
| Controllers | `app/Http/Controllers/` |
| Models | `app/Models/` |
| Middleware | `app/Http/Middleware/RoleMiddleware.php` |
| Fortify config | `config/fortify.php` |
| DB Seeder | `database/seeders/DatabaseSeeder.php` |

## Shared Hosting Notes

- Default DB: SQLite (`database/database.sqlite`) — zero config for MySQL swap in production
- Assets built via Vite → `public/build/` — served statically, no Node.js on server
- Change `APP_ENV=production`, set `SESSION_SECURE_COOKIE=true`, and switch DB credentials in `.env` before deploying
- `.env` must **never** be committed
- For MySQL: set `DB_CONNECTION=mysql` in `.env` and configure credentials
