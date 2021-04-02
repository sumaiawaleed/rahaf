<?php

namespace App;
use App\Functions\ImagesFunctions;
use Illuminate\Database\Eloquent\Model;

class ExtraImage extends Model
{
    protected $table ="extra_imgs";
    public $timestamps = false;
    protected $fillable = ['product_id','img','color_id','quantity'];

    protected $appends = ["image_path"];

    public function getImagePathAttribute(){
        return asset("public/uploads/products/".$this->img);
    }

    public function getImageSize($size_width, $size_height)
    {
        $image =  asset('public/uploads/products/' . $this->img);
        if($image!=''){
            $image = str_replace(asset('public/uploads/products').'/', '', $image);
            if(strpos($image, 'placeholder.png')){
                return $image;
            }
            $images_functions = new ImagesFunctions();
            $new_image = $images_functions->getNewSizeFromImage('products', $image, $size_width, $size_height);
            if($new_image!=''){
                return asset('public/uploads/products/' . $new_image);
            } else {
                return asset('public/uploads/photo.svg');
            }
        } else {
            return asset('public/uploads/photo.svg');
        }
    }//end of image path attribute
}
