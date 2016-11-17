@extends('shared.master_layout')

@section('content')

    <div class="row padding-top-10">
        <div class="col-md-offset-4 col-md-4 text-center">
            <h4>We will send you an email with instructions to reset your password...</h4>
            {{ Form::open(['action' => 'RemindersController@postRemind', 'data-parsley-validate']) }}
                <div class="form-group ">
                    {{ Form::email('email', null,
                    ['class' => 'form-control text-center',
                    'placeholder' => 'Your Email',
                    'data-parsley-trigger' => 'focusout',
                    'data-parsley-type' => 'email',
                    'data-parsley-required'=>'true',]) }}
                </div>
                <div class="form-group text-right">
                    {{ Form::submit('Reset!', ['class' => 'btn btn-primary']) }}
                </div>
            {{ Form::close() }}
            @if (Session::has('error'))
                <p style="color: red;">{{ Session::get('error') }}</p>
            @elseif (Session::has('status'))
                <p style="color: #3058ff;">{{ Session::get('status') }}</p>
            @endif
        </div>
    </div>

@stop