<?php
date_default_timezone_set('Asia/Calcutta');
class Users {
	public $tableName = 'users';
	
	function __construct(){
		//Database configuration
		$dbServer = 'localhost'; //Define database server host
		$dbUsername = 'root'; //Define database username
		$dbPassword = 'foodiyerocks'; //Define database password
		$dbName = 'newDd'; //Define database name
		
		//Connect databse
		$con = mysqli_connect($dbServer,$dbUsername,$dbPassword,$dbName);
		if(mysqli_connect_errno()){
			die("Failed to connect with MySQL: ".mysqli_connect_error());
		}else{
			$this->connect = $con;
		}
	}
	
	function checkUser($oauth_provider,$oauth_uid,$username,$fname,$lname,$locale,$oauth_token,$oauth_secret,$profile_image_url){
		
		$prevQuery = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		if(mysqli_num_rows($prevQuery) > 0){
			$update = mysqli_query($this->connect,"UPDATE $this->tableName SET oauth_token = '".$oauth_token."', oauth_secret = '".$oauth_secret."', modified = '".date("Y-m-d H:i:s")."' WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		}else{
			$insert = mysqli_query($this->connect,"INSERT IGNORE INTO $this->tableName SET oauth_provider = '".$oauth_provider."', oauth_uid = '".$oauth_uid."', username = '".$username."', fname = '".$fname."', lname = '".$lname."', locale = '".$locale."', oauth_token = '".$oauth_token."', oauth_secret = '".$oauth_secret."', picture = '".$profile_image_url."', created = '".date("Y-m-d H:i:s")."', modified = '".date("Y-m-d H:i:s")."'") or die(mysqli_error($this->connect));
		}
		
		$query = mysqli_query($this->connect,"SELECT * FROM $this->tableName WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		$result = mysqli_fetch_array($query);
		return $result;
	}
	
	function logInsert($endpoint,$oauth_uid, $reqArray, $resArray)
	{
		$reqArray = json_encode ($reqArray);
		$resArray = mysqli_real_escape_string($this->connect,json_encode($resArray));
		$insert = mysqli_query($this->connect,"INSERT IGNORE INTO call_log SET resp_array = '".$resArray."',user_id = '".$oauth_uid."', req_array = '".$reqArray."', endpoint = '".$endpoint."'") or die(mysqli_error($this->connect));
		if( mysqli_num_rows($insert) > 0) 
		{
    		mysqli_query($this->connect,"INSERT IGNORE INTO call_log SET resp_array = '".$resArray."',user_id = '".$oauth_uid."', req_array = '".$reqArray."', endpoint = '".$endpoint."'") or die(mysqli_error($this->connect));
		}
		else
		{
		    mysqli_query($this->connect,"update call_log SET resp_array = '".$resArray."',user_id = '".$oauth_uid."', req_array = '".$reqArray."', endpoint = '".$endpoint."' where user_id = '".$oauth_uid."'") or die(mysqli_error($this->connect));
		}
		
	}

	function followInsert($oauth_uid, $nameFollow, $postedFollow, $tweetFollow, $idFollow, $screenNameFollow)
	{
		$nameFollow = mysqli_real_escape_string($this->connect, $nameFollow);
		$tweetFollow = mysqli_real_escape_string($this->connect,json_encode($tweetFollow));
		$screenNameFollow = mysqli_real_escape_string($this->connect,$screenNameFollow);

		$postedFollow = date("Y-m-d H:i:s", strtotime($postedFollow));
		$insert = mysqli_query($this->connect,"Select * from followers where id_followers = '".$idFollow."'") or die(mysqli_error($this->connect));
		if( mysqli_num_rows($insert) > 0) 
		{
    		mysqli_query($this->connect,"UPDATE followers SET modified='".date('Y-m-d H:i:s')."', oauth_uid = '".$oauth_uid."',name_followers = '".$nameFollow."', posted_followers = '".$postedFollow."', tweet_followers = '".$tweetFollow."', screen_followers = '".$screenNameFollow."' where id_followers='".$idFollow."'");
		}
		else
		{
		    mysqli_query($this->connect,"INSERT  INTO followers SET created='".date('Y-m-d H:i:s')."',modified='".date('Y-m-d H:i:s')."', oauth_uid = '".$oauth_uid."',name_followers = '".$nameFollow."', posted_followers = '".$postedFollow."', tweet_followers = '".$tweetFollow."', id_followers = '".$idFollow."', screen_followers = '".$screenNameFollow."'");
		}
	}
}
?>