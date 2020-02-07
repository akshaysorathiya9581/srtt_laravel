<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class PaxProfile extends Model
{
    protected $fillable = [
        'client_id','meal_preference','seat_preference','created_by','updated_by','deleted_by'
    ];

    public function clientDetails()
    {
    	return $this->hasOne('App\MasterClient','id','client_id');
    }
}
