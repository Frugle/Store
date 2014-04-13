<?php
	include "include/header.php"
?>

<?php
	if (!isLoggedIn())
		exit("Not logged in");

	$username = $_SESSION["username"];
	if (isset($_GET["user"]))
	{
		require_once "permissioncheck.php";
		if (!hasPermission(PERM_MODERATOR))
			exit("No permissions to view this page. GET OUT!");

		$username = $_GET["user"];
	}

	$row = getUser($username);
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
	$rows = getUserOrders($_SESSION["username"]);

	echo "<table>";
	echo "<th>Order id<th>Products<th>Total<th>Date";
	foreach ($rows as $row) 
	{
		require_once "include/htmlhelpers.php";

		$html = getOrderRowHtml($row, getOrderProducts($row["orderid"]));

		echo $html;
	}
	echo "</table>";
?>

<?php
	include "include/footer.php"
?>