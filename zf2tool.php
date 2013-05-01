<?php
$path = $argv[1];

$edit = function ($file) {
	if (! file_exists($file) || is_dir($file)) {
		return;
	}
	$contents = file_get_contents($file);
	// empty docblocks
	$contents = preg_replace('#\n\/\*\*[ ]*\n \*\/#', '', $contents);
	// trailing empty docblocks
	$contents = preg_replace('#\n \*[ ]*(\n \*\/)#', '$1', $contents);
	file_put_contents($file, $contents);
};

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
foreach($iterator as $file) {
    $edit($file);
}