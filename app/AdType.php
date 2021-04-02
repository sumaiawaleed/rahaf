<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdType extends Model
{
    protected $table ="ad_type";
    protected $fillable = ['name'];
}
