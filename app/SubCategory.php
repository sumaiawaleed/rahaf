<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = "sub_category";
    public $timestamps = false;
    protected $fillable = ["name","a_name","img","cat_id"];

    protected $appends = ["image_path","main_category"];


    public function getImagePathAttribute(){
        return asset("public/uploads/categories/".$this->img);
    }

    public function getMainCategoryAttribute(){
        return Category::find($this->cat_id);
    }

    public function getTranslateName($local){
        if($local == 'ar'){
            return $this->a_name;
        }else{
            return $this->name;
        }
    }
}
