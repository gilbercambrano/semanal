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
	include_once("../library/DeduccionPrestamoSemanal.php");
	include_once("../library/BonificacionSemanal.php");

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
	$deduccion_prestamo_semanal		= new DeduccionPrestamoSemanal();
	$bonificacion_semanal 			= new BonificacionSemanal();
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css"  />


	<link rel="stylesheet" href="../css/ui-lightness/jquery-ui.css" />
    <script src="../js/jquery-1.8.3.js"></script>
    <script src="../js/jquery-ui.js"></script>
    


	<script type="text/javascript">

		function activarAll(input){
			var lunes="lunes_"+input ;
			var martes ="martes_"+input;
			var miercoles ="miercoles_"+input ;
			var jueves ="jueves_"+input;
			var viernes ="viernes_"+input;
			var sabado ="sabado_"+input;
			var domingo ="domingo_"+input;

			document.getElementById(lunes).checked=1;
			document.getElementById(martes).checked=1;
			document.getElementById(miercoles).checked=1;
			document.getElementById(jueves).checked=1;
			document.getElementById(viernes).checked=1;
			document.getElementById(sabado).checked=1;
			document.getElementById(domingo).checked=1;
		}

		function calculaMonto(empleado){
			var bonificacion_dias = "bonificacion_dias_" + empleado ;
			var bonificacion_monto = "bonificacion_monto_" + empleado ;
			var salario = document.getElementById("salario_"+empleado).value ;
			var dias = document.getElementById(bonificacion_dias).value ;
			var monto = dias * salario ;
			document.getElementById(bonificacion_monto).value = monto.toFixed(2) ;
		}

		function calculaDias(empleado){
			var bonificacion_dias = "bonificacion_dias_" + empleado ;
			var bonificacion_monto = "bonificacion_monto_" + empleado ;
			var salario = document.getElementById("salario_"+empleado).value ;
			var monto = document.getElementById(bonificacion_monto).value ;
			var dias = monto / salario ;
			document.getElementById(bonificacion_dias).value = dias.toFixed(2) ;
		}

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

