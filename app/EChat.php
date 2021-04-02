<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class EChat extends Model
{
    protected $table = 'e_chat';
    protected $fillable  = ["user_id","last_msg",'date','admin_token','not_seen'];

    public $timestamps = false;
}
