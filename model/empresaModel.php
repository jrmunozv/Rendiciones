<?php
class Empresa extends Conexion
{
	public function selectperiodempresa()
    {
        $respuestaOK = false;
		$mensajeError = "No se puede ejecutar la aplicación";
		$contenidoOK = "";
		
		$idempresa = $_POST['id_empresa'];
		$idusuariosel = $_POST['id_usuariosel'];
		$mes = $_POST['mes'];
		$ano = $_POST['ano'];
		
		
		$sql="SELECT nombre FROM empresas WHERE id_empresa= '".$idempresa."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);

		$_SESSION["empresa"]=$reg['nombre'];
		$_SESSION["id_empresa"]=$idempresa;
			
			
		$sql="SELECT nombre FROM usuarios WHERE id_usuario= '".$idusuariosel."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);

		$_SESSION["usuariosel"]=$reg['nombre'];
		$_SESSION["id_usuariosel"]=$idusuariosel;
			
		$_SESSION["mes"]=$mes;
		$_SESSION["ano"]=$ano;
			
		$contenidoOK['empresa'] = '<span>'.$_SESSION["empresa"].'</span>';
		$contenidoOK['usuariosel'] = '<span>'.$_SESSION["usuariosel"].'</span>';
		$contenidoOK['periodo'] = '<span>'.$_SESSION["mes"].'-'.$_SESSION["ano"].'</span>';
			
		echo json_encode($contenidoOK);
		

	}
}
?>