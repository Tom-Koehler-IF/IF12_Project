<?php

session_start();

require_once(__DIR__ . '/../repository/cart.php');
require_once(__DIR__ . '/../repository/login.php');
require_once(__DIR__ . '/../repository/order.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Post adds a product to the shopping cart
    // on post request verify CLRF token
    if (!isset($_SERVER['HTTP_X_CSRF_TOKEN']) || $_SERVER['HTTP_X_CSRF_TOKEN'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        echo "CSRF verification failed";
        exit;
    }

    $cartItems = getShoppingCart();

    if (count($cartItems) == 0) {
        http_response_code(422);
        echo "Cart can not be empty";
        exit;
    }

    // Get logged in user
    $customer = getCurrentUser();

    if ($customer === null) {
        $customerKey = createCustomer($_POST['first_name'], $_POST['last_name'], $_POST['street'], $_POST['street_number'], $_POST['city'], $_POST['postal_code']);
        $customer = new Customer(
            $customerKey,
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['street'],
            $_POST['street_number'],
            $_POST['city'],
            $_POST['postal_code'],
        );
    }

    $order = createNewOrder($customer);    
    addOrderProducts($order, $cartItems);

    clearCart();

    echo $order;
}

?>
