<?php

namespace App;

use App\Functions\ImagesFunctions;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $timestamps = false;
    protected $fillable = ['name',
        'category_id',
        'details',
        'logo',
        'user_id',
        'address',
        'city_id',
        'is_deleted'];

    public function getTranslateName($local){
        $name = "";
        try {
            $array = json_decode($this->name,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateAddress($local){
        $name = "";
        try {
            $array = json_decode($this->address,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateDetails($local){
        $name = "";
        try {
            $array = json_decode($this->details,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }
    protected $appends = ['logo_path'];

    public function getLogoPathAttribute(){
        return asset('public/uploads/stores/'.$this->logo);
    }

    public function getImageSize($size_width, $size_height)
    {
        $image = $this->logo_path;
        if($image!=''){
            $image = str_replace(asset('public/uploads/stores').'/', '', $image);
            if(strpos($image, 'placeholder.png')){
                return $image;
            }
            $images_functions = new ImagesFunctions();
            $new_image = $images_functions->getNewSizeFromImage('stores', $image, $size_width, $size_height);
            if($new_image!=''){
                return asset('public/uploads/stores/' . $new_image);
            } else {
                return '';
            }
        } else {
            return '';
        }
    }//end of image path attribute
}
