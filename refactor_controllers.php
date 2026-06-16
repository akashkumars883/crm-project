<?php
$dir = new RecursiveDirectoryIterator('d:/Full Stack Dev/crm/app/Http/Controllers');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $file) {
    if(pathinfo($file, PATHINFO_EXTENSION) == 'php') {
        $content = file_get_contents($file);
        // Replace ->store('folder', 'public') with ->storeOnCloudinary('folder')->getSecurePath()
        $new_content = preg_replace('/->store\(([\'\"].+?[\'\"])\s*,\s*[\'\"]public[\'\"]\)/', '->storeOnCloudinary($1)->getSecurePath()', $content);
        if($content !== $new_content) {
            file_put_contents($file, $new_content);
            echo "Updated uploads in " . $file . "\n";
        }
    }
}
?>
