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
	include_once("../library/AreaDepartamento.php");
	include_once("../library/Puesto.php");
	include_once("../library/EmpleadoPuesto.php");
	include_once("../library/Localidad.php");
	include_once("../library/CompaniaEmpleado.php");
	$menu 		= new Menu();
	$estado 	= new Estado();
	$municipio 	= new Municipio();
	$aspirante 	= new Empleado();
	$localidad 	= new Localidad();
	$clinica 	= new Clinica();
	$detalle_direccion = new DetalleDireccion();
	$cuenta_bancaria = new CuentaBancaria();
	$area_departamento = new AreaDepartamento() ;
	$puesto = new Puesto ();
	$empleado_puesto = new EmpleadoPuesto();
	$compania_empleado = new CompaniaEmpleado();
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
				yearRange: "1950:2020",
				dateFormat:"yy-mm-dd",
				monthNamesShort:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				dayNamesMin:["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
			});



		   // var a = 0 ;
		    
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
			<?php
					echo $menu->printMainManu();
				?>
		</div>

		<div id="content">
			
			
			<div id="page">
				<div class="inner">
					<div class="form">
					<div class="tittle">
						Registro de aspirantes
						</div>

			<?php  
				if ( !empty($_POST)){

					$array_detalle_direccion=array(
							'id_detalle_direccion'	=>0,
							'calle'					=>$_POST['calle'],
							'numero_exterior'		=>$_POST['numero_exterior'],
							'numero_interior'		=>$_POST['numero_interior'],
							'id_localidad'			=>$_POST['id_localidad']
							);
					$id_detalle_direccion = $detalle_direccion->insert($array_detalle_direccion);

					$localidad->updateMunicipio( $_POST['id_localidad'], $_POST['municipio']);
					
					$array_cuenta_bancaria = array(
							"id_cuenta_bancaria" => 0,
							"banco"=>'',
							"numero_cuenta"=>"",
							'clabe'=>'',
							'tipo_cuenta'=>''
						);
					$id_cuenta_bancaria= $cuenta_bancaria->insert($array_cuenta_bancaria);





						$array_aspirante=array(
							'nombre' 			=>strtoupper($_POST['nombre']),
							'apellido_paterno' 	=> strtoupper( $_POST['apellido_paterno']),
							'apellido_materno'	=>strtoupper($_POST['apellido_materno'] ),
							'fecha_nacimiento'	=>$_POST['fecha_nacimiento'],
							'curp'				=>strtoupper($_POST['curp']),
							'ife'				=>$_POST['ife'],
							'matricula_smn'		=>strtoupper($_POST['matricula_smn']),
							'tipo_sangre'		=>'',
							'licencia'			=>strtoupper($_POST['licencia']),
							'telefono_fijo'		=>$_POST['telefono_fijo'],
							'telefono_movil'	=>$_POST['telefono_movil'],
							'email'				=>$_POST['email'],
							'fecha_inicio'		=>'0000-00-00',
							'sexo'				=>$_POST['sexo'],
							'observaciones'		=>'',
							'curriculum'		=>'',
							'foto'				=>'',
							'numero_imss'		=>$_POST['numero_imss'],
							'estatus'			=>'ASPIRANTE',
							'fecha_fin'			=>'0000-00-00',
							'id_detalle_direccion'=> $id_detalle_direccion,
							'id_clinica'		=>$_POST['clinica'],
							'id_cuenta_bancaria'=>$id_cuenta_bancaria
							);
						
						$id_aspirante = $aspirante->insert($array_aspirante);

						$empleado_puesto_enviar['id_empleado'] = $id_aspirante ;
					$empleado_puesto_enviar['id_puesto'] = $_POST['puesto'] ;
					$empleado_puesto_enviar['estatus'] = 'ACTIVO' ;
					$empleado_puesto_enviar['fecha_inicio'] = '0000-00-00' ;
					$empleado_puesto_enviar['fecha_fin'] = '0000-00-00' ;
					$empleado_puesto_enviar['salario'] = 0 ;
					$empleado_puesto_enviar['id_periodo'] = '3' ;
					$empleado_puesto_enviar['id_area_departamento'] = $_POST['area'];

					 $empleado_puesto->insert($empleado_puesto_enviar);



					$compania_enviar['id_compania'] = 1 ;
					$compania_enviar['id_empleado'] = $id_aspirante ;
					$compania_enviar['estatus'] = 'ACTIVO' ;
					$compania_enviar['fecha_inicio'] = '0000-00-00' ;
					$compania_enviar['fecha_fin'] = '0000-00-00' ;

					 $compania_empleado->insert($compania_enviar);


						if($id_aspirante !=null && $id_aspirante>0 ){
							?>
							<div id="success-registro">
							<center>
							Registro almacenado exitosamente
							<br>
							<a href="<?php echo 'pdf.php?id_aspirante='.$id_aspirante; ?>" target="_blank">Imprimir Solicitud de Servicio Médico</a>
							</center>
							</div>
							<?php
						}

				}

			?>


						<form class="formulario" method="POST">
							<fieldset> 
								<legend>Datos personales</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Nombre:
									</td>
										<td>
											<input type="text" maxlength="40" name="nombre" class="box" required>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Apellido paterno:
									</td>
										<td>
											<input type="text" name="apellido_paterno" class="box" required>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Apellido materno:
									</td>
										<td>
											<input type="text" name="apellido_materno" class="box">
										</td>
									</tr>

									<tr>
										<td class="lab">
											Sexo:
									</td>
										<td>
											<select name="sexo" class ="drop2">
   												<option value="MASCULINO">Masculino</option>
									   			<option value="FEMENINO">Femenino</option>
									   		</select> 
										</td>
									</tr>

									<tr>
										<td class="lab">
											Fecha de nacimiento:
									</td>
										<td>
											<input type="text" name="fecha_nacimiento" class="box" id="fecha_nacimiento" required>
										</td>
									</tr>
																
									
									<tr>
										<td class="lab">
											Telefono fijo:
									</td>
										<td>
											<input type="text" name="telefono_fijo" class="box">
										</td>
									</tr>

									<tr>
										<td class="lab">
											Telefono movil:
									</td>
										<td>
											<input type="text" name="telefono_movil" class="box">
										</td>
									</tr>

									<tr>
										<td class="lab">
											Correo electronico:
									</td>
										<td>
											<input type="text" name="email" class="box">
										</td>
									</tr>

								</table>
							</fieldset>


							<fieldset> 
								<legend>Datos de dirección</legend>
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
														<option value=<?php echo $value['id_estado']; ?> <?php if($value['clave'] == 27) echo "selected=\"selected\""; ?> > <?php echo $value['nombre']; ?></option>
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
														if($value['id_estado']==27){
															?>
															<option value=<?php echo $value['id_municipio']; ?>> <?php echo $value['nombre']; ?> </option>
															<?php
														}
													}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Colonia:
											<input type="hidden" id="id_localidad" name="id_localidad">
									</td>
										<td>
											<input type="text" name="localidad" id="localidad" class="box">
										</td>
									</tr>
									<tr>
										<td class="lab">
											Calle:
									</td>
										<td>
											<input type="text" name="calle" class="box">
										</td>
									</tr>
									<tr>
										<td class="lab">
											Número exterior:
									</td>
										<td>
											<input type="text" name="numero_exterior" class="box">
										</td>
									</tr>
									<tr>
										<td class="lab">
											Número interior:
									</td>
										<td>
											<input type="text" name="numero_interior" class="box">
										</td>
									</tr>
								</table>
							</fieldset>

							<fieldset> 
								<legend>Seguridad Social</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Numero de IMSS:
									</td>
										<td>
											<input type="text" name="numero_imss" class="box" required>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Clínica de afiliación:
									</td>
										<td>
											<select name="clinica" class="drop2" id="clinica">
												
												<?php
													$clinica = $clinica->loadAll();
													foreach($clinica as $value){
														if($value['id_estado']==27){
															?>
															<option value=<?php echo $value['id_clinica']; ?>> <?php echo $value['nombre']; ?> </option>
															<?php
														}
													}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="lab">
											I.F.E.:
									</td>
										<td>
											<input type="text" name="ife" class="box" required>
										</td>
									</tr>
									<tr>
										<td class="lab">
											C.U.R.P.:
									</td>
										<td>
											<input type="text" name="curp" class="box" required>
										</td>
									</tr>
									<tr>
										<td class="lab">
											Licencia:
									</td>
										<td>
											<input type="text" name="licencia" class="box">
										</td>
									</tr>
									<tr>
										<td class="lab">
											Servicio militar nacional:
									</td>
										<td>
											<input type="text" name="matricula_smn" class="box" q>
										</td>
									</tr>

								</table>
							</fieldset>



							<fieldset> 
								<legend>Datos de empleo</legend>
								<table class="tab_form">
									
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
									
								</table>
							</fieldset>

							

							<div class="btn_submit">
								<input type="submit" value="Guardar">
							</div>
						</form>
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