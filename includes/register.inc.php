<?php

// check if form was send

if (isset($_POST['submit'])) {

  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $passwordRepeat = $_POST["passwordRepeat"];

  include "../classes/dbHandler.class.php";
  include "../classes/register.class.php";
  include "../classes/registerHandler.class.php";

  $register = new registerHandler($username, $email, $password, $passwordRepeat);

  $register->registerValidate();
}