<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    Hey there, {{ $passenger->name }}
    <br/>
    <br/>
    <b>You have just joined {{ HTML::secureLink($driver_link, $driver->name) }}</b>'s trip.
    <br/>You can check it out here: <b>{{ HTML::secureLink($trip_link, $trip->route_from.' > '.$trip->route_to) }}</b>.
    <br/>
    <br/>
    <span><i>Sincerely,</i></span>
    <br/>

    <h3><i>Road2home team</i></h3>
</div>
</body>
</html>
