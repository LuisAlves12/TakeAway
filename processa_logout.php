<?php
include "css.php";
	session_start();
	$_SESSION['login']="incorreto";
	header("refresh:5;url=index.php");
	if(!isset($_SESSION['login'])){
		$_SESSION['login']="incorreto";
	}
	if($_SESSION['login']=="correto" && isset($_SESSION['login'])){

	}
	else{
		echo'Logout';
		header("refresh:2;url=index.php");
	}