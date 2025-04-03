<?php

class ContestImage {
    private $key;
    private $imagePath;
    private $accountName;
    private $createdAt;
    private $currentRating;

    public function __construct($key, $imagePath, $accountName, $createdAt, $currentRating = 0)
    {
        $this->key = $key;
        $this->imagePath = $imagePath;
        $this->accountName = $accountName;
        $this->createdAt = $createdAt;
        $this->currentRating = $currentRating;
    }

    public function getKey() { return $this->key; }
    public function getImagePath() { return $this->imagePath; }
    public function getAccountName() { return $this->accountName; }
    public function getCreatedAt() { return $this->createdAt; }
    public function getCurrentRating() { return $this->currentRating; }
}

?>
