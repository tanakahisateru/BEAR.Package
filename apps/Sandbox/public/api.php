<?php

/**
 * CLI Built-in web server for API
 *
 * This is an entry point for an API response based application build.
 *
 * Examples:
 *
 * CLI:
 * $ php api.pgp get page://self/
 * $ php api.pgp get 'page://first/greeting?name=koriym'
 *
 * Built-in web server:
 *
 * $ php -S localhost:8089 api.php
 *
 * @global  $mode
 */
use BEAR\Resource\Exception\Parameter as BadRequest;
use BEAR\Resource\Exception\ResourceNotFound as NotFound;

/**
 * The cache is cleared on each request via the following script. We understand that you may want to debug
 * your application with caching turned on. When doing so just comment out the following.
 */
require dirname(__DIR__) . '/scripts/clear.php';

/**
 * Here we get an application instance by setting a $mode variable such as (Prod, Dev, Api, Stub, Test)
 * the dev instance provides debugging tools and defaults to help you the development of your application.
 */
$mode = 'Api';
$app = require dirname(__DIR__) . '/scripts/instance.php';

/**
 * When using the CLI we set the router arguments needed for CLI use.
 * Otherwise just get the path directly from the globals.
 *
 * @var $app \BEAR\Package\Provide\Application\AbstractApp
 */
if (PHP_SAPI === 'cli') {
    $app->router->setArgv($argv);
    $uri = $argv[2];
    parse_str((isset(parse_url($uri)['query']) ? parse_url($uri)['query'] : ''), $get);
} else {
    $pathInfo = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '/index';
    $uri = 'app://self' . $pathInfo;
    $get = $_GET;
}

/**
 * Get the method from the router and attempt to request the resource and render.
 * On failure trigger the error handler.
 */
try {
    list($method,) = $app->router->match();
    $app->page = $app->resource->$method->uri($uri)->withQuery($get)->eager->request();
} catch (NotFound $e) {
    $code = 404;
    $body = 'Not Found';
    goto ERROR;
} catch (BadRequest $e) {
    $code = 400;
    $body = 'Bad Request';
    goto ERROR;
} catch (Exception $e) {
    $code = 503;
    $body = 'Service Unavailable';
    error_log((string)$e);
    goto ERROR;
}

/**
 * OK: Sets the response resources and renders
 * ERROR: sets the response code and loads error page.
 */
OK: {
    $app->response->setResource($app->page)->render()->send();
    exit(0);
}

ERROR: {
    http_response_code($code);
    echo $body;
    exit(1);
}
