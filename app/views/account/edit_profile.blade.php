@extends('shared.master_layout')

@section('content')
<div class="container edit-profile-page">
    {{ Form::model($user, ['id'=>'edit_profile_form','route' => ['account.update', $user->id], 'method' => 'put', 'data-parsley-validate', 'files'=>true]) }}
    {{Form::hidden('id')}}
    <div style="display:block">
        <div class="row">
            {{--Profile info--}}
            <div class="col-sm-6 ">
                <div class="col-sm-8 no-side-padding padding-right-10">
                    <div>
                        {{ Form::label('name','First name:') }}
                        <h2 class="col-sm-12 no-side-padding">{{Form::text('name',null,
                            ['class'=>'col-sm-12 no-side-padding form-control',
                            'placeholder'=>'First name',
                            'data-parsley-trigger' => 'submit',
                            'data-parsley-required' => 'true',
                            'data-parsley-pattern' => '^[A-Za-z ]+$',
                            'data-parsley-length' => '[2, 20]']
                            )}}
                        </h2>
                    </div>
                    <div>
                     {{ Form::label('surname','Surname:') }}
                     <h2 class="col-sm-12 no-side-padding">{{Form::text('surname',null,
                        ['class'=>'col-sm-12 no-side-padding form-control',
                        'placeholder' => 'Surname',
                        'data-parsley-trigger' => 'submit',
                        'data-parsley-required' => 'true',
                        'data-parsley-pattern' => '^[A-Za-z ]+$',
                        'data-parsley-length' => '[2, 20]'])
                    }}</h2>
                </div>
                <div class="row">
                    <div class="inline-block pull-left">
                        {{ Form::label('birthday','Birthday:',array("class"=>"block")) }}
                        {{Form::text('birthdate', null,
                            ['class'=>'col-sm-12 no-side-padding form-control edit-years-input datepicker date-field',
                            'readonly'])}}
                        </div>
                        <div class="is-smoker-icons inline-block pull-left padding-left-10">
                            {{ Form::label('smoker','Smoker:') }}
                            {{Form::select('smoker', [1 => 'Yes', 0 => 'No'],'0',['class'=>'form-control'])}}
                        </div>
                        <div class="is-smoker-icons inline-block pull-left padding-left-10">
                            {{ Form::label('driving_style','Driving style:') }}
                            {{Form::select('driving_style', Config::get('enums.driving_style'),$user->driving_style,['class'=>'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 no-side-padding">
                    <div id="effect-6" class="effects clearfix">
                        <div id="edit-profile-profile-picture" class="img">
                            <img id="profile-picture" src="{{ asset(HTML::ProfilePicPath($user->email, $user->gender)) }}" class="img-circle">
                            <div class="overlay img-circle">
                                <div class="uploadButton">
                                    <input type="file" id="upload-profile-file" name="profile-pic"
                                    style="width: 88px; opacity:0.0; filter:alpha(opacity=0); "/>
                                    <a id="upload-profile-pic-btn" href="#" class="expand">Upload</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-sm-7 no-side-padding padding-top-10">
                    {{ Form::label('university','University:', array("class"=>"edit-university-label")) }}
                    {{Form::text('university',null,
                        ['class'=>'col-sm-4 no-side-padding edit-university-input form-control',
                        'placeholder' => 'University',
                        'data-parsley-trigger' => 'submit',
                        'data-parsley-required' => 'true',
                        'data-parsley-pattern' => '^[A-Za-z ]+$'])
                    }}
                </div>
                <div class="col-sm-12 no-side-padding">
                    {{ Form::textarea('bio', $user->university,
                        ['class' => 'profile-bio form-control',
                        'placeholder' => 'A bit about yourself...',
                        'data-parsley-trigger' => 'submit',
                        'data-parsley-required' => 'true',
                        'data-parsley-length' => '[50, 150]'])
                    }}
                </div>
            </div>

            {{--Car info--}}
            <div class="col-sm-6 no-side-padding cars">
                @if(!$user->Vehicles->isEmpty())
                {{'';$i=0}}
                @foreach($user->Vehicles as $vehicle)
                <div class="col-sm-12 car-details-container">
                    <div class="col-sm-8 no-side-padding">
                        <div>
                            {{ Form::label('make','Make:') }}
                            <h2 class="car-make-and-model"
                            class="padding-right-10">
                            {{Form::text('Vehicles['.$vehicle->id.'][make]', $vehicle->make,
                                ['class'=>'col-sm-12 no-side-padding form-control',
                                'placeholder'=>'Make',
                                'data-parsley-pattern' => '^[A-Za-z ]+$',
                                'data-parsley-trigger' => 'submit',
                                'data-parsley-required'=>'true'])
                            }}
                        </h2>
                    </div>
                    <div>
                        {{ Form::label('model','Model:') }}
                        <h2 class="car-make-and-model">

                            {{Form::text('Vehicles['.$vehicle->id.'][model]', $vehicle->model,
                                ['class'=>'col-sm-12 no-side-padding form-control',
                                'placeholder'=>'Model',
                                'data-parsley-trigger' => 'submit',
                                'data-parsley-required'=>'true'])
                            }}
                        </h2>
                    </div>

                    <div id="car-details" class="car-details inline-block pull-left">
                        <div class="col-sm-8 no-side-padding edit-car-details-label">Year:</div>
                        <div class="col-sm-4 no-side-padding padding-right-10">
                            {{Form::text('Vehicles['.$vehicle->id.'][year]', $vehicle->year,
                                ['class'=>'col-sm-12 no-side-padding form-control',
                                'placeholder'=>'Year',
                                'data-parsley-trigger' => 'submit',
                                'data-parsley-type' => 'digits',
                                'data-parsley-required'=>'true'])
                            }}
                        </div>
                        <div class="col-sm-8 no-side-padding edit-car-details-label">Seats:</div>
                        <div class="col-sm-4 no-side-padding padding-right-10">
                            {{Form::text('Vehicles['.$vehicle->id.'][seats]', $vehicle->seats,
                                ['class'=>'col-sm-12 no-side-padding form-control',
                                'placeholder'=>'Seats',
                                'data-parsley-trigger' => 'submit',
                                'data-parsley-type' => 'digits',
                                'data-parsley-required'=>'true'])
                            }}
                        </div>
                        <div class="col-sm-8 no-side-padding edit-car-details-label">Color:</div>
                        <div class="col-sm-4 no-side-padding padding-right-10">
                            {{Form::text('Vehicles['.$vehicle->id.'][color]', $vehicle->color,
                                ['class'=>'col-sm-12 no-side-padding form-control',
                                'placeholder'=>'Color',
                                'data-parsley-trigger' => 'submit',
                                'data-parsley-pattern' => '^[A-Za-z ]+$',
                                'data-parsley-required'=>'true'])
                            }}
                        </div>
                        <div class="col-sm-8 no-side-padding edit-car-details-label">Type:</div>
                        <div class="col-sm-4 no-side-padding padding-right-10">{{ Form::select('Vehicles['.$vehicle->id.'][type]', Config::get('enums.car_types'),null,['class'=>'form-control']) }}</div>
                    </div>
                </div>
                <div class="col-sm-4 no-side-padding">
                    <div id="effect-6" class="effects clearfix">
                        <div class="img">
                            <img id="vehicle-pic-{{ $vehicle->id }}-img" src="{{ asset(HTML::VehiclePic($user->email, $vehicle->id)) }}" class="img-circle img150-150">

                            <div class="overlay img-circle">
                                <input type="file" id="vehicle-pic-{{ $vehicle->id }}" class="vehicle-pic" name="vehicle_{{$vehicle->id}}"
                                style="width: 88px; opacity:0.0; filter:alpha(opacity=0); "/>
                                <a href="#" class="expand upload-vehicle-pic">Upload</a>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-danger margin-top-10 delete-vehicle-button" name="delete_vehicle" value="{{ $vehicle->id }}" type="submit">Delete this vehicle</button>
                </div>
            </div>
            {{'';$i++}}
            @endforeach
            @else
            <div class="no-vehicles-note"><p>You have no cars right now</p></div>
            <div id="addCarBlock" class="col-sm-12 text-center">
                <a id="addCarButton" href='#' type="button" data-toggle="modal" data-target="#addCarModal" class="btn btn-large btn-primary">
                    Add a car
                    <i class="fa fa-plus add-car-plus-icon"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="edit-profile-actions">
    @if(!$user->Vehicles->isEmpty())
    <a href='#' type="button" data-toggle="modal" data-target="#addCarModal" class="add-car-button btn btn-success">Add a car</a>
    @endif
    {{ Form::submit('Save changes', ['class' => 'btn btn-success']) }}
</div>
</div>
{{ Form::close() }}

<!-- Modal -->
<div class="modal fade" id="addCarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            {{ Form::open(['action'=>'account.newVehicle','class'=>'new-vehicle-form','data-parsley-validate','method'=>'post','files'=>'true']) }}
            <div class="modal-header">
                <h3>Add a new vehicle</h3>
            </div>
            <div class="modal-body">
                <div class="col-md-offset-2 col-sm-6 no-side-padding">
                    <div class="col-md-6 form-group">
                        {{Form::label('make','Make:')}}
                        {{Form::text('make', '',
                            ['class'=>'text-center form-control',
                            'placeholder'=>'Make',
                            'data-parsley-trigger' => 'submit',
                            'data-parsley-required'=>'true'])
                        }}
                    </div>
                    <div class="col-md-6 form-group">
                        {{Form::label('model','Model:')}}
                        {{Form::text('model', '',
                            ['class'=>'text-center form-control',
                            'placeholder'=>'Model',
                            'data-parsley-trigger' => 'submit',
                            'data-parsley-required'=>'true'])
                        }}
                    </div>
                    <span class="clearfix">
                        <div class="col-md-6 form-group">
                            {{Form::text('year', '',
                                ['class'=>'text-center form-control',
                                'placeholder'=>'Year',
                                'data-parsley-trigger' => 'submit',
                                'data-parsley-type' => 'digits',
                                'data-parsley-min' => '1950',
                                'data-parsley-max' => '2015',
                                'data-parsley-required'=>'true'])
                            }}
                        </div>
                        <div class="col-md-6 form-group">
                         {{Form::text('seats', '',
                            ['class'=>'text-center form-control',
                            'placeholder'=>'Seats',
                            'data-parsley-trigger' => 'submit',
                            'data-parsley-type' => 'digits',
                            'data-parsley-min' => '1',
                            'data-parsley-max' => '8',
                            'data-parsley-required'=>'true'])
                        }}
                    </div>
                </span>
                <span class="clearfix">
                    <div class="col-md-6 form-group">
                        {{Form::text('color', '',
                            ['class'=>'text-center form-control',
                            'placeholder'=>'Color',
                            'data-parsley-trigger' => 'submit',
                            'data-parsley-required'=>'true'])
                        }}
                    </div>
                    <div class="col-md-6 form-group">
                        {{ Form::select('type', Config::get('enums.car_types'),null,['class'=>'form-control']) }}
                    </div>
                </span>
            </div>

            <div class="col-sm-4 no-side-padding padding-left-10">
                <div id="effect-6" class="effects clearfix">
                    <div class="img">
                        <img id="vehicle-pic-new-img" src="{{ asset(HTML::VehiclePic('', '')) }}" class="img-circle img150-150">

                        <div class="overlay img-circle">
                            <input type="file" id="vehicle-pic-new" class="vehicle-pic" name="vehicle_new_pic"
                            style="width: 88px; opacity:0.0; filter:alpha(opacity=0); "/>
                            <a href="#" class="expand upload-vehicle-pic">Upload</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer edit-car-footer">
            {{ Form::submit('Save changes', ['class' => 'btn btn-success']) }}
            <input type="button" class="btn btn-danger" value="Close" data-dismiss="modal"/>
        </div>
        {{ Form::close() }}
    </div>
</div>
</div>
@stop