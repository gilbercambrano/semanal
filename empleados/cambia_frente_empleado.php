<?php
	session_start();
	
	if(!empty($_SESSION)) {

		
	include_once("../library/Menu.php");
	include_once("../library/Estado.php");
	include_once("../library/Municipio.php");
	include_once("../library/Empleado.php");
	include_once("../library/Clinica.php");
	include_once("../library/DetalleDireccion.php");
	include_once("../library/CuentaBancaria.php");
	include_once("../library/Compania.php");
	include_once("../library/EmpleadoNominaFrenteSemanal.php");
	include_once("../library/FrenteTrabajo.php");
	include_once("../library/NominaFrenteSemanal.php");
	include_once("../library/CompaniaEmpleado.php");
	include_once("../library/EmpleadoPuesto.php");

	$menu 							= new Menu();
	$estado 						= new Estado();
	$municipio 						= new Municipio();
	$empleado 						= new Empleado();
	$clinica 						= new Clinica();
	$detalle_direccion 				= new DetalleDireccion();
	$cuenta_bancaria 				= new CuentaBancaria();
	$compania 						= new Compania();
	$empleado_nomina_frente_semanal	= new EmpleadoNominaFrenteSemanal();
	$frente_trabajo 				= new FrenteTrabajo();
	$nomina_frente_semanal 			= new NominaFrenteSemanal();
	$compania_empleado 				= new CompaniaEmpleado();
	$empleado_puesto 				= new EmpleadoPuesto();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css"  />
	<link rel="stylesheet" type="text/css" href="/css/dialog_box.css" />
	<script type="text/javascript" src="/js/dialog_box.js"></script>

</head>
<body id="item1">
	<div id="wrapper">
		<div id="head">
			<div id="logo_user_details">
				<h1 id="logo"><a href="#">Sistema de Nómina de SMT</a></h1>
				<div id="user_details">
					<ul id="user_details_menu">
						<li>Bienvenido <strong></strong></li>
						<li>
							<ul id="user_access">
								<!--<li class="first"><a href="#">Mi cuenta</a></li>-->
								<li class="last"><a href="../library/session_close.php">Salir</a></li>
							</ul>
						</li>
					</ul>

					<div id="search_wrapper">
						<form action="empleado_result.php" method="get">
							<fieldset>
								<label>
									<input class="text" name="buscar" type="text"/>
								</label>
								<span class="go"><input name="" type="submit" /></span>
							</fieldset>
						</form>						 
					</div>
				</div>
			</div>
			<div id="menus_wrapper">


				<?php
					echo $menu->printMainManu();
				?>
				
			</div>
		</div>

		<div id="content">
						<div id="page">
				<div class="inner">
					<div class="form">
						<div class="tittle">
							Empleados
						</div>
						<form class="formulario" method="POST">
							<fieldset> 
								<legend>Seleccione el frente de trabajo al que se adscribirá el empledo</legend>
								<center>
									<br><br>
									<?php
										$frentes = $frente_trabajo->loadAll();

									?>
							<select  class="drop2" name="frente" >
								<?php

									foreach ($frentes as $value) {
										?>
										<option value=<?php echo $value['id_frente_trabajo']; ?> > <?php echo $value['nombre']; ?> </option>
										<?php
									}

								?>
							</select>
							<input type="hidden" name="id_nomina" value=<?php echo $_GET['id_nomina']; ?> >
							<?php 
								if(isset($_GET['source']) && $_GET['source']=='search'){
									?>
									<input type="hidden" value=<?php echo "'". $_GET['get'] ."'" ; ?> name="get" id="get" >
									<?php
								}
								else if(isset($_GET['frente'])) {
							 ?>
								<input type="hidden" name="frente_red" id="frente_red" value=<?php echo $_GET['frente']; ?> >							
							<?php
								}
							?>

							</center>
							<br>
							<br>
							<div class="btn_submit">
								<input type="submit" value="Guardar">
							</div>
							</fieldset>
						</form>

						<?php
							if(!empty($_POST) ){
								if (!isset($_POST['get'])){
								$nomina_frente_semanal->loadByFrente($_POST['frente']);
							//$empleado_nomina_frente_semanal->loadById($_POST['id_nomina']);
							//$nuevo_cambio = array();
							//$nuevo_cambio['id_nomina_frente'] = $nomina_frente_semanal->getId();
							//$nuevo_cambio['id_empleado_nomina_frente_semanal'] = $_POST['id_nomina'];

							$empleado_nomina_frente_semanal->updateFrente( $_POST['id_nomina'],  $nomina_frente_semanal->getId());

							//$empleado_nomina_frente_semanal->updateFrente($nuevo_cambio);
							?>
							<script type="text/javascript">
							
							window.location = "asistencia_semanal.php?frente="+document.getElementById("frente_red").value;
						</script>
						<?php
							//header("location: asistencia_semanal.php?frente=".$_POST['frente_red']);
							}
							else{
							$nomina_frente_semanal->loadByFrente($_POST['frente']);
						//$empleado_nomina_frente_semanal->loadById($_POST['id_nomina']);
						//$nuevo_cambio = array();
						//$nuevo_cambio['id_nomina_frente'] = $nomina_frente_semanal->getId();
						//$nuevo_cambio['id_empleado_nomina_frente_semanal'] = $_POST['id_nomina'];

						$empleado_nomina_frente_semanal->updateFrente( $_POST['id_nomina'],  $nomina_frente_semanal->getId());
						?>
						<script type="text/javascript">

							
							window.location = "empleado_result.php?buscar="+document.getElementById("get").value;
						</script> 
						<?php
						//header("location: empleado_result.php?buscar=".$_POST['get']);
						}
						}
						
					?>

					</div>
					

				</div>
			</div>

			<div id="sidebar-menu">
				<?php
					
					echo $menu->printMenuEmpleados();
				?>
			</div>

		</div>
	</div>
</body>

</html>
<?php
}
else{
	header("Location: ../index.php");
}
?>