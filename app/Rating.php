<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = "ratings";
    protected $fillable = ['pr_id','user_id','rate','comment','the_date'];
    public $timestamps = false;
}
