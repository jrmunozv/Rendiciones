<?php
class  Periodos extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 

    public function cargarano()
    {
    	$ano = $_POST['ano'];	
		$sql = "SELECT * FROM periodo WHERE ano= '".$ano."'";

		
		//$r_query = mysql_query($sql,parent::con());
		$r_query= $this->conn->query($sql);
	
		$contenidoOK = array();

		/* array asociativo */
		//$row = $r_query->fetch_array(MYSQLI_ASSOC);
	
		//while($datos = mysql_fetch_array($r_query)){
		/*
		while($datos = $r_query->fetch_array(MYSQLI_ASSOC)){
			$regmes = $datos['mes'];
			$regac = $datos['ac'];
			
			//$contenidoOK[] = $regmes;
			$contenidoOK[] = $regac;
		}
		*/
		$regmes= array();
    	$regac = array();
	    while($datos = mysqli_fetch_array($r_query))
	    {
	    	//$contenidoOK.=$datos['mes'].";".$datos['ac'].";";	
	    	$regmes[] = $datos['mes'];
			$regac[] = $datos['ac'];	
	    }

	    $contenidoOK=array($regmes, $regac);
	
		$buscar='buscando';

		if ($buscar=='buscando')
		{
			echo json_encode(array("contenido"=>$contenidoOK));
		}
    } 

    public function cerrarmes()
    {
    	$mes = $_POST['mes'];
    	$ano = $_POST['ano'];		
		

		$query = sprintf
		(
			"UPDATE periodo
			SET
			ac='%s'
			WHERE ano= '".$ano."' AND mes= '".$mes."' LIMIT 1",
			0
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

    public function abrirmes()
    {
    	$mes = $_POST['mes'];
    	$ano = $_POST['ano'];		
		

		$query = sprintf
		(
			"UPDATE periodo
			SET
			ac='%s'
			WHERE ano= '".$ano."' AND mes= '".$mes."' LIMIT 1",
			1
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

}



?>