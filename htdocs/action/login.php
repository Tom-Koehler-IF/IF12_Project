<?php

include("../include/login.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        login($username, $password);

        if ($_POST['redirect']) {
            header("Location: " . $_POST['redirect']);
            die();   
        } else {
            redirectToDefaultPage(getUserRole());
        }
    } catch (Exception $_) {
        header("Location: /index.php?error=1&redirect=" . ($_POST['redirect'] ?? ''));
        die();
    }
} else {
    http_response_code(400);
    echo "Bad Request";
}

?>
