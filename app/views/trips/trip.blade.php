@extends('shared.master_layout')
@section('content')
    <div class="row padding-top-10 padding-bottom-10">
{{-- Driver Profile information --}}
        <div class="col-md-offset-1 col-md-2 no-side-padding">
            <div class="row">
                <h3>Your driver:</h3>
            </div>
            <div class="row text-left">
                <img id="profile-picture-big" src="{{ asset(HTML::ProfilePicPath($driver->email, $driver->gender)) }}" class="img-circle">
            </div>
            <div class="row">
                <h3>{{ $driver->name . ' ' . $driver->surname }}</h3>
            </div>
            <div class="row padding-bottom-10">
                {{ $driver->age }} years old
            </div>
            <div class="row padding-bottom-10 bottom-border-1">
                @if($driver->smoker)
                    <img src="{{ asset(HTML::Icon('smoking')) }}" class="img-circle small-icon" title="I'm a smoker. :)">
                @else
                    <img src="{{ asset(HTML::Icon('no-smoking')) }}" class="img-circle small-icon" title="I don't smoke.">
                @endif
                @if($driver->driving_style == 'SLOW')
                    <img src="{{ asset(HTML::Icon('slow_speed')) }}" class="img-circle small-icon" title="I drive slowly and steadily. :)">
                @elseif($driver->driving_style == 'NORMAL')
                    <img src="{{ asset(HTML::Icon('normal_speed')) }}" class="img-circle small-icon" title="I drive normally, average speed.">
                @else
                    <img src="{{ asset(HTML::Icon('fast_speed')) }}" class="img-circle small-icon" title="I drive fast, but secure!.">
                @endif
            </div>
            <div class="row padding-bottom-10 padding-top-10 bottom-border-1">
                @if(Auth::check() && Auth::user()->active)
                    <div>
                        <span id="uni-label" class="inline-block">University:</span>
                        <span id="university" class="inline-block">{{ $driver->university }}</span>
                    </div>
                    <div>
                        <span class="inline-block"><b>Email:</b></span>
                        <span class="inline-block">{{ $driver->email }}</span>
                    </div>
                    <div>
                        <span class="inline-block"><b>Phone:</b></span>
                        <span class="inline-block">{{ $driver->phone_number }}</span>
                    </div>
                @else
                    <div>
                        <span id="uni-label" class="inline-block">University:</span>
                        <span id="university" class="inline-block"><i>{{ HTML::linkRoute('account.editAccount', 'Confirm', Auth::id()) }} your account to see this info</i></span>
                    </div>
                    <div>
                        <span class="inline-block"><b>Email:</b></span>
                        <span class="inline-block"><i>{{ HTML::linkRoute('account.editAccount', 'Confirm', Auth::id()) }} your account to see this info</i></span>
                    </div>
                    <div>
                        <span class="inline-block"><b>Phone:</b></span>
                        <span class="inline-block"><i>{{ HTML::linkRoute('account.editAccount', 'Confirm', Auth::id()) }} your account to see this info</i></span>
                    </div>
                @endif
            </div>
            <div class="row padding-bottom-10 padding-top-10 bottom-border-1">
                @if($driver->gender == 'Male')
                    <span><b>A bit about him:</b></span>
                @else
                    <span><b>A bit about her:</b></span>
                @endif
                {{ $driver->bio }}
            </div>
            <div class="row">
                @if($driver->gender == 'Male')
                    <h3>His car:</h3>
                @else
                    <h3>Her car:</h3>
                @endif
            </div>
            <div class="row padding-bottom-10">
                <img src="{{ asset(HTML::VehiclePic($driver->email, $vehicle->id)) }}" class="img-circle car-picture-trip">
            </div>
            @if($vehicle)
                <div class="row padding-bottom-10">
                    {{ $vehicle->make . ' ' . $vehicle->model}}
                </div>
                <div class="row padding-bottom-10">
                    Year: {{ $vehicle->year }}
                </div>
            @else
                <i>Vehicle not present. Contact trip poster for more info.</i>
            @endif
        </div>

