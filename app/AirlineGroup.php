<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class AirlineGroup extends Model
{
    // use SoftDeletes;
    public $timestamps = true;
    protected $fillable = ['name','created_by','updated_by','deleted_by'];
    
}
