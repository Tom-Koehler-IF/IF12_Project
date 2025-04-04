<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/login.php';
require_once __DIR__ . '/../models/order.php';

/*
Creates a new order and returns it's id
*/
function createNewOrder($customer) {
    $conn = createDbConnection();
    $stmt = $conn->prepare("call spNewOrder (?, @orderId)");
    $stmt->bind_param('i', $customer->getCustomerKey());
    $stmt->execute();

    $result = $conn->query("select @orderId as result");
    $row = $result->fetch_assoc();
    $orderId = $row['result'];

    // Always make sure we have an orders array
    if (empty($_SESSION['orders'])) $_SESSION['orders'];
    // If our currentUser is not null store order as our owned order (If customer is logged in this can be done via the customerKey)
    if (getCurrentUser() === null) $_SESSION['orders'][] = $orderId;

    $stmt->close();
    $conn->close();

    return $orderId;
}

/*
Adds all cartItems to an order
*/
function addOrderProducts($order, $cartItems) {
    $conn = createDbConnection();

    foreach ($cartItems as $cartItem) {
        addOrderProduct($conn, $order, $cartItem);
    }

    $conn->close();
}

/*
Adds a single product to an order
*/
function addOrderProduct($conn, $order, $cartItem) {
    $stmt = $conn->prepare("call spNewOrderProduct(?, ?, ?)");
    $stmt->bind_param('iii', $order, $cartItem->getProduct()->getKey(), $cartItem->getCount());
    $stmt->execute();

    $stmt->close();
}

/*
Gets all invoice information for an order
*/
function getInvoice($orderNumber) {
    // Cast $orderNumber as int so we are immune to sql injection.
    // Like this it will crash if there is no int passed which we just ignore for now
    $orderNumber = (int) $orderNumber;
    
    $conn = createDbConnection();
    $sql = 'call spInvoice(' . $orderNumber . ')';
    $conn->multi_query($sql);

    $result = $conn->store_result();
    $row = null;
    if (!($row = $result->fetch_assoc())) {
        // If no row is returned in first resultset order does not exist
        $conn->close();
        return null;
    }
    $orderTime = $row['dtTime'];
    $result->free();

    $conn->next_result();
    $result = $conn->store_result();
    $customer = readCustomerFromRow($result->fetch_assoc());
    $result->free();

    $conn->next_result();
    $result = $conn->store_result();
    $orderProducts = array();
    while ($row = $result->fetch_assoc()) {
        $orderProducts[] = readOrderProductFromRow($row);
    }
    $result->free();

    $conn->next_result();
    $result = $conn->store_result();
    $price = readPriceFromRow($result->fetch_assoc());
    $result->free();

    $conn->close();

    return new Invoice($orderNumber, $orderTime, $customer, $orderProducts, $price);
}

/*
Determines if the current user can view an invoice
*/
function canViewInvoice($invoice) {
    // First case is our session orders contain the requested invoice. Then we can view it
    if (!empty($_SESSION['orders']) && in_array($invoice->getOrderNumber(), $_SESSION['orders'])) return true;
    // The second case is our customer matches our logged in user
    if (getCurrentUser() !== null && getCurrentUser()->getCustomerKey() == $invoice->getCustomer()->getCustomerKey()) return true;

    return false;
}

function readOrderProductFromRow($row) {
    return new OrderProduct($row['Name'], $row['Price'], $row['Quantity'], $row['Gesamt']);
}

function readPriceFromRow($row) {
    return new Price($row['Brutto'], $row['MwS'], $row['Netto']);
}

?>
