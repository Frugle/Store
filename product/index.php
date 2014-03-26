<?php
	include "../include/header.php"
?>
<?php
	function getProduct($productId)
	{
		if (!isset($productId))
			return null;

		try
		{
			require_once("../include/db.php");

			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$query = "
			SELECT *
			FROM product
			WHERE productid = :productid
			";

			$prepare = $db->prepare($query);

			$prepare->bindParam(":productid", 		$productId);

			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);

			$row = $prepare->fetch();

			$db = null;

			if (!isset($row["productid"]))
				return null;

			return $row;
		} 
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

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
		echo "Productid: " . $product["productid"] . "<br>";
		echo "Brand: " . $product["brandid"] . "<br>";
		echo "Model: " . $product["model"] . "<br>";
		echo "Description: " . $product["description"] . "<br>";
		echo "Warranty: " . $product["warranty"] . "<br>";
		echo "Base price: " . $product["baseprice"] . "<br>";
		echo "Discount: " . $product["discount"] . "<br>";
		echo "Image<br>";
		echo "<img src='/store/{$product["image"]}'>";
	}
?>
<?php
	include "../include/footer.php"
?>