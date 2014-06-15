<?php
/*
 *			browse.php
 *            .---._------------------------------+
 *___________/ ._____)                            |
 *              ) __|         created by          |
 *                __|      Fadi Abdalkhalk        |
 *..---------.._____|                             |
 *                  +-----------------------------+
 *
 *	copyright 2014 - Gitcloud
 *	created on 13-06-2014
 *	email: fadiabdalkhalk@gmail.com
 * 	based on https://github.com/IcyApril/TPCrawler
 * 
 */ 


// error reporting.
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// this will re-run the crawler.php script everytime the page is loaded. 
// keep track of this, it will use alot of your resources (CPU & RAM).
exec ("/usr/bin/php app/crawler.php >/dev/null &");

// include the config file. 
include_once('app/config.php');

function trunc($phrase, $max_words) {
   $phrase_array = explode(' ',$phrase);
   if(count($phrase_array) > $max_words && $max_words > 0) $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'&hellip;';
   return $phrase;
}


// starts the render time of the page.
// exported to HTML/PHP in the footer. 
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="<?php echo $meta_keywords; ?>"/>
	<meta name="description" content="<?php echo $meta_description; ?>">
	<title><?php echo $site_title; ?></title>
	<!-- bootstrap -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<!- custom CSS, overwrite classes in bootstrap -->
	<link rel="stylesheet" href="static/css/style_search.css">
	<!-- JS files -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="static/js/script.js"></script>
</head>
<?php
$search = htmlspecialchars(mysql_escape_string(($_GET['s'])));
$id = htmlspecialchars(mysql_escape_string(($_GET['id'])));
$page = htmlspecialchars(mysql_escape_string(($_GET['pages'])));

if ($page) {
$realpage = $page-1;
$lowerbound = $realpage*50;
$upperbound = $lowerbound+150;
$nextpage = $page+1;
} else {
$page = 1;
$realpage = 0;
$lowerbound = 0;
$upperbound = 50;
$nextpage = $page+1;
}

if ($id) {
$trunc = FALSE;
$quey1="SELECT * FROM magnets WHERE id='$id'"; } 
else if ($search) {
$trunc = TRUE;
$quey1="SELECT * FROM magnets WHERE url LIKE '%$search%' OR description LIKE '%$search%' OR magnet LIKE '%$search%' LIMIT 0, 50"; 
} else {
$trunc = TRUE;
$quey1="SELECT * FROM magnets WHERE id BETWEEN $lowerbound AND $upperbound";
}

$pg1="SELECT COUNT(id) FROM magnets";
$pgresult=mysql_query($pg1) or die(mysql_error());
while($row=mysql_fetch_array($pgresult)){
$totpages = intval($row['COUNT(id)']/100+1);
}

if (($page > $totpages) || ($page < 1)) {
die('<p>No more pages. :(</p>'); }

$result=mysql_query($quey1) or die(mysql_error());
?>
<body>

<div class="menu">
	<h1 class="logo"><?php echo $site_name; ?></h1>
		<form name="s" action="browse.php" method="get" class="navbar-form navbar-left" role="search">
			<div class="form-group">
			<input type="text" name="s" class="form-control" placeholder="<?php echo $search_result; ?> ">
			</div>
	  <button type="submit" class="btn btn-default">Submit</button>
	</form>
</div>
<div class="container">
	<div class="header">
			<p class="header_left"><a href="browse.php">Browse magnets</a></p>
			<p class="header_right"><?php if (!($id || $search)) {?> You are at page: <?=$page?> of <?=$totpages?> </a> <?php } ?></p>
		<div style="clear: both;"></div>
	</div>
<div class="content"
	<div class="table-responsive">
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
				<th>Source URL</th>
				<th>Magnet URL</th>
				<th>Description</th>
				<th>More Info</th>
			</tr>
		</thead>
	<tbody>
<?php
while($row=mysql_fetch_array($result)){
echo "<td>";
echo '<a href="'.$row['url'].'">Source</a>';
echo "</td><td>";
echo '<a href="'.$row['magnet'].'">Magnet</a>';
echo "</td><td>";
if ($trunc == TRUE) {
echo trunc($row['description'],10);
} else {
echo nl2br($row['description']);
}
echo "</td><td>";
echo '<a href="browse.php?id='.$row['id'].'">Info</a>';
echo "</td></tr>";
}
echo "</table>";
?>
</div>
<div class="footer_left">
<div class="page-search">
	<form name="pages" action="browse.php" method="get" class="form-inline" role="form">
		<div class="input-group input-group-sm">
			<span class="input-group-addon">Go to</span>
			<input name="pages" type="text" class="form-control" placeholder="page">
		</div>
	</form>
</div>
</div>
<div class="footer_right">
<?php if (!($id || $search)) {?>
You are at page: <?=$page?> of <?=$totpages?> <a href='browse.php?pages=<?=$nextpage?>'>Page: <?=$nextpage?></a> 
<?php } ?>
</div>
<div style="clear: both;"></div>
<hr />
<div class="footer_left">
<p>Download at <a href="https://github.com/GitcloudNL/ThePirateBay-Crawler-Magnet">Github</a> (Open Source).</p> </div>
<div class="footer_right">
<?php
// end of render time.
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';
?>
</div>
<div style="clear: both;"></div>
</body>
</html>
