<?php
session_start();

require_once(__DIR__ . '/../repository/cart.php');
require_once(__DIR__ . '/../repository/login.php');

$cart = getShoppingCart();
$user = getCurrentUser();
?>

<div style="display: flex;">
    <div style="flex: 1; padding: 10px; background-color: rgb(245, 245, 245); border-radius: 15px; margin-right: 25px;">
        <span style="font-size: 20px; font-weight: bold;">Checkout</span>
        <ul>
            <?php foreach($cart as $item): ?>
                <li><?php echo $item->getCount(); ?>: <?php echo $item->getProduct()->getName(); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div style="flex: 1; padding: 10px; background-color: rgb(245, 245, 245); border-radius: 15px;">
        <span style="font-size: 20px; font-weight: bold;">Rechnungsadresse</span>
        <div style="margin-bottom: 15px; margin-top: 15px;">
            <span>Vorname</span>
            <input type="text" class="form-control" maxlength="30" value="<?php if ($user) echo $user->getFirstName(); ?>" <?php if ($user) echo 'disabled'; ?>>
        </div>
        <div style="margin-bottom: 15px;">
            <span>Nachname</span>
            <input type="text" class="form-control" maxlength="30"value="<?php if ($user) echo $user->getLastName(); ?>" <?php if ($user) echo 'disabled'; ?>>
        </div>
        <div style="margin-bottom: 15px;">
            <span>Postleitzahl</span>
            <input type="text" class="form-control" maxlength="5"value="<?php if ($user) echo $user->getPostalCode(); ?>" <?php if ($user) echo 'disabled'; ?>>
        </div>
        <div style="margin-bottom: 15px;">
            <span>Ort</span>
            <input type="text" class="form-control" maxlength="40"value="<?php if ($user) echo $user->getCity(); ?>" <?php if ($user) echo 'disabled'; ?>>
        </div>
        <div style="margin-bottom: 15px;">
            <span>Straße</span>
            <input type="text" class="form-control" maxlength="40"value="<?php if ($user) echo $user->getStreet(); ?>" <?php if ($user) echo 'disabled'; ?>>
        </div>
        <div style="margin-bottom: 5px;">
            <span>Hausnummer</span>
            <input type="text" class="form-control" maxlength="3" value="<?php if ($user) echo $user->getHomeNumber(); ?>" <?php if ($user) echo 'disabled'; ?>>
        </div>
    </div>
</div>
<div style="display: flex; justify-content: center; margin-top: 50px;">
    <button class="btn btn-success" style="border-radius: 15px; width: 750px;" onclick="createOrder()">Bestellung aufgeben</button>
</div>
<script src="ajax/js/checkout.js"></script>