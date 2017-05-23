<?php

	echo "		<table align='center' width='850'>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Image</th>
					<th>Email</th>
					<th>Country</th>
					<th>Gender</th>
					<th>Birthday</th>
					<th>Last Login</th>
					<th>Register Date</th>
					<th>Status</th>
					<th>Auth</th>
				</tr>";
	
	$select_users = "select * from users ORDER by 1 DESC";
	$run_users = mysqli_query($con, $select_users);
	
		while($row_users = mysqli_fetch_array($run_users)){
			
			$user_id 			= $row_users['user_id'];
			$user_name 			= $row_users['user_name'];
			$user_image 		= $row_users['user_image'];
			$user_email 		= $row_users['user_email'];
			$user_country 		= $row_users['user_country'];
			$user_gender 		= $row_users['user_gender'];
			$user_bday 			= $row_users['user_bday'];
			$last_login 		= $row_users['last_login'];
			$register_date 		= $row_users['register_date'];
			$status 			= $row_users['status'];
			$auth 				= $row_users['auth'];
	
	
		echo "	<tr align='center'>
					<td>$user_id</td>
					<td><a href='index.php?edit_user&u_id=$user_id'>$user_name</a></td>
					<td><a href='../images/user_images/$user_image'><img src='../images/user_images/$user_image' width='30' height='30'/></a></td>
					<td>$user_email</td>
					<td>$user_country</td>
					<td>$user_gender</td>
					<td>$user_bday</td>
					<td>$last_login</td>
					<td>$register_date</td>
					<td>$status</td>
					<td>$auth</td>
				</tr>";
		}
		
		echo "	</table>";
	
?>	