
<?php

/* 
	Webstore Project
		- Permission Check

	Version: 1.0
	Author: Mika
	Completed in: 1.0hrs
*/

/* PERMISSION LEVELS */
define('PERM_USER', 0);
define('PERM_MODERATOR', 1);
define('PERM_ADMIN', 2);

/* MESSAGES */
define('MSG_ERR_NOPERM', 'Access denied.');

function hasPermission($permissionlevel)
{
	if(isLoggedIn())
		return db_getPermissionLevel($_SESSION['username']) >= $permissionlevel;
	return false;
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

	$user = getUser($usernameid);
	
	if($user)
		return $user['permissionlevel'];
	return PERM_USER;
}

?>
