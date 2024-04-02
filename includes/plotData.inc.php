<?php

if (isset($_POST['submit'])) {
  $table = $_POST["selectedTable"];
  $parameter = $_POST["columnSelectList"];
  $startDate = $_POST["startDate"];
  $stopDate = $_POST["stopDate"];

  include($_SERVER['DOCUMENT_ROOT'] . '/classes/dataTransfer.class.php');
  include($_SERVER['DOCUMENT_ROOT'] . '/classes/plotData.class.php');

  $downloadedData = new DataTransfer($table, $parameter, $startDate, $stopDate);
  $downloadedData->downloadDataDB($parameter);
}
