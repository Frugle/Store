
<?php

/* 
	Webstore Project
		- Cart Remove Item

	Version: 1.0
	Author: Mika
	Completed in: 60min
*/

if (session_status() == PHP_SESSION_NONE)
	session_start();

if(isset($_SESSION['cart']) === false)
{
	$_SESSION['cart'] = array();
}

if(isset($_POST['clear']) === true)
{
	$_SESSION['cart'] = array();
	echo 'All items removed from the cart!';
	return;
}

if(isset($_POST['item']) === true && validate($_POST['item']))
{
	$index = intval($_POST['item']);
	$keys = array_keys($_SESSION['cart']);
	$count = count($keys);

	for($i = 0; $i < $count; $i++)
	{
		if($_SESSION['cart'][$keys[$i]] === $index)
		{
			array_splice($_SESSION['cart'], $i, 1);
			echo 'Item removed from the cart!';
			return;
		}
	}
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function validate($productId)
{
	return preg_match('/^\d{1,11}$/', $productId);
}

?>
