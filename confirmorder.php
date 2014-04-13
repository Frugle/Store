<?php
	include_once "include/header.php";
?>
<?php

	if (!isLoggedIn())
		exit("Not logged in!");

	require_once "include/db.php";

	$validCart = isset($_SESSION['cart']) && count($_SESSION['cart']) > 0;

	$confirm = isset($_POST["confirm"]);

	try
	{
		$db = getDatabaseConnection();

		if ($confirm)
		{
			$query = "
			INSERT INTO `order` (
				usernameid, 
				date, 
				message)
			VALUE (
				:usernameid, 
				NOW(),
				:message)
			";

			$prepare = $db->prepare($query);

			$message = "";
			if (isset($_POST["message"]))
				$message = $_POST["message"];

			$prepare->bindParam(":usernameid", 	$_SESSION['username']);
			//$prepare->bindParam(":date", 		time(), PDO::PARAM_INT);
			$prepare->bindParam(":message", 	$message);
			$prepare->execute();

			$orderId = $db->lastInsertId();

			$query = "
			INSERT INTO orderproduct (
				orderid,
				productid,
				price,
				count)
			VALUES (
				:orderid,
				:productid,
				:price,
				:count)
			";
			$prepare = $db->prepare($query);

			$db2 = getDatabaseConnection();

			$productIds = $_SESSION['cart'];
			foreach ($productIds as $productid => $count) 
			{
				$prepare->bindParam(":orderid", $orderId);
				$prepare->bindParam(":productid", $productid);
				$prepare->bindParam(":count", $count);

				$product = getProduct($productid);

				$baseprice = $product["baseprice"];
				$discount = $product["discount"];
				$price = $baseprice * (1.0 - $discount);

				$prepare->bindParam(":price", $price);
				//echo "Query1: " . $query;
				$prepare->execute();
			}

			$db2 = null;

			$_SESSION['cart'] = array();
		}
		else
		{
			$user = getUser($_SESSION['username']);
		}
	}
	catch (Exception $e) 
	{
		exit($e->getMessage());
	}

	if (!$confirm)
	{
		echo "<h1>Shipping information</h1>";

		echo "<table>";
		echo "<tr>";
		echo "<td style=\"font-weight: bold\">First name</td><td>{$user["firstname"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style=\"font-weight: bold\">Last name</td><td>{$user["lastname"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style=\"font-weight: bold\">Address</td><td>{$user["address"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style=\"font-weight: bold\">Post code</td><td>{$user["postcode"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style=\"font-weight: bold\">Post office</td><td>{$user["postoffice"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style=\"font-weight: bold\">Phone</td><td>{$user["phone"]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td style=\"font-weight: bold\">E-mail</td><td>{$user["email"]}</td>";
		echo "</tr>";
		echo "</table>";

		echo "<h1>Shopping cart</h1>";
		include "cartlist.php";
	}

	if ($validCart && !$confirm)
	{
?>

<form method="post">
<label for="message">Message</label>
<textarea row="10" cols="40" name="message">
</textarea>
<br><br>
<input type="submit" name="confirm" value="Confirm Order">
</form>

<?php
	}
	else if ($confirm)
	{
		echo "<h2>Order received!</h2>";
	}
?>

<?php
	
	include_once "include/footer.php";
?>