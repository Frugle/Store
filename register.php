<?php
	include "include/header.php"
?>

<?php

$post = $_POST;

$errors = array();
$posted = isset($post["register"]);

if ($posted)
{
	require("lib/password_compat/password.php");
	require_once("include/db.php");

	try
	{
		$user = getUser($post["username"]);
		$userExists = isset($user["usernameid"]) && !empty($user["usernameid"]);

		if (strlen($post["username"]) < 1)
			array_push($errors, "Username too short");
		if (strlen($post["username"]) > 32)
			array_push($errors, "Username too long");
		if ($userExists)
			array_push($errors, "Username already in use");
		if (strlen($post["password"]) < 8)
			array_push($errors, "Password too short");
		if ($post["password"] !== $post["confirmpassword"])
			array_push($errors, "Passwords don't match");
		if (strlen($post["firstname"]) > 32)
			array_push($errors, "First name too long");
		if (strlen($post["lastname"]) < 1)
			array_push($errors, "Last name too short");
		if (strlen($post["lastname"]) > 32)
			array_push($errors, "Last name too long");
		if (strlen($post["address"]) < 1)
			array_push($errors, "Address too short");
		if (strlen($post["address"]) > 64)
			array_push($errors, "Address too long");
		if (strlen($post["postcode"]) < 1)
			array_push($errors, "Post code too short");
		if (strlen($post["postcode"]) > 5)
			array_push($errors, "Post code too long");
		if (strlen($post["postoffice"]) < 1)
			array_push($errors, "Post office too short");
		if (strlen($post["postoffice"]) > 32)
			array_push($errors, "Post office too long");
		if (strlen($post["phone"]) < 1)
			array_push($errors, "Phone too short");
		if (strlen($post["phone"]) > 16)
			array_push($errors, "Phone too long");
		if (strlen($post["email"]) < 1)
			array_push($errors, "E-mail too short");
		if (strlen($post["email"]) > 32)
			array_push($errors, "E-mail too long");

		if (count($errors) <= 0)
		{
			$db = getDatabaseConnection();

			$query = "
			INSERT INTO user (
				usernameid, 
				password, 
				salt, 
				firstname, 
				lastname,
				permissionlevel,
				address,
				postcode,
				postoffice,
				phone,
				email)
			VALUE (
				:usernameid, 
				:password, 
				:salt, 
				:firstname, 
				:lastname,
				:permissionlevel,
				:address,
				:postcode,
				:postoffice,
				:phone,
				:email)
			";

			$prepare = $db->prepare($query);

			if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN") // FOR DEBUG PURPOSES ONLY
				$salt = "000000000000000000000000000000000000000000000000000000000000";
			else
				$salt = file_get_contents("/dev/urandom", false, null, 0, 60);

			$hash = password_hash($post["password"] . $salt, PASSWORD_BCRYPT, ["cost" => 13]);

			$permissionlevel = 0;

			$prepare->bindParam(":usernameid", 		$post["username"]);
			$prepare->bindParam(":password", 		$hash);
			$prepare->bindParam(":salt", 			$salt);
			$prepare->bindParam(":firstname", 		$post["firstname"]);
			$prepare->bindParam(":lastname", 		$post["lastname"]);
			$prepare->bindParam(":permissionlevel", $permissionlevel, PDO::PARAM_INT);
			$prepare->bindParam(":address", 		$post["address"]);
			$prepare->bindParam(":postcode", 		$post["postcode"]);
			$prepare->bindParam(":postoffice", 		$post["postoffice"]);
			$prepare->bindParam(":phone", 			$post["phone"]);
			$prepare->bindParam(":email", 			$post["email"]);

			$prepare->execute();
		}

		$db = null;
	} 
	catch (Exception $e) 
	{
		exit($e->getMessage());
	}
}

$registered = $posted && count($errors) <= 0;

?>


<h1>Register</h1>

<?php
if ($registered)
{
	echo "<h1>Registered!</h1>";
}
else
{
	if (count($errors) > 0)
	{
		echo "<h2>Please fix the following errors:</h2>";
		echo "<ul>";
		for ($i=0; $i < count($errors); $i++) 
		{ 
			echo "<li>{$errors[$i]}</li>";
		}
		echo "</ul>";
	}
?>

<form method="post">
	<label for="username">Username</label>
	<input type="text" name="username" value="<?php echo isset($post["username"]) ? $post["username"] : ""; ?>"></label>
	<br>
	<label for="password">Password</label>
	<input type="password" name="password" value="<?php echo isset($post["password"]) ? $post["password"] : ""; ?>">
	<br>
	<label for="confirmpassword">Confirm password</label>
	<input type="password" name="confirmpassword" value="<?php echo isset($post["confirmpassword"]) ? $post["confirmpassword"] : ""; ?>">
	<br>
	<label for="firstname">First name</label>
	<input type="text" name="firstname" value="<?php echo isset($post["firstname"]) ? $post["firstname"] : ""; ?>">
	<br>
	<label for="lastname">Last name</label>
	<input type="text" name="lastname" value="<?php echo isset($post["lastname"]) ? $post["lastname"] : ""; ?>">
	<br>
	<label for="address">Address</label>
	<input type="text" name="address" value="<?php echo isset($post["address"]) ? $post["address"] : ""; ?>">
	<br>
	<label for="postcode">Post code</label>
	<input type="text" name="postcode" value="<?php echo isset($post["postcode"]) ? $post["postcode"] : ""; ?>">
	<br>
	<label for="postoffice">Post office</label>
	<input type="text" name="postoffice" value="<?php echo isset($post["postoffice"]) ? $post["postoffice"] : ""; ?>">
	<br>
	<label for="phone">Phone</label>
	<input type="text" name="phone" value="<?php echo isset($post["phone"]) ? $post["phone"] : ""; ?>">
	<br>
	<label for="email">E-mail</label>
	<input type="text" name="email" value="<?php echo isset($post["email"]) ? $post["email"] : ""; ?>">
	<br>
	<input type="submit" name="register" value="Register">
</form>

<?php
}
?>

<?php
	include "include/footer.php"
?>