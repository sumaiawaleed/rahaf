<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Dollar extends Model
{
    protected $table = "doller_cost";
    public $timestamps = false;
    protected $fillable = ['the_cost'];
}
