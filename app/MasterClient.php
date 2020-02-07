<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterClient extends Model
{
    protected $fillable = [
        'f_name','m_name','l_name','place','dob','gender'
    ];

    
}
