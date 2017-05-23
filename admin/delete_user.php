<?php include("connect.php");

	if(isset($_GET['u_id'])){
		
		$user_id = $_GET['u_id'];
			
		$get_user = "select * from users where user_id='$user_id'";
		$run_user = mysqli_query($con, $get_user);
		$row=mysqli_fetch_array($run_user);
					
				$user_id	= $row['user_id'];
				$user_name	= $row['user_name'];
				$user_image = $row['user_image'];

		echo "	<img src='../images/user_images/$user_image' width='100' height='100'>
				<h3><a href='../user_profile.php?u_id=$user_id'>$user_name</a></h3>
				<form action='' method='post'>
					<button name='delete'>Delete User <b>$user_name</b>, User Posts and Comments</button>
					<a href='index.php?edit_user&u_id=$user_id'>Cancel</a>
				</form>";
	}
	
		if(isset($_POST['delete'])){
			
			$user_id = $_GET['u_id'];
			
			$delete = "delete from users where user_id='$user_id'";
			$run_delete = mysqli_query($con, $delete);
			
			$del_posts = "delete from posts where user_id='$user_id'";
			$run_posts = mysqli_query($con, $del_posts);
			
			$del_comments = "delete from comments where user_id='$user_id'";
			$run_comments = mysqli_query($con, $del_comments);
			
			echo "<div id='delete'>User was deleted!</div>";
			echo "<meta http-equiv='refresh' content='3, URL=index.php?users'/>";
		}
	
?>