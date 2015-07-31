<?php

	session_start();
	if(!session_is_registered("BLOG_LOGIN"))
	{ 
		header("location:login.php");
	}

	if($_GET['action'] == 'newpost')
		$action = "add";
	else 
		$action = "edit";
		
	ob_start();
	
	require_once('db_connection.php');
	
	$tbl_name="blg_articles"; // Table name

	// Connect to server and select databse.
	//mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	//mysql_select_db("$db_name")or die("cannot select DB");
	
	$articleId = $_POST['articleId'];
	
	$txtTitle=$_POST['txtTitle']; 
	$txtDescription=$_POST['txtDescription']; 
	$txtKeywords=$_POST['txtKeywords']; 	
	$txtPageDesc=$_POST['txtPageDesc'];
	
	// To protect MySQL injection (more detail about MySQL injection)
	$txtTitle = stripslashes($txtTitle);
	$txtDescription = stripslashes($txtDescription);
	$txtKeywords = stripslashes($txtKeywords);
	$txtPageDesc = stripslashes($txtPageDesc);
	
	$txtTitle = mysql_real_escape_string($txtTitle);
	$txtDescription = mysql_real_escape_string($txtDescription);
	$txtKeywords = mysql_real_escape_string($txtKeywords);
	$txtPageDesc = mysql_real_escape_string($txtPageDesc);
	
	//$special = array("?", "!", "%", "$", "@", "&", "*", "#", "'", "\"", ",", ".");

	//$permalink = strtolower(str_replace(" ", "-", str_replace($special, "", $txtTitle)));
	
	if($action == "add")
	{
		$sql="INSERT INTO $tbl_name (articleTitle, articleDesc, keywords, pageDescription, dateCreated) VALUES ('$txtTitle', '$txtDescription', '$txtKeywords', '$txtPageDesc', NOW())";		
	}
	else
	{
		$sql="UPDATE $tbl_name SET articleTitle = '$txtTitle', articleDesc = '$txtDescription', keywords = '$txtKeywords', pageDescription = '$txtPageDesc', dateModified = NOW() WHERE articleId = $articleId";		
	}
		
	$count=mysql_query($sql);

	if($count==1)
	{			
		header("location:admin.php");
	}
	else 
	{
		require_once('header.php');
		echo "<p>An error occurred</p>";
		echo "<p>$sql</p>";
		require_once('footer.php');	
	}

	ob_end_flush();

?>