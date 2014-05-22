<?php

namespace Chtrupal;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\DependencyInjection\ContainerAwareHttpKernel;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Twig_Loader_Filesystem;
use Twig_Environment;

class Framework extends ContainerAwareHttpKernel
{
    public function __construct()
    {
        // Di
        $container = new ContainerBuilder();

        $container
            ->register('greeter', 'Chtrupal\Greeter')
            ->addArgument(new Reference('needer2'));

        $container
            ->register('needer1', 'Chtrupal\GreeterNeederNeedsMe');

        $container
            ->register('needer2', 'Chtrupal\GreeterNeedsMe')
            ->addArgument(new Reference('needer1'));

        // Twig
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../../views');
        $twig = new Twig_Environment(
            $loader,
            array(
                'cache' => __DIR__ . '/../../cache',
                'debug' => true
            )
        );

        // Greetings controller
        $greetings = function(Request $request) use ($container, $twig) {

            $greeter = $container->get('greeter');
            $greeting = $request->get('greeting');
            $body = $twig->render(
                'greeting.html.twig',
                [
                    'greeting' => $greeting,
                    'stuff' => $greeter->getStuff()
                ]
            );

            return new Response($body, 200);
        };

        // Routing
        $routes = new RouteCollection();
        $routes->add(
            'greeting',
            new Route(
                '/greetings/{greeting}',
                array(
                    'greeting' => 'Lussiposki',
                    '_controller' => $greetings
                )
            )
        );

        // HTTP kernel magic stuff
        $context = new RequestContext();
        $matcher = new UrlMatcher($routes, $context);
        $resolver = new ControllerResolver();

        // Listen to your heart
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher));
        $dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));

        parent::__construct($dispatcher, $container, $resolver);
    }
}
