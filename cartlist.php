<?php

/* 
	Webstore Project
		- Cart List Items

	Version: 1.0
	Author: Mika
	Completed in: 90min
*/

if (session_status() == PHP_SESSION_NONE)
	session_start();

if(isset($_SESSION['cart']) === true)
{
	$productIds = array_keys($_SESSION['cart']);

	if(is_array($productIds) === true && count($productIds) > 0)
	{
		$productInfo = getProductInfo($productIds);

		if($productInfo === null)
		{
			echo 'Error: Invalid productids in cart.<br>';
		}
		else
		{
			addProductCount($productInfo, $_SESSION['cart']);
			printProductInfo($productInfo);
		}
	}
	else
	{
		echo 'The cart is empty!<br>';
	}
}

function getProductInfo($productIds)
{
	$allValid = true;

	foreach($productIds as $id)
	{
		$allValid = $allValid && validateCart($id);
	}

	if($allValid === true)
		return db_getAllProducts($productIds);
	return null;
}

function addProductCount(&$productInfo, $counts)
{
	for($i = 0; $i < count($productInfo); $i++)
	{
		$productInfo[$i]['count'] = $counts[intval($productInfo[$i]['productid'])];
	}
}

function printProductInfo($productInfo)
{
	foreach($productInfo as $info)
	{
		$c = $info['count'];
		$bp = $info['baseprice'];
		$dc = $info['discount'];
	
		printf('<table><tr><td><img src="%s" height="100"/>', "/store/{$info['image']}");
		printf('<td><p>[%d] <b>%s</b> - %s</p>', $info['count'], $info['model'],
			$info['discount'] > 0
			? sprintf('%s EUR (-%s%%)', $c * $bp * (1.0 - $dc), $dc * 100.0)
			: sprintf('%s EUR', $c * $bp));

		echo '<blockquote>';
		printf('<p>%s</p>', $info['brandid']);
		printf('<p>%s</p>', $info['description']);
		printf('<p>%s</p>', $info['model']);
		echo '</blockquote><br></table>';
	}
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function validateCart($productId)
{
	return preg_match('/^\d{1,11}$/', $productId);
}

/* MOVE TO EXTERNAL FILE? */
function db_getAllProducts($productIds)
{
	require_once("include/db.php");

	$db = getDatabaseConnection();

	$query = 'SELECT * FROM product WHERE productid = :id0 ';
	$count = count($productIds);

	for($i = 1; $i < $count; $i++)
	{
		$query .= ' OR productid = :id' . $i;
	}

	$st = $db->prepare($query);

	for($i = 0; $i < $count; $i++)
	{
		$st->bindParam(":id" . $i, $productIds[$i]);
	}

	$st->execute();
	$st->setFetchMode(PDO::FETCH_ASSOC);

	$products = array();
	while($row = $st->fetch())
	{
		$products[] = $row;
	}

	return $products;
}

?>
