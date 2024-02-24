<?php

// check if form was send

if (isset($_POST['submit'])) {

  $username = $_POST["username"];
  $password = $_POST["password"];

  include "../classes/dbHandler.class.php";
  include "../classes/signin.class.php";
  include "../classes/signinHandler.class.php";

  $signin = new signinHandler($username, $password);

  // Error hadnlers

  $signin->signinValidate();
}
