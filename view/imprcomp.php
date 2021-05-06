<?php

require('../public/fpdf/fpdf.php');
$con=mysql_connect("localhost","root","gestion2010");
$bd=mysql_select_db("existencias");

$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Image('../public/images/logo (2).png' , 10 ,8, 20 , 13,'PNG');
$pdf->Cell(18, 10, '', 0);
$pdf->Cell(150, 10, 'Comprobante', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, 'Hoy: '.date('d-m-Y').'', 0);
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(70, 8, '', 0);
$pdf->Cell(100, 8, 'COMPROBANTE DE EXISTENCIAS', 0);
$pdf->Ln(10);
$pdf->Cell(60, 8, '', 0);
//$pdf->Cell(100, 8, 'Desde: '.$verDesde.' hasta: '.$verHasta, 0);
$pdf->Ln(23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'Id', 0);
$pdf->Cell(15, 8, 'Codigo', 0);
$pdf->Cell(50, 8, 'Nombre Articulo', 0);
$pdf->Cell(25, 8, 'Entrada', 0);
$pdf->Cell(25, 8, 'Salida', 0);
$pdf->Cell(25, 8, 'Centro', 0);
$pdf->Cell(25, 8, 'Cuenta', 0);
$pdf->Ln(8);
$pdf->SetFont('Arial', '', 8);
//CONSULTA
$idcomp = 1; //$_POST['idcomp'];	

$sql = "SELECT id, idart, entrada, salida, centro, cuenta FROM detcomp 
        WHERE idcomp = '".$idcomp."' AND elim= 1";
$res = mysql_query($sql, $con);

while ($reg = mysql_fetch_array($res))
{
	$sql2 = "SELECT nombre_articulo FROM articulos 
             WHERE id = '".$reg['idart']."'";
	$res2 = mysql_query($sql2, $con);
	$reg2 = mysql_fetch_array($res2);

	$id= $reg['id'];
	$idart= $reg['idart'];
	$nombreart= $reg2['nombre_articulo'];
	$entrada= $reg['entrada'];
	$salida= $reg['salida'];
	$centro= $reg['centro'];
	$cuenta= $reg['cuenta'];

	$pdf->Cell(15, 8, $id, 0);
	$pdf->Cell(15, 8, $idart, 0);
	$pdf->Cell(50, 8, $nombreart, 0);
	$pdf->Cell(25, 8, $entrada, 0);
	$pdf->Cell(25, 8, $salida, 0);
	$pdf->Cell(25, 8, $centro, 0);
	$pdf->Cell(25, 8, $cuenta, 0);
	$pdf->Ln(8);
	
}

/*
while($productos2 = mysql_fetch_array($productos)){
	$item = $item+1;
	$totaluni = $totaluni + $productos2['precio_unit'];
	$totaldis = $totaldis + $productos2['precio_dist'];
	
	$pdf->Cell(15, 8, $item, 0);
	$pdf->Cell(70, 8,$productos2['nomb_prod'], 0);
	$pdf->Cell(40, 8, $productos2['tipo_prod'], 0);
	$pdf->Cell(25, 8, 'S/. '.$productos2['precio_unit'], 0);
	$pdf->Cell(25, 8, 'S/. '.$productos2['precio_dist'], 0);
	$pdf->Cell(25, 8, date('d/m/Y', strtotime($productos2['fecha_reg'])), 0);
	$pdf->Ln(8);
}
*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(104,8,'',0);

$pdf->Output('reporte.pdf','D');
?>