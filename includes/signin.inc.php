<?php

if (isset($_POST['submit'])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/signinHandler.class.php');

  $signin = new signinHandler($username, $password);

  $signin->signinValidate();
}