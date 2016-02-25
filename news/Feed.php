<?php
/**
 *Feed.php a class that handles feed objects 
 * 
 *This class creates feed objects based on one parameter $id
 *which is passed at instatiation and then use by the constructor
 *to pull data from a db and assing other properties to the object.
 * 
 * @author Israel Santiago, Milo Sherman and Jaykel Torres
 * @version 1.0 2016/02/23
 * @link http://neoazareth.com/wn16/news/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see News.php
 * @see Feed.php
 * @todo none
 */


class Feed
{
    //instance variables
    public $id = 0;
    public $feedName = '';
    public $feedXml = '';
    public $timeCreated = 0;
    
    /**
     * Multiple php constructor, if no parameters are passed it creates a
     * default view of the top stories news page
     */
    public function __construct()
    {
    	//gets the arguments passed an stores them in the $a variable
        $a = func_get_args();
        
        //counts the arguments passed an stores the number in the $i variable
        //very important to name the other constructor with the number of
        //arguments they take
        $i = func_num_args();
       	
       	//calls the appropiate constructor based on the number of arguments
        if (method_exists($this,$f='__construct'.$i)) {
            call_user_func_array(array($this,$f),$a);
        }
        else
        {//if no arguments are passed it creates a top stories view
            $this->feedName = 'Top Stories';
            //pulls the feed from google's server and assigns it to the feedXml property
            $request = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&output=rss';
            $this->feedXml = file_get_contents($request);
        }
    }
    
    /**
     *A constructor that takes one parameter
     *
     *@param $id int; a number to be used to query the DB
     */
    public function __construct1($id)
    {
        $this->id = $id;
        
        $sqlFeed = "SELECT FeedName,FeedUrl FROM wn16_feeds WHERE FeedID = $id;";
        $singleFeed = mysqli_query(IDB::conn(),$sqlFeed) 
        or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
        if (mysqli_num_rows($singleFeed) > 0) {#there are records - present data
            //converts the query into an associative array
            $singleFeed = mysqli_fetch_assoc($singleFeed);

            $request = $singleFeed["FeedUrl"];
            $this->feedXml = file_get_contents($request);
            $this->feedName = $singleFeed["FeedName"];
            $this->timeCreated = (int)time();
        } else {
            header('Location:index.php');
        }
    }
    
    /**
     *this method puts together the feeds properties in order to display them 
     */
    public function getFeed()
    {
        echo '<div id="sidebar-right">';
        //converts the xml string property into an xml object
        $xml = simplexml_load_string($this->feedXml);
        print '<h1>' . $this->feedName . '</h1>';
        foreach($xml->channel->item as $story)
        {
        	//in here we erase a line from the description to make the story look better
            $desc = 
            str_replace(
            		'<br><div style="padding-top:0.8em;"><img alt="" height="1" width="1">'
            		,'',$story->description);
            echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
            echo '<p>' . $desc . '</p><br /><br />';
        }
        
        get_footer(); #defaults to footer_inc.php
        echo '</div>';
    }
}