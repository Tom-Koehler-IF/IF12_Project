<?php

class Invoice {
    private $orderNumber;
    private $orderTime;
    private $customer;
    private $orderProducts;
    private $price;

    public function __construct($orderNumber, $orderTime, $customer, $orderProducts, $price) {
        $this->orderNumber = $orderNumber;
        $this->orderTime = $orderTime;
        $this->customer = $customer;
        $this->orderProducts = $orderProducts;
        $this->price = $price;
    }

    public function getOrderNumber() { return $this->orderNumber; }
    public function getOrderTime() { return $this->orderTime; }
    public function getCustomer() { return $this->customer; }
    public function getOrderProducts() { return $this->orderProducts; }
    public function getPrice() { return $this->price; }
}

class OrderProduct {
    private $name;
    private $price;
    private $quantity;
    private $totalPrice;

    public function __construct($name, $price, $quantity, $totalPrice)
    {
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->totalPrice = $totalPrice;
    }

    public function getName() { return $this->name; }
    public function getPrice() { return $this->price; }
    public function getQuantity() { return $this->quantity; }
    public function getTotalPrice() { return $this->totalPrice; }
}

class Price {
    private $brutto;
    private $mws;
    private $netto;

    public function __construct($brutto, $mws, $netto)
    {
        $this->brutto = $brutto;
        $this->mws = $mws;
        $this->netto = $netto;
    }

    public function getBrutto() { return $this->brutto; }
    public function getMws() { return $this->mws; }
    public function getNetto() { return $this->netto; }
}

?>
