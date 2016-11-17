@extends('shared.master_layout')

@section('content')

    <div id="personal-profile-container" class="container ">
        {{--Edit button container--}}
        <div class="row">
            {{--Profile info--}}
            <div class="col-sm-6 right-border-1">
                <div class="col-sm-8 no-side-padding padding-right-10">
                    <h2 id="full-name">{{ $user->name }} {{ $user->surname }}</h2>

                    <div>
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
                </div>
                <div class="col-sm-4 no-side-padding">
                    {{-- Checks if a picture for this car exists and shows the default car picture if a picture can't be found --}}
                    <img id="profile-picture-big" src="{{ asset(HTML::ProfilePicPath($user->email, $user->gender)) }}" class="img-circle">
                </div>
                <div class="row margin-bottom-10">
                    <div class="col-sm-1 no-side-padding"><b>Phone:</b></div>
                    @if(is_null($user->phone_number))
                        <div class="col-sm-4 text-left">{{ $user->phone_number }}</div>
                    @else
                        <div class="col-sm-4 text-left"><i>no number set up</i></div>
                    @endif
                </div>
                <div class="row margin-bottom-10">
                    <div class="col-sm-2 no-side-padding"><b>University: </b></div>
                    <div class="col-sm-4 text-left no-side-padding">{{ $user->university }}</div>
                </div>
                </hr>
                <div class="col-sm-12 no-side-padding">
                    <div class="full-width bottom-border-1 margin-bottom-10"></div>
                    <span class="profile-bio"><b>About me: </b>{{ $user->bio }}</span>
                </div>

                <div class="col-sm-12 no-side-padding personal-ratings-container top-border-1">
                    <div class="personal-rating">
                        <h3>I'm this cool:</h3>
                        <div class="col-sm-6 no-side-padding">Rating: ***</div>
                        <div class="col-sm-6 no-side-padding">
                            <div class="col-sm-4 no-side-padding">Excellent:</div>
                            <div class="col-sm-8 no-side-padding">star graph</div>
                            <div class="col-sm-4 no-side-padding">Very good:</div>
                            <div class="col-sm-8 no-side-padding">star graph</div>
                            <div class="col-sm-4 no-side-padding">OK:</div>
                            <div class="col-sm-8 no-side-padding">star graph</div>
                            <div class="col-sm-4 no-side-padding">Not good:</div>
                            <div class="col-sm-8 no-side-padding">star graph</div>
                            <div class="col-sm-4 no-side-padding">Awful:</div>
                            <div class="col-sm-8 no-side-padding">star graph</div>
                        </div>
                    </div>
                </div>

            </div>

            {{--Car info--}}
            <div class="col-md-6">
                @if(!$user->Vehicles->isEmpty())
                    @foreach($user->Vehicles as $vehicle)
                        <div class="col-md-5 no-side-padding">
                            <h2 id="car-make-and-model">{{ $vehicle->make }} {{ $vehicle->model }}</h2>
                            <div id="car-details" class="car-details inline-block pull-left col-md-6">
                                <div class="col-sm-6 no-side-padding">Year:</div>
                                <div class="col-sm-4">{{ $vehicle->year }}</div>
                                <div class="col-sm-6 no-side-padding">Seats:</div>
                                <div class="col-sm-4">{{ $vehicle->seats }}</div>
                                <div class="col-sm-6 no-side-padding">Color:</div>
                                <div class="col-sm-4">{{ $vehicle->color }}</div>
                                <div class="col-sm-6 no-side-padding">Type:</div>
                                <div class="col-sm-4">{{ ucfirst(strtolower($vehicle->type)) }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4 no-side-padding">
                            {{-- Checks if a picture for this car exists and shows the default car picture if a picture can't be found --}}
                            <img id="car-picture-big" src="{{ asset(HTML::VehiclePic($user->email, $vehicle->id)) }}" class="img-circle">
                        </div>
                    @endforeach
                @else
                    <div class="col-sm-12"><h2>No vehicles</h2></div>
                @endif
                <div id="travel-stats" class="col-sm-12 no-side-padding top-border-1">
                    <h2>Statistics:</h2>
                    <div class="col-sm-7">Traveled (as passenger):</div>
                    <div class="col-sm-4">150km</div>
                    <div class="col-sm-7">Traveled (as driver):</div>
                    <div class="col-sm-4">753</div>
                    <div class="col-sm-7">CO2 saved :</div>
                    <div class="col-sm-4">43kg</div>
                    <div class="col-sm-7">Response rate:</div>
                    <div class="col-sm-4">87%</div>
                </div>

                <div id="reviews-container" class="col-sm-12 no-side-padding top-border-1">
                    <h2>Reviews:</h2>
                    <div class="review col-sm-12">
                        review body
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop