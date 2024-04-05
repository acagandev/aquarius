<!DOCTYPE html>

<?php

// Result handling messages

if (isset($_GET["error"])) {
  if ($_GET["error"] == "dataUploadOK") {
    echo "<p>Data uploaded</p>";
  } else {
    //
  }
  exit();
}

// if (isset($_GET["projectID"])) {
//   $projectID = $_GET["projectID"];
// } else {
//   echo "<p>Invalid project</p>";
//   exit();
// }
// // i.e. temperature
// if (isset($_GET["value1"])) {
//   $value1 = $_GET["value1"];
// } else {
//   echo "<p>Invalid value1</p>";
//   exit();
// }

// // i.e. 34 (degC)
// if (isset($_GET["value2"])) {
//   $value2 = $_GET["value2"];
// } else {
//   echo "<p>Invalid value2</p>";
//   exit();
// }

include($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
require($_SERVER['DOCUMENT_ROOT'] . '/classes/dataTransfer.class.php');

// $jsonString = file_get_contents('php://input');

$fileName = 'upload.data';
$filePath = ($_SERVER['DOCUMENT_ROOT'] . '/json/' . $fileName . '.json');

$jsonString = file_get_contents($filePath);

// Check if data was received
if (!empty($jsonString)) {

  $jsonData = json_decode($jsonString, true);

  if ($jsonData !== null) {

    // $param1 = $jsonData['param1'];
    // $param2 = $jsonData['param2'];

    foreach ($jsonData as $key => $value) {
      // echo "Parameter: $key, Value: ", implode(', ', $value);
      // echo "\n";
      $keys[] = $key;
      $values[] = $value;
      // echo "Keys: ", implode(', ', $keys);
      // echo "\n";
      // echo "Values: ", implode(', ', $values[0]);
    }
    echo "Keys: ", implode(', ', $keys);
    echo "<br>";
    echo "Columns: ", implode(', ', $values[0]);
    echo "<br>";
    echo "Values: ", implode(', ', $values[1]);

    $dataToUpload = new DataTransfer($keys[0], $values[0], $values[1]);
    $dataToUpload->uploadDataDB();
    // Process the received data
    // For example, you can insert it into a database
    // Or perform any other desired operations
    // echo "Received param1: $param1, param2: $param2";
  } else {
    echo "Error: Failed to decode JSON data";
  }
} else {
  echo "Error: No JSON data received";
}

// Invoke-WebRequest -Uri "http://localhost/dataTransfer.php" -Method POST -ContentType "application/json" -Body '{ "param1": "value1", "param2": "value2" }'
// Invoke-WebRequest -Uri "http://localhost/dataTransfer.php" -Method POST -ContentType "application/json" -Body '{ "temperature": ["tempWater", "tempAmbient", "measured"], "values": ["23.50", "23.45", "1000-01-01 00:00:00"] }'