{{-- Trip information --}}
        <div class="col-md-5">
            <div class="row padding-bottom-10 margin-bottom-10">
                <h1>{{ $trip->route_from . ' > ' . $trip->route_to }}</h1>
                {{ Form::hidden('invisible', $trip->route_from, ['id' => 'main_route_from_input']) }}
                {{ Form::hidden('invisible', $trip->route_to, ['id' => 'main_route_to_input']) }}
            </div>
            <div class="row top-border-1 bottom-border-1">
                <div class="col-sm-3 col-sm-offset-1 padding-10 trip-detail-font">
                    <strong>Departure</strong>
                </div>
                <div class="col-sm-7 col-sm-offset-1 text-left padding-10">
                    @if(Auth::check() && Auth::user()->active)
                        <strong>{{ $trip->date }}</strong> at <strong>{{ $trip->time }}</strong>
                    @else
                        <i>{{ HTML::linkRoute('account.editAccount', 'Confirm', Auth::id()) }} your account to see this info</i>
                    @endif
                </div>
            </div>
            <div class="row bottom-border-1">
                <div class="col-sm-3 col-sm-offset-1 padding-10 trip-detail-font">
                    <strong>Price</strong>
                </div>
                <div class="col-sm-7 col-sm-offset-1 text-left padding-10">
                    @if(Auth::check() && Auth::user()->active)
                        <strong>{{ $trip->price }}</strong> DKK
                    @else
                        <i>{{ HTML::linkRoute('account.editAccount', 'Confirm', Auth::id()) }} your account to see this info</i>
                    @endif
                </div>
            </div>
            <div class="row bottom-border-1">
                <div class="col-sm-3 col-sm-offset-1 padding-10 trip-detail-font">
                    <strong>Luggage size</strong>
                </div>
                <div class="col-sm-7 col-sm-offset-1 text-left padding-10">
                    @if($trip->luggage_size)
                        <h5>{{ Config::get('enums.luggage_sizes')[$trip->luggage_size] }}</h5>
                    @else
                        <h5>Not specified.</h5>
                    @endif
                </div>
            </div>
            <div class="row bottom-border-1">
                <div class="col-sm-3 col-sm-offset-1 padding-10 trip-detail-font">
                    <strong>Preferences</strong>
                </div>
                <div class="col-sm-7 col-sm-offset-1 text-left padding-10">
                    @if($trip->smoking_allowed)
                        <img src="{{ asset(HTML::Icon('smoking')) }}" class="img-circle small-icon" title="Smoking allowed. :)">
                    @else
                        <img src="{{ asset(HTML::Icon('no-smoking')) }}" class="img-circle small-icon" title="I don't like smoking in my car.">
                    @endif
                    @if($trip->chat_allowed)
                        <img src="{{ asset(HTML::Icon('chat')) }}" class="img-circle small-icon" title="I would like to chat">
                    @else
                        <img src="{{ asset(HTML::Icon('no-chat')) }}" class="img-circle small-icon" title="I am not chat friendly...">
                    @endif
                    @if($trip->music_allowed)
                        <img src="{{ asset(HTML::Icon('music')) }}" class="img-circle small-icon" title="I like to listen to music in the car. Yeah!">
                    @else
                        <img src="{{ asset(HTML::Icon('no-music')) }}" class="img-circle small-icon" title="Me no music person... :\">
                    @endif
                    @if($trip->animals_allowed)
                        <img src="{{ asset(HTML::Icon('pets')) }}" class="img-circle small-icon" title="Pets are cool! Bring them over!">
                    @else
                        <img src="{{ asset(HTML::Icon('no-pets')) }}" class="img-circle small-icon" title="No hairy animals in my car, please... :)">
                    @endif
                </div>
            </div>
            <div class="row bottom-border-1">
                <div class="col-sm-3 col-sm-offset-1 padding-10 trip-detail-font">
                    <strong>Comments</strong>
                </div>
                <div class="col-sm-7 col-sm-offset-1 text-left padding-10">
                    @if(Auth::check() && Auth::user()->active)
                        <h5>{{ $trip->additional_info }}</h5>
                    @else
                        <i>{{ HTML::linkRoute('account.editAccount', 'Confirm', Auth::id()) }} your account to see this info</i>
                    @endif
                </div>
            </div>
            <div class="row padding-top-10 text-center">
                <div id="map" class="col-lg-12 map-large">

                </div>
            </div>
        </div>

