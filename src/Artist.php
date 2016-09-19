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

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO artist (name) VALUES ('{$this->getName()}')");
        $this->id= $GLOBALS['DB']->lastInsertId();
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

    }

    }


?>
