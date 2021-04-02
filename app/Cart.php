<?php

namespace App;

class Cart
{
    public $items = [];
    public $totalQty ;
    public $totalPrice;

    public function __Construct($cart = null) {
        if($cart) {
            $this->items = $cart->items;
            $this->totalQty = $cart->totalQty;
            $this->totalPrice = $cart->totalPrice;
        } else {

            $this->items = [];
            $this->totalQty = 0;
            $this->totalPrice = 0;
        }
    }

    public function add($product,$qty) {
        $item = [
            'id' =>  $product->id,
            'title' => $product->title,
            'price' => $product->price,
            'qty' => $qty,
            'image' => $product->getImageSize(150,150),
        ];

        if( !array_key_exists($product->id, $this->items)) {
            $this->items[$product->id] = $item ;
            $this->totalQty +=1;
            $this->totalPrice += $product->price;

        } else {
            $this->totalQty = 1;
            $this->totalPrice += $product->price;
        }

    }

    public function edit($product,$qty){
        if(array_key_exists($product->id, $this->items)) {
            $this->items[$product->id]['qty']  = $qty ;
        }

        $total = 0;
        foreach ($this->items as $item){
            $total += $item['qty'] * $item['price'];
        }
        $this->totalPrice = $total;
    }

    public function remove($product) {

        if( array_key_exists($product->id, $this->items)){
            $this->totalQty -= 1;
            unset($this->items[$product->id]);
            $total = 0;
            foreach ($this->items as $item){
                $total += $item['qty'] * $item['price'];
            }
            $this->totalPrice = $total;

        }

    }


}
