@extends('shared.master_layout')

@section('content')

    <div class="row padding-top-10">
        <div class="col-md-6 col-md-offset-1">
            <h3>{{ $user->email }}</h3>
            <div class="row padding-top-10">
                <div class="col-md-2">
                    {{ Form::open(['action' => 'RemindersController@postRemind']) }}
                        {{ Form::submit('Reset my password.', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
            @if($user->active)
                <div class="row padding-top-10">
                    <div class="col-md-2 disabled-btn" onmouseover="$showPopout()" onmouseout="$hidePopout()">
                        {{ Form::button('Resend activation email.', ['class' => 'btn btn-success disabled']) }}
                    </div>
                </div>
                <div class="row">
                    <div class="disabled-popout">
                        Your account is already confirmed.
                    </div>
                </div>
            @else
                <div class="row padding-top-10">
                    <div class="col-md-2">
                        {{ Form::open(['action' => 'AccountController@sendActivate']) }}
                            {{ Form::submit('Resend activation email.', ['class' => 'btn btn-success']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            @endif
        </div>

        @if (Session::has('error'))
            <p style="color: red;">{{ Session::get('error') }}</p>
        @elseif (Session::has('status'))
            <p style="color: #3058ff;">{{ Session::get('status') }}</p>
        @endif
    </div>

@stop