<?php

$greeting = (isset($_GET['greeting'])) ? $_GET['greeting']: 'tussiposki';

?>

<html>
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


