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
	include_once("../library/DeduccionSemanal.php");
	include_once("../library/BonificacionSemanal.php");
	include_once("../library/NominaGeneralSemanal.php");

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
	$deduccion_semanal				= new DeduccionSemanal();
	$bonificacion_semanal			= new BonificacionSemanal();
	$nomina_general_semanal			= new NominaGeneralSemanal();
	//$emp_temp						= new Empleado();

	$nomina_general_semanal ->loadByActivo();
	/*$nominas_frentes = $nomina_frente_semanal->loadByNominaGeneralSemanal($nomina_general_semanal->getId());
	
	foreach ($nominas_frentes as $value) {
		$monto_nomina = 0 ;
		$empleados_nominas = $empleado_nomina_frente_semanal ->loadByNominaFrenteSemanal($value['id_nomina_frente_semanal']);
		foreach ($empleados_nominas as $item) {
			$monto_nomina+=$item['monto'] ;
			$bonificaciones=$bonificacion_semanal->loadByEmpleadoNominaFrente($item['id_empleado_nomina_frente_semanal']);
			if(!empty($bonificaciones)){
				$monto_nomina+=$bonificaciones['monto'];
				$empleado_nomina_frente_semanal->updateMonto($item['id_empleado_nomina_frente_semanal'], ($item['monto'] + $bonificaciones['monto'] ));
			}
		}

		$nomina_frente_semanal->loadById($value['id_nomina_frente_semanal']);
		$nomina_frente_semanal->update(array(
											'id_nomina_frente_semanal'=>$value['id_nomina_frente_semanal'],
											'monto'=>$monto_nomina,
											'observaciones'=>$nomina_frente_semanal->getObservaciones(),
											'estatus'=>$nomina_frente_semanal->getEstatus()
											));
	}

	$nomina_general_semanal ->updateMonto($nomina_general_semanal->getId(), round($nomina_frente_semanal ->getTotalNominasFrentes($nomina_general_semanal->getId()), $_SESSION['id_usuario']));
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css"  />


	<link rel="stylesheet" href="../css/ui-lightness/jquery-ui.css" />
    <script src="../js/jquery-1.8.3.js"></script>
    <script src="../js/jquery-ui.js"></script>


	<script type="text/javascript">

	</script>


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
						
						</div>

						
						<center>
							<a href="exporta_excel.php"><h2>Saldar Nómina</h2></a>
							<h3 style="color:#CC0000; font-size:14px;" > * Esta opción, exportará la nómina a un Libro de MS Excel. <br>Una vez generado el libro, no podrá modificar la información de ningún empleado respecto a su asistencia y bonificaciones.

							 </h3>
						<form class="tabla_empleado" method="POST">
							<fieldset>
								<legend>Resume de Nóminas por frente</legend>
								<div class="tabla_emp">

									<center>

										<?php
										$frentes = $frente_trabajo->loadAll();

										foreach ($frentes as $item) {
											echo "<h1>".$item['nombre']."</h1>";
											$nomina_frente_semanal->loadByFrente($item['id_frente_trabajo']);
											$empleados_nominas = $empleado_nomina_frente_semanal->loadByNominaFrenteSemanal($nomina_frente_semanal->getId());
												

										?>
									<table width="950" class="empleados">
										<tr>
											<th width="60">Clave</th>
											<th>Nombre</th>
											<th width="30">Compañía</th>
											<th width="30">Lun</th>
											<th width="30">Mar</th>
											<th width="30">Mié</th>
											<th width="30">Jue</th>
											<th width="30">Vie</th>
											<th width="30">Sáb</th>
											<th width="30">Dom</th>
											<th width="80">Deducciones</th>
											<th colspan="2">Bonificaciones</th>
											<th width="80">Monto</th>
										</tr>
										<?php
										$line = 1 ;
											foreach ($empleados_nominas as $value) {
												if($value['monto']>0){
												
												$empleado->loadById($value['id_empleado']);
												$compania_empleado->loadByEmpleado($empleado->getId());
												$val = ($line % 2 == 0)  ? "par": "impar" ;
												?>
												<input type="hidden" name=<?php echo $empleado->getId()."_empleado"; ?> value=<?php echo $empleado->getId();?> >
												<input type="hidden" name=<?php echo $value['id_empleado_nomina_frente_semanal']."_nomina"; ?> value=<?php echo $value['id_empleado_nomina_frente_semanal']; ?> >
												<tr class=<?php echo $val ?>>
													<td>
														<?php
														echo $empleado->getId();
														?>
													</td>
													<td>
														<?php
														echo $empleado->getNombreCompleto($empleado->getId());
														?>
													</td>
													<td>
														<?php
														echo $empleado->getCompaniaEmpleado($empleado->getId());
														?>
													</td>
													<td>
														<input disabled="disabled" type="checkbox" <?php if($value['lunes']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_lunes";?> id=<?php echo "lunes_".$empleado->getId();?> >
														
													</td>
													<td>
														<input disabled="disabled" type="checkbox" <?php if($value['martes']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_martes";?> id=<?php echo "martes_".$empleado->getId();?>>
														
													</td>
													<td>
														<input disabled="disabled" type="checkbox" <?php if($value['miercoles']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_miercoles";?> id=<?php echo "miercoles_".$empleado->getId();?> >
														
													</td>
													<td>
														<input disabled="disabled" type="checkbox" <?php if($value['jueves']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_jueves";?> id=<?php echo "jueves_".$empleado->getId();?> >

													</td>
													<td>
														<input disabled="disabled" type="checkbox" <?php if($value['viernes']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_viernes";?> id=<?php echo "viernes_".$empleado->getId();?> >
														
													</td>
													<td>
														<input disabled="disabled" type="checkbox" <?php if($value['sabado']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_sabado";?> id=<?php echo "sabado_".$empleado->getId();?>>
														
													</td>
													<td>
														<input disabled="disabled" type="checkbox" <?php if($value['domingo']==1) echo "checked='checked'"; ?>  name=<?php echo $empleado->getId()."_domingo";?> id=<?php echo "domingo_".$empleado->getId();?> >
														
													</td>






													<td align="center">

															<?php

																 if( $deduccion_semanal->loadByEmpleadoNomina($value['id_empleado_nomina_frente_semanal'])==1){
																 	$monto_deducciones = $deduccion_semanal->getMonto();
																 }
																 else{
																 	$monto_deducciones = 0 ;
																 }
																
																
																echo number_format( $monto_deducciones,2) ;
														 	?>  
													</td>
													<td title="Días">
														
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($value['id_empleado_nomina_frente_semanal']);
															if(!empty($b))
																echo $b['numero_dias'] ;
															else
																echo "0.0";
														?> 
														

														</td>
														<td title="Monto">
															<center>
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($value['id_empleado_nomina_frente_semanal']);
															$monto_bon = 0.0 ;
															if(!empty($b)){
																$monto_bon = $b['monto'] ;
															}
															echo number_format( $monto_bon, 2 ) ;
														?> 
														</center>
														

														<input type="hidden" value=<?php echo $empleado_puesto->getSalario(); ?> name=<?php echo $empleado->getId()."_salario";?> id=<?php echo "salario_".$empleado->getId();?>  >
														
													</td>




													<td align="center">
														<?php echo number_format(  (($value['monto'] + $monto_bon) - $monto_deducciones), 2) ;?>
													</td>

												</tr>
												<?php
												$line ++ ;
												}
											}
										//}
										?>

									</table>
									<?php
									}
									?>
									</center>
								</div>
								</fieldset>
							<div class="btn_submit">	
							<!--	<input type="submit" value="Guardar"> -->
							</div>
						</form>



						</center>
						</div>
					

				</div>
			</div>


			<div id="sidebar-menu">
				<?php
					echo $menu->printMenuNominas();
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