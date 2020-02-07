<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterClientSuggestion extends Model
{
	public $timestamps = false;
    protected $fillable = [
        'client_id','cont_coun_code','phone_number','whas_coun_code','wtsapp_no','email'
    ];
    
}
