<?php
/*
require_once("model/userModel.php");
$u=new User();

$datos=$u->get_usuarios();
require_once("view/user.phtml");
*/


if (empty($_POST['accion']))
{
	require_once("view/usuarios.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/usuariosModel.php");

	switch ($_POST['accion'])
	{
		case 'guardar':
			$usu=new Usuarios();
			$usu->guardareditarusu();
		break;

		case 'eliminar':
			$usu=new Usuarios();
			$usu->eliminarusu();
		break;

		case 'buscar':
			$usu=new Usuarios();
			$usu->buscarusu();
		break;

		case 'recorre':
			$usu=new Usuarios();
			$usu->recorreusu();
		break;
	}
	
}


?>