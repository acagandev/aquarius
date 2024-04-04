<?php

if (isset($_POST['submit'])) {
  $table = $_POST["selectedTable"];
  $parameter = $_POST["columnSelectList"];
  $startDate = $_POST["startDate"];
  $stopDate = $_POST["stopDate"];

  require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dataTransfer.class.php');

  $downloadedData = new DataTransfer($table, $parameter, $startDate, $stopDate);
  $downloadedData->downloadDataDB($parameter);
}
