<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdImage extends Model
{
    protected $table = "ads_extra_images";
    public $timestamps = false;
    protected $fillable = ["ad_id","image"];

    protected $appends = ["image_path"];

    public function getImagePathAttribute(){
        return asset('public/uploads/ads/'.$this->image);
    }
}
