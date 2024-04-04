<?php
session_start();

require($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
$currentUrl = $_SERVER['REQUEST_URI'];
?>

<!DOCTYPE html>
<html lang="sk">
<base href="~/" />

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="decscription" content="Aquarius User Interface" />
  <meta name="viewport" content="width=device-width, initdsvial-scale=1.0" />
  <title>Aquarius UI</title>

  <link rel="stylesheet" href="/css/reset.css" />
  <link rel="stylesheet" href="/css/aquarius-styles.css" />
  <link rel="icon" href="/favicon.ico" />
</head>

<body>

  <div id="header">
    <section id="top-header">
      <a href="/index.php" id="title"><b>Aquarius UI</b></a>
    </section>
    <section id="bottom-header">
      <nav style="height: inherit;">
        <ul style="height: inherit;">
          <li><a href="/index.php"><img src="/img/Aquarius-logos.jpeg" alt="server logo" width="50px"></a>
          </li>
          <?php
          if (isset($_SESSION["username"])) {
            echo "<li><a href='/profile/profile.prf.php' class='button'>PROFILE</a></li>";
            echo "<li><a href='/includes/signout.inc.php' class='button'>LOGOUT</a></li>";
            if (strpos($currentUrl, '/viewData.prf.php') !== false) {
              // echo "<li><a href='/profile/viewData.prf.php?plot=true' class='button'>Plot Data</a></li>";
            } else {
              echo "<li><a href='/profile/viewData.prf.php' class='button'>View Data</a></li>";
            }
          } else {
            echo "<li><a href='/signin.php' class='button'>Sign in</a></li>";
            echo "<li><a href='/register.php' class='button'>Register</a></li>";
          }
          ?>
        </ul>
      </nav>
    </section>
  </div>

  <div id="content" style="background-image: url('/img/Aquarius-logoss.jpeg')">
    <div id="scrollableContent">
      <div id="paddingContent">