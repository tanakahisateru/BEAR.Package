<?php

namespace Helloworld;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;

$packageDir = dirname(dirname(dirname(__DIR__)));

// Annotation auto loader
$loader = require $packageDir . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);
AnnotationReader::addGlobalIgnoredName('noinspection');
unset($packageDir);
