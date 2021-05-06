<?php
if (empty($_POST['accion']))
{
	require_once("view/tesoreria.phtml");
}
else
{
	require_once("../includes/config.php");
	require_once("../model/tesoreriaModel.php");
	switch ($_POST['accion'])
	{
		case 'editarrend':
			$rend=new Rendiciones();
			$rend->editarrend();
		break;
	}
}
?>
