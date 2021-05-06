<?php
class  Usuarios extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 

	public function guardareditarusu()
    {
    	if ($_POST['accion']=='guardar')
		{
			$query = "SELECT * FROM usuarios WHERE id_usuario= '". $_POST['id']."'";
	        //$r_query = mysql_query($query,parent::con());
	        $r_query= $this->conn->query($query);
	        $filas = $r_query->num_rows;

			//$filas = mysql_num_rows($r_query);
			if($filas==1)
			{
				$_POST['accion']='editar';
				$this->editarusu();
			}
			else
			{
				$this->guardarusu();
			}
		}
    }

	public function guardarusu()
    {
        //VALIDAR LOG
        if (empty($_POST['log']))
        {
        	$errors[] = 'Olvidaste el login. ';
        }

        $log= trim($_POST['log']);
        $strippedlog= mysqli_escape_string($this->conn,strip_tags($log));
        $logpermitido = '/^[A-Z üÜáéíóúÁÉÍÓÚ]{1,15}$/i';
        if (!preg_match($logpermitido,$strippedlog))
        {
        	$errors[] = 'Login invalido. ';
        }


        //VALIDAR NOMBRE
        $nom= trim($_POST['nombre']);
        $strippednom= mysqli_escape_string($this->conn,strip_tags($nom));
        $strlen= mb_strlen($strippednom,'utf8');
        if($strlen < 1)
        {
        	$errors[] = 'Olvidaste el nombre. ';
        }

        //VALIDAR EMAIL
        $email= false;
        if (empty($_POST['correo']))
        {
        	$errors[] = 'Olvidaste el mail. ';
        }

        if (filter_var((trim($_POST['correo'])),FILTER_VALIDATE_EMAIL))
        {
        	$email= mysqli_escape_string($this->conn,trim($_POST['correo']));
        }
        else
        {
        	$errors[] = 'Mail invalido. ';	
        }


        //VALIDAR PASS
        if (empty($_POST['password']))
        {
        	$errors[] = 'Olvidaste la pass. ';
        }

        /*
        $cadena="AB-4554"; 
		$expresion = '/^[A-Z]{2}-[0-9]{4}$/';  // /i case-insensitivo 

		if (preg_match($expresion, $cadena)){  
		  echo 'si';  
		  }else{  
		  echo 'nooo!!';  
		  } 
		 */


        $pass= mysqli_escape_string($this->conn,trim($_POST['password']));
        $passpermitida = '/^[A-Z üÜáéíóúÁÉÍÓÚ]{1,15}[0-9]{1,6}$/i';
        if (!preg_match($passpermitida,$pass))
        {
        	$errors[] = 'Pass invalida. ';
        }

        if (empty($errors))
        {
	        $query = sprintf
			(
				"INSERT INTO usuarios
				SET
				login='%s',
				nombre='%s', 
				correo='%s',
				pass='%s',
				imgfirma='%s',
				admin='%s'",
				$strippedlog,
				$strippednom,
				$email,
				SHA1($pass),
				$_POST['firma'],
				$_POST['admin']
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

	public function editarusu()
    {
        //VALIDAR LOG
        if (empty($_POST['log']))
        {
        	$errors[] = 'Olvidaste el login. ';
        }

        $log= trim($_POST['log']);
        $strippedlog= mysqli_escape_string($this->conn,strip_tags($log));
        $logpermitido = '/^[A-Z üÜáéíóúÁÉÍÓÚ]{1,15}$/i';
        if (!preg_match($logpermitido,$strippedlog))
        {
        	$errors[] = 'Login invalido. ';
        }


        //VALIDAR NOMBRE
        $nom= trim($_POST['nombre']);
        $strippednom= mysqli_escape_string($this->conn,strip_tags($nom));
        $strlen= mb_strlen($strippednom,'utf8');
        if($strlen < 1)
        {
        	$errors[] = 'Olvidaste el nombre. ';
        }

        //VALIDAR EMAIL
        $email= false;
        if (empty($_POST['correo']))
        {
        	$errors[] = 'Olvidaste el mail. ';
        }

        if (filter_var((trim($_POST['correo'])),FILTER_VALIDATE_EMAIL))
        {
        	$email= mysqli_escape_string($this->conn,trim($_POST['correo']));
        }
        else
        {
        	$errors[] = 'Mail invalido. ';	
        }


        //VALIDAR PASS
        if (empty($_POST['password']))
        {
        	$errors[] = 'Olvidaste la pass. ';
        }

        /*
        $cadena="AB-4554"; 
		$expresion = '/^[A-Z]{2}-[0-9]{4}$/';  // /i case-insensitivo 

		if (preg_match($expresion, $cadena)){  
		  echo 'si';  
		  }else{  
		  echo 'nooo!!';  
		  } 
		 */


        $pass= mysqli_escape_string($this->conn,trim($_POST['password']));
        //$passpermitida = '/^[A-Z üÜáéíóúÁÉÍÓÚ]{1,15}[0-9]{1,6}$/i';
        $passpermitida = '/^[A-Z 0-9 üÜáéíóúÁÉÍÓÚ]{1,15}$/i';
        if (!preg_match($passpermitida,$pass))
        {
        	$errors[] = 'Pass invalida. ';
        }

        if (empty($errors))
        {
	        $query = sprintf
			(
				"UPDATE usuarios
				SET
				id_usuario='%s',
				login='%s',
				nombre='%s', 
				correo='%s',
				pass='%s',
				imgfirma='%s',
				admin='%s'
				WHERE id_usuario= '".$_POST['id']."' LIMIT 1",
				$_POST['id'],
				$strippedlog,
				$strippednom,
				$email,
				SHA1($pass),
				$_POST['firma'],
				$_POST['admin']
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

	public function eliminarusu()
    {
    	$query = "DELETE FROM usuarios WHERE id_usuario= '". $_POST['id']."'";

    	
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

    public function buscarusu()
    {
    	$id = $_POST['id'];	
		$sql = "SELECT * FROM usuarios WHERE id_usuario= '".$id."'";

		
		//$r_query = mysql_query($sql,parent::con());
		$r_query= $this->conn->query($sql);
		
		$filas = $r_query->num_rows;
        
        if($filas==0)
        {
        	$contenidoOK['log'] = false;
        	echo json_encode($contenidoOK);
        }
        else
        {
			$contenidoOK = array();

			/* array asociativo */
			//$row = $r_query->fetch_array(MYSQLI_ASSOC);
		
			//while($datos = mysql_fetch_array($r_query)){
			while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
				$log = $datos['login'];
				$nombre = $datos['nombre'];
				$correo = $datos['correo'];
				//$password = $datos['pass'];
				$firma = $datos['imgfirma'];
				$admin = $datos['admin'];
			}
		
			$contenidoOK['log'] = $log;
			$contenidoOK['nombre'] = $nombre;
			$contenidoOK['correo'] = $correo;
			//$contenidoOK['password'] = $password;
			$contenidoOK['firma'] = $firma;
			$contenidoOK['admin'] = $admin;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

    public function recorreusu()
    {
    	$sql = "SELECT * FROM articulos";
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