<?php
/**
 * index.php the index of the news aggregation feature
 *
 * based on demo_shared.php Bill Newman <williamnewman@gmail.com>
 *
 * @author Israel Santiago, Milo Sherman and Jaykel Torres
 * @version 1.0 2016/02/23
 * @link http://neoazareth.com/wn16/news/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php  
 * @see header_inc.php
 * @see footer_inc.php
 * @see News.php
 * @see Feed.php
 * @todo none
 */
# '../' works for a sub-folder.  use './' for the root

require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
require 'News.php';
require_once 'Feed.php';


$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<!--Title of the page and javascript by Milo-->
<h3 align="center">News</h3>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
$(document).ready(function () {
	
	$('#toggle-view li').click(function () {

		var text = $(this).children('div.panel');

		if (text.is(':hidden')) {
			text.slideDown('200');
			$(this).children('span').html('-');		
		} else {
			text.slideUp('200');
			$(this).children('span').html('+');		
		}
		
	});

});
</script>

<?php
//instatiates a News object
$myNews = new News();

//calls the getNewsNav method to disply news nav
$myNews->getNewsNav(0);

//calls the getNewsFeed method to display the feed view
$myNews->getNewsFeed(0);
?>
