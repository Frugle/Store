<?php
	include "include/header.php"
?>

Index
<br>

<?php
	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1)
		echo "Logged in as " . $_SESSION["username"];
?>

<?php
	include "include/footer.php"
?>