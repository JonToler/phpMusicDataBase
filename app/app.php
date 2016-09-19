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

    $app->get("/artists/{id}", function($id) use ($app) {
        $artist = Artist::find($id);
        return $app['twig']->render('albums.html.twig', array('artist' => $artist, 'albums' => $artist->getAlbums()));
    });


    $app->post("/delete_everything", function() use ($app) {
        Artist::deleteAll();
        Album::deleteAll();
        return $app['twig']->render('index.html.twig', array('artists' => Artist::getAll()));
    });

    $app->post("/albums", function() use ($app) {
        $album = new Album($_POST['album_name'], $_POST['album_artist']);
        $album->save();
        $artist = Artist::find($_POST['album_artist']);
        return $app['twig']->render('albums.html.twig', array('albums' => Album::getAll(), 'artist' => $artist));
    });


    $app->get("/albums", function() use ($app) {
        return $app['twig']->render('albums.html.twig', array('albums' => Album::getAll(), 'artist' => ''));
    });

    return $app;
?>
