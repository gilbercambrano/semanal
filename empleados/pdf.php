<?php

	include_once("../library/Menu.php");

	include_once("../library/pdf/fpdf.php");
	include_once("../library/SolicitudMedica.php");

	$menu 							= new Menu();


	




	include_once("../library/Empleado.php");
	include_once("../library/EmpleadoPuesto.php");
	include_once("../library/Puesto.php");
	$id_aspirante = $_GET['id_aspirante'] ;
	$aspirante = new Empleado();
	$empleado_puesto = new EmpleadoPuesto();
	$puesto = new Puesto(); 
	$solicitud_medica = new SolicitudMedica() ;


	$pdf = new FPDF() ;
	
	set_time_limit(0);

	$empleado_puesto->loadByEmpleado($id_aspirante);
	$aspirante->loadById($id_aspirante);
	$puesto->loadById( $empleado_puesto->getPuesto());

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Sistema de Nómina de SMT</title>
	<link media="screen" rel="stylesheet" type="text/css" href="../css/admin.css"  />


	<link rel="stylesheet" href="../css/ui-lightness/jquery-ui.css" />
    <script src="../js/jquery-1.8.3.js"></script>
    <script src="../js/jquery-ui.js"></script>
    



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

						<center>
						<?php


						$consecutivo = $solicitud_medica->getNextConsecutivo();


			$pdf->AddPage();
			$pdf->line(5,8,204,8);
			$pdf->line(5,20,204,20);
			$pdf->line(5,30,204,30);

			$pdf->line(5,8, 5,30);
			$pdf->line(204,8, 204,30);
			$pdf->line(102,8, 102,20);

			$pdf->line(5, 40, 204, 40);
			$pdf->line(5, 45, 204, 45);
			$pdf->line(5, 50, 204, 50);
			$pdf->line(5, 55, 204, 55);
			$pdf->line(5, 60, 204, 60);
			$pdf->line(5, 70, 204, 70);
			$pdf->line(5, 75, 204, 75);
			$pdf->line(5, 85, 204, 85);
			$pdf->line(5, 120, 204, 120);

			$pdf->line(5, 40, 5, 120);
			$pdf->line(204, 40, 204, 120);
			$pdf->line(53, 40, 53, 55);

			$pdf->line(53, 60, 53, 85 );
			


			$pdf->Image('../images/SMT.JPG', 8,9, 70, 9, 'JPG', '');
			$pdf->Image('../images/pie.jpg', 5,122, 199, 10, 'JPG', '');

			$pdf->SetFont('Arial', 'B', 13);
			$pdf->Text(115, 15, utf8_decode("SOLICITUD DE SERVICIO MÉDICO"));
			$pdf->SetFont('Arial', '', 10);
			$pdf->Text(152, 25, utf8_decode('Codificación: FOR-RH-SSM-12') );
			$pdf->Text(175, 29, utf8_decode('Hoja: 1   de   1') );
			$pdf->Text(155, 35, 'Folio: SMT-VHSA-RH-'.$consecutivo.'/13');

			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Text(7, 44, 'Fecha:');
			$pdf->Text(7, 49, utf8_decode('Atención:'));
			$pdf->Text(7, 54, utf8_decode('Dirección:'));

			$pdf->Text(7, 66, 'Nombre de la persona:');
			$pdf->Text(7, 74, utf8_decode('Categoría:'));
			$pdf->Text(7, 81, utf8_decode('Tipo de servicio solicitado:'));

			$pdf->Text(55,44,date('d-m-Y'));
			$pdf->Text(55, 49, 'Dr. Oscar San Miguel Bravo');
			$pdf->Text(55, 54, utf8_decode('Av. Cesar Sandino No. 310, Col. Primero de Mayo'));
			$pdf->Text(85, 59, 'CLINICA PREMIER');

			$pdf->Text(55, 66, utf8_decode($aspirante->getNombreCompleto($id_aspirante)));
			$pdf->Text(55, 74, utf8_decode($puesto->getNombre()));
			$pdf->Text(55, 81, utf8_decode('Análisis Clínico'));

			$pdf->line(10, 100, 80,100);
			$pdf->line(129, 100, 199,100);

			$pdf->Text(20, 105, utf8_decode('Nombre y firma de Autorización'));
			$pdf->Text(15, 110, utf8_decode('Departamento de Recursos Humanos'));

			$pdf->Text(170,115, 'ID Aspirante: ' . $_GET['id_aspirante']);

			$pdf->Text(139, 105, utf8_decode('Nombre y firma del empleado'));
			$pdf->line(0, 133, 210, 133);




			/**

			*/
			$pdf->line(5,143,204,143);
			$pdf->line(5,155,204,155);
			$pdf->line(5,165,204,165);

			$pdf->line(5,143, 5,165);
			$pdf->line(204,143, 204,165);
			$pdf->line(102,143, 102,155);

			$pdf->line(5, 175, 204, 175);
			$pdf->line(5, 180, 204, 180);
			$pdf->line(5, 185, 204, 185);
			$pdf->line(5, 190, 204, 190);
			$pdf->line(5, 195, 204, 195);
			$pdf->line(5, 205, 204, 205);
			$pdf->line(5, 210, 204, 210);
			$pdf->line(5, 220, 204, 220);
			$pdf->line(5, 255, 204, 255);

			$pdf->line(5, 175, 5, 255);
			$pdf->line(204, 175, 204, 255);
			$pdf->line(53, 175, 53, 190);

			$pdf->line(53, 195, 53, 220 );
			


			$pdf->Image('../images/SMT.JPG', 8,144, 70, 9, 'JPG', '');
			$pdf->Image('../images/pie.jpg', 5,257, 199, 10, 'JPG', '');

			$pdf->SetFont('Arial', 'B', 13);
			$pdf->Text(115, 150, utf8_decode("SOLICITUD DE SERVICIO MÉDICO"));
			$pdf->SetFont('Arial', '', 10);
			$pdf->Text(152, 160, utf8_decode('Codificación: FOR-RH-SSM-12') );
			$pdf->Text(175, 164, utf8_decode('Hoja: 1   de   1') );
			$pdf->Text(155, 170, 'Folio: SMT-VHSA-RH-'.$consecutivo.'/13');

			$pdf->SetFont('Arial', 'B', 10);
			$pdf->Text(7, 179, 'Fecha:');
			$pdf->Text(7, 184, utf8_decode('Atención:'));
			$pdf->Text(7, 189, utf8_decode('Dirección:'));

			$pdf->Text(7, 201, 'Nombre de la persona:');
			$pdf->Text(7, 209, utf8_decode('Categoría:'));
			$pdf->Text(7, 216, utf8_decode('Tipo de servicio solicitado:'));

			$pdf->Text(55,179,date('d-m-Y'));
			$pdf->Text(55, 184, 'Dr. Oscar San Miguel Bravo');
			$pdf->Text(55, 189, utf8_decode('Av. Cesar Sandino No. 310, Col. Primero de Mayo'));
			$pdf->Text(85, 194, 'CLINICA PREMIER');

			$pdf->Text(55, 201, utf8_decode($aspirante->getNombreCompleto($id_aspirante)));
			$pdf->Text(55, 209, utf8_decode($puesto->getNombre()));
			$pdf->Text(55, 216, utf8_decode('Análisis Clínico'));

			$pdf->line(10, 235, 80,235);
			$pdf->line(129, 235, 199,235);

			$pdf->Text(20, 240, utf8_decode('Nombre y firma de Autorización'));
			$pdf->Text(15, 245, utf8_decode('Departamento de Recursos Humanos'));

			$pdf->Text(170,250, 'ID Aspirante: ' . $_GET['id_aspirante']);

			$pdf->Text(139, 240, utf8_decode('Nombre y firma del empleado'));
			//$pdf->line(0, , 210, 133); 
			/**

			*/
			$a ['id_empleado'] =  $_GET['id_aspirante'] ;
			$a['consecutivo'] = $consecutivo ;
			$solicitud_medica->insert($a);

			$pdf->Output("../files/ssm/ssm_".$_GET['id_aspirante'].".pdf",'');
			?>
			<script type="text/javascript">
			window.location="../files/ssm/ssm_<?php echo $_GET['id_aspirante']; ?>.pdf";
			</script>
				
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
