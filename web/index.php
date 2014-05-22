<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Chtrupal\GreeterNeederNeedsMe;
use Chtrupal\GreeterNeedsMe;
use Chtrupal\Greeter;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$request = Request::createFromGlobals();
$greeting = $request->query->get('greeting', 'tussikasvo');

// DI

$container = new ContainerBuilder();

$container
    ->register('greeter', 'Chtrupal\Greeter')
    ->addArgument(new Reference('needer2'));

$container
    ->register('needer1', 'Chtrupal\GreeterNeederNeedsMe');

$container
    ->register('needer2', 'Chtrupal\GreeterNeedsMe')
    ->addArgument(new Reference('needer1'));

// Get service from DI
$greeter = $container->get('greeter');

// Twig

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



