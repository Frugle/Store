<?php
	include_once "include/header.php"
?>

<?php

/* 
	Webstore Project
		- Add product

	Version: 1.1
	Author: Mika and Iiro
	Completed in: 1.5+ hrs
*/

if(isset($_POST['submit']) === false)
{
	// Print Form
	echo '<form method="post" enctype="multipart/form-data">';
	echo 'Brand: <select name="brandid">' . getBrandsHtml() . '</select><br>';
	echo 'Model: <input type="text" name="model"/><br>';
	echo 'Description: <textarea type="text" name="description"></textarea><br>';
	echo 'Warranty: <input type="text" name="warranty"/><br>';
	echo 'Baseprice: <input type="text" name="baseprice"/><br>';
	echo 'Discount: <input type="text" name="discount"/><br>';
	echo 'Image URL: <input type="file" name="image"/><br>';
	echo '<input type=submit name="submit"/>';
	echo '</form>';
}
else
{
	if(validateProduct($_POST["brandid"], $_POST["model"], $_POST["description"], $_POST["warranty"],
		$_POST["baseprice"], $_POST["discount"], $_FILES["image"]) === true)
	{
		// SQL Query
		try
		{
			db_addProduct($_POST["brandid"], $_POST["model"], $_POST["description"], $_POST["warranty"],
				$_POST["baseprice"], $_POST["discount"], $_FILES["image"]);
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

function getBrandsHtml()
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
function validateProduct($brandid, $model, $description, $warranty, $baseprice, $discount, $image)
{
	return preg_match('/^[\w\d]{2}[\w\d\s]{0,30}$/', $brandid) &&
		preg_match('/^[\w\d\s]{0,64}$/', $model) &&	
		preg_match('/^.{0,512}$/', $description) &&
		preg_match('/^\d{0,4}$/', $warranty) &&
		preg_match('/^\d{1,7}($|(\.\d{1,2}))$/', $baseprice) &&
		preg_match('/^\d($|(\.\d{1,2}))$/', $discount) &&
		$image["error"] == 0;
}

/* MOVE TO EXTERNAL FILE? */
function db_getAllBrands()
{
	require_once("include/db.php");

	$brands = array();
	$brandsGeneric = getBrands();
	foreach ($brandsGeneric as $row) 
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
		\"\")
	");

	$st->bindParam(":brandid", $brandid);
	$st->bindParam(":model", $model);
	$st->bindParam(":description", $description);
	$st->bindParam(":warranty", $warranty);
	$st->bindParam(":baseprice", $baseprice);
	$st->bindParam(":discount", $discount);
	$st->execute();

	$lastId = $db->lastInsertId();

  	$ext = pathinfo($image["name"], PATHINFO_EXTENSION);

  	// TODO: validate extension

  	$imageDirDB = "productimages";
  	$imageDirMove = "{$_SERVER['DOCUMENT_ROOT']}/store/$imageDirDB";

  	if (!file_exists($imageDirMove))
  		mkdir($imageDirMove, 0777, true);

  	$name = $lastId . "." . $ext;
  	$imagePathDB = "$imageDirDB/$name";
  	$imagePathMove = "$imageDirMove/$name";

  	move_uploaded_file($image["tmp_name"], $imagePathMove );

  	$st = $db->prepare("
		UPDATE product
		SET image = :image
		WHERE productid = :lastid");

  	$st->bindParam(":lastid", $lastId);
  	$st->bindParam(":image", $imagePathDB);
  	$st->execute();
}

?>

<?php
	include "include/footer.php"
?>