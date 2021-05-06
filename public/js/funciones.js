/* Desarrollado por Jose Munoz */

$(document).ready(function(){
  
  //Seleccionar USUARIOS al escoger EMPRESA en form HOME****************************************
  $('#empresa').change(function(){
    var id = $("#empresa").val(); 
    $.get("../controller/formularioController.php",{idemp:id})
    .done(function(data){
      $("#usuariosel").html(data);
      $('#usuariosel').attr("disabled", false)
    });
  });
  
  // Seleccionar empresa
  $('#btnSeleccionar').click(function(){
    var verificar = true;
    //var id_empresa = $("#empresa").val();
    var id_empresa = document.getElementById("empresa").value;
    var id_usuariosel = $("#usuariosel").val();
    var mes = $("#mes").val();
    var ano = $("#ano").val();
    

    if(id_empresa == 0)
    {
      alert("El campo Empresa debe ser seleccionado");
      id_empresa.focus();
      verificar = false;
    }
    
    else if(id_usuariosel== 0)
    {
      alert("El campo Usuario es requerido");
      id_usuariosel.focus();
      verificar = false;  
    }
    
    else if(mes == 0)
    {
      alert("El campo Mes debe ser seleccionado");
      mes.focus();
      verificar = false;
    }
    
    else if(ano == 0)
    {
      alert("El campo año debe ser seleccionado");
      ano.focus();
      verificar = false;
    }
 
    /////
    
    if (verificar)
    {

      var data='id_empresa=' + id_empresa + '&id_usuariosel=' + id_usuariosel + '&mes=' + mes + '&ano=' + ano;
    
      $.ajax({ 
        //cache: false,
        type: 'POST',
        dataType: 'json',
        url:'../controller/empresaController.php', 
        data: data,
        success: function(response){
            // si es exitosa la operación
            $('#spnEmpresa').html(response.empresa);
            $('#spnUsuariosel').html(response.usuariosel);
            $('#spnPeriodo').html(response.periodo);
            //location.reload(true);
            //alert("hola");
            //$('#mnuArticulo').html(mnuEArticulo);
            $('#usuariosel').attr("disabled", true)
            
            // definimos lo que queremos hacer en el click primero 
            $("#home2").click(function() { 
                 location.href = this.href; // ir al link 
            });
            // lanzamos la llamada al evento click
            $('#home2').click();

            
        },
        error:function(){
            alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
          }
      });       
    
    }
    
  }); 

  
});
//FIN FUNCTION READY DOCUMENT



//mostrar reloj
  function muestraReloj()
{
// Compruebo si se puede ejecutar el script en el navegador del usuario
if (!document.layers && !document.all && !document.getElementById) return;
// Obtengo la hora actual y la divido en sus partes
var fechacompleta = new Date();
var horas = fechacompleta.getHours();
var minutos = fechacompleta.getMinutes();
var segundos = fechacompleta.getSeconds();
var mt = "AM";
// Pongo el formato 12 horas
if (horas> 12) {
mt = "PM";
horas = horas - 12;
}
if (horas === 0) horas = 12;
// Pongo minutos y segundos con dos digitos
if (minutos <= 9) minutos = "0" + minutos;
if (segundos <= 9) segundos = "0" + segundos;
// En la variable 'cadenareloj' puedes cambiar los colores y el tipo de fuente
//cadenareloj = "<font size='-1' face='verdana'>" + horas + ":" + minutos + ":" + segundos + " " + mt + "</font>";
cadenareloj =horas + ":" + minutos + ":" + segundos + " " + mt;
// Escribo el reloj de una manera u otra, segun el navegador del usuario
if (document.layers) {
document.layers.spanreloj.document.write(cadenareloj);
document.layers.spanreloj.document.close();
}
else if (document.all) spanreloj.innerHTML = cadenareloj;
else if (document.getElementById) document.getElementById("spanreloj").innerHTML = cadenareloj;
// Ejecuto la funcion con un intervalo de un segundo
//setTimeout("muestraReloj()", 1000);
}
//*********************************************************************************
function botones(id,color)
{
    document.getElementById(id).style.backgroundColor=color;
}


//////////////////////////////////////////////////




//*****************************************************************************
function valida_logueo()
{
    var form=document.form;
    if (form.login.value===0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Login est&aacute; vac&iacute;o</font></div>";
        form.login.value="";
        form.login.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    
     if (form.pass.value===0)
    {
        document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>EL Password est&aacute; vac&iacute;o</font></div>";
        form.pass.value="";
        form.pass.focus();
        return false;
    }else
    {
        document.getElementById("valor").innerHTML="";
    }
    //alert("todo ok");
    form.submit();
}

function limpiar()
{
  document.form.reset();
  document.form.id.focus();
}

function guardar()
{
  var form=document.form;
  form.submit();
}
function valida_logueo2()
{
    document.getElementById("valor").innerHTML="<div class='fail large png_bg'><font color='#ff0000'>Todo bien</font></div>";
}
