<?php

session_start();

require_once(__DIR__ . '/../repository/login.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_SERVER['HTTP_X_CSRF_TOKEN']) || $_SERVER['HTTP_X_CSRF_TOKEN'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        echo "CSRF verification failed";
        exit;
    }

    $username = $_GET['username'];
    $password = $_GET['password'];

    if (!isset($username) || !isset($password)) {
        http_response_code(400);
        echo "Benutzername und passwort erforderlich";
        exit;
    }

    $login_result = login($username, $password);

    http_response_code(200);
    echo $login_result;
    exit();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SERVER['HTTP_X_CSRF_TOKEN']) || $_SERVER['HTTP_X_CSRF_TOKEN'] !== $_SESSION['csrf_token']) {
        http_response_code(403);
        echo "CSRF verification failed";
        exit;
    }

    $result = signup($_POST['username'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['street'], $_POST['street_number'], $_POST['city'], $_POST['postal_code']);
    
    http_response_code(200);
    echo $result;
    exit();
} else {
    http_response_code(405);
    exit('Methode nicht erlaubt');
}

?>
