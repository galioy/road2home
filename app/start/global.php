<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories([

    app_path() . '/commands',
    app_path() . '/controllers',
    app_path() . '/models',
    app_path() . '/database/seeds',
    app_path() . '/classes',
]);

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path() . '/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function (Exception $exception, $code) {
    Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function () {
    return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path() . '/filters.php';

//Custom helper macros
HTML::macro('UserEmailCredentials', function ($user) {
    $UserEmailCredentials = str_replace('@via.dk', '', $user->email);

    return $UserEmailCredentials;
});

/**
 * Checks if the given profile picture for the user exists, and if it does it returns the path to it.
 * If the picture does not exist, then a default picture path is returned depending if the user is male or female.
 *
 * @input array $user - the user model
 * @return string path to an image
 */
HTML::macro('ProfilePicPath', function ($email, $gender) {
    $user_email = str_replace("@via.dk", '', $email);

    if (file_exists('images/profiles/' . $user_email . '/profile.jpg')) {
        return 'images/profiles/' . $user_email . '/profile.jpg';
    } else {
        if ($gender == 'Male') {
            return '/images/profiles/default_profile_m.png';
        } else {
            return '/images/profiles/default_profile_f.png';
        }
    }
});

/**
 * Checks if the given vehicle picture for the user exists, and if it does it returns the path to it.
 * If the picture does not exist, then a default picture is returned.
 *
 * @input array $user - the user model
 * @input array $vehicle - the vehicle for which the picture is sought
 * @return string path to an image
 */
HTML::macro('VehiclePic', function ($email, $vehicle_id) {

    $user_email = str_replace('@via.dk', '', $email);

    if ($vehicle_id) {
        if (file_exists('images/profiles/' . $user_email . '/vehicle_' . $vehicle_id . '.jpg')) {
            return '/images/profiles/' . $user_email . '/vehicle_' . $vehicle_id . '.jpg';
        } else {
            return '/images/profiles/default_vehicle.png';
        }
    } else {
        return '/images/profiles/default_vehicle.png';
    }
});

/**
 * @input string $preference - the preference/detail for which an icon (circled image) should be shown
 */
HTML::macro('Icon', function ($preference) {
    switch ($preference) {
        case('smoking'):
            return '/images/icons/smoking.jpg';
        case('no-smoking'):
            return '/images/icons/no_smoking.jpg';
        case('music'):
            return '/images/icons/music.jpg';
        case('no-music'):
            return '/images/icons/no_music.jpg';
        case('pets'):
            return '/images/icons/pets.png';
        case('no-pets'):
            return '/images/icons/no_pets.png';
        case('children'):
            return '/images/icons/children.png';
        case('no-children'):
            return '/images/icons/no_children.png';
        case('chat'):
            return '/images/icons/chat.png';
        case('no-chat'):
            return '/images/icons/no_chat.jpg';
        case('women-only'):
            return '/images/icons/women_only.png';
        case('slow_speed'):
            return '/images/icons/slow_speed.png';
        case('normal_speed'):
            return '/images/icons/normal_speed.png';
        case('fast_speed'):
            return '/images/icons/fast_speed.jpg';
        case('seat_free'):
            return '/images/icons/seat_free.png';
        case('seat_taken'):
            return '/images/icons/seat_taken.png';
    }
});

/**
 * Replaces {? ?} with <?php ?>
 * This is with the purpose to allow writing php code inside the views, because {{ }} by default echoes
 * the written php code inside of it.
 * @input [php code] $value - the php code chunk that you would like to include in the view
 *
 * @return <?php $value ?>
 */
Blade::extend(function ($value) {
    return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
});