<?php
require_once __DIR__ . '/repository/order.php';

if (empty($_GET['orderNumber'])) {
    http_response_code(404);
    echo 'Order not found';
    exit;
}

$invoice = getInvoice($_GET['orderNumber']);
if (!$invoice) {
    http_response_code(404);
    echo 'Order not found';
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">

    <title>Bestellübersicht</title>
    <link href="bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <script src="bootstrap.min.js"></script>

    <div class="container mt-5">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="mb-3">Bestellübersicht</h1>
                <p class="text-muted">Mac Apple</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1"><strong>Bestellnummer:</strong> #<?php echo $invoice->getOrderNumber(); ?></p>
                <p class="mb-1"><strong>Datum:</strong> <?php echo $invoice->getOrderTime(); ?></p>
            </div>
        </div>

        <!-- Kundendaten -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Kundendaten</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Name:</strong> <?php echo $invoice->getCustomer()->getFirstName() . ' ' . $invoice->getCustomer()->getLastName(); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Adresse:</strong></p>
                        <p class="mb-1"><?php echo $invoice->getCustomer()->getStreet() . ' ' . $invoice->getCustomer()->getHomeNumber(); ?></p>
                        <p class="mb-1"><?php echo $invoice->getCustomer()->getPostalCode() . ' ' . $invoice->getCustomer()->getCity(); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bestelltabelle -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Bestellte Artikel</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Artikel</th>
                                <th>Anzahl</th>
                                <th class="text-end">Einzelpreis</th>
                                <th class="text-end">Gesamtpreis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($invoice->getOrderProducts() as $orderProduct): ?>
                                <tr>
                                    <td><?php echo $orderProduct->getName(); ?></td>
                                    <td><?php echo $orderProduct->getQuantity(); ?></td>
                                    <td class="text-end"><?php echo number_format($orderProduct->getPrice()); ?> €</td>
                                    <td class="text-end"><?php echo number_format($orderProduct->getTotalPrice()); ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Gesamtbeträge -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Zahlungsübersicht</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><strong>Zwischensumme (Netto):</strong></td>
                                    <td class="text-end"><?php echo number_format($invoice->getPrice()->getNetto(), 2);?> €</td>
                                </tr>
                                <tr>
                                    <td><strong>MwSt. (7%):</strong></td>
                                    <td class="text-end"><?php echo number_format($invoice->getPrice()->getMws());?> €</td>
                                </tr>
                                <tr class="border-top">
                                    <td><strong>Gesamtbetrag (Brutto):</strong></td>
                                    <td class="text-end"><strong><?php echo number_format($invoice->getPrice()->getBrutto());?> €</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fußzeile -->
        <div class="mt-4 text-center">
            <p class="text-muted">Vielen Dank für deine Bestellung!</p>
        </div>

        <div class="mt-4 text-center">
            <a href="/">Zurück zur Startsetie</a>
        </div>
    </div>
</body>

</html>
