<?php
	include_once "include/header.php"
?>

<?php

$post = $_POST;

$logoutPosted = isset($_GET["logout"]);
$loginPosted = isset($_POST["login"]);
$loggedIn = isLoggedIn();

if ($logoutPosted && $loggedIn)
{
	$_SESSION = array();
	session_destroy();
	echo "<h2>Logged out!</h2>";
	$loggedIn = isLoggedIn();
}

if ($loginPosted && !$loggedIn)
{
	function tryLogin()
	{
		try
		{
			require("lib/password_compat/password.php");
			require_once("include/db.php");

			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
			$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

			$query = "
			SELECT usernameid, password, salt
			FROM user
			WHERE usernameid = :username
			";

			$prepare = $db->prepare($query);

			$prepare->bindParam(":username", 		$post["username"]);

			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);

			$row = $prepare->fetch();

			if (!isset($row["usernameid"]))
			{
				return false;
			}

			if ($row["usernameid"] !== $post["username"])
			{
				return false;
			}

			$toVerify = $post["password"] . $row["salt"];

			$passCorrect = password_verify($toVerify, $row["password"]);

			if (!$passCorrect)
			{
				return false;
			}

			$_SESSION['username'] = $row["usernameid"];
			$_SESSION['loggedin'] = 1;

			$db = null;
			return true;
		} 
		catch (Exception $e) 
		{
			return false;
		}

		$db = null;
		return false;
	}

	$loggedIn = tryLogin() == true;
	echo "Logged in: " . $loggedIn;
}

if ($loggedIn)
{
	echo "<br>Logged in as " . $_SESSION["username"] . "<br>";
	echo "<a href='login.php?logout'>Logout</a>";
}
else
{
?>

<h1>Login</h1>

<?php
	if ($loginPosted)
	{
		echo "<h2>Invalid username or password</h2>";
	}
?>

<form method="post" action="login.php">
	<label for="username">Username</label>
	<input type="text" name="username" value="<?php echo isset($post["username"]) ? $post["username"] : ""; ?>">
	<br>
	<label for="password">Password</label>
	<input type="password" name="password">
	<br>
	<input type="submit" name="login" value="Login">
</form>

<?php
}
?>

<?php
	include "include/footer.php"
?>