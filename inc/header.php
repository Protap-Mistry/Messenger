<?php
	$filepath= realpath(dirname(__FILE__));
	include $filepath.'/../lib/User.php';

?>

<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'/../lib/Session.php';
	Session::init();
	//Session::checkSession();
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>  
    <title> Messenger </title>

    <meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	
	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"> -->

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css">

	<link rel="stylesheet" href="css/my.css?v=<?php echo time()?>">
	
	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" > -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css?v=<?php echo time()?>">

	<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
 -->	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://cdn.jsdelivr.net/gh/yuku-t/jquery-textcomplete@v1.3.4/dist/jquery.textcomplete.js
"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js.map"></script>	
 -->
 	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script> -->
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
 	
 	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
	
	<script src="https://www.jqueryscript.net/demo/Dialog-Modal-Dialogify/dist/dialogify.min.js"></script>

	<script src="js/sweetalert.min.js"></script>
	
	<script src="js/scripts_using_ajax_jquery.js"></script>

	<script type="text/javascript" src="js/top_up.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script> <!-- live search into navbar -->

	<script src="js/liveSearch.js"></script> <!-- live search into users list -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.js"></script>
	
 </head>
 <?php
   if(isset($_GET['action']) && $_GET['action']=="logout")
   {
	   Session::destroy();
   }
 ?>
 <body>
    <div class="container">
   	<?php 
   		include 'menu.php';
   	?>
	    