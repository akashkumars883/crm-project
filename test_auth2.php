<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u2 = \App\Models\User::create([
    'name' => 'Test Client 2',
    'email' => 'clienttest2@example.com',
    'password' => \Illuminate\Support\Facades\Hash::make('secret123'),
    'company_id' => 1
]);

$credentials = [
    'email' => 'clienttest2@example.com',
    'password' => 'secret123'
];

$success = \Illuminate\Support\Facades\Auth::attempt($credentials);
echo "Auth Attempt Success for U2 (Hash::make)? " . ($success ? "YES" : "NO") . "\n";
