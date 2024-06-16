<?php
ob_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php');

echo $_SERVER['PHP_SELF'] . "<br>";
echo "Temporary main profile page";

include_once($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php');
ob_flush();
