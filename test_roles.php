<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$customers = App\Models\Customer::all();
foreach($customers as $c) {
    $u = $c->user;
    if(!$u) {
        echo "Customer {$c->id} has no user\n";
    } elseif ($u->roles()->count() == 0) {
        echo "User {$u->id} has no role\n";
    }
}
echo "Done\n";
