<?php
if (empty($_POST['accion']))
{
	require_once("view/periodo.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/periodoModel.php");

	switch ($_POST['accion'])
	{
		case 'cargarano':
			$ano=new Periodos();
			$ano->cargarano();
		break;

		case 'cerrarmes':
			$mes=new Periodos();
			$mes->cerrarmes();
		break;

		case 'abrirmes':
			$mes=new Periodos();
			$mes->abrirmes();
		break;

	}
	
}
?>
