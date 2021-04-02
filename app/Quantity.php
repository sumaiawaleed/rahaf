<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    protected $table = "quantity";
    public $timestamps = false;
    protected $fillable = ["name","a_name","trader_id"];

    public function getTranslateName($local){
        if($local == 'ar'){
            return $this->a_name;
        }else{
            return $this->name;
        }
    }
}
