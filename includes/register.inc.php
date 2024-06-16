<?php
if (isset($_POST['submit'])) {

  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $passwordRepeat = $_POST["passwordRepeat"];

  require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/register.class.php');
  require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/registerHandler.class.php');

  $register = new registerHandler($username, $email, $password, $passwordRepeat);

  $register->registerValidate();
}
