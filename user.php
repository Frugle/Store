<?php
	include "include/header.php"
?>

<?php
	function getUserInfo()
	{
		try
		{
			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "
				SELECT *
				FROM user
				WHERE usernameid = :username
				";

			$prepare = $db->prepare($query);
			$prepare->bindParam(":username", $_SESSION['username']);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			return $prepare->fetch();
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getUserOrders()
	{
		try
		{
			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "
				SELECT *
				FROM `order`
				WHERE usernameid = :username
				";
			$prepare = $db->prepare($query);
			$prepare->bindParam(":username", $_SESSION['username']);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getOrderProducts($orderid)
	{
		try
		{
			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "
				SELECT *
				FROM `orderproduct`
				WHERE orderid = :orderid
				";
			$prepare = $db->prepare($query);
			$prepare->bindParam(":orderid", $orderid);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getProduct($productid)
	{
		try
		{
			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = "
				SELECT *
				FROM `product`
				WHERE productid = :productid
				";
			$prepare = $db->prepare($query);
			$prepare->bindParam(":productid", $productid);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			$row = $prepare->fetch();
			return $row;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}
?>

<?php
	$row = getUserInfo();
	echo "<h1>Shipping information</h1>";
	echo "<table>";
	echo "<tr>";
	echo "<td style=\"font-weight: bold\">First name</td><td>{$row["firstname"]}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style=\"font-weight: bold\">Last name</td><td>{$row["lastname"]}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style=\"font-weight: bold\">Address</td><td>{$row["address"]}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style=\"font-weight: bold\">Post code</td><td>{$row["postcode"]}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style=\"font-weight: bold\">Post office</td><td>{$row["postoffice"]}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style=\"font-weight: bold\">Phone</td><td>{$row["phone"]}</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td style=\"font-weight: bold\">E-mail</td><td>{$row["email"]}</td>";
	echo "</tr>";
	echo "</table>";
?>

<h1>Orders</h1>
<?php
	$rows = getUserOrders();

	echo "<table>";
	echo "<th>Order id<th>Products<th>Total<th>Date";
	foreach ($rows as $row) 
	{
		echo "<tr>";
		echo "<td style=\"border: 1px solid black\">{$row["orderid"]}</td>";

		echo "<td style=\"border: 1px solid black\">";
		echo "<table>";
		echo "<th>Name<th>Amount<th>Price";

		$orderProducts = getOrderProducts($row["orderid"]);
		$totalPrice = 0;
		foreach ($orderProducts as $orderProduct) 
		{
			$product = getProduct($orderProduct["productid"]);
			$productPrice = $orderProduct["price"] * $orderProduct["count"];
			$totalPrice += $productPrice;

			echo "<tr>";
			echo "<td style=\"width: 450px\">{$product["brandid"]} - {$product["model"]}</td>";
			echo "<td>{$orderProduct["count"]}</td>";
			echo "<td>{$productPrice}</td>";
			echo "</tr>";
		}

		echo "</table>";
		echo "</td>";

		echo "<td style=\"border: 1px solid black\">{$totalPrice}</td>";
		echo "<td style=\"border: 1px solid black\">{$row["date"]}</td>";
		echo "</tr>";
	}
	echo "</table>";
?>

<?php
	include "include/footer.php"
?>