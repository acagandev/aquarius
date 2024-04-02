<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');

echo $_SERVER['PHP_SELF'];
include_once($_SERVER['DOCUMENT_ROOT'] . '/profile.php');
// include_once($_SERVER['DOCUMENT_ROOT'] . '/profile/graphs.prf.php');

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
