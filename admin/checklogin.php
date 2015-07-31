<?php

	ob_start();
	require_once('db_connection.php');
	$tbl_name="blg_login"; // Table name

	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	 // Define $myusername and $mypassword 
	$myusername=$_POST['username']; 
	$mypassword=$_POST['password'];
	
	// To protect MySQL injection (more detail about MySQL injection)
	$myusername = stripslashes($myusername);
	$mypassword = stripslashes($mypassword);
	$myusername = mysql_real_escape_string($myusername);
	$mypassword = mysql_real_escape_string($mypassword);
	
	$encusername = md5($myusername);
	$encpassword = md5($mypassword);

	$sql="SELECT * FROM $tbl_name WHERE username='$encusername' and password='$encpassword'";
	$result=mysql_query($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	// If result matched $myusername and $mypassword, table row must be 1 row

	if($count==1)
	{
		// Register $myusername, $mypassword and redirect to file "login_success.php"
		session_register("BLOG_LOGIN");
		//$_SESSION['BLOG_LOGIN'] = true; 		
		header("location:admin.php");
	}
	else 
	{
		require_once('header.php');
		echo "<p>Wrong Username or Password</p>";
		require_once('footer.php');	
	}

	ob_end_flush();
	
?>