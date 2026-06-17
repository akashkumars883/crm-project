<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permission;
use App\Models\Role;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Illuminate\Support\Str;

class SeedPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract all permissions used in controllers and seed them to the database, then map to roles.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Extracting permissions from controllers...');
        
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(app_path('Http/Controllers')));
        $perms = [];
        
        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());
                preg_match_all('/hasPermission\(\\\'([a-zA-Z0-9\-]+)\\\'/', $content, $matches);
                if (!empty($matches[1])) {
                    $perms = array_merge($perms, $matches[1]);
                }
            }
        }
        
        $perms = array_unique($perms);
        sort($perms);

        $this->info('Found ' . count($perms) . ' unique permissions.');

        $roles = [
            'super-admin' => Role::firstOrCreate(['name' => 'super-admin']),
            'admin' => Role::firstOrCreate(['name' => 'admin']),
            'manager' => Role::firstOrCreate(['name' => 'manager']),
            'supervisor' => Role::firstOrCreate(['name' => 'supervisor']),
            'client' => Role::firstOrCreate(['name' => 'client']),
            'vendor' => Role::firstOrCreate(['name' => 'vendor']),
            'employee' => Role::firstOrCreate(['name' => 'employee']),
        ];

        $rolePermissions = [
            'super-admin' => [],
            'admin' => [],
            'manager' => [],
            'supervisor' => [],
            'client' => [],
            'vendor' => [],
            'employee' => [],
        ];

        foreach ($perms as $permName) {
            $permission = Permission::firstOrCreate([
                'name' => $permName,
            ], [
                'display_name' => Str::title(str_replace('-', ' ', $permName)),
                'description' => 'Can ' . str_replace('-', ' ', $permName),
            ]);

            $id = $permission->id;

            // Assign to super-admin and admin
            $rolePermissions['super-admin'][] = $id;
            $rolePermissions['admin'][] = $id;

            // Logic to assign permissions based on keywords
            if (Str::startsWith($permName, 'my-') || in_array($permName, ['create-ticket', 'read-ticket'])) {
                $rolePermissions['client'][] = $id;
                $rolePermissions['manager'][] = $id;
                $rolePermissions['supervisor'][] = $id;
            }

            if (Str::startsWith($permName, 'vendor-')) {
                $rolePermissions['vendor'][] = $id;
            }

            if (in_array($permName, ['employee-bills', 'employee-profile', 'my-attendance', 'my-bank-accounts'])) {
                $rolePermissions['employee'][] = $id;
            }

            // Manager usually gets a lot of permissions
            if (Str::contains($permName, ['project', 'lead', 'customer', 'inventory', 'invoice', 'bill', 'payment', 'attendance', 'activity', 'ticket'])) {
                if (!Str::contains($permName, ['delete-'])) {
                    $rolePermissions['manager'][] = $id;
                }
            }
            
            // Supervisor gets read permissions for projects and leads, etc.
            if (Str::startsWith($permName, 'read-') && Str::contains($permName, ['project', 'lead', 'customer', 'inventory', 'attendance', 'activity'])) {
                $rolePermissions['supervisor'][] = $id;
            }
        }

        // Sync in bulk to save database queries and prevent timeouts
        foreach ($roles as $roleName => $roleObj) {
            if (!empty($rolePermissions[$roleName])) {
                $roleObj->permissions()->syncWithoutDetaching(array_unique($rolePermissions[$roleName]));
            }
        }

        $this->info('Permissions seeded and assigned successfully.');
    }
}
