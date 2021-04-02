<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdReviews extends Model
{
    protected $table = "ads_reviews";
    protected $fillable = ["user_id","ad_id","review",'stars','is_deleted'];
}
