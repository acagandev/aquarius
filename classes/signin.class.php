<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');

class Signin extends DbHandler
{

  protected function signinProceed($username, $password)
  {
    $stmt = $this->connectUD()->prepare('SELECT password FROM users WHERE username = ?;');

    if (!$stmt->execute(array($username))) {
      $stmt = null;
      header("Location: /signin.php?error=stmtFailed");
      exit();
    }

    if ($stmt->rowCount() == 0) {

      $stmt = null;
      header("Location: /signin.php?error=userNotFound");
      exit();
    }

    $passwordHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $checkPassword = password_verify($password, $passwordHashed[0]["password"]);

    if ($checkPassword == false) {
      $stmt = null;
      header("Location: /signin.php?error=wrongCredentials");
      exit();
    } elseif ($checkPassword == true) {
      $stmt = $this->connectUD()->prepare('SELECT * FROM users WHERE username = ? AND password = ?;');

      if (!$stmt->execute(array($username, $passwordHashed[0]["password"]))) {
        $stmt = null;
        header("Location: /signin.php?error=stmtFailed");
        exit();
      }

      $loginData = $stmt->fetchAll(PDO::FETCH_ASSOC);
      if (count($loginData) == 0) {

        $stmt = null;
        header("Location: /signin.php?error=wrongCredentials");
        exit();
      }

      session_start();
      $_SESSION["username"] = $loginData[0]["username"];
      $_SESSION["loginTimeStamp"] = time();
      header("Location: /profile/profile.prf.php");
    }

    $stmt = null;
  }
}
