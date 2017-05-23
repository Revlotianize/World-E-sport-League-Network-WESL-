<?php include("connect.php");

	if(isset($_GET['p_id'])){
		
		$post_id = $_GET['p_id'];
			
		$get_post = "select * from posts where post_id='$post_id'";
		$run_post = mysqli_query($con, $get_post);
		$row=mysqli_fetch_array($run_post);
					
				$post_id		= $row['post_id'];
				$post_title		= $row['post_title'];
				$post_content 	= $row['post_content'];
				$post_date 		= $row['post_date'];

		echo "	<h3><a href='index.php?edit_post&p_id=$post_id'>$post_title</a> ($post_date)</h3>
				<p>$post_content</p>
				<form action='' method='post'>
					<button name='delete'>Delete Post and all comments</button>
					<a href='index.php?edit_post&p_id=$post_id'>Cancel</a>
				</form>";
	}
	
		if(isset($_POST['delete'])){
			
			$post_id = $_GET['p_id'];
			
			$del_posts = "delete from posts where post_id='$post_id'";
			$run_posts = mysqli_query($con, $del_posts);
			
			$del_comments = "delete from comments where post_id='$post_id'";
			$run_comments = mysqli_query($con, $del_comments);
			
			echo "<div id='delete'>Post was deleted!</div>";
			echo "<meta http-equiv='refresh' content='3, URL=index.php?posts'/>";
		}
	
?>