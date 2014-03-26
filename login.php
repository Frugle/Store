<?php
	include_once "include/header.php"
?>

<?php
if (isset($_GET["logout"]))
{
	$_SESSION = array();
	session_destroy();
	echo("Logged out!");
}

if (isset($_POST["login"]))
{
	function tryLogin()
	{
		try
		{
			require("lib/password_compat/password.php");
			require_once("include/db.php");

			$post = $_POST;

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
				echo("invalid username or password 1");
				return;
			}

			if ($row["usernameid"] !== $post["username"])
			{
				echo("invalid username or password 2");
				return;
			}

			$toVerify = $post["password"] . $row["salt"];

			$passCorrect = password_verify($toVerify, $row["password"]);

			if (!$passCorrect)
			{
				echo("invalid username or password 3");
				return;
			}

			$_SESSION['username'] = $row["usernameid"];
			$_SESSION['loggedin'] = 1;

			echo("LOGGED IN! :D");
		} 
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}

		$db = null;
	}

	tryLogin();
}

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == 1)
{
	echo "<br>Logged in as " . $_SESSION["username"] . "<br>";
	echo "<a href='login.php?logout'>Logout</a>";
}

?>

<h1>Login</h1>
<form method="post" action="login.php">
	<label for="username">Username</label>
	<input type="text" name="username">
	<br>
	<label for="password">Password</label>
	<input type="text" name="password">
	<br>
	<input type="submit" name="login" value="Login">
</form>

<?php
	include "include/footer.php"
?>