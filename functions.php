<?php
	require("/home/gittkaus/config.php");
    session_start();
	
	$database = "if16_gittkaus_3";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	require("Class/Helper.class.php");
	$Helper = new Helper();
?>