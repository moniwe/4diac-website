<?php
	header("Content-Type: application/rss+xml; charset=ISO-8859-1");

#small script to turn our news items into an rss feed to be included in blog agregators and news readers	
	
	function createDescription($lines, $greetings){
		$content = '<![CDATA[';
		for ($x = 1; $x < count($lines); $x++) {
			if (strpos($lines[$x], 'greeting.html') != false){
			    $content .= $greetings;
			}else{
		  		$content .= $lines[$x];
			}
		}
		return $content . ']]>';
	}
	
	function getNewsHeadline($line){
	    $headline = explode('__FILE__, "', $line)[1]; //get the start of the headline
	    return explode('"', $headline)[0];               //strip everything after the ending "
	}
	
$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>Eclipse 4diac News RSS feed</title>';
$rssfeed .= '<link>http://www.fordiac.org</link>';
$rssfeed .= '<description>This is the RSS feed for the 4diac news</description>';
$rssfeed .= '<language>en-us</language>';
#$rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';

$greetings =  file_get_contents('../news/greeting.html'); 

$folder = glob('../news/*.php');
foreach(array_reverse($folder) as $file){
	$lines = file($file);
	$rssfeed .= '<item>';
	$rssfeed .= '<title>' . getNewsHeadline($lines[0]) . '</title>';
	$rssfeed .= '<description>' . createDescription($lines, $greetings) . '</description>';
	$rssfeed .= '<link> https://www.eclipse.org/4diac/en_news.php#' . basename($file,".php") . '</link>';
	$rssfeed .= '<pubDate>' . date ("D, d M Y H:i:s T", filectime($file)) . '</pubDate>';
	$rssfeed .= '</item>';
}

$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;
?>