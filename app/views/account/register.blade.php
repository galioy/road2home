@extends('shared.master_layout')

@section('content')
    <div id="register-container" class="row padding-top-10">
        {{ Form::open(['route' => 'account.store', 'data-parsley-validate']) }}
        <div class="col-md-3 col-sm-offset-3">
            <div class="form-group">
                {{ Form::text('name', null,
                    ['class' => 'form-control',
                    'placeholder' => 'Name',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-required' => 'true',
                    'data-parsley-pattern' => '^[A-Za-z ]+$',
                    'data-parsley-length' => '[2, 20]',
                    'data-parsley-validation-threshold' => '0',
                    'data-parsley-errors-container'=>'#error-message-name'])
                }}
                {{ $errors->first('name', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group">
                {{ Form::text('surname', null,
                    ['class' => 'form-control',
                    'placeholder' => 'Surname',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-required' => 'true',
                    'data-parsley-pattern' => '^[A-Za-z ]+$',
                    'data-parsley-length' => '[2, 20]',
                    'data-parsley-validation-threshold' => '0',
                    'data-parsley-errors-container'=>'#error-message-surname'])
                }}
                {{ $errors->first('surname', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group">
                {{ Form::select('university', $universities_names , null, ['class' => 'form-control']) }}
                {{ $errors->first('university', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group">
                <div class="inline-block">
                    {{ Form::text('country_code', null,
                        ['id' => 'country-code', 'class' => 'form-control',
                        'placeholder' => '45',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-required' => 'true',
                        'data-parsley-type' => 'digits',
                        'data-parsley-length' => '[2,5]',
                        'data-parsley-errors-container' => '#error-message-country_code'])
                    }}
                </div>
                <div class="inline-block">
                    {{ Form::text('phone_number', null,
                        ['id' => 'phone-number', 'class' => 'form-control',
                        'placeholder' => 'Your mobile phone number',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-required' => 'true',
                        'data-parsley-type' => 'digits',
                        'data-parsley-length' => '[6,12]',
                        'data-parsley-errors-container' => '#error-message-phone_number'])
                    }}
                    {{ $errors->first('phone_number', '<span class="label label-warning">:message</span>') }}
                </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon calendar-icon"></span></span>
                {{ Form::text('birthdate', null,
                    ['class' => 'form-control text-center datepicker-registration date-field',
                    'readonly',
                    'placeholder' => 'Birth date',
                    'data-parsley-required' => 'true'])
                }}
              </div>
                {{ $errors->first('birthdate', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group">
                <div class="inline-block">
                    {{ Form::label('gender', 'I am a ') }}
                </div>
                <div class="inline-block">
                    {{ Form::select('gender', Config::get('enums.gender'), null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group">
                <div class="inline-block">
                    {{ Form::label('smoker','I do') }}
                </div>
                <div class="inline-block">
                    {{Form::select('smoker', [0 => 'not smoke', 1 => 'smoke'], null ,['class'=>'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                <div class="inline-block">
                    {{ Form::label('driving_style', 'I like to drive ') }}
                </div>
                <div class="inline-block">
                    {{ Form::select('driving_style', Config::get('enums.driving_style'), null, ['class' => 'form-control']) }}
                </div>
            </div>
        </div>
        {{--<div class="col-md-1">--}}

        {{--</div>--}}
        <div class="col-md-3 text-right">
            <div class="form-group">
                {{ Form::textarea('bio', null,
                    ['id' => 'bio', 'class' => 'form-control',
                    'placeholder' => 'A bit about yourself...',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-required' => 'true',
                    'data-parsley-validation-threshold' => '0',
                    'data-parsley-length' => '[50, 150]',
                    'data-parsley-error-container' => '#error-message-bio'])
                }}
                {{ $errors->first('bio', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group">
                <div class="inline-block">
                    {{ Form::text('email', null,
                        ['id' => 'email-field', 'class' => 'form-control',
                        'placeholder' => 'Email (stud. number)',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-type' => 'digits',
                        'data-parsley-required'=>'true',
                        'data-parsley-length' => '[6, 6]'])
                    }}
                </div>
                <div class="inline-block">
                    {{ Form::select('domain', Config::get('enums.domains'), null, ['class' => 'form-control']) }}
                </div>
                {{ $errors->first('email', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group">
                {{Form::password('password',
                    ['id' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                    'data-parsley-trigger' => 'focusout',
                    'data-parsley-required'=>'true',
                    'data-parsley-minlength' => '6'])
                }}
                {{ $errors->first('password', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group">
                {{ Form::password('password_repeat',
                    ['class' => 'form-control',
                    'placeholder' => 'Repeat password',
                    'data-parsley-trigger' => 'focusout',
                    'data-parsley-required'=>'true',
                    'data-parsley-equalto' => '#password'])
                }}
                {{ $errors->first('password_repeat', '<span class="label label-warning">:message</span>') }}
            </div>
            <div class="form-group no-bottom-margin no-padding-bottom">
                <p class="terms-text inline-block no-bottom-margin no-padding-bottom">
                    I understand and accept the
                    {{ HTML::link('#', ' terms and conditions', ['id' => 'termsLink',
                        'data-toggle' => 'modal',
                        'data-target' => '#termsModal'])
                    }}
                    .
                </p>
                {{ Form::checkbox('terms_and_conditions', '', false,
                    ['class' => 'inline-block',
                    'data-parsley-required'=>'true'])
                }}
                @include('shared.legal.terms_and_conditions')
            </div>
            <div class="form-group no-bottom-margin no-padding-bottom">
                <p class="terms-text inline-block no-bottom-margin no-padding-bottom">
                    I understand and accept the
                    {{ HTML::link('#', ' general rules', ['id' => 'rulesLink',
                        'data-toggle' => 'modal',
                        'data-target' => '#rulesModal'])
                    }}
                    .
                </p>
                {{ Form::checkbox('rules', '', false,
                    ['class' => 'inline-block',
                    'data-parsley-required'=>'true'])
                }}
                @include('shared.legal.general_rules')
            </div>
            <div class="form-group">
                {{ Form::submit('Register me!', ['class' => 'btn btn-md btn-primary button-width-250']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
@stop
