<?php
require_once("includes/config.php");
//print_r($_GET);
if(isset($_SESSION["backend_id"]))
{
    if(isset($_GET["accion"]))
    {
        $accion=$_GET["accion"];
    }else
    {
        $accion="home";
    }
    
    if(is_file("controller/".$accion."Controller.php"))
    {
        require_once("controller/".$accion."Controller.php");

    }else
    {
        require_once("controller/errorController.php");
    }
}else
{
    require_once("controller/indexController.php");

}


?>