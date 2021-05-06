<?php
if (empty($_POST['accion']))
{
	require_once("view/rendiciones.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/rendicionesModel.php");
	switch ($_POST['accion'])
	{
		case 'guardarrend':
			$comp=new Rendiciones();
			$comp->guardareditarrend();
		break;

		case 'guardarrenddet':
			$comp=new Rendiciones();
			$comp->guardareditarrenddet();
		break;

		case 'eliminarrend':
			$comp=new Rendiciones();
			$comp->eliminarrend();
		break;

		case 'buscar':
			$comp=new Rendiciones();
			$comp->buscar();
		break;

		case 'buscaraux':
			$comp=new Rendiciones();
			$comp->buscaraux();
		break;

		case 'buscarcuenta':
			$comp=new Rendiciones();
			$comp->buscarcuenta();
		break;

		case 'buscarcentro':
			$comp=new Rendiciones();
			$comp->buscarcentro();
		break;

		case 'revisafoliorend':
			$comp=new Rendiciones();
			$comp->revisafoliorend();
		break;

		case 'eliminarrenddet':
			$comp=new Rendiciones();
			$comp->eliminarrenddet();
		break;

		case 'eliminarrendarch':
			$comp=new Rendiciones();
			$comp->eliminarrendarch();
		break;

		case 'buscarauxdet':
			$comp=new Rendiciones();
			$comp->buscarauxdet();
		break;

		case 'buscardatosusuariosel':
			$comp=new Rendiciones();
			$comp->buscardatosusuariosel();
		break;

		case 'guardarrendarch':
			$comp=new Rendiciones();
			$comp->guardareditarrendarch();
		break;

		case 'subirrendarch':
			$comp=new Rendiciones();
			$comp->subirrendarch();
		break;

		case 'descargarrendarch':
			$comp=new Rendiciones();
			$comp->descargarrendarch();
		break;

		case 'verfondo':
			$comp=new Rendiciones();
			$comp->verfondo();
		break;

	}
}
?>