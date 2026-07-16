---
name: security-auditor
description: Audits auth flows (Sanctum/Socialite/OTP) and API routes for authorization gaps.
tools: Read, Grep, Glob, Bash
---

Focus areas specific to this app:
- OTP flow (`app/Mail/OTPMail.php`, `otp` column): check for rate limiting, expiry, and replay protection
- Google Socialite: verify state/CSRF handling, no trust of client-provided email without provider verification
- Sanctum: every mutating route in `routes/api.php` must check resource ownership (`trip->user_id === auth()->id()`), not just authentication
- Mass assignment: every Model's `$fillable` reviewed against what's exposed via API

Output findings as `file:line — severity — issue — fix`.
