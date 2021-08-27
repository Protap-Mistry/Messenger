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


	$last_activity= $user->updateLastActivity();
	//echo $last_activity;

	
?>
