<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$greeting = $request->query->get('greeting', 'tussikasvo');

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views');
$twig = new Twig_Environment(
    $loader,
    array(
        'cache' => __DIR__ . '/../cache',
        'debug' => true
    )
);

$body = $twig->render(
    'greeting.html.twig',
    [
        'greeting' => $greeting
    ]
);

$response = new Response($body, Response::HTTP_OK);
$response
    ->prepare($request)
    ->setPrivate()
    ->setExpires(new DateTime('1978-03-21'))
    ->send();



