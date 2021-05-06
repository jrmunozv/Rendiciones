/* Desarrollado por Jose Munoz */

$(document).ready(function(){
	

    var tableAux = $('#tableAux').DataTable();
    //Las variables que se definen a continuación sirven para escoger el campo que se escoge en $('#dialogo-maestroAux').dialog({
    var rutaux, nomaux;
	$('#listaauxiliares').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		rutaux = $(this).text();
        		//$('#idart').val(campo1);
        	}

        	if(index2==1)
        	{
        		//campo2 = $(this).text();
        		nomaux = $(this).text();
        		//$('#nombreart').val(campo2);
        	}

        })
        
	});

    
	$('#btnMaestroAux').click(function(){
		buscaraux();
		$('#dialogo-maestroAux').dialog('open');

	});

	$('#dialogo-maestroAux').dialog({
		title: 'Listado de Auxiliares',
		// Indica si la ventana se abre de forma automática
		autoOpen: false,
		// Indica si la ventana es modal
		modal: true,
		// Largo
		width: 600,
		// Alto
		height: 400,
		draggable: false,
		resizable: false,
		position: [200,100],

		
		// Creamos los botones
		buttons: {
			Aceptar: function() {

				//alert('datas');
				$('#rut').val(rutaux);
				buscar()
				//$('#nombre').val(nomart);
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				limpiaraux();
				$(this).dialog( "close" );
			}
		}
		
	});

	

	//Eliminar ARTICULOS****************************************
	// Mostrar dialogo borrar
	$('#btnBorrarAux').click(function(){
		$('#dialogo-borrarAux').dialog('open');
	});
	
	// Diálogo confirmación de eliminación
	$('#dialogo-borrarAux').dialog({
		autoOpen: false,
		modal:true,
		width:350,
		height:'auto',
		resizable: false,
		buttons: {
			Si: function() {			
				var rut= document.getElementById("rut").value;
				var accion= 'eliminar';
				$.ajax({
		        	beforeSend: function(){
		               // console.log('eliminando datos de la DB...')
		            },
					
		            cache: false,
		            type: 'POST',
		            dataType: 'json',
		            url:'../controller/auxiliarController.php', 
		            data:'accion=' + accion + "&rut=" + rut,
		            success: function(response){
		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            		alert(response.mensaje);
		            	}
		            	else
						{							
		            		// si es exitosa la operación
		                	$('#dialogo-borrarAux').dialog('close');
							var form=document.form;
							form.reset();
						}
		            },
					
		            error:function(){
		                alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
		            }
		        });	
			},
			
			No: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
	
	//Guardar AUXILIAR****************************************
	$('#btnGuardarAux').click(function(){
		var verificar = true;
		var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
		var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
		
		var rut= document.getElementById("rut").value;
		var dv= document.getElementById("dv").value;
		var nombre= document.getElementById("nombre").value;
		var direccion= document.getElementById("direccion").value;
		var comuna= document.getElementById("comuna").value;
		var telefono= document.getElementById("telefono").value;
		var celular= document.getElementById("celular").value;
		var mail= document.getElementById("mail").value;
		var contacto= document.getElementById("contacto").value;
		
		if(!rut)
		{
			alert("El campo rut es requerido");
			rut.focus();
			verificar = false;
		}
		
		else if(!dv)
		{
			alert("El campo digito verificador es requerido");
			dv.focus();
			verificar = false;	
		}

		else if(!nombre)
		{
			alert("El campo nombre es requerido");
			nombre.focus();
			verificar = false;	
		}

		else if(!direccion)
		{
			alert("El campo direccion es requerido");
			direccion.focus();
			verificar = false;	
		}

		else if(!comuna)
		{
			alert("El campo comuna es requerido");
			comuna.focus();
			verificar = false;	
		}

		else if(!telefono)
		{
			alert("El campo telefono es requerido");
			telefono.focus();
			verificar = false;	
		}

		else if(!celular)
		{
			alert("El campo celular es requerido");
			celular.focus();
			verificar = false;	
		}

		else if(!mail)
		{
			alert("El campo mail es requerido");
			mail.focus();
			verificar = false;	
		}

		else if(!expRegEmail.exec(mail))
		{
			alert("Debe ingresar un mail valido");
			mail.focus();
			verificar = false;
		}

		else if(!contacto)
		{
			alert("El campo contacto es requerido");
			contacto.focus();
			verificar = false;	
		}

		if (verificar)
		{
			var accion= 'guardar';
			var rut= document.getElementById("rut").value;
			var dv= document.getElementById("dv").value;
			var nombre= document.getElementById("nombre").value;
			var direccion= document.getElementById("direccion").value;
			var comuna= document.getElementById("comuna").value;
			var telefono= document.getElementById("telefono").value;
			var celular= document.getElementById("celular").value;
			var mail= document.getElementById("mail").value;
			var contacto= document.getElementById("contacto").value;
			var ctacte= document.getElementById("ctacte").value;
			var banco= document.getElementById("banco").value;
			if( $('#estado').prop('checked') ) {
                var estado= 1;
            }
            else
            {
                var estado= 0; 
            }

			var data='accion=' + accion + "&rut=" + rut+ "&dv=" + dv+ "&nombre=" + nombre+ "&direccion=" + direccion + "&comuna=" + comuna+ "&telefono=" + telefono+ "&celular=" + celular+ "&mail=" + mail+ "&contacto=" + contacto+ "&ctacte=" + ctacte+ "&banco=" + banco+ "&estado=" + estado;
						
			$.ajax({
				beforeSend: function(){
			    	//console.log('eliminando datos de la DB...')
				},
						
				cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/auxiliarController.php', 
				data: data,
				success: function(response){
					// Validar mensaje de error
			    	if(response.respuesta == false){
			    		alert(response.mensaje);
			    	}
			    	else
					{							
			    		// si es exitosa la operación
						var form=document.form;
						form.reset();
					}
				},  
			});
		}	
	});
	
	//Recorre AUXILIARES****************************************
	//Recorre-primero
	$('#btnPrimerArt').click(function(){
		var accion= 'recorre';
		var pos= 'primer';
		var data='accion=' + accion + "&pos="+pos;
		
		$.ajax({ 
			//cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/articuloController.php', 
			data: data,
			success: function(response){
				// si es exitosa la operación
				$('#id').val(response.id);
				$('#nombre').val(response.nombre);
				$('#um').val(response.um);
				$('#categoria').val(response.categoria);
				$('#cuenta').val(response.cuenta);
				$('#comentario').val(response.comentario);
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});								
	});
	
	//Recorre-siguiente
	$('#btnSiguienteArt').click(function(){
		var reg= document.getElementById("reg").value;
		var accion= 'recorre';
		var pos= 'siguiente';
		var data='accion=' + accion + "&pos="+pos + "&reg="+reg;
		
		$.ajax({ 
			//cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/articuloController.php', 
			data: data,
			success: function(response){
				// si es exitosa la operación
				$('#id').val(response.id);
				$('#nombre').val(response.nombre);
				$('#um').val(response.um);
				$('#categoria').val(response.categoria);
				$('#cuenta').val(response.cuenta);
				$('#comentario').val(response.comentario);
				$('#reg').val(response.reg);
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});
	});
	
	//Recorre-anterior
	$('#btnAnteriorArt').click(function(){
		var reg= document.getElementById("reg").value;
		var accion= 'recorre';
		var pos= 'anterior';
		var data='accion=' + accion + "&pos="+pos + "&reg="+reg;
		
		$.ajax({ 
			//cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/articuloController.php', 
			data: data,
			success: function(response){
				// si es exitosa la operación
				$('#id').val(response.id);
				$('#nombre').val(response.nombre);
				$('#um').val(response.um);
				$('#categoria').val(response.categoria);
				$('#cuenta').val(response.cuenta);
				$('#comentario').val(response.comentario);
				$('#reg').val(response.reg);
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});
	});
	
	//Recorre-ultimo
	$('#btnUltimoArt').click(function(){
		var accion= 'recorre';
		var pos= 'ultimo';
		var data='accion=' + accion + "&pos="+pos;
		
		$.ajax({ 
			//cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/articuloController.php', 
			data: data,
			success: function(response){
				// si es exitosa la operación
				$('#id').val(response.id);
				$('#nombre').val(response.nombre);
				$('#um').val(response.um);
				$('#categoria').val(response.categoria);
				$('#cuenta').val(response.cuenta);
				$('#comentario').val(response.comentario);
				$('#reg').val(response.reg);
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});								
	});
	
	//Imprime articulo
	$('#btnImprimirAux').click(function(){
		alert("Se debe generar codigo");
	});

	

	
});
//FIN FUNCTION READY DOCUMENT

function buscar()
{
	var index= document.getElementById("rut").value;
	if ($.isNumeric(index)) { 
		$('#rut').attr("readonly","readonly");

		var accion= 'buscar';
		var rut= document.getElementById("rut").value;
		
		if (rut=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&rut="+rut;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/auxiliarController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#dv').val(response.dv);
					$('#nombre').val(response.nombre);
					$('#direccion').val(response.direccion);
					$('#comuna').val(response.comuna);
					$('#telefono').val(response.telefono);
					$('#celular').val(response.celular);
					$('#mail').val(response.mail);
					$('#contacto').val(response.contacto);
					$('#ctacte').val(response.ctacte);
					$('#banco').val(response.banco);
					//$('#estado').val(response.estado);
					if (response.estado == 0)
	                {
	                    $('#estado').removeAttr('checked');
	                }
	                else
	                {
	                    $('#estado').attr('checked', 'checked');
	                }	
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}

function limpiaraux()
{
	$('#rut').val(null);
	$('#dv').val(null);
	$('#nombre').val(null);
	$('#direccion').val(null);
	$('#comuna').val(null);
	$('#telefono').val(null);
	$('#celular').val(null);
	$('#mail').val(null);
	$('#contacto').val(null);
	$('#ctacte').val(null);
	$('#banco').val(null);
	$('#estado').removeAttr('checked');

}

/**
 * Función que solo permite la entrada de numeros, un signo negativo y
 * un punto para separar los decimales
 */
function soloNumeros(e)
{
    // capturamos la tecla pulsada
    var teclaPulsada=window.event ? window.event.keyCode:e.which;
    // capturamos el contenido del input
    var valor=document.getElementById("rut").value;

    if(valor.length<10)
    {
        // 13 = tecla enter
        // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
        // punto
        if(teclaPulsada==13)
        {
            return true;
        }

        // devolvemos true o false dependiendo de si es numerico o no
        return /\d/.test(String.fromCharCode(teclaPulsada));
    }else{
        return false;
    }
}
function buscaraux()
{
	$('#tableAux').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscaraux"
				    }
	        },
	        "columns": [
	        	{ "data": "rut" },
	        	{ "data": "nombre" }
	        ],

	        dom: 'T<"clear">lfrtip',
	        tableTools: {
	            "sRowSelect": "single",
	        },
	        //dom: 'Bfrtip',
	        buttons: [
	            'copy', 'csv', 'excel', 'pdf', 'print'
	        ]

	})

}