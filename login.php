<?php
	include_once "include/header.php"
?>

<?php

$post = $_POST;

function tryLogin()
{
	global $post;

	try
	{
		require("lib/password_compat/password.php");
		require_once("include/db.php");

		$user = getUser($post["username"]);

		if (!isset($user["usernameid"]))
		{
			return false;
		}

		if ($user["usernameid"] !== $post["username"])
		{
			return false;
		}

		$toVerify = $post["password"] . $user["salt"];

		$passCorrect = password_verify($toVerify, $user["password"]);

		if (!$passCorrect)
		{
			return false;
		}

		$_SESSION['username'] = $user["usernameid"];
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
	$loggedIn = tryLogin() === true;
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