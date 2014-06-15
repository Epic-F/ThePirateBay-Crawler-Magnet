ThePirateBay-Crawler-Magnet
===========================

The Pirate Bay Crawler (mirror magnets to own database).



This project is based on https://github.com/IcyApril/TPCrawler. I changed alot to the base project, made it more
user friendly and added Bootstrap. Gave it a Google like index page and cleaned up the scripts. 


Hope you will enjoy it!


How to install:

Upload the files to your directory and edit config.php located in the "app" folder.

<?php
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

?>
