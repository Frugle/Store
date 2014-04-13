<?php
	// Functions in this file should not get information from database.
	// All necessary information to build html should be given in parameters.

	function getOrderRowHtml($orderRow, $orderProducts, $includeUsername = false)
	{
		$html = "";

		$html .= "<tr>";
		$html .= "<td style=\"border: 1px solid black\">{$orderRow["orderid"]}</td>";

		if ($includeUsername)
			$html .= "<td style=\"border: 1px solid black\"><a href=\"./user.php?user={$orderRow["usernameid"]}\">{$orderRow["usernameid"]}</a></td>";

		$html .= "<td style=\"border: 1px solid black\">";
		$html .= "<table>";
		$html .= "<th>Name<th>Amount<th>Price";

		$totalPrice = 0;
		foreach ($orderProducts as $orderProduct) 
		{
			$product = getProduct($orderProduct["productid"]);
			$productPrice = $orderProduct["price"] * $orderProduct["count"];
			$totalPrice += $productPrice;

			$html .= "<tr>";
			$html .= "<td style=\"width: 450px\">{$product["brandid"]} - {$product["model"]}</td>";
			$html .= "<td>{$orderProduct["count"]}</td>";
			$html .= "<td>{$productPrice}</td>";
			$html .= "</tr>";
		}

		$html .= "</table>";
		$html .= "</td>";

		$html .= "<td style=\"border: 1px solid black\">{$totalPrice}</td>";
		$html .= "<td style=\"border: 1px solid black\">{$orderRow["date"]}</td>";
		$html .= "</tr>";

		return $html;
	}
?>