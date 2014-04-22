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

		require_once "../include/htmlhelpers.php";

		echo "<table id=\"productInfoContainer\">";
		echo "<tr>";
		echo "<td id=\"productImageContainer\">";
		$imgUrl = fixImageUrl($product["image"]);
		echo "<img src='{$imgUrl}'>";
		echo "</td>";
		echo "<td>";

		echo "<table id=\"productInfoGeneral\">";
		echo "<tr>";
		echo "<td class=\"label\">Product ID</td>";
		echo "<td>{$product["productid"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"label\">Brand</td>";
		echo "<td>{$product["brandid"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"label\">Model</td>";
		echo "<td>{$product["model"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td class=\"label\">Warranty</td>";
		echo "<td>{$product["warranty"]} months</td>";
		echo "</tr>";
		if (isLoggedIn())
		{
			echo "<tr>";
			echo "<td colspan=\"2\"><a href=/store/product/{$product["productid"]}/add>ADD TO CART</a></td>";
			echo "</tr>";
		}
		echo "<tr>";
		echo "<td colspan=\"2\">";

		$finalPrice = $product["baseprice"] * (1 - $product["discount"]);
		$discount = $product["discount"] * 100;

		echo "<span class=\"finalprice\">\${$finalPrice}</span>";

		if ($discount != 0)
			echo " -{$discount}%";

		if ($discount != 0)
			echo "<br><span class=\"baseprice\">\${$product["baseprice"]}</span>";

		echo "</td>";
		echo "</tr>";
		echo "</table>";

		echo "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan=\"2\" id=\"desc\"><p>{$product["description"]}</p></td>";
		echo "</tr>";
		echo "</table>";
	}
?>
<?php
	include "../include/footer.php"
?>