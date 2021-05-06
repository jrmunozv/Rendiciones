<?php
class  Articulos extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 

	public function guardareditarart()
    {
    	if ($_POST['accion']=='guardar')
		{
			$query = "SELECT * FROM articulos WHERE id= '". $_POST['id']."'";
	        //$r_query = mysql_query($query,parent::con());
	        $r_query= $this->conn->query($query);
	        $filas = $r_query->num_rows;

			//$filas = mysql_num_rows($r_query);
			if($filas==1)
			{
				$_POST['accion']='editar';
				$this->editarart();
			}
			else
			{
				$this->guardarart();
			}
		}
    }

	public function guardarart()
    {
        $query = sprintf
		(
			"INSERT INTO articulos
			SET
			id='%s',
			nombre_articulo='%s',
			um='%s', 
			categoria='%s',
			cuenta='%s',
			comentario='%s'",
			$_POST['id'],
			$_POST['nombre'],
			$_POST['um'],
			$_POST['categoria'],
			$_POST['cuenta'],
			$_POST['comentario']
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

		//return $this->datos;

	}

	public function editarart()
    {
        $query = sprintf
		(
			"UPDATE articulos
			SET
			id='%s',
			nombre_articulo='%s',
			um='%s', 
			categoria='%s',
			cuenta='%s',
			comentario='%s'
			WHERE id= '".$_POST['id']."' LIMIT 1",
			$_POST['id'],
			$_POST['nombre'],
			$_POST['um'],
			$_POST['categoria'],
			$_POST['cuenta'],
			$_POST['comentario']
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

	public function eliminarart()
    {
    	$query = "DELETE FROM articulos WHERE id= '". $_POST['id']."'";

    	
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

    public function buscarart()
    {
    	$id = $_POST['id'];	
		$sql = "SELECT * FROM articulos WHERE id= '".$id."'";

		
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
				$categoria = $datos['categoria'];
				$cuenta = $datos['cuenta'];
				$comentario = $datos['comentario'];
			}
		
			$contenidoOK['nombre'] = $nombre;
			$contenidoOK['um'] = $um;
			$contenidoOK['categoria'] = $categoria;
			$contenidoOK['cuenta'] = $cuenta;
			$contenidoOK['comentario'] = $comentario;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

    public function recorreart()
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