
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
	<script type="text/javascript">
		$(function (){
			$("#fecha_inicio").datepicker({
				changeYear: true,
				changeMonth: true,
				yearRange: "1950:2020",
				dateFormat:"yy-mm-dd",
				monthNamesShort:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				dayNamesMin:["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
			});

			$("#fecha_fin").datepicker({
				changeYear: true,
				changeMonth: true,
				yearRange: "1950:2020",
				dateFormat:"yy-mm-dd",
				monthNamesShort:["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
				dayNamesMin:["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"]
			});
		} );
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
								<!--<li class="first"><a href="#">Mi cuenta</a></li>-->
								<li class="last"><a href="../library/session_close.php">Salir</a></li>
							</ul>
						</li>
					</ul>

					<div id="search_wrapper">
						<form action="#">
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
				<div id="main_menu">
					<ul>
						<li>
							<a href="#" 
									
								<span><span>Empleados</span></span>
							</a>
						</li>
						<li>
							<a href="#" 
									
								<span><span>Nóminas</span></span>
							</a>
						</li>
						<li>
							<a href="#" 
									
								<span><span>Estadísiticas</span></span>
							</a>
						</li>
						<li class="last">
							<a href="#" 
									
								<span><span>Administracion</span></span>
							</a>
						</li>
					</ul>
					
				</div>
				
			</div>
		</div>

		<div id="content">
			<div id="page">
				<div class="inner">
					<div class="form">
					<div class="tittle">
						Registro de sector o activo
						</div>
						<form class="formulario">
							<fieldset> 
								<legend>Datos del sector o activo</legend>
								<table class="tab_form">
									<tr>
										<td class="lab">
											Nombre:
										</td>
										<td>
											<input type="text" name="nombre" class="box" required>
										</td>
									</tr>

									
								</table>
							</fieldset>
							<div class="btn_sumit">
								<input type="submit" value="Guardar">
							</div>

						</form>
						</div>
					

				</div>
			</div>

			<div id="sidebar">
				<div class="inner">
					<div class="section">
						<!--aqui va el menu-->
					</div>
				</div>
			</div>

		</div>
	</div>
</body>
</html>