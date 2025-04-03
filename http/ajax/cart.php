<?php

session_start();

require_once(__DIR__ . '/../repository/cart.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Post adds a product to the shopping cart
    // on post request verify CLRF token
    if (!isset($_SERVER['HTTP_X_CSRF_TOKEN']) || $_SERVER['HTTP_X_CSRF_TOKEN'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        echo "CSRF verification failed";
        exit;
    }

    // Read productKey from $_SESSION. If it is not in the cart yet add it else increase count by 1
    $productKey = $_POST['product'];

    if (!isset($productKey)) {
        http_response_code(400);
        echo "No product passed";
        exit;
    }

    addToCart($productKey);
}


?>
