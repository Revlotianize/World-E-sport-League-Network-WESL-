	<?php 
	
	if(isset($_GET['p_id'])){
		
		$post_id = $_GET['p_id'];
		
		$select_post = "select * from posts where post_id='$post_id'";
		$run_post = mysqli_query($con, $select_post);
		$row_post = mysqli_fetch_array($run_post);
			
			$post_id 			= $row_post['post_id'];
			$user_id 			= $row_post['user_id'];
			$topic 				= $row_post['topic_id'];
			$post_title 		= $row_post['post_title'];
			$post_content 		= $row_post['post_content'];
			$post_date 			= $row_post['post_date'];
			
		$get_topic = "select topic_title from topics where topic_id='$topic'";
		$title = mysqli_query($con, $get_topic);
			
			$row=mysqli_fetch_array($title);
			
				$topic_title = $row['topic_title'];
				
		$get_user = "select user_name from users where user_id='$user_id'";
		$user = mysqli_query($con, $get_user);
			
			$row=mysqli_fetch_array($user);
			
				$user_name = $row['user_name'];
	
		echo "	<form action='' method='post'>
						<h3><a href='index.php?edit_user&u_id=$user_id'>$user_name</a> ($post_date)</h3>
						<div id='red_btn'>
							<a href='index.php?delete_post&p_id=$post_id'>Delete Post</a>
						</div>
						<br />
						<input type='text' name='post_title' value='$post_title'/> <a href='../single.php?post_id=$post_id'>View Post</a>
						<br />
						<textarea cols='100' rows='20' type='text' name='post_content'>$post_content</textarea>
						<br />
						<select name='topic_id'>
								<option selected='$topic_title'>$topic_title</option>";
					
								$get_topics = "select * from topics";
								$run_topics = mysqli_query($con, $get_topics);
										
								while($row=mysqli_fetch_array($run_topics)){
								
								$topic_id		= $row['topic_id'];
								$topic_title	= $row['topic_title'];
									
								echo "<option value='$topic_id'>$topic_title</a></option>";
								}
								
		echo "			</select>
					<button name='update'>Update Post</button>
				</form>";
	}
	
	if(isset($_POST['update'])){
				
		$title			= $_POST['post_title'];
		$content		= $_POST['post_content'];
		$topic_id		= $_POST['topic_id'];
		
		if($topic_id == 0){
					$topic_id = $topic;
				}
					
			$update = "update posts set post_title='$title', post_content='$content', topic_id='$topic_id' where post_id='$post_id'";	
			$run = mysqli_query($con, $update);
					
				if($run){
						
					echo "<meta http-equiv='refresh' content='0'>";
				}
	}	
	
	?>