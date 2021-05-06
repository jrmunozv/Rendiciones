<?php

require_once("model/menuModel.php");

if(isset($_SESSION["empresa"]))
{
	$menus=new Menu();
	$menu=$menus->conempresaselect();
}
else
{
	$menus=new Menu();
	$menu=$menus->sinempresaselect();
}

?>