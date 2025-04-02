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
                                <div class="h5 mb-0 font-weight-bold" id="total-orders">1,245</div>
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
                                <div class="h5 mb-0 font-weight-bold" id="total-revenue">$24,568</div>
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
                                <div class="h5 mb-0 font-weight-bold" id="avg-order">$19.73</div>
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
                                <div class="h5 mb-0 font-weight-bold" id="items-sold">3,687</div>
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
                            <?php
                                $width = 800;
                                $height = 300;
                                $ordersMax = 55;
                                $revenueMax = 1150;
                                $avgOrderMax = 20.91;
                                $data = [
                                    ['date' => '2023-05-01', 'orders' => 35, 'revenue' => 720, 'avgOrder' => 20.57],
                                    ['date' => '2023-05-02', 'orders' => 32, 'revenue' => 680, 'avgOrder' => 21.25],
                                    ['date' => '2023-05-03', 'orders' => 30, 'revenue' => 610, 'avgOrder' => 20.33],
                                    ['date' => '2023-05-04', 'orders' => 38, 'revenue' => 790, 'avgOrder' => 20.79],
                                    ['date' => '2023-05-05', 'orders' => 42, 'revenue' => 850, 'avgOrder' => 20.24],
                                    ['date' => '2023-05-06', 'orders' => 50, 'revenue' => 1020, 'avgOrder' => 20.40],
                                    ['date' => '2023-05-07', 'orders' => 55, 'revenue' => 1150, 'avgOrder' => 20.91],
                                    ['date' => '2023-05-08', 'orders' => 48, 'revenue' => 980, 'avgOrder' => 20.42],
                                    ['date' => '2023-05-09', 'orders' => 43, 'revenue' => 850, 'avgOrder' => 19.77],
                                    ['date' => '2023-05-10', 'orders' => 41, 'revenue' => 810, 'avgOrder' => 19.76],
                                    ['date' => '2023-05-11', 'orders' => 37, 'revenue' => 740, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-12', 'orders' => 40, 'revenue' => 820, 'avgOrder' => 20.50],
                                    ['date' => '2023-05-13', 'orders' => 45, 'revenue' => 910, 'avgOrder' => 20.22],
                                    ['date' => '2023-05-14', 'orders' => 52, 'revenue' => 1060, 'avgOrder' => 20.38],
                                    ['date' => '2023-05-15', 'orders' => 53, 'revenue' => 1100, 'avgOrder' => 20.75],
                                    ['date' => '2023-05-16', 'orders' => 48, 'revenue' => 950, 'avgOrder' => 19.79],
                                    ['date' => '2023-05-17', 'orders' => 43, 'revenue' => 860, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-18', 'orders' => 40, 'revenue' => 800, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-19', 'orders' => 43, 'revenue' => 840, 'avgOrder' => 19.53],
                                    ['date' => '2023-05-20', 'orders' => 45, 'revenue' => 900, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-21', 'orders' => 47, 'revenue' => 930, 'avgOrder' => 19.79],
                                    ['date' => '2023-05-22', 'orders' => 42, 'revenue' => 820, 'avgOrder' => 19.52],
                                    ['date' => '2023-05-23', 'orders' => 38, 'revenue' => 750, 'avgOrder' => 19.74],
                                    ['date' => '2023-05-24', 'orders' => 36, 'revenue' => 720, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-25', 'orders' => 38, 'revenue' => 760, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-26', 'orders' => 40, 'revenue' => 800, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-27', 'orders' => 45, 'revenue' => 880, 'avgOrder' => 19.56],
                                    ['date' => '2023-05-28', 'orders' => 50, 'revenue' => 1000, 'avgOrder' => 20.00],
                                    ['date' => '2023-05-29', 'orders' => 52, 'revenue' => 1050, 'avgOrder' => 20.19],
                                    ['date' => '2023-05-30', 'orders' => 48, 'revenue' => 960, 'avgOrder' => 20.00],
                                ];                                
                                $padding = array('top' => 20, 'right' => 30, 'bottom' => 30, 'left' => 50);

                                $axisColor = '#6c757d';
                                $xAxisFontSize = '10px';
                                $xLinePosition = $height - $padding['bottom'];
                                $xLabelPosition = $height - $padding['bottom'] + 20;

                                $yAxisTicksCount = 6;
                                $yLabelPosition = $padding['left'] - 20;

                                function xScale($index) {
                                    global $padding, $width, $data;
                                    return $padding['left'] + $index * (($width - $padding['left'] - $padding['right']) / (count($data) - 1)); 
                                };

                                function yScale($max, $value) {
                                    global $height, $padding;
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

                                function createLegendItem($text, $color, $xOffset) {
                                    echo '<g transform="translate(' . $xOffset . ', 0)">';
                                        echo '<rect width="12" height="12" fill="' . $color . '"></rect>';
                                        echo '<text x="16" y="10" fill="#212529" font-size="10-px">' . $text . '</text>';
                                    echo '</g>';
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
                                            $dateStr = new DateTime($data[$i]['date'])->format('F d');

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
                                    drawGraphLine('line-orders', $ordersMax, function($i) { global $data; return $data[$i]['orders']; });

                                    // Linie für Umsatz
                                    drawGraphLine('line-revenue', $revenueMax, function($i) { global $data; return $data[$i]['revenue']; });

                                    // Linie für durchschnittsauftrag
                                    drawGraphLine('line-avg-order', $avgOrderMax, function($i) { global $data; return $data[$i]['avgOrder']; });
                                
                                    // Legende
                                    echo '<g class="chart-legend" transform="translate(' . ($padding['left'] + 20) . ', ' . ($padding['top']) . ')">';
                                        createLegendItem('Orders', 'var(--bs-primary)', 0);
                                        createLegendItem('Umsatz', 'var(--bs-success)', 80);
                                        createLegendItem('Avg Order', 'var(--bs-info)', 160);
                                    echo '</g>';
                                
                                echo '</svg>';
                            ?>
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
                        <h6 class="m-0 font-weight-bold">Top 5 Products</h6>
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
                                    <!-- TODO: PHP -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Top 5 Categories</h6>
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
                                    <!-- TODO: PHP -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bestellzeiten diagramm -->
         <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Häufigste Bestellzeiten</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <?php 
                            $orderTimes = [
                                ['hour' => '6-7 AM', 'count' => 34],
                                ['hour' => '7-8 AM', 'count' => 67],
                                ['hour' => '8-9 AM', 'count' => 93],
                                ['hour' => '9-10 AM', 'count' => 78],
                                ['hour' => '10-11 AM', 'count' => 51],
                                ['hour' => '11-12 PM', 'count' => 124],
                                ['hour' => '12-1 PM', 'count' => 189],
                                ['hour' => '1-2 PM', 'count' => 142],
                                ['hour' => '2-3 PM', 'count' => 87],
                                ['hour' => '3-4 PM', 'count' => 65],
                                ['hour' => '4-5 PM', 'count' => 79],
                                ['hour' => '5-6 PM', 'count' => 112],
                                ['hour' => '6-7 PM', 'count' => 157],
                                ['hour' => '7-8 PM', 'count' => 143],
                                ['hour' => '8-9 PM', 'count' => 96],
                                ['hour' => '9-10 PM', 'count' => 69],
                                ['hour' => '10-11 PM', 'count' => 42],
                                ['hour' => '11-12 AM', 'count' => 21],
                            ];     
                            $maxCount = 189;
                            $barWidth = ($width - $padding['left'] - $padding['right']) / count($orderTimes) * 0.8;
                            $barSpacing = ($width - $padding['left'] - $padding['right']) / count($orderTimes) * 0.2;
                            
                            function xScaleBar($index) {
                                global $padding, $barWidth, $barSpacing;
                                return $padding['left'] + ($index * ($barWidth + $barSpacing)) + ($barSpacing / 2);
                            }

                            function yScaleBar($value) {
                                global $padding, $height, $maxCount;
                                return $height - $padding['bottom'] - (($height - $padding['top'] - $padding['bottom']) * ($value / ($maxCount * 1.1)));
                            }

                            echo '<svg width="' . $width . '" height="' . $height . '">';
                                // X-Achse
                                echo '<g class="axis x-axis">';
                                    // Linie
                                    echo '<line x1="' . $padding['left'] . '" y1="' . $xLinePosition. '" x2="' . ($width - $padding['right']) . '" y2="' . $xLinePosition . '" stroke="' . $axisColor . '"></line>';
                                    // Texte
                                    for ($i = 0; $i < $orderTimes; $i++) {
                                        $item = $orderTimes[$i];
                                        $x = xScaleBar($i) + ($barWidth / 2);

                                        echo '<text x="' . $x . '" y="' . $xLabelPosition . '" text-anchor="middle"' . 'fill="' . $axisColor . '" font-size="8px" transform="rotate(45, ' . $x . ', ' . $xLabelPosition .')">' . $item['hour'] . '</text>';
                                    }
                                echo '</g>';
                            echo '</svg>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>

    <script src="bootstrap.min.js"></script>
</body>