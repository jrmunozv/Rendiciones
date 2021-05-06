<?php
if (empty($_POST['accion']))
{
	require_once("view/comprobante.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/comprobanteModel.php");
	switch ($_POST['accion'])
	{
		case 'guardaroc':
			$comp=new Comprobante();
			$comp->guardareditaroc();
		break;

		case 'guardarocdet':
			$comp=new Comprobante();
			$comp->guardareditarocdet();
		break;

		case 'eliminarcomp':
			$comp=new Comprobante();
			$comp->eliminarcomp();
		break;

		case 'buscar':
			$comp=new Comprobante();
			$comp->buscar();
		break;

		case 'buscaraux':
			$comp=new Comprobante();
			$comp->buscaraux();
		break;

		case 'buscarcuenta':
			$comp=new Comprobante();
			$comp->buscarcuenta();
		break;

		case 'buscarcentro':
			$comp=new Comprobante();
			$comp->buscarcentro();
		break;

		case 'revisafoliooc':
			$comp=new Comprobante();
			$comp->revisafoliooc();
		break;

		case 'eliminarocdet':
			$comp=new Comprobante();
			$comp->eliminarocdet();
		break;

		case 'buscarart':
			$comp=new Comprobante();
			$comp->buscarart();
		break;

		case 'buscartotales':
			$comp=new Comprobante();
			$comp->buscartotales();
		break;

	}
}
?>