<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

function isLoggedIn()
{
	return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Store</title>
	</head>
	<body>

	<?php
	require_once('categorylist.php');
	?>