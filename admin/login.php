<?php
	// Start the session.
    session_start ();
	
	if(session_is_registered("BLOG_LOGIN"))
	{ 
		header("location:admin.php");
	}
	
	require_once('header.php');	
?>

	<form action="checklogin.php" method="post">
			<label for="user">Username</label><br />
			<input type="text" name="username" size="50"><p />
			
			<label for="pass">Password:</label><br />
			<input type="password" name="password" size="50"><p />
			
			<input type="submit" name="submit" value="Submit" />
	</form>

<?php
	require_once('footer.php');	
?>
	