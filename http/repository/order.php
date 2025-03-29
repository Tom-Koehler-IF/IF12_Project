<?php

require_once __DIR__ . '/db.php';

/**
Creates a new order and returns it's id
*/
function createNewOrder($customer) {
    $conn = createDbConnection();
    $stmt = $conn->prepare("call spNewOrder (?, @orderId)");
    $stmt->bind_param('i', $customer->getKey());
    $stmt->execute();

    $result = $conn->execute_query("select @orderId as result");
    if ($row = $result->fetch_assoc()) {
        return $row['result'];
    } else {
        return null;
    }

    $stmt->close();
    $conn->close();
}

/**
Adds all cartItems to an order
*/
function addOrderProducts($order, $cartItems) {
    $conn = createDbConnection();

    foreach ($cartItems as $cartItem) {
        addOrderProduct($conn, $order, $cartItem);
    }

    $conn->close();
}

/**
Adds a single product to an order
*/
function addOrderProduct($conn, $order, $cartItem) {
    $stmt = $conn->prepare("call spNewOrderProduct(?, ?, ?)");
    $stmt->bind_param('iii', $order, $cartItem->getProduct()->getKey(), $cartItem->getCount());
    $stmt->execute();

    $stmt->close();
}

?>
