<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $table = "favourite";
    public $timestamps = false;
    protected $fillable = [
        "user_id",
        "product_id"
    ];
}
