<p>Dear {{ $client->name }},</p>
<p>
    You requested to reset your password on {{ get_settings()->site_name }}. Click the link below to reset it:
</p>
<p>
    <a href="{{ $actionLink }}" target="_blank" style="color: #007bff; text-decoration: underline;">
        Reset Password
    </a>
</p>
<p>
    This link is valid for 15 minutes. If you didn’t request a password reset, please ignore this email.
</p>
<br>
<p>Regards,</p>
<p>{{ get_settings()->site_name }} Team</p>
