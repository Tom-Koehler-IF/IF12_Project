<?php

class CartItem {
    private $product;
    private $count;

    public function __construct($product, $count) {
        $this->product = $product;
        $this->count = $count;
    }

    public function getProduct() {
        return $this->product;
    }

    public function getCount() {
        return $this->count;
    }
}

?>
