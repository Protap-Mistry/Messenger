<?php
  require "phpMailer/vendor/autoload.php";
      
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
?>

<?php 
	include_once 'Session.php';
	include 'Database.php';
class User
{
	private $db;
	private $table= "users";

	public function __construct()
	{
		$this->db= new dbConnection();
	}

	public function usernameCheck($username)
	{
		$sql= "select username from $this->table where username= :u";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':u', $username);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function emailCheck($email)
	{
		$sql= "select email from $this->table where email= :email";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':email', $email);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function userRegistration($data)
	{
		$name= $data['name'];
		$username= $data['username'];
		$email= $data['email'];
		$password= $data['password'];
		$confirm_password= $data['confirm_password'];

		if($name=="" || $username=="" || $email=="" || $password=="" || $confirm_password==""){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty.</div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain alphanumerical, dashes and underscore.</div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username must only contain alphanumerical, dot, dashes and underscore.</div>";
			return $msg;
		}elseif (strlen($username)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username is too short </div>";
			return $msg;
		}

		$username_chk= $this->usernameCheck($username);

		if($username_chk==true){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The username already exist </div>";
			return $msg;
		}

		if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
			return $msg;
		}
		$email_chk= $this->emailCheck($email);

		if($email_chk==true){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The email address already exist </div>";
			return $msg;
		}

		if(strlen($password)<6){
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Password is too short. It must be greater than 5 values </div>";
			return $msg;
		}

		if($password != $confirm_password){
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Password dosen't match. </div>";
			return $msg;
		}

		$password= md5($data['password']);
		
