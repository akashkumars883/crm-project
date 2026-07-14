<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Assume password is 'password' (standard seed password) or let's create a fresh user to test
$u = \App\Models\User::create([
    'name' => 'Test Client',
    'email' => 'clienttest@example.com',
    'password' => 'secret123',
    'company_id' => 1
]);

$clientRole = \App\Models\Role::where('name', 'client')->first();
$u->addRole($clientRole);

$credentials = [
    'email' => 'clienttest@example.com',
    'password' => 'secret123'
];

$success = \Illuminate\Support\Facades\Auth::attempt($credentials);
echo "Auth Attempt Success? " . ($success ? "YES" : "NO") . "\n";
