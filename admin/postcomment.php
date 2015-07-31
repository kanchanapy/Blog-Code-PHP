<?php

	session_start();
	if(!session_is_registered("BLOG_LOGIN"))
	{ 
		header("location:login.php");
	}	
	
	$errMsg  = "";
	
	if(empty($_POST['txtCommentName']))
	{ 
		$errMsg = "<p>Please enter name</p>";				
	}
	elseif(empty($_POST['txtComment']))
	{
		$errMsg = "<p>Please enter something</p>";
	}
		
	if($errMsg != "")
	{
		$response_array['status'] = 'error';  
		$response_array['message'] = $errMsg;
	}
	else
	{	
		if($_POST['articleId'] != '') 
		{	
			ob_start();	
			require_once('db_connection.php');
			
			$articleId = $_POST['articleId'];
			
			$txtCommentName = $_POST['txtCommentName']; 
			$txtComment = $_POST['txtComment']; 
				
			// To protect MySQL injection (more detail about MySQL injection)
			$txtCommentName = stripslashes($txtCommentName);
			$txtComment = stripslashes($txtComment);
				
			$txtCommentName = mysql_real_escape_string($txtCommentName);
			$txtComment = mysql_real_escape_string($txtComment);
			
			//$linefeed = array("\n", "\r");	
			//$txtComment = str_replace($linefeed, "<br />", $txtComment);
					
			$sql="INSERT INTO blg_comments (articleId, name, commentText, dateCreated) VALUES ('$articleId', '$txtCommentName', '$txtComment', NOW())";		
				
			$count=mysql_query($sql);

			if(!($count==1))
			{		
				$errMsg = "<p>Something went wrong, please try again. If the problem persists, please contact the website administrator.</p>";
				$response_array['status'] = 'error';  
				$response_array['message'] = $errMsg;
			}
			else
			{				
				$response_array['status'] = 'success';  
				$response_array['message'] = 'success';
				$response_array['dateCreated'] = date('F j Y H:i');  
			}			
			ob_end_flush();
		}	
	}
	
	echo json_encode($response_array); 
	
?>