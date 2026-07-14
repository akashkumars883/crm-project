<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = \App\Models\User::whereHasRole('client')->get();
foreach($users as $u) {
    echo $u->email . " | pwd_len: " . strlen($u->password) . "\n";
}
