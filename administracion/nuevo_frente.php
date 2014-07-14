
<?php
	include_once("../library/Menu.php");
	include_once("../library/ActivoSector.php");
	include_once("../library/FrenteTrabajo.php");
	include_once("../library/NominaGeneralSemanal.php");
	include_once("../library/NominaFrenteSemanal.php");

	$menu 						= new Menu();
	$activo_sector 		 		= new ActivoSector();
	$frente_trabajo 			= new FrenteTrabajo();
	$nomina_general_semanal		= new NominaGeneralSemanal();
	$nomina_frente_semanal 		= new NominaFrenteSemanal();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css"  />
	<link rel="stylesheet" type="text/css" href="/css/dialog_box.css" />
	<script type="text/javascript" src="/js/dialog_box.js"></script>
	<link href="../css/ui-lightness/jquery-ui-1.9.2.custom.css" rel="stylesheet">
	<script src="../js/jquery-1.8.3.js"></script>
	<script src="../js/jquery-ui-1.9.2.custom.js"></script>

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
						Registro de frentes de trabajo
						</div>
						<form class="formulario" method="POST">
							<fieldset> 
								<legend>Datos del frente de trabajo</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Nombre:
										</td>
										<td>
											<input type="text" name="nombre" class="box" required>
										</td>
									</tr>

									<tr>
										<td class="lab">
											Activo:
										</td>
										<td>
											<?php
												$activos = $activo_sector->loadAll();
												//print_r($activos);
											?>
											<select name="id_activo_sector" class="drop2">
												<?php

													foreach ($activos as $value) {
														?>
															<option value=<?php echo $value['id_activo_sector']; ?> > <?php echo $value['nombre']; ?> </option>
														<?php
													}
												?>
											</select>
										</td>
									</tr>

									
								</table>
							</fieldset>
							
							<div class="btn_submit">
								<br>
								<input type="submit" value="Guardar">
							</div>

						</form>
						</div>

						<?php
						if(!empty($_POST)){
							$_POST ['nombre'] = strtoupper($_POST['nombre']);
							$id_frente_trabajo = $frente_trabajo->insert($_POST) ;
							
								$nomina_general_semanal->loadByActivo();

								$res = $nomina_frente_semanal->insert($nomina_general_semanal->getId(), $id_frente_trabajo);
								if($res > 0){
									?>
									<script type="text/javascript">
										alert("Frente agregado correctamente");
										window.location="index_frentes.php"
									</script>
									<?php
								}
								
						
						}
						?>
					

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