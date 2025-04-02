<?php

function createDbConnection() {  
    // Temporary hardcoded values
    $servername = "localhost";
    $username = "project";
    $password = "password";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);
    return $conn;
}

?>
