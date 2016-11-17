<!-- Button trigger modal -->
<a href='#' type="button" data-toggle="modal" data-target="#loginModal">
    Login
</a>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="loader-overlay">
                <span class="img-vertical-middle-helper"></span>
                <img src="images/ajax-loader.gif" class="loading-gif" alt=""/>
            </div>
            {{ Form::open(['action'=>'ajax.login','class'=>'login-form','data-parsley-validate','method'=>'post']) }}
            <div class="modal-body">

                <div id="error-message">

                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </br>
                <div class="form-group">
                    {{ Form::email('email', null,
                        ['class' => 'form-control',
                        'placeholder' => 'Email',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-type' => 'email',
                        'data-parsley-errors-container' => '#error-message-email',
                        'data-parsley-required' => 'true'])
                    }}
                    <div id="error-message-email"></div>
                </div>
                <div class="form-group">
                    {{ Form::password('password',
                        ['class'=>'form-control',
                        'placeholder' => 'Password',
                        'data-parsley-trigger' => 'focusout',
                        'data-parsley-required' => 'true',
                        'minlength' => '6',
                        'data-parsley-errors-container' => '#error-message-password']) }}
                    <div id="error-message-password"></div>
                </div>
                <div id="forgotten-password-link" class="form-group text-right">
                    {{ HTML::linkAction('RemindersController@postRemind', 'Forgot your password, eh? :)') }}
                </div>
            </div>
            {{ Form::submit('Enter!', ['id'=>'login-button','class'=>'btn btn-default btn-success no-rounded-corners' ]) }}
            {{ Form::close() }}
        </div>
    </div>
</div>