<?php
class  Rendiciones extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 
	public function guardareditarrend()
    {	
    	if ($_POST['accion']=='guardarrend')
		{
	    	//$nrooc = $_POST['nrooc'];
	    	$folio = $_POST['folio'];
	    	$id_encrend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;
	    	
			$query = "SELECT * FROM encrend WHERE id_encrend= '".$id_encrend."' AND elim= 1";
            $r_query= $this->conn->query($query);
            $filas = $r_query->num_rows;

			if($filas==1)
			{
				$_POST['accion']='editarrend';
				$this->editarrend();
			}
			else
			{
				$this->guardarrend();
			}
		}
    }

    public function guardareditarrenddet()
    {	
    	if ($_POST['accion']=='guardarrenddet')
		{
			$query = "SELECT * FROM detrend WHERE id= '". $_POST['iddetrend']."'";
			$r_query= $this->conn->query($query);
            $filas = $r_query->num_rows;

            //$r_query = mysql_query($query,parent::con());
			//$filas = mysql_num_rows($r_query);
			if($filas==1)
			{
				$_POST['accion']='editarrenddet';
				$this->editarrenddet();
			}
			else
			{
				$this->guardarrenddet();
			}
		}
    }

    public function guardareditarrendarch()
    {	
    	if ($_POST['accion']=='guardarrendarch')
		{
			$query = "SELECT * FROM archrend WHERE id= '". $_POST['iddetarch']."'";
			$r_query= $this->conn->query($query);
            $filas = $r_query->num_rows;

            //$r_query = mysql_query($query,parent::con());
			//$filas = mysql_num_rows($r_query);
			if($filas==1)
			{
				$_POST['accion']='editarrendarch';
				$this->editarrendarch();
			}
			else
			{
				$this->guardarrendarch();
			}
		}
    }

    public function guardarrendarchwwww()
    {	
			$ruta= $_SESSION["id_empresa"].'/'.$_SESSION["id_usuariosel"].'/';

			$data = array();

			if ( 0 < $_FILES['file']['error'] )
			{
		        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
		    }
		    else
		    {
		    	//"application/x-zip-compressed"
		    	//"application/vnd.openxmlformats-officedocument-wordprocessingml.document"
		    	//"application/pdf"
		    	//"application/vnd.ms-excel" excel antiguo xls y csv
				//"text/plain"
				//"application/vnd.ms-excel.sheet.macroEnabled.12"
				//"application/vnd.openxmlformats-officedocument-spreadsheetml.sheet"

		    	if ( $_FILES["file"]["size"] < 1000000 )
				{
			    	if (($_FILES["file"]["type"] == "image/pjpeg")
				        || ($_FILES["file"]["type"] == "image/jpeg")
				        || ($_FILES["file"]["type"] == "image/png")
				        || ($_FILES["file"]["type"] == "image/jpg")
				        || ($_FILES["file"]["type"] == "application/pdf"))
				    {
			        	move_uploaded_file($_FILES['file']['tmp_name'], '../archivos/'.$ruta. $_FILES['file']['name']);
			        	//$data = array('success' => 'NO FILES ARE SENT','formData' => $_REQUEST);
			        	$data = array('Tipo: ' => $_FILES["file"]["type"],'formData' => $_REQUEST);

			        	//$data = $_POST['mifolio'];
			        }
			        else
			        {
			        	//El archivo no se sube
			        	$data = 0;
			        }
			    }
			    else
			    {
			    	//El archivo no se sube
			    	$data = 0;
			    }


		    }
		    
			echo json_encode($data);
    }

    public function guardarrend()
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
	    	$sql = "SELECT MAX(folio) AS nrorend FROM encrend WHERE id_usuario= '".$_SESSION["id_usuariosel"]."' AND id_empresa= '".$_SESSION["id_empresa"]."'";
			$r_query= $this->conn->query($sql);

			$filas = $r_query->num_rows;
	        if($filas==0)
	        {
	        	
	        }
	        else
	        {
				$datos = $r_query->fetch_array(MYSQLI_ASSOC);
				$usarfolio = $datos['nrorend'] + 1;
	    	}
	    	$nrorend = $usarfolio;
	    	$id_encrend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;

	    	//VALIDAR ESTADO
	        if ($_POST['estado']== 0 || !filter_var($_POST['estado'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el estado. ';
	        }

	       
	        //VALIDAR FONDO ASIGNADO
	        if($_POST['fondoasign'] == 0)
	        {
	        }
	        else
	        {	
		        if (empty($_POST['fondoasign']) || $_POST['fondoasign']== null || !filter_var($_POST['fondoasign'], FILTER_VALIDATE_INT))
				{
					$errors[] = 'Tienes que anotar el monto asignado de forma correcta. '.$_POST['fondoasign'];
				}
			}

			//VALIDAR OBSERVACION
			$observacion= trim($_POST['observacion']);
	        $observacion= mysqli_escape_string($this->conn,strip_tags($observacion));
			
			//VALIDAR SOLICITANTE
	        if ($_POST['tipofondo']== 0 || !filter_var($_POST['tipofondo'], FILTER_VALIDATE_INT))
	        {
	        	$errors[] = 'Tienes que seleccionar el tipo de fondo. ';
	        }


	        if (empty($errors))
        	{
				$query = sprintf
				(
					"INSERT INTO encrend
					SET
					id_encrend='%s',
					id_usuario='%s',
					id_empresa='%s',
					id_usuariover='%s', 
					folio='%s',
					estado='%s',
					fecha='%s',
					tipofondo='%s',
					fondoasign='%s',
					banco='%s',
					tipocuenta='%s',
					nrocuenta='%s',
					observacion='%s',
					archivo='%s',
					elim='%s'",
					$id_encrend,
					$_SESSION["id_usuariosel"],
					$_SESSION["id_empresa"],
					$_SESSION["backend_id"],
					$nrorend,
					$_POST['estado'],
					$_POST['fecha'],
					$_POST['tipofondo'],
					$_POST['fondoasign'],
					$_POST['banco'],
					$_POST['tipocuenta'],
					$_POST['nrocuenta'],
					$_POST['observacion'],
					$_POST['archivo'],
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
									"contenido" => $contenidoOK,
									"folio" => $nrorend);
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

    public function editarrend()
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
			$nrorend = $_POST['folio'];
		    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;
			$sql = "SELECT aprobar FROM encrend WHERE id_encrend= '".$id_encRend."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['aprobar'];
        	if ($aprobar==1)
			{
				$mensajeError = "La rendicion ya se encuentra aprobada. No se puede realizar la operacion solicitada.";
				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError);
				echo json_encode($salidaJson);
			}
			else
			{
				$nrorend = $_POST['folio'];
		    	$id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;

		    	//VALIDAR ESTADO
		        if ($_POST['estado']== 0 || !filter_var($_POST['estado'], FILTER_VALIDATE_INT))
		        {
		        	$errors[] = 'Tienes que seleccionar el estado. ';
		        }

		       
		        //VALIDAR FONDO ASIGNADO
		        //VALIDAR FONDO ASIGNADO
		        if($_POST['fondoasign'] == 0)
		        {
		        }
		        else
		        {	
			        if (empty($_POST['fondoasign']) || $_POST['fondoasign']== null || !filter_var($_POST['fondoasign'], FILTER_VALIDATE_INT))
					{
						$errors[] = 'Tienes que anotar el monto asignado de forma correcta. ';
					}
				}

				//VALIDAR OBSERVACION
				$observacion= trim($_POST['observacion']);
		        $observacion= mysqli_escape_string($this->conn,strip_tags($observacion));
				
				//VALIDAR SOLICITANTE
		        if ($_POST['tipofondo']== 0 || !filter_var($_POST['tipofondo'], FILTER_VALIDATE_INT))
		        {
		        	$errors[] = 'Tienes que seleccionar el tipo de fondo. ';
		        }



		        if (empty($errors))
	        	{
					$query = sprintf
					(
						"UPDATE encrend
						SET
						estado='%s',
						tipofondo='%s',
						fondoasign='%s',
						observacion='%s',
						archivo='%s'
						WHERE id_encrend= '".$id_encRend."' LIMIT 1",
						$_POST['estado'],
						$_POST['tipofondo'],
						$_POST['fondoasign'],
						$_POST['observacion'],
						$_POST['archivo']
					);
					
					$r_query= $this->conn->query($query);
					
					$respuestaOK = true;
					$mensajeError = 'Se ha editado el registro correctamente';
					$contenidoOK = $r_query;

					$salidaJson = array("respuesta" => $respuestaOK,
										"mensaje" => $mensajeError,
										"contenido" => $contenidoOK,
										"folio" => $nrorend);
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
    }

    public function eliminarrend()
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
		//$_POST['idbod']= $_SESSION["id_bodega"];

    	$folio = $_POST['folio'];
    	//$us=2;
    	$id_encrend = $_SESSION["id_usuariosel"].$_POST['idemp'].$folio;
    	//$id_encOC = $us.$_POST['idemp'].$nrooc;

		$sql = "SELECT * FROM encrend WHERE id_encrend= '".$id_encrend."' AND elim= 1";
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
				
				// si es exitosa la operación
				$fecha = $datos['fecha'];
				$banco = $datos['banco'];
				$tipocuenta = $datos['tipocuenta'];
				$nrocuenta = $datos['nrocuenta'];
				$archivo = $datos['archivo'];
				$estado = $datos['estado'];
				$tipofondo = $datos['tipofondo'];
				$fondoasign = number_format($datos['fondoasign'], 0, ',', '.');
				$observacion = $datos['observacion'];
			}
		
			$contenidoOK['fecha'] = $fecha;
			$contenidoOK['banco'] = $banco;
			$contenidoOK['tipocuenta'] = $tipocuenta;
			$contenidoOK['nrocuenta'] = $nrocuenta;
			$contenidoOK['archivo'] = $archivo;
			$contenidoOK['estado'] = $estado;
			$contenidoOK['tipofondo'] = $tipofondo;
			$contenidoOK['fondoasign'] = $fondoasign;
			$contenidoOK['observacion'] = $observacion;
			
			

			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
		
    }

    public function revisafoliorend()
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



		$folio = $_POST['folio'];
		if ($folio=="" || $folio==null || !filter_var($folio, FILTER_VALIDATE_INT))
		{
			$folio= 0;
		}


		$sql = "SELECT MAX(folio) AS nroRend FROM encrend WHERE id_usuario= '".$_SESSION["id_usuariosel"]."' AND id_empresa= '".$_SESSION["id_empresa"]."'";
		$r_query= $this->conn->query($sql);

		$filas = $r_query->num_rows;
        if($filas==0)
        {
        	$contenidoOK['usarfolio'] = 1;
        	echo json_encode($contenidoOK);
        }
        else
        {
			$contenidoOK = array();
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
			{
				$usarfolio = $datos['nroRend'] + 1;
				$contenidoOK['usarfolio'] = $usarfolio;
				echo json_encode($contenidoOK);		

			}

		}
		
    }

    public function buscaraux()
    {
    	$rutaux = $_POST['rutdet'];	
		$sql = "SELECT * FROM auxiliares WHERE rut= '".$rutaux."' AND estado= 1";

		
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
    

    public function guardarrenddet()
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
			$nrorend = $_POST['folio'];
		    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;
			$sql = "SELECT aprobar FROM encrend WHERE id_encrend= '".$id_encRend."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['aprobar'];
        	if ($aprobar==1)
			{
				$mensajeError = "La rendicion ya se encuentra aprobada. No se puede realizar la operacion solicitada.";
				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError);
				echo json_encode($salidaJson);
			}
			else
			{
				$folio = $_POST['folio'];
			    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;


			    //VALIDAR FECHA
			   // if ($_POST['fechadet']== 0 || $_POST['fechadet']== null || !filter_var($_POST['fechadet'], FILTER_VALIDATE_INT))
			   // {
			   // 	$errors[] = 'Tienes que indicar la fecha. ';
			    //}

			    //VALIDAR RUT
			    if ($_POST['rutdet']== 0 || $_POST['rutdet']== null || !filter_var($_POST['rutdet'], FILTER_VALIDATE_INT))
			    {
			    	$errors[] = 'Tienes que indicar el rut. ';
			    }

			    
			    //VALIDAR MONTO
			    if (($_POST['montodet']) == '0')
			    {
			    	//$errors[] = 'Tienes que ingresar una cantidad validannnnnnnnnnnnn. '.$_POST['cantidad'];
			    }
			    else
			    {
				    if (!filter_var($_POST['montodet'], FILTER_VALIDATE_FLOAT))
				    {
				    	$errors[] = 'Tienes que ingresar un monto valido. '.$_POST['montodet'];
				    }
				}

				//VALIDAR TIPO DOC
			    if ($_POST['tipodocdet']== 0 )
			    {
			    	$errors[] = 'Tienes que indicar el tipode documento. ';
			    }


			    //VALIDAR NRO DOC
			    if ($_POST['nrodocdet']== 0 || $_POST['nrodocdet']== null || !filter_var($_POST['nrodocdet'], FILTER_VALIDATE_INT))
			    {
			    	$errors[] = 'Tienes que indicar un nro de documento. ';
			    }
				
				//VALIDAR CONCEPTO
				$conceptodet= trim($_POST['conceptodet']);
			    $conceptodet= mysqli_escape_string($this->conn,strip_tags($conceptodet));

			    //VALIDAR MATRIZ
				$matrizdet= trim($_POST['matrizdet']);
			    $matrizdet= mysqli_escape_string($this->conn,strip_tags($matrizdet));


			    if (empty($errors))
		        {  	
					$query = sprintf
					(
						"INSERT INTO detrend
						SET
						id_detRend='%s',
						nroRend='%s',
						fecha='%s',
						rut='%s',
						monto='%s',
						tipodoc='%s',
						nrodoc='%s', 
						concepto='%s',
						matriz='%s',
						elim='%s'",
						$id_encRend,
						$folio,
						$_POST['fechadet'],
						$_POST['rutdet'],
						$_POST['montodet'],
						$_POST['tipodocdet'],
						$_POST['nrodocdet'],
						$conceptodet,
						$matrizdet,
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
		}
    }

    public function descargarrendarch()
    {
    	// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

    	$iddetarch = $_POST['iddetarch'];

		$sql = "SELECT * FROM archrend WHERE id= '".$iddetarch."'";
		$r_query= $this->conn->query($sql);

		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        }
        else
        {
			$contenidoOK = array();
		
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC))
			{
				$nuevoarchivo = $datos['nuevoarchivo'];
				$ruta = $datos['ruta'];
			}

			$contenidoOK['nuevoarchivo'] = $nuevoarchivo;
			$contenidoOK['ruta'] = $ruta;
			
			echo json_encode($contenidoOK);
		}	


    	/*
    	# Pon su ruta absoluta, no importa qué tipo sea
		$rutaservidor= $_SESSION["id_empresa"].'/'.$_SESSION["id_usuariosel"].'/';
		$rutaArchivo = '../archivos/'.$rutaservidor."E1U1R2Id20200917_233510.jpg";

		# Obtener nombre sin ruta completa, únicamente para sugerirlo al guardar
		$nombreArchivo = basename($rutaArchivo);

		# Algunos encabezados que son justamente los que fuerzan la descarga
		header('Content-Type: application/octet-stream');
		header("Content-Transfer-Encoding: Binary");
		header("Content-disposition: attachment; filename=$nombreArchivo");
		# Leer el archivo y sacarlo al navegador
		readfile($rutaArchivo);
		# No recomiendo imprimir más cosas después de esto
		*/
    }

    public function guardarrendarch()
    {	
		
    	$fecha = date('Ym', strtotime($_POST['fecha']));
		$ano = intval(substr($fecha, 0, 4));
		$mes = intval(substr($fecha, 4, 2));

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "El periodo Mes:".$mes." Ano:".$ano." esta cerrado. No se puede realizar la operacion solicitada.";
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
			$nrorend = $_POST['folio'];
		    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;
			$sql = "SELECT aprobar FROM encrend WHERE id_encrend= '".$id_encRend."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['aprobar'];
        	if ($aprobar==1)
			{
				$mensajeError = "La rendicion ya se encuentra aprobada. No se puede realizar la operacion solicitada.";
				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError);
				echo json_encode($salidaJson);
			}
			else
			{
				$data = array();

				// Inicializamos variables de mensajes y JSON
				//$respuestaOK = false;
				//$mensajeError = "No se puede ejecutar la aplicación";
				//$contenidoOK = "";
				//$buscar="";	

				$archivo= $_POST['archivo'];
				$ultposder= strrpos($archivo,chr(92))+1;
				$archivo= substr($archivo,$ultposder);

				$ultposderext= strrpos($archivo,'.');
				$extension= substr($archivo,$ultposderext);

				//VALIDAR FOLIO
				if ($_POST['folio']== 0 || $_POST['folio']== null || !filter_var($_POST['folio'], FILTER_VALIDATE_INT))
				{
					$errors[] = 'Tienes que indicar el folio. ';
				}

				//VALIDAR ARCHIVO
				if ($archivo== null )
				{
					$errors[] = 'Tienes que indicar un archivo correctamente. '.$_POST['archivo'].' Este: '.$archivo;
				}

				//VALIDAR ARCHIVO A SUBIR
				if ( 0 < $_FILES['file']['error'] )
				{
					$errors[] = 'Error en el archivo. '.$_FILES['file']['error'];
				}

				//VALIDAR TAMAÑO ARCHIVO
				if ( $_FILES["file"]["size"] > 3000000 )
				{
					$errors[] = 'El archivo supera el tamano permitido. ';
				}

				//VALIDAR TIPO ARCHIVO	
				if (!(($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/png")
					|| ($_FILES["file"]["type"] == "image/jpg")
					|| ($_FILES["file"]["type"] == "application/pdf")))
				{
					//"application/x-zip-compressed"
					//"application/vnd.openxmlformats-officedocument-wordprocessingml.document"
					//"application/pdf"
					//"application/vnd.ms-excel" excel antiguo xls y csv
					//"text/plain"
					//"application/vnd.ms-excel.sheet.macroEnabled.12"
					//"application/vnd.openxmlformats-officedocument-spreadsheetml.sheet"
					
					$errors[] = 'El tipo de archivo no esta permitido. ';
				}

				if (empty($errors))
				{  	
					$rutaservidor= $_SESSION["id_empresa"].'/'.$_SESSION["id_usuariosel"].'/';
					$ruta= '%'.$_SESSION["id_empresa"].'%'.$_SESSION["id_usuariosel"];

					$folio = $_POST['folio'];
					$id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;

					$tiempo=time();
					$nuevonomarch= 'E'.$_SESSION["id_empresa"].'U'.$_SESSION["id_usuariosel"].'R'.$folio.'Id'.date("Ymd_His", $tiempo).$extension;

					move_uploaded_file($_FILES['file']['tmp_name'], '../archivos/'.$rutaservidor. $nuevonomarch);
					
					//move_uploaded_file($_FILES['file']['tmp_name'], '../archivos/'.$rutaservidor. $_FILES['file']['name']);

					//$data = array('success' => 'NO FILES ARE SENT','formData' => $_REQUEST);
					//$data = array('Tipo: ' => $_FILES["file"]["type"],'formData' => $_REQUEST);
					$data = 0;	

					$query = sprintf
					(
						"INSERT INTO archrend
						SET
						id_detRend='%s',
						nroRend='%s',
						archivo='%s',
						nuevoarchivo='%s',
						ruta='%s',
						elim='%s'",
						$id_encRend,
						$folio,
						$archivo,
						$nuevonomarch,
						$ruta,
						1
					);

					$r_query= $this->conn->query($query);

					//$respuestaOK = true;
					//$mensajeError = 'Se ha guardado el registro correctamente';
					//$contenidoOK = $r_query;

					//$salidaJson = array("respuesta" => $respuestaOK,
										//"mensaje" => $mensajeError,
										//"contenido" => $contenidoOK);
					//echo json_encode($salidaJson);
					
					
					echo json_encode($data);
				}
				else
				{
					//$respuestaOK = false;
					//$mensajeError = $errors;
					//$contenidoOK = 0;

					//$salidaJson = array("respuesta" => $respuestaOK,
										//"mensaje" => $mensajeError,
										//"contenido" => $contenidoOK);
					//echo json_encode($salidaJson);
					
					$data = array('Errores: ' => $errors, 'Otro: ' => $_REQUEST);
					//$data = 0;
					echo json_encode($data);
				}
			}
		}

    }

    public function editarrenddet()
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
			$nrorend = $_POST['folio'];
		    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;
			$sql = "SELECT aprobar FROM encrend WHERE id_encrend= '".$id_encRend."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['aprobar'];
        	if ($aprobar==1)
			{
				$mensajeError = "La rendicion ya se encuentra aprobada. No se puede realizar la operacion solicitada.";
				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError);
				echo json_encode($salidaJson);
			}
			else
			{
				$folio = $_POST['folio'];
			    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;
				
			    //VALIDAR FECHA
			   // if ($_POST['fechadet']== 0 || $_POST['fechadet']== null || !filter_var($_POST['fechadet'], FILTER_VALIDATE_INT))
			   // {
			   // 	$errors[] = 'Tienes que indicar la fecha. ';
			    //}

			    //VALIDAR RUT
			    if ($_POST['rutdet']== 0 || $_POST['rutdet']== null || !filter_var($_POST['rutdet'], FILTER_VALIDATE_INT))
			    {
			    	$errors[] = 'Tienes que indicar el rut. ';
			    }

			    
			    //VALIDAR MONTO
			    if (($_POST['montodet']) == '0')
			    {
			    	//$errors[] = 'Tienes que ingresar una cantidad validannnnnnnnnnnnn. '.$_POST['cantidad'];
			    }
			    else
			    {
				    if (!filter_var($_POST['montodet'], FILTER_VALIDATE_FLOAT))
				    {
				    	$errors[] = 'Tienes que ingresar un monto valido. '.$_POST['montodet'];
				    }
				}

				//VALIDAR TIPO DOC
			    if ($_POST['tipodocdet']== 0 )
			    {
			    	$errors[] = 'Tienes que indicar el tipode documento. ';
			    }


			    //VALIDAR NRO DOC
			    if ($_POST['nrodocdet']== 0 || $_POST['nrodocdet']== null || !filter_var($_POST['nrodocdet'], FILTER_VALIDATE_INT))
			    {
			    	$errors[] = 'Tienes que indicar un nro de documento. ';
			    }
				
				//VALIDAR CONCEPTO
				$conceptodet= trim($_POST['conceptodet']);
			    $conceptodet= mysqli_escape_string($this->conn,strip_tags($conceptodet));

			    //VALIDAR MATRIZ
				$matrizdet= trim($_POST['matrizdet']);
			    $matrizdet= mysqli_escape_string($this->conn,strip_tags($matrizdet));


			    if (empty($errors))
		        {
					$query = sprintf
					(
						"UPDATE detrend
						SET
						fecha='%s',
						rut='%s',
						monto='%s',
						tipodoc='%s',
						nrodoc='%s', 
						concepto='%s',
						matriz='%s',
						elim='%s'
						WHERE id= '".$_POST['iddetrend']."' LIMIT 1",
						$_POST['fechadet'],
						$_POST['rutdet'],
						$_POST['montodet'],
						$_POST['tipodocdet'],
						$_POST['nrodocdet'],
						$conceptodet,
						$matrizdet,
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
		}
    }

    public function editarrendarch()
    {
    	$fecha = date('Ym', strtotime($_POST['fecha']));
		$ano = intval(substr($fecha, 0, 4));
		$mes = intval(substr($fecha, 4, 2));

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "El periodo Mes:".$mes." Ano:".$ano." esta cerrado. No se puede realizar la operacion solicitada.";
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
	    	$nrorend = $_POST['folio'];
		    $id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;
			$sql = "SELECT aprobar FROM encrend WHERE id_encrend= '".$id_encRend."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['aprobar'];
        	if ($aprobar==1)
			{
				$mensajeError = "La rendicion ya se encuentra aprobada. No se puede realizar la operacion solicitada.";
				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError);
				echo json_encode($salidaJson);
			}
			else
			{
		    	$data = array();

				$archivo= $_POST['archivo'];
				$ultposder= strrpos($archivo,chr(92))+1;
				$archivo= substr($archivo,$ultposder);

				$ultposderext= strrpos($archivo,'.');
				$extension= substr($archivo,$ultposderext);

				//VALIDAR FOLIO
				if ($_POST['folio']== 0 || $_POST['folio']== null || !filter_var($_POST['folio'], FILTER_VALIDATE_INT))
				{
					$errors[] = 'Tienes que indicar el folio. ';
				}

				//VALIDAR ARCHIVO
				if ($archivo== null )
				{
					$errors[] = 'Tienes que indicar un archivo correctamente. '.$_POST['archivo'].' Este: '.$archivo;
				}

				//VALIDAR ARCHIVO A SUBIR
				if ( 0 < $_FILES['file']['error'] )
				{
					$errors[] = 'Error en el archivo. '.$_FILES['file']['error'];
				}

				//VALIDAR TAMAÑO ARCHIVO
				if ( $_FILES["file"]["size"] > 1000000 )
				{
					$errors[] = 'El archivo supera el tamano permitido. ';
				}

				//VALIDAR TIPO ARCHIVO	
				if (!(($_FILES["file"]["type"] == "image/pjpeg")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/png")
					|| ($_FILES["file"]["type"] == "image/jpg")
					|| ($_FILES["file"]["type"] == "application/pdf")))
				{
					//"application/x-zip-compressed"
					//"application/vnd.openxmlformats-officedocument-wordprocessingml.document"
					//"application/pdf"
					//"application/vnd.ms-excel" excel antiguo xls y csv
					//"text/plain"
					//"application/vnd.ms-excel.sheet.macroEnabled.12"
					//"application/vnd.openxmlformats-officedocument-spreadsheetml.sheet"
					
					$errors[] = 'El tipo de archivo no esta permitido. ';
				}

				if (empty($errors))
				{  	
					$rutaservidor= $_SESSION["id_empresa"].'/'.$_SESSION["id_usuariosel"].'/';
					$ruta= '%'.$_SESSION["id_empresa"].'%'.$_SESSION["id_usuariosel"];

					$folio = $_POST['folio'];
					$id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$folio;

					$tiempo=time();
					$nuevonomarch= 'E'.$_SESSION["id_empresa"].'U'.$_SESSION["id_usuariosel"].'R'.$folio.'Id'.date("Ymd_His", $tiempo).$extension;

					move_uploaded_file($_FILES['file']['tmp_name'], '../archivos/'.$rutaservidor. $nuevonomarch);
					
					//move_uploaded_file($_FILES['file']['tmp_name'], '../archivos/'.$rutaservidor. $_FILES['file']['name']);

					//$data = array('success' => 'NO FILES ARE SENT','formData' => $_REQUEST);
					//$data = array('Tipo: ' => $_FILES["file"]["type"],'formData' => $_REQUEST);
					$data = 0;	

					$query = sprintf
					(
						"UPDATE archrend
						SET
						archivo='%s',
						nuevoarchivo='%s',
						ruta='%s',
						elim='%s'
						WHERE id= '".$_POST['iddetarch']."' LIMIT 1",
						$archivo,
						$nuevonomarch,
						$ruta,
						1
					);
					

					$r_query= $this->conn->query($query);

					//$respuestaOK = true;
					//$mensajeError = 'Se ha guardado el registro correctamente';
					//$contenidoOK = $r_query;

					//$salidaJson = array("respuesta" => $respuestaOK,
										//"mensaje" => $mensajeError,
										//"contenido" => $contenidoOK);
					//echo json_encode($salidaJson);
					
					
					echo json_encode($data);
				}
				else
				{
					//$respuestaOK = false;
					//$mensajeError = $errors;
					//$contenidoOK = 0;

					//$salidaJson = array("respuesta" => $respuestaOK,
										//"mensaje" => $mensajeError,
										//"contenido" => $contenidoOK);
					//echo json_encode($salidaJson);
					
					$data = array('Errores: ' => $errors, 'Otro: ' => $_REQUEST);
					//$data = 0;
					echo json_encode($data);
				}
			}
		}
    }

    public function eliminarrenddet()
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
			$sql = "SELECT id_detRend FROM detrend WHERE id= '".$_POST['iddetrend']."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['id_detRend'];
			//$nrorend = $_POST['folio'];
		    //$id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;
			$sql = "SELECT aprobar FROM encrend WHERE id_encrend= '".$aprobar."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['aprobar'];
        	if ($aprobar==1)
			{
				$mensajeError = "La rendicion ya se encuentra aprobada. No se puede realizar la operacion solicitada.";
				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError);
				echo json_encode($salidaJson);
			}
			else
			{
				//$fechacomp = date('Y/m/d', strtotime($_POST['fecha']));         
				$query = sprintf
				(
					"UPDATE detrend
					SET
					elim='%s'
					WHERE id= '".$_POST['iddetrend']."' LIMIT 1",
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
    }

    public function eliminarrendarch()
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
			$sql = "SELECT id_detRend FROM detrend WHERE id= '".$_POST['iddetarch']."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['id_detRend'];
			//$nrorend = $_POST['folio'];
		    //$id_encRend = $_SESSION["id_usuariosel"].$_SESSION["id_empresa"].$nrorend;
			$sql = "SELECT aprobar FROM encrend WHERE id_encrend= '".$aprobar."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
        	$aprobar=$datos['aprobar'];
        	if ($aprobar==1)
			{
				$mensajeError = "La rendicion ya se encuentra aprobada. No se puede realizar la operacion solicitada.";
				$salidaJson = array("respuesta" => $respuestaOK,
									"mensaje" => $mensajeError);
				echo json_encode($salidaJson);
			}
			else
			{
				//$fechacomp = date('Y/m/d', strtotime($_POST['fecha']));         
				$query = sprintf
				(
					"UPDATE archrend
					SET
					elim='%s'
					WHERE id= '".$_POST['iddetarch']."' LIMIT 1",
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
    }


    public function buscarauxdet()
    {
    	$rutdet = $_POST['rutdet'];	
		$sql = "SELECT * FROM auxiliares WHERE rut= '".$rutdet."'";

		
		//$r_query = mysql_query($sql,parent::con());
		$r_query= $this->conn->query($sql);
		
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        		$contenidoOK['nombreaux'] = null;
				//$contenidoOK['um'] = $um;
				$buscar='buscando';

				if ($buscar=='buscando')
				{
					echo json_encode($contenidoOK);
				}
        }
        else
        {
			$contenidoOK = array();

			/* array asociativo */
			//$row = $r_query->fetch_array(MYSQLI_ASSOC);
		
			//while($datos = mysql_fetch_array($r_query)){
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
				$nombre = $datos['nombre'];
				//$um = $datos['um'];
				
			}
		
			$contenidoOK['nombreaux'] = $nombre;
			//$contenidoOK['um'] = $um;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

	public function buscardatosusuariosel()
    {	
    	//session_start();
		//sleep(0);

		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$buscar="";

		//$_POST['idemp']= $_SESSION["id_empresa"];
		//$_POST['idbod']= $_SESSION["id_bodega"];

    	$usuariosel_id = $_POST['usuariosel_id'];
    	//$us=2;
    	//$id_encOC = $_SESSION["backend_id"].$_POST['idemp'].$nrooc;
    	//$id_encOC = $us.$_POST['idemp'].$nrooc;

		$sql = "SELECT * FROM usuarios WHERE id_usuario= '".$usuariosel_id."'";
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
				$rutusuario = number_format($datos['rut'], 0, ',', '.')."-".$datos['dv'];
				$banco = $datos['banco'];
				$tipocuenta = $datos['tipocuenta'];
				$nrocuenta = $datos['nrocuenta'];
			}
			
			$sql = "SELECT banco FROM bancos WHERE id_banco= '".$banco."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			$banco = $datos['banco'];

			$sql = "SELECT tipocuenta FROM tipoctabanco WHERE id_tipocta= '".$tipocuenta."'";
			$r_query= $this->conn->query($sql);
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			$tipocuenta = $datos['tipocuenta'];

			$contenidoOK['rutusuario'] = $rutusuario;
			$contenidoOK['banco'] = $banco;
			$contenidoOK['tipocuenta'] = $tipocuenta;
			$contenidoOK['nrocuenta'] = $nrocuenta;
			
			echo json_encode($contenidoOK);
		}
		
    }

    public function verfondo()
    {      
		// Inicializamos variables de mensajes y JSON
		$respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		$contenidoOK = array();


    	$idfondo = $_POST['idfondo'];    	
    	$iduser = $_SESSION["id_usuariosel"];
    	

		$sql = "SELECT * FROM fondoasignado WHERE id_usuario= '".$iduser."' AND id_empresa= '".$_SESSION["id_empresa"]."'";
		$r_query= $this->conn->query($sql);
		$datos = $r_query->fetch_array(MYSQLI_ASSOC);
		
		$filas = $r_query->num_rows;
        
        //tiene fondo fijo asignado
        if($filas==1)
		{
			$fondoasign = $datos['fondoasign'];
			//fondo fijo
			if ($idfondo == 1)
			{
				$contenidoOK['tipfondo'] = 1;
				$contenidoOK['fondoasign'] = $fondoasign;
			}
			 else
        	{
        		$contenidoOK['tipfondo'] = 0;
        		$contenidoOK['fondoasign'] = 0;
        	}
				
		}
		else
		{
			$fondoasign = 'No tiene';
			
			if ($idfondo == 1)
			{
				$contenidoOK['tipfondo'] = 1;
				$contenidoOK['fondoasign'] = $fondoasign;
			}
			 else
        	{
        		$contenidoOK['tipfondo'] = 0;
        		$contenidoOK['fondoasign'] = 0;
        	}
		}

		echo json_encode($contenidoOK);

    }


}


?>