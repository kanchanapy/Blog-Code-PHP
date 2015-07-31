<?php
 session_start();
 if(!session_is_registered("BLOG_LOGIN"))
 { 
	header("location:login.php");
 }
 ?>
 
 <?php		
	require_once('header.php');	
	require_once('functions.php');	
	
	ob_start();
	require_once('db_connection.php');
	
	if($_GET['action'] == 'delete')
	{
		deleteComment($_GET['commentid']);		
		//header("location:admin.php");
	}	
	
?>
	<table style="width:100%;">
		<tr valign="top">
		<td class="mainleft">

	<div align="center"><h1>Admin area - View Comments</h1></div>
	<table style="width: 100%" border="0" cellpadding="5" align="center">
        <tr>
            <td style="width: 20%"><b>Comment By</b></td>
            <td style="width: 50%" align="center"><b>Text</b></td>
			<td style="width: 20%" align="center"><b>Created</b></td>			
			<td align="center"><b>Actions</b></td>
        </tr>
<?php 		
		$sql="SELECT * FROM blg_comments WHERE articleId = ". $_GET['id'] ." ORDER BY dateCreated DESC";
		$result=mysql_query($sql);
		
		while ($row = mysql_fetch_array($result))
		{			
?>	
		<tr>
            <td><?=$row['name']?></td>
			<td><?=$row['commentText']?></td>
            <td align="center"><?=date('m-d-Y H:i', strtotime($row['dateCreated']))?></td>			
			<td align="center"><a href="managecomments.php?action=delete&commentid=<?=$row['commentId']?>&id=<?=$_GET['id']?>" onclick="javascript:return confirm('Are you sure you want to delete this comment?')">Delete</a></td>
        </tr> 
<?php	
		}
?>
	</table>
<?php		
	
?>			
		</td>
		<td class="mainright" style="width: 200px;"> 
			<div class="titletop">ACTIONS</div>
			<p class="level1"><a href="admin.php?action=newpost">New Post</a></p>
			<p class="level1"><a href="admin.php">Manage Posts</a></p>
			<p class="level1"><a href="logout.php">Logout</a></p>			
		</td>
	</tr>
	</table>	

<?php
	ob_end_flush();
	require_once('footer.php');	
?>
