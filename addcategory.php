
<!--

	Webstore Project
		- Add category

	Version: 1.0
	Author: Mika
	Completed in: 3hrs

-->

<?php

if(isset($_POST['submit']) === false)
{
	// Print Form
	echo '<form method="post">';
	echo 'New category: <input type="text" name="categoryid"/><br>';
	echo 'Parent category: <select name="parentcategory">' . getCategories() . '</select><br>';
	echo '<input type=submit name="submit"/>';
	echo '</form>';
}
else
{
	if(validate($_POST["categoryid"], $_POST["parentcategory"]) === true)
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

function getCategories()
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
function validate($categoryid, $parentcategory)
{
	$pattern = '/^\w{2,32}$/';
	return preg_match($pattern, $categoryid) &&
		preg_match($pattern, $parentcategory);
}

/* MOVE TO EXTERNAL FILE? */
function db_getAllCategories()
{
	require_once("include/db.php");

	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->query('SELECT categoryid FROM category');
	$st->setFetchMode(PDO::FETCH_ASSOC);

	$categories = array();
	while($row = $st->fetch())
	{
		$categories[] = $row['categoryid'];
	}

	return $categories;
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
