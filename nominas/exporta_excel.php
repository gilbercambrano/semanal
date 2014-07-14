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

	$frente=array();

	set_time_limit(0);

	setlocale(LC_MONETARY, 'en_US');

	$nomina_general_semanal->loadByActivo();

	$nominas_frentes = $nomina_frente_semanal->loadByNominaGeneralSemanal($nomina_general_semanal->getId());



	/*  
	Inicio de calculo de montos totales
	*/

	$bonos = array();

		foreach ($nominas_frentes as $value) {
		$monto_nomina = 0 ;
		$empleados_nominas = $empleado_nomina_frente_semanal ->loadByNominaFrenteSemanal($value['id_nomina_frente_semanal']);
		foreach ($empleados_nominas as $item) {
			$monto_nomina+=$item['monto'] ;
			$bonificaciones=$bonificacion_semanal->loadByEmpleadoNominaFrente($item['id_empleado_nomina_frente_semanal']);
			//print_r($bonificaciones);
			//echo "<br>";
			if(!empty($bonificaciones)){
			
				$monto_nomina+=$bonificaciones['monto'];
				$empleado_nomina_frente_semanal->updateMonto($item['id_empleado_nomina_frente_semanal'], ($item['monto'] + $bonificaciones['monto'] ));
				$bonos[] = $bonificaciones['id_bonificacion_semanal'] ;
				//$bonificacion_semanal->updateEstatus($bonificaciones['id_bonificacion_semanal'], 'PAGADA');
//								echo "".$item['monto']. "     " . $bonificaciones['monto']  . "<br>" ;			
			}
			else{

			//	echo $bonificaciones['id_bonificacion_semanal'] . "<br><br>";
			}
		}

		$nomina_frente_semanal->loadById($value['id_nomina_frente_semanal']);
		$nomina_frente_semanal->update(array(
											'id_nomina_frente_semanal'=>$value['id_nomina_frente_semanal'],
											'monto'=>$monto_nomina,
											'observaciones'=>$nomina_frente_semanal->getObservaciones(),
											'estatus'=>$nomina_frente_semanal->getEstatus()
											));
	}

	$nomina_general_semanal ->updateMonto($nomina_general_semanal->getId(), round($nomina_frente_semanal ->getTotalNominasFrentes($nomina_general_semanal->getId()), $_SESSION['id_usuario']));


	/*
	Fin de calculo de montos totales
	*/




$row = 11;

$nominas_frentes = $nomina_frente_semanal->loadByNominaGeneralSemanal($nomina_general_semanal->getId());

foreach($nominas_frentes as  $dataRow) {

	if($dataRow['monto'] > 0 ) {  //inicio de if que filtra por frentes en 0

	$nominas_empleados = $empleado_nomina_frente_semanal->loadByNominaFrenteSemanal($dataRow['id_nomina_frente_semanal']);

	$frente_trabajo ->loadById($dataRow['id_frente_trabajo']);
		
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $frente_trabajo->getNombre());
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setName('Arial');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setSize(18);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'R'.$row);

	$frente[]= array('frente'=>$frente_trabajo->getNombre(),
		'monto'=>$dataRow['monto']);
	$row++;
		foreach ($nominas_empleados as $key ) {
			 if($key['monto']>0){  //comentario generado por pruebas
			 	$categoria = '' ;
			$empleado->loadById($key['id_empleado']);
			
					$compania_empleado->loadByEmpleado($key['id_empleado']); 
					$compania->loadById($compania_empleado->getCompania());

					$empleado_puesto->loadByEmpleado($key['id_empleado']);
					$puesto ->loadById($empleado_puesto->getPuesto());
					$categoria = $puesto->getNombre();

					if($key['lunes']==1)
						$l='P';
					else
						$l='O';
					
					if($key['martes']==1)
						$m='P';
					else
						$m='O';

					if($key['miercoles']==1)
						$mi='P';
					else
						$mi='O';

					if($key['jueves']==1)
						$j='P';
					else
						$j='O';

					if($key['viernes']==1)
						$v='P';
					else
						$v='O';
					
					if($key['sabado']==1)
						$s='P';
					else
						$s='O';
					
					if($key['domingo']==1)
						$d='P';
					else
						$d='O';


					$b=$bonificacion_semanal->loadByEmpleadoNominaFrente($key['id_empleado_nomina_frente_semanal']);
					if(!empty($b)){
						$boni= $b['monto'];
					}
					else{
						$boni=0;
					}
					
					$cuenta_bancaria->loadById($empleado->getCuentaBancaria());

					$ctabancaria=' '.$cuenta_bancaria->getNumeroCuenta().' ';

			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $empleado->getid())
	                              ->setCellValue('B'.$row, $empleado->getApellidoPaterno())
								  ->setCellValue('C'.$row, $empleado->getApellidoMaterno())
								  ->setCellValue('D'.$row, $empleado->getNombre())
								  ->setCellValue('E'.$row, $compania->getAbreviatura())
								  ->setCellValue('F'.$row, $categoria)
								  ->setCellValue('G'.$row, $empleado_puesto->getSalario())
								  ->setCellValue('H'.$row, $l)
								  ->setCellValue('I'.$row, $m)
								  ->setCellValue('J'.$row, $mi)
								  ->setCellValue('K'.$row, $j)
								  ->setCellValue('L'.$row, $v)
								  ->setCellValue('M'.$row, $s)
								  ->setCellValue('N'.$row, $d)
	                              ->setCellValue('O'.$row, $boni)
	                              ->setCellValue('P'.$row, 0)
	                              ->setCellValue('Q'.$row, $key['monto'])
	                              ->setCellValue('R'.$row, $ctabancaria)
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
	         }                   #  comentario generado por pruebas
		}
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TOTAL A PAGAR EN EL FRENTE '.$frente_trabajo->getNombre() );
		$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'P'.$row);
		$objPHPExcel->getActiveSheet()->setCellValue('Q'.$row, $dataRow['monto']);
		//$objPHPExcel->getActiveSheet()->mergeCells('Q'.$row.':'.'R'.$row);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setBreak( 'A' . $row, PHPExcel_Worksheet::BREAK_ROW);
		$row++;
	}		//fin del if de filtrado de frentes en 0
}  //fin foreach nominas


