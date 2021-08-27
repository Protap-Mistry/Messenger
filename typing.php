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

	if(isset($_POST['action']) && $_POST['action'] == 'typing')
	{

		$typing_activated= $user->typingActivated($logged_in_id);
		//echo $typing_activated;
		
	}
	
?>
