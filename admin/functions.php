<?php 
	
	function deletePost () 
	{					
		$sql="DELETE FROM blg_articles WHERE articleId = ". $_GET['id'];		
		$result=mysql_query($sql);   
	}
	
	function deleteComment ($commentId) 
	{					
		$sql="DELETE FROM blg_comments WHERE commentId = ". $commentId;		
		$result=mysql_query($sql);   
	}

?>