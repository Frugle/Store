
<!DOCTYPE html>
<html>
<head>
	<title>Test Cart</title>
</head>
<body>
	<form method="post" action="cartadd.php">
		ProductId: <input type="text" name="item"/>
		<button type="submit"/>Add</button>
	</form><br>

	<form method="post" action="cartremove.php">
		ProductId: <input type="text" name="item"/>
		<button type="submit"/>Remove</button>
	</form><br>

	<form method="post" action="cartremove.php">
		<input type="hidden" name="clear"/>
		<button type="submit"/>Remove all</button>
	</form><br>

	<form method="post" action="cartlist.php">
		<button type="submit"/>List</button>
	</form><br>
</body>
</html>
