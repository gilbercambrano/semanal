<?php
	session_start();
	
	if(!empty($_SESSION)) {

		
	include_once("../library/Menu.php");
	include_once("../library/Estado.php");
	include_once("../library/Municipio.php");
	include_once("../library/Empleado.php");
	include_once("../library/DetalleDireccion.php");
	include_once("../library/CuentaBancaria.php");
	include_once("../library/EmpleadoPuesto.php");
	include_once("../library/Localidad.php");
	include_once("../library/Clinica.php");
	include_once("../library/Compania.php");
	include_once("../library/AreaDepartamento.php");
	include_once("../library/Puesto.php");
	include_once("../library/FrenteTrabajo.php");
	include_once("../library/Periodo.php");
	include_once("../library/NominaFrenteSemanal.php");
	include_once("../library/EmpleadoNominaFrenteSemanal.php");
	include_once("../library/CompaniaEmpleado.php");



	$menu 				= new Menu();
	$estado 			= new Estado();
	$municipio 			= new Municipio();
	$empleado 			= new Empleado();
	$detalle_direccion	= new DetalleDireccion();
	$cuenta_bancaria	= new CuentaBancaria();
	$empleado_puesto	= new EmpleadoPuesto();
	$localidad 			= new Localidad();
	$clinica 			= new Clinica();
	$compania 			= new Compania();
	$area_departamento 	= new AreaDepartamento();
	$puesto 			= new Puesto();
	$frente_trabajo 	= new FrenteTrabajo();
	$periodo 			= new Periodo();
	$nomina_frente_semanal = new NominaFrenteSemanal();
	$empleado_nomina_frente_semanal = new EmpleadoNominaFrenteSemanal();
	$compania_empleado	= new CompaniaEmpleado();

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
		$(function (){
			$("#fecha_nacimiento").datepicker({
				changeYear: true,
				changeMonth: true,
				yearRange: "1930:2020",
				dateFormat:"yy-mm-dd",
				monthNamesShort:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				dayNamesMin:["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
			});

			$("#fecha_inicio").datepicker({
				changeYear: true,
				changeMonth: true,
				yearRange: "1930:2020",
				dateFormat:"yy-mm-dd",
				monthNamesShort:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				dayNamesMin:["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
			});
				    
		    $("#localidad").autocomplete({
		      minLength: 1,
		      delay: 0,
		      source: function(request, response) {
            $.ajax({
            url: "extraeLocalidades.php",
            dataType: "json",
            data: {
              term : request.term,
              id_municipio : $("#estado").val()
             },

             success: function(data) {
                 response(data);
                  }
                  });
                  },
                  select : function(event, ui){
		        document.getElementById("id_localidad").value = ui.item.id ;
		       
		       
		      }
             });
		      

		    });


		function changeMunicipio(){


			var	combo_municipios = document.getElementById("municipio");

		while(combo_municipios.length > 0)
		{
			combo_municipios.options[combo_municipios.options.length-1] = null;
		}

		var contador = 0;
		

			$.getJSON('extraeMunicipios.php',function (grupomunicipios){
				
				for (var i = 0; i < grupomunicipios.length; i++) {
				if (grupomunicipios[i].id_estado == document.getElementById("estado").value) 
				{
					combo_municipios.options[contador] = new Option();
					combo_municipios.options[contador].text = grupomunicipios[i].nombre;
					combo_municipios.options[contador].value = grupomunicipios[i].id_municipio;
					contador++;
				}
			}
				
			});

			changeClinica();
		}

		function changeClinica(){


			var	combo_clinicas = document.getElementById("clinica");

		while(combo_clinicas.length > 0)
		{
			combo_clinicas.options[combo_clinicas.options.length-1] = null;
		}

		var contador = 0;
		

			$.getJSON('extraeClinicas.php',function (grupoclinicas){
				
				for (var i = 0; i < grupoclinicas.length; i++) {
				if (grupoclinicas[i].id_estado == document.getElementById("estado").value) 
				{
					combo_clinicas.options[contador] = new Option();
					combo_clinicas.options[contador].text = grupoclinicas[i].nombre;
					combo_clinicas.options[contador].value = grupoclinicas[i].id_clinica;
					contador++;
				}
			}
				
			});
		}
	</script>
	
</head>










<body id="item1">
	<div id="wrapper">



		<!--   Encabezado del body  -->


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




		<!-- Fin  Encabezado del body  -->

		
		<div id="content">

			<div id="page">
				<div class="inner">


					<!--  Inicio del div form que contiene el formulario   -->


					<div class="form">


					<div class="tittle">
						Registro de empleados
						</div>

						<form class="formulario" method="GET">
							<fieldset>
								<legend>Búsqueda de registro</legend>
								<table class="tab_form">
									<tr>
									<td class="lab">Clave:</td>
									<td>
										<input type="text" name="id_empleado" class="box_search" title="Rellene este campo con la clave asignada del aspirante" >
										<input type="hidden" name="accion" value="busqueda" >
									</td>
									<td>
										<div class="btn_submit">
											<input type="submit" value="Buscar" >
										</div>
									</td>
									</tr>
								</table>
							</fieldset>
						</form>
							<?php
								if(isset($_GET['id_empleado']) && $_GET['id_empleado']!=''){
									if ($empleado->loadById($_GET['id_empleado'])){
										$detalle_direccion->loadById($empleado->getDetalleDireccion());
										$cuenta_bancaria->loadById($empleado->getCuentaBancaria());
										$empleado_puesto->loadByEmpleado($empleado->getId());
										$localidad->loadById($detalle_direccion->getLocalidad());

									}
									else{
										echo "<script type=\"text/javascript\" >";
										echo "alert(\"Registro no encontrado\");";
										echo "</script>";
									}
								}
							?>
						<form class="formulario" method="GET">
							<?php

								if(isset($_GET['accion']) && $_GET['accion'] == 'delete' ){
									$compania_empleado->loadByEmpleado($_GET['id_empleado']);
									$empleado_nomina_frente_semanal->loadByEmpleado($_GET['id_empleado']);
									?>
									<input type="hidden" name="id_empleado" value=<?php echo $empleado->getId(); ?> >

									<input type="hidden" name="id_compania_empleado" value=<?php echo $compania_empleado->getId(); ?> >
									<input type="hidden" name="accion" value="eliminar" > 
									<input type="hidden" name="id_empleado_nomina" value=<?php echo $empleado_nomina_frente_semanal->getId(); ?> >
									<?php
								}

								else if(isset($_GET['id_empleado']) and $_GET['accion'] !='insertar' ){
										if( $empleado->getEstatus()=='ASPIRANTE'){
											$cia = '' ;
											$en = '' ;
										}
										else{
											$cia =$compania_empleado->getId();
											$en = $empleado_nomina_frente_semanal->getId();
										}
									$compania_empleado->loadByEmpleado($_GET['id_empleado']);
									$empleado_nomina_frente_semanal->loadByEmpleado($_GET['id_empleado']);
									?>
									<input type="hidden" name="id_empleado" value=<?php echo $empleado->getId(); ?> >

									<input type="hidden" name="id_compania_empleado" value="<?php echo $cia ; ?>" >
									<input type="hidden" name="accion" value="actualizar" > 
									<input type="hidden" name="id_empleado_nomina" value="<?php echo $en; ?>" >
									<?php

								}
								else{
									?>
									<input type="hidden" name="accion" value="insertar" > 
									<?php

								}

							?>
							<fieldset> 
								<legend>Datos personales</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Nombre:
									</td>
										<td>
											<input type="text" name="nombre" required class="box"
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$empleado->getNombre()."'"; 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Apellido paterno:
									</td>
										<td>
											<input type="text" name="apellido_paterno" required class="box" 
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$empleado->getApellidoPaterno()."'"; 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Apellido materno:
									</td>
										<td>
											<input type="text" name="apellido_materno" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$empleado->getApellidoMaterno()."'"; 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Sexo:
									</td>
										<td>
											<select name="sexo" class="drop2">
												<option value="MASCULINO" <?php if($empleado->getSexo()=='MASCULINO') echo "selected='selected'"; ?> class="opdrop2">Masculino</option>
												<option value="FEMENINO" <?php if($empleado->getSexo()=='FEMENINO') echo "selected='selected'"; ?> class="opdrop2">Femenino</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Fecha de nacimiento:
									</td>
										<td>
											
											<input type="text" id="fecha_nacimiento" name="fecha_nacimiento" class="box"
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value=".$empleado->getFechaNacimiento(); 
													else 
														echo "value='0000-00-00'" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Tipo de Sangre:
									</td>
										<td>
											
											<input type="text" name="tipo_sangre" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$empleado->getTipoSangre()."'"; 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Teléfono fijo:
									</td>
										<td>
											
											<input type="text" name="telefono_fijo" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$empleado->getTelefonoFijo()."'"; 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>

									<tr>
										<td class="lab">
											Teléfono móvil:
									</td>
										<td>
											<input type="text" name="telefono_movil" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$empleado->getTelefonoMovil()."'"; 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>

									<tr>
										<td class="lab">
											Correo electrónico:
									</td>
										<td>
											<input type="text" name="email" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value=".$empleado->getEmail(); 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											I. F. E.:
									</td>
										<td>
											<input type="text" name="ife" class="box" 
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value=".$empleado->getIfe(); 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											C. U. R. P.:
									</td>
										<td>
											<input type="text" required maxlength="18" name="curp" class="box" 
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value=".$empleado->getCurp(); 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Licencia:
									</td>
										<td>
											<input type="text" name="licencia" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value=".$empleado->getLicencia(); 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Matrícula S. M. N.:
									</td>
										<td>
											<input type="text" name="matricula_smn" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value=".$empleado->getMatriculaSmn(); 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
								</table>
							</fieldset>







							
							
							<fieldset> 
								<legend>Datos de dirección</legend>

								<?php
								if(isset($_GET['id_empleado'])){
									 $detalle_direccion->loadById($empleado->getDetalleDireccion());
									 $localidad->loadById($detalle_direccion->getLocalidad());
									 $municipio->loadById($localidad->getM());
									 $estado->loadById($municipio->getEstado());
								}
								?>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Estado:
									</td>
										<td>
											<select name="estado" class="drop2" id="estado" onchange="changeMunicipio()">
												<option value="-1">Seleccione estado</option>
												<?php
													$estados = $estado->loadAll();
													foreach ($estados as $value) {
														?>
														<option value=<?php echo $value['id_estado']; ?> 
															<?php 
																if(isset($_GET['id_empleado'])){
																	if($value['clave'] == $estado->getId()) echo "selected=\"selected\"";
																}
																else{
																	if($value['clave'] == 27) echo "selected=\"selected\""; 
																}
															?> 
															> <?php echo $value['nombre']; ?></option>
														<?php
													} 
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Municipio:
									</td>
										<td>
											<select name="municipio" class="drop2" id="municipio">
												
												<?php
													$municipio = $municipio->loadAll();
													foreach($municipio as $value){

/*
														if(isset($_GET['id_empleado'])){
															?>
															<option value="<?php echo $value['id_municipio']; ?>" <?php if($value['id_municipio'] == $localidad->getM()) echo "selected='selected'" ?> ><?php echo $value['nombre']; ?></option>
															<?php
														}

														else{*/
														if($value['id_estado']==27){
															?>
															<option value=<?php echo $value['id_municipio']; ?>  

																<?php if($value['id_municipio'] == $localidad->getM() && isset($_GET['id_empleado']) ) echo "selected='selected'" ?>


															   > <?php echo $value['nombre']; ?> </option>
															<?php
														}
													//}
													} 
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Colonia:
											<input type="hidden" id="id_localidad" name="id_localidad" >
									</td>
										<td>
											<input type="text" name="localidad" id="localidad" class="box" 
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$localidad->getNombre()."'"; 
													else 
														echo "value=''"  ;
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Calle:
									</td>
										<td>
											<input type="text" name="calle" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value='".$detalle_direccion->getCalle()."'"; 
													else 
														echo "value=''"  ;
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Número exterior:
									</td>
										<td>
											<input type="text" name="numero_exterior" class="box"  
												<?php 
												if(isset($_GET['id_empleado'])) 
														echo "value=".$detalle_direccion->getNumeroExterior(); 
													else 
														echo "value=''"  ;
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Número interior:
									</td>
										<td>
											<input type="text" name="numero_interior" class="box"  
												<?php 
													if(isset($_GET['id_empleado'])) 
														echo "value=".$detalle_direccion->getNumeroInterior(); 
													else 
														echo "value=''"  ;
												?> 
											>
										</td>
									</tr>
								</table>
							</fieldset>   






							<!--
							<fieldset> 
								<legend>Seguridad Social</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Número IMSS:
									</td>
										<td>
											<input type="text" name="numero_imss" class="box" 
												<?php 
												//	if(isset($_GET['id_empleado'])) 
												//		echo "value=".$empleado->getNumeroImss(); 
												//	else 
												//		echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Cínica:
									</td>
										<td>

											<select name="clinica" class="drop2" id="clinica">
												
												<?php
												/*	$clinica = $clinica->loadAll();
													foreach($clinica as $value){
														if($value['id_estado']==27){
															?>
															<option value=<?php echo $value['id_clinica']; ?>> <?php echo $value['nombre']; ?> </option>
															<?php
														}
													} */
												?>
											</select>
										</td>
									</tr>
									
								</table>
							</fieldset>   -->











							<fieldset> 
								<legend>Datos de empleo</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Compañía:
									</td>
										<td>
											<?php
												$companias= $compania->loadAll();
												//print_r($companias);
												if(!empty($_GET) && $empleado->getId()!='' && $empleado->getEstatus()!='ASPIRANTE')
													$compania_empleado->loadByEmpleado($empleado->getId());
											?>
											<select name="compania" class="drop2">
												<?php
												foreach ($companias as $value) {
													?>
													<option <?php if( !empty($_GET) && $compania_empleado->getCompania()==$value['id_compania']) echo "selected='selected'"; ?> value= <?php echo $value['id_compania']; ?>  > <?php echo $value['compania']; ?> </option>
													<?php
												}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Área o departamento:
									</td>
										<td>
											<select name="area" class="drop2">
												<?php
													$areas = $area_departamento->loadAll();
													if(!empty($_GET))
													$empleado_puesto->loadByEmpleado($empleado->getId());
													foreach ($areas as $value) {
														?>
														<option <?php if( !empty($_GET) && $empleado_puesto->getAreaDepartamento()==$value['id_area_departamento']) echo "selected='selected'"; ?> value=<?php echo $value['id_area_departamento']; ?> class="opdrop2"><?php echo $value['nombre']; ?></option>
														<?php
													}
												?>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Puesto:
									</td>
										<td>
											<select name="puesto" class="drop2">
												<?php
													$puestos = $puesto->loadAll();
													foreach ($puestos as $value) {
														?>
														<option <?php if($empleado_puesto->getPuesto()==$value['id_puesto']) echo "selected='selected'"; ?> value=<?php echo $value['id_puesto']; ?> class="opdrop2"><?php echo $value['nombre']; ?></option>
														<?php
													}
												?>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Frente:
									</td>
										<td>
											<select name="frente" class="drop2">
												<?php
													$frentes = $frente_trabajo->loadAll();
													if(!empty($_GET) && $empleado->getEstatus()!='ASPIRANTE') {
														if($empleado_puesto->getPeriodo() == 1){
															$empleado_nomina_frente_semanal->loadByEmpleado($empleado->getId());
															$nomina_frente_semanal->loadById($empleado_nomina_frente_semanal->getNominaFrente());
														}
													}
													foreach ($frentes as $value) {
														?>
														<option <?php if($nomina_frente_semanal->getFrenteTrabajo() == $value['id_frente_trabajo'] ) echo "selected='selected'" ?> value=<?php echo $value['id_frente_trabajo']; ?> class="opdrop2"><?php echo $value['nombre']; ?></option>
														<?php
													}
												?>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Fecha inicio:
									</td>
										<td>
											<input type="text" name="fecha_inicio" required class="box"  id="fecha_inicio"
												<?php 
													if(isset($_GET['id_empleado']) ) 
														echo "value='".$empleado_puesto->getFechaInicio()."'"; 
													else 
														echo "value=''" 
												?> 
											>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Sueldo semanal:
									</td>
										<td>
											<input type="text" name="salario" required class="box" 
												<?php 
													if(isset($_GET['id_empleado'])){ 
														if($empleado_puesto->getPeriodo()==1){
														echo "value='". round(( 7 * $empleado_puesto->getSalario()))."'"; 
														}
														else{
															echo "value='". round( ( 15 * $empleado_puesto->getSalario()))."'"; 
														}
													}
													else {
														echo "value=''";
													} 
												?> 
											>
										</td>
									</tr>


									<tr>
										<td class="lab">
											Periodo de pagos:
									</td>
										<td>
											<select name="periodo_pago" class="drop2">
												<?php
													$periodos = $periodo->loadAll();
													foreach ($periodos as $value) {
														?>
														<option  value=<?php echo $value['id_periodo']; ?> class="opdrop2" 
															<?php
																if(isset($_GET['id_empleado'])){
																	if($empleado_puesto->getPeriodo()== $value['id_periodo']){
																		echo "selected='selected'";
																	}
																}

															?>
															><?php echo $value['nombre']; ?></option>
														<?php
													}
												?>
												
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Banco:

									</td>
										<td>
											<select name="banco" class="drop2">
												<option value="CHEQUE" class="opdrop2" <?php if( stristr($cuenta_bancaria->getBanco(), 'CHEQUE') ) echo "selected='selected'"; ?> >CHEQUE</option>
												<option value="BANCOMER" class="opdrop2" <?php if( stristr($cuenta_bancaria->getBanco(), 'BANCOMER') ) echo "selected='selected'"; ?> >BANCOMER</option>
												<option value="BANORTE" class="opdrop2" <?php if( stristr($cuenta_bancaria->getBanco(), 'BANORTE') ) echo "selected='selected'"; ?> >BANORTE</option>
											</select>

										</td>
									</tr>
								<!--	<tr>
										<td class="lab">
											Tipo de cuenta:
									</td>
										<td>
											<select name="tipo_cuenta" class="drop2">
												<option value="-1" class="opdrop2">Seleccione tipo de cuenta</option>
											</select>
										</td>
									</tr> -->
									<tr>
										<td class="lab">
											Número de cuenta:
									</td>
										<td>
											<input type="text" name="numero_cuenta" class="box"  
												<?php 
													if(isset($_GET['id_empleado']) && $empleado->getEstatus()!='ASPIRANTE' ) {
														echo "value=".$cuenta_bancaria->getNumeroCuenta(); 
													}
													else 
														echo "value=''" 
												?> 
											>
											<?php
												if(isset($_GET['id_empleado'])) {
													
													 ?>
													 <input type="hidden" name="cuenta_bancaria" value= <?php echo $empleado->getCuentaBancaria(); ?> >  
													 <?php
												}
											?>
										</td>
									</tr>
								</table>
							</fieldset>

							<fieldset>
								<legend>Observaciones</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Observaciones:
										</td>
										<td>
											<textarea name="observaciones" class="boxarea"><?php 
													if(isset($_GET['id_empleado'])) 
														echo $empleado->getObservaciones(); 
													else 
														echo'';
												?> </textarea>

										</td>
									</tr>
								</table>
							</fieldset>




							<div class="btn_submit">

								<?php
									if (isset($_GET['accion']) && $_GET['accion'] == 'delete' ) {
										?>
											<input type="submit" value="Eliminar"  >
										<?php
									}
									else{
										?>
											<input type="submit" value="Guardar datos"  >
										<?php
									}
								?>

							



							</div>



						</form>


						</div>



						<!-- Fin del div form que contiene el formulario  -->
					

				</div>
			</div>
			<?php
				if(isset($_GET['accion']) && $_GET['accion'] == 'insertar'){


					$nombre_comparar = $_GET['nombre'] . $_GET['apellido_paterno'] . $_GET['apellido_materno'] ;
					$nombre_comparar = strtoupper(str_replace(' ', '', $nombre_comparar));

					$curp_comparar = $_GET['curp'] ;
					$curp_comparar = strtoupper(str_replace(' ', '', $curp_comparar));
					

					if(strlen($curp_comparar)==18){
					


					if( $empleado->getComparative($nombre_comparar)==false  && $empleado->getComparativeByCurp($curp_comparar)==false ){




					if($_GET['banco']=='CHEQUE') {
						$cuenta_enviar ['banco'] = $_GET['banco'];
						$cuenta_enviar ['numero_cuenta'] = 'ENVIAR';
						$cuenta_enviar ['clabe'] = '';
						$cuenta_enviar ['tipo_cuenta'] = '';
					}
					else{
						$cuenta_enviar ['banco'] = $_GET['banco'];
						$cuenta_enviar ['numero_cuenta'] = $_GET['numero_cuenta'];
						$cuenta_enviar ['clabe'] = '';
						$cuenta_enviar ['tipo_cuenta'] = '';
					}


					

					$id_cuenta_bancaria = $cuenta_bancaria->insert($cuenta_enviar);
					
					$empleado_enviar['nombre'] = strtoupper( $_GET['nombre'] );
					$empleado_enviar['apellido_paterno'] = strtoupper( $_GET['apellido_paterno'] );
					$empleado_enviar['apellido_materno'] = strtoupper( $_GET['apellido_materno'] );
					$empleado_enviar['fecha_nacimiento'] = $_GET['fecha_nacimiento'];
					$empleado_enviar['curp'] = strtoupper( $_GET['curp']);
					$empleado_enviar['ife'] = $_GET['ife'];
					$empleado_enviar['matricula_smn'] = $_GET['matricula_smn'];
					$empleado_enviar['tipo_sangre'] = strtoupper( $_GET['tipo_sangre']) ;
					$empleado_enviar['licencia'] = $_GET['licencia'];
					$empleado_enviar['telefono_fijo'] = $_GET['telefono_fijo'];
					$empleado_enviar['telefono_movil'] = $_GET['telefono_movil'];
					$empleado_enviar['email'] = $_GET['email'];
					$empleado_enviar['fecha_inicio'] = $_GET['fecha_inicio'];
					$empleado_enviar['sexo'] = $_GET['sexo'];
					$empleado_enviar['observaciones'] = strtoupper( $_GET['observaciones'] );
					$empleado_enviar['id_cuenta_bancaria'] = $id_cuenta_bancaria;

					$id_empleado = $empleado->insertTemp($empleado_enviar);

					$compania_enviar['id_compania'] = $_GET['compania'] ;
					$compania_enviar['id_empleado'] = $id_empleado ;
					$compania_enviar['estatus'] = 'ACTIVO' ;
					$compania_enviar['fecha_inicio'] = $_GET['fecha_inicio'] ;
					$compania_enviar['fecha_fin'] = '0000-00-00' ;

					$compania_empleado->insert($compania_enviar);

					if($_GET['periodo_pago'] ==1){
						$salario = $_GET['salario'] / 7 ;
					}
					else{
						$salario = $_GET['salario'] / 15 ;
					}

					$empleado_puesto_enviar['id_empleado'] = $id_empleado ;
					$empleado_puesto_enviar['id_puesto'] = $_GET['puesto'] ;
					$empleado_puesto_enviar['estatus'] = 'ACTIVO' ;
					$empleado_puesto_enviar['fecha_inicio'] = $_GET['fecha_inicio'] ;
					$empleado_puesto_enviar['fecha_fin'] = '0000-00-00' ;
					$empleado_puesto_enviar['salario'] = $salario ;
					$empleado_puesto_enviar['id_periodo'] = $_GET['periodo_pago'] ;
					$empleado_puesto_enviar['id_area_departamento'] = $_GET['area'];

					$empleado_puesto->insert($empleado_puesto_enviar);

						/**
							Insertar en nomina semanal
						*/

					if($_GET['periodo_pago'] == 1 ){

						$nomina_frente_semanal->loadByFrente($_GET['frente']);


						$nomina_enviar['id_nomina_frente_semanal'] = $nomina_frente_semanal->getId();
						$nomina_enviar['id_empleado'] = $id_empleado;

						$empleado_nomina_frente_semanal->generaNominaEmpleadoTemp($nomina_enviar);
					}


						/**
							Insertar en nomina semanal
						*/
							/* codigo para insertar en nomina quincenal
						else{

						}
						*/


					?>
						<script type="text/javascript">
							alert("Empleado registrado exitosamente");
							//window.location = "empleado.php";
						</script>
					<?php
				} // fin del if de la comparacion curp y  nombre

				else{
					?>
					<script type="text/javascript">
						alert("El empleado ha sido registrado posteriormente. Si requieres capturar otro empleado con estos mismos datos, contacta al administrador.");
						window.location = "empleado.php";
					</script>
					<?php
					
				}

				} // fin if de comparacion de tamaño de curp 
				else{
					?>
					<script type="text/javascript">
						alert("La CURP ha sido ingresada incorrectamente.");
						window.location = "empleado.php";
					</script>
					<?php	
				}
				}  // fin del if de insertar 

				/**

				*/

				else if(isset($_GET['accion']) && $_GET['accion'] == 'actualizar'){

					//print_r($_GET);

					$empleado->loadById($_GET['id_empleado']);

					if($_GET['banco']=='CHEQUE') {
						$cuenta_enviar ['banco'] = $_GET['banco'];
						$cuenta_enviar ['numero_cuenta'] = 'ENVIAR';
						$cuenta_enviar ['clabe'] = '';
						$cuenta_enviar ['tipo_cuenta'] = '';
						$cuenta_enviar['id_cuenta_bancaria'] = $_GET['cuenta_bancaria'] ;
					}
					else{
						$cuenta_enviar ['banco'] = $_GET['banco'];
						$cuenta_enviar ['numero_cuenta'] = $_GET['numero_cuenta'];
						$cuenta_enviar ['clabe'] = '';
						$cuenta_enviar ['tipo_cuenta'] = '';
						$cuenta_enviar ['id_cuenta_bancaria'] = $_GET['cuenta_bancaria'] ;
					}
					//print_r($cuenta_enviar);

					
						$cuenta_bancaria->update($cuenta_enviar);
					

					$empleado_enviar['nombre'] = $_GET['nombre'];
					$empleado_enviar['id_empleado'] = $_GET['id_empleado'];
					$empleado_enviar['apellido_paterno'] = $_GET['apellido_paterno'];
					$empleado_enviar['apellido_materno'] = $_GET['apellido_materno'];
					$empleado_enviar['fecha_nacimiento'] = $_GET['fecha_nacimiento'];
					$empleado_enviar['curp'] = $_GET['curp'];
					$empleado_enviar['ife'] = $_GET['ife'];
					$empleado_enviar['matricula_smn'] = $_GET['matricula_smn'];
					$empleado_enviar['tipo_sangre'] = $_GET['tipo_sangre'];
					$empleado_enviar['licencia'] = $_GET['licencia'];
					$empleado_enviar['telefono_fijo'] = $_GET['telefono_fijo'];
					$empleado_enviar['telefono_movil'] = $_GET['telefono_movil'];
					$empleado_enviar['email'] = $_GET['email'];
					$empleado_enviar['fecha_inicio'] = $_GET['fecha_inicio'];
					$empleado_enviar['sexo'] = $_GET['sexo'];
					$empleado_enviar['observaciones'] = $_GET['observaciones'];
					$empleado_enviar['id_cuenta_bancaria'] =$cuenta_enviar['id_cuenta_bancaria'];

					$empleado->update($empleado_enviar);

					$compania_enviar['id_compania'] = $_GET['compania'] ;
					$compania_enviar['id_compania_empleado'] = $_GET['id_compania_empleado'];
					$compania_enviar['id_empleado'] = $_GET['id_empleado'] ;
					$compania_enviar['estatus'] = 'ACTIVO' ;
					$compania_enviar['fecha_inicio'] = $_GET['fecha_inicio'] ;
					$compania_enviar['fecha_fin'] = '0000-00-00' ;
					
					
					$compania_empleado->update($compania_enviar);
					if($_GET['periodo_pago'] ==1){
						$salario = $_GET['salario'] / 7 ;
					}
					else{
						$salario = $_GET['salario'] / 15 ;
					}


					$empleado_puesto_enviar['id_empleado'] = $_GET['id_empleado'];
					$empleado_puesto_enviar['id_puesto'] = $_GET['puesto'] ;
					$empleado_puesto_enviar['estatus'] = 'ACTIVO' ;
					$empleado_puesto_enviar['fecha_inicio'] = $_GET['fecha_inicio'] ;
					$empleado_puesto_enviar['fecha_fin'] = '0000-00-00' ;
					$empleado_puesto_enviar['salario'] = $salario ;
					$empleado_puesto_enviar['id_periodo'] = $_GET['periodo_pago'] ;
					$empleado_puesto_enviar['id_area_departamento'] = $_GET['area'];

					$empleado_puesto->update($empleado_puesto_enviar);

					if($empleado->getEstatus()=='ASPIRANTE' && $_GET['periodo_pago'] == 1){


						$nomina_frente_semanal->loadByFrente($_GET['frente']);


						$nomina_enviar['id_nomina_frente_semanal'] = $nomina_frente_semanal->getId();
						$nomina_enviar['id_empleado'] = $_GET['id_empleado'];

						$empleado_nomina_frente_semanal->generaNominaEmpleadoTemp($nomina_enviar);
					}

					else if($empleado->getEstatus()=='LABORANDO'  && $_GET['periodo_pago'] = 1){
						$nomina_frente_semanal->loadByFrente($_GET['frente']);
					$empleado_nomina_frente_semanal->loadByEmpleado($_GET['id_empleado']);


					$empleado_nomina_frente_semanal->updateFrente($empleado_nomina_frente_semanal->getId(), $nomina_frente_semanal->getId());
	
					}

					$empleado->updateEstatus($empleado->getId(), 'LABORANDO');
					


					?>
					<script type="text/javascript">
					alert("Empleado actualizado correctamente");
					window.location = "empleado.php?accion=update&id_empleado="+ <?php echo $_GET['id_empleado']; ?>;
					</script> 	
					<?php


				}  // fin del if de actualizar

				/**

				*/


				else if(isset($_GET['accion']) && $_GET['accion'] == 'eliminar'){
					$empleado_nomina_frente_semanal->delete($_GET['id_empleado_nomina']);
					$empleado_puesto ->deleteForEmpleadoEstatus($_GET['id_empleado'], 'ACTIVO');
					$compania_empleado ->deleteForEmpleadoEstatus($_GET['id_empleado'], 'ACTIVO');
					$empleado->delete($_GET['id_empleado']);
					?>
					<script type="text/javascript">
						alert("Empleado eliminado satisfactoriamente");
						window.location = "empleado.php";
					</script>
					<?php	
				}

			?>

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