<?php
require_once('include/header.php');
?>

<?php

/*
	Example
		- Permission Check

	Version: 1.0
*/

require_once('permissioncheck.php');

if(!hasPermission(PERM_ADMIN))
{
	exit(MSG_ERR_NOPERM);
}
else
{
	echo 'Access granted!';
}

?>

<?php
require_once('include/footer.php');
?>