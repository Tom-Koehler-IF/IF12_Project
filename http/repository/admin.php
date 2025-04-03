<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../models/admin.php';

function getAdminReport($from, $till) {
    if (!isValidDate($from) || !isValidDate($till)) return null;

    $conn = createDbConnection();
    $sql = "call spGetAdminReport('$from', '$till')";
    $conn->multi_query($sql);

    $result = $conn->store_result();
    $row = $result->fetch_assoc();
    $orderCount = $row['nOrderCount'];
    $totalRevenue = $row['dTotalRevenue'];
    $avgOrderPrice = $row['dAvgOrderPrice'];
    $itemsSold = $row['nItemsSold'];
    $result->free();

    $conn->next_result();
    $result = $conn->store_result();
    $dailyData = array();
    while ($row = $result->fetch_assoc()) {
        $dailyData[] = readDailyDataFromRow($row);
    }
    $result->free();

    $conn->next_result();
    $result = $conn->store_result();
    $topProducts = array();
    while ($row = $result->fetch_assoc()) {
        $topProducts[] = readTableDataFromRow($row);
    }
    $result->free();

    $conn->next_result();
    $result = $conn->store_result();
    $topCategories = array();
    while ($row = $result->fetch_assoc()) {
        $topCategories[] = readTableDataFromRow($row);
    }
    $result->free();
    
    $conn->close();

    // Here we also always cache the sales data in the session for later graph retreival
    $_SESSION['admin']['sales'] = serialize($dailyData);

    return new AdminReport($orderCount, $totalRevenue, $avgOrderPrice, $itemsSold, $dailyData, $topProducts, $topCategories);
}

function getCachedSalesData() {
    if (isset($_SESSION['admin']['sales'])) return unserialize($_SESSION['admin']['sales']);
    else null;
}

function isValidDate($date) {
    return preg_match('/^\d{4}-\d{1,2}-\d{1,2}$/', $date);
}

function readDailyDataFromRow($row) {
    return new DailyData($row['dtDay'], $row['nOrderCount'], $row['dTotalRevenue'], $row['dAvgOrderPrice'], $row['nItemsSold']);
}

function readTableDataFromRow($row) {
    return new TableData($row['szName'], $row['nTotalQuantity'], $row['dTotalRevenue'], $row['dTotalPercentage']);
}

?>
