<?php
	session_start();
	if(!session_is_registered("BLOG_LOGIN"))
	{ 
		header("location:login.php");
	}
	
	if($_GET['action'] == 'publish')
	{	
		$prevPublished = true;
		$title = "";
		
		ob_start();
		require_once('db_connection.php');
		
		$tbl_name="blg_articles"; // Table name
		$sql="SELECT datePublished, articleTitle FROM $tbl_name WHERE articleId = ". $_GET['id'];
		$result=mysql_query($sql);
		
		if($result)
		{
			$row = mysql_fetch_array($result);
			$title = $row['articleTitle'];
			if(is_null($row['datePublished']))
			{
				$prevPublished = false;				
			}		
		}
		
		if(!$prevPublished)
		{
			//Create permalink only when first publishing the article, don't update it
			$special = array("?", "!", "%", "$", "@", "&", "*", "#", "'", "\"", ",", ".");
			$permalink = strtolower(str_replace(" ", "-", str_replace($special, "", $title)));
			
			$sql="UPDATE $tbl_name SET permalink = '$permalink', datePublished = NOW(), yearPosted = YEAR(NOW()), monthPosted = MONTH(NOW()), isPublished = 1 WHERE articleId = ". $_GET['id'];
		}
		else
		{
			$sql="UPDATE $tbl_name SET isPublished = 1 WHERE articleId = ". $_GET['id'];
		}
		
		$result=mysql_query($sql);	
		
		header("location:admin.php");
		
		ob_end_flush();
	}
	else
	{
		ob_start();
		require_once('db_connection.php');
		
		$tbl_name="blg_articles"; // Table name
				
		$sql="UPDATE $tbl_name SET isPublished = 0 WHERE articleId = ". $_GET['id'];		
		
		$result=mysql_query($sql);	
		
		header("location:admin.php");
		
		ob_end_flush();	
	}
		
?>