<?php
						if(!empty($_POST)){
							$monto_total = 0 ;
							$emp_nom_frent_semanal = new EmpleadoNominaFrenteSemanal();
							$bon_temp = new BonificacionSemanal();
							$empleado_nuevo = false ;
							$arreglo_nominas = array();
							foreach ($_POST as $key => $value) {

								$pos_ = strpos($key, '_');
								$tam = strlen($key);
								$cadena = substr($key, $pos_ +1 );
								//echo $cadena . " ----> " . $value ."<br>"  ;

								if($cadena == 'empleado' ) {
									if($empleado_nuevo){
										$arreglo_nominas['id_empleado_nomina_frente_semanal'] = $nomina ;
										$arreglo_nominas['estatus']= 'REVISADA';
										$arreglo_nominas['observaciones'] = '';
										$arreglo_nominas['lunes']=$dias_empleados['lunes'];
										$arreglo_nominas['martes']=$dias_empleados['martes'];
										$arreglo_nominas['miercoles']=$dias_empleados['miercoles'];
										$arreglo_nominas['jueves']=$dias_empleados['jueves'];
										$arreglo_nominas['viernes']=$dias_empleados['viernes'];
										$arreglo_nominas['sabado']=$dias_empleados['sabado'];
										$arreglo_nominas['domingo']=$dias_empleados['domingo'];
										$arreglo_nominas['monto']=round($dias_laborados * $empleado_puesto->getSalario());
										$b = $bon_temp->loadByEmpleadoNominaFrente($nomina);

										
										/*if(!empty($b)){
											$arreglo_nominas['monto'] +=$b['monto'];
										} */
										$monto_total += $arreglo_nominas['monto'];
										$emp_nom_frent_semanal->update($arreglo_nominas);
										
										$bonificacion['estatus'] = 'ACTIVO';
											$bonificaciones_existentes = $bonificacion_semanal->loadByEmpleadoNominaFrente($bonificacion['id_empleado_nomina_frente_semanal']) ;
											
											if( empty($bonificaciones_existentes) ){
												if($bonificacion['dias']>0 && $bonificacion['monto']>0){
													$bonificacion_semanal ->insert($bonificacion);
												}
											}
											else {
												$bonificacion['id_bonificacion_semanal'] = $bonificaciones_existentes['id_bonificacion_semanal'] ;
												  $bonificacion_semanal->update($bonificacion);
											}
										

									}
									$clave_empleado = $value ;
									$dias_empleados['lunes'] = 0 ;
									$dias_empleados['martes'] = 0 ;
									$dias_empleados['miercoles'] = 0 ;
									$dias_empleados['jueves'] = 0 ;
									$dias_empleados['viernes'] = 0 ;
									$dias_empleados['sabado'] = 0 ;
									$dias_empleados['domingo'] = 0 ;
									$dias_laborados = 0 ;
									$bonificacion= array();
									$bonificacion['descripcion'] ='';

									$empleado_puesto->loadByEmpleado($clave_empleado);

									$empleado_nuevo = true ;
								}
								if($empleado_nuevo && $cadena == 'nomina'){
									$nomina = $value ;
									$bonificacion['id_empleado_nomina_frente_semanal']= $nomina;
								}

								if($cadena != 'empleado' && $cadena != 'nomina' ){
									switch ($cadena) {
										case 'lunes':
											if($value == 'on'){
												$dias_empleados['lunes'] = 1 ;	
												$dias_laborados ++ ;
											}
											break;
										case 'martes':
											if($value == 'on'){
												$dias_empleados['martes'] = 1 ;	
												$dias_laborados ++ ;
											}
											break;
										case 'miercoles':
											if($value == 'on'){
												$dias_empleados['miercoles'] = 1 ;	
												$dias_laborados ++ ;
											}
											break;
										case 'jueves':
											if($value == 'on'){
												$dias_empleados['jueves'] = 1 ;	
												$dias_laborados ++ ;
											}
											break;
										case 'viernes':
											if($value == 'on'){
												$dias_empleados['viernes'] = 1 ;	
												$dias_laborados ++ ;
											}
											break;
										case 'sabado':
											if($value == 'on'){
												$dias_empleados['sabado'] = 1 ;	
												$dias_laborados ++ ;
											}
											break;
										case 'domingo':
											if($value == 'on'){
												$dias_empleados['domingo'] = 1 ;	
												$dias_laborados ++ ;
											}
											break;
										case 'bonificacion_monto':
											$bonificacion['monto'] = $value ;
											break;
										case 'bonificacion_dias':
											$bonificacion['dias'] = $value ;
											break;
									}
								}

							}
					
										$arreglo_nominas['id_empleado_nomina_frente_semanal'] = $nomina ;
										$arreglo_nominas['estatus']= 'REVISADA';
										$arreglo_nominas['observaciones'] = '';
										$arreglo_nominas['lunes']=$dias_empleados['lunes'];
										$arreglo_nominas['martes']=$dias_empleados['martes'];
										$arreglo_nominas['miercoles']=$dias_empleados['miercoles'];
										$arreglo_nominas['jueves']=$dias_empleados['jueves'];
										$arreglo_nominas['viernes']=$dias_empleados['viernes'];
										$arreglo_nominas['sabado']=$dias_empleados['sabado'];
										$arreglo_nominas['domingo']=$dias_empleados['domingo'];
										$arreglo_nominas['monto']=round($dias_laborados * $empleado_puesto->getSalario());
										$b = $bon_temp->loadByEmpleadoNominaFrente($nomina);
										
										/*if(!empty($b)){
											$arreglo_nominas['monto'] +=$b['monto'];
										} */
										$monto_total += $arreglo_nominas['monto'];
										$emp_nom_frent_semanal->update($arreglo_nominas);

										
											$bonificacion['estatus'] = 'ACTIVO';
											$bonificaciones_existentes = $bonificacion_semanal->loadByEmpleadoNominaFrente($bonificacion['id_empleado_nomina_frente_semanal']) ;
											
											if( empty($bonificaciones_existentes) ){
												if($bonificacion['dias']>0 && $bonificacion['monto']>0){
													$bonificacion_semanal ->insert($bonificacion);
												}
											}
											else {
												$bonificacion['id_bonificacion_semanal'] = $bonificaciones_existentes['id_bonificacion_semanal'] ;
												  $bonificacion_semanal->update($bonificacion);
											}
										
											/*
											
										$emp_nom_frent_semanal->loadById($nomina);
										
										//echo $emp_nom_frent_semanal->getNominaFrente() ;
										$nomina_frente_semanal->loadById($emp_nom_frent_semanal->getNominaFrente());
										$nomina_frente_semanal->update(array(
																	'id_nomina_frente_semanal'=>$nomina_frente_semanal->getId(),
																	'monto'=>$monto_total,
																	'observaciones'=>$nomina_frente_semanal->getObservaciones(),
																	'estatus'=>$nomina_frente_semanal->getEstatus()
																	));


										*/


										//echo $nomina_frente_semanal->getId();

										?>
										<script type="text/javascript">
										alert("Asistencia guardada exitosamente");
										</script>
										<?php
						}
						else{
							//echo "no existe";
						}
						?>


		<div id="content">
			
			
			<div id="page">
				<div class="inner">
					<div class="form">
					<div class="tittle">
						
						</div>

						<form class="formulario" method="GET">
							<!--	<a href="../nominas/nomina_export_excel.xls">Nomina</a> -->
							<fieldset> 
								<legend>Búsqueda por frente</legend>
								<center>
									<?php
										$frentes = $frente_trabajo->loadAll();

									?>
							<select  class="drop2" name="frente" >
								<?php

									foreach ($frentes as $value) {
										?>
										<option <?php if(!empty($_GET) and ($_GET['frente']==$value['id_frente_trabajo']) ) echo "selected='selected'"; ?> value=<?php echo $value['id_frente_trabajo']; ?> > <?php echo $value['nombre']; ?> </option>
										<?php
									}

								?>
							</select>
							</center>
							<br>
							<div class="btn_submit">
								<input type="submit" value="Cargar">
							</div>
							</fieldset>
						</form>
						<center>
						<form class="tabla_empleado" method="POST">
							<fieldset>
								<legend>Empleados</legend>
								<div class="tabla_emp">
									<center>
										<?php
											
											if(!empty($_GET)){
												$array_empleados = $empleado->loadByEstatus('LABORANDO');
												$nomina_frente_semanal->loadByFrente($_GET['frente']);
												$empleados_nominas = $empleado_nomina_frente_semanal->loadByNominaFrenteSemanal($nomina_frente_semanal->getId());
											}

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
											<th width="90">Bonificaciones</th>
											<th width="80">Acciones</th>
										</tr>
										<?php
										$line = 1 ;
										if(!empty($_GET) ){
											foreach ($empleados_nominas as $value) {
												$empleado->loadById($value['id_empleado']);
												$empleado_puesto->loadByEmpleado($empleado->getId());
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
													<td align="center">
														<input  type="checkbox" <?php if($value['lunes']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_lunes";?> id=<?php echo "lunes_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($value['martes']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_martes";?> id=<?php echo "martes_".$empleado->getId();?>>
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($value['miercoles']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_miercoles";?> id=<?php echo "miercoles_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($value['jueves']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_jueves";?> id=<?php echo "jueves_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($value['viernes']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_viernes";?> id=<?php echo "viernes_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($value['sabado']==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_sabado";?> id=<?php echo "sabado_".$empleado->getId();?>>
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($value['domingo']==1) echo "checked='checked'"; ?>  name=<?php echo $empleado->getId()."_domingo";?> id=<?php echo "domingo_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input style="text-align:right; color:#000000;" size="5" type="text" name=<?php echo $empleado->getId()."_deduccion";?> value=
															<?php 
																$deducciones = $deduccion_prestamo_semanal->loadByEmpleadoNomina($value['id_empleado_nomina_frente_semanal']);
																$monto_deducciones = 0 ;
																foreach ($deducciones as $ded) {
																	$monto_deducciones += $ded['monto'] ;
																}
																echo number_format($monto_deducciones, 2) ;
														 	?> >
													</td>
													<td>
														<input value=
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($value['id_empleado_nomina_frente_semanal']);
															if(!empty($b))
																echo $b['numero_dias'] ;
															else
																echo "0.0";
														?> 
														type="text" 
														size="2" 
														title="Número de días" 
														name=<?php echo $empleado->getId()."_bonificacion_dias";?> 
														id=<?php echo "bonificacion_dias_".$empleado->getId();?> 
														onchange=<?php echo "calculaMonto(".$empleado->getId().")"; ?> 
														>

														<input value= 
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($value['id_empleado_nomina_frente_semanal']);
															if(!empty($b))
																echo $b['monto'] ;
															else
																echo "0.0";
														?> 
														style="text-align:right;" 
														type="text" 
														size="5" 
														title="Monto a bonificar" 
														name=<?php echo $empleado->getId()."_bonificacion_monto";?> 
														id=<?php echo "bonificacion_monto_".$empleado->getId();?> 
														onchange=<?php echo "calculaDias(".$empleado->getId().")"; ?> 
														>

														<input type="hidden" value=<?php echo $empleado_puesto->getSalario(); ?> name=<?php echo $empleado->getId()."_salario";?> id=<?php echo "salario_".$empleado->getId();?>  >
														
													</td>
													<td align="center">
														<div class="menu-action">
														<div class="action">
															<a onclick=<?php echo "activarAll(".$empleado->getId().")"; ?>><img src="../css/layout/site/tables/completed.png" title="Activar todo" ></a>
														</div>
														<div class="action">
															<a href=<?php echo "cambia_frente_empleado.php?id_nomina=".$value['id_empleado_nomina_frente_semanal']."&frente=".$_GET['frente']; ?> ><img src="../css/layout/site/tables/precontract.png" title="Cambiar de frente" ></a>
														</div>
														</div>
													</td>

												</tr>
												<?php
												$line ++ ;
											}
										}
										?>

									</table>
									</center>
								</div>
								</fieldset>
							<div class="btn_submit">	
								<input type="submit" value="Guardar">
							</div>
						</form>



						</center>
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