/* Desarrollado por Jose Munoz */

$(document).ready(function(){
	

    var tableArt = $('#tableArt').DataTable();

    var codart, nomart;
	$('#listaarticulos').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		codart = $(this).text();
        		//$('#idart').val(campo1);
        	}

        	if(index2==1)
        	{
        		//campo2 = $(this).text();
        		nomart = $(this).text();
        		//$('#nombreart').val(campo2);
        	}

        })
        
	});

    
	$('#btnMaestroArt').click(function(){
		buscarart();
		$('#dialogo-maestroArt').dialog('open');

	});

	$('#dialogo-maestroArt').dialog({
		title: 'Listado de Articulos',
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
				$('#id').val(codart);
				buscar()
				//$('#nombre').val(nomart);
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				limpiarart();
				$(this).dialog( "close" );
			}
		}
		
	});

	

	//Eliminar ARTICULOS****************************************
	// Mostrar dialogo borrar
	$('#btnBorrarArt').click(function(){
		$('#dialogo-borrarArt').dialog('open');
	});
	
	// Diálogo confirmación de eliminación
	$('#dialogo-borrarArt').dialog({
		autoOpen: false,
		modal:true,
		width:350,
		height:'auto',
		resizable: false,
		buttons: {
			Si: function() {			
				var id= document.getElementById("id").value;
				var accion= 'eliminar';
				$.ajax({
		        	beforeSend: function(){
		               // console.log('eliminando datos de la DB...')
		            },
					
		            cache: false,
		            type: 'POST',
		            dataType: 'json',
		            url:'../controller/articuloController.php', 
		            data:'accion=' + accion + "&id=" + id,
		            success: function(response){
		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            		alert(response.mensaje);
		            	}
		            	else
						{							
		            		// si es exitosa la operación
		                	$('#dialogo-borrarArt').dialog('close');
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
	
	
	//Guardar ARTICULOS****************************************
	$('#btnGuardarArt').click(function(){
		var accion= 'guardar';
		var id= document.getElementById("id").value;
		var nombre= document.getElementById("nombre").value;
		var um= document.getElementById("um").value;
		var categoria= document.getElementById("categoria").value;
		var cuenta= document.getElementById("cuenta").value;
		var comentario= document.getElementById("comentario").value;
		var data='accion=' + accion + "&id=" + id+ "&nombre=" + nombre+ "&um=" + um+ "&categoria=" + categoria+ "&cuenta=" + cuenta + "&comentario=" + comentario;
					
		$.ajax({
			beforeSend: function(){
		    	//console.log('eliminando datos de la DB...')
			},
					
			cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/articuloController.php', 
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
	});
	
	//Recorre ARTICULOS****************************************
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
	$('#btnImprimirArt').click(function(){
		alert("Se debe generar codigo");
	});

	

	
});
//FIN FUNCTION READY DOCUMENT

function buscar()
{
	var index= document.getElementById("id").value;
	if ($.isNumeric(index)) { 
		$('#id').attr("readonly","readonly");

		var accion= 'buscar';
		var id= document.getElementById("id").value;
		
		if (id=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&id="+id;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/articuloController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
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
		}
	}
}

function limpiarart()
{
	$('#id').val(null);
	$('#nombre').val(null);
	$('#um').val(null);
	$('#categoria').val(null);
	$('#cuenta').val(null);
	$('#comentario').val(null);	

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
    var valor=document.getElementById("id").value;

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
function buscarart()
{
	$('#tableArt').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscarart"
				    }
	        },
	        "columns": [
	        	{ "data": "codigo" },
	        	{ "data": "nombre" },
	        	{ "data": "um" }
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