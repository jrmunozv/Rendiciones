<?php
class  Auxiliares extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 

	public function guardareditaraux()
    {
    	if ($_POST['accion']=='guardar')
		{
			$query = "SELECT * FROM auxiliares WHERE rut= '". $_POST['rut']."'";
	        //$r_query = mysql_query($query,parent::con());
	        $r_query= $this->conn->query($query);
	        $filas = $r_query->num_rows;

			//$filas = mysql_num_rows($r_query);
			if($filas==1)
			{
				$_POST['accion']='editar';
				$this->editaraux();
			}
			else
			{
				$this->guardaraux();
			}
		}
    }

	public function guardaraux()
    {
        //VALIDAR RUT
	    if ($_POST['rut']== 0 || $_POST['rut']== null || !filter_var($_POST['rut'], FILTER_VALIDATE_INT))
	    {
	    	$errors[] = 'Tienes que seleccionar o indicar un rut correcto. ';
	    }

	    //VALIDAR RAZON SOCIAL
        $nombre= trim($_POST['nombre']);
        $nombre= mysqli_escape_string($this->conn,strip_tags($nombre));
        $strlen= mb_strlen($nombre,'utf8');
        if($strlen < 1)
        {
        	$errors[] = 'Olvidaste la razon social. ';
        }

        //VALIDAR DIRECCION
        $direccion= trim($_POST['direccion']);
        $direccion= mysqli_escape_string($this->conn,strip_tags($direccion));
        $strlen= mb_strlen($direccion,'utf8');
        if($strlen < 1)
        {
        	$errors[] = 'Olvidaste la direccion. ';
        }

        //VALIDAR COMUNA
        $comuna= trim($_POST['comuna']);
        $comuna= mysqli_escape_string($this->conn,strip_tags($comuna));
        $strlen= mb_strlen($comuna,'utf8');
        if($strlen < 1)
        {
        	$errors[] = 'Olvidaste la comuna. ';
        }

    	//VALIDAR EMAIL
        $email= false;
        if (empty($_POST['mail']))
        {
        	$errors[] = 'Olvidaste el mail. ';
        }

        if (filter_var((trim($_POST['mail'])),FILTER_VALIDATE_EMAIL))
        {
        	$email= mysqli_escape_string($this->conn,trim($_POST['mail']));
        }
        else
        {
        	$errors[] = 'Mail invalido. ';	
        }


        if (empty($errors))
        {
	        $query = sprintf
			(
				"INSERT INTO auxiliares
				SET
				rut='%s',
				dv='%s', 
				nombre='%s',
				direccion='%s',
				comuna='%s',
				telefono='%s',
				celular='%s',
				mail='%s',
				contacto='%s',
				ctacte='%s',
				banco='%s',
				estado='%s'",
				$_POST['rut'],
				$_POST['dv'],
				$nombre,
				$direccion,
				$comuna,
				$_POST['telefono'],
				$_POST['celular'],
				$email,
				$_POST['contacto'],
				$_POST['ctacte'],
				$_POST['banco'],
				$_POST['estado']
			);
			
			//$r_query = mysql_query($query,parent::con());
			$r_query= $this->conn->query($query);
			
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

	public function editaraux()
    {
        $query = sprintf
		(
			"UPDATE auxiliares
			SET
			rut='%s',
			dv='%s', 
			nombre='%s',
			direccion='%s',
			comuna='%s',
			telefono='%s',
			celular='%s',
			mail='%s',
			contacto='%s',
			ctacte='%s',
			banco='%s',
			estado='%s'
			WHERE rut= '".$_POST['rut']."' LIMIT 1",
			$_POST['rut'],
			$_POST['dv'],
			$_POST['nombre'],
			$_POST['direccion'],
			$_POST['comuna'],
			$_POST['telefono'],
			$_POST['celular'],
			$_POST['mail'],
			$_POST['contacto'],
			$_POST['ctacte'],
			$_POST['banco'],
			$_POST['estado']
		);

		
		//$r_query = mysql_query($query,parent::con());
		$r_query= $this->conn->query($query);
		
		// Validamos que se haya actualizado el registro
		//if($r_query -> affected_rows == 1){
		$respuestaOK = true;
		$mensajeError = 'Se ha editado el registro correctamente';
		$contenidoOK = $r_query;

		$salidaJson = array("respuesta" => $respuestaOK,
							"mensaje" => $mensajeError,
							"contenido" => $contenidoOK);
		echo json_encode($salidaJson);

	}

	public function eliminaraux()
    {
		$query = "DELETE FROM auxiliares WHERE rut= '". $_POST['rut']."'";

    	
        //$r_query = mysql_query($query,parent::con());
        $r_query= $this->conn->query($query);
		
		$respuestaOK = true;
		$mensajeError = 'Se ha eliminado el registro correctamente';
		$contenidoOK = $r_query;

		$salidaJson = array("respuesta" => $respuestaOK,
						"mensaje" => $mensajeError,
						"contenido" => $contenidoOK);
		echo json_encode($salidaJson);		
    }

    public function buscaraux()
    {
    	$rut = $_POST['rut'];	
		$sql = "SELECT * FROM auxiliares WHERE rut= '".$rut."'";

		
		//$r_query = mysql_query($sql,parent::con());
		$r_query= $this->conn->query($sql);
		
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        	$contenidoOK['dv'] = "";
        	echo json_encode($contenidoOK);
        }
        else
        {
			$contenidoOK = array();

			/* array asociativo */
			//$row = $r_query->fetch_array(MYSQLI_ASSOC);
		
			//while($datos = mysql_fetch_array($r_query)){
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
				$dv = $datos['dv'];
				$nombre = $datos['nombre'];
				$direccion = $datos['direccion'];
				$comuna = $datos['comuna'];
				$telefono = $datos['telefono'];
				$celular = $datos['celular'];
				$mail = $datos['mail'];
				$contacto = $datos['contacto'];
				$ctacte = $datos['ctacte'];
				$banco = $datos['banco'];
				$estado = $datos['estado'];
			}
			
			$contenidoOK['dv'] = $dv;
			$contenidoOK['nombre'] = $nombre;
			$contenidoOK['direccion'] = $direccion;
			$contenidoOK['comuna'] = $comuna;
			$contenidoOK['telefono'] = $telefono;
			$contenidoOK['celular'] = $celular;
			$contenidoOK['mail'] = $mail;
			$contenidoOK['contacto'] = $contacto;
			$contenidoOK['ctacte'] = $ctacte;
			$contenidoOK['banco'] = $banco;
			$contenidoOK['estado'] = $estado;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

    public function recorreaux()
    {
    	$sql = "SELECT * FROM auxiliares";
    	$r_query= $this->conn->query($sql);
		//$r_query = mysql_query($sql,parent::con());
	
		$contenido = array();
		
		
		if ($_POST['pos']=='ultimo')
		{
			$filas = $r_query->num_rows;
			$filas= $filas-1;

			//$filas = mysql_num_rows($r_query)-1; // obtenemos el número de filas
			
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			//$datos = mysql_fetch_array($r_query);

			 /* saltar a la fila numero 400 */
		    $r_query->data_seek($filas);

		    /* obtener fila */
		    $row = $r_query->fetch_row($filas);

			//mysql_data_seek($r_query, $filas);

			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			//$datos = mysql_fetch_array($r_query);
			$reg=$filas;
			$contenido['reg'] = $reg;
		}
		else if ($_POST['pos']=='primer')
		{
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			//$datos = mysql_fetch_array($r_query);	
		}
		else if ($_POST['pos']=='siguiente')
		{
			$filas = $r_query->num_rows;
			$filas= $filas-1;

			//$filas = mysql_num_rows($r_query)-1; // obtenemos el número de filas
			$reg=$_POST['reg'];
			
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			//$datos = mysql_fetch_array($r_query);

			/* saltar a la fila numero 400 */
		    $r_query->data_seek($reg);

		    /* obtener fila */
		    $row = $r_query->fetch_row($reg);

			//mysql_data_seek($r_query, $reg);
			
			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			//$datos = mysql_fetch_array($r_query);
			if ($filas==$reg)
			{	
			}
			else
			{
				$reg=$reg + 1;
			}
			$contenido['reg'] = $reg;
		}
		else if ($_POST['pos']=='anterior')
		{
			if($_POST['reg']==0)
			{
				$reg=0;
			}
			else
			{
				$reg=$_POST['reg']-1;
			}

			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			//$datos = mysql_fetch_array($r_query);
			
			/* saltar a la fila numero 400 */
		    $r_query->data_seek($reg);

		    /* obtener fila */
		    $row = $r_query->fetch_row($reg);

			//mysql_data_seek($r_query, $reg);

			$datos = $r_query->fetch_array(MYSQLI_ASSOC);
			//$datos = mysql_fetch_array($r_query);
			
			$contenido['reg'] = $reg;
		}
		
		$id = $datos['id'];
		$nombre = $datos['nombre_articulo'];
		$um = $datos['um'];
		$categoria = $datos['categoria'];
		$cuenta = $datos['cuenta'];
		$comentario = $datos['comentario'];
		
		
		$contenido['id'] = $id;	
		$contenido['nombre'] = $nombre;
		$contenido['um'] = $um;
		$contenido['categoria'] = $categoria;
		$contenido['cuenta'] = $cuenta;
		$contenido['comentario'] = $comentario;
		
		
		$buscar='buscando';
		$contenidoOK= $contenido;

		if ($buscar=='buscando')
		{
			echo json_encode($contenidoOK);
		}

    }


}



?>