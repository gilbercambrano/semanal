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
	<script language="JavaScript" type="text/javascript" src="js/ajax.js"></script>

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
						Gráfica correspondiente a las nóminas generales semanales
						</div>
						<center>

							<br>
							<br>
					<table>

						<tr>
							<td colspan=2>
								<div id="maestro_chart" style="text-align:center;" >
									<?php include("graficos/grafico1.php"); ?>
								</div>
							</td>
						</tr>
						<tr>
							<td colspan=2></td>
						</tr>
						<tr>
							<td colspan=2>
								<br>
								<div id="detalle_chart" style="display:none;"></div>
							</td>
						</tr>
						
					</table>	
					</center>
				</div> 

				</div> 

			</div>

			<div id="sidebar-menu">
				<?php
					echo $menu->printMenuEstadisticas();
				?>
			</div>


		</div>
	</div>
</body>
</html>

<html>

<?php
}
else{
	header("Location: ../index.php");
}
?>