<?php
class ProductCategory {
    private $key;
    private $name;
    private $products;

    public function __construct($key, $name, $products) {
        $this->key = $key;
        $this->name = $name;
        $this->products = $products;
    }

    public function getKey() {
        return $this->key;
    }
    
    public function getName() {
        return $this->name;
    }

    public function getProducts() {
        return $this->products;
    }

    public function addProduct($product) {
        $this->products[] = $product;
    }
}

class Product {
    private $key;
    private $name;
    private $calories;
    private $price;
    private $description;
    private $imagePath;

    private $ingredients;

    private $isMenu;
    private $includes;

    private $categoryKey;

    public function __construct(
        $key,
        $name,
        $calories,
        $price,
        $description,
        $imagePath,
        $ingredients,

        $isMenu = false,
        $includes = null,
        $categoryKey = null,
    ) {
        $this->key = $key;
        $this->name = $name;
        $this->calories = $calories;
        $this->price = $price;
        $this->description = $description;
        $this->imagePath = $imagePath;
        $this->ingredients = $ingredients;
        $this->isMenu = $isMenu;
        $this->includes = $includes;
        $this->categoryKey = $categoryKey;
    }

    public function getKey() { return $this->key; }
    public function getName() { return $this->name; }
    public function getCalories() { return $this->calories; }
    public function getPrice() { return $this->price; }
    public function getDescription() { return $this->description; }
    public function getImagePath() { return $this->imagePath; }
    public function getIngredients() { return $this->ingredients; }
    public function getIsMenu() { return $this->isMenu; }
    public function getIncludes() { return $this->includes; }
    public function getCategoryKey() { return $this->categoryKey; }

    public function addIngredient($ingredient) { $this->ingredients[] = $ingredient; }
    public function addInclude($include) { $this->includes[] = $include; }
}
?>
