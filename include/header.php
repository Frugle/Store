<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

$urlPrepend = "/store/";

function isLoggedIn()
{
	return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Store</title>
	<link rel="stylesheet" type="text/css" href="/store/styles.css">
</head>
<body>
<div id="mainContainer">
	<header>
		Header!
	</header>
	<div id="nav">
		<h1>Store</h1>
	</div>
	<div id="categories">
	<?php
	require_once('categorylist.php');
	?>
	</div>
	<div id="content">