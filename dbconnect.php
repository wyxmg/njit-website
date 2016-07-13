<?php
include('dbinfo.php');


$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {
	die('Not connected : ' . mysqli_error());
}


$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
	die ('Can\'t use db : ' . mysqli_error());
}
?>