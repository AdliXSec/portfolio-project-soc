<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <link href="https://fonts.googleapis.com/css?family=Plus+Jakarta+Sans:wght@700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; background-color: #050505; font-family: 'Plus Jakarta Sans', Arial, sans-serif; color: #e5e7eb;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 20px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
                    <tr>
                        <td align="center" style="padding: 40px 0 30px 0;">
                            <!-- Header -->
                            <div style="width: 48px; height: 48px; background-color: #2563eb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; color: #ffffff; margin: 0 auto 16px auto;">N</div>
                            <h1 style="font-size: 24px; font-weight: bold; color: #ffffff; margin: 0;">Your Login Code</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px 30px; border-radius: 16px; background-color: #111827; border: 1px solid rgba(255, 255, 255, 0.1);">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <p style="margin: 0 0 24px 0; font-size: 16px; line-height: 24px; color: #d1d5db;">
                                            Here is the One-Time Password (OTP) to complete your login.
                                        </p>
                                        
                                        <!-- OTP Panel -->
                                        <div style="background-color: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; text-align: center; padding: 20px;">
                                            <p style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: 5px; color: #ffffff;">
                                                {{ $otp }}
                                            </p>
                                        </div>

                                        <p style="margin: 24px 0 0 0; font-size: 14px; line-height: 20px; color: #9ca3af;">
                                            This code is valid for 5 minutes. Please do not share this code with anyone.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 30px 0;">
                            <!-- Footer -->
                            <p style="margin: 0; font-size: 12px; color: #6b7280;">
                                Thanks,<br>
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
