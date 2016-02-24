<?php
//News.php a class that handles news objects

class News
{
    //instance variables
    public $categories = [];
    public $subCategories = [];
    
    //constructor
    public function __construct()
    {
        $sqlCats = "SELECT CategoryID, CategoryName FROM wn16_news_categories";
        $sqlSubCats = "SELECT f.FeedID,f.CategoryID,f.FeedName FROM wn16_feeds f ORDER BY f.FeedName ASC";
        
        $cats = mysqli_query(IDB::conn(),$sqlCats) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
        $subCats = mysqli_query(IDB::conn(),$sqlSubCats) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
        $subCats = mysqli_fetch_all($subCats,MYSQLI_ASSOC);
        
        $this->categories = $cats;
        $this->subCategories = $subCats;
    }
    
    //function that displays the new navigation menu
    public function getNewsNav()
    {
        echo '<div id="sidebar-left">
        <h3 class="sidebar-left-header">Categories</h3>
        <ul id="toggle-view">';
        
        if(mysqli_num_rows($this->categories) > 0)
        {#there are records - present data
            while($row = mysqli_fetch_assoc($this->categories))
            {# pull data from associative array
               $string = '<li>
                <h5>'.$row['CategoryName'].'</h5>
                <span>&#43;</span>
                <div class="panel">';
                    if($this->subCategories)
                    {#there are records - present data
                        foreach ($this->subCategories as $feed)
                        {# loops through the feeds array to find feeds that belong to the category
                            if($row["CategoryID"] == $feed["CategoryID"])
                            {#if $row categoryid is equal to the $feed categoryid they belong together
                                $string .= '
                                <p><strong>
                                <a href="feed_view.php?id='.$feed["FeedID"].'">'.$feed["FeedName"].'</a>
                                </strong></p>';
                            }
                        }
                    }
                $string .='</div></li>';
                echo $string;
            }
        }
        
        echo '</ul></div>';
    }
    
    //fucntion that displays a feed given its ID
    public function getNewsFeed($id)
    {
        if ($id != 0 && isset($_SESSION["feeds"]["$id"])) {
            $myFeed = unserialize($_SESSION["feeds"]["$id"]);
            if ($myFeed->timeCreated + 600 > time() && !(isset($_GET["refresh"]))){
                echo 'This is from a session that started at ' 
                    .date("h:i",$myFeed->timeCreated) . '. It is set to expire in 10 minutes.';
                echo '
                <a href="feed_view.php?id='.$myFeed->id.'&refresh=true">Click here to refresh the feed</a>
                ';
                $myFeed->getFeed();
            }
            else
            {
                $myFeed = new Feed($id);
                $_SESSION["feeds"]["$id"] = serialize($myFeed);
                $myFeed->getFeed();
            }
        } else {
            if ($id > 0) {
                $myFeed = new Feed($id);
                $_SESSION["feeds"]["$id"] = serialize($myFeed);
            } else {
                $myFeed = new Feed();
            }
            $myFeed->getFeed();
        }
    }
}