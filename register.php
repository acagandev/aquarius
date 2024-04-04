<!DOCTYPE html>
<base href="~/" />

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
?>

<section class="form-text">
  <h2 class="center">Registration</h2>
  <form class="form-text" action="/includes/register.inc.php" method="POST">
    <div>
      <label>Username:</label>
      <input type="text" name="username" placeholder="a-zA-Z0-9_">
    </div>
    <div>
      <label>Email:</label>
      <input type="text" name="email" placeholder="local-part@domain">
    </div>
    <div>
      <label>Password:</label>
      <input type="password" name="password" placeholder="password">
    </div>
    <div>
      <label>Repeat password:</label>
      <input type="password" name="passwordRepeat" placeholder="repeat password">
    </div>
    <div>
      <button type="submit" name="submit">Register</button>
    </div>
  </form>
  <div>
    <a href="/signin.php">Already have an account?</a>
  </div>
</section>

<!-- Result handling messages -->
<?php
if (isset($_GET["error"])) {
  if ($_GET["error"] == "emptyInput") {
    echo "<p>Fill all inputs.</p>";
  } elseif ($_GET["error"] == "invalidUChar") {
    echo "<p>Allowed characters for username: a-zA-Z0-9_</p>";
  } elseif ($_GET["error"] == "invalidULength") {
    echo "<p>Username must be 3 to 16 characters long.</p>";
  } elseif ($_GET["error"] == "invalidEmail") {
    echo "<p>Email address is not in correct format.</p>";
  } elseif ($_GET["error"] == "loginTaken") {
    echo "<p>Username or email is already registered.</p>";
  } elseif ($_GET["error"] == "passwordMismatch") {
    echo "<p>Passwords do not match.</p>";
  } elseif ($_GET["error"] == "stmtFailed") {
    echo "<p>There was an error with the database, try again later.</p>";
  } elseif ($_GET["error"] == "none") {
    echo "<p>Registration successful.</p>";
  }
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');