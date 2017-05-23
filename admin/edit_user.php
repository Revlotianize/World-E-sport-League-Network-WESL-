	<?php 
	
	if(isset($_GET['u_id'])){
		
		$user_id = $_GET['u_id'];
		
		$select_user = "select * from users where user_id='$user_id'";
		$run_user = mysqli_query($con, $select_user);
		$row_user = mysqli_fetch_array($run_user);
			
			$user_id 			= $row_user['user_id'];
			$user_name 			= $row_user['user_name'];
			$user_image 		= $row_user['user_image'];
			$status 			= $row_user['status'];
			$auth				= $row_user['auth'];
			$first_name 		= $row_user['first_name'];
			$last_name 			= $row_user['last_name'];
			$user_country 		= $row_user['user_country'];
			$user_gender 		= $row_user['user_gender'];
			$user_bday 			= $row_user['user_bday'];
			$last_login 		= $row_user['last_login'];
			$register_date 		= $row_user['register_date'];
			$user_email 		= $row_user['user_email'];
	
	
		echo "	<form action='' method='post' enctype='multipart/form-data'>
					<table>
						<tr>
							<td>Profile Image:</td>
							<td><a href='../images/user_images/$user_image'><img src='../images/user_images/$user_image' width='100' height='100'/></a></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>Delete User</td>
							<td>
								<div id='red_btn'>
									<a href='index.php?delete_user&u_id=$user_id'>Delete User</a>
								</div>
							</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						</tr>
						<tr>
							<td>ID:</td>
							<td><input type='text' name='u_id' value='$user_id'/></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
						<tr>
							<td>Username:</td>
							<td><input type='text' name='u_name' value='$user_name'/></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><input type='email' name='u_email' value='$user_email'/></td>
						</tr>
						<tr>
							<td>Status:</td>
							<td><input type='text' name='u_status' value='$status'/></td>
						</tr>
						<tr>
							<td>Auth:</td>
							<td><input type='text' name='u_auth' value='$auth'/></td>
						</tr>
						<tr>
							<td>First Name:</td>
							<td><input type='text' name='first_name' value='$first_name'/></td>
						</tr>
						<tr>
							<td>Last Name:</td>
							<td><input type='text' name='last_name' value='$last_name'/></td>
						</tr>
						<tr>
							<td>Country:</td>
							<td><input type='text' name='u_country' value='$user_country'/></td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td><input type='text' name='u_gender' value='$user_gender'/></td>
						</tr>
						<tr>
							<td>Birth Date:</td>
							<td>
								<div id='date'><input type='date' name='u_bday' value='$user_bday'/></div>
							</td>
						</tr>
						<tr>
							<td>Last Login:</td>
							<td><input type='text' name='last_login' value='$last_login'/></td>
						</tr>
						<tr>
							<td>Register Date:</td>
							<td><input type='text' name='register_date' value='$register_date'/></td>
						</tr>
						<tr>
							<td>Profile Image:</td>
							<td>
								<div id='file'><input type='file' name='u_image' value='$user_image'/></div>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<button name='update'>Update User</button>
							</td>
						</tr>
					</table>
				</form>";
	}
	
	if(isset($_POST['update'])){
				
		$u_id			= $_POST['u_id'];
		$u_name			= $_POST['u_name'];
		$u_email 		= $_POST['u_email'];
		$u_status 		= $_POST['u_status'];
		$u_auth 		= $_POST['u_auth'];
		$first_name 	= $_POST['first_name'];
		$last_name 		= $_POST['last_name'];
		$u_country 		= $_POST['u_country'];
		$u_gender 		= $_POST['u_gender'];
		$u_bday 		= $_POST['u_bday'];
		$u_image 		= $_FILES['u_image']['name'];
		$image_tmp 		= $_FILES['u_image']['tmp_name'];
				
		move_uploaded_file($image_tmp,"../images/user_images/$u_image");
				
			if(empty($_FILES['u_image']['name'])){
				$u_image = $user_image;
			}
					
			$update = "update users set user_id='$u_id', user_name='$u_name', user_email='$u_email', status='$u_status', auth='$u_auth', first_name='$first_name', last_name='$last_name', user_country='$u_country', user_gender='$u_gender', user_bday='$u_bday', last_login='$last_login', register_date='$register_date', user_image='$u_image' where user_id='$user_id'";	
			$run = mysqli_query($con, $update);
					
				if($run){
						
					echo "<meta http-equiv='refresh' content='0'>";
				}
	}	
	
	?>