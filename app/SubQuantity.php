<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class SubQuantity extends Model
{
    protected $table = "sub_quantity";
    public $timestamps = false;
    protected $fillable = ["name","a_name","quantity_id"];

    public function getTranslateName($local){
        if($local == 'ar'){
            return $this->a_name;
        }else{
            return $this->name;
        }
    }
}
