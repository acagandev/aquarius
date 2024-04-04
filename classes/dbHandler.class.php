<?php

class DbHandler
{

  // CONNECT TO USERS DATABASE
  protected function connectUD()
  {
    try {
      $username = "aquarius";
      $password = "aquarius123";
      $dbh = new PDO('mysql:host=localhost;dbname=diplomka_ud', $username, $password);
      return $dbh;
    } catch (PDOException $e) {
      print "Error: " . $e->getMessage() . "<br/>";
      die();
    }
  }

  // CONNECT TO PROJECT DATABASE
  protected function connectPD()
  {
    try {
      $username = "aquarius";
      $password = "aquarius123";
      $dbh = new PDO('mysql:host=localhost;dbname=diplomka_pd', $username, $password);
      return $dbh;
    } catch (PDOException $e) {
      print "Error: " . $e->getMessage() . "<br/>";
      die();
    }
  }
}