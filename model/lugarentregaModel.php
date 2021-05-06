<?php
class  Lugares extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 

	public function guardareditarlug()
    {
    	if ($_POST['accion']=='guardar')
		{
			$query = "SELECT * FROM lugarentrega WHERE id_entr= '". $_POST['id']."'";
	        //$r_query = mysql_query($query,parent::con());
	        $r_query= $this->conn->query($query);
	        $filas = $r_query->num_rows;

			//$filas = mysql_num_rows($r_query);
			if($filas==1)
			{
				$_POST['accion']='editar';
				$this->editarlug();
			}
			else
			{
				$this->guardarlug();
			}
		}
    }

	public function guardarlug()
    {
        $query = sprintf
		(
			"INSERT INTO lugarentrega
			SET
			id_entr='%s',
			direccion='%s'",
			$_POST['id'],
			$_POST['nombre']
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

	public function editarlug()
    {
        $query = sprintf
		(
			"UPDATE lugarentrega
			SET
			id_entr='%s',
			direccion='%s'
			WHERE id_entr= '".$_POST['id']."' LIMIT 1",
			$_POST['id'],
			$_POST['nombre']
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

	public function eliminarlug()
    {
    	$query = "DELETE FROM lugarentrega WHERE id_entr= '". $_POST['id']."'";

    	
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

    public function buscarlug()
    {
    	$id = $_POST['id'];	
		$sql = "SELECT * FROM lugarentrega WHERE id_entr= '".$id."'";

		
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
				$nombre = $datos['direccion'];
			}
		
			$contenidoOK['nombre'] = $nombre;
			$buscar='buscando';

			if ($buscar=='buscando')
			{
				echo json_encode($contenidoOK);
			}
		}
    }

    public function recorrelug()
    {
    	$sql = "SELECT * FROM lugarentrega";
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
		
		$id = $datos['id_entr'];
		$nombre = $datos['direccion'];
		
		
		$contenido['id'] = $id;	
		$contenido['nombre'] = $nombre;
		
		
		$buscar='buscando';
		$contenidoOK= $contenido;

		if ($buscar=='buscando')
		{
			echo json_encode($contenidoOK);
		}

    }


}



?>