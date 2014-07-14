<?php

			$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');

$pdf->Output("archivos_fichas.pdf",'');
?>
<a href="archivos_fichas.pdf" target="_blank">D</a>