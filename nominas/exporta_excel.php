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
	<script src="../js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="/js/dialog_box.js"></script>
	<script type="text/javascript">
	function  efecto(){
                             $('#loading').hide();
                      //      $('#contenidoWeb').fadeIn(500);
        }
	</script>

</head>
<body id="item1" onload="efecto();">
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
							Resultado
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
							Exportando Nómina a MS Excel...
							<br>
							Espere un momento por favor
							</strong>
							</center>

							<strong>
							Calculando Frente de Trabajo:
							</strong>
						</div>

						<!-- FIN ANIMACION DE LOADING -->


						<div>		<!-- INICIO DEL PROCESAMIENTO PARA LA EXPORTACION A EXCEL-->




<?php

set_time_limit(0);

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
require_once '../Classes/PHPExcel/IOFactory.php';



//echo date('H:i:s') , " abrir para templete cinco" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/30template.xls");
//echo date('H:i:s') , " Adicionar nuevo templete" , EOL;


//PONER EL ARREGLO QUE CONTENGA LOS DATOS
	include_once("../library/Excel.php");
	include_once("../library/Empleado.php");
	include_once("../library/NominaGeneralSemanal.php");
	include_once("../library/NominaFrenteSemanal.php");
	include_once("../library/EmpleadoNominaFrenteSemanal.php");
	include_once("../library/FrenteTrabajo.php");
	include_once("../library/CompaniaEmpleado.php");
	include_once("../library/Compania.php");
	include_once("../library/EmpleadoPuesto.php");
	include_once("../library/CuentaBancaria.php");
	include_once("../library/BonificacionSemanal.php");
	include_once("../library/GeneraNominaSemanal.php");
	include_once("../library/Puesto.php");
	include_once("../library/DeduccionSemanal.php");

	$xls 							= new ExcelWriter();
	$empleado 						= new Empleado();
	$nomina_general_semanal 		= new NominaGeneralSemanal();
	$nomina_frente_semanal 			= new NominaFrenteSemanal();
	$empleado_nomina_frente_semanal	= new EmpleadoNominaFrenteSemanal();
	$frente_trabajo 				= new FrenteTrabajo();
	$compania_empleado				= new CompaniaEmpleado();
	$compania 						= new Compania();
	$empleado_puesto 				= new EmpleadoPuesto();
	$cuenta_bancaria 				= new CuentaBancaria();
	$bonificacion_semanal 			= new BonificacionSemanal();
	$puesto 						= new Puesto();
	$deduccion_semanal 				= new DeduccionSemanal();

	$frente=array();

	set_time_limit(0);

	setlocale(LC_MONETARY, 'en_US');



	$nomina_general_semanal->loadByActivo();

	$nominas_frentes = $nomina_frente_semanal->loadByNominaGeneralSemanal($nomina_general_semanal->getId());







		/**
		Nueva Implementación
		*/

		$monto_total_nomina_general = 0 ; 

		$resumen_frentes_trabajo = array();







		$row = 11;


		foreach ($nominas_frentes as $nomina_frente) {

			$nomina_frente_semanal->loadById($nomina_frente['id_nomina_frente_semanal']);
			$frente_trabajo->loadById($nomina_frente_semanal->getFrenteTrabajo());

			$impreso = 0 ;
			$bandera_nombre_frente = 0 ;
			

			
			$monto_total_nomina_frente = 0 ;
			
			$empleados_nominas = $empleado_nomina_frente_semanal ->loadByNominaFrenteSemanal($nomina_frente['id_nomina_frente_semanal']);
			

			foreach ($empleados_nominas as $nomina_empleado) {
				
				$deduccion = 0 ;
				$bonificacion = 0 ;
				$monto_empleado = 0 ;
				
				$empleado->loadById($nomina_empleado['id_empleado']);
				$empleado_puesto->loadByEmpleado($empleado->getId());
				$puesto->loadById($empleado_puesto->getPuesto());

				$compania_empleado->loadByEmpleado($nomina_empleado['id_empleado']);
				$compania->loadById($compania_empleado->getCompania());

				$cuenta_bancaria->loadById($empleado->getCuentaBancaria());

				if($deduccion_semanal->loadByEmpleadoNomina($nomina_empleado['id_empleado_nomina_frente_semanal'])==1){
					$deduccion = $deduccion_semanal->getMonto();
					$bandera_nombre_frente = 1 ;
					$deduccion_semanal->updateEstatus($deduccion_semanal->getId(), 'PAGADA');
				}

				if($bonificacion_semanal->loadByEmpleadoNomina($nomina_empleado['id_empleado_nomina_frente_semanal'])==1){
					$bonificacion = $bonificacion_semanal->getMonto();
					$bandera_nombre_frente = 1 ;
					$bonificacion_semanal->updateEstatus($bonificacion_semanal->getId(), 'PAGADA');
				}


				
				if($nomina_empleado['monto']>0){

					$bandera_nombre_frente = 1 ;

					$monto_empleado = $nomina_empleado['monto'] ;
					
					
				}
				
				

				$monto_empleado += $bonificacion ;
				$monto_empleado = $monto_empleado - $deduccion ;

				if($monto_empleado > 0 || $bonificacion > 0 || $deduccion > 0){

					if($bandera_nombre_frente==1 && $impreso==0){




						$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
						$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $frente_trabajo->getNombre());
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setName('Arial');
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setSize(18);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
						$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'R'.$row);

						$row++;


						



/*
						echo "<h2>".$frente_trabajo->getNombre()."</h2>";
						echo "<br>"; */
						$impreso = 1 ;
					}





					$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $empleado->getid())
	                              ->setCellValue('B'.$row, $empleado->getApellidoPaterno())
								  ->setCellValue('C'.$row, $empleado->getApellidoMaterno())
								  ->setCellValue('D'.$row, $empleado->getNombre())
								  ->setCellValue('E'.$row, $compania->getAbreviatura())
								  ->setCellValue('F'.$row, $puesto->getNombre())
								  ->setCellValue('G'.$row, $empleado_puesto->getSalario())
								  ->setCellValue('H'.$row, ( ( $nomina_empleado['lunes'] == 1) ? 'P' : 'O' ) )
								  ->setCellValue('I'.$row, ( ( $nomina_empleado['martes'] == 1) ? 'P' : 'O' ) )
								  ->setCellValue('J'.$row, ( ( $nomina_empleado['miercoles'] == 1) ? 'P' : 'O' ) )
								  ->setCellValue('K'.$row, ( ( $nomina_empleado['jueves'] == 1) ? 'P' : 'O' ) )
								  ->setCellValue('L'.$row, ( ( $nomina_empleado['viernes'] == 1) ? 'P' : 'O' ) )
								  ->setCellValue('M'.$row, ( ( $nomina_empleado['sabado'] == 1) ? 'P' : 'O' ) )
								  ->setCellValue('N'.$row, ( ( $nomina_empleado['domingo'] == 1) ? 'P' : 'O' ) )
	                              ->setCellValue('O'.$row, $bonificacion)
	                              ->setCellValue('P'.$row, $deduccion)
	                              ->setCellValue('Q'.$row, $monto_empleado)
	                              ->setCellValue('R'.$row, $cuenta_bancaria->getNumeroCuenta() )
	                              ->setCellValue('S'.$row, $cuenta_bancaria->getBanco());
	                              //->setCellValue('S'.$row, $frente_trabajo->getNombre());
	                              $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setName('Arial');
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setSize(10);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('R'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

	                              $row++;

	                              $empleado_nomina_frente_semanal->updateMonto($nomina_empleado['id_empleado_nomina_frente_semanal'], $monto_empleado);





					/*echo $empleado->getNombre()." " . $empleado->getApellidoPaterno()." ".$empleado->getApellidoMaterno() ."---- " . $puesto->getNombre() . "----- " . $compania->getAbreviatura()."------- " . $empleado_puesto->getSalario(). "------". $cuenta_bancaria->getBanco() . "-------" . $cuenta_bancaria->getNumeroCuenta() ;
					echo "<br>";
					print_r($nomina_empleado) ;
					echo "<br>";
					echo $deduccion . "------" . $bonificacion ;

					echo "<br><br>"; */

				}


				$monto_total_nomina_frente += $monto_empleado ;



				
			}



			if($monto_total_nomina_frente>0){


			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TOTAL A PAGAR EN EL FRENTE '.$frente_trabajo->getNombre() );
			$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'P'.$row);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $monto_total_nomina_frente);
			//$objPHPExcel->getActiveSheet()->mergeCells('Q'.$row.':'.'R'.$row);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->setBreak( 'A' . $row, PHPExcel_Worksheet::BREAK_ROW);
			$row++;

			$nomina_frente_semanal->updateMonto($nomina_frente['id_nomina_frente_semanal'], $monto_total_nomina_frente);
			//$empleado_nomina_frente_semanal->updateEstatus($nomina_empleado['id_empleado_nomina_frente_semanal'], 'PAGADA');



			$resumen_frentes_trabajo[] = array("nombre"=>$frente_trabajo->getNombre(), "monto"=>$monto_total_nomina_frente);


			$monto_total_nomina_general +=  $monto_total_nomina_frente ;
			/*echo $monto_total_nomina_frente ;
			echo "<br><br>"; */
		}

		} //foreach nominas_frentes	

		//echo $monto_total_nomina_general ;

		$row+=3 ;


		foreach($resumen_frentes_trabajo as $fila){


			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $fila['nombre'])
										  ->setCellValue('D'.$row, $fila['monto']);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE );
			$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);
			$row++;




		}

		$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, 'TOTAL A PAGAR EN ESTA NOMINA: ')
								  	->setCellValue('D'.$row, $monto_total_nomina_general);
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE );
		$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);








		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$name_file = "NOMINA_SEMANAL_".date('Y-m-d H-i-s').'.xls';
		$objWriter->save("../files/nominas_semanales/".$name_file);

		echo "<h2>La nómina ha sido generada correctamente, haga clic en el siguiente enlace para descargarla:</h2>";

		echo "<center><h2><a href=\"../files/nominas_semanales/".$name_file."\">Descargar</a></h2></center>";



		/**
		Fin Nueva Implementación
		*/


		$id_nomina_general_anterior = $nomina_general_semanal->getId();

		$id_nomina_general_nueva = $nomina_general_semanal->insertNuevo();


		foreach ($nominas_frentes as $nomina_frente) {

			$nomina_frente_nueva = $nomina_frente_semanal->insertNuevo($id_nomina_general_nueva, $nomina_frente['id_frente_trabajo']);
			$empleados_nominas = $empleado_nomina_frente_semanal ->loadByNominaFrenteSemanal($nomina_frente['id_nomina_frente_semanal']);
			
			foreach ($empleados_nominas as $nomina_empleado) {
				$empleado_nomina_frente_semanal->updateEstatus($nomina_empleado['id_empleado_nomina_frente_semanal'], 'PAGADA');
				$empleado_nomina_frente_semanal->generaNominaEmpleadoTemp(array('id_empleado'=>$nomina_empleado['id_empleado'], 'id_nomina_frente_semanal'=>$nomina_frente_nueva));
			}

			$nomina_frente_semanal->updateEstatus($nomina_frente['id_nomina_frente_semanal'], 'PAGADA');


		}

		$nomina_general_semanal->saldarNomina($id_nomina_general_anterior);
		$nomina_general_semanal->updateMonto($id_nomina_general_anterior, $monto_total_nomina_general);






?>








						</div>  	<!-- FIN DEL PROCESAMIENTO -->

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