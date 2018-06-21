<?php 
session_start();

echo "<pre>";
echo "request <br />";

var_dump ($_REQUEST);

echo "<hr />";
echo "post <br />";

var_dump ($_POST);

echo "<hr />";
echo "cookie <br />";

var_dump ($_COOKIE);

echo "<hr />";
echo "session <br />";

var_dump ($_SESSION);

echo "<hr />";
echo "server <br />";

var_dump ($_SERVER);

echo "<hr />";
echo "Globals <br />";

var_dump ($GLOBALS);

echo "<hr />";
echo "server <br />";

var_dump ($_SERVER);

echo "<hr />";
echo "files <br />";

var_dump ($_FILES);

echo "<hr />";
echo "env <br />";

var_dump ($_ENV);

echo "</pre>";