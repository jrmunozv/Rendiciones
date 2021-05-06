<?php
if(isset($_GET['idemp']))
{
	$form='cambiaempresa';
}

switch($form)
{
	case 'empresas':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_empresas();
	break;
	
	case 'empresaactiva':
		
		if($tipo=="empresa")
		{
			require_once("model/formulariosModel.php");
			$c=new Formularios();
			$c->muestraempresaselected();

		}
		elseif($tipo=="usuariosel")
		{
			require_once("model/formulariosModel.php");
			$c=new Formularios();
			$c->muestrausuarioselected();
		}
		
	break;

	case 'cambiaempresa':
		require_once("../includes/config.php");
		require_once("../model/formulariosModel.php");
		$c=new Formularios();
		$c->cambiaempresa();
		
	break;
		
	case 'tipocompr':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_tipocomp();
	break;

	case 'tipofondo':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_tipofondo();
	break;

	case 'lugarentrega':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_lugarentrega();
	break;

	case 'condpago':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_condpago();
	break;

	case 'um':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_um();
	break;

	case 'tipodocdet':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_tipodocdet();
	break;

	case 'estado':
		require_once("model/formulariosModel.php");
		$c=new Formularios();
		$datos=$c->get_estado();
	break;
			
	default:	
			
	break;	
}

?>