<?php
// archivos incluidos. Librerías PHP para poder graficar.
include ("../funciones_php/FusionCharts.php");
//VER KE PEDOS
//include ("../NominaFrenteSemanal.php");
include("../../library/NominaFrenteSemanal.php");
include("../../library/FrenteTrabajo.php");
include("../../library/NominaGeneralSemanal.php");

// Gráfico detalle: gráfico de Torta o Círculo.
// Obtengo los parámetros enviados por javascript.
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


// $strXML: Para concatenar los parámetros finales para el gráfico.

// Armo los parámetros para el gráfico. Todos estos datos se concatenan en una variable.
// Encabezado de la variable XML. Comienza con la etiqueta "Chart".
// caption: define el título del gráfico. Asgno de titulo el Año que fue seleccionado en la barra.
// bgColor: define el color de fondo que tendrá el gráfico.
// baseFontSize: Tamaño de la fuente que se usará en el gráfico.

// Armado de cada porción del gráfico en círculo.
// set label: asigno el nombre de cada porción.
// value: asigno el valor para cada porción.


// Cerramos la etiqueta "chart".
$strXML .= "</chart>";
$strXML2 .= "</chart>";
// Por último imprimo el gráfico.
// renderChartHTML: función que se encuentra en el archivo FusionCharts.php
// Envía varios parámetros.
// 1er parámetro: indica la ruta y nombre del archivo "swf" que contiene el gráfico. En este caso Columnas ( barras) 3D
// 2do parámetro: indica el archivo "xml" a usarse para graficar. En este caso queda vacío "", ya que los parámetros lo pasamos por PHP.
// 3er parámetro: $strXML, es el archivo parámetro para el gráfico. 
// 4to parámetro: "ejemplo". Es el identificador del gráfico. Puede ser cualquier nombre.
// 5to y 6to parámetro: indica ancho y alto que tendrá el gráfico.
// 7mo parámetro: "false". Trata del "modo debug". No es im,portante en nuestro caso, pero pueden ponerlo a true ara probarlo.
echo renderChartHTML("swf_charts/Pie3D.swf", "",$strXML, "detalle", 500, 350, false);
echo renderChartHTML("swf_charts/SSGrid.swf", "",$strXML2, "detalle", 500, 350, false);
?>