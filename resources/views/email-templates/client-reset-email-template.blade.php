<p>Dear {{ $client->name }},</p>
<p>
    Your password on {{ get_settings()->site_name }} has been successfully changed. Below are your updated login details:
</p>
<ul>
    {{-- <li><b>Email:</b> {{ $client->email }}</li>
    <li> <b>Password: {{$client->password}}</b> </li> --}}
</ul>
<p>
    Please keep your credentials confidential. If you did not make this change, contact us immediately.
</p>
<br>
<p>Regards,</p>
<p>{{ get_settings()->site_name }} Admin Team</p>
