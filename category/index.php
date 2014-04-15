<?php
	include_once "../include/header.php"
?>

<?php

	function getHighestCategory()
	{
		$highestCategory = null;
		for ($i = 1; $i <= 5; $i++) 
		{
			if (!isset($_GET["category" . $i]))
				return $highestCategory;

			$highestCategory = $_GET["category" . $i];
		}

		return $highestCategory;
	}

	function echoCategoryProducts($categoryid)
	{
		require_once "../include/db.php";
		require_once "../include/htmlhelpers.php";

		echo "<table>";
		echo "<th>Image<th>Product name<th>Price";
		$products = getCategoryProducts($categoryid);
		//var_dump($products);
		foreach ($products as $key => $row) 
		{
			echo "<tr>";

			$fixedUrl = fixImageUrl($row["image"]);
			$shouldEchoImage = !empty($fixedUrl);
			echo "<td style=\"height: 80px; width: 80px\">" . ($shouldEchoImage ? "<img src=\"{$fixedUrl}\" style=\"max-width: 80px; max-height: 80px\">" : "") . "</td>";
			echo "<td style=\"width: 300px\">{$row["brandid"]} - {$row["model"]}</td>";
			$finalPrice = $row["baseprice"] * (1 - $row["discount"]);
			echo "<td>{$finalPrice}</td>";

			echo "</tr>";
		}
		echo "</table>";
	}

	echoCategoryProducts(getHighestCategory())
?>

<?php
	include_once "../include/footer.php"
?>