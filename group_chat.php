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

	if(isset($_POST['action']) && $_POST['action'] == 'group_chat')
	{

		$group_chat_message= $user->groupChat($logged_in_id);
		echo $group_chat_message;
		
	}
	if(isset($_POST['action']) && $_POST['action'] == 'fetch_group_chat')
	{

		$fetch_group_message= $user->fetchGroupMessage($logged_in_id);
		echo $fetch_group_message;
		
	}
	
?>
