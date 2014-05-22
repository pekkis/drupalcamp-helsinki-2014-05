<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Chtrupal\GreeterNeederNeedsMe;
use Chtrupal\GreeterNeedsMe;
use Chtrupal\Greeter;

$request = Request::createFromGlobals();
$greeting = $request->query->get('greeting', 'tussikasvo');

$needer1 = new GreeterNeederNeedsMe();
$needer2 = new GreeterNeedsMe($needer1);
$greeter = new Greeter($needer2);

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
        'greeting' => $greeting,
        'stuff' => $greeter->getStuff()
    ]
);

$response = new Response($body, Response::HTTP_OK);
$response
    ->prepare($request)
    ->setPrivate()
    ->setExpires(new DateTime('1978-03-21'))
    ->send();



