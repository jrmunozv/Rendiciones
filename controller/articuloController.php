<?php
if (empty($_POST['accion']))
{
	require_once("view/articulos.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/articulosModel.php");

	switch ($_POST['accion'])
	{
		case 'guardar':
			$art=new Articulos();
			$art->guardareditarart();
		break;

		case 'eliminar':
			$art=new Articulos();
			$art->eliminarart();
		break;

		case 'buscar':
			$art=new Articulos();
			$art->buscarart();
		break;

		case 'recorre':
			$art=new Articulos();
			$art->recorreart();
		break;
	}
	
}
?>