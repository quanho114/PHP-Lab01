<?php

function getCustomerStatus(float $totalSpent): string
{
    if ($totalSpent >= 1000) {
        return 'VIP';
    } elseif ($totalSpent >= 300) {
        return 'Active';
    }

    return 'New';
}

function formatCustomerName(string $name): string
{
    return ucwords(strtolower($name));
}

function getTotalSpent(array $customers): float
{
    return array_reduce($customers, function ($carry, $customer) {
        return $carry + $customer['total_spent'];
    }, 0.0);
}

function getActiveCustomers(array $customers): array
{
    return array_values(array_filter($customers, function ($customer) {
        return $customer['orders_count'] > 0;
    }));
}
