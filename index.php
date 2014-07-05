<?php
	session_start();
	if(!empty($_SESSION['username']) && !empty($_SESSION['role']))
	{
		header('location:home.php');
	}
	else
	{
		header('location:login.php');
	}
?>