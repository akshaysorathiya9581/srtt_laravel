<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passport extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

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
