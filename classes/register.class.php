<?php

require_once "dbHandler.class.php";

class Register extends DbHandler
{

  protected function registerProceed($username, $email, $password)
  {
    $stmt = $this->connectUD()->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?);');

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!$stmt->execute(array($username, $email, $hashedPassword))) {
      $stmt = null;
      header("location: ../register.php?error=stmtfailed");
      exit();
    }

    $stmt = null;

    header("location: ../register.php?error=none");
  }

  // ERROR HANDLER METHODS
  protected function userExists($username, $email)
  {
    $stmt = $this->connectUD()->prepare('SELECT uid FROM users WHERE username = ? OR email = ?;');

    if (!$stmt->execute(array($username, $email))) {
      $stmt = null;
      header("location: ../register.php?error=stmtfailed");
      exit();
    }

    $result = false;
    if ($stmt->rowCount() > 0) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }
}
