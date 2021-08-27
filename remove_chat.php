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

	if(isset($_POST['action']) && $_POST['action'] == 'remove_msg')
	{

		$remove_message= $user->removeMessage();
		//echo $remove_message;
		
	}
	
?>
