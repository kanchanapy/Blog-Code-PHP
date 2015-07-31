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
	
?>
	<table style="width:100%;">
		<tr valign="top">
		<td class="mainleft">
<?php 
	if($_GET['action'] == 'newpost')
	{
		require_once('addeditpost.php');
	}
	else if($_GET['action'] == 'editpost')
	{
		require_once('addeditpost.php');
	}	
	else
	{		
		if($_GET['action'] == 'deletepost')
		{
			deletePost();		
			//header("location:admin.php");
		}			
	
?>	
	<div align="center"><h1>Welcome to the admin area</h1></div>
	<table style="width: 100%" border="0" cellpadding="5" align="center">
        <tr>
            <td style="width: 40%"><b>Title</b></td>
            <td style="width: 15%" align="center"><b>Date Created</b></td>			
			<td align="center"><b>Actions</b></td>
        </tr>
<?php 		
		$sql="SELECT * FROM blg_articles ORDER BY dateCreated DESC";
		$result=mysql_query($sql);
		
		while ($row = mysql_fetch_array($result))
		{			
?>	
		<tr>
            <td><?=$row['articleTitle']?></td>
            <td align="center"><?=date('m-d-Y', strtotime($row['dateCreated']))?></td>			
			<td align="center"><a href="admin.php?action=editpost&id=<?=$row['articleId']?>">Edit</a> | 
<?php 	
		if($row['isPublished'] == 0)
		{
			echo "<a href=\"publish.php?action=publish&id=".$row['articleId']."\">Publish</a>";
		} 	
		else
		{
			echo "<a href=\"publish.php?action=unpublish&id=".$row['articleId']."\">Unpublish</a>";
		}
?>
				| <a href="preview.php?id=<?=$row['articleId']?>" target="_blank">Preview</a>
				| <a href="admin.php?action=deletepost&id=<?=$row['articleId']?>" onclick="javascript:return confirm('Are you sure you want to delete this post?')">Delete</a> | <a href="managecomments.php?id=<?=$row['articleId']?>">Comments</a>
			</td>
        </tr> 
<?php	
		}
?>
	</table>
<?php		
	} 
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
