<?php

class University extends \Eloquent {

    protected $table = 'universities';

    protected $hidden = [
        'id'
    ];

    protected $fillable = [
        'name',
        'initials',
        'country',
        'city',
        'address'
    ];

    public function user()
    {
        return $this->belongsTo('User', 'university');
    }
}