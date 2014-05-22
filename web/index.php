<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$chtrupal = new \Chtrupal\Framework();

$response = $chtrupal->handle($request);

$response
    ->prepare($request)
    ->setPrivate()
    ->setExpires(new DateTime('1978-03-21'))
    ->send();
