<?php
include (dirname(__DIR__ ) . '/vendor/Autoload.php');
$config = include(dirname(__DIR__ ) . '/main/config.php');
$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
$kernel = new \App\main\Kernel($config, $request);
echo $kernel->start();
