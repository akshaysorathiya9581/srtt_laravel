<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipCard extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function clientDetails()
    {
    	return $this->hasOne('App\MasterClient','id','client_id');
    }

    public function airlineDetails()
    {
    	return $this->hasOne('App\Airlinelist','id','airline_id');
    }

    public function createdBy()
    {
    	return $this->hasOne('App\User','id','created_by');
    }
    public function updatedBy()
    {
    	return $this->hasOne('App\User','id','updated_by');
    }
}
