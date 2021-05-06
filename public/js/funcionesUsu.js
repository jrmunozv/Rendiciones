/* Desarrollado por Jose Munoz */

$(document).ready(function(){
	

    var tableUsu = $('#tableUsu').DataTable();

    var codusu, logusu, nomusu;
	$('#listausuarios').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		codusu = $(this).text();
        		//$('#idart').val(campo1);
        	}

        	if(index2==1)
        	{
        		//campo2 = $(this).text();
        		logusu = $(this).text();
        		//$('#nombreart').val(campo2);
        	}

        	if(index2==2)
        	{
        		//campo2 = $(this).text();
        		nomusu = $(this).text();
        		//$('#nombreart').val(campo2);
        	}

        })
        
	});
    
	$('#btnMaestroUsu').click(function(){
		buscarusu();
		$('#dialogo-maestroUsu').dialog('open');

	});

	$('#dialogo-maestroUsu').dialog({
		title: 'Listado de Usuarios',
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
				$('#id').val(codusu);
				buscar()
				//$('#nombre').val(nomart);
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				limpiarusu();
				$(this).dialog( "close" );
			}
		}
		
	});

	

	//Eliminar ARTICULOS****************************************
	// Mostrar dialogo borrar
	$('#btnBorrarUsu').click(function(){
		$('#dialogo-borrarUsu').dialog('open');
	});
	
	// Diálogo confirmación de eliminación
	$('#dialogo-borrarUsu').dialog({
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
		            url:'../controller/usuariosController.php', 
		            data:'accion=' + accion + "&id=" + id,
		            success: function(response){
		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            		alert(response.mensaje);
		            	}
		            	else
						{							
		            		// si es exitosa la operación
		                	$('#dialogo-borrarUsu').dialog('close');
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
	$('#btnGuardarUsu').click(function(){
		///////////
		var verificar = true;
		var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
		var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
		
		var id= document.getElementById("id").value;
		var log= document.getElementById("log").value;
		var nombre= document.getElementById("nombre").value;
		var correo= document.getElementById("correo").value;
		var password= document.getElementById("password").value;
		var firma= document.getElementById("firma").value;
		var admin= document.getElementById("admin").value;


		if(!log)
		{
			alert("El campo Log es requerido");
			log.focus();
			verificar = false;
		}
		
		else if(!nombre)
		{
			alert("El campo Nombre es requerido");
			nombre.focus();
			verificar = false;	
		}

		else if(!expRegNombre.exec(nombre))
		{
			alert("Debe ingresar un nombre valido");
			nombre.focus();
			verificar = false;	
		}
		
		else if(!correo)
		{
			alert("El campo Correo es requerido");
			correo.focus();
			verificar = false;
		}

		else if(!expRegEmail.exec(correo))
		{
			alert("Debe ingresar un correo valido");
			correo.focus();
			verificar = false;
		}
		
		else if(!password)
		{
			alert("El campo Pass es requerido");
			password.focus();
			verificar = false;
		}

		else if(!firma)
		{
			alert("El campo Firma es requerido");
			firma.focus();
			verificar = false;
		}

		else if(admin == 0)
		{
			alert("El campo Tipo debe ser seleccionado");
			admin.focus();
			verificar = false;	
		}


		/////
		if (verificar)
		{
			var accion= 'guardar';
			var id= document.getElementById("id").value;
			var log= document.getElementById("log").value;
			var nombre= document.getElementById("nombre").value;
			var correo= document.getElementById("correo").value;
			var password= document.getElementById("password").value;
			var firma= document.getElementById("firma").value;
			var admin= document.getElementById("admin").value;
			var data='accion=' + accion + "&id=" + id+ "&log=" + log+ "&nombre=" + nombre+ "&correo=" + correo+ "&password=" + password + "&firma=" + firma+ "&admin=" + admin;
						
			$.ajax({
				beforeSend: function(){
			    	//console.log('eliminando datos de la DB...')
				},
						
				cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/usuariosController.php', 
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
	
	//Recorre ARTICULOS****************************************
	//Recorre-primero
	$('#btnPrimerUsu').click(function(){
		var accion= 'recorre';
		var pos= 'primer';
		var data='accion=' + accion + "&pos="+pos;
		
		$.ajax({ 
			//cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/usuariosController.php', 
			data: data,
			success: function(response){
				// si es exitosa la operación
				$('#id').val(response.id);
				$('#log').val(response.log);
				$('#nombre').val(response.nombre);
				$('#correo').val(response.correo);
				$('#password').val(response.password);
				$('#firma').val(response.firma);
				$('#admin').val(response.admin);
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});								
	});
	
	//Recorre-siguiente
	$('#btnSiguienteUsu').click(function(){
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
				$('#log').val(response.log);
				$('#nombre').val(response.nombre);
				$('#correo').val(response.correo);
				$('#password').val(response.password);
				$('#firma').val(response.firma);
				$('#admin').val(response.admin);
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});
	});
	
	//Recorre-anterior
	$('#btnAnteriorUsu').click(function(){
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
				$('#log').val(response.log);
				$('#nombre').val(response.nombre);
				$('#correo').val(response.correo);
				$('#password').val(response.password);
				$('#firma').val(response.firma);
				$('#admin').val(response.admin);
				
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});
	});
	
	//Recorre-ultimo
	$('#btnUltimoUsu').click(function(){
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
				$('#log').val(response.log);
				$('#nombre').val(response.nombre);
				$('#correo').val(response.correo);
				$('#password').val(response.password);
				$('#firma').val(response.firma);
				$('#admin').val(response.admin);
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});								
	});
	
	//Imprime articulo
	$('#btnImprimirUsu').click(function(){
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
				url:'../controller/usuariosController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					if(response.log == false)
					{
						$('#id').val(null);
						
					}
					else
					{
						$('#log').val(response.log);
						$('#nombre').val(response.nombre);
						$('#correo').val(response.correo);
						$('#password').val(response.password);
						$('#firma').val(response.firma);
						$('#admin').val(response.admin);
					}	
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}

function limpiarusu()
{
	$('#id').val(null);
	$('#log').val(null);
	$('#nombre').val(null);
	$('#correo').val(null);
	$('#password').val(null);
	$('#firma').val(null);
	$('#admin').val(0);	

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
function buscarusu()
{
	$('#tableUsu').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscarusu"
				    }
	        },
	        "columns": [
	        	{ "data": "codigo" },
	        	{ "data": "log" },
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