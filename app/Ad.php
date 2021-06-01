<?php

namespace App;

use App\Functions\ImagesFunctions;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table = "advertisement";
    public $timestamps = false;
    protected $fillable = [
        'type',
        'ad_id',
        'img',
       ];
    protected $appends = ["image_path"];

    public function getImagePathAttribute(){
        return asset('public/uploads/advertisements'.$this->img);
    }

    public function getImageSize($size_width, $size_height)
    {
        $image =  asset('public/uploads/advertisements' . $this->img);
        if($image!=''){
            $image = str_replace(asset('public/uploads/advertisements').'/', '', $image);
            if(strpos($image, 'placeholder.png')){
                return $image;
            }
            $images_functions = new ImagesFunctions();
            $new_image = $images_functions->getNewSizeFromImage('advertisements', $image, $size_width, $size_height);
            if($new_image!=''){
                return asset('public/uploads/advertisements' . $new_image);
            } else {
                return asset('public/uploads/photo.svg');
            }
        } else {
            return asset('public/uploads/photo.svg');
        }
    }//end of image path attribute


}
