@extends('shared.master_layout')
@section('content')
@if($trips)
    <div class="col-md-12 text-center margin-bottom-10">
        <h1>Trips available</h1>
    </div>
    <ul class="trip-list margin-top-10">
        @foreach($trips as $trip)
            <li class="trip-container">
                <div class="row">
                    <div class="col-md-3">
                        <img id="profile-picture-big"
                             src="{{ asset(HTML::ProfilePicPath($trip->driver['email'], $trip->driver['gender'])) }}"
                             class="img-circle">
                    </div>
                    <div class="col-md-6">
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
                        <div class="col-md-6">
                            Driver:
                            {{ HTML::linkRoute('account.show',
                                        $trip->driver['name'] . ' ' . $trip->driver['surname'],
                                        $trip->driver['id']) }}
                        </div>
                        <div class="col-md-6 text-right">
                        @if(Auth::check())
                            {{ HTML::linkRoute('trips.show', 'Check it out!', $trip->id,
                            ['class' => 'btn btn-success']) }}
                        @else
                            <div id="{{ $trip->id }}"  class="not-logged-details" onmouseover="$showNotice({{ $trip->id }})"
                                 onmouseout="$hideNotice({{ $trip->id }})">
                                <div  class="disabled btn btn-success">
                                    Check it out!
                                </div>
                            </div>
                            <div  class="{{ $trip->id }} not-logged-in-notice">
                                Log in/register to see the details
                            </div>
                        @endif
                        </div>
                    </div>
                    <div class="col-ms-3">
                        @if(isset($trip->vehicle))
                            <img style="float:left" id="car-picture-big"
                                 src="{{ asset(HTML::VehiclePic($trip->driver['email'], $trip->vehicle['id'])) }}"
                                 class="img-circle">
                        @else
                            <img style="float:left" id="car-picture-big"
                                 src="{{ asset('images/profiles/default_vehicle.png') }}"
                                 class="img-circle">
                        @endif
                    </div>

                </div>
            </li>
             <hr class="trips-list-separator">
        @endforeach
        @if(!isset($search))
            <li class="pagination-container">
                <div class="col-md-offset-3 col-md-6 no-side-padding text-center">{{ $trips->links() }}</div>
            </li>
        @endif
    </ul>
@else
    <div class="col-md-12 text-center margin-bottom-10">
        <h1>Oops... <br>No trips from {{ $route_from  }} to {{ $route_to }} are happening.</h1>
    </div>
@endif
@stop