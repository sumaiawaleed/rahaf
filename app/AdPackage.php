<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdPackage extends Model
{
    protected $table = "ads_packages";
    protected $fillable = ['name',
        'features',
        'total_ads',
        'days',
        'user_type',
        'is_deleted'];

    public function type(){
        return $this->belongsTo(UserType::class);
    }
    public function getTranslateName($local){
        $name = "";
        try {
            $array = json_decode($this->name,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

    public function getTranslateFeatures($local){
        $name = "";
        try {
            $array = json_decode($this->features,TRUE);
            $name = $array[$local];
        }catch (\Exception $ex){

        }
        return $name;
    }

}
