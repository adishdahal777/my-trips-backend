# CLAUDE.md

## Stack
- PHP 8.3, Laravel 13
- Auth: Sanctum (tokens) + Socialite (Google OAuth) + OTP email login
- API docs: dedoc/scramble (auto-generated from routes/FormRequests, no manual OpenAPI)
- DB: SQLite (dev), driver-agnostic via Eloquent
- Frontend build: Vite + Tailwind v4 (asset pipeline only, no SPA framework detected)

## Commands
| Task | Command |
|---|---|
| Install | `composer install && npm install` |
| Dev (server+queue+logs+vite) | `composer dev` |
| Test | `composer test` (= `artisan config:clear && artisan test`) |
| Single test | `php artisan test --filter=TestName` |
| Lint/format | `./vendor/bin/pint` |
| Migrate | `php artisan migrate` |
| Build assets | `npm run build` |

## Project Layout
```
app/Models/       Trip, RouteStop, Expense, Photo, Note, Comment, Like, User, UserProfile
app/Mail/OTPMail.php   OTP login email
routes/api.php     API routes (Sanctum-protected)
database/migrations/  trips, route_stops, expenses, photos, notes, trip_likes, trip_comments + auth/OTP/google fields
database/seeders/PublicTripsSeeder.php
```
Domain: a Trip has RouteStops, Expenses, Photos, Notes, and social features (Likes, Comments) — some trips are public (see PublicTripsSeeder).

## Judgment Boundaries
- NEVER commit `.env`, `database/database.sqlite`, or run destructive migrations (`migrate:fresh`, `migrate:rollback`) against non-local DB without asking.
- ASK FIRST before adding new composer/npm dependencies — keep this skeleton lean.
- ALWAYS run `php artisan test` after touching `app/Models` or `database/migrations`.
- API routes are documented automatically by Scramble — don't hand-write OpenAPI specs.

## Conventions
- Auth supports three paths: Sanctum token, Google Socialite, and OTP-by-email — check `User` model fields (`otp`, `google_*`) before adding new auth logic.
- Migrations for domain tables (trips, route_stops, expenses, photos, notes, likes, comments) were all added 2026-07-02 — treat as the current canonical schema, not legacy.

## Agentic Config
See `.agents/` and `.claude/` for subagents, skills, and wiki notes.

@AGENTS.md
