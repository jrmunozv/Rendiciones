<?php
class  User extends Conexion
{
    
    private $u;
    
    public function __construct()
    {
        $this->u=array();
        parent::__construct();
    }
    public function logueo()
    {
        //parent::con();
        //$pass= SHA1($_POST["pass"]);
        $log=$_POST["login"];
        $pass= $_POST["pass"];
        
        $sql=sprintf
        (
            "SELECT id_usuario,login FROM usuarios
            WHERE
            login=%s
            AND
            pass=%s",
            //$_POST["login"],
            //$_POST["pass"]
            parent::comillas_inteligentes($log),
            parent::comillas_inteligentes($pass)
        );
       //echo $sql;exit;
        
        $res= $this->conn->query($sql);
        //$res=mysql_query($sql);


        //echo mysql_num_rows($res);exit;
        $filas = $res->num_rows;
        //if(mysql_num_rows($res)==0)
        if($filas==0)
        {
            header("Location: ".Conectar::ruta()."index/1/");exit;
        }else
        {
            
            //if($reg=mysql_fetch_array($res))
            if($reg=$res->fetch_array(MYSQLI_ASSOC))
            {
                $_SESSION["backend_id"]=$reg["id_usuario"];
                $_SESSION["backend_login"]=$reg["login"];
                header("Location: ".Conectar::ruta()."home/");
            }
        }
    }


}
?>