<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Account confirmation</h2>

<div>
    Hey there, {{ $name }}<br/><br/>
    Please confirm your account email by clicking on the following link:<br/>
    <b>{{ HTML::secureLink($link, 'Account activation link') }}</b>
    <br/>
    <br/>
    <br/>
    <span><i>Sincerely,</i></span>
    <br/>

    <h3><i>Road2home team</i></h3>
</div>
</body>
</html>