		$sql= "insert into $this->table(name, username, email, password) values(:name, :username, :email, :password)";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':name', $name);
		$query->bindValue(':username', $username);
		$query->bindValue(':email', $email);
		$query->bindValue(':password', $password);
		
		if($query->execute())
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>
			Thank You, you have been registered... </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Sorry, there has been problem to insert your details. </div>";
			return $msg;
		}
	}

	public function getLoginUser($username, $password)
	{
		$sql= "select * from $this->table where username= :username and password= :password limit 1";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':username', $username);
		$query->bindValue(':password', $password);
		$query->execute();
		
		return $query->fetch(PDO::FETCH_OBJ);
		
	}
	public function userLogin($data)
	{
		$username= $data['username'];
		$password= ($data['password']);
		$confirm_password= $data['confirm_password'];
				
		if($username== "" OR $password== "" OR $confirm_password== "")
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Field must not be empty </div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username must only contain alphanumerical, dot, dashes and underscore.</div>";
			return $msg;
		}elseif (strlen($username)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username is too short.</div>";
			return $msg;
		}

		$username_chk= $this->usernameCheck($username);

		if($username_chk==false){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The username doesn't match. </div>";
			return $msg;
		}

		if(strlen($password)<6)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Password is too short. It must be greater than 5 values </div>";
			return $msg;
		}

		if($password != $confirm_password){
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Password dosen't match. </div>";
			return $msg;
		}

		$password= md5($data['password']);

		$result= $this->getLoginUser($username, $password);

		if($result)
		{
			Session::init();
			Session::set("login", true);
			Session::set("id", $result->id);
			Session::set("name", $result->name);
			Session::set("username", $result->username);
			Session::set("email", $result->email);
			Session::set("loginmsg", "<div class='alert alert-success'> <strong>Successfull! </strong>
			You are logged in... </div>");

			$sub_sql= "insert into users_login_info(user_id) values('".Session::get('id')."')";
			$query= dbConnection::myPrepareMethod($sub_sql);		
			$query->execute();		

			$_SESSION['users_login_info_id']= dbConnection::lastInsertIdMethod();
			//echo $_SESSION['users_login_info_id'];

			echo "<script> window.location= 'index.php'; </script>";
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
			Incorrect password ! </div>";
			return $msg;
		}
	}
	public function getUserData()
	{
		$sql= "select * from $this->table order by id desc";
		$query= dbConnection::myPrepareMethod($sql);		
		$query->execute();
		
		$result= $query->fetchAll();
		return $result;
	}
	public function getUserById($id)
	{
		$sql= "select * from $this->table where id= :id limit 1";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':id', $id);
		$query->execute();
		
		$result= $query->fetch(PDO::FETCH_OBJ);
		return $result;
	}

	public function updateTimeUsernameCheck($username, $id)
	{
		$sql= "select username from $this->table where username= :u and id != $id";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':u', $username);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateUserData($id, $data)
	{
		$name= $data['name'];
		$username= $data['username'];
		$email= $data['email'];
		$bio= $data['bio'];

		/*Image work start*/
	    $permitted= array('jpg', 'jpeg', 'png', 'gif');
	    $image_file_name= $_FILES['image']['name'];
	    $file_size= $_FILES['image']['size'];
	    $file_temp_name= $_FILES['image']['tmp_name'];

	    $divided= explode('.', $image_file_name);
	    $file_extension= strtolower(end($divided));
	    $unique_image= substr(md5(time()), 0, 10).'.'.$file_extension;
	    $uploaded_image= "images/".$unique_image;
	    /*Image work start*/
			
		if($name=="" || $username=="" || $email==""){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Field must not empty ( Image and bio aren't mandatory).</div>";
			return $msg;
		}
		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $name)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Name must only contain alphanumerical, dashes and underscore.</div>";
			return $msg;
		}

		if(preg_match('/[^A-Za-z0-9 ._-]+/i', $username)){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username must only contain alphanumerical, dot, dashes and underscore.</div>";
			return $msg;
		}elseif (strlen($username)<3) {
				
			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> Username is too short </div>";
			return $msg;
		}

		$update_time_username_chk= $this->updateTimeUsernameCheck($username, $id);

		if($update_time_username_chk==true){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong> The username already exist </div>";
			return $msg;
		}

		if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

			$msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>The email address is not valid. Please put like name@gmail.com </div>";
			return $msg;
		}

		if(!empty($image_file_name))
        {

			if($file_size>1048567)
			{
		        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>Image size should be less than 1 MB. </div>";
		        return $msg;
		    }
		    elseif (in_array($file_extension, $permitted) === false) 
		    {
		        $msg= "<div class='alert alert-danger'> <strong> Error!!! </strong>You can upload only: ".implode(', ', $permitted)."</div>";
		        return $msg;
		    }
		    else
		    {
		        move_uploaded_file($file_temp_name, $uploaded_image);
		    }

			$sql= "update $this->table set name= :name, username= :username, email= :email, image=:i, bio= :b where id= :id";
			$query= dbConnection::myPrepareMethod($sql);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $username);
			$query->bindValue(':email', $email);
			$query->bindValue(':i', $uploaded_image);
			$query->bindValue(':b', $bio);
			$query->bindValue(':id', $id);
			
			if($query->execute())
			{
				$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>
				Your data updated successfully ...</div>";
				return $msg;
			}
			else
			{
				$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
				Sorry, User data not updated !!!  </div>";
				return $msg;
			}
		}
		else
        {
	        $sql= "update $this->table set name= :name, username= :username, email= :email, bio= :b where id= :id";
			$query= dbConnection::myPrepareMethod($sql);
			$query->bindValue(':name', $name);
			$query->bindValue(':username', $username);
			$query->bindValue(':email', $email);
			$query->bindValue(':b', $bio);
			$query->bindValue(':id', $id);
	          
	        if($query->execute())
			{
				$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>
				Your data updated successfully ...</div>";
				return $msg;
			}
			else
			{
				$msg= "<div class='alert alert-danger'> <strong> Error! </strong>
				Sorry, User data not updated !!!  </div>";
				return $msg;
			}
        }
	}
	public function checkPassword($id, $old_pass)
	{
		$password= md5($old_pass);
		$sql= "select password from $this->table where id= :id  and  password= :password";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':id', $id);
		$query->bindValue(':password', $password);
		$query->execute();
		if($query->rowCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	public function updatePassword($id, $data)
	{
		$old_pass= $data['old_pass'];
		$new_pass= $data['password'];

		if($old_pass== "" OR $new_pass== "")
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Field must not be empty!!! </div>";
			return $msg;
		}
		$chk_pass= $this->checkPassword($id, $old_pass);
		
		if($chk_pass== false)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Old password not exist!!! </div>";
			return $msg;
		}
		if(strlen($new_pass)<=5)
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Password length is too short. You have put at least 6 values </div>";
			return $msg;
		}

		$password=md5($new_pass);

		$sql= "update $this->table set password= :password where id= :id";
		$query= dbConnection::myPrepareMethod($sql);
		$query->bindValue(':password', $password);		
		$query->bindValue(':id', $id);
		
		if($query->execute())
		{
			$msg= "<div class='alert alert-success'> <strong> Successfull! </strong>Password updated successfully </div>";
			return $msg;
		}
		else
		{
			$msg= "<div class='alert alert-danger'> <strong> Error! </strong>Sorry, Password not updated !!!  </div>";
			return $msg;
		}
	}

	//recovery customer password by sending email
    public function userPasswordRecover($data){
      $email= $data['email'];

      if($email == ""){
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>Field must not be empty !!!</div> </br>";
        return $msg;
      }
      if(filter_var($email, FILTER_VALIDATE_EMAIL)==false){

        $msg= "<div class='alert alert-danger'> <strong> Error! </strong>The email address is not valid. Please put like name@gmail.com </div> </br>";
        return $msg;    
      }

      $email_chk= $this->emailCheck($email);

      if($email_chk==true)
      {
        
        $new_generate= substr($email, 0, 3);
        $random= rand(10000, 99999);
        $combine= "$new_generate$random";
        $new_pass= md5($combine);

        $sql= "update users set password= :p where email= :email";
        $query= dbConnection::myPrepareMethod($sql);

        $query->bindValue(':p', $new_pass);
        $query->bindValue(':email', $email);
        $query->execute();

        //new work start

        $sender = 'sender_email@gmail.com';

        $developmentMode = true;
        $mailer = new PHPMailer($developmentMode);
        $mailer->Mailer = "smtp";

        try 
        {
            $mailer->SMTPDebug = 0;
            $mailer->isSMTP();

            if ($developmentMode) 
            {
                $mailer->SMTPOptions = [
                    'ssl'=> [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                    ]
                ];
            }

            $mailer->Host = 'smtp.gmail.com';
            $mailer->SMTPAuth = true;
            $mailer->Username = $sender;
            $mailer->Password = 'sender_email_password';
            $mailer->SMTPSecure = 'tls';
            $mailer->Port = 587;

            $mailer->setFrom($sender, 'Author');
            $mailer->addAddress($email);

            $mailer->isHTML(true);
            $mailer->Subject = 'Your New Password';
            $mailer->Body = "Your new password is ".$combine.". Please visit our website to login";
       
            //$mailer->ClearAllRecipients();
            //echo "E-mail has been sent successfully !!!";
            if($mailer->send())
            {
              $msg= "<div class='alert alert-success'>E-mail has been sent successfully !!! Please check your email for getting new password.</div> </br>";
              return $msg;
            }
        } 
        catch (Exception $e) 
        {
            echo "E-mail sending failed. INFO: " . $mailer->ErrorInfo;
        }
        //new work end           
      }
      else
      {
        $msg= "<div class='alert alert-danger'> <strong> Error! </strong> The email address doesn't exist. </div> </br>";
        return $msg;
      }
    }

	public function showAllUsers($logged_in_id, $lowerLimit, $perPageCount)
	{
		$output= '';

		$sql="select * from users where id !=$logged_in_id limit $lowerLimit, $perPageCount";
		// var_dump($lowerLimit);
		// var_dump($perPageCount);
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		// var_dump($sql);
		$row_count= $stmt->rowCount();
		//echo "string ". $row_count;
		if($row_count>0)
		{
			$output= '<table class="table table-bordered table-striped">
						<tr>
							<th>Serial</th>
							<th>Name</th>
							<th>Username</th>
							<th>Image</th>
							<th>Status</th>
							<th>Action</th>
						</tr>';

			$i=0;

			foreach ($result as $value) 
			{
				$i++;
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive img-circle images" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive img-circle images" />';
				}

				$status= '';

				date_default_timezone_set("Asia/Dhaka");

				$current_timestamp= strtotime(date('Y-m-d H:i:s').'-10 second');

				$converted_timestamp= date('Y-m-d H:i:s', $current_timestamp);

				$user_last_activity= $this->fetchUserLastActivity($value['id']);

				if($user_last_activity>$converted_timestamp)
				{
					
					$status='<span class="table_online_status">Online</span>';
				} 
				else
				{
					$status='<span class="table_offline_status">Offline</span>';
				}

				$output = $output.'<tr>
									<td class="table-secondary">'.$i.'</td>
									<td>'.$value["name"].'</td>
									<td class="table-secondary">'.$value["username"].' '.$this->countUnseenMessage($value['id'], $logged_in_id).' '.$this->fetchTypingStatus($value['id']).'</td>
									<td>'.$profile_image.'</td>
									<td class="table-secondary">'.$status.'</td>
									<td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$value["id"].'" data-tousername="'.$value["username"].'">
									<i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> Start Chat
								</button></td>
								</tr>';

			}
			$output = $output.'</table>';
		}
		else
		{
			$output= '<td colspan="6"><h5 class="no_result">Whoops!!! No User Found...</h5></td>';
		}
		return $output;
	}

	public function updateLastActivity()
	{
		$sql= "update users_login_info set last_activity=now() where users_login_info_id='".$_SESSION["users_login_info_id"]."'";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	}

	public function fetchUserLastActivity($id)
	{
		$sql= "select * from users_login_info where user_id='$id' order by last_activity desc limit 1";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	    $all= $result->fetchAll();
	    foreach ($all as $value) 
	    {
	    	return $value['last_activity'];
	    }

	}

	public function paginationForShowingUsers($logged_in_id)
	{
		$sql= "select * from users where id !=$logged_in_id";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	    $result->fetchAll();
		//print_r($result);
		$row_count= $result->rowCount();
	    return $row_count;
	}

	public function toShowStatus($status)
	{

		date_default_timezone_set("Asia/Dhaka");

		$current_timestamp= strtotime(date('Y-m-d H:i:s').'-10 second');
		$converted_timestamp= date('Y-m-d H:i:s', $current_timestamp);

		$user_last_activity= $this->fetchUserLastActivity($value['id']); 
		if($user_last_activity>$converted_timestamp)
		{
			$status='<span class="table_online_status">Online</span>';

		} 
		else
		{
			$status='<span class="table_offline_status">Offline</span>';
		}
	}

	public function showActiveUsers($logged_in_id)
	{
		$output= '';

		$sql="select * from users 
				inner join users_login_info 
				on users_login_info.user_id=users.id 
				where id != $logged_in_id and last_activity > DATE_SUB(NOW(), INTERVAL 5 SECOND) order by last_activity desc";
		//echo $sql; 
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		//print_r($result);
		$row_count= $stmt->rowCount();
		//echo "string ". $row_count;
		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$status= '';

				date_default_timezone_set("Asia/Dhaka");

				$current_timestamp= strtotime(date('Y-m-d H:i:s').'-10 second');
				$converted_timestamp= date('Y-m-d H:i:s', $current_timestamp);

				$user_last_activity= $this->fetchUserLastActivity($value['id']); 
				if($user_last_activity>$converted_timestamp)
				{
					$status='<span class="table_online_status">Online</span>';
				} 
				else
				{
					$status='<span class="table_offline_status">Offline</span>';
				}

				$output = $output.'
					<div class="row users">
						<div class="col-md-4">
						'.$profile_image.'
						</div>
						<div class="col-md-8">
							<h4> <b>#'.$value["username"].'</b></h4><p>'.$value["bio"].'</p>'.$status.'
							<button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$value["id"].'" data-tousername="'.$value["username"].'">
									<i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> Start Chat
							</button>
						</div>
					</div><div class="under_users"></div>';

			}			
		}
		else
		{
			$output= '<h5 class="no_result">Whoops!!! No Active User Found...</h5>';
		}
		return $output;
	}

		public function paginationForShowingActiveUsers($logged_in_id)
	{

		$sql= "select * from users where id != $logged_in_id order by id desc";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	    //$result->fetchAll();
		//print_r($result);
		$row_count= $result->fetchColumn();
		//echo $row_count;
	    return $row_count;
	    
	}

	public function chat($logged_in_id)
	{
		$sql= "insert into messages(to_user_id, from_user_id, message, status) values('".$_POST["to_user_id"]."','".$logged_in_id."','".$_POST["chat_message"]."', 1)";
		$result= dbConnection::myPrepareMethod($sql);
	    if($result->execute())
	    {
	    	return $this->fetchUserChatHistory($logged_in_id, $_POST['to_user_id']);
	    }
	}

	public function fetchUserChatHistory($from_user_id, $to_user_id)
	{
		$output= '';

		$sql= "select * from messages where (from_user_id='".$from_user_id."' and to_user_id='".$to_user_id."')
			 or (from_user_id='".$to_user_id."' and to_user_id='".$from_user_id."') order by timestamp desc";

		$result= dbConnection::myPrepareMethod($sql);
	    $result->execute();
	    $all= $result->fetchAll();

	    $output= '<ul class="list-unstyled">';

	    foreach ($all as $value) 
	    {
	    	$username= '';
	    	$dynamic_background= '';
	    	$chat_message= '';

	    	if($value["from_user_id"] == $from_user_id)
	    	{
	    		if($value["status"] == 2)
	    		{
	    			$chat_message= '<em style="color: tomato;">This message has been removed</em>';
	    			$username= '<b class= "text-success">You</b>';
	    		}
	    		else
	    		{
	    			$chat_message= $value["message"];
	    			$username= '<button type="button" class="btn btn-sm btn-outline-danger py-0 remove_chat" style="font-size: 0.8em;" title="remove" id="'.$value["message_id"].'">x</button> <b class= "text-success">You</b>';
	    		}

	    		$dynamic_background= 'background-color:#ffe6e6;';	    		
	    	}
	    	else
	    	{
	    		if($value["status"] == 2)
	    		{
	    			$chat_message= '<em style="color: tomato;">This message has been removed</em>';
	    		}
	    		else
	    		{
	    			$chat_message= $value["message"];
	    		}

	    		$username= '<b class= "text-danger">'.$this->getUsername($value['from_user_id']).'</b>';
	    		$dynamic_background= 'background-color:#ffffe6;';
	    	}
	    	$output = $output.'
	    		<li style="border-bottom: 1px dotted #ccc; padding:8px 8px 0 8px;'.$dynamic_background.' ">
	    			<p>'.$username.' - '.$chat_message.'
	    				<div align="right">
	    					- <small><em>'.$value['timestamp'].'</em></small>
	    				</div>
	    			</p>
	    		</li>
	    	';
	    }
	    $output = $output.'</ul>';

	    $update= "update messages set status= '0' where from_user_id='".$to_user_id."' and to_user_id= '".$from_user_id."' and status= '1'";
	    $update_stmt= dbConnection::myPrepareMethod($update);
	    $update_stmt->execute();

	    return $output;

	}

	public function getUsername($user_id)
	{
		$sql= "select username from users where id='".$user_id."'";
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();

		foreach ($result as $value) 
		{
			return $value["username"]; 
		}
	}

	public function fetchMessage($logged_in_id)
	{
		return $this->fetchUserChatHistory($logged_in_id, $_POST['to_user_id']); 
	}

	public function countUnseenMessage($from_user_id, $to_user_id)
	{
		$output= '';

		$sql= "select * from messages where from_user_id = '$from_user_id' and to_user_id='$to_user_id' and status= '1'";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();

	    $rows= $result->rowCount();
	    if($rows>0)
	    {
	    	$output= '<span class="unseen_msg">'.$rows.'</span>';
	    }
	    return $output;

	}

	public function typingActivated($logged_in_id)
	{
		$sql= "update users_login_info set typing='".$_POST['is_typing']."' where users_login_info_id= '".$_SESSION['users_login_info_id']."'";
		$result= dbConnection::myPrepareMethod($sql);
	    $result->execute();
	}

	public function fetchTypingStatus($user_id)
	{
		$output= '';

		$sql= "select typing from users_login_info where user_id= '".$user_id."' order by last_activity desc limit 1";
		$result= dbConnection::myPrepareMethod($sql);
	    $result->execute();
	    $all= $result->fetchAll();

	    foreach ($all as $value) {
	    	
	    	if($value["typing"] == 'yes')
	    	{
	    		$output= ' - <small><em><span class="text-success">Typing...</span></em></small>';
	    	}
	    }
	    return $output;
	}

	public function groupChat($logged_in_id)
	{
		$sql= "insert into messages(from_user_id, message, status) values('".$logged_in_id."','".$_POST["group_chat_message"]."', 1)";
		$result= dbConnection::myPrepareMethod($sql);
	    if($result->execute())
	    {
	    	return $this->fetchGroupChatHistory($logged_in_id);
	    }
	}

	public function fetchGroupChatHistory($from_user_id)
	{
		$output= '';

		$sql= "select * from messages where to_user_id='0' order by timestamp desc";

		$result= dbConnection::myPrepareMethod($sql);
	    $result->execute();
	    $all= $result->fetchAll();

	    $output= '<ul class="list-unstyled">';

	    foreach ($all as $value) 
	    {
	    	$username= '';
	    	$dynamic_background= '';
	    	$chat_message= '';

	    	if($value["from_user_id"] == $from_user_id)
	    	{
	    		if($value["status"] == 2)
	    		{
	    			$chat_message= '<em style="color: tomato;">This message has been removed</em>';
	    			$username= '<b class= "text-success">You</b>';
	    		}
	    		else
	    		{
	    			$chat_message= $value["message"];
	    			$username= '<button type="button" class="btn btn-sm btn-outline-danger py-0 remove_chat" style="font-size: 0.8em;" title="remove" id="'.$value["message_id"].'">x</button> <b class= "text-success">You</b>';
	    		}
	    		
	    		$dynamic_background= 'background-color:#ffe6e6;';
	    	}
	    	else
	    	{
	    		if($value["status"] == 2)
	    		{
	    			$chat_message= '<em style="color: tomato;">This message has been removed</em>';
	    		}
	    		else
	    		{
	    			$chat_message= $value["message"];
	    		}

	    		$username= '<b class= "text-danger">'.$this->getUsername($value['from_user_id']).'</b>';
	    		$dynamic_background= 'background-color:#ffffe6;';
	    	}
	    	$output = $output.'
	    		<li style="border-bottom: 1px dotted #ccc; padding:8px 8px 0 8px;'.$dynamic_background.' ">
	    			<p>'.$username.' - '.$chat_message.'
	    				<div align="right">
	    					- <small><em>'.$value['timestamp'].'</em></small>
	    				</div>
	    			</p>
	    		</li>
	    	';
	    }
	    $output = $output.'</ul>';

	    // $update= "update messages set status= '0' where from_user_id='".$to_user_id."' and to_user_id= '".$from_user_id."' and status= '1'";
	    // $update_stmt= dbConnection::myPrepareMethod($update);
	    // $update_stmt->execute();

	    return $output;

	}

	public function fetchGroupMessage($logged_in_id)
	{
		return $this->fetchGroupChatHistory($logged_in_id); 
	}

	public function removeMessage()
	{
		$sql= "update messages set status= '2' where message_id='".$_POST["chat_message_id"]."'";
	    $result= dbConnection::myPrepareMethod($sql);
	    $result->execute();
	}

	public function search($logged_in_id)
	{

		$query="select * from users where username like '%".$_POST['query']."%' and id != $logged_in_id";
		$stmt= dbConnection::myPrepareMethod($query);
		$stmt->execute();
		$result= $stmt->fetchAll();
		//print_r($result);
		$row_count= $stmt->rowCount();

		$output= '';

		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$status= '';

				date_default_timezone_set("Asia/Dhaka");

				$current_timestamp= strtotime(date('Y-m-d H:i:s').'-10 second');
				$converted_timestamp= date('Y-m-d H:i:s', $current_timestamp);

				$user_last_activity= $this->fetchUserLastActivity($value['id']); 
				if($user_last_activity>$converted_timestamp)
				{
					$status='<span class="table_online_status">Online</span>';
				} 
				else
				{
					$status='<span class="table_offline_status">Offline</span>';
				}

				$output= $output.'
					<div class="row users">
						<div class="col-md-4">
						'.$profile_image.'
						</div>
						<div class="col-md-8">
							<h4> <b>#'.$value["username"].'</b></h4><p>'.$value["bio"].'</p>'.$status.'
							<button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$value["id"].'" data-tousername="'.$value["username"].'">
									<i class="fa fa-comments-o fa-lg" aria-hidden="true"></i> Start Chat
							</button>
						</div>
					</div><div class="under_users"></div>';
			}
			return $output.'<div class="under_search"></div>';
		}
		else
		{ ?>
			<h5 class="no_result"> Whoops !!! no related data found ...</h5>
		<?php }		
	}

	//navbar search to get whole details of users
	public function navbarSearchToGetWholeDetailsOfAnUser($logged_in_id)
	{
		$sql= "select username from users where username like '%".$_POST['query_type']."%' and id != $logged_in_id";

		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();

		foreach ($result as $value) 
		{
			$data[]= $value["username"]; //it stores all username data under this $data variable in a re-format
		}
		return json_encode($data); //it will convert data in json format and send to ajax request

	}

	public function navbarSearchDetails($logged_in_id)
	{
		$output= '';

		$sql= "select * from users where username='".$_GET["data"]."'";
		//"data" get from scripts_using_ajax_jquery file
		$stmt= dbConnection::myPrepareMethod($sql);
		$stmt->execute();
		$result= $stmt->fetchAll();
		$row_count= $stmt->rowCount();
		//echo "string ". $row_count;
		if($row_count>0)
		{
			foreach ($result as $value) 
			{
				$profile_image= '';

				if($value['image'] != '')
				{
					$profile_image= '<img src="'.$value["image"].'" class="img-thumbnail img-responsive" />';
				}
				else
				{
					$profile_image= '<img src="images/user.png" class="img-thumbnail img-responsive" />';
				}

				$status= '';

				date_default_timezone_set("Asia/Dhaka");

				$current_timestamp= strtotime(date('Y-m-d H:i:s').'-10 second');
				$converted_timestamp= date('Y-m-d H:i:s', $current_timestamp);

				$user_last_activity= $this->fetchUserLastActivity($value['id']); 
				if($user_last_activity>$converted_timestamp)
				{
					$status='<span class="table_online_status">Online</span>';
				} 
				else
				{
					$status='<span class="table_offline_status">Offline</span>';
				}

				$output= $output.'
					<div class="mycard">
						<form action="" method="POST" enctype="multipart/form-data" class="form_label">
			                <div class="form-group">
							    <label for="name">Your name</label>
								<input type="text" id="name" name="name" class="form-control" readonly value="'.$value["name"].'"/ >
							</div>
							<div class="form-group">
							    <label for="username">Username</label>
								<input type="text" id="username" name="username" class="form-control" readonly value="'.$value["username"].'"/ >
							</div>
							<div class="form-group">
							    <label for="email">Email address</label>
								<input type="text" id="email" name="email" class="form-control" readonly value="'.$value["email"].'"/ >
							</div>
							<div class="form-group">
							    <label for="image">Image</label>
							    <div class="col-md-3">
							    	'.$profile_image.'							
							    </div>
							</div>
							<div class="form-group">
							    <label for="bio">Biodata</label>
							    <textarea id="bio" name="bio" class="form-control" readonly>'.$value["bio"].'</textarea>
								
							</div>						
			            </form>
			            
		            	<button type="button" class="btn btn-success btn-xs okay">
							<i class="fa fa-check-square-o fa-lg" aria-hidden="true"></i> Okay
						</button>
						
		            </div>';
			}
		}
		else
		{
			$output= '<h5 class="no_result">Whoops!!! No Profile Found...</h5>';
		}
		return $output;
	}

}
?>