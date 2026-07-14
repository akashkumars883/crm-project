<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::whereHasRole('client')->first();
if ($user) {
    echo "Email: " . $user->email . "\n";
    echo "Hash: " . $user->password . "\n";
    echo "Double Hash Check? " . (\Illuminate\Support\Facades\Hash::needsRehash($user->password) ? 'YES' : 'NO') . "\n";
    
    // Let's create a test user with Hash::make vs without Hash::make
    $u1 = new \App\Models\User();
    $u1->password = \Illuminate\Support\Facades\Hash::make('password123');
    echo "U1 Hash: " . $u1->password . "\n";
    echo "U1 Check: " . (\Illuminate\Support\Facades\Hash::check('password123', $u1->password) ? 'OK' : 'FAIL') . "\n";
}
