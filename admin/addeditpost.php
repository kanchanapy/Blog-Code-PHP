<?php

if($_GET['action'] == 'editpost')
{			
	//ob_start();
	
	//require_once('db_connection.php');
	
	$tbl_name="blg_articles"; // Table name
	
	$sql="SELECT * FROM $tbl_name WHERE articleId = ". $_GET['id'] ." ORDER BY dateCreated DESC";
	$result=mysql_query($sql);
	if($result)
	{
		$row = mysql_fetch_array($result);
	
	 	$txtTitle=$row['articleTitle']; 
		$txtDescription=$row['articleDesc']; 
		$txtKeywords=$row['keywords']; 	
		$txtPageDesc=$row['pageDescription'];	
	}
	
	//ob_end_flush();
}

?>

<form action="addeditpost_submit.php?action=<?=$_GET['action']?>" method="post">
	<table style="width: 100%" border="0" cellpadding="5" align="center">
        <tr>
            <td style="width: 120px" align="right">Title:<input type="hidden" name="articleId" value="<?=$_GET['id']?>" /></td>
            <td><input name="txtTitle" type="text" maxlength="64" style="width: 90%" value="<?=$txtTitle?>"/></td>
        </tr>  
        <tr>
            <td align="right">Page Description:</td>
            <td><textarea name="txtPageDesc" rows="3" cols="20" style="width: 90%"><?=$txtPageDesc?></textarea>
            </td>
        </tr>        
        <tr>
            <td align="right">Content:</td>
            <td><textarea name="txtDescription" rows="15" cols="20" style="width: 90%"><?=$txtDescription?></textarea></td>
        </tr>
		  <tr>
            <td align="right">Keywords:</td>
            <td><textarea name="txtKeywords" rows="3" cols="20" style="width: 90%"><?=$txtKeywords?></textarea></td>
        </tr>
        <tr>
			<td>&nbsp;</td>
            <td align="left"><input type="submit" name="btnAddEdit" value="Save" />			  
			  <input type="button" name="btnCancel" value="Cancel" onclick="window.location = 'admin.php'" />
			</td>
        </tr>
    </table>
</form>
