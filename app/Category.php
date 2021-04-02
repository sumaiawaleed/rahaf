<?php

namespace App;
use App\Functions\ImagesFunctions;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    public $timestamps = false;
    protected $fillable = ["name","a_name","img","cat_type",'main_cat_id','status'];

    protected $appends = ["image_path","main_category"];

    public function getImagePathAttribute(){
        if($this->img)
            return asset("public/uploads/categories/".$this->img);
        else
            return asset('public/uploads/photo.svg');
    }

    public function getMainCategoryAttribute(){
        return MainCategory::find($this->cat_type);
    }

    public function getTranslateName($local = ""){
        $local = app()->getLocale();
        if($local == 'ar'){
            return $this->a_name;
        }else{
            return $this->name;
        }
    }

    public function getImageSize($size_width, $size_height)
    {
        $image =  asset('public/uploads/categories/' . $this->img);
        if($image!=''){
            $image = str_replace(asset('public/uploads/categories').'/', '', $image);
            if(strpos($image, 'placeholder.png')){
                return $image;
            }
            $images_functions = new ImagesFunctions();
            $new_image = $images_functions->getNewSizeFromImage('categories', $image, $size_width, $size_height);
            if($new_image!=''){
                return asset('public/uploads/categories/' . $new_image);
            } else {
                return asset('public/uploads/photo.svg');
            }
        } else {
            return asset('public/uploads/photo.svg');
        }
    }//end of image path attribute

}
