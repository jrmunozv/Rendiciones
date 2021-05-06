<?php
require_once("../includes/config.php");
	
	

class Comprobante extends Conexion
{
	
	public function __construct()
    {
        parent::__construct();
    }

	public function imprrend()
    {
        
    	$folio = $_GET['folio'];
        $id_encrend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;
        $sql = "SELECT * FROM encrend 
	             WHERE id_encrend = '".$id_encrend."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$id_usuario= $reg['id_usuario'];
		$id_empresa= $reg['id_empresa'];
		//$id_usuariover= $reg['id_usuariover'];
		$fecha = date('d/m/Y', strtotime($reg['fecha']));
		$fondoasign= $reg['fondoasign'];
		$tipofondo= $reg['tipofondo'];
		$tipocuenta= $reg['tipocuenta'];
		$nrocuenta= $reg['nrocuenta'];
		$banco= $reg['banco'];
		$observacion= utf8_decode($reg['observacion']);
		
		


		$sql = "SELECT * FROM empresas 
	             WHERE id_empresa = '".$id_empresa."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$nombre= $reg['nombre'];
		$rut= $reg['rut'];
		$dv= $reg['dv'];
		$giro= $reg['giro'];
		$direccion= $reg['direccion'];
		$comuna= $reg['comuna'];
		$telefono= $reg['telefono'];
		$mail= $reg['mail'];
		$casilla= $reg['casilla'];
		$enviofacturas= $reg['enviofacturas'];
		$contacto= $reg['contacto'];
		$logo= $reg['logo'];


		$sql = "SELECT * FROM usuarios 
	             WHERE id_usuario = '".$id_usuario."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$usuario_sel= $reg['nombre'];
		$rutusuario_sel= $reg['rut'];
		$imgfirma= $reg['imgfirma'];
		$correo= $reg['correo'];


		$sql = "SELECT * FROM tipofondo 
	             WHERE id_tipofondo = '".$tipofondo."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$nombrefondo= $reg['nombrefondo'];
		



        require('../public/fpdf/fpdf.php');
		
		//Cell(ancho, alto, texto, bordes(L:izq, T:Sup, R:Der, B:Inf), salto lin, align, fondo) 
		$pdf = new FPDF('P','mm','Letter');
		$pdf->AddPage();
		
		$pdf->SetFont('Arial', '', 10);
		$pdf->Image('../public/images/'.$logo, 10, 10, 20, null,'PNG');
		
		$pdf->Cell(20, 12, '',1 , 0, 'L', false);
		$pdf->Cell(0, 12, 'Rendicion de Fondos', 1, 0, 'C', false);
		
		$pdf->Ln(12);
		$pdf->Ln(4);
		$pdf->SetFont('Arial', '', 6);
		$pdf->Cell(25, 2.7, 'Folio', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, $folio, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Fecha', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, $fecha, 1, 0, 'L', false);
		$pdf->Cell(50, 2.7, '', 0, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Banco'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $banco, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Responsable'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, $usuario_sel, 1, 0, 'L', false);
		$pdf->Cell(50, 2.7, '', 0, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Tipo Cuenta'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $tipocuenta, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Fondo Asignado'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, number_format($fondoasign, 0, ',', '.'), 1, 0, 'L', false);
		$pdf->Cell(50, 2.7, '', 0, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Nro. Cuenta'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $nrocuenta, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Tipo Fondo'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, $nombrefondo, 1, 0, 'L', false);
		$pdf->Cell(50, 2.7, '', 0, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Email'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $correo, 1, 0, 'L', false);


		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Observacion'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(169, 2.7, $observacion, 1, 0, 'L', false);

		$pdf->Ln(4);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(15, 4, 'Fecha', 1, 0, 'L', false);
		$pdf->Cell(15, 4, 'Tipo Doc.', 1, 0, 'L', false);
		$pdf->Cell(12, 4, utf8_decode('Nro.Doc'), 1, 0, 'L', false);
		$pdf->Cell(30, 4, 'Proveedor', 1, 0, 'L', false);
		$pdf->Cell(40, 4, 'Concepto', 1, 0, 'L', false);
		$pdf->Cell(69, 4, 'Cuenta-Centro', 1, 0, 'L', false);
		$pdf->Cell(15, 4, 'Monto CLP', 1, 0, 'L', false);


		$pdf->SetFont('Arial', '', 7);
		$pdf->Ln(4);

		$sql = "SELECT * FROM detrend 
		        WHERE id_detRend = '".$id_encrend."' AND elim= 1";
		$res= $this->conn->query($sql);

		while($reg = $res->fetch_array(MYSQLI_ASSOC))
		{	
			$fecha= $reg['fecha'];
			$rut= $reg['rut'];
			$concepto= $reg['concepto'];
			$nrodoc= $reg['nrodoc'];
			$tipodoc= $reg['tipodoc'];
			$monto= $reg['monto'];
			$matriz= $reg['matriz'];
			$fecha = date('d/m/Y', strtotime($reg['fecha']));


			$sql2 = "SELECT * FROM tipodoc 
		             WHERE id_tipodoc = '".$tipodoc."'";
			$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);
			$tipodoc= $reg2['tipodoc'];

			$sql2 = "SELECT * FROM auxiliares 
		             WHERE rut = '".$rut."'";
			$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);
			$nombreprov= $reg2['nombre'];
			$nombreprov= substr($nombreprov, 0, 18);


			$largo= $pdf->GetStringWidth($concepto);
			$largo= round($largo, 0);
			
			if ($largo > 1 && $largo < 40)
			{
				$alto= 4;
			}
			elseif ($largo > 40 && $largo < 80)
			{
				$alto= 8;
			}
			elseif ($largo > 80 && $largo < 160)
			{
				$alto= 12;
			}
			else
			{
				$alto= 16;		
			}


			$pdf->Cell(15, $alto, $fecha, 1, 0, 'R', false);
			$pdf->Cell(15, $alto, $tipodoc, 1, 0, 'L', false);
			$pdf->Cell(12, $alto, $nrodoc, 1, 0, 'R', false);
			$pdf->Cell(30, $alto, $nombreprov, 1, 0, 'L', false);
			
			//$pdf->Cell(120, 4, utf8_decode($detalle), 1, 0, 'L', false);
			$posx= $pdf->GetX() + 40;
			$posy= $pdf->GetY();
			$pdf->MultiCell(40, 4, utf8_decode($concepto), 1, 'L', false);
			$largo= $pdf->GetStringWidth($concepto);
			$largo= round($largo, 0);
			
			if ($largo > 1 && $largo < 40)
			{
				$alto= 4;
			}
			elseif ($largo > 40 && $largo < 80)
			{
				$alto= 8;
			}
			elseif ($largo > 80 && $largo < 160)
			{
				$alto= 12;
			}
			else
			{
				$alto= 16;		
			}
			
			$pdf->SetXY($posx, $posy);
			$matriz= substr($matriz, 0, 50);
			$pdf->Cell(69, $alto, $matriz, 1, 0, 'L', false);
			$pdf->Cell(15, $alto, number_format($monto, 0, ',', '.'), 1, 0, 'R', false);
				

			$posy2= $pdf->GetY() + $alto;
			$pdf->SetY($posy2);
			//$pdf->Ln(4);
			$total= $total + $monto;
			
		}

		//$total= 2349569;

		//Fondo fijo
		if ($tipofondo == 1)
		{
			if ($fondoasign > $total)
			{
				$comentario= 'Saldo a favor del trabajador';
				$montorend= $total;
			}
			elseif ($fondoasign < $total)
			{
				$comentario= 'Saldo a favor del trabajador';
				$montorend= $total;
			}
		}
		//Fondo extra
		elseif ($tipofondo == 2)
		{
			if ($fondoasign > $total)
			{
				$comentario= 'Saldo a favor de la empresa';
				$montorend= $fondoasign - $total;
			}
			elseif ($fondoasign == 0)
			{
				$comentario= 'Saldo a favor del trabajador';
				$montorend= $total;
			}
			elseif ($fondoasign < $total  && $fondoasign !== 0)
			{
				$comentario= 'Saldo a favor del trabajador';
				$montorend= $total - $fondoasign;
			}
		}


		$pdf->Ln(4);
		//$pdf->Cell(90, 4, '', 1);
		$pdf->Cell(179, 4, 'Total monto de la rendicion', 1, 0, 'L', false);
		$pdf->Cell(2, 4, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 4, number_format($total, 0, ',', '.'), 1, 0, 'R', false);

		$pdf->Ln(8);
		$pdf->Cell(95, 4, $comentario, 1, 0, 'L', false);
		$pdf->Cell(2, 4, ':', 1, 0, 'L', false);
		$pdf->Cell(15, 4, number_format($montorend, 0, ',', '.'), 1, 0, 'R', false);



		$pdf->SetY(185);		
		$pdf->Ln(8);
		$pdf->SetFont('Arial', '', 8);

		$pdf->Ln(4);
		//$pdf->Image('../public/images/'.$imgfirma , 140, 212 , 30, null,'PNG');


		$pdf->SetY(245);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(125, 3, '', 0, 0, 'L', false);
		$pdf->Cell(40, 3, utf8_decode($usuario_sel), 0, 0, 'C', false);

		$pdf->Ln(3);
		$pdf->Cell(125, 3, '', 0, 0, 'L', false);
		$pdf->Cell(40, 3, $nombre, 0, 0, 'C', false);

		
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(104,8,'',0);





		//Otra página

		$pdf->AddPage();
		
		$pdf->SetFont('Arial', '', 10);
		$pdf->Image('../public/images/'.$logo, 10, 10, 20, null,'PNG');
		
		$pdf->Cell(20, 12, '',1 , 0, 'L', false);
		$pdf->Cell(0, 12, 'Detalle contabilizacion', 1, 0, 'C', false);
		
		$pdf->Ln(12);
		$pdf->Ln(4);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(69, 4, 'Cuenta-Centro', 1, 0, 'L', false);
		$pdf->Cell(15, 4, 'Monto CLP', 1, 0, 'L', false);


		$pdf->SetFont('Arial', '', 7);
		$pdf->Ln(4);

		$sql = "SELECT DISTINCT matriz FROM detrend 
		        WHERE id_detRend = '".$id_encrend."' AND elim= 1";
		$res= $this->conn->query($sql);

		$total=0;
		while($reg = $res->fetch_array(MYSQLI_ASSOC))
		{	
			$matriz= $reg['matriz'];

			$sql2 = "SELECT SUM(monto) AS monto FROM detrend 
		        	WHERE id_detRend = '".$id_encrend."' AND matriz = '".$matriz."' AND elim= 1";
			$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);
			$monto= $reg2['monto'];
            
            $matriz= substr($matriz, 0, 50);
			$pdf->Cell(69, 4, $matriz, 1, 0, 'L', false);
			$pdf->Cell(15, 4, number_format($monto, 0, ',', '.'), 1, 0, 'R', false);
			$pdf->Ln(4);

			$total= $total + $monto;
			
		}

		$pdf->Ln(4);
		$pdf->Cell(67, 4, 'Total rendicion', 1, 0, 'L', false);
		$pdf->Cell(2, 4, ':', 1, 0, 'L', false);
		$pdf->Cell(15, 4, number_format($total, 0, ',', '.'), 1, 0, 'R', false);


		
		//$pdf->Output('Comprobante.pdf','D');
		$pdf->Output('Rendicion.pdf', 'I');
	}


}


$comp = new Comprobante();
$comp->imprrend();


?>