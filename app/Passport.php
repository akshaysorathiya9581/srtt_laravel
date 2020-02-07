<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    public function clientDetails()
    {
    	return $this->hasOne('App\MasterClient','id','client_id');
    }
}
