<?php
include(dirname(__DIR__) . '/vendor/autoload.php');
$kernel = new \App\main\Kernel(
    new \App\main\Container(
        include(dirname(__DIR__) . '/main/config.php')
    )
);
echo $kernel->start();
