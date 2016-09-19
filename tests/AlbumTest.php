<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Artist.php";
    require_once "src/Album.php";

    $server = 'mysql:host=localhost;dbname=music_collection_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AlbumTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Album::deleteAll();
        }

        function test_getName()
        {
            $name = "Soliloquy for Lilith";
            $id = 1;
            $id_artist = 10;
            $test_Album = new Album($name, $id_artist, $id);

            $result = $test_Album->getName();

            $this->assertEquals($name, $result);
        }

        function test_setName()
        {
            $name = "A Chance Meeting";
            $id = 1;
            $id_artist = 10;
            $new_name = "Horse Rotorvator";
            $test_Album = new Album($name, $id_artist, $id);
            $test_Album->setName($new_name);

            $result = $test_Album->getName();

            $this->assertEquals($new_name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "You've Got Foetus On Your Breath";
            $id = 1;
            $id_artist = 10;
            $test_Album = new Album($name, $id_artist, $id);

            //Act
            $result = $test_Album->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            $name = "Loves Secret Domain";
            $id = 1;
            $id_artist = 10;
            $test_Album = new Album($name, $id_artist, $id);
            $test_Album->save();
            $result = Album::getAll();
            $this->assertEquals($test_Album, $result[0]);
        }

        function test_deleteAll()
        {
            $name = "Imperium";
            $name2 = "93 Dead Sunwheels";
            $id_artist = 10;
            $test_artist = new Album($name, $id_artist);
            $test_artist->save();
            $test_Album2 = new Album($name2, $id_artist);
            $test_Album2->save();
            Album::deleteAll();
            $result = Album::getAll();
            $this->assertEquals([], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Küttel Im Frost";
            $id_artist = 10;
            $name2 = "Ege Bamyasi";
            $id_artist2 = 11;
            $test_Album = new Album($name, $id_artist);
            $test_Album->save();
            $test_Album2 = new Album($name2, $id_artist2);
            $test_Album2->save();

            //Act
            $result = Album::getAll();

            //Assert
            $this->assertEquals([$test_Album, $test_Album2], $result);
        }

        function test_find()
        {
            $name = "Merzbirds";
            $name2 = "The Caution Appears";
            $id_artist = 10;
            $test_Album = new Album($name, $id_artist);
            $test_Album->save();
            $test_Album2 = new Album($name2, $id_artist);
            $test_Album2->save();
            $result = Album::find($test_Album->getId());
            $this->assertEquals($test_Album, $result);
        }

    }

?>
