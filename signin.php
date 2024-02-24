<!DOCTYPE html>


<?php
include_once 'templates/header.php';
?>

<section class="">
  <h2 class="center">Sign in</h2>
  <form class="form-text" action="./includes/signin.inc.php" method="POST">
    <div>
      <label>Username/Email:</label>
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
    <a href="">Forgot password?</a>
  </div> -->
</section>

<!-- ERROR HANDLER MESSAGES -->
<?php
if (isset($_GET["error"])) {
  if ($_GET["error"] == "emptyInput") {
    echo "<p>Fill all credentials</p>";
  } elseif ($_GET["error"] == "dbOffline") {
    echo "<p>Database is unreachable, try again later</p>";
  } elseif ($_GET["error"] == "none") {
    echo "<p>Registration OK</p>";
  } elseif ($_GET["error"] == "wrongLogin") {
    echo "<p>Invalid credentials</p>";
  }
} elseif (isset($_GET["newpwd"])) {
  if ($_GET["newpwd"] == "pwdupdated") {
    echo "<p>Password changed!</p>";
  }
}

include_once 'templates/footer.php';