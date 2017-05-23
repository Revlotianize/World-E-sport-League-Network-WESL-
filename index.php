<?php 
	
	session_start();
	include("wesl.core.functions.php");
	if(isset($_SESSION['user_email'])){
		include("home.php");
	}
	else {
		include("template/splash.html");
	}
?>


		 
