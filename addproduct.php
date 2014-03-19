<?php
	include "include/header.php"
?>

<!--

	Webstore Project
		- Add product

	Version: 1.0
	Author: Mika
	Completed in: 1.5hrs

-->
<?php

if(isset($_POST['submit']) === false)
{
	// Print Form
	echo '<form method="post">';
	echo 'Brand: <select name="brandid">' . getBrands() . '</select><br>';
	echo 'Model: <input type="text" name="model"/><br>';
	echo 'Description: <textarea type="text" name="description"></textarea><br>';
	echo 'Warranty: <input type="text" name="warranty"/><br>';
	echo 'Baseprice: <input type="text" name="baseprice"/><br>';
	echo 'Discount: <input type="text" name="discount"/><br>';
	echo 'Image URL: <input type="text" name="image"/><br>';
	echo '<input type=submit name="submit"/>';
	echo '</form>';
}
else
{
	if(validate($_POST["brandid"], $_POST["model"], $_POST["description"], $_POST["warranty"],
		$_POST["baseprice"], $_POST["discount"], $_POST["image"]) === true)
	{
		// SQL Query
		try
		{
			db_addProduct($_POST["brandid"], $_POST["model"], $_POST["description"], $_POST["warranty"],
				$_POST["baseprice"], $_POST["discount"], $_POST["image"]);
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
		exit('Error: Data validation failed!' . getReturnLink());
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

function getBrands()
{
	try
	{
		return sprintf("<option>%s</option>",
			implode('</option><option>', db_getAllBrands()));
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
function validate($brandid, $model, $description, $warranty, $baseprice, $discount, $image)
{
	return preg_match('/^[\w\d]{2}[\w\d\s]{0,30}$/', $brandid) &&
		preg_match('/^[\w\d\s]{0,64}$/', $model) &&	
		preg_match('/^.{0,512}$/', $description) &&
		preg_match('/^\d{0,4}$/', $warranty) &&
		preg_match('/^\d{1,7}($|(\.\d{1,2}))$/', $baseprice) &&
		preg_match('/^\d($|(\.\d{1,2}))$/', $discount) &&
		preg_match('/^\S{0,128}$/', $image);
}

/* MOVE TO EXTERNAL FILE? */
function db_getAllBrands()
{
	require_once("include/db.php");

	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->query('SELECT brandid FROM brand');
	$st->setFetchMode(PDO::FETCH_ASSOC);

	$brands = array();
	while($row = $st->fetch())
	{
		$brands[] = $row['brandid'];
	}

	return $brands;
}

/* MOVE TO EXTERNAL FILE? */
function db_addProduct($brandid, $model, $description, $warranty, $baseprice, $discount, $image)
{
	require_once("include/db.php");

	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->prepare("
	INSERT INTO product (
		brandid,
		model,
		description,
		warranty,
		baseprice,
		discount,
		image)
	VALUE (
		:brandid,
		:model,
		:description,
		:warranty,
		:baseprice,
		:discount,
		:image)
	");

	$st->bindParam(":brandid", $brandid);
	$st->bindParam(":model", $model);
	$st->bindParam(":description", $description);
	$st->bindParam(":warranty", $warranty);
	$st->bindParam(":baseprice", $baseprice);
	$st->bindParam(":discount", $discount);
	$st->bindParam(":image", $image);
	$st->execute();
}

?>

<?php
	include "include/footer.php"
?>