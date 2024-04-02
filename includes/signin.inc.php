<?php

if (isset($_POST['submit'])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  include($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
  include($_SERVER['DOCUMENT_ROOT'] . '/classes/signin.class.php');
  include($_SERVER['DOCUMENT_ROOT'] . '/classes/signinHandler.class.php');

  $signin = new signinHandler($username, $password);

  // Error hadnlers

  $signin->signinValidate();
}
