
<!--

	Webstore Project
		- Permission Check

	Version: 0.1
	Author: Mika
	Completed in: 0.5hrs

-->
<?php

/* PERMISSION LEVELS */
define('PERM_USER', 0);
define('PERM_MODERATOR', 1);
define('PERM_ADMIN', 2);

/* MESSAGES */
define('MSG_ERR_NOPERM', 'Access denied.');

function hasPermission($permissionlevel)
{
	if(isLoggedIn())
		return $db_getPermissionLevel($_SESSION['username']) >= $permissionlevel;
	return false;
}

function isLoggedIn()
{
	return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === 1;
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function validate($usernameid)
{
	return preg_match('/^.{0,32}$/', $usernameid);
}

/* MOVE TO EXTERNAL FILE? */
function db_getPermissionLevel($usernameid)
{
	require_once("include/db.php");

	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->query('SELECT permissionlevel FROM user WHERE usernameid = :usernameid');
	$st->bindParam(":usernameid", $usernameid);
	$st->setFetchMode(PDO::FETCH_ASSOC);

	$result = $st->fetch();

	if($result)
		return $result['permissionlevel'];
	return PERM_USER;
}

?>
