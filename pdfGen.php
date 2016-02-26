<?php
require('lib/fpdf.php');
session_start();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
foreach ($_SESSION['pdfTweet'] as $iter)
 {
 	$dim = $dim+ 40;
	$pdf->Text(10,$dim,$iter);
}
$pdf->Output();

?>