
<?php
if (empty($_POST['accion']))
{
	require_once("view/auxiliares.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/auxiliaresModel.php");

	switch ($_POST['accion'])
	{
		case 'guardar':
			$aux=new Auxiliares();
			$aux->guardareditaraux();
		break;

		case 'eliminar':
			$aux=new Auxiliares();
			$aux->eliminaraux();
		break;

		case 'buscar':
			$aux=new Auxiliares();
			$aux->buscaraux();
		break;

		case 'recorre':
			$art=new Auxiliares();
			$art->recorreaux();
		break;
	}
	
}
?>