<?php

class Passenger extends \Eloquent {

    protected $table = 'trip_passengers';

    protected $hidden = [
        'id',
        'trip_id',
        'user_ud'
    ];

    protected $fillable = [];
}