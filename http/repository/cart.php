<?php

require_once __DIR__ . '/../models/cart.php';
require_once __DIR__ . '/product.php';

/// Adds a product to the cart based on product key
function addToCart($productKey) {
    if (!is_array($_SESSION['SHOPPING_CART'])) $_SESSION['SHOPPING_CART'] = array();
    
    if (isset($_SESSION['SHOPPING_CART'][$productKey])) $_SESSION['SHOPPING_CART'][$productKey] += 1;
    else $_SESSION['SHOPPING_CART'][$productKey] = 1;
}

// Returns the shopping cart as an array of cart-item
function getShoppingCart() {
    $products = array();
    loadAllProductCategories($products);

    $result = array();
    foreach ($_SESSION['SHOPPING_CART'] as $productKey => $count) {
        $result[] = new CartItem($products[$productKey], $count);
    }
    
    return $result;
}

// Clears the current shopping cart
function clearCart() {
    $_SESSION['SHOPPING_CART'] = array();
}

?>
