<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = "user";
    protected $fillable = ["name", "phone", "country_code", "lat", 'log', 'address', 'gender', 'password','remember_token','token'];
    public $timestamps = false;
}