$row++;
$row++;
$acumulador= 0;

foreach ($frente as $value) {
	$acumulador=$acumulador+$value['monto'];
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $value['frente'])
								  ->setCellValue('D'.$row, $value['monto']);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE );
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);
	$row++;
}


	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, 'TOTAL A PAGAR EN ESTA NOMINA: ')
								  ->setCellValue('D'.$row, $acumulador);
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD_SIMPLE );
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'C'.$row);
	$row++;

	$nomina_general_semanal->loadById($nomina_general_semanal->getId());
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $nomina_general_semanal->getmonto());
	




// intento de imprimir los ceros:


	$row += 5 ;

/**

foreach($nominas_frentes as  $dataRow) {

	if($dataRow['monto'] == 0 ) {  //inicio de if que filtra por frentes en 0

	$nominas_empleados = $empleado_nomina_frente_semanal->loadByNominaFrenteSemanal($dataRow['id_nomina_frente_semanal']);

	$frente_trabajo ->loadById($dataRow['id_frente_trabajo']);
		
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $frente_trabajo->getNombre());
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setName('Arial');
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setSize(18);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
	$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'R'.$row);

	$frente[]= array('frente'=>$frente_trabajo->getNombre(),
		'monto'=>$dataRow['monto']);
	$row++;
		foreach ($nominas_empleados as $key ) {
			 if($key['monto'] == 0){  //comentario generado por pruebas
			$empleado->loadById($key['id_empleado']);
			
					$compania_empleado->loadByEmpleado($key['id_empleado']); 
					$compania->loadById($compania_empleado->getCompania());

					$empleado_puesto->loadByEmpleado($key['id_empleado']);

					if($key['lunes']==1)
						$l='P';
					else
						$l='O';
					
					if($key['martes']==1)
						$m='P';
					else
						$m='O';

					if($key['miercoles']==1)
						$mi='P';
					else
						$mi='O';

					if($key['jueves']==1)
						$j='P';
					else
						$j='O';

					if($key['viernes']==1)
						$v='P';
					else
						$v='O';
					
					if($key['sabado']==1)
						$s='P';
					else
						$s='O';
					
					if($key['domingo']==1)
						$d='P';
					else
						$d='O';


					$b=$bonificacion_semanal->loadByEmpleadoNominaFrente($key['id_empleado_nomina_frente_semanal']);
					if(!empty($b)){
						$boni= $b['monto'];
					}
					else{
						$boni=0;
					}
					
					$cuenta_bancaria->loadById($empleado->getCuentaBancaria());

					$ctabancaria=' '.$cuenta_bancaria->getNumeroCuenta().' ';

			$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $empleado->getid())
	                              ->setCellValue('B'.$row, $empleado->getApellidoPaterno())
								  ->setCellValue('C'.$row, $empleado->getApellidoMaterno())
								  ->setCellValue('D'.$row, $empleado->getNombre())
								  ->setCellValue('E'.$row, $compania->getAbreviatura())
								  ->setCellValue('F'.$row, $empleado_puesto->getSalario())
								  ->setCellValue('G'.$row, $l)
								  ->setCellValue('H'.$row, $m)
								  ->setCellValue('I'.$row, $mi)
								  ->setCellValue('J'.$row, $j)
								  ->setCellValue('K'.$row, $v)
								  ->setCellValue('L'.$row, $s)
								  ->setCellValue('M'.$row, $d)
	                              ->setCellValue('N'.$row, $boni)
	                              ->setCellValue('O'.$row, 0)
	                              ->setCellValue('P'.$row, $key['monto'])
	                              ->setCellValue('Q'.$row, $ctabancaria)
	                              ->setCellValue('R'.$row, $cuenta_bancaria->getBanco());
	                              
	                              $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setName('Arial');
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setSize(10);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								  

	                             
	                              // agregar un santo de pagina
	                              
	                              $row++;
	         }                   #  comentario generado por pruebas
		}
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'TOTAL A PAGAR EN EL FRENTE '.$frente_trabajo->getNombre() );
		$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLUE);
		$objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':'.'O'.$row);
		$objPHPExcel->getActiveSheet()->setCellValue('P'.$row, $dataRow['monto']);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setBreak( 'A' . $row, PHPExcel_Worksheet::BREAK_ROW);
		$row++;
	}		//fin del if de filtrado de frentes en 0
}  //fin foreach nominas

*/
//fin del intento de imprimir los ceros


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$name_file = "NOMINA_SEMANAL_".date('Y-m-d H-i-s').'.xls';
$objWriter->save("../files/nominas_semanales/".$name_file);



	
	$genera_nomina = new GeneraNominaSemanal();

	
	$genera_nomina->generaByNominaOld();
	foreach ($bonos as $key ) {
		$bonificacion_semanal->updateEstatus($key, 'PAGADA');
	}
	
	echo "<a href=\"../files/nominas_semanales/".$name_file."\">Descargar</a>";


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