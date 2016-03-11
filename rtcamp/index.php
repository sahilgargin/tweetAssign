
<?php
//start session
session_start();

// Include config file and twitter PHP Library by Abraham Williams (abraham@abrah.am)
include_once("config.php");
include_once("inc/twitteroauth.php");
include_once("includes/functions.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login with Twitter using PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/roboto.css" rel='stylesheet' type='text/css'>
    <link href="css/ninja-slider.css" rel="stylesheet" type="text/css" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
     <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="js/ninja-slider.js" type="text/javascript"></script>
    <script type = "text/javascript" src="js/main.js"></script>
    <style type="text/css">
    
    </style>
</head>
<body>
<div class="loadinger">
<svg id="loading">
<g>
    <path class="ld-l" fill="#39C0C4" d="M43.6,33.2h9.2V35H41.6V15.2h2V33.2z"/>
    <path class="ld-o" fill="#39C0C4" d="M74.7,25.1c0,1.5-0.3,2.9-0.8,4.2c-0.5,1.3-1.2,2.4-2.2,3.3c-0.9,0.9-2,1.6-3.3,2.2
        c-1.3,0.5-2.6,0.8-4.1,0.8s-2.8-0.3-4.1-0.8c-1.3-0.5-2.4-1.2-3.3-2.2s-1.6-2-2.2-3.3C54.3,28,54,26.6,54,25.1s0.3-2.9,0.8-4.2
        c0.5-1.3,1.2-2.4,2.2-3.3s2-1.6,3.3-2.2c1.3-0.5,2.6-0.8,4.1-0.8s2.8,0.3,4.1,0.8c1.3,0.5,2.4,1.2,3.3,2.2c0.9,0.9,1.6,2,2.2,3.3
        C74.4,22.2,74.7,23.6,74.7,25.1z M72.5,25.1c0-1.2-0.2-2.3-0.6-3.3c-0.4-1-0.9-2-1.6-2.8c-0.7-0.8-1.6-1.4-2.6-1.9
        c-1-0.5-2.2-0.7-3.4-0.7c-1.3,0-2.4,0.2-3.4,0.7c-1,0.5-1.9,1.1-2.6,1.9c-0.7,0.8-1.3,1.7-1.6,2.8c-0.4,1-0.6,2.1-0.6,3.3
        c0,1.2,0.2,2.3,0.6,3.3c0.4,1,0.9,2,1.6,2.7c0.7,0.8,1.6,1.4,2.6,1.9c1,0.5,2.2,0.7,3.4,0.7c1.3,0,2.4-0.2,3.4-0.7
        c1-0.5,1.9-1.1,2.6-1.9c0.7-0.8,1.3-1.7,1.6-2.7C72.4,27.4,72.5,26.3,72.5,25.1z"/>
    <path class="ld-a" fill="#39C0C4" d="M78.2,35H76l8.6-19.8h2L95.1,35h-2.2l-2.2-5.2H80.4L78.2,35z M81.1,27.9h8.7l-4.4-10.5L81.1,27.9z"/>
    <path class="ld-d" fill="#39C0C4" d="M98,15.2h6.6c1.2,0,2.5,0.2,3.7,0.6c1.2,0.4,2.4,1,3.4,1.9c1,0.8,1.8,1.9,2.4,3.1s0.9,2.7,0.9,4.3
        c0,1.7-0.3,3.1-0.9,4.3s-1.4,2.3-2.4,3.1c-1,0.8-2.1,1.5-3.4,1.9c-1.2,0.4-2.5,0.6-3.7,0.6H98V15.2z M100,33.2h4
        c1.5,0,2.8-0.2,3.9-0.7c1.1-0.5,2-1.1,2.8-1.8c0.7-0.8,1.3-1.6,1.6-2.6s0.5-2,0.5-3c0-1-0.2-2-0.5-3c-0.4-1-0.9-1.8-1.6-2.6
        c-0.7-0.8-1.6-1.4-2.8-1.8c-1.1-0.5-2.4-0.7-3.9-0.7h-4V33.2z"/>
    <path class="ld-i" fill="#39C0C4" d="M121.2,35h-2V15.2h2V35z"/>
    <path class="ld-n" fill="#39C0C4" d="M140.5,32.1L140.5,32.1l0.1-16.9h2V35h-2.5l-11.5-17.1h-0.1V35h-2V15.2h2.5L140.5,32.1z"/>
    <path class="ld-g" fill="#39C0C4" d="M162.9,18.8c-0.7-0.7-1.5-1.3-2.5-1.7c-1-0.4-2-0.6-3.3-0.6c-1.3,0-2.4,0.2-3.4,0.7s-1.9,1.1-2.6,1.9
        c-0.7,0.8-1.3,1.7-1.6,2.8c-0.4,1-0.6,2.1-0.6,3.3c0,1.2,0.2,2.3,0.6,3.3c0.4,1,0.9,2,1.6,2.7c0.7,0.8,1.6,1.4,2.6,1.9
        s2.2,0.7,3.4,0.7c1.1,0,2.1-0.1,3.1-0.4c0.9-0.2,1.7-0.5,2.3-0.9v-6h-4.6v-1.8h6.6v9c-1.1,0.7-2.2,1.1-3.5,1.5
        c-1.3,0.3-2.5,0.5-3.9,0.5c-1.5,0-2.9-0.3-4.1-0.8s-2.4-1.2-3.3-2.2c-0.9-0.9-1.6-2-2.1-3.3s-0.8-2.7-0.8-4.2s0.3-2.9,0.8-4.2
        c0.5-1.3,1.2-2.4,2.2-3.3c0.9-0.9,2-1.6,3.3-2.2c1.3-0.5,2.6-0.8,4.1-0.8c1.6,0,3,0.2,4.1,0.7s2.2,1.1,3,2L162.9,18.8z"/>
</g>
</svg>


<svg width='182px' height='182px' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-ripple"><rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect><g> <animate attributeName="opacity" dur="4s" repeatCount="indefinite" begin="0s" keyTimes="0;0.33;1" values="1;1;0"></animate><circle cx="50" cy="50" r="40" stroke="#eeeeee" fill="none" stroke-width="2" stroke-linecap="round"><animate attributeName="r" dur="4s" repeatCount="indefinite" begin="0s" keyTimes="0;0.33;1" values="0;22;44"></animate></circle></g><g><animate attributeName="opacity" dur="4s" repeatCount="indefinite" begin="2s" keyTimes="0;0.33;1" values="1;1;0"></animate><circle cx="50" cy="50" r="40" stroke="#eeeeee" fill="none" stroke-width="2" stroke-linecap="round"><animate attributeName="r" dur="4s" repeatCount="indefinite" begin="2s" keyTimes="0;0.33;1" values="0;22;44"></animate></circle></g></svg>
</div>
    
<?php
if (isset($_SESSION['status']) && $_SESSION['status'] == 'verified') {
    //Retrive variables
    $screen_name        = $_SESSION['request_vars']['screen_name'];
    $twitter_id         = $_SESSION['request_vars']['user_id'];
    $oauth_token        = $_SESSION['request_vars']['oauth_token'];
    $oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
    
    //Show welcome message
    echo '<div class="welcome_txt">Welcome <strong>' . $screen_name . '</strong><div id="twitId">'.$twitter_id.' </div> <a href="logout.php?logout">Logout</a>!</div>';
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    
    //If user wants to tweet using form.
    if (isset($_POST["updateme"])) {
        //Post text to twitter
        $my_update = $connection->post('statuses/update', array(
            'status' => $_POST["updateme"]
        ));
        die('<script type="text/javascript">window.top.location="index.php"</script>'); //redirect back to index.php
    }
    
    //show tweet form
    echo '<div class="tweet_box">';
    echo '<form method="post" action="index.php" class="frm">';
    echo '<textarea name="updateme" cols="60" rows="14"></textarea>';
    echo '<input class="SearchB" type="submit" value="Tweet" />';
    echo '</form>';
    echo '</div>';
    
    //Get latest tweets
    $my_tweets   = $connection->get('statuses/user_timeline', array(
        'screen_name' => $screen_name,
        'count' => 10
    ));
    $foll_tweets = $connection->get('followers/list', array(
        'screen_name' => $screen_name,
        'count' => 10
    ));
    $go          = new Users();
    $go->logInsert("followers/list", $twitter_id, array(
        'screen_name' => $screen_name,
        'count' => 10
    ), $foll_tweets);
    
    //var_dump($my_tweets);
    //die();    
    
    $app     = "";
    $pdfCont = array();
    foreach ($my_tweets as $my_tweet) {
        
        $app .= "<li>
                    <div class='content'>
                        <img src='{$my_tweet->entities->media[0]->media_url}' />
                        <h3>{$my_tweet->text}</h3>
                        <p>{$my_tweet->created_at}</p>
                    </div>
                </li>";
        
        array_push($pdfCont, $my_tweet->text);
    }
    echo "<div class='wrap-up'><div class='nameFol'><div id='whoTweet'>Tweets by {$screen_name}:</div> <a class='doTweet' href='pdfGen.php'><div  width='151' height='24' border='0' >Download Tweets!</div></a></div><br/><div id='ninja-slider'><div class='slider-inner'><ul>";
    echo $app;
    echo "<div class='fs-icon' title='Expand/Close'></div></div></div></div>";
    
    $_SESSION['pdfTweet'] = $pdfCont;
    
    echo "<div class='tweet_list'><div class='autoEnclose'><div class='SearchBox'>
            <form action='/search' method='get' class='sb'>
                <input type='text' placeholder='Search Followers' name='followerSearchBox' id = 'sbox'  autocomplete='off'/>
            </form></div><div id='autoFill' class='BlockDis'></div></div><br/><strong>Followers: </strong>";
    echo '<ul>';
    echo "";
    foreach ($foll_tweets->users as $foll_tweet) {
        $follo_tweets = $connection->get('statuses/user_timeline', array(
            'user_id' => $foll_tweet->id,
            'screen_name' => $foll_tweet->screen_name,
            'count' => 10
        ));
        $go->followInsert($twitter_id, $foll_tweet->name, $foll_tweet->created_at, $follo_tweets, $foll_tweet->id, $foll_tweet->screen_name);
        echo '<li><a href="#" class="divShow" onclick="getTweetData('.$foll_tweet->id.');  return false;" ><img src="' . $foll_tweet->profile_image_url_https . '"/><br />-<i>' . $foll_tweet->name . '</i>-<i>' . $foll_tweet->created_at . '</i></a></li>';
        
        /*foreach ($follo_tweets  as $follo_tweet) 
        {
        echo '<li>'.$follo_tweet->text.' <br />-<i>'.$follo_tweet->created_at.'</i></li><br/><br/>';
        }*/
    }
    echo '</ul></div>';
    
    
    
} else {
    //Display login button
    echo '<center><a class="login" href="process.php"><img src="images/sign-in-with-twitter.png" width="151" height="24" border="0" /></a><center>';
}
?>  
</body>
</html>

