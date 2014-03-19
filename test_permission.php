
<?php

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
