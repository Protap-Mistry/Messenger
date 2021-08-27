<?php
  include 'inc/header.php';
  //Session::checkSession();
 
?>

<?php
	if(!isset($_SESSION['id']))
	{
		echo "<script> window.location= 'login.php'; </script>";
	}
?>

<?php
	$loginmsg= Session::get("loginmsg");
	if(isset($loginmsg))
	{
		echo $loginmsg;
	}
	Session::set("loginmsg", NULL);
?>

<?php 
	$user= new User();
	$id= Session::get("id");

	//start for users pagination
	if(isset($_GET["page"])){

		$pageNumber= $_GET['page'];
		Session::set("page", $pageNumber);
	}
	else
	{
		Session::set("page", NULL);
	}
	//end for users pagination
	
?>

<div class="row">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title text-center">... Users ...</h3>
			</div>
			<div class="card-body table-responsive">
				<div class="row users_card">
					<div id="all_users_list">
						<div id="users_pagination"></div>
					</div>
					<div id="user_model_details">
						
					</div>
				</div>
			</div>
					
		</div>		
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<div class="row">
		    		<div class="col-md-7">				
						<h4 class="card-title active_users">Active Users List</h4>
					</div>

					<div class="col-md-1">
					
						<input type="hidden" id="is_active_group_chat_window" value="no" />
						<button type="button" name="group_chat" id="group_chat" class="btn btn-info btn-xs"><i class="fa fa-users fa-lg" aria-hidden="true"></i> Group Chat</button>
					</div>
					<div id="group_chat_dialog" title="Group Chat">
						<div id="group_chat_history" class="group_chat">
							
						</div>
						<div class="form-group">
							<!-- <textarea name="group_chat_message" id="group_chat_message" class="form-control"></textarea> -->
							<div class="chat_message_area">
								<div id="group_chat_message" contenteditable class="form-control"></div>
								
								<div class="image_upload">
									<form action="upload.php" id="uploadImage" method="POST">
										
										<input type="file" class="novisible" name="uploadFile" id="uploadFile" accept=".jpg, .png"/>
										<label for="uploadFile" class="btn btn-md btn-teak pull-left">
											<i class="fa fa-cloud-upload fa-2x" aria-hidden="true" title="Upload"> </i>
										</label>									
									</form>
								</div>
							</div>
						</div>
						<div class="form-group" align="right">
							<button type="button" id="send_group_chat" name="send_group_chat" class="btn btn-success">Send</button>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row search">
				<div class="col-lg-12">
				    <div class="input-group">
				      	<span class="input-group-btn">
				        	<button class="btn btn-default" type="button">#</button>
				      	</span>
				      	<input type="text" name="search_text" id="search_text" class="form-control" placeholder="Search user using username to chat...">
				    </div><!-- /input-group -->
				</div><!-- /.col-lg-12 -->
			</div><!-- /.row -->

			<br/>
			<div id="result"></div>
			<div style="clear:both"></div>

			<div class="card-body">
				<div id="active_users_list">
					
				</div>
			</div>
			
		</div>
	</div>
</div>
<br>
<?php include 'inc/footer.php';	?>