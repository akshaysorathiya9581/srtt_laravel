<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    protected $fillable = [
        'client_id','passport_number','issue_date','issue_place','expiry_date','ecr','country_id','attached','status','created_by','updated_by','deleted_by'
    ];

    public function clientDetails()
    {
    	return $this->hasOne('App\MasterClient','id','client_id');
    }

    public function countryDetails()
    {
    	return $this->hasOne('App\Countrie','id','country_id');
    }
}
