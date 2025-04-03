<?php
session_start();

require_once __DIR__ . '/repository/login.php';
require_once __DIR__ . '/repository/admin.php';

if (empty($_GET['till']) || empty($_GET['from'])) {
    $tillDay = date('Y-m-d');
    $fromDay = date('Y-m-d', strtotime('-7 days'));

    header('Location: http://localhost/admin.php?from=' . $fromDay . '&till=' . $tillDay);
    exit;
}

$user = getCurrentUser();
if ($user == null || !$user->getIsAdmin()) {
    http_response_code(response_code: 400);
    echo 'You are not allowed to view this site';
    exit;
}

$adminReport = getAdminReport($_GET['from'], $_GET['till']);
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">

    <title>Admin Dashboard</title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <link href="admin.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a href="#" class="navbar-brand">Mac Apple Admin Dashboard</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dashboard Übersicht</h5>
                        <p class="card-text text-muted">Leistungsübersicht von Mac Apple</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hauptmetriken -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card h-100 border-left-primary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders
                                </div>
                                <div class="h5 mb-0 font-weight-bold" id="total-orders"><?php echo number_format($adminReport->getOrderCount()); ?></div>
                            </div>
                            <div class="col-auto">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card h-100 border-left-success">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Revenue
                                </div>
                                <div class="h5 mb-0 font-weight-bold" id="total-revenue"><?php echo number_format($adminReport->getTotalRevenue(), 2); ?>€</div>
                            </div>
                            <div class="col-auto">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card h-100 border-left-info">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Average Order Value
                                </div>
                                <div class="h5 mb-0 font-weight-bold" id="avg-order"><?php echo number_format($adminReport->getAvgOrderPrice(), 2); ?>€</div>
                            </div>
                            <div class="col-auto">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3 mb-md-0">
                <div class="card h-100 border-left-warning">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Items Sold</div>
                                <div class="h5 mb-0 font-weight-bold" id="items-sold"><?php echo number_format($adminReport->getItemsSold()); ?></div>
                            </div>
                            <div class="col-auto">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik zu Verkäufen -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Verkaufszahlen</h5>
                        <div class="chart-container">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meist Bestellte Produkte und Kategorien -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Top 5 Produkte</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="top-products-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity Sold</th>
                                        <th>Revenue</th>
                                        <th>% of Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($adminReport->getTopProducts() as $product): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product->getName()); ?></td>
                                            <td><?php echo number_format($product->getTotalQuantity()); ?></td>
                                            <td><?php echo number_format($product->getTotalRevenue(), 2); ?>€</td>
                                            <td><?php echo number_format($product->getTotalPercentage(), 2); ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Top 5 Kategorien</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="top-categories-table">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Items Sold</th>
                                        <th>Revenue</th>
                                        <th>% of Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($adminReport->getTopCategories() as $product): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($product->getName()); ?></td>
                                            <td><?php echo number_format($product->getTotalQuantity()); ?></td>
                                            <td><?php echo number_format($product->getTotalRevenue(), 2); ?>€</td>
                                            <td><?php echo number_format($product->getTotalPercentage(), 2); ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="bootstrap.min.js"></script>
    <?php require_once __DIR__ . '/ajax/ajax.js.php'; ?>
    <script src="admin.js" defer></script>
</body>
