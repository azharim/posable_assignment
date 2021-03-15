<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developers extends Model
{
    protected $table = "developers";
    public $timestamps = true;

    protected $fillable = [
		    'first_name',
        'last_name',
        'email',
        'phone_num',
        'address',
        'avatar'
	];
}
