<?php
	include "include/header.php"
?>

<?php

/* 
	Webstore Project
		- Category List

	Version: 1.0
	Author: Mika
	Completed in: 4hrs
*/

$all = db_getAllCategories();
$arr = array();
createCategoryTree($all, $arr, null, '');

function createCategoryTree(&$all, &$arr, $parent, $path)
{
	echo '<ul>';
	foreach ($all as $key => $val)
	{
		if($val == $parent)
		{
			$newpath = $path . $key . '/';
			printf('<li>%s<br>', sprintf('<a href="category/%s">%s</a>',
				$newpath, substr($newpath, strrpos($newpath, '/', -2))));
			$arr[$key] = createCategoryTree($all, $arr[$key], $key, $newpath);
		}
	}

	echo '</ul>';
	return $arr;
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function db_getAllCategories()
{
	require_once("include/db.php");

	$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$st = $db->prepare('SELECT * FROM category');
	$st->execute();
	$st->setFetchMode(PDO::FETCH_NUM);

	$categories = array();
	while($row = $st->fetch())
	{
		$categories[$row[0]] = $row[1];
	}

	return $categories;
}

?>

<?php
	include "include/footer.php"
?>