<?php
	$filepath= realpath(dirname(__FILE__));
	include_once $filepath.'./lib/Session.php';

	include 'lib/User.php';
	Session::init();
	Session::checkSession();
?>
<?php 

	if(!empty($_FILES))
	{
		// $file_extension= strtolower(pathinfo($_FILES["uploadFile"]["name"], PATHINFO_EXTENSION));
		// $new_file_name= rand().'.'.$file_extension;
		if(is_uploaded_file($_FILES["uploadFile"]["tmp_name"]))
		{

			$source_path= $_FILES["uploadFile"]["tmp_name"];
			$target_path= 'images/'.$_FILES["uploadFile"]["name"];

			if(move_uploaded_file($source_path, $target_path))
			{
				// if($file_extension == 'jpg' || $file_extension == 'png')
				// {
					echo '<p><img src="'.$target_path.'" class="img-responsive img-thumbnail" id="show" width="150px" height="150px"/></p><br/>';
				// }
				// else
				// {
				// 	echo "Not allowed";
				// }
			}
		}
	}

?>