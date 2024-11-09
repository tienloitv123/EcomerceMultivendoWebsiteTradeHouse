<p>Dear {{ $client_name }},</p>
<p>
    We have received a request to verify the Laravel Client account associated with {{ $client_email }}. <br>
    You can verify your account by clicking on the link below: <br>
    <a href="{{ $action_link }}">Verify Account</a>
</p>
<p>
    If you did not request this verification, please ignore this email.
</p>
<p>
    Best Regards,<br>
    {{ config('app.name') }} Team
</p>
