<?php
require_once("../includes/config.php");
	
	

class Comprobante extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 
	public function improc()
    {
        $nrooc = $_GET['nrooc'];
        $sql = "SELECT * FROM encoc 
	             WHERE nroOC = '".$nrooc."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$id_usuario= $reg['id_usuario'];
		$id_empresa= $reg['id_empresa'];
		$fecha = date('d/m/Y', strtotime($reg['fecha']));
		$cotizacion= $reg['cotizacion'];
		$rutaux= $reg['rutaux'];
		$solicitante= $reg['solicitante'];
		$lugarenvio= $reg['lugarenvio'];
		$entrega= $reg['entrega'];
		$pago= $reg['pago'];
		$presupuesto= $reg['presupuesto'];
		$tipocambio= $reg['tipocambio'];
		$observacion= $reg['observacion'];
		$cuenta= $reg['cuenta'];
		$centrocosto= $reg['centrocosto'];
		$porcentpago= $reg['porcentpago'];
		$neto= $reg['neto'];
		$iva= $reg['iva'];
		$total= $reg['total'];
		


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



		$sql = "SELECT * FROM auxiliares 
	             WHERE rut = '".$rutaux."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$auxdv= $reg['dv'];
		$auxnombre= $reg['nombre'];
		$auxdireccion= $reg['direccion'];
		$auxcomuna= $reg['comuna'];
		$auxtelefono= $reg['telefono'];
		$auxcelular= $reg['celular'];
		$auxmail= $reg['mail'];
		$auxcontacto= $reg['contacto'];
		$auxctacte= $reg['ctacte'];
		$auxbanco= $reg['banco'];


		$sql = "SELECT * FROM lugarentrega 
	             WHERE id_entr = '".$lugarenvio."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$lugdireccion= $reg['direccion'];

		$sql = "SELECT * FROM solicitante 
	             WHERE id_sol = '".$solicitante."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$nomsolicitante= $reg['solicitante'];

		$sql = "SELECT * FROM condicionpago 
	             WHERE id_cp = '".$pago."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$condpago= $reg['condpago'];

		$sql = "SELECT * FROM cuentas 
	             WHERE codigo = '".$cuenta."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$nomcuenta= $cuenta." ".$reg['nombre'];

		$sql = "SELECT * FROM centros 
	             WHERE codigo = '".$centrocosto."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$nomcentrocosto= $centrocosto." ".$reg['nombre'];

		$sql = "SELECT * FROM usuarios 
	             WHERE id_usuario = '".$id_usuario."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		$nomusuario= $reg['nombre'];
		$imgfirma= $reg['imgfirma'];
		

        require('../public/fpdf/fpdf.php');
		
		//Cell(ancho, alto, texto, bordes(L:izq, T:Sup, R:Der, B:Inf), salto lin, align, fondo) 
		$pdf = new FPDF('P','mm','Letter');
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 10);
		$pdf->Image('../public/images/'.$logo, 10, 10, 20, null,'PNG');
		$pdf->Cell(20, 12, '',1 , 0, 'L', false);
		$pdf->Cell(0, 12, 'ORDEN DE COMPRA', 1, 0, 'C', false);
		
		$pdf->Ln(12);
		$pdf->SetFont('Arial', '', 6);
		$pdf->Cell(25, 2.7, 'Orden de Compra', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, $nrooc, 0, 0, 'L', false);
		
		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Cotización'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, $cotizacion, 0, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Fecha', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(30, 2.7, $fecha, 0, 1, 'L', false);
		
		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'De', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $nombre, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, 'Atte Sr(a)', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $auxcontacto, 1, 0, 'L', false);


		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Razón Social'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $nombre, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Móvil'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $auxcelular, 1, 0, 'L', false);




		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Rut', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $rut."-".$dv, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Razón Social'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $auxnombre, 1, 0, 'L', false);



		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Dirección'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $direccion, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, 'Rut', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $rutaux."-".$auxdv, 1, 0, 'L', false);





		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Comuna', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $comuna, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Dirección'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $auxdireccion, 1, 0, 'L', false);



		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Giro', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $giro, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, 'Comuna', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $auxcomuna, 1, 0, 'L', false);




		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Teléfono'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $telefono, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, utf8_decode('Teléfono'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $auxtelefono, 1, 0, 'L', false);






		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Mail', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $mail, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, 'Mail', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $auxmail, 1, 0, 'L', false);




		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Casilla', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $casilla, 1, 0, 'L', false);
		
		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Envío y pago de facturas'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $enviofacturas, 1, 0, 'L', false);
		
		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Atte', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $contacto, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, 'Solicitante', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $nomsolicitante, 1, 1, 'L', false);
		
		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, utf8_decode('Envío'), 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $lugdireccion, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Entrega', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $entrega, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Pago', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $condpago, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Cuenta corriente', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $auxctacte, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Banco', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $auxbanco, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Presupuesto', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(70, 2.7, $presupuesto, 1, 0, 'L', false);
		$pdf->Cell(15, 2.7, 'Tipo cambio', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $tipocambio, 1, 0, 'L', false);







		$pdf->Ln(4);
		$pdf->SetFont('Arial', 'B', 7);
		$pdf->Cell(25, 4, 'Cantidad', 1, 0, 'L', false);
		$pdf->Cell(10, 4, 'UM', 1, 0, 'L', false);
		$pdf->Cell(120, 4, utf8_decode('Descripción'), 1, 0, 'L', false);
		$pdf->Cell(20, 4, 'Precio unitario', 1, 0, 'L', false);
		$pdf->Cell(0, 4, 'Precio Total', 1, 0, 'L', false);
		


		$pdf->SetFont('Arial', '', 7);
		$pdf->Ln(4);
	    $id_encOC = $_SESSION["backend_id"].$_SESSION["id_empresa"].$nrooc;

		$sql = "SELECT * FROM detoc 
		        WHERE id_detOC = '".$id_encOC."' AND elim= 1";
		$res= $this->conn->query($sql);

		while($reg = $res->fetch_array(MYSQLI_ASSOC))
		{
			
			$sql2 = "SELECT um FROM um 
		             WHERE id_um = '".$reg['um']."'";
			$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

			

			$cantidad= $reg['cantidad'];
			$um= $reg2['um'];
			$detalle= $reg['detalle'];
			$precio= $reg['precio'];
			$netodet= $reg['neto'];

			$pdf->Cell(25, 4, number_format($cantidad, 2, ',', '.'), 1, 0, 'R', false);
			$pdf->Cell(10, 4, $um, 1, 0, 'L', false);
			//$pdf->Cell(120, 4, utf8_decode($detalle), 1, 0, 'L', false);
			$posx= $pdf->GetX() + 120;
			$posy= $pdf->GetY();
			$pdf->MultiCell(120, 4, utf8_decode($detalle), 1, 'L', false);
			$largo= $pdf->GetStringWidth($detalle);
			$largo= round($largo, 0);
			
			if ($largo > 1 && $largo < 120)
			{
				$alto= 4;
			}
			elseif ($largo > 120 && $largo < 240)
			{
				$alto= 8;
			}
			elseif ($largo > 240 && $largo < 360)
			{
				$alto= 12;
			}
			else
			{
				$alto= 16;		
			}
			
			$pdf->SetXY($posx, $posy);
			$pdf->Cell(20, 4, number_format($precio, 0, ',', '.'), 1, 0, 'R', false);
			$pdf->Cell(0, 4, number_format($netodet, 0, ',', '.'), 1, 0, 'R', false);
			$posy2= $pdf->GetY() + $alto;
			$pdf->SetY($posy2);
			//$pdf->Ln(4);
			
		}








		$pdf->SetY(185);		
		$pdf->Ln(8);
		$pdf->SetFont('Arial', '', 8);

		$pdf->Cell(140, 4, 'NO SE RECIBIRAN FACTURAS SIN SU ORDEN DE COMPRA ADJUNTA', 1, 0, 'L', false);
		$pdf->Cell(20, 4, 'Neto', 1, 0, 'L', false);
		$pdf->Cell(2, 4, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 4, number_format($neto, 0, ',', '.'), 1, 0, 'R', false);
		$pdf->Ln(4);
		$pdf->Cell(140, 4, 'EL PROVEEDOR ES RESPONSABLE DE REVISAR TODOS LOS DATOS DE LA OC', 1, 0, 'L', false);
		$pdf->Cell(20, 4, 'IVA', 1, 0, 'L', false);
		$pdf->Cell(2, 4, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 4, number_format($iva, 0, ',', '.'), 1, 0, 'R', false);
		$pdf->Ln(4);
		$pdf->Cell(140, 4, '', 1);
		$pdf->Cell(20, 4, 'Total', 1, 0, 'L', false);
		$pdf->Cell(2, 4, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 4, number_format($total, 0, ',', '.'), 1, 0, 'R', false);

		$pdf->SetFont('Arial', '', 6);
		$pdf->Ln(4);
		$pdf->Cell(25, 2.7, 'Observaciones', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(0, 2.7, $observacion, 1, 0, 'L', false);

		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Cuenta', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(100, 2.7, $nomcuenta, 1, 0, 'L', false);
		
		
		$pdf->Ln(2.7);
		$pdf->Cell(25, 2.7, 'Centro costo', 1, 0, 'L', false);
		$pdf->Cell(2, 2.7, ':', 1, 0, 'L', false);
		$pdf->Cell(100, 2.7, $nomcentrocosto, 1, 0, 'L', false);

		$pdf->Ln(4);
		$pdf->Image('../public/images/'.$imgfirma , 140, 212 , 30, null,'PNG');


		$pdf->SetY(238);
		$pdf->SetFont('Arial', '', 7);
		$pdf->Cell(125, 3, '', 1, 0, 'L', false);
		$pdf->Cell(40, 3, utf8_decode($nomusuario), 1, 0, 'C', false);

		$pdf->Ln(3);
		$pdf->Cell(125, 3, '', 1, 0, 'L', false);
		$pdf->Cell(40, 3, $nombre, 1, 0, 'C', false);

		$pdf->Ln(10);
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(100, 4, 'FACTURACION ELECTRONICA A: facturas@sbchile.cl - sosorno@sbchile.cl', 1, 0, 'L', false);
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(0, 4, 'Favor adjuntar OC a Factura', 1, 0, 'R', false);

		
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(104,8,'',0);

		//$pdf->Output('Comprobante.pdf','D');
		$pdf->Output('Comprobante.pdf', 'I');
	}


}

$comp=new Comprobante();
$comp->improc();


?>