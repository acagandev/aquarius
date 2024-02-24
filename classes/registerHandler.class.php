<?php

require_once "register.class.php";

class RegisterHandler extends Register
{

  private $username;
  private $email;
  private $password;
  private $passwordRepeat;

  public function __construct($username, $email, $password, $passwordRepeat)
  {
    $this->username = $username;
    $this->email = $email;
    $this->password = $password;
    $this->passwordRepeat = $passwordRepeat;
  }

  // ERROR HANDLER MESSAGES
  public function registerValidate()
  {
    if ($this->loginTaken() == true) {
      header("location: ../register.php?error=loginTaken");
      exit();
    }

    if ($this->emptyInput() == true) {
      header("location: ../register.php?error=emptyInput");
      exit();
    }

    if ($this->invalidUsernameChar() == true) {
      header("location: ../register.php?error=invalidUChar");
      exit();
    }

    if ($this->invalidUsernameLength() == true) {
      header("location: ../register.php?error=invalidULenght");
      exit();
    }

    // if ($this->invalidEmail() == true) {
    //   header("location: ../register.php?error=invalidEmail");
    //   exit();
    // }

    if ($this->passwordMismatch() == true) {
      header("location: ../register.php?error=passwordMismatch");
      exit();
    }
    $this->registerProceed($this->username, $this->email, $this->password);
  }

  // ERROR HANDLER METHODS
  private function loginTaken()
  {
    $result = false;
    if ($this->userExists($this->username, $this->email)) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }

  protected function emptyInput()
  {
    $result = false;
    if (empty($this->username) || empty($this->email) || empty($this->password) || empty($this->passwordRepeat)) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }

  private function passwordMismatch()
  {
    $result = false;
    if ($this->password !== $this->passwordRepeat) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }

  private function invalidUsernameChar()
  {
    $result = false;
    if (!preg_match("/^[a-zA-Z0-9_]*$/", $this->username)) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }

  private function invalidUsernameLength()
  {
    $result = false;
    if (strlen($this->username) < 3 || strlen($this->username) > 16) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }

  private function invalidEmail()
  {
    $result = false;
    if (!filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }
}
