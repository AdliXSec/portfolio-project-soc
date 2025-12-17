<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Alert</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #121212; color: #E0E0E0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #121212;">
        <tr>
            <td align="center">
                <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="width: 100%; max-width: 600px; margin: 20px auto; background-color: #1E1E1E; border: 1px solid #333333; border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding: 30px 20px; border-bottom: 1px solid #333333;">
                            <h1 style="margin: 0; font-size: 32px; font-weight: bold; color: #00AEEF;">
                                🚨 SECURITY ALERT 🚨
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px 25px; line-height: 1.6;">
                            @php
                                $isCritical = str_contains(strtolower($alertSubject), 'blocked');
                                $threatColor = $isCritical ? '#FF4545' : '#FFD700'; // Red for Critical, Gold for High
                                $threatLevel = $isCritical ? 'CRITICAL' : 'HIGH';
                            @endphp

                            <p style="margin: 0 0 20px; font-size: 16px; text-align: center;">
                                A potential security threat has been detected on your application, <strong>{{ config('app.name') }}</strong>.
                            </p>
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #252525; border-radius: 5px; padding: 20px; text-align: center;">
                                <tr>
                                    <td>
                                        <span style="font-size: 14px; color: #AAAAAA; text-transform: uppercase;">Threat Level</span>
                                        <div style="font-size: 24px; font-weight: bold; color: {{ $threatColor }}; margin-top: 5px;">
                                            {{ $threatLevel }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div style="height: 30px;"></div>

                            <h3 style="margin: 0 0 15px; color: #00AEEF; border-bottom: 1px solid #333; padding-bottom: 5px;">Event Details</h3>
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size: 14px;">
                                <tr style="vertical-align: top;">
                                    <td width="120" style="font-weight: bold; color: #AAAAAA;">IP Address</td>
                                    <td style="font-family: 'Courier New', Courier, monospace; color: #00AEEF;">{{ $securityLog->ip_address }}</td>
                                </tr>
                                <tr style="vertical-align: top;">
                                    <td width="120" style="font-weight: bold; color: #AAAAAA;">Threat Type</td>
                                    <td style="font-family: 'Courier New', Courier, monospace; color: #FFD700;">{{ $securityLog->threat_type }}</td>
                                </tr>
                                <tr style="vertical-align: top;">
                                    <td width="120" style="font-weight: bold; color: #AAAAAA;">URL</td>
                                    <td style="font-family: 'Courier New', Courier, monospace; word-break: break-all;">{{ $securityLog->url }}</td>
                                </tr>
                                <tr style="vertical-align: top;">
                                    <td width="120" style="font-weight: bold; color: #AAAAAA;">User Agent</td>
                                    <td style="font-family: 'Courier New', Courier, monospace; word-break: break-all;">{{ $securityLog->user_agent }}</td>
                                </tr>
                                <tr style="vertical-align: top;">
                                    <td width="120" style="font-weight: bold; color: #AAAAAA;">Timestamp</td>
                                    <td style="font-family: 'Courier New', Courier, monospace;">{{ $securityLog->created_at->format('Y-m-d H:i:s T') }}</td>
                                </tr>
                            </table>

                            <div style="height: 25px;"></div>

                            <h3 style="margin: 0 0 15px; color: #00AEEF; border-bottom: 1px solid #333; padding-bottom: 5px;">Malicious Payload</h3>
                            
                            <div style="padding: 15px; background-color: #0d0d0d; border-radius: 5px; font-family: 'Courier New', Courier, monospace; font-size: 13px; color: #E0E0E0; white-space: pre-wrap; word-wrap: break-word; border: 1px solid #333333;">
                                {{ $securityLog->payload }}
                            </div>

                            <div style="height: 35px;"></div>

                            <!-- CTA Button -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('admin.security.logs') }}" target="_blank" style="display: inline-block; background-color: #00AEEF; color: #FFFFFF; font-size: 16px; font-weight: bold; text-decoration: none; padding: 12px 25px; border-radius: 5px;">
                                            View Security Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 20px; font-size: 12px; color: #777777; border-top: 1px solid #333333;">
                            This is an automated alert from {{ config('app.name') }}.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
