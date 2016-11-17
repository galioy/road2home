@extends('shared.master_layout')

@section('content')

    <div class="row padding-top-10">
        <div class="col-md-offset-4 col-md-4 text-center">
            <h2>Hey, {{ $user->name }}! <br />Resetting the password, huh?</h2>
            {{ Form::open(['action' => 'RemindersController@postReset', 'data-parsley-validate']) }}
                <div class="form-group ">
                    {{ Form::hidden('token', $token) }}
                    {{ Form::hidden('email', $email) }}
                </div>
                <div class="form-group">
                    {{Form::password('password',
                        ['id' => 'password',
                        'class' => 'form-control text-center',
                        'placeholder' => 'New password',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-required'=>'true',
                        'data-parsley-minlength' => '6',
                        'data-parsley-errors-container'=>'#error-message-password'])
                    }}
                </div>
                <div class="form-group">
                    {{ Form::password('password_confirmation',
                        ['class' => 'form-control text-center',
                        'placeholder' => 'Repeat password',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-required'=>'true',
                        'data-parsley-equalto' => '#password'])
                    }}
                </div>
                <div class="form-group text-right">
                    {{ Form::submit('Reset!', ['class' => 'btn btn-primary']) }}
                </div>
            {{ Form::close() }}
            @if (Session::has('error'))
                <p style="color: red;">{{ Session::get('error') }}</p>
            @elseif (Session::has('status'))
                <p style="color: #3058ff;">{{ Session::get('status') }}</p>
                {{ Redirect::route('home') }}
            @endif
        </div>
    </div>

@stop