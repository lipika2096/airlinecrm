<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Updated</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #6a1b9a; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
            <h1 style="color: #fff; margin: 0; font-size: 24px;">{{ config('app.name') }}</h1>
        </div>

        <div style="background: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-top: none;">
            <h2 style="color: #6a1b9a; margin-top: 0;">Password Successfully Updated</h2>

            <p>Dear {{ $user->name ?? 'User' }},</p>

            <p>We wanted to let you know that your password was successfully updated on <strong>{{ $updatedAt->format('F j, Y') }}</strong> at <strong>{{ $updatedAt->format('g:i A') }}</strong>.</p>

            <p>If you did not make this change, please contact our support team immediately.</p>

            <div style="background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0;">
                <p style="margin: 0;"><strong>Security Notice:</strong> For your security, we recommend using a strong password with a mix of letters, numbers, and special characters.</p>
            </div>

            <p>If you have any questions or concerns, please don't hesitate to reach out to our support team.</p>

            <p>Best regards,<br>
            {{ config('app.name') }} Team</p>

            <hr style="border: none; border-top: 1px solid #ddd; margin: 30px 0;">

            <p style="font-size: 12px; color: #666;">
                This is an automated email. Please do not reply to this message.<br>
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
