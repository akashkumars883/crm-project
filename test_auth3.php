<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u3 = \App\Models\User::create([
    'name' => 'Test Client 3',
    'email' => 'clienttest3@example.com',
    'password' => 'secret123',
    'company_id' => 1
]);

// Retrieve from DB to trigger casts
$userFromDb = \App\Models\User::find($u3->id);

// Update with Hash::make
$userFromDb->update([
    'password' => \Illuminate\Support\Facades\Hash::make('newpassword123')
]);

$credentials = [
    'email' => 'clienttest3@example.com',
    'password' => 'newpassword123'
];

$success = \Illuminate\Support\Facades\Auth::attempt($credentials);
echo "Auth Attempt Success for U3 (Update with Hash::make)? " . ($success ? "YES" : "NO") . "\n";
