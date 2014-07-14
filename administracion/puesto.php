
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css"  />
	<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../js/jquery.formatCurrency-1.4.0.js"></script>
	<script type="text/javascript" src="../js/moneda2.js"></script>
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
						Agregar puesto
						</div>
						<form class="formulario">
							<fieldset> 
								<legend>Datos del puesto</legend>
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
											Descripcion:
									</td>
										<td>
											<textarea name="descripcion" class ="boxarea"></textarea>
										</td>
									</tr>

									<tr>
										<td class="lab">
											Salario:
									</td>
										<td>
											<!--<INPUT id="txtChar" onkeypress="return isNumberKey(event)" type="text" name="txtChar">-->
											<input type="text" id="formatWhileTypingAndWarnOnDecimalsEntered2" onkeypress="return isNumberKey(event)"  name="salario" class="box" required>
											<span id="formatWhileTypingAndWarnOnDecimalsEnteredNotification2" class="message"></span>
										</td>
									</tr>

									<tr>
										<td class="lab">
											Area - Departamento
									
									</td>
										<td>
											<select name="jefe" class ="drop2">
   												<option value=-1>Seleccione un departamento</option>
   												
									   		</select> 
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