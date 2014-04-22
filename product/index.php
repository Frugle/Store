<?php
	include_once "../include/header.php"
?>
<?php
	if (!isset($_GET["id"]) || empty($_GET["id"]))
	{
		header("HTTP/1.0 404 Not Found");
		exit("Product not found (Invalid GET)");
	}

	$product = getProduct($_GET["id"]);

	if ($product == null)
		exit("Product not found (DB)");
	else
	{
		if (isset($_GET["add"]) && isLoggedIn())
		{
			//echo "CART ADD" . intval($product["productid"]);
			require_once("../cartadd.php");
			addItem(intval($product["productid"]));
		}

		if (isLoggedIn())
			echo "<a href=/store/product/{$product["productid"]}/add>Add to cart</a><br>";

		echo "Productid: " . $product["productid"] . "<br>";
		echo "Brand: " . $product["brandid"] . "<br>";
		echo "Model: " . $product["model"] . "<br>";
		echo "Description: " . $product["description"] . "<br>";
		echo "Warranty: " . $product["warranty"] . "<br>";
		echo "Base price: " . $product["baseprice"] . "<br>";
		echo "Discount: " . $product["discount"] . "<br>";

		require_once "../include/htmlhelpers.php";

		$imgUrl = fixImageUrl($product["image"]);

		echo "Image<br>";
		echo "<img src='{$imgUrl}'>";
	}
?>
<?php
	include "../include/footer.php"
?>