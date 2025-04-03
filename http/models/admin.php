
<?php

class AdminReport {
    // General information
    private $orderCount;
    private $totalRevenue;
    private $avgOrderPrice;
    private $itemsSold;
    
    // Daily data
    private $dailyData;
    // Table data
    private $topProducts;
    private $topCategories;

    public function __construct($orderCount, $totalRevenue, $avgOrderPrice, $itemsSold, $dailyData, $topProducts, $topCategories)
    {
        $this->orderCount = $orderCount;
        $this->totalRevenue = $totalRevenue;
        $this->avgOrderPrice = $avgOrderPrice;
        $this->itemsSold = $itemsSold;
        $this->dailyData = $dailyData;
        $this->topProducts = $topProducts;
        $this->topCategories = $topCategories;
    }

    public function getOrderCount() { return $this->orderCount; }
    public function getTotalRevenue() { return $this->totalRevenue; }
    public function getAvgOrderPrice() { return $this->avgOrderPrice; }
    public function getItemsSold() { return $this->itemsSold; }

    public function getDailyData() { return $this->dailyData; }

    public function getTopProducts() { return $this->topProducts; }
    public function getTopCategories() { return $this->topCategories; }
}

class DailyData implements Serializable {
    private $date;
    private $orderCount;
    private $totalRevenue;
    private $avgOrderPrice;
    private $itemsSold;

    public function __construct($date, $orderCount, $totalRevenue, $avgOrderPrice, $itemsSold) 
    {
        $this->date = $date;
        $this->orderCount = $orderCount;
        $this->totalRevenue = $totalRevenue;
        $this->avgOrderPrice = $avgOrderPrice;
        $this->itemsSold = $itemsSold;
    }

    public function getDate() { return $this->date; }
    public function getOrderCount() { return $this->orderCount; }
    public function getTotalRevenue() { return $this->totalRevenue; }
    public function getAvgOrderPrice() { return $this->avgOrderPrice; }
    public function getItemsSold() { return $this->itemsSold; }

    public function serialize() {
        // Serialize all properties, including parent class properties
        return serialize([
            'date' => $this->date,
            'orderCount' => $this->orderCount,
            'totalRevenue' => $this->totalRevenue,
            'avgOrderPrice' => $this->avgOrderPrice,
            'itemsSold'=> $this->itemsSold
        ]);
    }

    public function unserialize($data) {
        // Unserialize the data
        $props = unserialize($data);

        // Reconstruct the object using the constructor
        $this->__construct(
            $props['date'],
            $props['orderCount'],
            $props['totalRevenue'],
            $props['avgOrderPrice'],
            $props['itemsSold'],
        );
    }
}

class TableData {
    private $name;
    private $totalQuantity;
    private $totalRevenue;
    private $totalPercentage;

    public function __construct($name, $totalQuantity, $totalRevenue, $totalPercentage)
    {
        $this->name = $name;
        $this->totalQuantity = $totalQuantity;
        $this->totalRevenue = $totalRevenue;
        $this->totalPercentage = $totalPercentage;
    }

    public function getName() { return $this->name; }
    public function getTotalQuantity() { return $this->totalQuantity; }
    public function getTotalRevenue() { return $this->totalRevenue; }
    public function getTotalPercentage() { return $this->totalPercentage; }
}

?>
