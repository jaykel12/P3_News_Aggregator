<?php
//session-test2.php
    
    session_start();

//$game = new Game('49ers','2016-10-06');
//$game = new Game('Panthers','2016-16-06');

if(!isset($_SESSION['Game']))
{//session is set, add to it
    $_SESSION['Game'] = array();
}

$_SESSION['Game'][] = new Game('49ers','2016-10-06');

var_dump($_SESSION['Game']);

//var_dump($games);

/*if(isset($_SESSION['FavoriteColor']))
{
    echo $_SESSION['FavoriteColor'];

}else
{
    echo 'No session set!<br/>';
    echo $_SESSION['FavoriteColor'] = 'blue';
    echo 'Now session is set:' . $_SESSION['FavoriteColor'];
}

//$_SESSION['FavoriteColor'] = 'blue';
*/

class Game
{
    $Day = '';
    $Opponent = '';
    
    public function __construct($Opponent,$Day)
    {
        this->Opponent = $Opponent;
        $this->Dau = $Day;
    }
    
}