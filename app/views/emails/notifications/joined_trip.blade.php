<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    Hey there, {{ $driver->name }}
    <br/>
    <br/>
    <b>{{ HTML::secureLink($passenger_link, $passenger->name.' '.$passenger->surname) }}</b> has joined your trip
    <b>{{ HTML::secureLink($trip_link, $trip->route_from.' > '.$trip->route_to) }}</b>.
    <br/>
    You have <b>{{$trip->seats_total - $trip->seats_taken}}</b> seats left free in your car for this trip.
    <br/>
    <br/>
    <span><i>Sincerely,</i></span>
    <br/>

    <h3><i>Road2home team</i></h3>
</div>
</body>
</html>
