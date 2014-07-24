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
	include_once("../library/Database.php");

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
	$deduccion_semanal		= new DeduccionSemanal();
	$bonificacion_semanal 			= new BonificacionSemanal();
	$database 						= new Database();


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
			//alert("salario_"+empleado);
			var bonificacion_dias = "bonificacion_dias_" + empleado ;
			var bonificacion_monto = "bonificacion_monto_" + empleado ;
			var salario = document.getElementById("salario_"+empleado).value ;
			var dias = document.getElementById(bonificacion_dias).value ;
			var monto = dias * salario ;
			
			document.getElementById(bonificacion_monto).value = monto.toFixed(2) ;
		}

		function calculaDias(empleado){
			//alert("salario_"+empleado);
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
							$deduccion = array() ;
							foreach ($_POST as $key => $value) {


								$informacion = explode("_", $key);
								if($informacion[0]=="buscar"){
									$informacion[0] = $_GET['buscar'] ; 
									$informacion[1] = 'buscar' ; 
								}
								$pos_ = strpos($key, '_');
								$tam = strlen($key);
								$cadena = substr($key, $pos_ +1 );
								/*print_r($informacion) ;
								echo "<br><br>"; */

								if( is_numeric($informacion[0]) ){
									$empleado_nomina_frente_semanal->loadByEmpleado($informacion[0]);
								}
								
								



								/**
								DEDUCCIONES
								*/
											
											//echo $cadena['deduccion'] . "gilber" ;
											if($cadena=='deduccion' ){

												$arreglo_deduccion['descripcion'] = 'Deduccion RH' ;
												$arreglo_deduccion['estatus'] = 'PENDIENTE' ;
												$arreglo_deduccion['monto'] = $value ;
												$arreglo_deduccion['id_empleado_nomina_frente_semanal'] = $empleado_nomina_frente_semanal->getId();

												if($deduccion_semanal->loadByEmpleadoNomina($empleado_nomina_frente_semanal->getId())==1){
													$deduccion_semanal->update($arreglo_deduccion);
												}

												else if ($value>0){
													$deduccion_semanal->insert($arreglo_deduccion);
												}
											}
								/**
								DEDUCCIONES
								*/



								if($cadena == 'empleado' ) {
									$monto_total = 0 ;
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

										
										/* if(!empty($b)){
											$arreglo_nominas['monto'] +=$b['monto'];
										} */
										$monto_total += $arreglo_nominas['monto'];

										//print_r($arreglo_nominas);
										//echo "<br><br>";
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
										
									/*	if(!empty($b)){
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






										

										?>
										<script type="text/javascript">
										alert("Asistencia guardada exitosamente");
										</script>
										<?php
						


						}
						#INICIO CALCULO DE MONTOS DE NOMINAS DE FRENTES 
						/* 
						$emp_nom_frent = new EmpleadoNominaFrenteSemanal();
						$nominas=$nomina_frente_semanal->loadByActivo_();
										
										foreach ($nominas as $value) {
											$monto_nomina= 0 ;
											$empleados_nominas = $emp_nom_frent->loadByNominaFrenteSemanal($value['id_nomina_frente_semanal']);
											foreach ($empleados_nominas as $item) {
												$monto_nomina+=$item['monto'] ;
												$bonificaciones=$bonificacion_semanal->loadByEmpleadoNominaFrente($item['id_empleado_nomina_frente_semanal']);
												if(!empty($bonificaciones)){
													$monto_nomina+=$bonificaciones['monto'];
												}
											}
											$nomina_frente_semanal->loadById($value['id_nomina_frente_semanal']);
											$nomina_frente_semanal->update(array(
																	'id_nomina_frente_semanal'=>$value['id_nomina_frente_semanal'],
																	'monto'=>$monto_nomina,
																	'observaciones'=>$nomina_frente_semanal->getObservaciones(),
																	'estatus'=>$nomina_frente_semanal->getEstatus()
																	));


										}		*/
						?>


		<div id="content">
			
			
			<div id="page">
				<div class="inner">
					<div class="form">
					<div class="tittle">
						Resultado de la búsqueda
						</div>


						<center>
						<form class="tabla_empleado" method="POST">
							<br>
							<fieldset>

								<legend>Empleados</legend>
								<div class="tabla_emp">
									<center>
										
									<table width="950" class="empleados">
										<tr>
											<th width="30">Clave</th>
											<th>Nombre</th>
											<th width="30">Cía</th>
											<th>Frente</th>
											<th width="25">Lun</th>
											<th width="25">Mar</th>
											<th width="25">Mié</th>
											<th width="25">Jue</th>
											<th width="25">Vie</th>
											<th width="25">Sáb</th>
											<th width="25">Dom</th>
											<th width="80">Deducciones</th>
											<th width="100">Bonificaciones</th>
											<th width="110">Acciones</th>
										</tr>
										<?php
										$line = 1 ;
										if(!empty($_GET) ){
											


											$conexion = $database->getConexion();

												if(is_numeric($_GET['buscar'])){
													$sql = "select * from empleados 
													join empleados_nominas_frentes_semanal on empleados_nominas_frentes_semanal.id_empleado = empleados.id_empleado
													where empleados.estatus = 'LABORANDO' 
													and empleados_nominas_frentes_semanal.estatus = 'REVISADA'
													and empleados.id_empleado=".$_GET['buscar'];
												}
												else{
												$sql = "select * from empleados
														join empleados_nominas_frentes_semanal on empleados_nominas_frentes_semanal.id_empleado = empleados.id_empleado
														where 
														empleados.estatus='LABORANDO' and 
														(nombre like '%".$_GET['buscar']."%' 
														or apellido_paterno like '%".$_GET['buscar']."%' 
														or apellido_materno like '%".$_GET['buscar']."%' 
														or concat(nombre, ' ' , apellido_paterno, ' ' , apellido_materno) like '%".$_GET['buscar']."%' 
														 )
														and empleados_nominas_frentes_semanal.estatus = 'REVISADA'
														order by apellido_paterno
														";
														//echo $sql;
													}

												$resultado = mysql_query($sql, $conexion);

												while ($res = mysql_fetch_assoc($resultado)){

													$empleado->loadById($res['id_empleado']);
													//echo $empleado->getId();
													$empleado_nomina_frente_semanal->loadByEmpleado($empleado->getId());
													
													$nomina_frente_semanal->loadById($empleado_nomina_frente_semanal->getNominaFrente());
													$frente_trabajo->loadById($nomina_frente_semanal->getFrenteTrabajo());

												$val = ($line % 2 == 0)  ? "par": "impar" ;
												?>
												<input type="hidden" name=<?php echo $empleado->getId()."_empleado"; ?> value=<?php echo $empleado->getId();?> >
												<input type="hidden" name=<?php echo $empleado_nomina_frente_semanal->getId()."_nomina"; ?> value=<?php echo $empleado_nomina_frente_semanal->getId(); ?> >
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
														<?php
															echo $frente_trabajo->getNombre();
														?>
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($empleado_nomina_frente_semanal->getLunes()==1) echo "checked='checked'"; ?> name=<?php echo $empleado_nomina_frente_semanal->getId()."_lunes";?> id=<?php echo "lunes_".$empleado_nomina_frente_semanal->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($empleado_nomina_frente_semanal->getMartes()==1) echo "checked='checked'"; ?> name=<?php echo $empleado_nomina_frente_semanal->getId()."_martes";?> id=<?php echo "martes_".$empleado_nomina_frente_semanal->getId();?>>
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($empleado_nomina_frente_semanal->getMiercoles()==1) echo "checked='checked'"; ?> name=<?php echo $empleado_nomina_frente_semanal->getId()."_miercoles";?> id=<?php echo "miercoles_".$empleado_nomina_frente_semanal->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($empleado_nomina_frente_semanal->getJueves()==1) echo "checked='checked'"; ?> name=<?php echo $empleado_nomina_frente_semanal->getId()."_jueves";?> id=<?php echo "jueves_".$empleado_nomina_frente_semanal->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($empleado_nomina_frente_semanal->getViernes()==1) echo "checked='checked'"; ?> name=<?php echo $empleado_nomina_frente_semanal->getId()."_viernes";?> id=<?php echo "viernes_".$empleado_nomina_frente_semanal->getId();?> >
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($empleado_nomina_frente_semanal->getSabado()==1) echo "checked='checked'"; ?> name=<?php echo $empleado_nomina_frente_semanal->getId()."_sabado";?> id=<?php echo "sabado_".$empleado_nomina_frente_semanal->getId();?>>
													</td>
													<td align="center">
														<input  type="checkbox" <?php if($empleado_nomina_frente_semanal->getDomingo()==1) echo "checked='checked'"; ?>  name=<?php echo $empleado_nomina_frente_semanal->getId()."_domingo";?> id=<?php echo "domingo_".$empleado_nomina_frente_semanal->getId();?> >
													</td>
													<td align="center">
														<input type="hidden" name="buscar" value=<?php echo "'".$_GET['buscar']."'"; ?> >
														<input style="text-align:right; color:#000000;" size="5" type="text" name=<?php echo $empleado->getId()."_deduccion";?> value=
															<?php 
																 if( $deduccion_semanal->loadByEmpleadoNomina($empleado_nomina_frente_semanal->getId())==1){
																 	$monto_deducciones = $deduccion_semanal->getMonto();
																 }
																 else{
																 	$monto_deducciones = 0 ;
																 }
																
																
																echo number_format( $monto_deducciones,2) ;
														 	?> > 
													</td>
													<td>
														<input value=
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($empleado_nomina_frente_semanal->getId());
															if(!empty($b))
																echo $b['numero_dias'] ;
															else
																echo "0.0";
														?> 
														type="text" 
														size="2" 
														title="Número de días" 
														name=<?php echo $empleado_nomina_frente_semanal->getId()."_bonificacion_dias"; ?> 
														id=<?php echo "bonificacion_dias_".$empleado_nomina_frente_semanal->getId();?> 
														onchange=<?php echo "calculaMonto(".$empleado_nomina_frente_semanal->getId().")"; ?> 
														>

														<input value= 
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($empleado_nomina_frente_semanal->getId());
															if(!empty($b))
																echo $b['monto'] ;
															else
																echo "0.0";
														?> 
														style="text-align:right;" 
														type="text" 
														size="5" 
														title="Monto a bonificar" 
														name=<?php echo $empleado_nomina_frente_semanal->getId()."_bonificacion_monto";?> 
														id=<?php echo "bonificacion_monto_".$empleado_nomina_frente_semanal->getId();?> 
														onchange=<?php echo "calculaDias(".$empleado_nomina_frente_semanal->getId().")"; ?> 
														>
															<?php  
																$empleado_puesto->loadByEmpleado($empleado->getId());
															?>
														<input  
															type 	="hidden" 
															id 		="<?php echo "salario_".$empleado_nomina_frente_semanal->getId();?>"
															value	="<?php echo $empleado_puesto->getSalario(); ?>"
															name 	="<?php echo $empleado_nomina_frente_semanal->getId()."_salario";?>"  >
														
													</td>
													<td align="center">
														<div class="menu-action">
														<div class="action">
															<a onclick=<?php echo "activarAll(".$empleado_nomina_frente_semanal->getId().")"; ?>><img src="../css/layout/site/tables/completed.png" title="Asistencia todos los días" ></a>
														</div>
														<div class="action">
															<a href=<?php echo "cambia_frente_empleado.php?source=search&get=". str_replace( ' ', '+', $_GET['buscar'])."&id_nomina=".$empleado_nomina_frente_semanal->getId(); ?> ><img src="../css/layout/site/tables/precontract.png" title="Cambiar de frente" ></a>
														</div>
														<div class="action">
															<a href=<?php echo "empleado.php?accion=update&id_empleado=".$empleado->getId(); ?> ><img src="../css/layout/site/tables/edit_action.gif" title="Editar empleado" ></a>
														</div>
														<div class="action">
															<a href=<?php echo "empleado.php?accion=delete&id_empleado=".$empleado->getId(); ?> ><img src="../css/layout/site/tables/delete.gif" title="Eliminar empleado" ></a>
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