<?php
class  Rendiciones extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 
	
    
    public function editarrend()
    {	
			$nrorend = $_POST['codrend'];
			$aprobar = $_POST['aprobar'];
	    	
	    	//VALIDAR ESTADO
	        if ($_POST['codrend']== null)
	        {
	        	$errors[] = 'Tienes que seleccionar una rendicion. ';
	        }


	        if (empty($errors))
        	{
				$query = sprintf
				(
					"UPDATE encrend
					SET
					aprobar='%s'
					WHERE id_encrend= '".$nrorend."' LIMIT 1",
					$_POST['aprobar']
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


?>