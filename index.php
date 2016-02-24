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
    <script src="js/ninja-slider.js" type="text/javascript"></script>	
    <script type = "text/javascript" src="js/main.js"></script>
    <style type="text/css">
	.wrapper{width:600px; margin-left:auto;margin-right:auto;}
	.welcome_txt{
		margin: 20px;
		background-color: #EBEBEB;
		padding: 10px;
		border: #D6D6D6 solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_box{
		margin: 20px;
		background-color: #FFF0DD;
		padding: 10px;
		border: #F7CFCF solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_box textarea{
		width: 100%;
		border: #F7CFCF solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_list{
		margin: 20px;
		padding:20px;
		background-color: #E2FFF9;
		border: #CBECCE solid 1px;
		-moz-border-radius:5px;
		-webkit-border-radius:5px;
		border-radius:5px;
	}
	.tweet_list ul{
		padding: 0px;
		font-family: verdana;
		font-size: 12px;
		color: #5C5C5C;
	}
	.tweet_list li{
		border-bottom: silver dashed 1px;
		list-style: none;
		padding: 5px;
	}
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
		echo '<div class="welcome_txt">Welcome <strong>'.$screen_name.'</strong> (Twitter ID : '.$twitter_id.'). <a href="logout.php?logout">Logout</a>!</div>';
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
		echo '<form method="post" action="index.php"><table width="200" border="0" cellpadding="3">';
		echo '<tr>';
		echo '<td><textarea name="updateme" cols="60" rows="4"></textarea></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td><input type="submit" value="Tweet" /></td>';
		echo '</tr></table></form>';
		echo '</div>';
		
		//Get latest tweets
		$my_tweets = $connection->get('statuses/user_timeline', array('screen_name' => $screen_name, 'count' => 10));
		$foll_tweets = $connection->get('followers/list', array('screen_name' => $screen_name, 'count' => 10));
		$go = new Users();
		$go->logInsert("followers/list",$twitter_id,array('screen_name' => $screen_name, 'count' => 10),$foll_tweets);

		//var_dump($my_tweets);
		//die();	
		
		echo "<div id='ninja-slider'><div class='slider-inner'><ul>";

		foreach ($my_tweets  as $my_tweet) {
			
			echo "<li>
                    <div class='content'>
                        <img src='{$my_tweet->entities->media[0]->media_url}' />
                        <h3>{$my_tweet->text}</h3>
                        <p>{$my_tweet->created_at}</p>
                    </div>
                </li>";
			//echo '<li>'.$my_tweet->text.' <br />-<i>'.$my_tweet->created_at.'</i></li>';
		}
		echo "<div class='fs-icon' title='Expand/Close'></div></div></div>";	
		echo "<center><div class='SearchBox'>
            <form action='/search' method='get' class='sb'>
                <input type='text' name='followerSearchBox' id = 'sbox' class='SearchB' autocomplete='off'/>
                <input type='submit' value='Search' class = 'ButtonS'/>
            </form>
        </div>
        <div id='autoFill' class='BlockDis'>
        </div>
        </center>";

		echo '<div class="tweet_list"><strong>Followers: </strong>';
		echo '<ul>';

		foreach($foll_tweets->users  as $foll_tweet)
		{
			$go->followInsert($twitter_id, $foll_tweet->name, $foll_tweet->created_at, $follo_tweets, $foll_tweet->id, $foll_tweet->screen_name);
			echo '<li><img src="'.$foll_tweet->profile_image_url_https.'"/><br />-<i>'.$foll_tweet->name.'</i>-<i>'.$foll_tweet->created_at.'</i></li>';
			$follo_tweets = $connection->get('statuses/user_timeline', array('user_id'=>$foll_tweet->id,'screen_name' => $foll_tweet->screen_name, 'count' => 10));
			foreach ($follo_tweets  as $follo_tweet) 
			{
				echo '<li>'.$follo_tweet->text.' <br />-<i>'.$follo_tweet->created_at.'</i></li><br/><br/>';
			}
		}
		echo '</ul></div>';

		
			
	}else{
		//Display login button
		echo '<a href="process.php"><img src="images/sign-in-with-twitter.png" width="151" height="24" border="0" /></a>';
	}
?>  
</body>
</html>