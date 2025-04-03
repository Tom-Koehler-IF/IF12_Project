<?php
session_start();

require_once __DIR__ . '/../repository/admin.php';

// This is a helper script for the admin sales diagram. 
// This is done as we need clientWidht and clientHeight for the diagram and like this we can easily pass it.

$width = (int) $_GET['clientWidth'];
$height = (int) $_GET['clientHeight'];
$data = getCachedSalesData();

if ($data === null || count($data) == 0) exit;

// Declare max values
$ordersMax = 0;
$revenueMax = 0;
$avgOrderMax = 0;
$itemsSoldMax = 0;

// Read all max values
foreach ($data as $daily) {
    if ($daily->getOrderCount() > $ordersMax) $ordersMax = $daily->getOrderCount();
    if ($daily->getTotalRevenue() > $revenueMax) $revenueMax = $daily->getTotalRevenue();
    if ($daily->getAvgOrderPrice() > $avgOrderMax) $avgOrderMax = $daily->getAvgOrderPrice();
    if ($daily->getItemsSold() > $itemsSoldMax) $itemsSoldMax = $daily->getItemsSold();
}

// Define some static helper
$padding = array('top' => 20, 'right' => 30, 'bottom' => 30, 'left' => 50);

$axisColor = '#6c757d';
$xAxisFontSize = '10px';
$xLinePosition = $height - $padding['bottom'];
$xLabelPosition = $height - $padding['bottom'] + 20;

$yAxisTicksCount = 6;
$yLabelPosition = $padding['left'] - 20;

// Function definitions
function xScale($index) {
    global $padding, $width, $data;
    return $padding['left'] + $index * (($width - $padding['left'] - $padding['right']) / (count($data) - 1)); 
};

function yScale($max, $value) {
    global $height, $padding;
    if ($max == 0) return $height - $padding['bottom'];
    return $height - $padding['bottom'] - (($height - $padding['top'] - $padding['bottom']) * ($value / ($max * 1.1)));
}

// Baut einen graph als path mit einer klasse. Erwartet attributes, einen max wert und einen value accessor (Um den wert für einen index zu lesen)
function drawGraphLine($class, $max, callable $yAccessor) {
    global $data;
    // Pfad beginnt mit einem M als startpunkt
    $path = 'M ' . xScale(0) . ' ' . yScale($max, $yAccessor(0));

    for ($i = 1; $i < count($data); $i++) {
        $path .= ' L ' . xScale($i) . ' ' . yScale($max, $yAccessor($i));
    }

    echo '<path d="' . $path . '" class="line ' . $class . '"></path>';
}

// Start outputting html
echo '<svg width="' . $width . '" height="' . $height . '">';
    // X-Achse
    echo '<g class="axis x-axis">';
        // Linie der X-Achse
        echo '<line x1="' . $padding['left'] . '" y1="' . $xLinePosition. '" x2="' . ($width - $padding['right']) . '" y2="' . $xLinePosition . '" stroke="' . $axisColor . '"></line>';

        // TODO: Fix how much dates are shown
        for ($i = 0; $i < count($data); $i += 5) {
            // Calcaulte the x position for index
            $x = xScale($i);
            // TODO: This should already be a date
            $date = new DateTime($data[$i]->getDate());
            $dateStr = $date->format('F d'); 

            // Label Text
            echo '<text x="' . $x . '" y="' . $xLabelPosition . '" text-anchor="middle"' . 'fill="' . $axisColor . '" font-size="' . $xAxisFontSize . '">' . $dateStr . '</text>';
            // Linie über text an der xAchse
            echo '<line x1="' . $x . '" y1="' . $xLinePosition . '" x2="' . $x . '" y2="' . ($xLabelPosition - 15) . '" stroke="' . $axisColor . '"></line>';
        }
    echo '</g>';

    // Y-Achse
    echo '<g class="axis y-axis">';
        // Linie der Y-Achse
        echo '<line x1="' . $padding['left'] . '" y1="' . $padding['top'] . '" x2="' . $padding['left'] . '" y2="' . $xLinePosition . '" stroke="' . $axisColor . '"></line>';
                                    
        // Kleine seitenteile (Werden erstmal immer 5 sein für aufträge)
        for ($i = 0; $i <= $yAxisTicksCount; $i++) {
            // Alle ticks für gleichmäßig verteilte werte anzeigen
            $value = round($ordersMax * ($i / $yAxisTicksCount));
            $y = yScale($ordersMax, $value);

            // Label Text ($y + 5 weil text platz einnimmt)
            echo '<text x="' . $yLabelPosition . '" y="' . $y + 5 . '" fill="' . $axisColor . '" font-size="10px">' . $value . '</text>';
            // Linien im Diagramm
            echo '<line x1="' . $padding['left'] . '" y1="' . $y . '" x2="' . ($width - $padding['right']) . '" y2="' . $y . '" stroke="' . $axisColor . '" stroke-opacity="0.1" stroke-dasharray="2,2"></line>';
        }
    echo '</g>';

    // Linie für Order
    drawGraphLine('line-orders', $ordersMax, function($i) { global $data; return $data[$i]->getOrderCount(); });

    // Linie für Umsatz
    drawGraphLine('line-revenue', $revenueMax, function($i) { global $data; return $data[$i]->getTotalRevenue(); });

    // Linie für durchschnittsauftrag
    drawGraphLine('line-avg-order', $avgOrderMax, function($i) { global $data; return $data[$i]->getAvgOrderPrice(); });

    // Linie für gesamtverkäufe
    drawGraphLine('line-items-sold', $itemsSoldMax, function($i) { global $data; return $data[$i]->getItemsSold();});                                
echo '</svg>';
?>