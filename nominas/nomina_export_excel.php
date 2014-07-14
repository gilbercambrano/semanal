<?php


	session_start();
	
	if(!empty($_SESSION)) {
		set_time_limit(0);
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2012 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2012 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.8, 2012-10-12
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
require_once '../Classes/PHPExcel/IOFactory.php';



echo date('H:i:s') , " abrir para templete cinco" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/30template.xls");
echo date('H:i:s') , " Adicionar nuevo templete" , EOL;


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













	//$objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel(time()));

$row = 11;

$nominas_frentes = $nomina_frente_semanal->loadByNominaGeneralSemanal($nomina_general_semanal->getId());
//print_r($nominas_frentes) ;

//echo "<br><br>";
// ver ke paso con el id nomina frente 
foreach($nominas_frentes as  $dataRow) {

	if($dataRow['monto'] > 0 ) {  //inicio de if que filtra por frentes en 0

	$nominas_empleados = $empleado_nomina_frente_semanal->loadByNominaFrenteSemanal($dataRow['id_nomina_frente_semanal']);

	//print_r($nominas_empleados) ;

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
//						print_r($boni) ;
//						echo "<br><br>";
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
	                              //->setCellValue('S'.$row, $frente_trabajo->getNombre());
	                              $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setName('Arial');
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setSize(10);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								  //$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL]);

	                              //->setCellValue('S'.$row, $r);
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


$row++;
$row++;
$acumulador= 0;

//echo "-------------------------------";
//print_r($frentes);

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



foreach($nominas_frentes as  $dataRow) {

	if($dataRow['monto'] == 0 ) {  //inicio de if que filtra por frentes en 0

	$nominas_empleados = $empleado_nomina_frente_semanal->loadByNominaFrenteSemanal($dataRow['id_nomina_frente_semanal']);

	//print_r($nominas_empleados) ;

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
//						print_r($boni) ;
//						echo "<br><br>";
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
	                              //->setCellValue('S'.$row, $frente_trabajo->getNombre());
	                              $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setName('Arial');
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setSize(10);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->setBold(false);
								  $objPHPExcel->getActiveSheet()->getStyle('A'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('P'.$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
								  $objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
								  //$objPHPExcel->getActiveSheet()->getStyle('Q'.$row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL]);

	                              //->setCellValue('S'.$row, $r);
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


//fin del intento de imprimir los ceros

//$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save(str_replace('.php', '.xls', __FILE__));
$objWriter->save("NOMINA_SEMANAL_".date('Y-m-d').'.xls');

/*
echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
echo date('H:i:s') , " poka memoria: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Escribeindo archivo" , EOL;
echo 'el archivo asido modificado ' , getcwd() , EOL;



*/

/*

*/


	
	$genera_nomina = new GeneraNominaSemanal();

	
	$genera_nomina->generaByNominaOld();
	foreach ($bonos as $key ) {
		$bonificacion_semanal->updateEstatus($key, 'PAGADA');
	}
	//header("location: descargar_nomina.php");
	echo "<a href=\"nomina_export_excel.xls\">Descargar</a>";

}
/*

*/