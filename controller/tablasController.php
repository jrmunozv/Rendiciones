<?php
if (empty($_POST['accion']))
{
	
}
else
{
	require_once("../includes/config.php");
	require_once("../model/tablasModel.php");

	switch ($_POST['accion'])
	{
		case 'buscarart':
			$art=new Tablas();
			$art->buscarart();
		break;

		case 'buscarlug':
			$lug=new Tablas();
			$lug->buscarlug();
		break;

		case 'buscarusu':
			$usu=new Tablas();
			$usu->buscarusu();
		break;

		case 'buscaraux':
			$aux=new Tablas();
			$aux->buscaraux();
		break;

		case 'buscarrend':
			$oc=new Tablas();
			$oc->buscarrend();
		break;

		case 'buscarrendaprob':
			$rend=new Tablas();
			$rend->buscarrendaprob();
		break;

		case 'buscarmatriz':
			$cta=new Tablas();
			$cta->buscarmatriz();
		break;

		case 'buscarrendarch':
			$cta=new Tablas();
			$cta->buscarrendarch();
		break;

		case 'buscarcentro':
			$cent=new Tablas();
			$cent->buscarcentro();
		break;

		case 'buscarrenddet':
			$renddet=new Tablas();
			$renddet->buscarrenddet();
		break;

		case 'buscarreg':
			$reg=new Tablas();
			$reg->buscarreg();
		break;

		case 'buscarstock':
			$sto=new Tablas();
			$sto->buscarstock();
		break;
	}
	
}

?>