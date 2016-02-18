<?php
/**
 * index.php a list page of surveys
 *
 * based on demo_shared.php
 *
 * demo_idb.php is both a test page for your IDB shared mysqli connection, and a starting point for 
 * building DB applications using IDB connections
 *
 * @package nmCommon
 * @author Bill Newman <williamnewman@gmail.com>
 * @version 2.09 2011/05/09
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php  
 * @see header_inc.php
 * @see footer_inc.php 
 * @todo none
 */
# '../' works for a sub-folder.  use './' for the root

require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

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

# SQL statement - PREFIX is optional way to distinguish your app


//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
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
<div id="sidebar-left">
    <h3 class="sidebar-left-header">Categories</h3>
    <ul id="toggle-view">
    <li>
        <h5>Sports</h5>
        <span>&#43;</span>
        <div class="panel">
            <p><strong><a href="#">One</a></strong></p>
            <p><strong><a href="#">Two</a></strong></p>
            <p><strong><a href="#">Three</a></strong></p>
        </div>
    </li>
    <li>
        <h5>Technology</h5>
        <span>&#43;</span>
        <div class="panel">
            <p><strong><a href="#">One</a></strong></p>
            <p><strong><a href="#">Two</a></strong></p>
            <p><strong><a href="#">Three</a></strong></p>
        </div>
    </li>
    <li>
        <h5>Politics</h5>
        <span>&#43;</span>
        <div class="panel">
            <p><strong><a href="#">One</a></strong></p>
            <p><strong><a href="#">Two</a></strong></p>
            <p><strong><a href="#">Three</a></strong></p>
        </div>
    </li>
</ul>
</div>
<div id="sidebar-right">
<?php
//read-feed.php
//our simplest example of consuming an RSS feed

  $request = "https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&output=rss";
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
  foreach($xml->channel->item as $story)
  {
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
  }
?>
<?php
get_footer(); #defaults to footer_inc.php
?>
</div>