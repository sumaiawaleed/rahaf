<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = FALSE;
    protected $fillable = ['name','a_name','details','a_details','link'];

    public function getTranslateName(){
        $local = app()->getLocale();
        if($local == 'ar'){
            return $this->a_name;
        }else{
            return $this->name;
        }
    }

    public function getTranslateDetail(){
        $local = app()->getLocale();
        if($local == 'ar'){
            return $this->a_details;
        }else{
            return $this->details;
        }
    }
}
