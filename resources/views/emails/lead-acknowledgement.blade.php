<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We've received your enquiry</title>
</head>

<body style="margin:0; padding:0; background:#eef5f6; font-family: Arial, Helvetica, sans-serif; color:#0a161e;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 8px 24px rgba(10,22,30,0.08);">
                    <tr>
                        <td style="background:#0a161e; padding:24px 32px;">
                            <span style="display:inline-block; width:34px; height:34px; line-height:34px; text-align:center; border-radius:9px; background:#ea580c; color:#ffffff; font-weight:bold;">BR</span>
                            <span style="color:#ffffff; font-size:18px; font-weight:bold; margin-left:8px;">{{ $brandName ?? config('app.name', 'MEP Solutions') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <h1 style="margin:0 0 12px; font-size:22px;">Thanks for reaching out, {{ $lead->name }}!</h1>
                            <p style="margin:0 0 16px; font-size:15px; line-height:1.6; color:#3f5560;">
                                {!! nl2br(e($body ?? "We've received your enquiry and our team will contact you shortly. Here's what you sent:")) !!}
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f8f9; border-radius:12px; font-size:14px;">
                                <tr>
                                    <td style="padding:12px 16px; color:#6b7f88;">Service</td>
                                    <td style="padding:12px 16px; font-weight:bold;">{{ $lead->service ?: 'General enquiry' }}</td>
                                </tr>
                                @if ($lead->message)
                                <tr>
                                    <td style="padding:12px 16px; color:#6b7f88; vertical-align:top;">Message</td>
                                    <td style="padding:12px 16px;">{{ \Illuminate\Support\Str::limit($lead->message, 120) }}</td>
                                </tr>
                                @endif
                            </table>
                            <p style="margin:24px 0 0; font-size:15px; line-height:1.6; color:#3f5560;">
                                Need us sooner? Call or WhatsApp us and we'll get right on it.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 32px; background:#f4f8f9; font-size:12px; color:#6b7f88;">
                            This is an automated acknowledgement from {{ $brandName ?? config('app.name', 'MEP Solutions') }}.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>