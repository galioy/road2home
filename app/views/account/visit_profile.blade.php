@extends('shared.master_layout')

@section('content')
    <div id="visit-profile-container" class="container">
        <div class="row">
            {{--Rating info--}}
            <div class="col-sm-6">
                <div class="col-sm-12 no-side-padding personal-ratings-container">
                    <div class="personal-rating">
                        <h2>Rating:</h2>
                        <div class="col-sm-12 no-side-padding">-- coming soon --</div>
                        {{--<div class="col-sm-6 no-side-padding">Rating: ***</div>--}}
                        {{--<div class="col-sm-6 no-side-padding">--}}
                            {{--<div class="col-sm-4 no-side-padding">Excellent:</div>--}}
                            {{--<div class="col-sm-8 no-side-padding">star graph</div>--}}
                            {{--<div class="col-sm-4 no-side-padding">Very good:</div>--}}
                            {{--<div class="col-sm-8 no-side-padding">star graph</div>--}}
                            {{--<div class="col-sm-4 no-side-padding">OK:</div>--}}
                            {{--<div class="col-sm-8 no-side-padding">star graph</div>--}}
                            {{--<div class="col-sm-4 no-side-padding">Not good:</div>--}}
                            {{--<div class="col-sm-8 no-side-padding">star graph</div>--}}
                            {{--<div class="col-sm-4 no-side-padding">Awful:</div>--}}
                            {{--<div class="col-sm-8 no-side-padding">star graph</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
                <div id="reviews-container" class="col-sm-12 no-side-padding top-border-1">
                    <h2>Reviews:</h2>
                    <div class="review col-sm-12 no-side-padding">
                        -- coming soon --
                    </div>
                </div>
            </div>
            {{--Profile info--}}
            <div class="col-sm-6">
                <div id="personal-info-container" class="col-sm-12 no-side-padding">
                    <div class="col-sm-6 no-side-padding padding-right-10">
                        <div class="row">
                            <h2 id="full-name">{{ $user->name }} {{ $user->surname }}</h2>

                            <div id="age" class="inline-block pull-left">{{ $user->age }} years old</div>
                            <div class="col-md-1">{{ $user->gender }}</div>
                            <div class="inline-block pull-right">
                                @if($user->smoker)
                                    <img src="{{ asset(HTML::Icon('smoking')) }}" class="img-circle small-icon" title="I'm a smoker. :)">
                                @else
                                    <img src="{{ asset(HTML::Icon('no-smoking')) }}" class="img-circle small-icon" title="I don't smoke.">
                                @endif
                                @if($user->driving_style == 'SLOW')
                                    <img src="{{ asset(HTML::Icon('slow_speed')) }}" class="img-circle small-icon" title="I drive slowly and steadily. :)">
                                @elseif($user->driving_style == 'NORMAL')
                                    <img src="{{ asset(HTML::Icon('normal_speed')) }}" class="img-circle small-icon" title="I drive normally, average speed.">
                                @else
                                    <img src="{{ asset(HTML::Icon('fast_speed')) }}" class="img-circle small-icon" title="I drive fast, but secure!.">
                                @endif
                            </div>
                        </div>
                        @if(Auth::check() && Auth::user()->active)
                            <div class="row">
                                <div class="col-md-2 no-side-padding"><b>Email:</b></div>
                                <div class="col-md-8">{{ $user->email }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 no-side-padding"><b>Phone:</b></div>
                                @if(is_null($user->phone_number))
                                    <div class="col-md-8">{{ $user->phone_number }}</div>
                                @else
                                    <div class="col-md-8"><i>no number set up</i></div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-4 no-side-padding">
                        {{-- Checks if a picture for this car exists and shows the default car picture if a picture can't be found --}}
                        <img id="profile-picture-big" src="{{ asset(HTML::ProfilePicPath($user->email, $user->gender)) }}" class="img-circle">
                    </div>
                    <div class="col-sm-12 no-side-padding bottom-border-1">
                        <span id="uni-label" class="inline-block">University: </span> <span id="university" class="inline-block">{{ $user->university }}</span>
                    </div>
                    </hr>
                    <div class="col-sm-12 no-side-padding bottom-border-1 margin-top-10 padding-bottom-10">
                        <span class="profile-bio"><b>About me: </b>{{ $user->bio }}</span>
                    </div>
                </div>
                {{--Car info--}}
                <div id="car-info-container" class="col-md-8 no-side-padding ">
                    @if(!$user->Vehicles->isEmpty())
                        @foreach($user->Vehicles as $vehicle)
                            <div class="col-md-8 no-side-padding ">
                                <h3 id="car-make-and-model">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                                <div id="car-details" class="car-details inline-block pull-left col-md-10 ">
                                    <div class="col-sm-4 no-side-padding">Year:</div>
                                    <div class="col-sm-6 no-side-padding">{{ $vehicle->year }}</div>
                                    <div class="col-sm-4 no-side-padding">Seats:</div>
                                    <div class="col-sm-6 no-side-padding">{{ $vehicle->seats }}</div>
                                    <div class="col-sm-4 no-side-padding ">Color:</div>
                                    <div class="col-sm-6 no-side-padding ">{{ $vehicle->color }}</div>
                                    <div class="col-sm-4 no-side-padding">Type:</div>
                                    <div class="col-sm-6 no-side-padding">{{ ucfirst(strtolower($vehicle->type)) }}</div>
                                </div>
                            </div>
                            <div class="col-sm-4 no-side-padding margin-top-10">
                                {{-- Checks if a picture for this car exists and shows the default car picture if a picture can't be found --}}
                                <img id="car-picture-big" src="{{ asset(HTML::VehiclePic($user->email, $vehicle->id)) }}" class="img-circle">
                            </div>
                        @endforeach
                    @else
                        <div class="col-sm-12"><h2>No vehicles</h2></div>
                    @endif
                </div>
                <div id="travel-stats" class="col-sm-12 no-side-padding top-border-1">
                    <h2>Statistics:</h2>
                    <div class="col-sm-8 no-side-padding">Traveled (as passenger):</div>
                    <div class="col-sm-4 no-side-padding">150km</div>
                    <div class="col-sm-8 no-side-padding">Traveled (as driver):</div>
                    <div class="col-sm-4 no-side-padding">753</div>
                    <div class="col-sm-8 no-side-padding">CO2 saved :</div>
                    <div class="col-sm-4 no-side-padding">43kg</div>
                    <div class="col-sm-8 no-side-padding">Response rate:</div>
                    <div class="col-sm-4 no-side-padding">87%</div>
                </div>
            </div>
        </div>
    </div>
@stop