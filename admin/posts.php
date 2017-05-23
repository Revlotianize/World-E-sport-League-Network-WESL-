<?php

	echo "		<table align='center' width='850'>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Author</th>
					<th>Topic</th>
					<th>Post Preview</th>
					<th>Comments</th>
					<th>Date</th>
				</tr>";
	
	$select_users = "select * from posts ORDER by 1 DESC";
	$run_users = mysqli_query($con, $select_users);
	
		while($row_posts = mysqli_fetch_array($run_users)){
			
			$post_id 			= $row_posts['post_id'];
			$user_id 			= $row_posts['user_id'];
			$topic_id 			= $row_posts['topic_id'];
			$post_title 		= $row_posts['post_title'];
			$post_content 		= substr($row_posts['post_content'],0 ,25);
			$post_date 			= $row_posts['post_date'];
			
			$post_content = $post_content . "...";
			
			$count_comments = "select * from comments where post_id='$post_id'";
			$run_comments = mysqli_query($con, $count_comments);
			
			$comments = mysqli_num_rows($run_comments);
			
			$get_topic = "select topic_title from topics where topic_id='$topic_id'";
			$title = mysqli_query($con, $get_topic);
			
			$row=mysqli_fetch_array($title);
			
				$topic_title = $row['topic_title'];
				
			$get_user = "select user_name from users where user_id='$user_id'";
			$user = mysqli_query($con, $get_user);
			
			$row=mysqli_fetch_array($user);
			
				$user_name = $row['user_name'];
	
	
		echo "	<tr align='center'>
					<td>$post_id</td>
					<td><a href='index.php?edit_post&p_id=$post_id'>$post_title</a></td>
					<td><a href='index.php?edit_user&u_id=$user_id'>$user_name ($user_id)</a></td>
					<td>$topic_title ($topic_id)</td>
					<td><a href='../single.php?post_id=$post_id'>$post_content</a></td>
					<td>$comments</td>
					<td>$post_date</td>
				</tr>";
		}
		
		echo "	</table>";
	
?>	