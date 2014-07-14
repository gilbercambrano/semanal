<?php
	session_start();
	
	if(!empty($_SESSION)) {

	include_once("../library/Menu.php");
	$menu = new Menu();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css"  />
	<link rel="stylesheet" type="text/css" href="/css/dialog_box.css" />
	<script type="text/javascript" src="/js/dialog_box.js"></script>

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
						<table border=1>
							<tr>
								<th>Clave</th>
								<th>Nombre</th>
								<th>Puesto</th>
								<th>Departamento</th>
								<th>Acciones</th>
							</tr>
						</table>
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