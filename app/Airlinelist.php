<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airlinelist extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function airlineGroup()
    {
        return $this->belongsTo('App\AirlineGroup');
    }
}
