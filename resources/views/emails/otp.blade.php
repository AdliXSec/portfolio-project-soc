<x-mail::message>
# Your One-Time Password (OTP)

Here is your OTP code to complete your login.

<x-mail::panel>
**{{ $otp }}**
</x-mail::panel>

This code is valid for 5 minutes. Please do not share this code with anyone.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
