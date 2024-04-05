<!DOCTYPE html>

<?php

// Result handling messages

if (isset($_GET["error"])) {
  if ($_GET["error"] == "none") {
    echo "<p>Data uploaded</p>";
  } elseif ($_GET["error"] == "stmtFailed") {
    echo "<p>There was an error with the database, try again later.</p>";
  } elseif ($_GET["error"] == "tableNotFound") {
    echo "<p>Invalid data.</p>";
  }
  exit();
}

include($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dataTransfer.class.php');

// TESTING TOGGLE FUNCTIONALITY
$testToggle == true;
if (!$testToggle) {
  $jsonString = file_get_contents('php://input');
} else {
  $fileName = 'upload.data';
  $filePath = ($_SERVER['DOCUMENT_ROOT'] . '/json/' . $fileName . '.json');
  $jsonString = file_get_contents($filePath);
}
// ----------------------------

if (!empty($jsonString)) {

  $jsonData = json_decode($jsonString, true);

  if ($jsonData !== null) {

    foreach ($jsonData as $key => $value) {
      $keys[] = $key;
      $values[] = $value;
    }

    if ($testToggle) {
      echo "Keys: ", implode(', ', $keys);
      echo "<br>";
      echo "Columns: ", implode(', ', $values[0]);
      echo "<br>";
      echo "Values: ", implode(', ', $values[1]);
    }

    $dataToUpload = new DataTransfer($keys[0], $values[0], $values[1]);
    $dataToUpload->uploadDataDB();
  } else {
    // echo "Error: Failed to decode JSON data";
  }
} else {
  // echo "Error: No JSON data received";
}

// Example PowerShell command:
// Invoke-WebRequest -Uri "http://localhost/dataTransfer.php" -Method POST -ContentType "application/json" -Body '{ "temperature": ["tempWater", "tempAmbient", "measured"], "values": ["23.50", "23.45", "2000-01-01 00:00:00"] }'