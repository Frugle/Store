<?php

/* 
	Webstore Project
		- Category List

	Version: 1.0
	Author: Mika
	Completed in: 4hrs
*/

$rawCategories = db_getAllCategories();
$completeTree = array();
createCategoryTree($rawCategories, $completeTree, null);
//echoCategoryTree($completeTree, '');
echoCategoryTreeRequestSensitive($completeTree, '');

function createCategoryTree(&$rawCategories, &$result, $parent)
{
	foreach ($rawCategories as $key => $val)
	{
		if($val == $parent)
		{
			$result[$key] = createCategoryTree($rawCategories, $result[$key], $key);
		}
	}
	
	return $result;
}

// Doesn't work, don't use
function getChildTreeParentName(&$completeTree, &$childTree)
{
	if ($completeTree === null)
		return null;

	foreach ($completeTree as $key => $children)
	{
		if ($children == $childTree)
		{
			return $key;
		}

		return getChildTreeParentName($children, $childTree);
	}

	return null;
}

function echoCategory($name, $path)
{
	$newpath = $path . $name . '/';
	printf('<li>%s<br>', sprintf('<a href="category/%s">%s</a>',
		$newpath, $name));

	return $newpath;
}

function echoCategoryTree(&$categoryTree, $path, $maxDepth = null)
{
	if ($categoryTree === null)
		return;

	$nextDepth = $maxDepth - 1;

	echo '<ul>';
	foreach ($categoryTree as $key => $val)
	{
		$newpath = echoCategory($path, $key);

		if ($maxDepth === null || $nextDepth > 0)
			echoCategoryTree($categoryTree[$key], $newpath);
	}
	echo '</ul>';
}

function getChildCategories(&$all, &$result, &$parents)
{
	foreach ($all as $key => $val) 
	{
		if ($value === $parents[0])
		{
			return $result = getChildCategories($all[array_shift($parents)], $result, $parents);
		}
	}	
}

function echoCategoryTreeRequestSensitive(&$categoryTree, $path, $currentGet = "category1")
{
	if ($categoryTree === null)
		return;

	$getCat = isset($_GET[$currentGet]) ? $_GET[$currentGet] : null;
	$catGetNum = substr($currentGet, -1, 1);

	echo '<ul>';
	foreach ($categoryTree as $currentParent => $children) 
	{
		$newPath = echoCategory($currentParent, $path);

		if ($getCat !== null && $getCat == $currentParent)
			echoCategoryTreeRequestSensitive($categoryTree[$currentParent], $newPath, "category" . ($catGetNum + 1));
	}
	echo '</ul>';
}

?>

<!-- THE REST ARE PLACEHOLDERS UNTIL THEY'RE MOVED -->

<?php

/* MOVE TO EXTERNAL FILE? */
function db_getAllCategories()
{
	require_once("db.php");

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