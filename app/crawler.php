<?php
ignore_user_abort(true);
set_time_limit(0);
$bannedurls = array('/','/login','/language','/about','/legal','/blog','/contact','/policy','/downloads','/promo','/doodles','/rss','/register','/browse','/tv','/music','/top','/switchview.php?view=s');
$vistedurls = array();

include_once('config.php');

$query = "SELECT url FROM magnets WHERE 1"; 
	 
$result = mysql_query($query) or die(mysql_error());
$visitedurls = array();
while($row = mysql_fetch_array($result)){
	array_push($visitedurls,$row['url']);
}

function get_magnets($url)

{
	$html = file_get_contents($url);
	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	// grab all the on the page
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");

		for ($i = 0; $i < $hrefs->length; $i++) {
	       $href = $hrefs->item($i);
    	   $url = $href->getAttribute('href');
    	   if (substr($url, 0, 7) === 'magnet:') {
    	   return $url;}
	}


}

function get_pre($url)

{
	$html = file_get_contents($url);

 // a new dom object 
 $dom = new domDocument('1.0', 'utf-8'); 
 // load the html into the object ***/ 
 @$dom->loadHTML($html); 
 //discard white space 
 $dom->preserveWhiteSpace = false; 
 $pre = $dom->getElementsByTagName('pre'); //Get elements by desired tag.
 return htmlspecialchars($pre->item(0)->nodeValue); 

}

function get_next_url($url, $bannedurls,$visitedurls)

{


	$nexturls = array();
	$html = file_get_contents($url);
	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	// grab all the on the page
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");

		for ($i = 0; $i < $hrefs->length; $i++) {
	       $href = $hrefs->item($i);
    	   $url = $href->getAttribute('href');
    	   if (substr($url, 0, 1) === '/') {
    	   if (!in_array($url, $bannedurls)) {
    	   array_push($nexturls, $url);
    	   
    	   
    	   } }
	}
	
	array_unique($nexturls);
	$newnexturls = array();
foreach ($nexturls as &$value) {
    if(strstr($value,'/torrent/')) 
	{ 
	array_push($newnexturls,$value);
	}

}
if($newnexturls) {
$nexturls = array_merge($newnexturls,$nexturls);
}

shuffle($nexturls); // Mix it up a bit. ;-)
return($nexturls);

}

$url = "https://thepiratebay.se/top/48hall";

while (true) {

	if (!in_array($url,$visitedurls)) {
	
	if (substr($url, 0, 31) === 'https://thepiratebay.se/torrent') {
	$pre = mysql_real_escape_string(strip_tags(get_pre($url)));
	$magnet = get_magnets($url);
	$url2 = mysql_real_escape_string(strip_tags($url));
	mysql_query("INSERT IGNORE INTO magnets SET url='".$url2."', magnet='".$magnet."', description='".$pre."'") or die(mysql_error());
	
	}}
	$nexturls = get_next_url($url, $bannedurls, $visitedurls);
	$nexturl = $nexturls[0];

$arraycount = 0;
while (in_array($nexturls[$arraycount],$visitedurls)) {
$url = $nexturls[$arraycount];
$arraycount++;
}
$url = 'https://thepiratebay.se'.$nexturl;
}

header('Location: crawler.php');
die('<meta http-equiv="refresh" content="0; url=crawler.php" />\n');


?>
