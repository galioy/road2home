$(function () {

    function setProfileImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile-picture-big').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function setVehicleImg(input, vehicleId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#' + vehicleId + '-img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#upload-profile-file").change(function () {
        setProfileImg(this);
    });

    $(".vehicle-pic").change(function () {
        id = $(this).attr('id');
        console.log(id);
        setVehicleImg(this, id);
    });

    $('#upload-profile-pic-btn').on('click', function () {
        $('#upload-profile-file').click();
    });

    $('.upload-vehicle-pic').on('click', function () {
        $(this).prev().prev().click();
    });


});
