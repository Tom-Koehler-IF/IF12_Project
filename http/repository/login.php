<?php

require_once __DIR__ . '/../models/login.php';
require_once __DIR__ . '/db.php';

function login($username, $password) {
    $conn = createDbConnection();

    $stmt = $conn->prepare("call spLoginUser(?, ?)");
    $stmt->bind_param('ss', $username, md5($password));
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['USER'] = serialize(new User($row['nUserKey'], $row['szFirstName'], $row['szLastName'], $row['szStreet'], $row['szStreetNumber'], $row['szCity'], $row['szPostalCode'], $row['szAccountName']));
        return null;
    } else {
        return "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}

function signup($username, $password, $first_name, $last_name, $street, $street_number, $city, $postal_code) {
    $conn = createDbConnection();

    $stmt = $conn->prepare("call spNewCustomer(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssssss', $first_name, $last_name, $street, $street_number, $postal_code, $city, $username, md5($password));
    $stmt->execute();
}

function getCurrentUser() {
    if (empty($_SESSION['USER'])) return null;
    else return unserialize($_SESSION['USER']);
}

?>
