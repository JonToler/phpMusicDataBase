<?php

    class Artist
    {
        private $name;
        private $id;

    function __construct($name, $id = null)
    {
        $this->name = $name;
        $this->id = $id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = (string) $new_name;
    }

    function getId()
    {
        return $this->id;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO artist (name) VALUES ('{$this->getName()}')");
        $this->id= $GLOBALS['DB']->lastInsertId();
    }

    function getAlbums()
    {
        $albums = Array();
        $returned_albums = $GLOBALS['DB']->query("SELECT * FROM album WHERE id_artist = {$this->getId()};");
        foreach($returned_albums as $album) {
            $name = $album['name'];
            $id = $album['id'];
            $id_artist = $album['id_artist'];
            $new_album = new Album($name, $id_artist, $id);
            array_push($albums, $new_album);
        }
        return $albums;
    }


    static function getAll()
    {
        $returned_artists = $GLOBALS['DB']->query("SELECT * FROM artist;");
        $artists = array();
        foreach($returned_artists as $artist) {
            $name = $artist['name'];
            $id = $artist['id'];
            $new_artist = new Artist($name, $id);
            array_push($artists, $new_artist);
        }
        return $artists;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM artist;");
    }

    static function find($searchId)
    {
        $found_artist = null;
        $artists = Artist::getAll();
        foreach($artists as $artist) {
            $artist_id = $artist->getId();
            if ($artist_id == $searchId) {
              $found_artist = $artist;
            }
        }
        return $found_artist;
    }

    }


?>
