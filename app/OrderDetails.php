<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table = "order_details";
    public $timestamps = false;
    protected $fillable = [
        "order_id",
        "price",
        "quantity",
        "sub_quantity_id",
        "product_id",
        "color_id",
        "img"
    ];
}
