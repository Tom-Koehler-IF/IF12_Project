<?php
// Start session with secure settings
ini_set('session.cookie_httponly', 1); // Prevent js access to cookie
ini_set('session.use_only_cookies', 1); // Forces cookie usage
ini_set('session.cookie_samesite', 'Strict'); // Prevents CSRF attacks

session_start();

// Generate crsf token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once('repository/product.php');
require_once('repository/login.php');

$productCategories = loadAllProductCategories();
$user = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">

        <!--Webseite Title-->
        <title>Fastfood</title>

        <!--Bootstrap CSS-->
        <link href="bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <!--Bootstrap JS-->
        <script src="bootstrap.bundle.min.js"></script>
        <!--Top bar-->
        <nav class="navbar navbar-expand-lg bg-body-secondary">
            <div class="container-fluid">
                <img style="width: 40px; height: 35px;" src="images/Fastfood_icon.png" />
        
                <!--Button 1.0 - Essen bestellen-->
                <button type="button" onclick="switchClasses('order', 'Funny_Dinner_Contest')" class="btn btn-success" id="orderButton" style="border-radius: 15px; width: 500px; height: 45px; margin-left: 85px;">Essen bestellen</button>
        
                <!--Button 1.1 Funny Dinner Contest-->
                <button type="button" onclick="switchClasses('Funny_Dinner_Contest', 'order')" class="btn btn-secondary" id="contestButton" style="border-radius: 15px; width: 500px; height: 45px;">Funny Dinner Contest</button>
                
                <!--Button 1.2 Shopping Cart-->
                <button id="Shopping_Cart" onclick="loadCheckout()" style="width: 75px; height: 45px; border-radius: 25px; border-color: transparent; background-color: transparent;">
                    <!--Shopping Cart image-->
                    <img src="images\ShoppingCart.png" width="70px" height="40px" alt="Shopping Cart" style="display: block; margin: auto;">
                </button>
        
                <!--Button 1.3 Account-->
                <button id="Account_Button" style="width: 45px; height: 45px; border-radius: 50%; border-color: transparent; background-color: transparent;" onclick="redirectToLogin()">
                    <?php if ($user != null) echo $user->getAccountName(); else echo 'Login'; ?>
                </button>
            </div>
        </nav>
        
        <!--Side bar-->
        <div class="d-flex">
            <div class="bg-light border" style="width: 200px; height: 100vh;">
            <ul class="nav flex-column">
                <!-- TODO: Has to be loaded dynamic --> 
                <!-- TODO: loadContent should be changed a little bit. It should be split into two functions I think one for loading something like funny dinner contest one for loading the left sidebar thingies --> 
                <!--Beliebt Content-->
                <li class="nav-item">
                </li>

                <?php foreach($productCategories as $productCategory): ?>
                    <li class="nav-item">
                        <button class="btn btn-link nav-link" onclick="loadProductCategory(<?php echo $productCategory->getKey();?>)"><?php echo htmlspecialchars($productCategory->getName()); ?></button>
                    </li>
                <?php endforeach; ?>
            </ul>
            </div>
            <div class="flex-grow-1 p-3" id="main-content">
            <!--Main content which will be displayed if nothing is selected-->
            <h1>Main content which will be displayed if nothing is selected</h1>
            </div>
        </div>

        <!-- Here we can dump some constant values to js so js can use them, but we still want to seperate js and php -->
        <script>
            const INITIAL_CATEGORY = <?php echo current($productCategories)->getKey(); ?>;
        </script>

        <!--Main content switch function-->
        <!--In the event that a tab within the side navigation bar is engaged, the en                    <button class="btn btn-link nav-link" onclick="loadContent('Beliebt')">Beliebt</button>
tirety of the web page shall remain stationary, eschewing a full-page reload. Instead, only the content area shall undergo a dynamic update, thus preserving the user’s seamless browsing experience.-->
        <?php require_once('./ajax/ajax.js.php') ?>
        <script src="./index.js"></script>
    </body> 
</html>
