<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Authentication Code</title>
</head>
<body style="margin:0;padding:0;background:#F4F6F9;font-family:'Inter',ui-sans-serif,system-ui,-apple-system,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#F4F6F9;padding:32px 16px;">
<tr>
<td align="center">
<table role="presentation" width="480" cellpadding="0" cellspacing="0" style="max-width:480px;width:100%;background:#FFFFFF;border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(15,23,42,0.06);">

<tr>
<td style="background:#2563EB;padding:28px 32px;text-align:center;">
<table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto;">
<tr>
<td style="vertical-align:middle;padding-right:10px;">
<div style="width:30px;height:30px;border-radius:9px;background:rgba(255,255,255,0.18);text-align:center;line-height:30px;">
<span style="color:#FFFFFF;font-size:15px;">&#9992;</span>
</div>
</td>
<td style="vertical-align:middle;">
<span style="font-family:'Outfit',ui-sans-serif,system-ui,sans-serif;color:#FFFFFF;font-size:19px;font-weight:600;letter-spacing:-0.02em;">MyTrips</span>
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td style="padding:40px 36px 8px;text-align:center;">
<h1 style="margin:0 0 10px;font-family:'Outfit',ui-sans-serif,system-ui,sans-serif;color:#0F172A;font-size:22px;font-weight:600;letter-spacing:-0.02em;">Your Authentication Code</h1>
<p style="margin:0;color:#64748B;font-size:14px;line-height:22px;">Use the 6-digit code below to continue signing in to MyTrips. This code expires in 5 minutes.</p>
</td>
</tr>

<tr>
<td style="padding:24px 36px 8px;text-align:center;">
<div style="background:rgba(37,99,235,0.08);border:1px solid rgba(37,99,235,0.16);border-radius:16px;padding:20px;">
<span style="font-family:'Outfit',ui-sans-serif,system-ui,sans-serif;font-size:36px;font-weight:700;letter-spacing:0.3em;color:#2563EB;">{{ $otp }}</span>
</div>
</td>
</tr>

<tr>
<td style="padding:24px 36px 36px;text-align:center;">
<p style="margin:0;color:#94A3B8;font-size:12.5px;line-height:20px;">Didn't request this code? You can safely ignore this email — no changes will be made to your account.</p>
</td>
</tr>

<tr>
<td style="padding:20px 36px;border-top:1px solid #EEF1F6;text-align:center;">
<p style="margin:0;color:#94A3B8;font-size:11.5px;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
</td>
</tr>

</table>
</td>
</tr>
</table>
</body>
</html>
