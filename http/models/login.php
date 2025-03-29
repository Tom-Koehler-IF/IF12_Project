<?php

class Customer {
    private $key;
    private $first_name;
    private $last_name;
    private $street;
    private $home_number;
    private $city;
    private $postal_code;

    public function __construct($key, $first_name, $last_name, $street, $home_number, $city, $postal_code) {
        $this->key = $key;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->street = $street;
        $this->home_number = $home_number;
        $this->city = $city;
        $this->postal_code = $postal_code;
    }

    // Getters
    public function getKey() {
        return $this->key;
    }

    public function getFirstName() {
        return $this->first_name;
    }

    public function getLastName() {
        return $this->last_name;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getHomeNumber() {
        return $this->home_number;
    }

    public function getCity() {
        return $this->city;
    }

    public function getPostalCode() {
        return $this->postal_code;
    }
}

class User extends Customer implements Serializable {
    private $account_name;

    public function __construct($key, $first_name, $last_name, $street, $home_number, $city, $postal_code, $account_name) {
        // Call parent constructor
        parent::__construct($key, $first_name, $last_name, $street, $home_number, $city, $postal_code);
        
        // Set additional property
        $this->account_name = $account_name;
    }

    // Getter for account name
    public function getAccountName() {
        return $this->account_name;
    }

        // Serializable interface methods
    public function serialize() {
        // Serialize all properties, including parent class properties
        return serialize([
            'key' => $this->getKey(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'street' => $this->getStreet(),
            'home_number' => $this->getHomeNumber(),
            'city' => $this->getCity(),
            'postal_code' => $this->getPostalCode(),
            'account_name' => $this->account_name
        ]);
    }

    public function unserialize($data) {
        // Unserialize the data
        $props = unserialize($data);

        // Reconstruct the object using the constructor
        $this->__construct(
            $props['key'],
            $props['first_name'],
            $props['last_name'],
            $props['street'],
            $props['home_number'],
            $props['city'],
            $props['postal_code'],
            $props['account_name']
        );
    }
}

?>