{{-- Trip controls --}}
        <div class="col-md-2 padding-top-10">
            <div class="row padding-bottom-10 padding-top-10">
                @if(Auth::check())
                    @if(Auth::user()->active)
                {{-- Viewer user is the driver itself --}}
                        @if(Auth::user()->id == $trip->driver_user_id)
                            <div class="disabled-btn" onmouseover="$showPopout()" onmouseout="$hidePopout()">
                                <div class="disabled btn btn-lg btn-success button-width-250">
                                    Get on the ride!
                                </div>
                            </div>
                            <div  class="disabled-popout">
                                That's the ride you're offering. Come on... :D
                            </div>
                {{-- Logged-in and activated user --}}
                        @else
                            {? $signed_for_trip = false; ?}
                            @foreach($passengers as $passenger)
                                @if(Auth::user()->id == $passenger)
                                    {? $signed_for_trip = true; ?}
                                @endif
                            @endforeach
                {{-- The user is already signed for the trip --}}
                            @if($signed_for_trip)
                                {{ Form::open(['route' => ['trips.resign', $trip->id, Auth::user()->id], 'method' => 'delete']) }}
                                    <div class="disabled-btn" onmouseover="$showPopout()" onmouseout="$hidePopout()">
                                        {{ Form::submit('Resign from this trip?', ['id' => 'sign-for-trip-button', 'class' => 'btn btn-lg btn-danger button-width-250']) }}
                                    </div>
                                    <div class="disabled-popout">
                                        You're on this ride already.<br>
                                        Do you want to resign from it?
                                    </div>
                                {{ Form::close() }}
                {{-- All seats for the trip are reserved --}}
                            @elseif($trip->seats_taken == $trip->seats_total)
                                <div class="disabled-btn" onmouseover="$showPopout()" onmouseout="$hidePopout()">
                                    <div class="disabled btn btn-lg btn-success button-width-250">
                                        Get on the ride!
                                    </div>
                                </div>
                                <div  class="disabled-popout">
                                    The car for this ride is already full... :\
                                </div>
                {{-- Everything is fine! Sign for the trip! --}}
                            @else
                                {{ Form::open(['route' => ['trips.apply', $trip->id, Auth::user()->id]]) }}
                                    {{ Form::submit('Get on the ride!', ['id' => 'sign-for-trip-button', 'class' => 'btn btn-lg btn-success button-width-250']) }}
                                {{ Form::close() }}
                            @endif
                        @endif
                {{-- NOT confirmed/activated user --}}
                    @else
                        <div class="disabled-btn" onmouseover="$showPopout()" onmouseout="$hidePopout()">
                            <div class="disabled btn btn-lg btn-success button-width-250">
                                Get on the ride!
                            </div>
                        </div>
                        <div  class="disabled-popout">
                            Confirm your account/email to be able to sign for trips.
                        </div>
                    @endif
                {{-- NOT authenticated (logged-in) --}}
                @else
                    <div class="disabled-btn" onmouseover="$showPopout()" onmouseout="$hidePopout()">
                        <div class="disabled btn btn-lg btn-success button-width-250">
                            Get on the ride!
                        </div>
                    </div>
                    <div  class="disabled-popout">
                        Log in/register to be able to sign for trips.
                    </div>
                @endif
            </div>
            <div class="row padding-bottom-10">
                @if(Auth::check())
                    @for($i = 0; $i < $trip->seats_taken; $i++)
                        <img src="{{ asset(HTML::Icon('seat_taken')) }}" class="img-circle small-icon" title="Seat is taken! :(">
                    @endfor
                    @for($i = $trip->seats_taken; $i < $trip->seats_total; $i++)
                        <img src="{{ asset(HTML::Icon('seat_free')) }}" class="img-circle small-icon" title="Seat is free! Hooray! :)">
                    @endfor
                @else
                    <i>Confirm your account to see the number of free/taken seats for this trip.</i>
                @endif
            </div>
            <div class="row empty-div-height-100">

            </div>
            @if(isset($trip->parent_trip_id))
                <div class="row padding-bottom-10">
                    {{ HTML::linkRoute('trips.show', 'This is a partial trip of... >>', $trip->parent_trip_id, ['class' => 'btn btn-lg btn-default'] ) }}
                </div>
            @endif
            @if(isset($trip->return_trip_id))
                <div class="row padding-bottom-10">
                    {{ HTML::linkRoute('trips.show', 'This ride has a round trip >>', $trip->return_trip_id, ['class' => 'btn btn-lg btn-default'] ) }}
                </div>
            @endif
            @if(isset($partial_trips))
                @foreach($partial_trips as $p_trip)
                    <div class="row padding-bottom-10">
                        {{ HTML::linkRoute('trips.show', 'It has a partial trip >>', $p_trip->id, ['class' => 'btn btn-lg btn-default'] ) }}
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <script type="text/javascript">
        calcRoute();
    </script>
@stop