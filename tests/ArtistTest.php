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

    class ArtistTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Artist::deleteAll();
        }

        function test_getName()
        {
            $name = "Nurse With Wound";
            $id = 1;
            $test_Artist = new Artist($name, $id);

            $result = $test_Artist->getName();

            $this->assertEquals($name, $result);
        }

        function test_setName()
        {
            $name = "Nurse With Wound";
            $id = 1;
            $new_name = "Coil";
            $test_Artist = new Artist($name, $id);
            $test_Artist->setName($new_name);

            $result = $test_Artist->getName();

            $this->assertEquals($new_name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Foetus Inc.";
            $id = 1;
            $test_Artist = new Artist($name, $id);

            //Act
            $result = $test_Artist->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            $name = "Jhonn Balance";
            $id = 1;
            $test_Artist = new Artist($name, $id);
            $test_Artist->save();
            $result = Artist::getAll();
            $this->assertEquals($test_Artist, $result[0]);
        }

        function test_deleteAll()
        {
            $name = "Current 93";
            $name2 = "Death in June";
            $test_artist = new Artist($name);
            $test_artist->save();
            $test_Artist2 = new Artist($name2);
            $test_Artist2->save();
            Artist::deleteAll();
            $result = Artist::getAll();
            $this->assertEquals([], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name = "HNAS";
            $name2 = "The Can";
            $test_Artist = new Artist($name);
            $test_Artist->save();
            $test_Artist2 = new Artist($name2);
            $test_Artist2->save();

            //Act
            $result = Artist::getAll();

            //Assert
            $this->assertEquals([$test_Artist, $test_Artist2], $result);
        }

        function test_find()
        {
            $name = "Merzbow";
            $name2 = "Fushitsusha";
            $test_Artist = new Artist($name);
            $test_Artist->save();
            $test_Artist2 = new Artist($name2);
            $test_Artist2->save();
            $result = Artist::find($test_Artist->getId());
            $this->assertEquals($test_Artist, $result);
        }

    }

?>
