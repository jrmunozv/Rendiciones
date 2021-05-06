<?php
if (empty($_POST['accion']))
{
	require_once("view/lugarentrega.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/lugarentregaModel.php");

	switch ($_POST['accion'])
	{
		case 'guardar':
			$lug=new Lugares();
			$lug->guardareditarlug();
		break;

		case 'eliminar':
			$lug=new Lugares();
			$lug->eliminarlug();
		break;

		case 'buscar':
			$lug=new Lugares();
			$lug->buscarlug();
		break;

		case 'recorre':
			$lug=new Luagares();
			$lug->recorrelug();
		break;
	}
	
}
?>