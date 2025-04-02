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

    </head>

    <body>
        <!--Bootstrap CSS-->
        <link href="bootstrap.min.css" rel="stylesheet">

        <!--Bootstrap JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <!--Top bar-->
        <nav class="navbar navbar-expand-lg bg-body-secondary">
            <div class="container-fluid">
                <img style="width: 40px; height: 35px;" src="Images/Fastfood_icon.png" />
        
                <!--Button 1.0 - Essen bestellen-->
                <button type="button" onclick="switchClasses('order', 'Funny_Dinner_Contest')" class="btn btn-success" id="orderButton" style="border-radius: 15px; width: 500px; height: 45px; margin-left: 85px;">Essen bestellen</button>
        
                <!--Button 1.1 Funny Dinner Contest-->
                <button type="button" onclick="switchClasses('Funny_Dinner_Contest', 'order')" class="btn btn-secondary" id="contestButton" style="border-radius: 15px; width: 500px; height: 45px;">Funny Dinner Contest</button>
                
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
            function switchClasses(activeContent, inactiveContent, doNotReload) {
            let orderButton = document.getElementById("orderButton");
            let contestButton = document.getElementById("contestButton");
        
            if (activeContent === 'order') {
                orderButton.className = "btn btn-success";
                contestButton.className = "btn btn-secondary";

                if(!doNotReload) {
                    loadProductCategory(<?php echo current($productCategories)->getKey();?>);
                }
            } else if (activeContent === 'Funny_Dinner_Contest' || activeContent === 'Funny_Dinner_Contest_Rating') {
                orderButton.className = "btn btn-secondary";
                contestButton.className = "btn btn-success";

                // Reset the color of all buttons to default
                const buttons = document.querySelectorAll('.category-button');
                buttons.forEach(btn => btn.style.setProperty('color', '#000', 'important'));

                loadDinnerContest(false);
            }
            }
        </script>

        <!--Side bar-->
        <div class="d-flex">
            <div class="bg-light border" style="width: 250px; height: 100vh;">
            <ul class="nav flex-column p-3" style="font-size: 16px;">
            <li class="nav-item mb-3">
            <h5 class="text-center" style="color: #28a745;">Kategorien</h5>
            </li>
            <?php foreach($productCategories as $productCategory): ?>
            <li onclick="switchClasses('order', 'Funny_Dinner_Contest', true)" class="nav-item mb-2">
            <button class="btn btn-link nav-link text-start text-dark category-button" style="font-weight: 500; text-decoration: none;" onclick="highlightCategory(this); loadProductCategory(<?php echo $productCategory->getKey();?>)">
            <?php echo htmlspecialchars($productCategory->getName()); ?>
            </button>
            </li>
            <?php endforeach; ?>
            </ul>
            </div>
            <div id="main-content" style="flex-grow: 1; padding: 20px;">
            <!--Main content which will be displayed if nothing is selected-->
            <h1 class="text-center text-secondary">Willkommen! Wählen Sie eine Kategorie aus.</h1>
            </div>
        </div>

        <script>
            function highlightCategory(button) {
            // Reset all buttons to default color
            const buttons = document.querySelectorAll('.category-button');
            buttons.forEach(btn => btn.style.setProperty('color', '#000', 'important'));

            // Set the clicked button color to #28a745
            button.style.setProperty('color', '#28a745', 'important');
            }
        </script>


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

        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="cartToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Warenkorb</strong>
                    <small>Jetzt</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Schließen"></button>
                </div>
                <div class="toast-body">
                    Zum Warenkorb hinzugefügt!
                </div>
            </div>
        </div> 
    </body> 
</html>
