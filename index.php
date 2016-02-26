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
	
<?php
	if(isset($_SESSION['status']) && $_SESSION['status'] == 'verified') 
	{
		//Retrive variables
		$screen_name 		= $_SESSION['request_vars']['screen_name'];
		$twitter_id			= $_SESSION['request_vars']['user_id'];
		$oauth_token 		= $_SESSION['request_vars']['oauth_token'];
		$oauth_token_secret = $_SESSION['request_vars']['oauth_token_secret'];
	
		//Show welcome message
		echo '<div class="welcome_txt">Welcome <strong>'.$screen_name.'</strong> <a href="logout.php?logout">Logout</a>!</div>';
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
		
		//If user wants to tweet using form.
		if(isset($_POST["updateme"])) 
		{
			//Post text to twitter
			$my_update = $connection->post('statuses/update', array('status' => $_POST["updateme"]));
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
		$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $screen_name, 'count' => 10));
		$foll_tweets = $connection->get('followers/list', array('screen_name' => $screen_name, 'count' => 10));
		$go = new Users();
		$go->logInsert("followers/list",$twitter_id,array('screen_name' => $screen_name, 'count' => 10),$foll_tweets);

		//var_dump($my_tweets);
		//die();	
		
		$app = "";
		$pdfCont =  array();
		foreach ($my_tweets  as $my_tweet) {
			
			$app .=  "<li>
                    <div class='content'>
                        <img src='{$my_tweet->entities->media[0]->media_url}' />
                        <h3>{$my_tweet->text}</h3>
                        <p>{$my_tweet->created_at}</p>
                    </div>
                </li>";

        	array_push($pdfCont, $my_tweet->text);
		}
		echo "<div class='wrap-up'><div class='nameFol'>{$screen_name} <a class='doTweet' href='pdfGen.php'><div  width='151' height='24' border='0' >Download Tweets!</div></a></div><br/><div id='ninja-slider'><div class='slider-inner'><ul>";
		echo $app;
		echo "<div class='fs-icon' title='Expand/Close'></div></div></div></div>";	
		
		$_SESSION['pdfTweet'] = $pdfCont;

		echo "<div class='tweet_list'><div class='autoEnclose'><div class='SearchBox'>
            <form action='/search' method='get' class='sb'>
                <input type='text' placeholder='Search Followers' name='followerSearchBox' id = 'sbox'  autocomplete='off'/>
            </form></div><div id='autoFill' class='BlockDis'></div></div><br/><strong>Followers: </strong>";
		echo '<ul>';
		echo "";
		foreach($foll_tweets->users  as $foll_tweet)
		{
			$go->followInsert($twitter_id, $foll_tweet->name, $foll_tweet->created_at, $follo_tweets, $foll_tweet->id, $foll_tweet->screen_name);
			echo '<li><img src="'.$foll_tweet->profile_image_url_https.'"/><br />-<i>'.$foll_tweet->name.'</i>-<i>'.$foll_tweet->created_at.'</i></li>';
			$follo_tweets = $connection->get('statuses/user_timeline', array('user_id'=>$foll_tweet->id,'screen_name' => $foll_tweet->screen_name, 'count' => 10));
			/*foreach ($follo_tweets  as $follo_tweet) 
			{
				echo '<li>'.$follo_tweet->text.' <br />-<i>'.$follo_tweet->created_at.'</i></li><br/><br/>';
			}*/
		}
		echo '</ul></div>';

		
			
	}else{
		//Display login button
		echo '<center><a class="login" href="process.php"><img src="images/sign-in-with-twitter.png" width="151" height="24" border="0" /></a><center>';
	}
?>  
</body>
</html>