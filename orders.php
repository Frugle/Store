<?php
	include "include/header.php";
?>

<?php
	require_once "permissioncheck.php";
	if (!hasPermission(PERM_MODERATOR))
		exit("No permissions to view this page. GET OUT!");
?>

<h1>Orders</h1>
<?php
	$orders = getOrders();
	echo "<table>";
	echo "<th>Order id<th>Username<th>Products<th>Total<th>Date";
	foreach ($orders as $row) 
	{
		require_once "include/htmlhelpers.php";

		$html = getOrderRowHtml($row, getOrderProducts($row["orderid"]), true);
		echo $html;
	}
	echo "</table>";
?>

<?php
	include "include/footer.php"
?>