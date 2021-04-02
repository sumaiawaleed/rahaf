<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";
    public $timestamps = false;


    protected $fillable =[
        "user_id",
        "total_price",
        "user_lat",
        "user_log",
        "user_address",
        "note",
        "the_millisecands",
        "driver_id",
        "status",
        "not_seen",
        "day_doller_cost",
    ];

    protected $appends = ['status_name'];

    public function getStatusNameAttribute(){
        if($this->status == 1)
            return __('site.done');
        else if($this->status == 0)
            return __('site.pending');
        else if($this->status == 2)
            return __('site.rejected');
    }

    public function get_color(){
        $id = $this->status;
        if($id == 1){
            return "#28a745";
        }
        else  if($id == 0){
            return "#ffc107";
        }else{
            return "#dc3545";
        }
    }

    public function driver(){
        $d =  Driver::find($this->driver_id);
        return $d ?  $d->name : '';
    }
}
