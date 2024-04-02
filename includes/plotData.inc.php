<?php

if (isset($_POST['submitAll'])) {

  $table = $_POST["tableSelectList"];
  $parameter = $_POST["columnSelectList"];
  $startDate = $_POST["startDate"];
  $stopDate = $_POST["stopDate"];

  echo $table;

  include($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
  include($_SERVER['DOCUMENT_ROOT'] . '/classes/plotData.class.php');
  // include($_SERVER['DOCUMENT_ROOT'] . '/classes/signinHandler.class.php');

  // $signin = new signinHandler($username, $password);
  // $plotData = new 

  // Error hadnlers

  // $signin->signinValidate();
}
