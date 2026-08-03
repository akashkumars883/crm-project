<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== All Employees ===\n";
foreach (App\Models\Employee::all(['id','emp_id','name','email']) as $e) {
    echo "ID:{$e->id} | {$e->emp_id} | {$e->name} | {$e->email}\n";
}

echo "\n=== All EmployeeUser Links ===\n";
$links = App\Models\EmployeeUser::with('employee','user')->get();
foreach ($links as $l) {
    echo "EmpID:{$l->employee_id} ({$l->employee?->name}) -> UserID:{$l->user_id} ({$l->user?->name}) | email:{$l->user?->email}\n";
}

echo "\n=== All Users & Roles ===\n";
$users = App\Models\User::with('roles')->get();
foreach ($users as $u) {
    $roleNames = $u->roles->pluck('name')->implode(', ') ?: 'NO ROLE';
    echo "ID:{$u->id} | {$u->name} | {$u->email} | Roles: {$roleNames}\n";
}
