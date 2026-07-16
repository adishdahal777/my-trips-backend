# Architecture

- Request flow: `routes/api.php` → Controller → Model (Eloquent) → SQLite. Sanctum middleware guards protected routes.
- Auth: three entry points feed the same `User` model — token login (Sanctum), Google OAuth (Socialite, `google_*` columns), OTP email (`otp` column + `app/Mail/OTPMail.php`).
- API docs are generated, not written: `dedoc/scramble` introspects routes and FormRequests at request-time to serve OpenAPI/UI. Adding a route or FormRequest updates docs automatically.
- Domain graph: `Trip` is the aggregate root — has many `RouteStop`, `Expense`, `Photo`, `Note`; `Like`/`Comment` are social features referencing `Trip` + `User`. Public trips are surfaced via `PublicTripsSeeder`.

## Gotchas
- All domain migrations are dated 2026-07-02 — this is a fresh schema, not legacy debt.
- `.env.example` defaults to SQLite + database-backed sessions/queue/cache — no Redis required for local dev despite config being present.
