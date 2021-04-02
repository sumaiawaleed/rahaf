<?php

namespace App;

use App\Functions\ImagesFunctions;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = "contacts";
    protected $fillable = ["name","icon","type"];
    protected $appends = ["icon_path"];

    public function get_type(){
        if($this->type == 1){
            return "tel";
        }else if($this->type == 2){
            return "app";
        }else if($this->type == 3){
            return "url";
        }
    }

    public function getIconPathAttribute()
    {
        return $this->icon != '' ?  asset('public/uploads/contacts/' . $this->icon) :  asset('public/uploads/photo.svg');
    }

    public function getImageSize($size_width, $size_height)
    {
        $image =  asset('public/uploads/contacts/' . $this->icon);
        if($image!=''){
            $image = str_replace(asset('public/uploads/contacts').'/', '', $image);
            if(strpos($image, 'placeholder.png')){
                return $image;
            }
            $images_functions = new ImagesFunctions();
            $new_image = $images_functions->getNewSizeFromImage('contacts', $image, $size_width, $size_height);
            if($new_image!=''){
                return asset('public/uploads/contacts/' . $new_image);
            } else {
                return asset('public/uploads/photo.svg');
            }
        } else {
            return asset('public/uploads/photo.svg');
        }
    }//end of image path attribute

    public function getTranslateName($local){
        $name = "";
        try {
            $array = json_decode($this->name,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }
}
