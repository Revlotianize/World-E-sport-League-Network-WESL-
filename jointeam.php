<?php

	session_start();
  include("wesl.core.functions.php");
	$team_id = isset($_GET['t_id']) ? $_GET['t_id'] : 0;
	if(!isset($_SESSION['user_email'])){
		include("template/splash.php");
	}
	else {
    if($team_id==0){
      header("Location: home.php");
    } else {
      addUserInTeam($team_id);
    }
  }
?>
