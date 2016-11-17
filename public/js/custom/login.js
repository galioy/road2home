$(function () {

    $('.login-form').on('submit', function () {
        console.log("Submitting login data...");
        $('#loginModal .loader-overlay').fadeIn();

        $token = $(this).find('input[name=_token]').val()
        $email = $("[name='email']").val();
        $password = $("[name='password']").val();
        $.post(
            $(this).prop('action'), {
                "_token": $token,
                "email": $email,
                "password": $password
            },
            function (data) {
                if (data['status'] == 'error') {
                    $('#error-message').html(data['msg']);
                    $('#error-message').fadeIn();
                    $('#loginModal .loader-overlay').fadeOut();
                }

                if (data['status'] == 'success') {
                    setTimeout("window.location.href='/';", 0);
                }
            },
            'json'
        );
        return false;
    });

});
