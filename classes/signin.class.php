<?php

require_once "dbHandler.class.php";

class Signin extends DbHandler
{


  protected function signinProceed($username, $password)
  {
    $stmt = $this->connectUD()->prepare('SELECT password FROM users WHERE username = ? OR email = ?;');

    if (!$stmt->execute(array($username, $username))) {
      $stmt = null;
      header("location: ../signin.php?error=stmtfailed");
      exit();
    }

    if ($stmt->rowCount() == 0) {

      $stmt = null;
      header("location: ../signin.php?error=userNotFound");
      exit();
    }

    $passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $checkPassword = password_verify($password, $passwordHashed[0]["password"]);

    if ($checkPassword == false) {
      $stmt = null;
      header("location: ../signin.php?error=wrongPassword");
      exit();
    } elseif ($checkPassword == true) {
      $stmt = $this->connectUD()->prepare('SELECT * FROM users WHERE username = ? OR email = ? AND password = ?;');

      if (!$stmt->execute(array($username, $username, $passwordHashed[0]["password"]))) {
        $stmt = null;
        header("location: ../signin.php?error=stmtfailed");
        exit();
      }

      $loginData = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($loginData) == 0) {

        $stmt = null;
        header("location: ../signin.php?error=userNotFound");
        exit();
      }

      session_start();
      $_SESSION["username"] = $loginData[0]["username"];
      // $_SESSION["username"]=$username[0]["username"];
      header("location: ../signin.php");
    }

    $stmt = null;
  }
}
