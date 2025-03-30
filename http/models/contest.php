<?php

class ContestImage {
    private $key;
    private $imagePath;
    private $accountName;
    private $createdAt;

    public function __construct($key, $imagePath, $accountName, $createdAt)
    {
        $this->key = $key;
        $this->imagePath = $imagePath;
        $this->accountName = $accountName;
        $this->createdAt = $createdAt;
    }

    public function getKey() { return $this->key; }
    public function getImagePath() { return $this->imagePath; }
    public function getAccountName() { return $this->accountName; }
    public function getCreatedAt() { return $this->createdAt; }
}

?>
