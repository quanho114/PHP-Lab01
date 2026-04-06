<?php

$customers = require __DIR__ . '/../src/Data/customers.php';
require __DIR__ . '/../src/Helpers/functions.php';

$totalCustomers = count($customers);
$totalSpent = getTotalSpent($customers);
$activeCustomers = getActiveCustomers($customers);
$activeCount = count($activeCustomers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers</title>
</head>
<body>
    <h1>Customer List</h1>

    <h2>Statistics</h2>
    <ul>
        <li>Total customers: <?php echo $totalCustomers; ?></li>
        <li>Total spent: $<?php echo number_format($totalSpent, 2); ?></li>
        <li>Active customers: <?php echo $activeCount; ?></li>
    </ul>

    <h2>Customer Details</h2>

    <?php foreach ($customers as $customer): ?>
        <div style="margin-bottom: 16px; padding: 8px; border: 1px solid #ccc;">
            <p><strong>Name:</strong> <?php echo formatCustomerName($customer['name']); ?></p>
            <p><strong>Email:</strong> <?php echo $customer['email']; ?></p>
            <p><strong>Group:</strong> <?php echo $customer['group']; ?></p>
            <p><strong>Orders:</strong> <?php echo $customer['orders_count']; ?></p>
            <p><strong>Total Spent:</strong> $<?php echo number_format($customer['total_spent'], 2); ?></p>
            <p><strong>Status:</strong> <?php echo getCustomerStatus($customer['total_spent']); ?></p>
        </div>
    <?php endforeach; ?>
</body>
</html>