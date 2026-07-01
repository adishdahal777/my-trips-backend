<x-mail::message>
# Your Authentication Code

Use the following 6-digit code to complete your login. This code will expire in 5 minutes.

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

If you did not request this code, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
