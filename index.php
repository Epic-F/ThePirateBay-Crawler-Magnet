<?php 
/*
 *			config.php
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
 * 	based on a original design
 * 
 */

// include the config file.
include('app/config.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="keywords" content="<?php echo $meta_keywords; ?>"/>
	<meta name="description" content="<?php echo $meta_description; ?>">
	<title><?php echo $site_title; ?></title>
	<link rel="stylesheet prefetch" href="http://netdna.bootstrapcdn.com/font-awesome/2.0/css/font-awesome.css">
	<link rel="stylesheet" href="static/css/style_front.css">
</head>
<body>
<div class="menu">
  <ul>
    <li><a href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>">Gitcloud</a></li>
	<li><a href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>browse.php">Browse</a></li>
  </ul>
</div>
<img class="profile" src="<?php echo $index_image; ?>" width="84" height="80" />
<h1 class="logo">Gitcloud</h1>
<div class="link_front">
<strong>Search magnets</strong> | 
<a href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>browse.php">browse magnets</a>
</div>
<form name="s" action="browse.php" method="get">
	<div class='search'>
		<input type="text" name="s" />
		<button>
			<i class="icon-search">
		</i></button>
		<div class="copyright">Download at <a href="https://github.com/GitcloudNL/ThePirateBay-Crawler-Magnet">Github</a> (Open Source).</div>
	</div>
</form>
<!-- JS Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="static/js/script.js"></script>
<!-- JS Scripts -->
</body>
</html>