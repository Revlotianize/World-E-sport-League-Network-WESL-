<?php 	

	session_start();
	include("connect.php");
	if(!isset($_SESSION['admin_email'])){
		header("location:login.php");
	}
	else {
		
?>

<!DOCTYPE html>

<html>
	<head>
	<title>WeSL ACP</title>
	<link rel="stylesheet" href="css/admin.css" media="all"/>
	</head>
	
	<body>
		<div class="container">
			<div id="head">
				<form method="get" action="search.php" id="search">
					<input type="text" name="query" placeholder="search query"/>
					<button>Search</button>
				</form>
				<div id="menu">
					<ul>
						<li><a href="index.php?users">Users</a></li>
						<li><a href="index.php?posts">Posts</a></li>
						<li><a href="index.php?comments">Comments</a></li>
						<li><a href="index.php?topics">Topics</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</div>
			</div>
			<div id="content">
			<?php
			
			if(isset($_GET['users'])){
				include("users.php");
				exit;
			}
			if(isset($_GET['edit_user'])){
				include("edit_user.php");
				exit;
			}
			if(isset($_GET['delete_user'])){
				include("delete_user.php");
				exit;
			}
			if(isset($_GET['posts'])){
				include("posts.php");
				exit;
			}
			if(isset($_GET['edit_post'])){
				include("edit_post.php");
				exit;
			}
			if(isset($_GET['delete_post'])){
				include("delete_post.php");
				exit;
			}
			else {
				include("stats.php");
			}
	
			?>
			</div>
		</div>
	</body>
</html>
<?php } ?>