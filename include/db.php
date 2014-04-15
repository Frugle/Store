<?php
	define("DB_HOST", "37.139.17.207");       //Database address
	define("DB_USER", "webdev");            //Database username
	define("DB_PASS", "nelio");          //Database password
	define("DB_NAME", "store");       //Database name

	define("DEBUG", true);

	function getDatabaseConnection()
	{
		try
		{
			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);

			if (DEBUG)
			{
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}

			return $db;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getProduct($productid)
	{
		try
		{
			$db = getDatabaseConnection();
			$query = "
				SELECT *
				FROM `product`
				WHERE productid = :productid
				";
			$prepare = $db->prepare($query);
			$prepare->bindParam(":productid", $productid);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			return $prepare->fetch();
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getCategoryProducts($categoryid)
	{
		try
		{
			$db = getDatabaseConnection();
			$query = "
				SELECT *
				FROM product
				INNER JOIN productcategory
				ON productcategory.productid = product.productid
				WHERE productcategory.categoryid = :categoryid
				";
			$prepare = $db->prepare($query);
			$prepare->bindParam(":categoryid", $categoryid);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getUser($usernameid)
	{
		try
		{
			$db = getDatabaseConnection();
			$query = "
				SELECT *
				FROM user
				WHERE usernameid = :username
				";

			$prepare = $db->prepare($query);
			$prepare->bindParam(":username", $usernameid);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			return $prepare->fetch();
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getOrders()
	{
		try
		{
			$db = getDatabaseConnection();
			$query = "
				SELECT *
				FROM `order`
				";
			$prepare = $db->prepare($query);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getUserOrders($usernameid)
	{
		try
		{
			$db = getDatabaseConnection();
			$query = "
				SELECT *
				FROM `order`
				WHERE usernameid = :username
				";
			$prepare = $db->prepare($query);
			$prepare->bindParam(":username", $usernameid);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getOrderProducts($orderid)
	{
		try
		{
			$db = getDatabaseConnection();
			$query = "
				SELECT *
				FROM `orderproduct`
				WHERE orderid = :orderid
				";
			$prepare = $db->prepare($query);
			$prepare->bindParam(":orderid", $orderid);
			$prepare->execute();

			$prepare->setFetchMode(PDO::FETCH_ASSOC);
			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getBrands()
	{
		try
		{
			$db = getDatabaseConnection();
			$prepare = $db->query('SELECT brandid FROM brand');
			$prepare->setFetchMode(PDO::FETCH_ASSOC);

			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}

	function getCategories()
	{
		try
		{
			$db = getDatabaseConnection();
			$prepare = $db->query('SELECT categoryid FROM category');
			$prepare->setFetchMode(PDO::FETCH_ASSOC);

			$rows = array();
			while ($row = $prepare->fetch())
			{
				$rows[] = $row;
			}
			return $rows;
		}
		catch (Exception $e) 
		{
			exit($e->getMessage());
		}
	}
?>