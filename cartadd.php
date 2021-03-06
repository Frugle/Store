<?php

/* 
	Webstore Project
		- Cart Add Item

	Version: 1.0
	Author: Mika
	Completed in: 60min
*/

if (session_status() == PHP_SESSION_NONE)
	session_start();

function addItem($itemId)
{
	if(isset($_SESSION['cart']) === false)
	{
		$_SESSION['cart'] = array();
	}

	$index = intval($itemId);

	if(isset($_SESSION['cart'][$index]))
	{
		$_SESSION['cart'][$index]++;
	}
	else
	{
		$_SESSION['cart'][$index] = 1;
	}
}

if(isset($_POST['item']) === true && validateCartAdd($_POST['item']))
{
	$index = intval($_POST['item']);

	addItem($index);

	echo 'Item added to the cart!';
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function validateCartAdd($productId)
{
	return preg_match('/^\d{1,11}$/', $productId);
}

?>
