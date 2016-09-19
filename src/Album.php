<?php

    class Album
    {
        private $name;
        private $id;
        private $id_artist;

    function __construct($name, $id_artist, $id = null)
    {
        $this->name = $name;
        $this->id_artist = $id_artist;
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

    function getArtistID()
    {
        return $this->id_artist;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO album (name, id_artist) VALUES ('{$this->getName()}', {$this->getArtistID()})");
        $this->id= $GLOBALS['DB']->lastInsertId();
    }

    static function getAll()
    {
        $returned_albums = $GLOBALS['DB']->query("SELECT * FROM album;");
        $albums = array();
        foreach($returned_albums as $album) {
            $name = $album['name'];
            $id = $album['id'];
            $id_artist = $album['id_artist'];
            $new_album = new Album($name, $id_artist, $id);
            array_push($albums, $new_album);
        }
        return $albums;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM album;");
    }

    static function find($searchId)
    {
        $found_album = null;
        $albums = Album::getAll();
        foreach($albums as $album) {
            $album_id = $album->getId();
            if ($album_id == $searchId) {
              $found_album = $album;
            }
        }
        return $found_album;
    }

    }


?>
