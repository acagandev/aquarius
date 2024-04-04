<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/signin.class.php');

class SigninHandler extends Signin
{

  private $username;
  private $password;

  public function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

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

  public function signinValidate()
  {
    if ($this->emptyInput() == true) {
      header("location: /signin.php?error=emptyInput");
    } else {
      $this->signinProceed($this->username, $this->password);
    }
  }
}