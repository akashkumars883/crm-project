<?php
$dir = new RecursiveDirectoryIterator('d:/Full Stack Dev/crm/resources/views');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if(pathinfo($file, PATHINFO_EXTENSION) == 'php') {
        $content = file_get_contents($file);
        $new_content = preg_replace('/asset\(\'storage\/\'\s*\.\s*(.+?)\)/', '(\\Illuminate\\Support\\Str::startsWith($1, \'http\') ? $1 : asset(\'storage/\' . $1))', $content);
        if($content !== $new_content) {
            file_put_contents($file, $new_content);
            echo 'Updated ' . $file . "\n";
        }
    }
}
?>
