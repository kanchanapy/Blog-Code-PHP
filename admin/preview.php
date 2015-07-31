<?php		
session_start();
if(!session_is_registered("BLOG_LOGIN"))
{ 
	header("location:login.php");
}
 
	//require_once('functions.php');	
	ob_start();
	require_once('db_connection.php');	
	require_once('header.php');	
?>
	<table>
		<tr valign="top">
		<td class="mainleft">	
<?php
if($_GET['id'] != '')
{
	$sql="SELECT * FROM blg_articles WHERE articleId=". $_GET['id'];
	
	$result=mysql_query($sql);
	
	$row = mysql_fetch_array($result);
		
		
?>	
			<div class="titledate"><?=date('l, j F Y', strtotime($row['datePublished']))?></div>
			<div class="posttitle"><h1><?=$row['articleTitle']?></h1></div>
			<div class="postcontent"><?=$row['articleDesc']?></div>
			
	
						
			
			<script type="text/javascript">
				function checkCommentForm() {
					if(document.getElementById("txtComment").value == "")
					{
						document.getElementById("msgErrors").innerHTML = "Please enter something";
						return false;
					}
					
					if(document.getElementById("txtCommentName").value == "")
					{
						document.getElementById("msgErrors").innerHTML = "Please enter name";
						return false;
					}					
					return true;						
				}	

				function limitText(limitField, limitCount, limitNum) {
					if (limitField.value.length > limitNum) {
						limitField.value = limitField.value.substring(0, limitNum);
					} else {
						limitCount.value = limitNum - limitField.value.length;
					}
				}

			</script>
<?php

$errMsg  = "";

if($_POST['articleId'] != '') 
{	
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
	}
}	

?>

	<?php 
	$sql2="SELECT * FROM blg_comments WHERE articleId=". $_GET['id'];	
	$result2=mysql_query($sql2);
	while ($row2 = mysql_fetch_array($result2))
	{
		$linefeed = array("\n");	
		$commentText = str_replace($linefeed, "<br />", $row2['commentText']);		
?>		
			<div class="comments">
				<div class="commentTitle"><b><?=$row2['name']?></b> July 16 2012 14:57</div>
				<div><?=$commentText?></div>			
			</div>
			
<?php 
	}
?>	
			
			<form method="post">
			<div class="postcomment">
				<h3>Post a Comment</h3>
				<div id="msgErrors" style="color: #f00;"><?php if($errMsg!='') echo $errMsg; ?></div>
				<div><textarea id="txtComment" name="txtComment" rows="6" cols="60" onKeyDown="limitText(this.form.txtComment,this.form.countdown,1000);" onKeyUp="limitText(this.form.txtComment,this.form.countdown,1000);"><?php if($errMsg!='') echo $txtComment; ?></textarea><br/>
				<!--<font size="1">(Maximum characters: 1000)<br>-->You have <input readonly type="text" name="countdown" size="3" value="<?php if($errMsg!='') echo (1000 - strlen($txtComment)); else echo "1000"?>"> characters left.</font>
				</div>				
			    <p>Comment as: <input id="txtCommentName" name="txtCommentName" type="text" maxlength="200" style="width: 200px" value="<?php if($errMsg!='') echo $txtCommentName; ?>" />				
				<input type="hidden" name="articleId" value="<?=$_GET['id']?>" /></p>
				
				<p><input type="submit" name="btnComment" value="Publish" onclick="return checkCommentForm();"/></p>
			</div>
			</form>
			
			
			
<?php
}
?>
		</td>
		<td class="mainright"> 
			<div class="titletop">BLOG ARCHIVE</div>

						
		</td>
	</tr>
	</table>

<?php
	require_once('footer.php');	
	ob_end_flush();	
?>