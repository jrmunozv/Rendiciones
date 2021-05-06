<?php
class  Tablas extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 
	
	public function buscarart()
    {
		$sql = "SELECT * FROM articulos";
		$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
		$salida="";
		//while($datos = mysql_fetch_array($r_query))
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			$salida.='
			 	{
			 		"codigo":"'.$datos['id'].'",
			 		"nombre":"'.$datos['nombre_articulo'].'",
			 		"um":"'.$datos['um'].'"
			 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarlug()
    {
		$sql = "SELECT * FROM lugarentrega";
		$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
		$salida="";
		//while($datos = mysql_fetch_array($r_query))
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			$salida.='
			 	{
			 		"codigo":"'.$datos['id_entr'].'",
			 		"nombre":"'.$datos['direccion'].'"
			 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarusu()
    {
		$sql = "SELECT * FROM usuarios";
		$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
		$salida="";
		//while($datos = mysql_fetch_array($r_query))
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			$salida.='
			 	{
			 		"codigo":"'.$datos['id_usuario'].'",
			 		"log":"'.$datos['login'].'",
			 		"nombre":"'.$datos['nombre'].'"
			 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscaraux()
    {
		$sql = "SELECT * FROM auxiliares";
		$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
		$salida="";
		//while($datos = mysql_fetch_array($r_query))
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			$salida.='
			 	{
			 		"rut":"'.$datos['rut'].'",
			 		"nombre":"'.$datos['nombre'].'"
			 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarmatriz()
    {
		$sql = "SELECT * FROM matriz WHERE id_usuario= '".$_SESSION["id_usuariosel"]."' AND id_empresa= '".$_SESSION["id_empresa"]."'";
		$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
		$salida="";
		//while($datos = mysql_fetch_array($r_query))
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			
			$largo= strlen($datos['cuentanom']);
			if ($largo < 60)
			{


			}

			$posicion1 = strpos($datos['cuentanom'], "->");
			//START NEGATIVO
			//$resultado = substr("pruebacadenas", -3);
			//echo $resultado; // imprime "nas"
			//$resultado = substr("pruebacadenas", -5, 1);
			//echo $resultado; // imprime "d"

			$cuentanom= substr($datos['cuentanom'], 0, 60);
			$cuentacentro= $datos['cuentacod'].$cuentanom." -> ".$datos['centrocod'].$datos['centronom'];

			$salida.='
			 	{
			 		"codigo":"'.$datos['id'].'",
			 		"nombre":"'.$cuentacentro.'"
			 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarcentro()
    {
		$sql = "SELECT * FROM centros";
		$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
		$salida="";
		//while($datos = mysql_fetch_array($r_query))
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			$salida.='
			 	{
			 		"codigo":"'.$datos['codigo'].'",
			 		"nombre":"'.$datos['nombre'].'"
			 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarrend()
    {
		
		$sql = "SELECT * FROM encrend WHERE id_usuario= '".$_SESSION["id_usuariosel"]."' AND id_empresa= '".$_SESSION["id_empresa"]."' AND elim= 1";

		$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
		$salida="";

		//while($datos = mysql_fetch_array($r_query))
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			$salida.='
			 	{
			 		"folio":"'.$datos['folio'].'",
			 		"observacion":"'.$datos['observacion'].'"
			 	},';
						 
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarrendaprob()
    {
		
		$sql = "SELECT * FROM encrend
		WHERE fecha >= '".$_POST['desdefecha']."' 
	      AND fecha <= '".$_POST['hastafecha']."' AND elim= 1";
		$r_query= $this->conn->query($sql);
		



		$salida="";
		
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
		{
			$sql2 = "SELECT nombre FROM usuarios 
		             WHERE id_usuario = '".$datos['id_usuario']."'";
			$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

			$sql3 = "SELECT estado FROM estado 
		             WHERE id_estado = '".$datos['estado']."'";
			$res3= $this->conn->query($sql3);
			$reg3 = $res3->fetch_array(MYSQLI_ASSOC);

			$sql4 = "SELECT SUM(monto) AS total FROM detrend 
		             WHERE id_detRend = '".$datos['id_encrend']."'";
			$res4= $this->conn->query($sql4);
			$reg4 = $res4->fetch_array(MYSQLI_ASSOC);
			$total= $reg4['total'];

			$sql5 = "SELECT nomabr FROM empresas 
		             WHERE id_empresa = '".$datos['id_empresa']."'";
			$res5= $this->conn->query($sql5);
			$reg5 = $res5->fetch_array(MYSQLI_ASSOC);

			$tipofondo= $datos['tipofondo'];
			$fondoasign= $datos['fondoasign'];
			//Fondo fijo
			if ($tipofondo == 1)
			{
				if ($fondoasign > $total)
				{
					//$comentario= 'Saldo a favor del trabajador';
					$montorend= $total;
				}
				elseif ($fondoasign < $total)
				{
					//$comentario= 'Saldo a favor del trabajador';
					$montorend= $total;
				}
			}
			//Fondo extra
			elseif ($tipofondo == 2)
			{
				if ($fondoasign > $total)
				{
					//$comentario= 'Saldo a favor de la empresa';
					$montorend= $fondoasign - $total;
				}
				elseif ($fondoasign == 0)
				{
					//$comentario= 'Saldo a favor del trabajador';
					$montorend= $total;
				}
				elseif ($fondoasign < $total  && $fondoasign !== 0)
				{
					//$comentario= 'Saldo a favor del trabajador';
					$montorend= $total - $fondoasign;
				}
			}




			if($datos['contabilidad'] == 1)
			{
				$contab='Hecho';
			}
			else
			{
				$contab='Pendiente';
			}

			if($datos['tesoreria'] == 1)
			{
				$tesoreria='Pagado';
			}
			else
			{
				$tesoreria='Impago';
			}

			if($datos['aprobar'] == 1)
			{
				$aprobar='Aprobado';
			}
			else
			{
				$aprobar='Pending';
			}

			$salida.='
			 	{
			 		"codrend":"'.$datos['id_encrend'].'",
			 		"folio":"'.$datos['folio'].'",
			 		"fecha":"'.$datos['fecha'].'",
			 		"usuario":"'.$reg2['nombre'].'",
			 		"empresa":"'.$reg5['nomabr'].'",
			 		"estado":"'.$reg3['estado'].'",
			 		"monto":"'.number_format($montorend, 0, ',', '.').'",
			 		"detalle":"'.$datos['observacion'].'",
			 		"contab":"'.$contab.'",
			 		"pago":"'.$tesoreria.'",
			 		"aprobar":"'.$aprobar.'"
			 	},';					 
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarrenddet()
    {
		
		$folio = $_POST['folio'];
	    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;

		$sql = "SELECT id, fecha, rut, monto, tipodoc, nrodoc, concepto, matriz FROM detrend 
		        WHERE id_detRend = '".$id_encRend."' AND elim= 1";
		$res= $this->conn->query($sql);
		
		$salida="";

		while($reg = $res->fetch_array(MYSQLI_ASSOC))
		{
			
			$sql2 = "SELECT nombre FROM auxiliares 
		             WHERE rut = '".$reg['rut']."'";
			$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);
			

			$salida.='
				 	{
				 		"id":"'.$reg['id'].'",
				 		"fecha":"'.$reg['fecha'].'",
				 		"rut":"'.$reg['rut'].'",
				 		"proveedor":"'.$reg2['nombre'].'",
				 		"monto":"'.number_format($reg['monto'], 0, ',', '.').'",
				 		"tipodoc":"'.$reg['tipodoc'].'",
				 		"nrodoc":"'.$reg['nrodoc'].'",
				 		"concepto":"'.$reg['concepto'].'",
				 		"matriz":"'.$reg['matriz'].'"
				 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarrendarch()
    {
		
		$folio = $_POST['folio'];
	    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;

		$sql = "SELECT id, archivo, nuevoarchivo FROM archrend 
		        WHERE id_detRend = '".$id_encRend."' AND elim= 1";
		$res= $this->conn->query($sql);
		
		$salida="";

		while($reg = $res->fetch_array(MYSQLI_ASSOC))
		{
			$salida.='
				 	{
				 		"id":"'.$reg['id'].'",
				 		"archivo":"'.$reg['archivo'].'",
				 		"nuevoarchivo":"'.$reg['nuevoarchivo'].'"
				 	},';
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }

    public function buscarreg()
    {
		if($_POST['tipo']==0)
		{
			$sql = "SELECT idcomp, tipo, fecha, comentario FROM enccomp 
	                WHERE fecha >= '".$_POST['desdefecha']."' 
	                AND fecha <= '".$_POST['hastafecha']."'
	                AND idcomp >= '".$_POST['desdeidart']."'
	                AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        }else
        {
	        $sql = "SELECT idcomp, tipo, fecha, comentario FROM enccomp 
	                WHERE fecha >= '".$_POST['desdefecha']."' 
	                AND fecha <= '".$_POST['hastafecha']."'
	                AND idcomp >= '".$_POST['desdeidart']."'
	                AND tipo = '".$_POST['tipo']."'
	                AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        }

        $res= $this->conn->query($sql);

		//$res = mysql_query($sql,parent::con());
		
		
		$salida="";
		//while ($reg = mysql_fetch_array($res))
		while($reg = $res->fetch_array(MYSQLI_ASSOC))
		{
			$sql2 = "SELECT id, idart, entrada, salida, centro, cuenta FROM detcomp 
        	WHERE idcomp = '".$reg['idcomp']."' AND elim = 1";	
        	$res2= $this->conn->query($sql2);
        	
        	//$res2 = mysql_query($sql2,parent::con());
        	//while ($reg2 = mysql_fetch_array($res2))
        	while($reg2 = $res2->fetch_array(MYSQLI_ASSOC))
			{
				$sql3 = "SELECT nombre_articulo FROM articulos 
		             WHERE id = '".$reg2['idart']."'";
				$res3= $this->conn->query($sql3);
				$reg3 = $res3->fetch_array(MYSQLI_ASSOC);

				//$res3 = mysql_query($sql3,parent::con());
				//$reg3 = mysql_fetch_array($res3);

				$sql4 = "SELECT descripcion FROM tipomov 
		             WHERE idtipomov = '".$reg['tipo']."'";
				$res4= $this->conn->query($sql4);
				$reg4 = $res4->fetch_array(MYSQLI_ASSOC);


				//$res4 = mysql_query($sql4,parent::con());
				//$reg4 = mysql_fetch_array($res4);

				$salida.='
					 	{
					 		"folio":"'.$reg['idcomp'].'",
					 		"tipo":"'.$reg4['descripcion'].'",
					 		"fecha":"'.$reg['fecha'].'",
					 		"comentario":"'.$reg['comentario'].'",
					 		"id":"'.$reg2['id'].'",
					 		"codigo":"'.$reg2['idart'].'",
					 		"articulo":"'.$reg3['nombre_articulo'].'",
					 		"entrada":"'.$reg2['entrada'].'",
					 		"salida":"'.$reg2['salida'].'",
					 		"centro":"'.$reg2['centro'].'",
					 		"cuenta":"'.$reg2['cuenta'].'"
					 	},';
			}
		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';
    }
	
	public function buscarstock()
    {
		$saldoinicial=0;
		$compras=0;
		$traspasoentrada=0;
		$ajusteentrada=0;
		$consumos=0;
		$traspasosalida=0;
		$ventas=0;
		$ajustesalida=0;
		$saldofinal=0;

		$sql = "SELECT DISTINCT idart FROM detcomp 
                WHERE fecha >= '".$_POST['desdefecha']."' 
                AND fecha <= '".$_POST['hastafecha']."'
                AND idcomp >= '".$_POST['desdeidart']."'
                AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        
		$res= $this->conn->query($sql);

		//$res = mysql_query($sql,parent::con());
		
		
		$salida="";
		//while ($reg = mysql_fetch_array($res))
		while($reg = $res->fetch_array(MYSQLI_ASSOC))
		{	
			//Saldo inicial
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE idart = '".$reg['idart']."'
        	AND fecha < '".$_POST['desdefecha']."'
        	AND elim = 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$saldoinicial=$reg2['entrada']-$reg2['salida'];

        	//compras
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE fecha >= '".$_POST['desdefecha']."' 
            AND fecha <= '".$_POST['hastafecha']."'
            AND idcomp >= '".$_POST['desdeidart']."'
            AND idart = '".$reg['idart']."'
            AND tipo = 1 
            AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$compras=$reg2['entrada']-$reg2['salida'];

        	//traspaso entrada
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE fecha >= '".$_POST['desdefecha']."' 
            AND fecha <= '".$_POST['hastafecha']."'
            AND idcomp >= '".$_POST['desdeidart']."'
            AND idart = '".$reg['idart']."'
            AND tipo = 2
            AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$traspasoentrada=$reg2['entrada']-$reg2['salida'];

        	//ajuste entrada
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE fecha >= '".$_POST['desdefecha']."' 
            AND fecha <= '".$_POST['hastafecha']."'
            AND idcomp >= '".$_POST['desdeidart']."'
            AND idart = '".$reg['idart']."'
            AND tipo = 3
            AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$ajusteentrada=$reg2['entrada']-$reg2['salida'];

        	//consumo
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE fecha >= '".$_POST['desdefecha']."' 
            AND fecha <= '".$_POST['hastafecha']."'
            AND idcomp >= '".$_POST['desdeidart']."'
            AND idart = '".$reg['idart']."'
            AND tipo = 4
            AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$consumos=$reg2['entrada']-$reg2['salida'];

        	//traspaso salida
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE fecha >= '".$_POST['desdefecha']."' 
            AND fecha <= '".$_POST['hastafecha']."'
            AND idcomp >= '".$_POST['desdeidart']."'
            AND idart = '".$reg['idart']."'
            AND tipo = 5
            AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$traspasosalida=$reg2['entrada']-$reg2['salida'];

        	//venta
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE fecha >= '".$_POST['desdefecha']."' 
            AND fecha <= '".$_POST['hastafecha']."'
            AND idcomp >= '".$_POST['desdeidart']."'
            AND idart = '".$reg['idart']."'
            AND tipo = 6
            AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$ventas=$reg2['entrada']-$reg2['salida'];

        	//ajuste salida
			$sql2 = "SELECT SUM(entrada) AS entrada, SUM(salida) AS salida FROM detcomp 
        	WHERE fecha >= '".$_POST['desdefecha']."' 
            AND fecha <= '".$_POST['hastafecha']."'
            AND idcomp >= '".$_POST['desdeidart']."'
            AND idart = '".$reg['idart']."'
            AND tipo = 7
            AND idcomp <= '".$_POST['hastaidart']."' AND elim= 1";
        	$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

        	//$res2 = mysql_query($sql2,parent::con());
        	//$reg2 = mysql_fetch_array($res2);
        	$ajustesalida=$reg2['entrada']-$reg2['salida'];

        	$saldofinal=$saldoinicial+$compras+$traspasoentrada+$ajusteentrada+$consumos+$traspasosalida+$ventas+$ajustesalida;

        	$sql2 = "SELECT nombre_articulo, um FROM articulos 
		             WHERE id = '".$reg['idart']."'";
			$res2= $this->conn->query($sql2);
			$reg2 = $res2->fetch_array(MYSQLI_ASSOC);

			//$res2 = mysql_query($sql2,parent::con());
			//$reg2 = mysql_fetch_array($res2);

			$salida.='
				 	{
				 		"idart":"'.$reg['idart'].'",
				 		"nombreart":"'.$reg2['nombre_articulo'].'",
				 		"um":"'.$reg2['um'].'",
				 		"saldoinicial":"'.$saldoinicial.'",
				 		"compra":"'.$compras.'",
				 		"traspasoentrada":"'.$traspasoentrada.'",
				 		"ajusteentrada":"'.$ajusteentrada.'",
				 		"consumo":"'.$consumos.'",
				 		"traspasosalida":"'.$traspasosalida.'",
				 		"venta":"'.$ventas.'",
				 		"ajustesalida":"'.$ajustesalida.'",
				 		"saldofinal":"'.$saldofinal.'"
				 	},';

			$saldoinicial=0;
			$compras=0;
			$traspasoentrada=0;
			$ajusteentrada=0;
			$consumos=0;
			$traspasosalida=0;
			$ventas=0;
			$ajustesalida=0;
			$saldofinal=0;


		}

		$salida = substr($salida, 0, strlen($salida)-1);
		echo '{"data": ['.$salida.']}';	
    }


}



?>