<?php
	include "include/header.php"
?>

<!--

	Webstore Project
		- Add brand

	Version: 1.0
	Author: Mika
	Completed in: 15mis

-->

<?php

if(isset($_POST['submit']) === false)
{
	// Print Form
	echo '<form method="post">';
	echo 'New brand: <input type="text" name="brandid"/><br>';
	echo '<input type=submit name="submit"/>';
	echo '</form>';
}
else
{
	if(validate($_POST["brandid"]) === true)
	{
		// SQL Query
		try
		{
			db_addBrand($_POST["brandid"]);
		}
		catch (Exception $ex)
		{
			exit($ex->getMessage() . getReturnLink());
		}

		// On success, return to the main view
		header("location: " . getReturnAddress());
	}
	else
	{
		// Print Error and return link
		exit('Error: Invalid brand!' . getReturnLink());
	}
}

function getReturnAddress()
{
	return preg_replace('/\\?.*$/', '', $_SERVER['PHP_SELF']);
}

function getReturnLink()
{
	return '<br><a href="' . getReturnAddress() . '">Return</a><br>';
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function validate($brandid)
{
	$pattern = '/^[\w\d]{2}[\w\d\s]{0,30}$/';
	return preg_match($pattern, $brandid) === 1;
}

/* MOVE TO EXTERNAL FILE? */
function db_addBrand($brandid)
{
	require_once("include/db.php");

	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->prepare("INSERT INTO brand (brandid) VALUES (:brandid)");
	$st->bindParam(":brandid", $brandid);
	$st->execute();
}

?>

<?php
	include "include/footer.php"
?>