<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
    protected $table = "user_contacts";
    protected $fillable = ["user_id","contact_id","value","is_visible"];
    public $timestamps = false;
}
