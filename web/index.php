<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$greeting = $request->query->get('greeting', 'tussikasvo');

ob_start();
?><html>
    <head>
        <title>Chtrupal v666</title>

        <style type="text/css">

            body {
                font-size: 20px;
            }

        </style>


    </head>

    <body>

        <h1><?php echo "{$greeting}, welcome to Chtrupal v666!"; ?></h1>

        <p>
            Cthrupal is a content management framework to end all content management frameworks!
        </p>

    </body>

</html>
<?php
$body = ob_get_clean();

$response = new Response($body, Response::HTTP_OK);
$response
    ->prepare($request)
    ->setPrivate()
    ->setExpires(new DateTime('1978-03-21'))
    ->send();



