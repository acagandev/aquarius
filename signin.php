<!DOCTYPE html>
<base href="~/" />

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');
?>

<section class="form-text">
  <h2 class="center">Sign in</h2>
  <form class="form-text" action="/includes/signin.inc.php" method="POST">
    <div>
      <label>Username:</label>
      <input type="text" name="username" placeholder="">
    </div>
    <div>
      <label>Password:</label>
      <input type="password" name="password" placeholder="">
    </div>
    <div>
      <button type="submit" name="submit">Sign in</button>
    </div>
  </form>
  <!--   <div>
    <a href="">Forgot password?</a> >>Future development
  </div> -->
</section>

<!-- Result handling messages -->
<?php
if (isset($_GET["error"])) {
  if ($_GET["error"] == "emptyInput") {
    echo "<p>Fill in all credentials.</p>";
  } elseif ($_GET["error"] == "stmtFailed") {
    echo "<p>There was an error with the database, try again later.</p>";
  } elseif (($_GET["error"] == "userNotFound") || ($_GET["error"] == "wrongCredentials")) {
    echo "<p>Credentials are NOT correct.</p>";
  }
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');