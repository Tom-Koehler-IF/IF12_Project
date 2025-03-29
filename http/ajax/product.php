<?php
require_once __DIR__ . '/../repository/product.php';

session_start();

$categoryKey = htmlspecialchars($_GET['category']);
$products = loadAllProductsForCategory($categoryKey);
?>

<div style="display: flex; flex-wrap: wrap; justify-content: center;">
    <?php foreach($products as $product): ?>
        <div style="border: 1px solid black; margin: 15px; padding: 10px; width: 30%;">
            <h3 style="font-weight: bold;"><?php echo htmlspecialchars($product->getName())?></h3>
            <img src="<?php echo htmlspecialchars($product->getImagePath()) ?>" alt="Icon" style="width: 100%;">
            <p>Preis: <?php echo number_format($product->getPrice(), 2, ',', '.') ?>EUR</p>
            <!-- If we are a menu and have includes display the includes details -->
            <?php if($product->getIsMenu() && $product->getIncludes()): ?>
                <details>
                    <summary>Beinhaltet</summary>
                    <ul>
                    <?php foreach($product->getIncludes() as $part): ?>
                        <li><?php echo $part->getName(); ?></li>
                    <?php endforeach; ?>
                    </ul>
                </details>
            <?php endif; ?>
            <!-- If we have any ingredients display them as include -->
            <?php if($product->getIngredients() != null): ?>
                <details>
                    <summary>Zutaten</summary>
                    <ul>
                    <?php foreach($product->getIngredients() as $ingredient): ?>
                        <li><?php echo $ingredient; ?></li>
                    <?php endforeach; ?>
                    </ul>
                </details>
            <?php endif; ?>
            <!-- If we have known calories display them -->
            <?php if($product->getCalories() != null): ?>
                <p>Energiewerte: <?php echo number_format($product->getCalories() * 4.184, 0); ?>KJ / <?php echo number_format($product->getCalories(), 0); ?>kcal</p>
            <?php endif; ?>
            <button class="btn btn-success" style="border-radius: 15px;" onclick="addToCart(<?php echo $product->getKey(); ?>)">
            In den Warenkorb
            </button>
        </div>
    <?php endforeach ?>
</div>
