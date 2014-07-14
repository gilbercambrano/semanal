<?php
	include_once("Fpdf.php");
	include_once("Empleado.php");
	include_once("EmpleadoPuesto.php");
	include_once("Puesto.php");
	$opcion = $_GET['tipo'] ;
	$id_aspirante = $_GET['id_aspirante'] ;
	$aspirante = new Empleado();
	$empleado_puesto = new EmpleadoPuesto();
	$puesto = new Puesto();
	$empleado_puesto->loadByEmpleado($id_aspirante);
	$aspirante->loadById($id_aspirante);
	$puesto->loadById( $empleado_puesto->getPuesto());
	switch ($opcion) {
		case 1:

			$pdf = new PDF();
			$pdf->setMargins(20,20);
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetFont('Times','',12);
			$pdf->Cell(0, 10, "Atencion:  Dr. Oscar San Miguel Bravo", 0, 1);
			$pdf->Cell(0, 10, "Direccion:  Av. Sandino Frente a la Clinica CERACOM"  , 0, 1);
			$pdf->Cell(0, 10, "", 0, 1);
			$pdf->Cell(0, 10, 'Nombre:  ' . $aspirante->getNombreCompleto($id_aspirante), 0, 1);
			$pdf->Cell(0, 10, 'Categoria:'. $puesto->getNombre(), 0, 1);
			$pdf->Cell(0, 10, 'Tipo de servicio solicitado:  Analisis Clinicos', 0, 1);
			$pdf->Output();
		break;
		
	}
?>