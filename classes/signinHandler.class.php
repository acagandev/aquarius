<?php

require_once "signin.class.php";

class SigninHandler extends Signin
{

  private $username;
  // private $email;
  private $password;
  // private $passwordRepeat;

  public function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

  public function signinValidate()
  {
    if ($this->emptyInput() == true) {
      header("location: ../signin.php?error=emptyInput");
    }

    $this->signinProceed($this->username, $this->password);
  }

  // Error handlers
  private function emptyInput()
  {
    $result = false;
    if (empty($this->username) || empty($this->password)) {
      $result = true;
    } else {
      $result = false;
    }
    return $result;
  }
}
