<?php
class  Menu extends Conexion
{
	public function __construct()
    {
        parent::__construct();
    } 

	public function conempresaselect()
    {
    	$sql="SELECT id_usuario FROM usuarios WHERE login= '".$_SESSION["backend_login"]."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		
		$sql="SELECT nombre,habilitado FROM menu WHERE id_usuario= '".$reg['id_usuario']."'";
		$res= $this->conn->query($sql);
		
		$menu=array();
		
		while($reg=$res->fetch_array(MYSQLI_ASSOC))
		{
			$menu[$reg['nombre']]=$reg['habilitado'];
		}

		return $menu;

    }

    public function sinempresaselect()
    {
    	$sql="SELECT id_usuario FROM usuarios WHERE login= '".$_SESSION["backend_login"]."'";
		$res= $this->conn->query($sql);
		$reg = $res->fetch_array(MYSQLI_ASSOC);
		
		$sql="SELECT nombre,habilitado FROM menu WHERE id_usuario= '".$reg['id_usuario']."'";
		$res= $this->conn->query($sql);
		
		$menu=array();
		
		while($reg=$res->fetch_array(MYSQLI_ASSOC))
		{
			$menu[$reg['nombre']]=0;
		}

		return $menu;

    }

}



?>