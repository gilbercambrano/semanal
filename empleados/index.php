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
	$deduccion_prestamo_semanal		= new DeduccionPrestamoSemanal();
	$bonificacion_semanal 			= new BonificacionSemanal();
	$database 						= new Database();
	
	set_time_limit(0);

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
	window.onload = detectarCarga;
		function detectarCarga(){
   			document.getElementById("loading").style.display="none";
		}
	</script>

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


		<div id="content">
			
			
			<div id="page">
				<div class="inner">
					<div class="form">
					<div class="tittle">
						Empleados
						</div>

<!-- INIIO ANIMACION DE LOADING -->

						<div id="loading" style="margin-top:40px;">
							<center>
							<img src="../images/smt.gif">
							<br>
							<br>
							<img src="../images/loading.gif" >
							<br>
							<br>
							<strong style="font-size:18px; font-weight:bold;">
							Creando lista de empleados...
							<br>
							Espere un momento por favor
							</strong>
							</center>
						</div>

						<!-- FIN ANIMACION DE LOADING -->
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
											<th width="90">Bonificaciones</th>
											<th width="80">Acciones</th>
										</tr>
										<?php
										$line = 1 ;
												
											$conexion = $database->getConexion();

										
												
													$sql = "select * from empleados
															join empleados_puestos as ep
																on empleados.id_empleado = ep.id_empleado
															join periodos as p
																on p.id_periodo = ep.id_periodo
															where ep.estatus='ACTIVO' 
																and p.nombre='SEMANAL'
																and (empleados.estatus='LABORANDO' OR empleados.estatus='ASPIRANTE' )
																AND empleados.id_empleado!=356
													 		order by apellido_paterno asc";





												
												$resultado = mysql_query($sql, $conexion);
												$contador = 0 ;
												while ($res = mysql_fetch_assoc($resultado) ){
													
													$empleado->loadById($res['id_empleado']);
													
													if( $empleado_nomina_frente_semanal->loadByEmpleado($empleado->getId()) > 0) {
														//echo ++$contador .'<br>' ;
													$nomina_frente_semanal->loadById($empleado_nomina_frente_semanal->getNominaFrente());
													$frente_trabajo->loadById($nomina_frente_semanal->getFrenteTrabajo());
												//}
										//	}

												$val = ($line % 2 == 0)  ? "par": "impar" ;
												?>
												<input type="hidden" name=<?php echo $empleado->getId()."_empleado"; ?> value=<?php echo $empleado->getId();?> >
												<input type="hidden" name=<?php echo $empleado->getId()."_nomina"; ?> value=<?php echo $empleado->getId(); ?> >
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
														<input disabled  type="checkbox" <?php if($empleado_nomina_frente_semanal->getLunes()==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_lunes";?> id=<?php echo "lunes_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input disabled  type="checkbox" <?php if($empleado_nomina_frente_semanal->getMartes()==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_martes";?> id=<?php echo "martes_".$empleado->getId();?>>
													</td>
													<td align="center">
														<input disabled  type="checkbox" <?php if($empleado_nomina_frente_semanal->getMiercoles()==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_miercoles";?> id=<?php echo "miercoles_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input disabled  type="checkbox" <?php if($empleado_nomina_frente_semanal->getJueves()==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_jueves";?> id=<?php echo "jueves_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input disabled  type="checkbox" <?php if($empleado_nomina_frente_semanal->getViernes()==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_viernes";?> id=<?php echo "viernes_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input disabled  type="checkbox" <?php if($empleado_nomina_frente_semanal->getSabado()==1) echo "checked='checked'"; ?> name=<?php echo $empleado->getId()."_sabado";?> id=<?php echo "sabado_".$empleado->getId();?>>
													</td>
													<td align="center">
														<input disabled  type="checkbox" <?php if($empleado_nomina_frente_semanal->getDomingo()==1) echo "checked='checked'"; ?>  name=<?php echo $empleado->getId()."_domingo";?> id=<?php echo "domingo_".$empleado->getId();?> >
													</td>
													<td align="center">
														<input disabled style="text-align:right; color:#000000;" disabled size="5" type="text" name=<?php echo $empleado->getId()."_deduccion";?> value=
															<?php 
																$deducciones = $deduccion_prestamo_semanal->loadByEmpleadoNomina($empleado->getId());
																$monto_deducciones = 0 ;
																foreach ($deducciones as $ded) {
																	$monto_deducciones += $ded['monto'] ;
																}
																echo number_format($monto_deducciones, 2) ;
														 	?> >
													</td>
													<td>
														<input disabled value=
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($empleado->getId());
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

														<input disabled value= 
														<?php
															$b = $bonificacion_semanal->loadByEmpleadoNominaFrente($empleado->getId());
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
															<a href=<?php echo "cambia_frente_empleado.php?id_nomina=".$empleado->getId(); ?> ><img src="../css/layout/site/tables/precontract.png" title="Cambiar de frente" ></a>
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
										//}
										?>

									</table>
									</center>
								</div>
								</fieldset>
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