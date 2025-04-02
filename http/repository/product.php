<?php
require_once __DIR__ . '/../models/product.php';
require_once __DIR__ . '/db.php';

function loadAllProductCategories(&$products = array()) {
    $conn = createDbConnection();
    $sql = "call spGetAllProducts()";
    $conn->multi_query($sql);
   
    // Load first 3 resultsets as productCategories, products and ingredients
    $result = $conn->store_result();
    $categories = loadProductCategories($result);
    $result->free();

    $conn->next_result();
    $result = $conn->store_result();
    $products = loadProducts($result);
    $result->free();
    
    $conn->next_result();
    $result = $conn->store_result();
    $ingredients = loadIngredients($result);
    $result->free();

    // Map products to each category
    foreach ($products as $product) {
        $categories[$product->getCategoryKey()]->addProduct($product);
    }

    // Use the next resultset to resolve ingredients
    $conn->next_result();
    $result = $conn->store_result();
    while ($row = $result->fetch_assoc()) {
        $products[$row['nProductKey']]->addIngredient($ingredients[$row['nIngredientKey']]);
    }
    $result->free();

    // Use the next resultset to resolve menu products
    $conn->next_result();
    $result = $conn->store_result();
    while ($row = $result->fetch_assoc()) {
        $products[$row['nMenuKey']]->addInclude($products[$row['nProductKey']]);
    }
    $result->free();

    $conn->close();
   
    return $categories;
}

function loadAllProductsForCategory($categoryKey) {
    return loadAllProductCategories()[$categoryKey]->getProducts();
}

function loadProductCategories($result) {
    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[$row['nKey']] = new ProductCategory($row['nKey'], $row['szName'], array());
    }

    return $categories;
}

function loadProducts($result) {
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[$row['nKey']] = new Product($row['nKey'], $row['szName'], $row['nCalories'], $row['dPrice'], $row['szDescription'], $row['szImagePfad'], array(), $row['bIsMenu'], array(), $row['nProduct_CategoryKey']);
    }

    return $products;
}

function loadIngredients($result) {
    $ingredients = array();
    while ($row = $result->fetch_assoc()) {
        $ingredients[$row['nKey']] = $row['szName'];
    }

    return $ingredients;
}
?>
