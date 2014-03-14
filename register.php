<?php

$post = $_POST;

if (isset($post["register"]))
{
	require_once("include/db.php");

	try
	{
		$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
		$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

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

		$hash = password_hash($post["password"], PASSWORD_BCRYPT);

		$permissionlevel = 0;

		$prepare->bindParam(":usernameid", 		$post["username"]);
		$prepare->bindParam(":password", 		$hash);
		$prepare->bindParam(":salt", 			$hash);
		$prepare->bindParam(":firstname", 		$post["firstname"]);
		$prepare->bindParam(":lastname", 		$post["lastname"]);
		$prepare->bindParam(":permissionlevel", $permissionlevel, PDO::PARAM_INT);
		$prepare->bindParam(":address", 		$post["address"]);
		$prepare->bindParam(":postcode", 		$post["postcode"]);
		$prepare->bindParam(":postoffice", 		$post["postoffice"]);
		$prepare->bindParam(":phone", 			$post["phone"]);
		$prepare->bindParam(":email", 			$post["email"]);

		$prepare->execute();

		$db = null;
	} 
	catch (Exception $e) 
	{
		exit($e->getMessage());
	}
}

?>


<h1>Register</h1>
<form method="post">
	<label for="username">Username</label>
	<input type="text" name="username">
	<br>
	<label for="password">Password</label>
	<input type="text" name="password">
	<br>
	<label for="confirmpassword">Confirm password</label>
	<input type="text" name="confirmpassword">
	<br>
	<label for="firstname">First name</label>
	<input type="text" name="firstname">
	<br>
	<label for="lastname">Last name</label>
	<input type="text" name="lastname">
	<br>
	<label for="address">Address</label>
	<input type="text" name="address">
	<br>
	<label for="postcode">Post code</label>
	<input type="text" name="postcode">
	<br>
	<label for="postoffice">Post office</label>
	<input type="text" name="postoffice">
	<br>
	<label for="phone">Phone</label>
	<input type="text" name="phone">
	<br>
	<label for="email">E-mail</label>
	<input type="text" name="email">
	<br>
	<input type="submit" name="register" value="Register">
</form>