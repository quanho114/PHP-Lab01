<?php

$customers = require __DIR__ . '/../src/Data/customers.php';
require __DIR__ . '/../src/Helpers/functions.php';

$status = $_GET['status'] ?? 'all';
$query = trim($_GET['q'] ?? '');
$sort = $_GET['sort'] ?? 'none';

$allowedStatuses = ['all', 'VIP', 'Active', 'New'];
$allowedSorts = ['none', 'spent_desc', 'spent_asc', 'name_asc'];

if (!in_array($status, $allowedStatuses, true)) {
    $status = 'all';
}

if (!in_array($sort, $allowedSorts, true)) {
    $sort = 'none';
}

$filteredCustomers = array_values(array_filter($customers, function ($customer) use ($status, $query) {
    $matchesStatus = $status === 'all' || getCustomerStatus($customer['total_spent']) === $status;

    if ($query === '') {
        return $matchesStatus;
    }

    $matchesQuery = stripos($customer['name'], $query) !== false || stripos($customer['email'], $query) !== false;

    return $matchesStatus && $matchesQuery;
}));

if ($sort === 'spent_desc') {
    usort($filteredCustomers, function ($a, $b) {
        return $b['total_spent'] <=> $a['total_spent'];
    });
} elseif ($sort === 'spent_asc') {
    usort($filteredCustomers, function ($a, $b) {
        return $a['total_spent'] <=> $b['total_spent'];
    });
} elseif ($sort === 'name_asc') {
    usort($filteredCustomers, function ($a, $b) {
        return strcmp(formatCustomerName($a['name']), formatCustomerName($b['name']));
    });
}

$totalCustomers = count($filteredCustomers);
$totalSpent = getTotalSpent($filteredCustomers);
$activeCustomers = getActiveCustomers($filteredCustomers);
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

    <h2>Filter and Search</h2>
    <form method="get" action="">
        <label>
            Status:
            <select name="status">
                <option value="all" <?php echo $status === 'all' ? 'selected' : ''; ?>>All</option>
                <option value="VIP" <?php echo $status === 'VIP' ? 'selected' : ''; ?>>VIP</option>
                <option value="Active" <?php echo $status === 'Active' ? 'selected' : ''; ?>>Active</option>
                <option value="New" <?php echo $status === 'New' ? 'selected' : ''; ?>>New</option>
            </select>
        </label>

        <label>
            Search name/email:
            <input type="text" name="q" value="<?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?>">
        </label>

        <label>
            Sort:
            <select name="sort">
                <option value="none" <?php echo $sort === 'none' ? 'selected' : ''; ?>>Default</option>
                <option value="spent_desc" <?php echo $sort === 'spent_desc' ? 'selected' : ''; ?>>Spent high to low</option>
                <option value="spent_asc" <?php echo $sort === 'spent_asc' ? 'selected' : ''; ?>>Spent low to high</option>
                <option value="name_asc" <?php echo $sort === 'name_asc' ? 'selected' : ''; ?>>Name A-Z</option>
            </select>
        </label>

        <button type="submit">Apply</button>
    </form>

    <h2>Statistics</h2>
    <ul>
        <li>Total customers (filtered): <?php echo $totalCustomers; ?></li>
        <li>Total spent: $<?php echo number_format($totalSpent, 2); ?></li>
        <li>Active customers: <?php echo $activeCount; ?></li>
    </ul>

    <h2>Customer Details</h2>

    <?php if ($totalCustomers === 0): ?>
        <p>No customers found with current filter/search.</p>
    <?php endif; ?>

    <?php foreach ($filteredCustomers as $customer): ?>
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
