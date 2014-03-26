<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();
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