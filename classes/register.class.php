<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/dbHandler.class.php');

class Register extends DbHandler
{

  protected function registerProceed($username, $email, $password)
  {
    $stmt = $this->connectUD()->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?);');

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!$stmt->execute(array($username, $email, $hashedPassword))) {
      $stmt = null;
      header("Location: /register.php?error=stmtFailed");
      exit();
    }

    $stmt = null;

    header("Location: /register.php?error=none");
  }

  protected function userExists($username, $email)
  {
    $stmt = $this->connectUD()->prepare('SELECT uid FROM users WHERE username = ? OR email = ?;');

    if (!$stmt->execute(array($username, $email))) {
      $stmt = null;
      header("Location: /register.php?error=stmtFailed");
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
