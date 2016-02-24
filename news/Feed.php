<?php
//Feed.php a class that handles feed objects

class Feed
{
    //instance variables
    public $id = 0;
    public $feedName = '';
    public $feedXml = '';
    public $timeCreated = 0;
    
    //constructor
    
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
            $request = 'https://news.google.com/news?cf=all&hl=en&pz=1&ned=us&output=rss';
            $this->feedXml = file_get_contents($request);
        }
    }
    
    //constructor with one argument
    public function __construct1($id)
    {
        $this->id = $id;
        
        $sqlFeed = "SELECT FeedName,FeedUrl FROM wn16_feeds WHERE FeedID = $id;";
        $singleFeed = mysqli_query(IDB::conn(),$sqlFeed) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
        $singleFeed = mysqli_fetch_assoc($singleFeed);

        $request = $singleFeed["FeedUrl"];
        $this->feedXml = file_get_contents($request);
        $this->feedName = $singleFeed["FeedName"];
        $this->timeCreated = (int)time();
    }
    
    //gets the formated version of the objects feed
    public function getFeed()
    {
        echo '<div id="sidebar-right">';
        $xml = simplexml_load_string($this->feedXml);
        print '<h1>' . $this->feedName . '</h1>';
        foreach($xml->channel->item as $story)
        {
            echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
            echo '<p>' . $story->description . '</p><br /><br />';
        }
        
        get_footer(); #defaults to footer_inc.php
        echo '</div>';
    }
}