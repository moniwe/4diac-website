<?php
	header("Content-Type: application/rss+xml; charset=ISO-8859-1");

#small script to turn our news items into an rss feed to be included in blog agregators and news readers	

	$greetings =  file_get_contents('../news/greeting.html');  #buffer the content of the greatings
	
	
	function createDescription($lines){
		$content = '<![CDATA[';
		for ($x = 8; $x <= count($lines); $x++) {
			if (strpos($lines[$x], 'greeting.html') != false){
				$content .=  $grettings;
			}else{
		  		$content .= $lines[$x];
			}
		}
		$content .= ']]>';
		return $content;
	}

$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>Eclipse 4diac News RSS feed</title>';
$rssfeed .= '<link>http://www.fordiac.org</link>';
$rssfeed .= '<description>This is the RSS feed for the 4diac news</description>';
$rssfeed .= '<language>en-us</language>';
#$rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';


$folder = glob('../news/*.php');
foreach(array_reverse($folder) as $file){
	$lines = file($file);
	$rssfeed .= '<item>';
	$rssfeed .= '<title>' . strip_tags($lines[1]) . '</title>';
	$rssfeed .= '<description>' . createDescription($lines) . '</description>';
	$rssfeed .= '<link> http://www.eclipse.org/4diac/en_news.php#' . basename($file,".php") . '</link>';
	$rssfeed .= '<pubDate>' . date ("F d Y H:i:s", filemtime($file)) . '</pubDate>';
	$rssfeed .= '</item>';
}

$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;
?>