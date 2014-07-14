<?php
	session_start();
	
	if(!empty($_SESSION)) {

	include_once("../library/Menu.php");
	include_once("../library/FrenteTrabajo.php");
	include_once("../library/ActivoSector.php");

	$menu = new Menu();
	$frente_trabajo = new FrenteTrabajo();
	$activo_sector = new ActivoSector();

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
								
								<li class="last"><a href="../library/session_close.php">Salir</a></li>
							</ul>
						</li>
					</ul>

					<div id="search_wrapper">
						<form action="../empleados/empleado_result.php" method="get">
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
						Frentes de Trabajo
						</div>
						<div id="link_frentes">
							<a href="nuevo_frente.php">Agregar Frente de Trabajo</a>
						</div>
						<br>

								<div class="tabla_frentes" style="clear:both; margin-top:10px;">
									<center>
										<?php

										$frentes = $frente_trabajo->loadAll();
										//$activos = $activo_sector->loadAll();

										?>
										<br>
									<table width="950" class="frentes">
										<tr>
										<th>Id</th>
											<th>Frente</th>
											<th>Activo/Sector</th>
										<!--	<th width="80">Acciones</th>	-->
										</tr>

										<?php
										$cont = 0 ;
											foreach ($frentes as $value) {
												$val = ($cont % 2 == 0)  ? "par": "impar" ;
												?>
												<tr class=<?php echo $val ?> >
												<td>
														<?php echo $value['id_frente_trabajo']; ?>
													</td>
													<td>
														<?php echo $value['nombre']; ?>
													</td>
													<td>
														<?php 
															$activo_sector->loadById($value['id_activo_sector']); 
															echo $activo_sector->getNombre();
														?>
													</td>
													<!--	<td></td> 	-->
												</tr>
												<?php
												$cont ++ ;
											}

										?>

									</table>
									</center>

								</div>




						</div>
					

				</div>







			</div>

			<div id="sidebar-menu">
				<?php
					echo $menu->printMenuAdministracion();
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