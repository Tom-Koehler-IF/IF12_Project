<?php
    include("../include/login.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (array_key_exists(SESSION_ACCOUNT, $_SESSION)) {
            logout();
            header('Location: /');
        } else {
            http_response_code(404);
            echo "Cannot logout if not logged in";
        }
    } else {
        http_response_code(400);
        echo "Bad Request";
    }
?>
