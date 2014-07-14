<?php
	session_start();
	
	if(!empty($_SESSION)) {
		?>

<html>
<head>
	<meta http-equiv="Refresh" content="0;url=nomina_semanal_frente.php">
</head>
<body>
</body>
</html>
<?php
}
else{
	header("Location: ../index.php");
}
?>