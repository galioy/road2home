@extends('shared.master_layout')
@section('content')

<div class="row margin-top-10">
    <div class="col-md-6">
        <div class="row margin-top-10 margin-bottom-10">
            <div class="col-md-12 text-center">
                <h1>Active trips offered by you</h1>
            </div>
        </div>
        @foreach($trips_offered as $trip)
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="col-md-6 trip-list-route">
                            <p class="city_route inline-block"> {{ $trip->route_from }}</p>,
                            <p class="text-minified inline-block">{{ $trip->country_from }}</p>
                            <br>to <p class="city_route inline-block"> {{ $trip->route_to }}</p>,
                            <p class="text-minified inline-block">{{ $trip->country_to }}</p>
                        </div>
                        <div class="col-md-6 text-right trip-time">
                            <b>{{ $trip->date }}</b>
                            <i>at</i>
                            <b>{{ $trip->time }}</b>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="col-md-3 col-md-offset-8 text-right">
                            {{ HTML::linkRoute('trips.edit', 'Edit this one!', $trip->id,
                            ['class' => 'btn btn-success']) }}
                        </div>
                        <div class="col-md-1 text-right">
                            {{ Form::open(['route' => ['trips.destroy', $trip->id], 'method' => 'delete']) }}
                                {{ Form::submit('Delete', ['class' => 'btn btn-danger']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            <hr class="trips-list-separator">
        @endforeach
    </div>
    <div class="col-md-6">
        <div class="row margin-top-10 margin-bottom-10">
            <div class="col-md-12 text-center">
                <h1>Rides you've joined</h1>
            </div>
        </div>
        @foreach($trips_joined as $trip)
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="col-md-6 trip-list-route">
                        <p class="city_route inline-block"> {{ $trip->route_from }}</p>,
                        <p class="text-minified inline-block">{{ $trip->country_from }}</p>
                        <br>to <p class="city_route inline-block"> {{ $trip->route_to }}</p>,
                        <p class="text-minified inline-block">{{ $trip->country_to }}</p>
                    </div>
                    <div class="col-md-6 text-right trip-time">
                        <b>{{ $trip->date }}</b>
                        <i>at</i>
                        <b>{{ $trip->time }}</b>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-3 col-md-offset-8 text-right">
                        {{ HTML::linkRoute('trips.show', 'Check it out!', $trip->id,
                        ['class' => 'btn btn-success']) }}
                    </div>
                    <div class="col-md-1 text-right">
                        {{ Form::open(['route' => ['trips.resign', $trip->id, Auth::id()], 'method' => 'delete']) }}
                        {{ Form::submit('Resign...', ['class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
            <hr class="trips-list-separator">
        @endforeach
    </div>
</div>
@stop()