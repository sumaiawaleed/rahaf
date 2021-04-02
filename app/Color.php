<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = "color";
    public $timestamps = false;
    protected $fillable = ["color","name","a_name","type","notes"];

    public function getTranslateName($local = ""){
        $local = app()->getLocale();
        if($local == 'ar'){
            return $this->a_name;
        }else{
            return $this->name;
        }
    }
}
