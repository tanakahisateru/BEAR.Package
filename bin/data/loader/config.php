<?php
/**
 * This file is part of the BEAR.Package package
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */

$packageDir = dirname(dirname(dirname(__DIR__)));

require $packageDir . '/vendor/classpreloader/classpreloader/src/ClassPreloader/ClassLoader.php';
use ClassPreloader\ClassLoader;

$config = ClassLoader::getIncludes(
    function (ClassLoader $loader) use ($packageDir) {
        $loader->register();
        $app = require $packageDir . '/apps/Sandbox/scripts/instance.php';
    }
);

// Add a regex filter that requires that a class does not match the filter
$config
    ->addExclusiveFilter('/Sandbox/')
    ->addExclusiveFilter('/Doctrine\/Common\/Annotation/')
    ->addExclusiveFilter('/FirePHP/')
    ->addExclusiveFilter('/Smarty/');

return $config;
