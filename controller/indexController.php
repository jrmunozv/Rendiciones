<?php
require_once("model/userModel.php");
$u=new User();

if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
    $u->logueo();
    exit;
}
require_once("view/index.phtml");

?>