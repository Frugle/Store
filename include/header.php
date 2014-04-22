<?php
if (session_status() == PHP_SESSION_NONE)
	session_start();

$urlPrepend = "/store/";

function isLoggedIn()
{
	return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Store</title>
	<link rel="stylesheet" type="text/css" href="/store/styles.css">
</head>
<body>
<div id="mainContainer">
	<header>
		<div>
			<a href="<?php echo $urlPrepend; ?>"><h1>Store</h1></a>
		</div>
		<div><div>
			<?php
				if (!isLoggedIn()) {
			?>
				<span><a href="<? echo $urlPrepend . 'login.php'; ?>">Login</a></span>
			<?php
				} else {
			?>
				Logged in as <?php echo $_SESSION["username"]; ?>
				<a href="<? echo $urlPrepend . 'login.php?logout'; ?>">Logout</a>
			<?php
				}
			?>
		</div></div>
		<div>
			<a href="<? echo $urlPrepend . 'user.php'; ?>">Profile</a>
		</div>
	</header>
	<div class="sideBar"  id="sideBarLeft">
		<div id="categories">
			<?php require_once "categorylist.php"; ?>
		</div>
	</div>
	<div class="sideBar" id="sideBarRight">
		<div class="topTen" id="topTen1">
			<h5>New items</h5>
			<table>
			<?php
				require_once "db.php";
				$rows = getLatestProducts(10);

				foreach ($rows as $product)
				{
					echo "<tr>";
					echo "<td><a href=\"/store/product/{$product["productid"]}\">{$product["brandid"]} - {$product["model"]}</a></td>";
					echo "</tr>";
				}
			?>
			</table>
		</div>
		<div class="topTen" id="topTen2">
			<h5>Top sellers</h5>
			<table>
			<?php
				require_once "db.php";
				$rows = getTopSellers(10);

				foreach ($rows as $product)
				{
					echo "<tr>";
					echo "<td><a href=\"/store/product/{$product["productid"]}\">{$product["brandid"]} - {$product["model"]}</a></td>";
					echo "</tr>";
				}
			?>
			</table>
		</div>
	</div>
	<div id="content">
