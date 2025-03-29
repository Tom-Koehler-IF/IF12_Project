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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>
        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <!--Top bar-->
        <nav class="navbar navbar-expand-lg bg-body-secondary">
            <div class="container-fluid">
                <img style="width: 40px; height: 35px;" src="Images/Fastfood_icon.png" />
        
                <!--Button 1.0 - Essen bestellen-->
                <button type="button" onclick="switchClasses('Menüs', 'Funny_Dinner_Contest')" class="btn btn-success" id="orderButton" style="border-radius: 15px; width: 500px; height: 45px; margin-left: 85px;">Essen bestellen</button>
        
                <!--Button 1.1 Funny Dinner Contest-->
                <button type="button" onclick="switchClasses('Funny_Dinner_Contest', 'Menüs')" class="btn btn-secondary" id="contestButton" style="border-radius: 15px; width: 500px; height: 45px;">Funny Dinner Contest</button>
                
                <!--Button 1.2 Shopping Cart-->
                <button id="Shopping_Cart" onclick="loadCheckout()" style="width: 75px; height: 45px; border-radius: 25px; border-color: transparent; background-color: transparent;">
                    <!--Shopping Cart image-->
                    <img src="Images\NavBar\ShoppingCart.png" width="70px" height="40px" alt="Shopping Cart" style="display: block; margin: auto;">
                </button>
        
                <!--Button 1.3 Account-->
                <button id="Account_Button" style="width: 45px; height: 45px; border-radius: 50%; border-color: transparent; background-color: transparent;" onclick="redirectToLogin()">
                    <!--Account Avatar image-->
                    <img src="Images\NavBar\AccountAvatar.png" width="30px" height="25px" alt="<?php if ($user) echo $user->getAccountName(); else echo "Account Avatar"; ?>" style="display: block; margin: auto;">
                </button>
            </div>
        </nav>
        
        <!--Button class switch function (color change)-->
        <script>
            function switchClasses(activeContent, inactiveContent) {
                let orderButton = document.getElementById("orderButton");
                let contestButton = document.getElementById("contestButton");
        
                if (activeContent === 'Menüs' || activeContent === 'Pommes' || activeContent === 'Getränke' || activeContent === 'Hamburgers') {
                    orderButton.className = "btn btn-success";
                    contestButton.className = "btn btn-secondary";
                } else if (activeContent === 'Funny_Dinner_Contest') {
                    orderButton.className = "btn btn-secondary";
                    contestButton.className = "btn btn-success";
                }
        
                loadContent(activeContent);
            }
        </script>   

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

        <!--Main content switch function-->
        <!--In the event that a tab within the side navigation bar is engaged, the en                    <button class="btn btn-link nav-link" onclick="loadContent('Beliebt')">Beliebt</button>
tirety of the web page shall remain stationary, eschewing a full-page reload. Instead, only the content area shall undergo a dynamic update, thus preserving the user’s seamless browsing experience.-->
        <?php require_once('./ajax/ajax.js.php') ?>
        <script src="./ContentSwitchLogic.js"></script>
        <script src="./cart.js"></script>

        <!--Redirect to Login page-->
        <script>
            function redirectToLogin() {
                window.location.href = "Login.php";
            }
        </script>
    </body> 
</html>
