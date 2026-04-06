<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    
    // Replace ' required ' with ' '
    $content = str_replace(' required ', ' ', $content);
    // Replace ' required>' with '>'
    $content = str_replace(' required>', '>', $content);
    // Replace ' required/>' with '/>'
    $content = str_replace(' required/>', '/>', $content);
    // Also handle required class="
    $content = str_replace(' required class=', ' class=', $content);
    $content = str_replace(' required value=', ' value=', $content);
    $content = str_replace(' required autofocus', ' autofocus', $content);
    $content = str_replace(' required minlength=', ' minlength=', $content);
    $content = str_replace(' required maxlength=', ' maxlength=', $content);
    
    file_put_contents($path, $content);
    echo "Processed: " . basename($path) . "\n";
}
echo "All 'required' attributes have been removed from input fields.";
