<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Password Reset</h2>

<div>
    To reset your password, {{ HTML::link('password/reset/'.$token, 'complete this form') }}.<br/>
    This link will expire in {{ Config::get('auth.reminder.expire', 30) }} minutes.
    <br/>
    <br/>
    <br/>
    <span><i>Sincerely,</i></span>
    <br/>

    <h3><i>Road2home team</i></h3>
</div>
</body>
</html>
