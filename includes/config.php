<?php
session_start();
class Conexion
{ 
  /*
  private $server= 'localhost';
  private $user= 'root';
  private $pass= 'gestion2010';
  private $maindb= 'existencias';
  private $charset= 'utf-8';
  */
  
  protected $conn;

  public function __construct()
  {
      require_once "conexion.php";
      
      //$this->conn = new mysqli($this->server, $this->user, $this->pass, $this->maindb);
      $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      if ( $this->conn->connect_errno )
      {
          echo "Fallo al conectar a MySQL: ". $this->conn->connect_error;
          return;    
      }
      
      //$this->conn->set_charset('utf-8');
      $this->conn->set_charset(DB_CHARSET);
  } 
  
  
  protected function comillas_inteligentes($valor)
  {
      // Retirar las barras
      if (get_magic_quotes_gpc()) {
          $valor = stripslashes($valor);
      }
  
      // Colocar comillas si no es entero
      if (!is_numeric($valor)) {
          $valor = "'" . $this->conn->real_escape_string($valor) . "'";
      }
      return $valor;
  }
    
  public static function ruta()
  {
      require_once "conexion.php";
      //return "http://localhost/existencia2/";
      return RUTA;
  }

  //función para la fecha
  public static function fecha()
  {
      $dia=date("w");
      $day=date("d");
      $mes=date("m");
      
      switch ($dia)
      {
        case 0:
        $dia ="Domingo";
        break;

        case 1:
        $dia = "Lunes";
        break;

        case 2:
        $dia ="Martes";
        break;

        case 3:
        $dia ="Miércoles";
        break;

        case 4:
        $dia ="Jueves";
        break;

        case 5:
        $dia ="Viernes";
        break;

        case 6:
        $dia ="Sábado";
        break;

      }

      switch ($mes)
      {
        case '01':
        $mes="Enero";
        break;

        case '02':
        $mes="Febrero";
        break;

        case '03':
        $mes="Marzo";
        break;

        case '04':
        $mes="Abril";
        break;

        case '05':
        $mes="Mayo";
        break;

        case '06':
        $mes="Junio";
        break;

        case '07':
        $mes="Julio";
        break;

        case '08':
        $mes="Agosto";
        break;

        case '09':
        $mes="Septiembre";
        break;

        case '10':
        $mes="Octubre";
        break;

        case '11':
        $mes="Noviembre";
        break;

        case '12':
        $mes="Diciembre";
        break;
      }
      
      $fecha="$dia ".$day." de ".$mes." de ".date("Y");
      return $fecha; 
  }
}





class Conectar 
{
   protected function con()
    {
        $con=mysql_connect('localhost','root','gestion2010');
        mysql_query("SET NAMES 'utf8'");
        mysql_select_db("existencias");
        return $con;  
    }
    protected function comillas_inteligentes($valor)
    {
        // Retirar las barras
        if (get_magic_quotes_gpc()) {
            $valor = stripslashes($valor);
        }
    
        // Colocar comillas si no es entero
        if (!is_numeric($valor)) {
            $valor = "'" . mysql_real_escape_string($valor) . "'";
        }
        return $valor;
    }
    public static function ruta()
    {
        require_once "conexion.php";
        //return "http://localhost/existencia2/";
        return RUTA;
    }
    //*******************************************************************************************************************************************************
  //función para la fecha
  public static function fecha(){
  	$dia=date("w");
  	$day=date("d");
  	$mes=date("m");
  switch ($dia) {
  	case 0:
     	$dia ="Domingo";
  	break;

    case 1:
    $dia = "Lunes";
  	break;
  	case 2:
    $dia ="Martes";

            break;

    case 3:
    $dia ="Miércoles";

            break;
    case 4:
    	$dia ="Jueves";
      break;
    case 5:
    $dia ="Viernes";
  	break;
    case 6:
    $dia ="Sábado";
  	break;

  }
  switch ($mes){
  	case '01':
  	$mes="Enero";
  	break;
  	case '02':
  	$mes="Febrero";
  	break;
  	case '03':
  	$mes="Marzo";
  	break;
  	case '04':
  	$mes="Abril";
  	break;
  	case '05':
  	$mes="Mayo";
  	break;
  	case '06':
  	$mes="Junio";
  	break;
  	case '07':
  	$mes="Julio";
  	break;
  	case '08':
  	$mes="Agosto";
  	break;
  	case '09':
  	$mes="Septiembre";
  	break;
  	case '10':
  	$mes="Octubre";
  	break;
  	case '11':
  	$mes="Noviembre";
  	break;
  	case '12':
  	$mes="Diciembre";
  	break;
  }
  $fecha="$dia ".$day." de ".$mes." de ".date("Y");
  return $fecha; 
  }
  	public static function valida_correo($email){
      $mail_correcto = 0;
      //compruebo unas cosas primeras
      if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
         if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
            //miro si tiene caracter .
            if (substr_count($email,".")>= 1){
               //obtengo la terminacion del dominio
               $term_dom = substr(strrchr ($email, '.'),1);
               //compruebo que la terminaci?n del dominio sea correcta
               if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                  //compruebo que lo de antes del dominio sea correcto
                  $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                  $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                  if ($caracter_ult != "@" && $caracter_ult != "."){
                     $mail_correcto = 1;
                  }
               }
            }
         }
      }
      if ($mail_correcto)
         return true;
      else
         return false;
  } 
}






?>
