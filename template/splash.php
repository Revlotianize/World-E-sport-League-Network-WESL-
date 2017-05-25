<?php
	$teamId = isset($team_id) ? $team_id : 0;
?>
<!DOCTYPE html>
<html>
	<head>
		<title>WeSL</title>
		<link rel="stylesheet" href="styles/splash.css" media="all"/>
	</head>

<body>
	<!-- container start -->
	<div class="container">
		<!-- head wrap start -->
		<div id="head_wrap">
			<!-- header start -->
			<div id="header">
				<a href="https://wesl.one">World eSports League Network</a>
				<form method="post" action="" id="form1">
					<?php login($teamId); ?>
					<input type="email" name="email" placeholder="Email" required="required"/>
					<input type="password" name="pass" placeholder="Password" required="required"/>
					<button name="login">Login</button>
				</form>
			</div>
			<!-- header end -->
		</div>
		<!-- head wrap end -->
		<!-- content start -->
		<div id="content">
			<div>
				<img src="images/splash.jpg" style="float:left;width:50%;"/>
			</div>
			<div id="form2">
				<?php
					if($teamId != 0){
						nonUserJoinTeam($teamId);
					}
				?>
				<form action="" method="post">
				<?php newUser($teamId); ?>
					<table>
						<tr>
							<td></td>
							<td><h2>Sign Up</h2></td>
						</tr>
						<tr>
							<td>Username:</td>
							<td><input type="text" name="u_name" placeholder="Username" required="required"/></td>
						</tr>
						<tr>
							<td>Password:</td>
							<td><input type="password" name="u_pass" placeholder="Password" required="required"/></td>
						</tr>
						<tr>
							<td>Repeat Password:</td>
							<td><input type="password" name="u_pass2" placeholder="Password" required="required"/></td>
						</tr>
						<tr>
							<td>Email:</td>
							<td><input type="email" name="u_email" placeholder="Email" required="required"/></td>
						</tr>
						<tr>
							<td>Country:</td>
							<td>
								<select name="u_country"/>
									<option>Germany</option>
									<option>United States</option>
									<option>...</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Gender:</td>
							<td>
								<select name="u_gender"/>
									<option>Male</option>
									<option>Female</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Birth Date:</td>
							<td>
								<input type="date" name="u_bday"/>
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<button name="sign_up">Sign Up</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		 <!-- content end -->
	</div>
	<!-- container end -->
</body>
</html>
