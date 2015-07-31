<?php		
	
	//require_once('functions.php');	
	ob_start();
	require_once('admin/db_connection.php');	
	require_once('header.php');	
?>
<?php
	if($_GET['id'] != '')
	{
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
<?php } ?>
	<table>
		<tr valign="top">
		<td class="mainleft">	
<?php
	if($_GET['id'] != '')
	{
		$sql="SELECT * FROM blg_articles WHERE permalink LIKE '". $_GET['id'] ."'";
	}
	else if($_GET['month'] != '')
	{
		$sql="SELECT * FROM blg_articles WHERE yearPosted = ". $_GET['year'] ." and monthPosted = ". $_GET['month'] ." ORDER BY datePublished DESC";
	}
	else if($_GET['year'] != '')
	{
		$sql="SELECT * FROM blg_articles WHERE yearPosted = ". $_GET['year'] ." ORDER BY datePublished DESC";
	}
	else
	{
		$sql="SELECT * FROM blg_articles WHERE isPublished = 1 ORDER BY datePublished DESC LIMIT 5";
	}
	$result=mysql_query($sql);
	
	while ($row = mysql_fetch_array($result))
	{
		$articleId = $row['articleId'];
		if($_GET['id'] == '')
		{
			$articleTitle = "<a href=\"/blog/". $row['permalink'] . ".html\">". $row['articleTitle'] ."</a>";
		}
		else
		{
			$articleTitle = $row['articleTitle'];		
		}
?>	
			<div class="titledate"><?=date('l, j F Y', strtotime($row['datePublished']))?></div>
			<div class="posttitle"><h1><?=$articleTitle?></h1></div>
			<div class="postcontent"><?=$row['articleDesc']?></div>
<?php 	if($_GET['id'] == '')
		{
?>
			<div class="commentMain"><a href="/blog/<?=$row['permalink']?>.html">Comments</a></div>
<?php
		}
?>
			<div class="drawline">&nbsp;</div>

<?php		
		if($_GET['id'] != '')
		{
			$sql2="SELECT * FROM blg_comments WHERE articleId = $articleId ORDER BY dateCreated";	
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
			
			

<?php
			
		}
	}
?>
		</td>
		<td class="mainright"> 
			<div class="titletop">BLOG ARCHIVE</div>
<?php	
	$sql="SELECT yearPosted, count(*) AS cntYear FROM blg_articles WHERE isPublished = 1 GROUP BY yearPosted ORDER BY yearPosted DESC";
	$result=mysql_query($sql);	
	while ($row = mysql_fetch_array($result))
	{		
		echo "<p class=\"level1\"><a href=\"/blog/year/". $row['yearPosted'] .".html\">". $row['yearPosted'] ."</a> (". $row['cntYear'] .")</p>";
		$sql2 = "SELECT monthPosted, count(*) AS cntMonth FROM blg_articles WHERE isPublished = 1 and yearPosted = ". $row['yearPosted'] ." GROUP BY monthPosted ORDER BY monthPosted DESC";
		$result2 = mysql_query($sql2);	
		while ($row2 = mysql_fetch_array($result2))
		{
			$month_name = date( 'F', mktime(0, 0, 0, $row2['monthPosted']) );

			echo "<p class=\"level2\"><a href=\"/blog/year/". $row['yearPosted'] ."/". $row2['monthPosted'] .".html\">". $month_name ."</a> (". $row2['cntMonth'] .")</p>";
			
			$sql3 = "SELECT articleId, articleTitle, permalink FROM blg_articles WHERE isPublished = 1 and yearPosted = ". $row['yearPosted'] ."  and monthPosted = ". $row2['monthPosted'] ." ORDER BY datePublished DESC";
			
			$result3 = mysql_query($sql3);	
			while ($row3 = mysql_fetch_array($result3))
			{
				echo "<p class=\"level3\"><a href=\"/blog/". $row3['permalink'] .".html\">". $row3['articleTitle'] ."</a></p>";
			}
		}
	}
?>	
						
		</td>
	</tr>
	</table>

<?php
	require_once('footer.php');	
	ob_end_flush();	
?>