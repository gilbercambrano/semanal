<?php
	session_start() ;

	include_once("Sesion.php");

	$sesion = new Sesion();

	$sesion->updateSalida($_SESSION['id_session']);
	//print_r($_SESSION) ;


	session_destroy();

	header("Location: ../index.php");
?>