<?php

namespace Account;

use Vehicle;

class AccountProvider {

    public static function StoreProfilePic($user, $file)
    {
        $UserEmailCredentials = str_replace('@via.dk', '', $user->email);

        if ( ! is_dir('images/profiles/' . $UserEmailCredentials)) {
            mkdir('images/profiles/' . $UserEmailCredentials, 0777, true);
        }
        $path = 'images/profiles/' . $UserEmailCredentials . '/profile.jpg';

        AccountProvider::create_square_image($path, $file, 150);
    }

    public static function StoreVehiclePic($user, $file, $vehicleId)
    {
        $UserEmailCredentials = str_replace('@via.dk', '', $user->email);
        if ( ! is_dir('images/profiles/' . $UserEmailCredentials)) {
            mkdir('images/profiles/' . $UserEmailCredentials, 0777, true);
        }
        $path = 'images/profiles/' . $UserEmailCredentials . '/vehicle_' . $vehicleId . '.jpg';

        AccountProvider::create_square_image($path, $file, 150);
    }

    public static function create_square_image($path, $file, $endSize)
    {
        $image = imagecreatefromjpeg($file);
        list($x, $y) = getimagesize($file);

        // horizontal rectangle
        if ($x > $y) {
            $square = $y;              // $square: square side length
            $offsetX = ($x - $y) / 2;  // x offset based on the rectangle
            $offsetY = 0;              // y offset based on the rectangle
        } // vertical rectangle
        elseif ($y > $x) {
            $square = $x;
            $offsetX = 0;
            $offsetY = ($y - $x) / 2;
        } // it's already a square
        else {
            $square = $x;
            $offsetX = $offsetY = 0;
        }

        $tn = imagecreatetruecolor($endSize, $endSize);

        imagecopyresampled($tn, $image, 0, 0, $offsetX, $offsetY, $endSize, $endSize, $square, $square);
        imagejpeg($tn, $path, 100);

    }


    /**
     * Checks if the currently authenticated user has any vehicles added (set up) to his profile.
     * Returns "true" if yes, otherwise "false".
     *
     * @param int $user_id - the ID of the currently authenticated user.
     *
     * @return bool $has_vehicle
     */
    public static function checkUserHasVehicle($user_id)
    {
        $has_vehicle = true;
        try {
            $vehicles = Vehicle::whereUserId($user_id)->first()->id;
        } catch (\Exception $e) {
            $has_vehicle = false;
        }

        return $has_vehicle;
    }
}
