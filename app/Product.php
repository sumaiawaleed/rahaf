<?php

namespace App;
use App\Functions\ImagesFunctions;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $fillable = [
        'name',
        'a_name',
        'description',
        'a_description',
        'available',
        'price_type',
        'price',
        'offer_price',
        'status',
        'quantity_id',
        'brand_id',
        'img',
        'main_catgeory_id',
        'cat_id',
        'tags',
        'is_belong',
        'type',
        'quantity',
        'sku',
        'var_type'
    ];

    protected $appends = ["image_path","category_name","price_name",'total_rate','is_fav'];

    public function getImagePathAttribute(){
        return asset("public/uploads/products/".$this->img);
    }
    public function getPriceNameAttribute(){
        $currency = (session()->has('currency')and  session()->get('currency') == 1) ? 1  : 2;
        $total = 0;
        $d= Dollar::first();

        if($this->price_type == 1){
            $total =  $currency == 1 ?  $this->price : ($this->price * $d->the_cost);
        }else{
            $total = $currency == 1 ?  ($this->price / $d->the_cost) : ($this->price);
        }

        return number_format($total).' '.$currency == 1 ? '$' : 'Y.R';
    }
    public function getTotalRateAttribute()
    {
        $num = Rating::where('pr_id', $this->id)->selectRaw('SUM(rate)/COUNT(user_id) AS avg_rating')->first()->avg_rating;

        $num = round($num * 2) / 2;
        $result = '';
        for ($i = 0; $i < 5; $i++)
            if ($i < $num) {
                $result .='<span class="fa fa-star"  style = "color: #ffa800" ></span>';
        }else{
                $result .='<span class="fa fa-star" ></span>';
        }
        return $result;
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

    public function getCategoryNameAttribute(){
       $result = "";
       $local = app()->getLocale();
       $main = MainCategory::find($this->main_catgeory_id);
       $cat = Category::find($this->cat_id);
       if($main)
           $result .= $main->getTranslateName($local);

       if($cat)
           $result .= " - ".$cat->getTranslateName($local);


       return $result;
    }

    public function getTranslateName($local = ""){
        $local = app()->getLocale();
        if($local == 'ar'){
            return $this->a_name;
        }else{
            return $this->name;
        }
    }

    public function getTranslateDesc($local = ""){
        $local = app()->getLocale();
        if($local == 'ar'){
            return $this->a_description;
        }else{
            return $this->description;
        }
    }

    public function getIsFavAttribute(){
        $is_fav = FALSE;
        if(auth('customers')->user()){
            $f = Favourite::where('product_id',$this->id)->where('user_id',auth('customers')->user()->id)->first();
            $is_fav = ($f) ? TRUE : FALSE;
        }

        return $is_fav;
    }

    public function getPrice(){
        $currency = (session()->has('currency')and  session()->get('currency') == 1) ? 1  : 2;
        $d= Dollar::first();

        $total = 0;

        if($currency == 1){
            if($this->price_type == 1)
                $total = number_format($this->price).'$';
            else
                $total = number_format((float) ($this->price / $d->the_cost), 2, '.', '').'$';
        }else{
            if($this->price_type == 1)
                $total = number_format($this->price * $d->the_cost).'Y.R';
            else
                $total = $this->price.'Y.R';

        }

        return $total;
    }

    public function getDiscountPrice(){
        $currency = (session()->get('currency') == 1) ? 1  : 2;

        $discount = $this->offer_price;
        $d= Dollar::first();

        $total = 0;

        if($currency == 1){
            if($this->price_type == 1)
                $total = number_format($discount).'$';
            else
                $total = number_format((float) ($discount / $d->the_cost), 2, '.', '').'$';
        }else{
            if($this->price_type == 1)
                $total = number_format($discount * $d->the_cost).'Y.R';
            else
                $total = $discount.'Y.R';

        }

        return $total;
    }

    public function getTotal(){
        $total = $this->quantity;
        $products = ExtraImage::where('product_id',$this->id)->sum('quantity');
        return $total+$products;

    }
}
