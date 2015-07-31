<?php		
 
	//require_once('functions.php');	
	ob_start();
	require_once('admin/db_connection.php');	
	require_once('header.php');	
?>
<script type="text/javascript">
	$(document).ready(function(){

		$("#myForm").submit(function(){

			$.ajax({
				type: "POST",
				url: "postcomment.php",
				data: $("#myForm").serialize(),
				dataType: "json",

				success: function(msg){					
					//$("#formResponse").addClass(msg.status);
					if(msg.status == "error")
						$("#formResponse").html(msg.message);
					else
					{
						$("#formResponse").html("");	
						strComment = $("#txtComment").val();
						strComment = strComment.replace(/\n\r?/g, '<br />');					
						strAppend = "<div class=\"comments\"><div class=\"commentTitle\"><b>" + $("#txtCommentName").val() + "</b> " 
									+ msg.dateCreated + "</div>";
						strAppend += "<div>" + strComment + "</div></div>";						
						$('#expandable').append(strAppend);
						
						document.getElementById("txtCommentName").value = "";
						document.getElementById("txtComment").value = "";
					}

				},
				error: function(){					
					$("#formResponse").html("<p>There was an error submitting the form. Please try again.</p>");
				}
			});

			//make sure the form doesn't post
			return false;

		});

	});	
	
	function limitText(limitField, limitCount, limitNum) {
		if (limitField.value.length > limitNum) {
			limitField.value = limitField.value.substring(0, limitNum);
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	}
</script>
	
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

	<?php 
	$sql2="SELECT * FROM blg_comments WHERE articleId=". $_GET['id'] ." ORDER BY dateCreated";	
	$result2=mysql_query($sql2);
	while ($row2 = mysql_fetch_array($result2))
	{
		$linefeed = array("\n");	
		$commentText = str_replace($linefeed, "<br />", $row2['commentText']);		
?>		
			<div class="comments">
				<div class="commentTitle"><b><?=$row2['name']?></b> <?=date('F j Y H:i', strtotime($row2['dateCreated']))?></div>
				<div><?=$commentText?></div>			
			</div>
			
<?php 
	}
?>	
			<div id="expandable"></div>
			
			<form method="post"  id="myForm" action="postcomment.php">
			 
			<div class="postcomment">
				<h3>Post a Comment</h3>
				<div id="formResponse" style="color: #f00;"></div>
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