<?php

class Statistics extends \Eloquent {

    protected $table = 'statistics';
    protected $hidden = [
        'km_traveled',
        'co_saved',
        'passengers_driven',
        'trips_taken'
    ];
    protected $fillable = [];
}