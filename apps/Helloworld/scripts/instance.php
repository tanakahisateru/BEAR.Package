<?php
/**
 * Application instance
 *
 * @package Helloworld
 */
namespace Helloworld;

use Helloworld\Module\AppModule;
use Ray\Di\Injector;

require_once __DIR__ . '/load.php';

$hasApc = function_exists('apc_fetch');
if ($hasApc && apc_exists('app-helloworld')) {
    return apc_fetch('app-helloworld');
}
$app = Injector::create([new AppModule])->getInstance('BEAR\Sunday\Extension\Application\AppInterface');
$hasApc ? apc_store('app-helloworld', $app) : null;

return $app;
