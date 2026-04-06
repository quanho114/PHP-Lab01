<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Customer Management</title>
</head>
<body>
    <h1>Mini Customer Management App</h1>
    <ul>
        <?php foreach ($customers as $customer): ?>
            <li>
                <?= htmlspecialchars(formatCustomerName($customer['name']), ENT_QUOTES, 'UTF-8') ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
