<?php include 'inc/header.php'; ?>

<?php

	if(!isset($_SESSION['id']))
	{
		echo "<script> window.location= 'login.php'; </script>";
	}
?>
<?php 
	$user= new User();
	$logged_in_id= Session::get("id");

	$username= $_GET["data"];
	//echo $username;
	
	$search_details= $user->navbarSearchDetails($logged_in_id);

?>

<div class="card">
    <div class="card-header">
	    <h2 class="text-center">
	    	<?php
							
				echo '#<b>'.$_GET["data"].'</b> Profile';					  
		 	?>
		</h2>
	</div>
	
	<div class="card-body">
		<?php 
			if($search_details)
			{
				echo $search_details;
			}

		?>
						    
	</div>
</div>
<br>
<?php include 'inc/footer.php';	?>
