<?php
	include_once "../include/header.php"
?>

<?php
if (isset($_GET["category1"]))
	echo $_GET["category1"] . "<br>";

if (isset($_GET["category2"]))
	echo $_GET["category2"] . "<br>";

if (isset($_GET["category3"]))
	echo $_GET["category3"] . "<br>";
?>

<?php
	include "../include/footer.php"
?>