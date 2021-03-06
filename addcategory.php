<?php
	include "include/header.php"
?>

<?php

/* 
	Webstore Project
		- Add category

	Version: 1.0
	Author: Mika
	Completed in: 3hrs
*/

if(isset($_POST['submit']) === false)
{
	// Print Form
	echo '<form method="post">';
	echo 'New category: <input type="text" name="categoryid"/><br>';
	echo 'Parent category: <select name="parentcategory">' . getCategoriesHtml() . '</select><br>';
	echo '<input type=submit name="submit"/>';
	echo '</form>';
}
else
{
	if(validateCategory($_POST["categoryid"], $_POST["parentcategory"]) === true)
	{
		// Replace 'None' with database friendly null value
		if($_POST["parentcategory"] === 'None')
		{
			$_POST["parentcategory"] = null;
		}

		// SQL Query
		try
		{
			db_addCategory($_POST["categoryid"], $_POST["parentcategory"]);
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
		exit('Error: Invalid category!' . getReturnLink());
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

function getCategoriesHtml()
{
	try
	{
		return sprintf("<option selected>None</option><option>%s</option>",
			implode('</option><option>', db_getAllCategories()));
	}
	catch (Exception $ex)
	{
		exit($ex->getMessage() . getReturnLink());
	}
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function validateCategory($categoryid, $parentcategory)
{
	$pattern = '/^[\w\d]{2}[\w\d\s]{0,30}$/';
	return preg_match($pattern, $categoryid) &&
		preg_match($pattern, $parentcategory);
}

/* MOVE TO EXTERNAL FILE? */
function db_addCategory($categoryid, $parentcategory)
{
	require_once("include/db.php");

	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->prepare("
	INSERT INTO category (
		categoryid,
		parentcategory)
	VALUE (
		:categoryid,
		:parentcategory)
	");

	$st->bindParam(":categoryid", $categoryid);
	$st->bindParam(":parentcategory", $parentcategory);
	$st->execute();
}

?>

<?php
	include "include/footer.php"
?>