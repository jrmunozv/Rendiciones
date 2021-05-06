<?php
if (empty($_POST['accion']))
{
	require_once("view/aprobacion.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/aprobacionModel.php");
	switch ($_POST['accion'])
	{
		case 'editarrend':
			$rend=new Rendiciones();
			$rend->editarrend();
		break;
	}
}
?>
