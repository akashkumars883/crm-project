<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SubscriptionPlan;

$plans = [
    [
        'name' => 'Free',
        'price' => 0.00,
        'max_users' => 1,
        'max_customers' => 10,
        'max_projects' => 5,
        'is_active' => true,
    ],
    [
        'name' => 'Basic',
        'price' => 1999.00,
        'max_users' => 5,
        'max_customers' => 100,
        'max_projects' => 50,
        'is_active' => true,
    ],
    [
        'name' => 'Pro',
        'price' => 4999.00,
        'max_users' => 20,
        'max_customers' => 500,
        'max_projects' => 250,
        'is_active' => true,
    ],
    [
        'name' => 'Enterprise',
        'price' => 9999.00,
        'max_users' => 100,
        'max_customers' => 5000,
        'max_projects' => 2500,
        'is_active' => true,
    ]
];

foreach ($plans as $planData) {
    SubscriptionPlan::updateOrCreate(
        ['name' => $planData['name']],
        $planData
    );
}

echo "Subscription plans seeded successfully.\n";
