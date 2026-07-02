<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Empire.pk Admin Login Code</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f4f6;font-family:Arial,Helvetica,sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f3f4f6;padding:24px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:560px;background-color:#ffffff;border-radius:16px;overflow:hidden;border:1px solid #e5e7eb;">
                <tr>
                    <td style="background-color:#082454;padding:28px 24px;text-align:center;">
                        <p style="margin:0;font-size:28px;line-height:1;font-weight:600;color:#ffffff;letter-spacing:-1px;">
                            empire<span style="color:#E3A11B;">•</span><span style="color:#E3A11B;">pk</span>
                        </p>
                        <p style="margin:8px 0 0;font-size:12px;color:#cbd5e1;letter-spacing:0.08em;text-transform:uppercase;">Admin Security Verification</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px 24px 12px;">
                        <p style="margin:0 0 12px;font-size:16px;line-height:1.5;color:#111827;">Hello {{ $userName }},</p>
                        <p style="margin:0;font-size:15px;line-height:1.6;color:#4b5563;">
                            Use the verification code below to complete your admin login. This code expires in
                            <strong style="color:#111827;">{{ $expiresMinutes }} minutes</strong>.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:8px 24px 24px;">
                        <div style="display:inline-block;background-color:#fffbeb;border:2px dashed #E3A11B;border-radius:14px;padding:18px 28px;">
                            <p style="margin:0 0 6px;font-size:12px;color:#92400e;text-transform:uppercase;letter-spacing:0.08em;font-weight:700;">Your OTP Code</p>
                            <p style="margin:0;font-size:36px;line-height:1;letter-spacing:0.35em;font-weight:700;color:#082454;font-family:'Courier New',Courier,monospace;">{{ $otp }}</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 24px 28px;">
                        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f9fafb;border-radius:12px;">
                            <tr>
                                <td style="padding:16px;">
                                    <p style="margin:0 0 8px;font-size:13px;line-height:1.5;color:#374151;">
                                        After verification, you can sign in with your email and password for the next
                                        <strong>7 days</strong> without entering a new code.
                                    </p>
                                    <p style="margin:0;font-size:13px;line-height:1.5;color:#6b7280;">
                                        If you did not attempt to sign in, you can safely ignore this email.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 24px 28px;text-align:center;">
                        <p style="margin:0;font-size:12px;line-height:1.5;color:#9ca3af;">© {{ date('Y') }} Empire.pk — Admin Panel</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
