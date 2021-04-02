<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = "driver";
    public $timestamps = false;
    protected $fillable = ['name','phone'];
}
