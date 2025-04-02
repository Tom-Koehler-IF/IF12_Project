<?php

class Customer {
    private $customerKey;
    private $first_name;
    private $last_name;
    private $street;
    private $home_number;
    private $city;
    private $postal_code;

    public function __construct($customerKey, $first_name, $last_name, $street, $home_number, $city, $postal_code) {
        $this->customerKey = $customerKey;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->street = $street;
        $this->home_number = $home_number;
        $this->city = $city;
        $this->postal_code = $postal_code;
    }

    // Getters
    public function getCustomerKey() {
        return $this->customerKey;
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
    private $key;
    private $account_name;
    private $is_admin;

    public function __construct($customerKey, $key, $first_name, $last_name, $street, $home_number, $city, $postal_code, $account_name, $is_admin = 0) {
        // Call parent constructor
        parent::__construct($customerKey, $first_name, $last_name, $street, $home_number, $city, $postal_code);
        
        // Set additional property
        $this->key = $key;
        $this->account_name = $account_name;
        $this->is_admin = $is_admin;
    }

    public function getKey() {
        return $this->key;
    }

    // Getter for account name
    public function getAccountName() {
        return $this->account_name;
    }

    public function getIsAdmin() {
        return $this->is_admin;
    }

        // Serializable interface methods
    public function serialize() {
        // Serialize all properties, including parent class properties
        return serialize([
            'customer_key' => $this->getCustomerKey(),
            'key' => $this->getKey(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'street' => $this->getStreet(),
            'home_number' => $this->getHomeNumber(),
            'city' => $this->getCity(),
            'postal_code' => $this->getPostalCode(),
            'account_name' => $this->account_name,
            'is_admin' => $this->is_admin,
        ]);
    }

    public function unserialize($data) {
        // Unserialize the data
        $props = unserialize($data);

        // Reconstruct the object using the constructor
        $this->__construct(
            $props['customer_key'],
            $props['key'],
            $props['first_name'],
            $props['last_name'],
            $props['street'],
            $props['home_number'],
            $props['city'],
            $props['postal_code'],
            $props['account_name'],
            $props['is_admin']
        );
    }
}

?>
