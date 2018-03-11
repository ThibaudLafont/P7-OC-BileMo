<?php

use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';

if ('varnish' !== $proxyIp = gethostbyname('varnish')) {
    Request::setTrustedProxies([$proxyIp], Request::HEADER_FORWARDED);
}

$kernel = new AppKernel('prod', false);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
