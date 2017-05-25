<?php

	session_start();
  include("wesl.core.functions.php");
	if(!isset($_SESSION['user_email'])){
		header("location:index.php");
	}
	else {
    $team_id = isset($_GET['t_id']) ? $_GET['t_id'] : 0;
    if($team_id==0){
      header("Location: home.php");
    } else {
      addUserInTeam($team_id);
    }
  }
?>
