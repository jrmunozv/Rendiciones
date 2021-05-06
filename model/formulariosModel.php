<?php
class Formularios extends Conexion
{

    private $form;
    
    public function __construct()
    {
        $this->form=array();
        parent::__construct();
    }
	   
    public function get_empresas()
    {
        $sql="SELECT id_usuario FROM usuarios WHERE login= '".$_SESSION["backend_login"]."'";
        $res= $this->conn->query($sql);
        $reg = $res->fetch_array(MYSQLI_ASSOC);

        //$res=mysql_query($sql,parent::con());
		//$reg=mysql_fetch_assoc($res);
		$sql="SELECT DISTINCT id_empresa FROM acceso WHERE id_usuario= '".$reg['id_usuario']."'";
		$res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $sql="SELECT id_empresa, nombre FROM empresas WHERE id_empresa= '".$reg['id_empresa']."'";
			$ress= $this->conn->query($sql);
            $regg = $ress->fetch_array(MYSQLI_ASSOC);
            //$ress=mysql_query($sql,parent::con());
			//$regg=mysql_fetch_assoc($ress);
			$this->form[]=$regg;
        }
        return $this->form;
 	}

    public function muestraempresaselected()
    {
        $sql="SELECT id_usuario FROM usuarios WHERE login= '".$_SESSION["backend_login"]."'";
        $res= $this->conn->query($sql);
        $reg = $res->fetch_array(MYSQLI_ASSOC);

        //$res=mysql_query($sql,parent::con());
        //$reg=mysql_fetch_assoc($res);
        $sql="SELECT DISTINCT id_empresa FROM acceso WHERE id_usuario= '".$reg['id_usuario']."'";
        $res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $sql="SELECT id_empresa, nombre FROM empresas WHERE id_empresa= '".$reg['id_empresa']."'";
            $ress= $this->conn->query($sql);
            $regg = $ress->fetch_array(MYSQLI_ASSOC);

            //$ress=mysql_query($sql,parent::con());
            //$regg=mysql_fetch_assoc($ress);
            echo '<option value="'.$regg['id_empresa'].'"';
            if($regg['nombre']==$_SESSION["empresa"])
            {
                echo " selected";
            }
            echo '>'.$regg['nombre'].'</option>';
            
        }
    }

    public function muestrausuarioselected()
    {
        
//******************************************************+
        $sql="SELECT id_usuario, admin FROM usuarios WHERE login= '".$_SESSION["backend_login"]."'";
        $res= $this->conn->query($sql);
        $reg = $res->fetch_array(MYSQLI_ASSOC);


        //$res=mysql_query($sql,parent::con());
        //$reg=mysql_fetch_assoc($res);
        if ($reg['admin']== 1)
        {
            //Muestra todos los usuarios de la empresa seleccionada
            $sql="SELECT id_usuario FROM acceso WHERE id_empresa= '".$_SESSION["id_empresa"]."'";
            //."' AND id_usuario= '".$reg['id_usuario']."'";
            $res= $this->conn->query($sql);
        }
        elseif($reg['admin']== 0)
        {
            // 0 es igual a accesos usuario NO adminsitrador
            $sql="SELECT id_usuario FROM acceso WHERE id_empresa= '".$_SESSION["id_empresa"]."' AND id_usuario= '".$reg['id_usuario']."'";
            $res= $this->conn->query($sql);
            
        }

        //$res = mysql_query($sql,parent::con());
        
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $sql="SELECT id_usuario, nombre, login FROM usuarios WHERE id_usuario= '".$reg['id_usuario']."'";
            $ress= $this->conn->query($sql);
            $regg = $ress->fetch_array(MYSQLI_ASSOC);

            //$ress=mysql_query($sql,parent::con());
            //$regg=mysql_fetch_assoc($ress); 
            echo '<option value="'.$regg['id_usuario'].'"';
            if($regg['id_usuario']==$_SESSION["id_usuariosel"])//$_SESSION["backend_id"])
            {
                echo " selected";
            }
            echo '>'.$regg['nombre'].'</option>';
        }
    }

    public function cambiaempresa()
    {
        //Esto vine de funcionesjs: change(function
        $idempresa = $_GET['idemp'];
        
        $sql="SELECT id_usuario, admin FROM usuarios WHERE login= '".$_SESSION["backend_login"]."'";
        $res= $this->conn->query($sql);
        $reg = $res->fetch_array(MYSQLI_ASSOC);



        //$res=mysql_query($sql,parent::con());
        //$reg=mysql_fetch_assoc($res);
        

        if ($reg['admin']== 1)
        {
            // 1 es igual a accesos usuario administrador
            $sql="SELECT id_usuario FROM acceso WHERE id_empresa= '".$idempresa."'";
            //."' AND id_usuario= '".$reg['id_usuario']."'";
            $res= $this->conn->query($sql);
        }
        elseif($reg['admin']== 0)
        {
            // 0 es igual a accesos usuario NO adminsitrador
            $sql="SELECT id_usuario FROM acceso WHERE id_empresa= '".$idempresa."' AND id_usuario= '".$reg['id_usuario']."'";
            $res= $this->conn->query($sql);
            
        }




        //$res = mysql_query($sql,parent::con());
        
        echo '<option value="0">Seleccione usuario</option>';
        
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $sql="SELECT id_usuario, nombre FROM usuarios WHERE id_usuario= '".$reg['id_usuario']."'";
            $ress= $this->conn->query($sql);
            $regg = $ress->fetch_array(MYSQLI_ASSOC);

            //$ress=mysql_query($sql,parent::con());
            //$regg=mysql_fetch_assoc($ress); 
            echo '<option value="'.$regg['id_usuario'].'">'.$regg['nombre'].'</option>';
            
        }
    }
	
	public function get_tipocomp()
    {
     	$sql="SELECT idtipomov, descripcion FROM tipomov";
		$res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
			$this->form[]=$reg;
        }
        return $this->form;   
 	}

    public function get_tipofondo()
    {
        $sql="SELECT id_tipofondo, nombrefondo FROM tipofondo";
        $res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $this->form[]=$reg;
        }
        return $this->form;   
    }

    public function get_lugarentrega()
    {
        $sql="SELECT id_entr, LEFT(direccion,27) AS direccion FROM lugarentrega";
        $res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $this->form[]=$reg;
        }
        return $this->form;   
    }

    public function get_condpago()
    {
        $sql="SELECT id_cp, condpago FROM condicionpago";
        $res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $this->form[]=$reg;
        }
        return $this->form;   
    }

    public function get_um()
    {
        $sql="SELECT id_um, um FROM um";
        $res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $this->form[]=$reg;
        }
        return $this->form;   
    }

    public function get_tipodocdet()
    {
        $sql="SELECT id_tipodoc, tipodoc FROM tipodoc";
        $res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $this->form[]=$reg;
        }
        return $this->form;   
    }

    public function get_estado()
    {
        $sql="SELECT id_estado, estado FROM estado";
        $res= $this->conn->query($sql);

        //$res=mysql_query($sql,parent::con());
        //while($reg=mysql_fetch_assoc($res))
        while($reg = $res->fetch_array(MYSQLI_ASSOC))
        {
            $this->form[]=$reg;
        }
        return $this->form;   
    }
	
	
}

?>