<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'./lib/Session.php';

	include 'lib/User.php';
	Session::init();
	Session::checkSession();
?>
<?php 

	$user= new User();
	$logged_in_id= Session::get("id");		    

	if(isset($_POST['action']) && $_POST['action'] == 'chat')
	{

		$chat_message= $user->chat($logged_in_id);
		echo $chat_message;
		
	}
	if(isset($_POST['action']) && $_POST['action'] == 'fetch_chat')
	{

		$fetch_message= $user->fetchMessage($logged_in_id);
		echo $fetch_message;
		
	}
	
?>
