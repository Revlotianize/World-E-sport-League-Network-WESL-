<?php 	

	session_start();
	if(!isset($_SESSION['user_email'])){
		header("location:index.php");
	}
	else {
			
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $lang['PAGE_TITLE']; ?></title>
		<link rel="stylesheet" type="text/css" href="styles/main.css">
		<link rel="stylesheet" type="text/css" href="styles/ui.css">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
<body>
	<nav>
		<ul>
		<?php showMenu(); ?>
		</ul>
	</nav>
	<header>
		<?php include("template/search.html"); ?>
		<h3>World <font color="darkorange">e</font>Sports League Network</h3>
	</header>
	<main>
		<aside>
			<ul>
			<?php userDetails(); ?>
			</ul>
		</aside>
		<section>
			<article>
				<h3><?php echo $lang['CONTENT_TIMELINE_TITLE']; ?></h3>
				<hr />
				<?php insertPost(); ?>
			</article>
			<article>
				<h3><?php echo $lang['HOME_CONTENT_TITLE']; ?></h3>
				<hr />
				<?php getPosts(); ?>
			</article>
		</section>
		<?php include("template/footer.html"); ?>
	</main>		
</body>
</html>
<?php } ?>