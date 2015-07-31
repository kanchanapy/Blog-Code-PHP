<?php		
function transcribe_cp1252_to_latin1($cp1252) {
   return strtr(
     $cp1252,
     array(
       "\x80" => "e",  "\x81" => " ",    "\x82" => "'", "\x83" => 'f',
       "\x84" => '"',  "\x85" => "...",  "\x86" => "+", "\x87" => "#",
       "\x88" => "^",  "\x89" => "0/00", "\x8A" => "S", "\x8B" => "<",
       "\x8C" => "OE", "\x8D" => " ",    "\x8E" => "Z", "\x8F" => " ",
       "\x90" => " ",  "\x91" => "`",    "\x92" => "'", "\x93" => '"',
       "\x94" => '"',  "\x95" => "*",    "\x96" => "-", "\x97" => "--",
       "\x98" => "~",  "\x99" => "(TM)", "\x9A" => "s", "\x9B" => ">",
       "\x9C" => "oe", "\x9D" => " ",    "\x9E" => "z", "\x9F" => "Y")); 
}
	   
ob_start();
require_once('admin/db_connection.php');	
$fileName = "rss.xml";
$fileHandle = fopen($fileName, 'w') or die("can't open file");

$stringData = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n" . "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
	xmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"
	xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
	xmlns:atom=\"http://www.w3.org/2005/Atom\"
	xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
	xmlns:slash=\"http://purl.org/rss/1.0/modules/slash/\">\n" . "<channel>\n";
fwrite($fileHandle, $stringData);
$stringData = "\t<title>Modern Style Organic Living Blog</title>\n".
			  "\t<atom:link href=\"http://earthdreamz.com/blog/rss.xml\" rel=\"self\" type=\"application/rss+xml\" />\n".
		  	  "\t<link>http://earthdreamz.com/blog/</link>\n".
			  "\t<description>A blog to express thoughts on green living and eco lifestyle.</description>\n".
			  "\t<language>en-us</language>\n".
			  "\t<pubDate>". gmdate('D, d M Y H:i:s') ." GMT</pubDate>\n".
			  "\t<copyright>earthdreamz.com</copyright>\n\n";
fwrite($fileHandle, $stringData);

$sql="SELECT * FROM blg_articles WHERE isPublished = 1 ORDER BY datePublished DESC LIMIT 10";	
$result=mysql_query($sql);
while ($row = mysql_fetch_array($result))
{
 
$stringData = "\t<item>\n".
			  "\t\t<title>". $row['articleTitle'] ."</title>\n".
			  "\t\t<link>http://earthdreamz.com/blog/". $row['permalink'] .".html</link>\n".
			  "\t\t<guid>http://earthdreamz.com/blog/". $row['articleId'] ."</guid>\n".
			  "\t\t<pubDate>". gmdate('D, d M Y H:i:s', strtotime($row['datePublished'])) ." GMT</pubDate>\n".
			  "\t\t<description>". $row['pageDescription'] ."</description>\n".
			  "\t\t<content:encoded><![CDATA[". transcribe_cp1252_to_latin1($row['articleDesc']) ."]]></content:encoded>\n".   
			  "\t</item>\n\n";
			  
fwrite($fileHandle, $stringData);

}

$stringData = "</channel>\n</rss>\n";
fwrite($fileHandle, $stringData);

fclose($fileHandle);

ob_end_flush();
	
?>