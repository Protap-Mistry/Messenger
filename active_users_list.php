<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'./lib/Session.php';

	include 'lib/User.php';
	Session::init();
	Session::checkSession();
?>
<?php 

	$user= new User();
	$id= Session::get("id");

	if(isset($_POST['action']) && $_POST['action'] == 'fetch_active_users')
	{

		$active_users_fetch= $user->showActiveUsers($id);
		echo $active_users_fetch;
		
	}
	
?>
