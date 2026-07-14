<?php

$models = [
    'User', 'Customer', 'Lead', 'Project', 'Invoice', 'Bill', 
    'Expense', 'Ticket', 'Inventory', 'Vendor', 'Employee', 
    'AttendanceRecord', 'Activity', 'ProjectTask', 'Payment', 'Setting'
];

foreach ($models as $model) {
    $path = __DIR__ . '/app/Models/' . $model . '.php';
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        // Skip if already added
        if (strpos($content, 'BelongsToCompany') !== false) {
            continue;
        }

        // Add use statement at the top if not present
        if (strpos($content, 'use App\\Traits\\BelongsToCompany;') === false) {
            $content = preg_replace('/namespace App\\\\Models;/', "namespace App\\Models;\n\nuse App\\Traits\\BelongsToCompany;", $content);
        }

        // Add trait inside the class
        // Find the first occurrence of `use ` inside the class, or just after the opening brace `{`
        $pattern = '/class\s+' . $model . '.*?\n\{/';
        if (preg_match($pattern, $content, $matches)) {
            $replacement = $matches[0] . "\n    use BelongsToCompany;\n";
            $content = str_replace($matches[0], $replacement, $content);
            file_put_contents($path, $content);
            echo "Updated $model\n";
        }
    }
}
echo "Done.";
