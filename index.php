<?php
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Store</title>
	</head>
	<body>
		Index
		<br>
		<?php
			if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1)
				echo "Logged in as " . $_SESSION["username"];
		?>
	</body>
</html>