<?php
	session_start();
	
	if (isset ($_COOKIE['pseudo']))
	{
		setcookie('pseudo', '', -1);
	}
	$_SESSION = array();
	session_destroy();
	
	header('location:login.php');
?>