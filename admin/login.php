<?php 

	session_start();
	include("connect.php");
	
?>

<!DOCTYPE html>

<html>
	<head>
	<title>WeSL ACP</title>
	<link rel="stylesheet" href="css/login.css" media="all"/>
	</head>
	
	<body>
		<div class="container">
			<div id="head">
				<h2>WeSL ACP Login</h2>
			</div>
			<div id="content">
					<form method="post" action="">
						<input type="email" name="email" placeholder="Email" required="required"/>
						<input type="password" name="pass" placeholder="Password" required="required"/>
						<button name="login">Login</button>
					</form>
					
					<?php
					
						#Level required for admin login
						$level = "1";
					
						if(isset($_POST['login'])){
							
							$email 	= $_POST['email'];
							$pass 	= $_POST['pass'];
							
							$get_admin = "select * from users where user_email='$email' AND user_pass='$pass'";
							
							$run_admin = mysqli_query($con, $get_admin);
							$row = mysqli_fetch_array($run_admin);
					
								$auth	= $row['auth'];
							
							if($auth != $level){
								echo "<div id='error'>Authentication Error $auth</font></div>";
							}
							else {
								$_SESSION['admin_email']=$email;
								echo "<meta http-equiv='refresh' content='0; URL=index.php?users'>";
							}
						}
					
					?>
			</div>
		</div>
	</body>
</html>