<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class  Advertisement extends Model
{
    protected $table = "advertisement";
    protected $fillable = ["type","ad_id","img"];

    protected $appends = ["images_path"];

    public function getImagePathAttribute(){
        return asset("public/uploads/advertisements/".$this->img);
    }
}
