<?php
session_start();
	include_once("library/Usuario.php");
	include_once ("library/Sesion.php");

	$usuario = new Usuario();
	$sesion = new Sesion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="css/admin.css"  />
	<link rel="stylesheet" type="text/css" href="/css/dialog_box.css" />
	<script type="text/javascript" src="/js/dialog_box.js"></script>

</head>
<body id="item1">
	<div id="wrapper">
		<div id="head1">
			<div id="logo_user_details">
				<h1 id="logo"><a href="#">Sistema de Nómina de SMT</a></h1>

			</div>
			<div id="menus_wrapper2" class="ind" >
				Iniciar Sesión para ingresar al Sistema de Nóminas  

				
			</div>
		</div>

		<div id="content">
			<div id="page">
				<div id="inner_index">
					<center>
					<form method="post" >
						<fieldset class="inicio">
							
							<center>
							<table>
								<tr>
									<td style="text-align:right;"><p>Usuario:</p></td>
									<td><p><input type="text" name="username" class="text" title="Introduzca su clave de usuario"></p></td>
								</tr>
								<tr></tr>
								<tr>
									<td style="text-align:right;"><p>Contraseña:</p></td>
									<td><p><input type="password" name="password" class="text" title="Introduzca su contraseña"></p></td>
								</tr>
								<tr></tr>
								<tr>
									<td colspan="2" align="center" style="text-align:right;">
										<input type="submit" value="Iniciar sesión" id="btn_start">
									</td>
								</tr>
							</table>
							</center>
						</fieldset>
					</form>



					<?php
					if(!empty($_POST)){
						
						if($usuario->loadByUsername( $_POST['username'] ) > 0){
							if($usuario->getPassword() == $_POST['password']){

								if($sesion->getForIngreso($usuario->getId()) == 0){

								$_SESSION['id_usuario'] = $usuario->getId() ;
								$_SESSION['username'] = $usuario->getUsername() ;
								$_SESSION['password'] = $usuario->getPassword();
								$_SESSION['tipo_usuario'] = $usuario->getTipoUsuario() ;
								$_SESSION['estatus'] = $usuario->getEstatus() ;
								$_SESSION['id_empleado'] = $usuario->getEmpleado();


								$_SESSION['id_session'] = $sesion->insert( 
																			array(
																				'usuario' => $_SESSION['id_usuario'] ,
																				'ip_acceso' => $_SERVER['REMOTE_ADDR'],
																				'usuario_pc' => $_SERVER['REMOTE_USER'],
																				'remote_host' => $_SERVER['REMOTE_HOST']
																		 	) );


								header("Location: empleados/index.php");
							}
							else{
								?>
								<br>
								<span style="color:red; font-size:14px; font-weight:bold;" >
									Ya existe una sesión iniciada con esas credenciales
									<br>No es posible iniciar sesión con la misma cuenta más de una vez
								</span>
								<?php
							}
							}
							else{
								?>
								<br>
								<span style="color:red; font-size:14px; font-weight:bold;" >Password no correcto</span>
								<?php
							}
						}
						else{
							?>
							<br>
							<span style="color:red; font-size:14px; font-weight:bold;" >Clave de usuario no encontrada</span>
							<?php
						}


					}
					?>

					</center>
				</div>
			</div>

		</div>
	</div>
</body>
</html>