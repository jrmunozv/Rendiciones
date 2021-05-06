<?php
class  Comprobante extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 
	public function guardareditaroc()
    {	
    	if ($_POST['accion']=='guardaroc')
		{
	    	//$nrooc = $_POST['nrooc'];
	    	$nrooc = $_POST['nrooc'];
	    	$id_encOC = $_SESSION["backend_id"].$_SESSION["id_empresa"].$nrooc;
	    	
			$query = "SELECT * FROM encoc WHERE id_encOC= '".$id_encOC."' AND elim= 1";
            $r_query= $this->conn->query($query);
            $filas = $r_query->num_rows;

			if($filas==1)
			{
				$_POST['accion']='editaroc';
				$this->editaroc();
			}
			else
			{
				$this->guardaroc();
			}
		}
    }

    public function guardareditarocdet()
    {	
    	if ($_POST['accion']=='guardarocdet')
		{
			$query = "SELECT * FROM detoc WHERE id= '". $_POST['iddetoc']."'";
			$r_query= $this->conn->query($query);
            $filas = $r_query->num_rows;

            //$r_query = mysql_query($query,parent::con());
			//$filas = mysql_num_rows($r_query);
			if($filas==1)
			{
				$_POST['accion']='editarocdet';
				$this->editarocdet();
			}
			else
			{
				$this->guardarocdet();
			}
		}
    }

    public function guardaroc()
    {	
    	//session_start();
		//sleep(0);
		$fecha = date('Ym', strtotime($_POST['fecha']));
		$ano = intval(substr($fecha, 0, 4));
		$mes = intval(substr($fecha, 4, 2));

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "El periodo Mes:".$mes." Año:".$ano." está cerrado. No se puede realizar la operacion solicitada.";
		$contenidoOK = "";
		$buscar="";

		$query = "SELECT * FROM periodo WHERE ano= '". $ano."' AND mes= '". $mes."'";
        $r_query= $this->conn->query($query);
        $datos = $r_query->fetch_array(MYSQLI_ASSOC);
        $ac=$datos['ac'];

        if ($ac==0)
		{
			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError);
			echo json_encode($salidaJson);
		}
		else
		{
	    	$sql = "SELECT MAX(nroOC) AS nroOC FROM encoc WHERE id_usuario= '".$_SESSION["backend_id"]."' AND id_empresa= '".$_SESSION["id_empresa"]."'";
			$r_query= $this->conn->query($sql);

			$filas = $r_query->num_rows;
	        if($filas==0)
	        {
	        	
	        }
	        else
	        {
				$datos = $r_query->fetch_array(MYSQLI_ASSOC);
				$usarfolio = $datos['nroOC'] + 1;
	    	}
	    	$nrooc = $usarfolio;
	    	$id_encOC = $_SESSION["backend_id"].$_SESSION["id_empresa"].$nrooc;

	    	//VALIDAR ESTADO
	        if ($_POST['estado']== 0 || !filter_var($_POST['estado'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el estado. ';
	        }

	        //VALIDAR COTIZACION
			$cotizacion= trim($_POST['cotizacion']);
	        $cotizacion= mysqli_escape_string($this->conn,strip_tags($cotizacion));
			
	        //VALIDAR RUT PROVEEDOR
	        if (empty($_POST['rutaux']) || $_POST['rutaux']== null || !filter_var($_POST['rutaux'], FILTER_VALIDATE_INT))
			{
				$errors[] = 'Tienes que seleccionar el rut de proveedor de forma correcta. ';
			}

			//VALIDAR OBSERVACION
			$observacion= trim($_POST['observacion']);
	        $observacion= mysqli_escape_string($this->conn,strip_tags($observacion));
			
			//VALIDAR SOLICITANTE
	        if ($_POST['solicitante']== 0 || !filter_var($_POST['solicitante'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el solicitante. ';
	        }

	        //VALIDAR LUGAR ENTREGA
	        if ($_POST['lugarentrega']== 0 || !filter_var($_POST['lugarentrega'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el lugar de entrega. ';
	        }

	        //VALIDAR ENTREGA
			$entrega= trim($_POST['entrega']);
	        $entrega= mysqli_escape_string($this->conn,strip_tags($entrega));
			
	        //VALIDAR CONDICION DE PAGO
	        if ($_POST['condpago']== 0 || !filter_var($_POST['condpago'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar la condicion de pago. ';
	        }

	        //VALIDAR PORCENTAJE DEPAGO
			$porcentpago= trim($_POST['porcentpago']);
	        $porcentpago= mysqli_escape_string($this->conn,strip_tags($porcentpago));
			
			//VALIDAR PRESUPUESTO
			$presupuesto= trim($_POST['presupuesto']);
	        $presupuesto= mysqli_escape_string($this->conn,strip_tags($presupuesto));
			
	        //VALIDAR TIPO CAMBIO
	        if (empty($_POST['tipocambio']) || $_POST['tipocambio']== null || !filter_var($_POST['tipocambio'], FILTER_VALIDATE_INT))
			{
				$errors[] = 'Tienes que ingresar el tipo de cambio de forma correcta. ';
			}

			//VALIDAR LOG
	        if (empty($_POST['cuenta']))
	        {
	        	$errors[] = 'Debes seleccionar una cuenta valida. ';
	        }

	        //VALIDAR CUENTA
	        $cuenta= trim($_POST['cuenta']);
	        $cuenta= mysqli_escape_string($this->conn,strip_tags($cuenta));

	        //VALIDAR CENTRO
	        $centrocosto= trim($_POST['centrocosto']);
	        $centrocosto= mysqli_escape_string($this->conn,strip_tags($centrocosto));


	        if (empty($errors))
        	{
				$query = sprintf
				(
					"INSERT INTO encoc
					SET
					id_encOC='%s',
					id_usuario='%s',
					id_empresa='%s', 
					nroOC='%s',
					fecha='%s',
					estado='%s',
					cotizacion='%s',
					rutaux='%s',
					solicitante='%s',
					lugarenvio='%s',
					entrega='%s',
					pago='%s',
					presupuesto='%s',
					tipocambio='%s',
					observacion='%s',
					cuenta='%s',
					centrocosto='%s',
					porcentpago='%s',
					neto='%s',
					iva='%s',
					total='%s',
					elim='%s'",
					$id_encOC,
					$_SESSION["backend_id"],
					$_SESSION["id_empresa"],
					$_POST['nrooc'],
					$_POST['fecha'],
					$_POST['estado'],
					$cotizacion,
					$_POST['rutaux'],
					$_POST['solicitante'],
					$_POST['lugarentrega'],
					$entrega,
					$_POST['condpago'],
					$presupuesto,
					$_POST['tipocambio'],
					$observacion,
					$cuenta,
					$centrocosto,
					$porcentpago,
					0,
					0,
					0,
					1

				);
				
				$r_query= $this->conn->query($query);
				//$r_query = mysql_query($query,parent::con());
				
				// Validamos que se haya actualizado el registro
				//if($r_query -> affected_rows == 1){
				$respuestaOK = true;
				$mensajeError = 'Se ha guardado el registro correctamente';
				$contenidoOK = $r_query;

				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError,
									"contenido" => $contenidoOK);
				echo json_encode($salidaJson);
			}
			else
			{
				$respuestaOK = false;
				$mensajeError = $errors;
				$contenidoOK = 0;

				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError,
									"contenido" => $contenidoOK);
				echo json_encode($salidaJson);
			}
		}
    }

    public function editaroc()
    {	
    	//session_start();
		//sleep(0);
		$fecha = date('Ym', strtotime($_POST['fecha']));
		$ano = intval(substr($fecha, 0, 4));
		$mes = intval(substr($fecha, 4, 2));

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "El periodo Mes:".$mes." Año:".$ano." está cerrado. No se puede realizar la operacion solicitada.";
		$contenidoOK = "";
		$buscar="";

		$query = "SELECT * FROM periodo WHERE ano= '". $ano."' AND mes= '". $mes."'";
        $r_query= $this->conn->query($query);
        $datos = $r_query->fetch_array(MYSQLI_ASSOC);
        $ac=$datos['ac'];

        if ($ac==0)
		{
			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError);
			echo json_encode($salidaJson);
		}
		else
		{
			$nrooc = $_POST['nrooc'];
	    	$id_encOC = $_SESSION["backend_id"].$_SESSION["id_empresa"].$nrooc;

	    	//VALIDAR ESTADO
	        if ($_POST['estado']== 0 || !filter_var($_POST['estado'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el estado. ';
	        }

	        //VALIDAR COTIZACION
			$cotizacion= trim($_POST['cotizacion']);
	        $cotizacion= mysqli_escape_string($this->conn,strip_tags($cotizacion));
			
	        //VALIDAR RUT PROVEEDOR
	        if (empty($_POST['rutaux']) || $_POST['rutaux']== null || !filter_var($_POST['rutaux'], FILTER_VALIDATE_INT))
			{
				$errors[] = 'Tienes que seleccionar el rut de proveedor de forma correcta. ';
			}

			//VALIDAR OBSERVACION
			$observacion= trim($_POST['observacion']);
	        $observacion= mysqli_escape_string($this->conn,strip_tags($observacion));
			
			//VALIDAR SOLICITANTE
	        if ($_POST['solicitante']== 0 || !filter_var($_POST['solicitante'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el solicitante. ';
	        }

	        //VALIDAR LUGAR ENTREGA
	        if ($_POST['lugarentrega']== 0 || !filter_var($_POST['lugarentrega'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el lugar de entrega. ';
	        }

	        //VALIDAR ENTREGA
			$entrega= trim($_POST['entrega']);
	        $entrega= mysqli_escape_string($this->conn,strip_tags($entrega));
			
	        //VALIDAR CONDICION DE PAGO
	        if ($_POST['condpago']== 0 || !filter_var($_POST['condpago'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar la condicion de pago. ';
	        }

	        //VALIDAR PORCENTAJE DEPAGO
			$porcentpago= trim($_POST['porcentpago']);
	        $porcentpago= mysqli_escape_string($this->conn,strip_tags($porcentpago));
			
			//VALIDAR PRESUPUESTO
			$presupuesto= trim($_POST['presupuesto']);
	        $presupuesto= mysqli_escape_string($this->conn,strip_tags($presupuesto));
			
	        //VALIDAR TIPO CAMBIO
	        if (empty($_POST['tipocambio']) || $_POST['tipocambio']== null || !filter_var($_POST['tipocambio'], FILTER_VALIDATE_INT))
			{
				$errors[] = 'Tienes que ingresar el tipo de cambio de forma correcta. ';
			}

			//VALIDAR LOG
	        if (empty($_POST['cuenta']))
	        {
	        	$errors[] = 'Debes seleccionar una cuenta valida. ';
	        }

	        //VALIDAR CUENTA
	        $cuenta= trim($_POST['cuenta']);
	        $cuenta= mysqli_escape_string($this->conn,strip_tags($cuenta));

	        //VALIDAR CENTRO
	        $centrocosto= trim($_POST['centrocosto']);
	        $centrocosto= mysqli_escape_string($this->conn,strip_tags($centrocosto));


	        if (empty($errors))
        	{
				$query = sprintf
				(
					"UPDATE encoc
					SET
					estado='%s',
					cotizacion='%s',
					rutaux='%s',
					solicitante='%s',
					lugarenvio='%s',
					entrega='%s',
					pago='%s',
					presupuesto='%s',
					tipocambio='%s',
					observacion='%s',
					cuenta='%s',
					centrocosto='%s',
					porcentpago='%s',
					elim='%s'
					WHERE id_encOC= '".$id_encOC."' LIMIT 1",
					$_POST['estado'],
					$cotizacion,
					$_POST['rutaux'],
					$_POST['solicitante'],
					$_POST['lugarentrega'],
					$entrega,
					$_POST['condpago'],
					$presupuesto,
					$_POST['tipocambio'],
					$observacion,
					$cuenta,
					$centrocosto,
					$porcentpago,
					1
				);
				
				$r_query= $this->conn->query($query);
				
				$respuestaOK = true;
				$mensajeError = 'Se ha editado el registro correctamente';
				$contenidoOK = $r_query;

				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError,
									"contenido" => $contenidoOK);
				echo json_encode($salidaJson);
			}
			else
			{
				$respuestaOK = false;
				$mensajeError = $errors;
				$contenidoOK = 0;

				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError,
									"contenido" => $contenidoOK);
				echo json_encode($salidaJson);
			}
		}
    }

    public function eliminarcomp()
    {	
    	//session_start();
		sleep(0);
		$fecha = date('Ym', strtotime($_POST['fecha']));
		$ano = intval(substr($fecha, 0, 4));
		$mes = intval(substr($fecha, 4, 2));

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "El periodo Mes:".$mes." Año:".$ano." está cerrado. No se puede realizar la operacion solicitada.";
		$contenidoOK = "";
		$buscar="";

		$_POST['idemp']= $_SESSION["id_empresa"];
		$_POST['idbod']= $_SESSION["id_bodega"];

		$query = "SELECT * FROM periodo WHERE ano= '". $ano."' AND mes= '". $mes."'";
        $r_query= $this->conn->query($query);
        $datos = $r_query->fetch_array(MYSQLI_ASSOC);
        $ac=$datos['ac'];

        if ($ac==0)
		{
			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError);
			echo json_encode($salidaJson);
		}
		else
		{
	    	//Eliminar detalle
			$query = sprintf
			(
				"UPDATE detcomp
				SET
				elim='%s'
				WHERE idcomp= '".$_POST['idcomp']."' LIMIT 1",
				2
			);
			
			$r_query= $this->conn->query($query);
			//$r_query = mysql_query($query,parent::con());


			//Eliminar encabezado
			$query = sprintf
			(
				"UPDATE enccomp
				SET
				elim='%s'
				WHERE idcomp= '".$_POST['idcomp']."' LIMIT 1",
				2
			);
			
			$r_query= $this->conn->query($query);
			//$r_query = mysql_query($query,parent::con());
			
			// Validamos que se haya actualizado el registro
			//if($r_query -> affected_rows == 1){
			$respuestaOK = true;
			$mensajeError = 'Se ha eliminado el registro correctamente';
			$contenidoOK = $r_query;

			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError,
								"contenido" => $contenidoOK);
			echo json_encode($salidaJson);
		}
    }

    public function buscar()
    {	
    	//session_start();
		//sleep(0);

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

		$_POST['idemp']= $_SESSION["id_empresa"];
		$_POST['idbod']= $_SESSION["id_bodega"];

    	$nrooc = $_POST['nrooc'];
    	//$us=2;
    	$id_encOC = $_SESSION["backend_id"].$_POST['idemp'].$nrooc;
    	//$id_encOC = $us.$_POST['idemp'].$nrooc;

		$sql = "SELECT * FROM encoc WHERE id_encOC= '".$id_encOC."' AND elim= 1";
		$r_query= $this->conn->query($sql);

		//$r_query = mysql_query($sql,parent::con());
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        }
        else
        {
			$contenidoOK = array();
		
			//while($datos = mysql_fetch_array($r_query))
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
			{
				$solicitante = $datos['solicitante'];
				$lugarentrega = $datos['lugarenvio'];
				$fecha = $datos['fecha'];
				$entrega = $datos['entrega'];
				$estado = $datos['estado'];
				$condpago = $datos['pago'];
				$cotizacion = $datos['cotizacion'];
				$porcentpago = $datos['porcentpago'];
				$rutaux = $datos['rutaux'];
				$presupuesto = $datos['presupuesto'];
				$tipocambio = $datos['tipocambio'];
				$cuenta = $datos['cuenta'];
				$centrocosto = $datos['centrocosto'];
				$observacion = $datos['observacion'];
				$neto = number_format($datos['neto'], 0, ',', '.');
				$iva = number_format($datos['iva'], 0, ',', '.');
				$total = number_format($datos['total'], 0, ',', '.');

			}
		
			$contenidoOK['solicitante'] = $solicitante;
			$contenidoOK['lugarentrega'] = $lugarentrega;
			$contenidoOK['fecha'] = $fecha;
			$contenidoOK['entrega'] = $entrega;
			$contenidoOK['estado'] = $estado;
			$contenidoOK['condpago'] = $condpago;
			$contenidoOK['cotizacion'] = $cotizacion;
			$contenidoOK['porcentpago'] = $porcentpago;
			$contenidoOK['rutaux'] = $rutaux;
			$contenidoOK['presupuesto'] = $presupuesto;
			$contenidoOK['tipocambio'] = $tipocambio;
			$contenidoOK['cuenta'] = $cuenta;
			$contenidoOK['centrocosto'] = $centrocosto;
			$contenidoOK['observacion'] = $observacion;
			$contenidoOK['neto'] = $neto;
			$contenidoOK['iva'] = $iva;
			$contenidoOK['total'] = $total;
			
			$sql = "SELECT * FROM auxiliares WHERE rut= '".$rutaux."'";
			$r_query= $this->conn->query($sql);

			while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
			{
				$nombreaux = $datos['nombre'];
				$contacto = $datos['contacto'];
				$celular = $datos['celular'];
				$direccion = $datos['direccion'];
				$comuna = $datos['comuna'];
				$telefono = $datos['telefono'];
				$ctacte = $datos['ctacte'];
				$banco = $datos['banco'];
				$mail = $datos['mail'];
				
			}

			$contenidoOK['nombreaux'] = $nombreaux;
			$contenidoOK['contacto'] = $contacto;
			$contenidoOK['celular'] = $celular;
			$contenidoOK['direccion'] = $direccion;
			$contenidoOK['comuna'] = $comuna;
			$contenidoOK['telefono'] = $telefono;
			$contenidoOK['ctacte'] = $ctacte;
			$contenidoOK['banco'] = $banco;
			$contenidoOK['mail'] = $mail;


			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
		
    }

    public function revisafoliooc()
    {	
    	
		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

		/*
		$int = 122;
		$min = 1;
		$max = 200;

		if (filter_var($int, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false) {
		    echo("Variable value is not within the legal range");
		} else {
		    echo("Variable value is within the legal range");
		}
		*/



		$nrooc = $_POST['nrooc'];
		if ($nrooc=="" || $nrooc==null || !filter_var($nrooc, FILTER_VALIDATE_INT))
		{
			$nrooc= 0;
		}


		$sql = "SELECT MAX(nroOC) AS nroOC FROM encoc WHERE id_usuario= '".$_SESSION["backend_id"]."' AND id_empresa= '".$_SESSION["id_empresa"]."'";
		$r_query= $this->conn->query($sql);

		$filas = $r_query->num_rows;
        if($filas==0)
        {
        	$contenidoOK['usarfolio'] = "";
        	echo json_encode($contenidoOK);
        }
        else
        {
			$contenidoOK = array();
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
			{
				$usarfolio = $datos['nroOC'] + 1;

			}

			$sql = "SELECT hasta FROM folioocautorizado WHERE id_usuario= '".$_SESSION["backend_id"]."' AND id_empresa= '".$_SESSION["id_empresa"]."' AND estado=1";
			$r_query= $this->conn->query($sql);

			$filas = $r_query->num_rows;
        	if($filas==0)
        	{
        		$contenidoOK['usarfolio'] = "";
        		echo json_encode($contenidoOK);
        	}
        	else
        	{
				while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
				{
					$foliohasta = $datos['hasta'];
				}
			}


			
	    	$id_encOC = $_SESSION["backend_id"].$_SESSION["id_empresa"].$nrooc;
	    
			$sql = "SELECT * FROM encoc WHERE id_encOC= '".$id_encOC."' AND elim= 1";
			$r_query= $this->conn->query($sql);

			$filas = $r_query->num_rows;
	        
	        if($filas==0)
	        {
	        	$folio=0;
	        }
	        else
	        {
				while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
				{
					$folio = $datos['nroOC'];
				}

			}

			
			if($usarfolio > $foliohasta)
			{
        		$contenidoOK['usarfolio'] = "Supera";
        		echo json_encode($contenidoOK);
        	}
        	elseif($folio > 0)
			{
        		$contenidoOK['usarfolio'] = "Editar";
        		echo json_encode($contenidoOK);
        	}
        	else
        	{
        		$contenidoOK['usarfolio'] = $usarfolio;
				echo json_encode($contenidoOK);		
			}

		}
		
    }

    public function buscaraux()
    {
    	$rutaux = $_POST['rutaux'];	
		$sql = "SELECT * FROM auxiliares WHERE rut= '".$rutaux."'";

		
		//$r_query = mysql_query($sql,parent::con());
		$r_query= $this->conn->query($sql);
		
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        	$contenidoOK['nombreaux'] = "No";
        	echo json_encode($contenidoOK);
        }
        else
        {
			$contenidoOK = array();

			/* array asociativo */
			//$row = $r_query->fetch_array(MYSQLI_ASSOC);
		
			//while($datos = mysql_fetch_array($r_query)){
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
				$nombre = $datos['nombre'];
				$direccion = $datos['direccion'];
				$comuna = $datos['comuna'];
				$telefono = $datos['telefono'];
				$celular = $datos['celular'];
				$mail = $datos['mail'];
				$contacto = $datos['contacto'];
				$ctacte = $datos['ctacte'];
				$banco = $datos['banco'];
			}
			
			$contenidoOK['nombreaux'] = $nombre;
			$contenidoOK['direccion'] = $direccion;
			$contenidoOK['comuna'] = $comuna;
			$contenidoOK['telefono'] = $telefono;
			$contenidoOK['celular'] = $celular;
			$contenidoOK['mail'] = $mail;
			$contenidoOK['contacto'] = $contacto;
			$contenidoOK['ctacte'] = $ctacte;
			$contenidoOK['banco'] = $banco;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

	public function buscarcuenta()
    {
    	$cuenta = $_POST['cuenta'];	
		$sql = "SELECT * FROM cuentas WHERE codigo= '".$cuenta."'";

		
		//$r_query = mysql_query($sql,parent::con());
		$r_query= $this->conn->query($sql);
		
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        	$contenidoOK['codigonombrecta'] = "";
        	echo json_encode($contenidoOK);
        }
        else
        {
			$contenidoOK = array();

			/* array asociativo */
			//$row = $r_query->fetch_array(MYSQLI_ASSOC);
		
			//while($datos = mysql_fetch_array($r_query)){
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
				$codigo = $datos['codigo'];
				$nombre = $datos['nombre'];
			}
			
			$contenidoOK['codigonombrecta'] = $codigo." ".$nombre;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

    public function buscarcentro()
    {
    	$centro = $_POST['centro'];	
		$sql = "SELECT * FROM centros WHERE codigo= '".$centro."'";

		$r_query= $this->conn->query($sql);
		
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        	$contenidoOK['codigonombrecentro'] = "";
        	echo json_encode($contenidoOK);
        }
        else
        {
			$contenidoOK = array();

			/* array asociativo */
			//$row = $r_query->fetch_array(MYSQLI_ASSOC);
		
			//while($datos = mysql_fetch_array($r_query)){
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
				$codigo = $datos['codigo'];
				$nombre = $datos['nombre'];
			}
			
			$contenidoOK['codigonombrecentro'] = $codigo." ".$nombre;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }
    

    public function guardarocdet()
    {	
    	//session_start();
		//sleep(0);

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

		$nrooc = $_POST['nrooc'];
	    $id_encOC = $_SESSION["backend_id"].$_SESSION["id_empresa"].$nrooc;


	    //VALIDAR ESTADO
	    if ($_POST['idart']== 0 || $_POST['idart']== null || !filter_var($_POST['idart'], FILTER_VALIDATE_INT))
	    {
	    	$errors[] = 'Tienes que seleccionar o indicar el id de articulo correcto. ';
	    }

	    //VALIDAR DETALLE
		$detalle= trim($_POST['detalle']);
	    $detalle= mysqli_escape_string($this->conn,strip_tags($detalle));

	    //VALIDAR CANTIDAD
	    if (($_POST['cantidad']) == '0')
	    {
	    	//$errors[] = 'Tienes que ingresar una cantidad validannnnnnnnnnnnn. '.$_POST['cantidad'];
	    }
	    else
	    {
		    if (!filter_var($_POST['cantidad'], FILTER_VALIDATE_FLOAT))
		    {
		    	$errors[] = 'Tienes que ingresar una cantidad valida. '.$_POST['cantidad'];
		    }
		}

		//VALIDAR PRECIOS
	    if (($_POST['precio']) == '0')
	    {
	    	//$errors[] = 'Tienes que ingresar una cantidad validannnnnnnnnnnnn. '.$_POST['cantidad'];
	    }
	    else
	    {
		    if (!filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT))
		    {
		    	$errors[] = 'Tienes que ingresar un precio valido. '.$_POST['precio'];
		    }
		}

	    if (empty($errors))
        {
    	
			$query = sprintf
			(
				"INSERT INTO detoc
				SET
				id_detOC='%s',
				nroOC='%s',
				tipo='%s',
				id_art='%s',
				detalle='%s',
				cantidad='%s',
				um='%s', 
				precio='%s',
				neto='%s',
				elim='%s'",
				$id_encOC,
				$nrooc,
				$_POST['tipoart'],
				$_POST['idart'],
				$detalle,
				$_POST['cantidad'],
				$_POST['um'],
				$_POST['precio'],
				$_POST['cantidad'] * $_POST['precio'],
				1

			);

			$r_query= $this->conn->query($query);
			
			$sql = "SELECT SUM(neto) AS neto FROM detoc 
		             WHERE id_detOC = '".$id_encOC."' AND elim=1";
			$res= $this->conn->query($sql);
			$reg = $res->fetch_array(MYSQLI_ASSOC);
			$neto= $reg['neto'];
			$iva= $neto * 19/100;
			$total= $neto + $iva;

			$query = sprintf
				(
					"UPDATE encoc
					SET
					neto='%s',
					iva='%s',
					total='%s',
					elim='%s'
					WHERE id_encOC= '".$id_encOC."' LIMIT 1",
					$neto,
					$iva,
					$total,
					1
				);
				
			$r_query= $this->conn->query($query);



			$respuestaOK = true;
			$mensajeError = 'Se ha guardado el registro correctamente';
			$contenidoOK = $r_query;

			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError,
								"contenido" => $contenidoOK);
			echo json_encode($salidaJson);
		}
		else
		{
			$respuestaOK = false;
			$mensajeError = $errors;
			$contenidoOK = 0;

			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError,
								"contenido" => $contenidoOK);
			echo json_encode($salidaJson);
		}
    }

    public function editarocdet()
    {	
    	//session_start();
		//sleep(0);

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

		$nrooc = $_POST['nrooc'];
	    $id_encOC = $_SESSION["backend_id"].$_SESSION["id_empresa"].$nrooc;
		
	    //VALIDAR ESTADO
	    if ($_POST['idart']== 0 || $_POST['idart']== null || !filter_var($_POST['idart'], FILTER_VALIDATE_INT))
	    {
	    	$errors[] = 'Tienes que seleccionar o indicar el id de articulo correcto. ';
	    }

	    //VALIDAR DETALLE
		$detalle= trim($_POST['detalle']);
	    $detalle= mysqli_escape_string($this->conn,strip_tags($detalle));

	    //VALIDAR CANTIDAD
	    if (($_POST['cantidad']) == '0')
	    {
	    	//$errors[] = 'Tienes que ingresar una cantidad validannnnnnnnnnnnn. '.$_POST['cantidad'];
	    }
	    else
	    {
		    if (!filter_var($_POST['cantidad'], FILTER_VALIDATE_FLOAT))
		    {
		    	$errors[] = 'Tienes que ingresar una cantidad valida. '.$_POST['cantidad'];
		    }
		}

		//VALIDAR PRECIOS
	    if (($_POST['precio']) == '0')
	    {
	    	//$errors[] = 'Tienes que ingresar una cantidad validannnnnnnnnnnnn. '.$_POST['cantidad'];
	    }
	    else
	    {
		    if (!filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT))
		    {
		    	$errors[] = 'Tienes que ingresar un precio valido. '.$_POST['precio'];
		    }
		}

	    if (empty($errors))
        {
			$query = sprintf
			(
				"UPDATE detoc
				SET
				tipo='%s',
				id_art='%s',
				detalle='%s',
				cantidad='%s',
				um='%s', 
				precio='%s',
				neto='%s',
				elim='%s'
				WHERE id= '".$_POST['iddetoc']."' LIMIT 1",
				$_POST['tipoart'],
				$_POST['idart'],
				$detalle,
				$_POST['cantidad'],
				$_POST['um'],
				$_POST['precio'],
				$_POST['cantidad'] * $_POST['precio'],
				1
			);
			
			$r_query= $this->conn->query($query);
			
			$sql = "SELECT SUM(neto) AS neto FROM detoc 
		             WHERE id_detOC = '".$id_encOC."' AND elim=1";
			$res= $this->conn->query($sql);
			$reg = $res->fetch_array(MYSQLI_ASSOC);
			$neto= $reg['neto'];
			$iva= $neto * 19/100;
			$total= $neto + $iva;

			$query = sprintf
				(
					"UPDATE encoc
					SET
					neto='%s',
					iva='%s',
					total='%s',
					elim='%s'
					WHERE id_encOC= '".$id_encOC."' LIMIT 1",
					$neto,
					$iva,
					$total,
					1
				);
				
			$r_query= $this->conn->query($query);



			$respuestaOK = true;
			$mensajeError = 'Se ha guardado el registro correctamente';
			$contenidoOK = $r_query;

			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError,
								"contenido" => $contenidoOK);
			echo json_encode($salidaJson);
		}
		else
		{
			$respuestaOK = false;
			$mensajeError = $errors;
			$contenidoOK = 0;

			$salidaJson = array("respuesta" => $respuestaOK,
								"mensaje" => $mensajeError,
								"contenido" => $contenidoOK);
			echo json_encode($salidaJson);
		}
    }

    public function eliminarocdet()
    {	
    	//session_start();
		//sleep(0);

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

		//$fechacomp = date('Y/m/d', strtotime($_POST['fecha']));         
		$query = sprintf
		(
			"UPDATE detoc
			SET
			elim='%s'
			WHERE id= '".$_POST['iddetoc']."' LIMIT 1",
			2
		);
		
		$r_query= $this->conn->query($query);
		//$r_query = mysql_query($query,parent::con());
		
		// Validamos que se haya actualizado el registro
		//if($r_query -> affected_rows == 1){
		$respuestaOK = true;
		$mensajeError = 'Se ha eliminado el registro correctamente';
		$contenidoOK = $r_query;

		$salidaJson = array("respuesta" => $respuestaOK,
							"mensaje" => $mensajeError,
							"contenido" => $contenidoOK);
		echo json_encode($salidaJson);    		
    }

    public function buscarart()
    {
    	$idart = $_POST['idart'];	
		$sql = "SELECT * FROM articulos WHERE id= '".$idart."'";

		
		//$r_query = mysql_query($sql,parent::con());
		$r_query= $this->conn->query($sql);
		
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        }
        else
        {
			$contenidoOK = array();

			/* array asociativo */
			//$row = $r_query->fetch_array(MYSQLI_ASSOC);
		
			//while($datos = mysql_fetch_array($r_query)){
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
				$nombre = $datos['nombre_articulo'];
				$um = $datos['um'];
				
			}
		
			$contenidoOK['nombre'] = $nombre;
			$contenidoOK['um'] = $um;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

	public function buscartotales()
    {	
    	//session_start();
		//sleep(0);

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

		$_POST['idemp']= $_SESSION["id_empresa"];
		$_POST['idbod']= $_SESSION["id_bodega"];

    	$nrooc = $_POST['nrooc'];
    	//$us=2;
    	$id_encOC = $_SESSION["backend_id"].$_POST['idemp'].$nrooc;
    	//$id_encOC = $us.$_POST['idemp'].$nrooc;

		$sql = "SELECT * FROM encoc WHERE id_encOC= '".$id_encOC."' AND elim= 1";
		$r_query= $this->conn->query($sql);

		//$r_query = mysql_query($sql,parent::con());
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        }
        else
        {
			$contenidoOK = array();
		
			//while($datos = mysql_fetch_array($r_query))
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
			{
				$neto = number_format($datos['neto'], 0, ',', '.');
				$iva = number_format($datos['iva'], 0, ',', '.');
				$total = number_format($datos['total'], 0, ',', '.');
				

			}
		
			$contenidoOK['neto'] = $neto;
			$contenidoOK['iva'] = $iva;
			$contenidoOK['total'] = $total;
			
			
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
		
    }


}


?>