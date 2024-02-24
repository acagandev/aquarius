<!DOCTYPE html>

<?php

// <!-- ERROR HANDLER MESSAGES -->

if (isset($_GET["error"])) {
  if ($_GET["error"] == "dataUploadOK") {
    echo "<p>Data uploaded</p>";
  } else {
    //
  }
  exit();
}

if (isset($_GET["projectID"])) {
  $projectID = $_GET["projectID"];
} else {
  echo "<p>Invalid project</p>";
  exit();
}
// i.e. temperature
if (isset($_GET["value1"])) {
  $value1 = $_GET["value1"];
} else {
  echo "<p>Invalid value1</p>";
  exit();
}

// i.e. 34 (degC)
if (isset($_GET["value2"])) {
  $value2 = $_GET["value2"];
} else {
  echo "<p>Invalid value2</p>";
  exit();
}

include "./classes/dbHandler.class.php";
require './classes/dataTransfer.class.php';

$dataMap = new DataTransfer($projectID, $value1, $value2);

$dataMap->uploadData();
