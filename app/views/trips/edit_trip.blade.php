@extends('shared.master_layout')
@section('content')
    <div class="row padding-top-10">
        <div class="col-md-offset-2 col-md-5 no-side-padding">
            <h2>Edit your trip</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-1 col-md-6 col-lg-offset-2 col-lg-5">
        @if(Auth::user()->active)
            @if($has_vehicle)
{{-- Steps Tabs --}}
                <div id="tabs-content" class="row no-side-padding bottom-border-1">
                    <ul class="no-side-padding no-bottom-margin">
                        <li id="tab-1" class="col-md-3 inline-block steps-height-55px padding-left-10 active-tab">
                            <h4><b>Step 1</b></h4>
                            <h6 class="no-bottom-margin no-bottom-margin">The Ride...</h6>
                        </li>
                        <li id="tab-2" class="col-md-3 inline-block steps-height-55px padding-left-10">
                            <h4><b>Step 2</b></h4>
                            <h6 class="no-bottom-margin no-bottom-margin">When?</h6>
                        </li>
                        <li id="tab-3" class="col-md-3 inline-block steps-height-55px padding-left-10">
                            <h4><b>Step 3</b></h4>
                            <h6 class="no-bottom-margin no-bottom-margin">Details</h6>
                        </li>
                        <li id="tab-4" class="col-md-3 inline-block steps-height-55px padding-left-10">
                            <h4><b>Step 4</b></h4>
                            <h6 class="no-bottom-margin">Price</h6>
                        </li>
                    </ul>
                </div>
                <div class="row bottom-border-1 padding-top-10">
    {{-- STEP 1 --}}
                    <div id="tab-content-1" class="form-group col-sm-offset-2 col-sm-8">
                        {{ Form::open(['class'=>'stepform', 'data-parsley-validate'])}}
                            {{--<div class="row form-group">--}}
                                {{--<div class="col-sm-3 text-right no-side-padding ">--}}
                                    {{--{{ Form::label('trip_type_label', 'Trip type') }}--}}
                                {{--</div>--}}
                                {{--<div class="col-sm-8 text-left ">--}}
                                    {{--{{ Form::select('trip_type_dum', Config::get('enums.trip_types'), $trip->trip_type, ['class' => 'form-control']) }}--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="row form-group">
                                <div class="col-sm-3 text-right no-side-padding ">
                                    {{ Form::label('from_label', 'From') }}
                                </div>
                                <div class="col-sm-8 text-left">
                                    {{ Form::text('route_from_dum', $trip->route_from . ', ' . $trip->country_from,
                                     ['id' => 'main_route_from_input', 'class' => 'form-control waypoint',
                                                'data-parsley-required' => 'true',
                                                'data-parsley-trigger' => 'keyup',
                                                'data-parsley-validation-threshold' => '0']) }}
                                </div>
                            </div>
                            <div id="stops_content" class="form-group">
                                {{-- stop-point container --}}
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-8 col-sm-offset-3 text-left">
                                    {{ HTML::link('#', '+ Add stop-point', ['id' => 'stop_add_btn']) }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3 text-right no-side-padding">
                                    {{ Form::label('to_label', 'To') }}
                                </div>
                                <div class="col-sm-8 text-left ">
                                    {{ Form::text('route_to_dum', $trip->route_to . ', ' . $trip->country_to,
                                     ['id' => 'main_route_to_input', 'class' => 'form-control waypoint',
                                                'data-parsley-required' => 'true',
                                                'data-parsley-trigger' => 'keyup',
                                                'data-parsley-validation-threshold' => '0']) }}
                                </div>
                            </div>
                            <div class="row no-side-padding padding-top-10">
                                <div class="col-sm-2 col-sm-offset-8 no-side-padding text-center">
                                    {{ Form::submit('Next >', ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
    {{-- STEP 2 --}}
                    <div id="tab-content-2" class="col-sm-offset-2 col-sm-8">
                        {{ Form::open(['class'=>'stepform', 'data-parsley-validate'])}}
                            <div class="row form-group no-bottom-margin">
                                <div class="col-sm-4 text-right no-side-padding">
                                    <h4>{{ Form::label('start_trip_label', 'Start of the ride', ['class' => 'no-side-padding']) }}</h4>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-offset-3 col-sm-8 text-left ">
                                  <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon calendar-icon"></span></span>
                                    {{ Form::text('start_date_dum', $trip->date,
                                        ['id' => 'datepicker-start_date', 'class' => 'form-control text-center date-field',
                                        'placeholder' => 'When do you go?',
                                        'readonly',
                                        'data-parsley-required' => 'true'])
                                    }}
                                  </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-offset-3 col-sm-8 text-left ">
                                    <div class="inline-block">
                                        {{ Form::select('start_hour_dum', Config::get('enums.hours'), $trip->time_hours,['class' => 'form-control']) }}
                                    </div>
                                    <div class="inline-block">
                                        {{ Form::select('start_minutes_dum', Config::get('enums.minutes'), $trip->time_minutes, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row no-side-padding padding-top-10">
                                <div class="col-sm-2 no-side-padding text-center">
                                    {{ Form::button('< Back', ['class' => 'btn btn-default prevBtn']) }}
                                </div>
                                <div class="col-sm-2 col-sm-offset-8 no-side-padding text-center">
                                    {{ Form::submit('Next >', ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
    {{-- STEP 3 --}}
                    <div id="tab-content-3" class="col-sm-offset-2 col-sm-8">
                        {{ Form::open(['class'=>'stepform', 'data-parsley-validate'])}}
                            <div class="row form-group">
                                <div class="col-sm-3 text-right no-side-padding">
                                    {{ Form::label('seats_label', 'Seats') }}
                                    <br />
                                    (without the driver)
                                </div>
                                <div class="col-sm-8 text-left ">
                                    {{ Form::select('seats_dum', $seats, $trip->seats_total,
                                            ['id' => 'seatsField', 'class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3 text-right no-side-padding">
                                    {{ Form::label('luggage_label', 'Luggage') }}
                                </div>
                                <div class="col-sm-8 text-left ">
                                    {{ Form::select('luggage_dum', Config::get('enums.luggage_sizes'), $trip->luggage_size, ['class' => 'form-control']) }}
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3 text-right no-side-padding">
                                    {{ Form::label('preferences_label', 'You would like...') }}
                                </div>
                                <div class="col-sm-8 text-left ">
                                    <div class="row form-group no-bottom-margin">
                                        <div class="col-sm-1 text-left ">
                                            {{ Form::checkbox('chat_allowed', null, $trip->chat_allowed); }}
                                        </div>
                                        <div class="col-sm-8 text-left ">
                                            To chat<br/>
                                        </div>
                                    </div>
                                    <div class="row form-group no-bottom-margin">
                                        <div class="col-sm-1 text-left ">
                                            {{ Form::checkbox('music_allowed', null, $trip->music_allowed); }}
                                        </div>
                                        <div class="col-sm-8 text-left ">
                                            Listen to music<br/>
                                        </div>
                                    </div>
                                    <div class="row form-group no-bottom-margin">
                                        <div class="col-sm-1 text-left ">
                                            {{ Form::checkbox('smoking_allowed', null, $trip->smoking_allowed); }}
                                        </div>
                                        <div class="col-sm-8 text-left ">
                                            Smoking allowed<br/>
                                        </div>
                                    </div>
                                    <div class="row form-group no-bottom-margin">
                                        <div class="col-sm-1 text-left ">
                                            {{ Form::checkbox('children_allowed', null, $trip->children_allowed); }}
                                        </div>
                                        <div class="col-sm-8 text-left ">
                                            Children are welcome<br/>
                                        </div>
                                    </div>
                                    <div class="row form-group no-bottom-margin">
                                        <div class="col-sm-1 text-left ">
                                            {{ Form::checkbox('animals_allowed', null, $trip->animals_allowed); }}
                                        </div>
                                        <div class="col-sm-8 text-left ">
                                            Animals are welcome<br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3 text-right no-side-padding">
                                    {{ Form::label('comments_label', 'Pick-up point and comments') }}
                                </div>
                                <div class="col-sm-8 text-left ">
                                    {{ Form::textarea('additional_info_dum', $trip->additional_info,
                                                        ['class' => 'form-control',
                                                        'placeholder' => 'eg. where exactly you meet, drop-off points...',
                                                        'rows' => 5,
                                                        'cols' => 50,
                                                        'data-parsley-trigger' => 'keyup',
                                                        'data-parsley-required' => 'true',
                                                        'data-parsley-validation-threshold' => '0',
                                                        'data-parsley-length' => '[50, 200]'])
                                                    }}
                                    <br/>
                                    <small><i>Do NOT write your email address and phone number in this field. Use your profile instead.
                                    This way only registered and confirmed users can access your contact details.</i></small>
                                </div>
                            </div>
                            <div class="row no-side-padding padding-top-10">
                                <div class="col-sm-2 no-side-padding text-center">
                                    {{ Form::button('< Back', ['class' => 'btn btn-default prevBtn']) }}
                                </div>
                                <div class="col-sm-2 col-sm-offset-8 no-side-padding text-center">
                                    {{ Form::submit('Next >', ['class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
    {{-- STEP 4 --}}
                    <div id="tab-content-4" class="col-sm-offset-2 col-sm-8">
                        {{ Form::open(['route' => ['trips.update', $trip->id], 'method' => 'put', 'data-parsley-validate',
                                'id'=>'offer_trip_form'])}}
                            <div class="row form-group">
                                <div class="col-sm-8 text-left no-side-padding">
                                    {{ Form::label('main_route', $trip->route_from . ' > ' . $trip->route_to) }}
                                </div>
                                <div class="col-sm-3 text-right no-side-padding">
                                    {{ Form::text('price', $trip->price,
                                        ['class' => 'form-control trip_price_input_width',
                                        'data-parsley-trigger' => 'keyup',
                                        'data-parsley-required' => 'true',
                                        'data-parsley-type' => 'integer',
                                        'data-parsley-validation-threshold' => '0',
                                        'data-parsley-min' => '1',
                                        'data-parsley-minlength' => '1'])
                                    }}
                                </div>
                                <div class="col-sm-1 text-left no-side-padding">
                                    {{ Form::label('price_label', 'DKK') }}
                                </div>
                            </div>
                            <div id="stops_labels_prices_content" class="row form-group">
                                {{--stop-points-container--}}
                            </div>
                            Distance: {{ Form::label('distance', '', ['id' => 'distance_label']) }}
                            <br/>
                            Duration: {{ Form::label('duration', '', ['id' => 'duration_label']) }}
                            <div class="row no-side-padding padding-top-10">
                                <div class="col-sm-2 no-side-padding text-center">
                                    {{ Form::button('< Back', ['class' => 'btn btn-default prevBtn']) }}
                                </div>
                                <div class="col-sm-2 col-sm-offset-8 no-side-padding text-center">
                                    {{ Form::submit('Save it!', ['id' => 'finishBtn', 'class' => 'btn btn-success']) }}
                                </div>
                            </div>
                            {{--{{ Form::hidden('trip_type') }}--}}
                            {{ Form::hidden('route_from') }}
                            {{ Form::hidden('route_to') }}
                            {{ Form::hidden('start_date') }}
                            {{ Form::hidden('start_hour') }}
                            {{ Form::hidden('start_minutes') }}
                            {{ Form::hidden('seats') }}
                            {{ Form::hidden('luggage') }}
                            {{ Form::hidden('additional_info') }}
                            {{ Form::hidden('distance', null, ['id' => 'distance']) }}
                            {{ Form::hidden('duration', null, ['id' => 'duration']) }}

                        {{ Form::close() }}
                    </div>
                </div>
                @else
                    <h3>Whoops, looks like you removed the vehicle from your profile...</h3>
                    <br />
                    You must have a vehicle set up to your profile in order to be able to manage trips.
                    <br />
                    You can do that by going to the <a href="{{ URL::route('account.edit', ['id' => Auth::id()]) }}">Edit profile</a>
                    page and add a vehicle to your profile.
                @endif
            @else
                <h3>You must confirm your account in order to be able to manage trips.</h3>
                </br>
                You can do that by going to the <a href="{{ URL::route('account.editAccount', ['id' => Auth::id()]) }}">Account</a>
                page and <i>Resend an activation email</i>.
            @endif
        </div>
{{-- Google Maps --}}
        <div class="col-md-6 col-lg-4 no-side-padding">
            <div id="map" class="col-lg-12 text-center">
            </div>
            <div><i>This route is automatically suggested by Google Maps. The real route may differ.</i></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-offset-7 col-md-3"></div>
    </div>
    {{ HTML::script('../js/custom/offer_edit_trip_tabs.js') }}
@stop
