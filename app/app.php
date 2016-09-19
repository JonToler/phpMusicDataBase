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
        return $app['twig']->render('index.html.twig', array('artists' => Artist::getAll()));
    });

    $app->post("/artists", function() use ($app) {
        $artist = new Artist($_POST['artist_name']);
        $artist->save();
        return $app['twig']->render('index.html.twig', array('artists' => Artist::getAll()));
    });

    $app->post("/delete_artists", function() use ($app) {
        Artist::deleteAll();
        return $app['twig']->render('index.html.twig', array('artists' => Artist::getAll()));
    });

    $app->post("/albums", function() use ($app) {
        $album = new Album($_POST['album_name'], $_POST['album_artist']);
        $album->save();
        return $app['twig']->render('albums.html.twig', array('albums' => Album::getAll()));
    });


    $app->get("/albums", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('albums' => Album::getAll()));
    });

    return $app;
?>
