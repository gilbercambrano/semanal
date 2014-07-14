<?php
// archivos incluidos. Librer�as PHP para poder graficar.
include ("../funciones_php/FusionCharts.php");
//VER KE PEDOS
//include ("../NominaFrenteSemanal.php");
include("../../library/NominaFrenteSemanal.php");
include("../../library/FrenteTrabajo.php");
include("../../library/NominaGeneralSemanal.php");

// Gr�fico detalle: gr�fico de Torta o C�rculo.
// Obtengo los par�metros enviados por javascript.
// anio, valor del semestre 1, y valor del semestre 2
$id = $_POST['anio'];
$nomina_frente_semanal = new NominaFrenteSemanal();
$frentes=$nomina_frente_semanal->loadByNominaGeneralSemanal2($id);

$nombre_frente= new FrenteTrabajo(); 


$nomina_general_semanal = new NominaGeneralSemanal();
$nominas=$nomina_general_semanal->loadById($id);
//print_r($nominas);





$strXML = "";
$strXML2 = "";
$strXML = "<chart caption = 'Grafico por Frentes de Trabajo ".$nomina_general_semanal->getFechaGeneracion()."' bgColor='#CDDEE5' baseFontSize='12' formatNumberScale='0' numberPrefix='$' >";
$strXML2 = "<chart caption = 'Grafico por Frentes de Trabajo ".$id."' bgColor='#CDDEE5' baseFontSize='12' formatNumberScale='0' numberPrefix='$' >";
foreach ($frentes as $value) {
	
	$nombre_frente->loadById($value['id_frente_trabajo']);
	$nombre= "(".$value['id_frente_trabajo'].") ".$nombre_frente->getNombre();
	//$strXML .= "<set label = '".$value['id_frente_trabajo']."' value ='".$value['monto']."' />";
	$strXML .= "<set label = '"."(".$value['id_frente_trabajo'].")"."' value ='".$value['monto']."' />";
	$strXML2 .= "<set label = '".$nombre."' value ='".$value['monto']."' />";
}
// el id se encuentra en la variabele anio


// $strXML: Para concatenar los par�metros finales para el gr�fico.

// Armo los par�metros para el gr�fico. Todos estos datos se concatenan en una variable.
// Encabezado de la variable XML. Comienza con la etiqueta "Chart".
// caption: define el t�tulo del gr�fico. Asgno de titulo el A�o que fue seleccionado en la barra.
// bgColor: define el color de fondo que tendr� el gr�fico.
// baseFontSize: Tama�o de la fuente que se usar� en el gr�fico.

// Armado de cada porci�n del gr�fico en c�rculo.
// set label: asigno el nombre de cada porci�n.
// value: asigno el valor para cada porci�n.


// Cerramos la etiqueta "chart".
$strXML .= "</chart>";
$strXML2 .= "</chart>";
// Por �ltimo imprimo el gr�fico.
// renderChartHTML: funci�n que se encuentra en el archivo FusionCharts.php
// Env�a varios par�metros.
// 1er par�metro: indica la ruta y nombre del archivo "swf" que contiene el gr�fico. En este caso Columnas ( barras) 3D
// 2do par�metro: indica el archivo "xml" a usarse para graficar. En este caso queda vac�o "", ya que los par�metros lo pasamos por PHP.
// 3er par�metro: $strXML, es el archivo par�metro para el gr�fico. 
// 4to par�metro: "ejemplo". Es el identificador del gr�fico. Puede ser cualquier nombre.
// 5to y 6to par�metro: indica ancho y alto que tendr� el gr�fico.
// 7mo par�metro: "false". Trata del "modo debug". No es im,portante en nuestro caso, pero pueden ponerlo a true ara probarlo.
echo renderChartHTML("swf_charts/Pie3D.swf", "",$strXML, "detalle", 500, 350, false);
echo renderChartHTML("swf_charts/SSGrid.swf", "",$strXML2, "detalle", 500, 350, false);
?>