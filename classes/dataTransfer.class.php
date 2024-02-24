<?php

require_once "dbHandler.class.php";

class DataTransfer extends DbHandler
{
  private $projectID;
  private $value1;
  private $value2;

  public function __construct($projectID, $value1, $value2)
  {
    $this->projectID = $projectID;
    $this->value1 = $value1;
    $this->value2 = $value2;
  }

  /*   protected function mapData()
  {
    if (isset($_GET["projectID"])) {
      $this->projectID = $_GET["projectID"];
    }
    // i.e. temperature
    if (isset($_GET["value1"])) {
      $this->value1 = $_GET["value1"];
    }

    // i.e. 34degC
    if (isset($_GET["value2"])) {
      $this->value2 = $_GET["value2"];
    }
  } */

  // http://localhost/aquarius/dataTransfer.php?projectID=proj123&value1=temp&value2=123

  public function uploadData()
  {

    // $mysqli = new mysqli("localhost", "aquarius", "aquarius123");
    // $this->projectID = $mysqli->real_escape_string($this->projectID);
    // $this->value1 = $mysqli->real_escape_string($this->value1);
    // $this->value2 = $mysqli->real_escape_string($this->value2);

    $stmt = $this->connectPD()->prepare('DESCRIBE ' . $this->projectID . ';');

    if (!$stmt->execute()) {
      $stmt = null;
      header("location: ./dataTransfer.php?error=projectNotFound");
      exit();
    }

    // $query = 'INSERT INTO ' . $this->projectID . ' (' . $this->value1 . ') VALUES (' . $this->value2 . ');';
    // print_r($query);

    // $stmt = $this->connectPD()->prepare($query);
    $stmt = $this->connectPD()->prepare('INSERT INTO ' . $this->projectID . ' (' . $this->value1 . ') VALUES (' . $this->value2 . ');');

    if (!$stmt->execute()) {
      $stmt = null;
      header("location: ./dataTransfer.php?error=stmtfailed");
      exit();
    }

    $stmt = null;

    header("location: ./dataTransfer.php?error=dataUploadOK");
  }
}
