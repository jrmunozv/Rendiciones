<?php
	
	require_once("../includes/config.php");
	require_once("../model/empresaModel.php");
	$emp=new Empresa();
	$emp->selectperiodempresa();
	
?>