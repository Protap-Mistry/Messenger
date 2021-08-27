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

	$perPageCount = 5;
	$pageNumber = 1;

	if(Session::get("page")){

		$pageNumber= Session::get("page");
	}
	//var_dump($pageNumber);
	$lowerLimit = ($pageNumber - 1) * $perPageCount;

	if(isset($_POST['action']) && $_POST['action'] == 'fetch_all_users')
	{

		$all_users_fetch= $user->showAllUsers($id, $lowerLimit, $perPageCount);
		echo $all_users_fetch;
		
	}

	$rowCount= $user->paginationForShowingUsers($id);
	//echo $rowCount;
	$pagesCount = ceil($rowCount / $perPageCount);
	//echo $pagesCount;
	echo "<span class='pagination'>";

		for ($i = 1; $i <= $pagesCount; $i ++) 
        {
            if ($i == $pageNumber) 
            {
            	echo "<a href='index.php' class='active_page'>$i</a>";
            } 
            else 
            {
            	echo "<a href='index.php?&page=$i' onclick='showRecords($perPageCount, $i)'>$i</a>";
            }
        }
        ?>
         	=>Page <?php echo $pageNumber; ?> of <?php echo $pagesCount; ?>
        <?php
 
	echo "</span>";
	
?>
