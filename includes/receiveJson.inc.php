<?php

$jsonString = file_get_contents('php://input');

// Check if data was received
if (!empty($jsonString)) {

  $data = json_decode($jsonData, true);

  if ($jsonData !== null) {

    $param1 = $jsonData['param1'];
    $param2 = $jsonData['param2'];

    // Process the received data
    // For example, you can insert it into a database
    // Or perform any other desired operations
    echo "Received param1: $param1, param2: $param2";
  } else {
    // JSON decoding failed
    echo "Error: Failed to decode JSON data";
  }
} else {
  // No data received
  echo "Error: No JSON data received";
}

// Invoke-WebRequest -Uri "http://localhost/includes/receiveJson.inc.php" -Method POST -ContentType "application/json" -Body '{ "param1": "value1", "param2": "value2" }'