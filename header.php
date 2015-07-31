<?php
	
	if($_GET['id'] != '')
	{
		$sql="SELECT * FROM blg_articles WHERE permalink LIKE '". $_GET['id'] ."'";	
		$result=mysql_query($sql);	
		$row = mysql_fetch_array($result);
		
		$title = $row['articleTitle'] . " | EarthDreamz.com";
		$keywords = $row['keywords'];
		$pagedescription = $row['pageDescription'];
	}
	else
	{
		$title = "EarthDreamz.com Blog for articles on eco friendly and organic topics";
		$pagedescription = "A blog to express thoughts on green living and eco lifestyle.";
		$keywords = "Eco friendly lifestlye blog, eco friendly blog, eco friendly topics, green living blog, organic lifestlye blog,Earth Friendly blog";
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title><?=$title?></title>
<meta name="description" content="<?=$pagedescription?>">
<meta name="keywords" content="<?=$keywords?>">

<link rel="shortcut icon" href="/blog/images/favicon.ico" >
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
<link href="/blog/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
</head>
<body>
<div id="content">

	<div id="header"><a href="http://earthdreamz.com/" target="_blank"><img src="/blog/images/header.gif" alt="EarthDreamz.com" border="0"></a></div>

	<div id="maincontent">