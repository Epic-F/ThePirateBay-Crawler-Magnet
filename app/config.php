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
 * 	based on https://github.com/IcyApril/TPCrawler
 * 
 */

// database config
$db_host			= 'localhost';		// In most cases you should leave this alone.
$db_user			= 'database_username';		// MySQL username.
$db_pass			= 'password';		// MySQL password.
$db_database		= 'database';		// MySQL database name.
// site config
$site_title			= 'Gitcloud - The Pirate Bay magnet mirror';
$site_name			= 'Gitcloud';
$index_image		= 'static/img/face.png';
$meta_keywords		= 'TPB, ThePirateBay, Magnet, mirror, Crawler, search, opensource';
$meta_description	= 'A mirror of ThePiratebay (magnet)';

// don't touch, if you don't know what they do
$search				= isset($_REQUEST['s']) ? $_REQUEST['s'] : '' ;
$search_result		= isset($_REQUEST['s']) ? $_REQUEST['s'] : 'What are you looking for?' ;
$page_number		= isset($_REQUEST['pages']) ? $_REQUEST['pages'] : '' ;


// database 
$link = mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');
mysql_select_db($db_database,$link);
mysql_query("SET NAMES UTF8");/* Database config */
$sql = "CREATE TABLE IF NOT EXISTS `magnets` (\n"
    . " `id` int(11) NOT NULL AUTO_INCREMENT,\n"
    . " `url` varchar(1000) NOT NULL,\n"
    . " `magnet` varchar(2555) NOT NULL,\n"
    . " `description` text NOT NULL,\n"
    . " PRIMARY KEY (`id`),\n"
    . " UNIQUE KEY `url` (`url`)\n"
    . ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
    mysql_query($sql);


?>
