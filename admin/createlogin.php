<?php
	//Delete this file after creating username/password
	//To change username/password, modify this file and upload and run and then delete after use	
	
	ob_start();
	$host="localhost"; // Host name 
	$username=""; // Mysql username 
	$password=""; // Mysql password 
	$db_name=""; // Database name 
	$tbl_name="blg_login"; // Table name

	// Connect to server and select databse.
	mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	 // Define $myusername and $mypassword 
	$myusername=""; 
	$mypassword="";

	$encusername = md5($myusername);
	$encpassword = md5($mypassword);

	$sql="INSERT INTO $tbl_name VALUES ('$encusername','$encpassword')";
	mysql_query($sql);	
	
	echo "Success: $encusername, $encpassword";
	
	ob_end_flush();
?>