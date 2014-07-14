<?php
	session_start();
	
	if(!empty($_SESSION)) {

	
		header("location:index_frentes.php");
	}
else{
	header("Location: ../index.php");
}
?>