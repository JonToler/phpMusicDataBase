<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Artist.php";
    require_once __DIR__."/../src/Album.php";

    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=music_collection';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    return $app;
?>
