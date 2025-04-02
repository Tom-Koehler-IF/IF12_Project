<?php
require_once __DIR__ . '/../repository/product.php';

session_start();

$categoryKey = htmlspecialchars($_GET['category']);
$products = loadAllProductsForCategory($categoryKey);
?>

</script>
<div style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; gap: 20px; padding: 20px;">
    <?php foreach($products as $product): ?>
        <div style="border: 1px solid #ddd; margin: 15px; padding: 20px; min-height: 450px; width: 300px; text-align: center; box-sizing: border-box; display: flex; flex-direction: column; justify-content: space-between; align-items: center; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.75);">
            <h3 style="font-weight: bold; font-size: 20px; color: #333;"><?php echo htmlspecialchars($product->getName())?></h3>
            <img src="<?php echo htmlspecialchars($product->getImagePath()) ?>" alt="Icon" style="width: 225px; height: 200px; border-radius: 10px; object-fit: cover;">
            <p style="font-size: 16px; color: #555;">Preis: <?php echo number_format($product->getPrice(), 2, ',', '.') ?> EUR</p>
            <?php if($product->getIsMenu() && $product->getIncludes()): ?>
                <details style="margin-top: 10px;">
                    <summary style="cursor: pointer; font-weight: bold; color:rgb(0, 0, 0);">Beinhaltet</summary>
                    <ul style="list-style: none; padding: 0; margin: 10px 0; color: #555;">
                    <?php foreach($product->getIncludes() as $part): ?>
                        <li>- <?php echo htmlspecialchars($part->getName()); ?></li>
                    <?php endforeach; ?>
                    </ul>
                </details>
            <?php endif; ?>
            <?php if($product->getIngredients() != null): ?>
                <details style="margin-top: 10px;">
                    <summary style="cursor: pointer; font-weight: bold; color:rgb(0, 0, 0);">Zutaten</summary>
                    <ul style="list-style: none; padding: 0; margin: 10px 0; color: #555;">
                    <?php foreach($product->getIngredients() as $ingredient): ?>
                        <li>- <?php echo htmlspecialchars($ingredient); ?></li>
                    <?php endforeach; ?>
                    </ul>
                </details>
            <?php endif; ?>
            <?php if($product->getCalories() != null): ?>
                <p style="font-size: 14px; color: #777;">Energiewerte: <?php echo number_format($product->getCalories() * 4.184, 0); ?> KJ / <?php echo number_format($product->getCalories(), 0); ?> kcal</p>
            <?php endif; ?>
            <button class="btn btn-success" style="border-radius: 15px; padding: 10px 20px; background-color: #28a745; color: white; border: none; cursor: pointer; transition: background-color 0.3s ease, transform 0.2s ease;" 
                onmouseover="this.style.backgroundColor='#218838'; this.style.transform='scale(1.05)';" 
                onmouseout="this.style.backgroundColor='#28a745'; this.style.transform='scale(1)';" 
                onclick="addToCart(<?php echo $product->getKey(); ?>)">
                In den Warenkorb
            </button>
        </div>
    <?php endforeach; ?>
</div>
