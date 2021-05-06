/* Desarrollado por Jose Munoz */

$(document).ready(function(){
	
	hoyFecha();
	buscarDatosUsuarioSel();
	$('#show2').hide();
	$('#show3').hide();
    $('#pestaña1').css({'background-color': 'rgba(102, 64, 131, 0.86)'});
	$('#pestaña1').css({'font-weight': 'bold'});
	$('#pestaña2').css({'color': '#CCC'});
	$('#pestaña3').css({'color': '#CCC'});
    
    $('#archivo').attr("disabled", true);


    $('#tipofondo').change(function(){
	    var idfondo = $("#tipofondo").val();
	    var accion = "verfondo";
	    var data='accion=' + accion + "&idfondo="+idfondo;
		
		$.ajax({ 
			//cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/rendicionesController.php', 
			data: data,
			success: function(response){
				// si es exitosa la operación
				if (response.tipfondo == 1)
		    	{
					$('#fondoasign').val(response.fondoasign);
					$('#fondoasign').attr("readonly","readonly");
				}
				else
				{
					$('#fondoasign').val(response.fondoasign);
					$('#fondoasign').removeAttr("readonly");
				}


			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}
		});		


	});
        /*Ajustamos el tamaño de los diferentes elementos*/
        /*$('#show1').css({ //accesamos a todos los elementos div del documento
            'height': ($(document).outerHeight(true) - 160  ) //la altura del documento - 60px de la barra - los margenes
        });
    
        $('#show2').css({ //accesamos a todos los elementos div del documento
            'height': ($(document).outerHeight(true) - 160  ) //la altura del documento - 60px de la barra - los margenes
        });
    
        /*************************************************/
        
        $('#pestaña1').click(function(){
            $('#show2').fadeOut(function(){
                $('#pestaña2').css({'background-color': '#6ad5f5'}); //inhabilita color
                $('#pestaña1').css({'font-weight': 'bold'}); //habilita color
				$('#pestaña2').css({'font-weight': 'normal'}); //inhabilita
                $('#show1').fadeIn(); //habilita
                $('#pestaña1').css({'color': '#000000'}); //habilita
				$('#pestaña2').css({'color': '#CCC'}); //inhabilita
				//buscarDatosUsuarioSel();	
            });

            $('#show3').fadeOut(function(){
                $('#pestaña3').css({'background-color': '#6ad5f5'}); //inhabilita color
                //$('#pestaña1').css({'font-weight': 'bold'}); //habilita color
				$('#pestaña3').css({'font-weight': 'normal'}); //inhabilita
                //$('#show1').fadeIn(); //habilita
                //$('#pestaña1').css({'color': '#000000'}); //habilita
				$('#pestaña3').css({'color': '#CCC'}); //inhabilita
				//buscarDatosUsuarioSel();	
            });     
        });
    	

    	
		$('#pestaña2').click(function(){	    
		    var folio = document.getElementById("folio").value;
		    if (folio == "")
		    {

		     /*	$('#show1').fadeOut(function() {
					            $('#pestaña1').css({'background-color': '#6ad5f5'});
					            $('#show2').fadeIn();
					            $('#pestaña2').css({'font-weight': 'bold'});
								$('#pestaña1').css({'font-weight': 'normal'});
								$('#pestaña2').css({'color': '#000000'});
								$('#pestaña1').css({'color': '#CCC'});
					        });
			*/
		    }
		    else
		    {		        
		    	var accion= 'buscar';				
				var data='accion=' + accion + "&folio="+folio;
			
				$.ajax({ 
					//cache: false,
					type: 'POST',
					dataType: 'json',
					url:'../controller/rendicionesController.php', 
					data: data,
					success: function(response){
						if(!response.fecha)
						{	
				        }
				        else
						{							
				        	$('#show1').fadeOut(function() {
					            $('#pestaña1').css({'background-color': '#6ad5f5'});
					            $('#show2').fadeIn();
					            $('#pestaña2').css({'font-weight': 'bold'});
								$('#pestaña1').css({'font-weight': 'normal'});
								$('#pestaña2').css({'color': '#000000'});
								$('#pestaña1').css({'color': '#CCC'});
					        });

					        $('#show3').fadeOut(function() {
					            $('#pestaña3').css({'background-color': '#6ad5f5'});
					            //$('#show2').fadeIn();
					            $('#pestaña3').css({'font-weight': 'bold'});
								//$('#pestaña1').css({'font-weight': 'normal'});
								//$('#pestaña2').css({'color': '#000000'});
								$('#pestaña3').css({'color': '#CCC'});
					        });

					        cargargridrend();
				            
						}
							
					},
					error:function(){
						alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
					}
				});				
				   
			}

        });
        

        $('#pestaña3').click(function(){
            var folio = document.getElementById("folio").value;
		    if (folio == "")
		    {

		     /*	$('#show1').fadeOut(function() {
					            $('#pestaña1').css({'background-color': '#6ad5f5'});
					            $('#show2').fadeIn();
					            $('#pestaña2').css({'font-weight': 'bold'});
								$('#pestaña1').css({'font-weight': 'normal'});
								$('#pestaña2').css({'color': '#000000'});
								$('#pestaña1').css({'color': '#CCC'});
					        });
			*/
		    }
		    else
		    {		        
		    	var accion= 'buscar';				
				var data='accion=' + accion + "&folio="+folio;
			
				$.ajax({ 
					//cache: false,
					type: 'POST',
					dataType: 'json',
					url:'../controller/rendicionesController.php', 
					data: data,
					success: function(response){
						if(!response.fecha)
						{	
				        }
				        else
						{
				            $('#show1').fadeOut(function(){
				                $('#pestaña1').css({'background-color': '#6ad5f5'}); //inhabilita color
				                $('#pestaña3').css({'font-weight': 'bold'}); //habilita color
								$('#pestaña1').css({'font-weight': 'normal'}); //inhabilita
				                $('#show3').fadeIn(); //habilita
				                $('#pestaña3').css({'color': '#000000'}); //habilita
								$('#pestaña1').css({'color': '#CCC'}); //inhabilita
								//buscarDatosUsuarioSel();
				            });

				            $('#show2').fadeOut(function(){
				                $('#pestaña2').css({'background-color': '#6ad5f5'}); //inhabilita color
				                //$('#pestaña3').css({'font-weight': 'bold'}); //habilita color
								$('#pestaña2').css({'font-weight': 'normal'}); //inhabilita
				                //$('#show3').fadeIn(); //habilita
				                //$('#pestaña3').css({'color': '#000000'}); //habilita
								$('#pestaña2').css({'color': '#CCC'}); //inhabilita
								//buscarDatosUsuarioSel();
				            });

				            cargargridarch();

				        }
							
					},
					error:function(){
						alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
					}
				});			
			}
        });
	
	///////////////////////////////////////////////////////////////////////////////
//FUNCIONES RELACIONADAS CON PAGINA COMPROBANTE
	
	//IMprime comprobante
	$('#btnImprimirRend').click(function(){
		//alert("Se debe generar codigo para guardar");
		var folio= document.getElementById("folio").value;
		if(!folio)
		{
		}
		else
		{
			window.open('../model/imprrendModel.php/?folio='+folio);
		}
		
	});


	// Mostrar dialogo maestro de registros
	//$('#table').DataTable();
	//var table = $('#table').DataTable();
 	
 	/*
    var tablaDet = $('#tablaDet').DataTable({
        "destroy": true,
        "pageLength": 5,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
        },
        //dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
	
	*/
	var tablaDet = $('#tablaDet').DataTable();
	var tableComp = $('#tableComp').DataTable();

/*
   $('#tablaDet tbody').on('click', 'tr', function () {
        var datas = tablaDet.row( this ).data();
        //alert( 'You clicked on '+datas[0]+'\'s row' );
        var lintabla = datas[0];
        $('#lin').val(lintabla);
        var idtabla = datas[1];
        $('#idart').val(idtabla);
        var nomtabla = datas[2];
        $('#nombreart').val(nomtabla);
        var entrtabla = datas[3];
        $('#entradaart').val(entrtabla);
        var saltabla = datas[4];
        $('#salidaart').val(saltabla);
        var centtabla = datas[5];
        $('#centroart').val(centtabla);
        var cuentabla = datas[6];
        $('#cuentaart').val(cuentabla);
    });


*/

	$('#btnBorrarCompDetFunciona').click(function(){
		//alert('BIEN');
		var idcomp= document.getElementById("idcomp").value;
		var accion= 'cargar';
		$.ajax({
			type:'POST',//TIPO DE PETICION PUEDE SER GET
			dataType:"json",//EL TIPO DE DATO QUE DEVUELVE PUEDE SER JSON/TEXT/HTML/XML
			url:"../controller/tablasController.php",//DIRECCION DONDE SE ENCUENTRA LA OPERACION A REALIZAR
			data:'accion=' + accion + "&idcomp=" + idcomp,//DATOS ENVIADOS PUEDE SER TEXT A TRAVEZ DE LA URL O PUEDE SER UN OBJETO
			beforeSend: function(){//ACCION QUE SUCEDE ANTES DE HACER EL SUBMIT
				//$('#loader').show();//MOSTRAMOS EL DIV LOADER EL CUAL CONTIENE LA IMAGEN DE CARGA
				//alert(data);
			},
			success: function(response){//ACCION QUE SUCEDE DESPUES DE REALIZAR CORRECTAMENTE LA PETCION EL CUAL NOS TRAE UNA RESPUESTA
				if(response.respuesta=="DONE"){//MANDAMOS EL MENSAJE QUE NOS DEVUELVE EL RESPONSE
					$("#listausuarios").html(response.contenido);//cargo los registros que devuelve ajax
					//$('#div-frm').dialog('close');//CERRAMOS EL FORM
					//$('#loader').hide();//OCULTAMOS EL LOADER
										
				}
				else{
					alert("Ocurrio un error al ejecutar la operacion, intentelo de nuevo");
					//$('#loader').hide();	
				}
				
				
			},
			error: function(){//SI OCURRE UN ERROR 
				alert('El servicio no esta disponible intentelo mas tarde');//MENSAJE EN CASO DE ERROR
				//$('#loader').hide();//OCULTAMOS EL DIV LOADER
			}
		});
		return false;//RETORNAMOS FALSE PARA QUE NO HAGA UN RELOAD EN LA PAGINA
	
	});

	

	$('#listadetrend').on('click', 'tr', function (){
		
	//	var celda = $(this).children("td");
     //   $('#lin').val(celda.html());
      //  alert(celda.html());

      	var campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8, campo9;
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		campo1 = $(this).text();
        		$('#iddetrend').val(campo1);
        	}

        	if(index2==1)
        	{
        		campo2 = $(this).text();
        		$('#fechadet').val(campo2);
        	}

        	if(index2==2)
        	{
        		campo3 = $(this).text();
        		$('#rutdet').val(campo3);
        	}

        	if(index2==3)
        	{
        		campo4 = $(this).text();
        		$('#proveedordet').val(campo4);
        	}

        	if(index2==4)
        	{
        		campo5 = $(this).text();
        		campo5 = campo5.replace('.', '');
        		$('#montodet').val(campo5);
        	}

        	if(index2==5)
        	{
        		campo6 = $(this).text();
        		$('#tipodocdetalle').val(campo6);
        	}

        	if(index2==6)
        	{
        		campo7 = $(this).text();
        		$('#nrodocdet').val(campo7);
        	}

        	if(index2==7)
        	{
        		campo8 = $(this).text();
        		$('#conceptodet').val(campo8);
        	}

        	if(index2==8)
        	{
        		campo9 = $(this).text();
        		$('#matrizdet').val(campo9);
        	}
        })
        //alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
		/*
		$("#tablaDet tbody tr").each(function (index) 
        {
            var campo1, campo2, campo3;
            $(this).children("td").each(function (index2) 
            {
                switch (index2) 
                {
                    case 0: campo1 = $(this).text();
                            break;
                    case 1: campo2 = $(this).text();
                            break;
                    case 2: campo3 = $(this).text();
                            break;
                }
                $(this).css("background-color", "#ECF8E0");
            })
            alert(campo1 + ' - ' + campo2 + ' - ' + campo3);
        })
		*/
	});


	$('#listadetarch').on('click', 'tr', function (){
      	var campo1, campo2, campo3;
        $(this).children("td").each(function (index2) 
        {         
        	if(index2==0)
        	{
        		campo1 = $(this).text();
        		$('#iddetarch').val(campo1);
        	}

        	if(index2==1)
        	{
        		campo2 = $(this).text();
        		$('#archivodetarch').val(campo2);
        	}

        	if(index2==2)
        	{
        		campo3 = $(this).text();
        		$('#nuevoarchivo').val(campo3);
        	}
        })

        descargarArchivoRend();
	});



   $('#btnMaestroRend').click(function(){
   		buscarRend();
		$('#dialogo-maestroRend').dialog('open');

	});

	$('#dialogo-maestroRend').dialog({
		title: 'Listado de Rendiciones',
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
				$('#folio').val(codrend);
				buscarEncRend();
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				limpiarrend();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codrend;
	$('#listaencrend').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		codrend = $(this).text();
        		//$('#idart').val(campo1);
        	}
        })
        
	});


	$('#btnMaestroAux').click(function(){
   		buscarAux();
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
				$('#rutdet').val(codaux);
				buscarEncAux();
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				//limpiaroc();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codaux;
	$('#listaencaux').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		codaux = $(this).text();
        		//$('#idart').val(campo1);
        	}
        })
        
	});


$('#btnMatriz').click(function(){
   		buscarMatriz();
		$('#dialogo-maestroMatriz').dialog('open');

	});

	$('#dialogo-maestroMatriz').dialog({
		title: 'Listado de Matriz de gastos',
		// Indica si la ventana se abre de forma automática
		autoOpen: false,
		// Indica si la ventana es modal
		modal: true,
		// Largo
		width: 800,
		// Alto
		height: 400,
		draggable: false,
		resizable: false,
		position: [200,100],

		
		// Creamos los botones
		buttons: {
			Aceptar: function() {

				//alert('datas');
				$('#matrizdet').val(codmatriz);
				//buscarEncMatriz();
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				//limpiaroc();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codmatriz;
	$('#listaencmatriz').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==1)
        	{
        		//campo1 = $(this).text();
        		codmatriz = $(this).text();
        		//$('#idart').val(campo1);
        	}
        })
        
	});

	$('#btnMaestroCentro').click(function(){
   		buscarCentro();
		$('#dialogo-maestroCentro').dialog('open');

	});

	$('#dialogo-maestroCentro').dialog({
		title: 'Listado de Centros contables',
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
				$('#centrocosto').val(codcentro);
				buscarEncCentro();
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				//limpiaroc();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codcentro;
	$('#listaenccentro').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		codcentro = $(this).text();
        		//$('#idart').val(campo1);
        	}
        })
        
	});




	$('#btnMaestroArt').click(function(){
		if( $('#tipoart').prop('checked') ) {	   
			buscarart();
			$('#dialogo-maestroArt').dialog('open');
		}

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
				$('#idart').val(codart);
				$('#detalle').val(nomart);
				$('#detalle').val(nomart);
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				//limpiarcomp();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codart, nomart; //um;
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

        	if(index2==2)
        	{
        		//campo2 = $(this).text();
        		nomart = $(this).text();
        		//$('#nombreart').val(campo2);
        	}

        })
        
	});

	// Diálogo nuevo auxiliar
	$('#dialogo-nuevoAux').dialog({
		autoOpen: false,
		modal:true,
		width:350,
		height:'auto',
		resizable: false,
		buttons: {
			Si: function() {			
				//var rut = 12;
				$('#rutaux').val("");
				$('#nombreaux').val("");
				$( this ).dialog( "close" );
				var url = 'http://localhost/ocompras/auxiliar/';
				abrirEnPestana(url);
				//$('#rut').val(rut);
					
			},
			
			No: function() {
				$('#rutaux').val("");
				$('#nombreaux').val("");
				$( this ).dialog( "close" );
			}
		}
	});

	// Diálogo sin folios OC
	$('#dialogo-folioFolio').dialog({
		autoOpen: false,
		modal:true,
		width:350,
		height:'auto',
		resizable: false,
		buttons: {
			Ok: function() {			
				$( this ).dialog( "close" );	
			},
		}
	});

//Eliminar COMPROBANTES****************************************
	//Eliminar COMPROBANTE****************************************
	// Mostrar dialogo borrar
	$('#btnBorrarComp').click(function(){
		$('#dialogo-borrarComp').dialog('open');
	});
	
	// Diálogo confirmación de eliminación
	$('#dialogo-borrarComp').dialog({
		autoOpen: false,
		modal:true,
		width:350,
		height:'auto',
		resizable: false,
		buttons: {
			Si: function() {			
				var idcomp= document.getElementById("idcomp").value;
				var fecha= document.getElementById("fecha").value;
				var accion= 'eliminarcomp';
				$.ajax({
		        	beforeSend: function(){
		               // console.log('eliminando datos de la DB...')
		            },
					
		            cache: false,
		            type: 'POST',
		            dataType: 'json',
		            url:'../controller/comprobanteController.php', 
		            data:'accion=' + accion + "&idcomp=" + idcomp + "&fecha=" + fecha,
		            success: function(response){
		            	// Validar mensaje de error
		            	if(response.respuesta == false){
		            		alert(response.mensaje);
		            	}
		            	else
						{							
		            		// si es exitosa la operación
		                	$('#dialogo-borrarComp').dialog('close');
							var form=document.form;
							form.reset();
							$('#idcomp').removeAttr("readonly");
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
	

	//Guardar RENDICIONES****************************************
	//
	$('#btnGuardarRend').click(function(){
		///////////
		var verificar = true;
		var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
		var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
		
		

		//var nrooc= document.getElementById("nrooc").value;
		//var formulario = document.getElementById("form").value;
		var estado = document.getElementById("estado").value;
		var archivo = document.getElementById("archivo").value;
		var tipofondo = document.getElementById("tipofondo").value;
		var fondoasign = document.getElementById("fondoasign").value;
		

		//hoyFecha();

		//revisafoliorend();
		
		if(archivo == 0)
		{
			alert("El campo Subir archivo debe ser seleccionado");
			archivo.focus();
			verificar = false;
		}
		
		else if(estado == 0)
		{
			alert("El campo Estado debe ser seleccionado");
			estado.focus();
			verificar = false;	
		}
		
		else if(tipofondo == 0)
		{
			alert("El campo Tipo de Fondo debe ser seleccionado");
			tipofondo.focus();
			verificar = false;
		}
		
		else if(!fondoasign && tipofondo == 2)
		{
			alert("El campo Fondo asignado es requerido");
			fondoasign.focus();
			verificar = false;
		}

		else if(fondoasign == 'No tiene')
		{
			alert("No tiene fondo fijo asignado. Contacte al administrador.");
			fondoasign.focus();
			verificar = false;
		}

		
		
		/////
		
		if (verificar)
		{
			var accion= 'guardarrend';
			var folio= document.getElementById("folio").value;
			var fecha= document.getElementById("fecha").value;
			var estado= document.getElementById("estado").value;
			var archivo= document.getElementById("archivo").value;
			var tipofondo= document.getElementById("tipofondo").value;
			var fondoasign= document.getElementById("fondoasign").value;
			var banco= document.getElementById("banco").value;
			var tipocuenta= document.getElementById("tipocuenta").value;
			var nrocuenta= document.getElementById("nrocuenta").value;
			var observacion= document.getElementById("observacion").value;
			
			fondoasign = fondoasign.replace(".","");


			var data='accion=' + accion + "&folio=" + folio+ "&fecha=" +
			fecha+ "&estado=" + estado+ "&archivo=" + archivo+
			"&tipofondo=" + tipofondo + "&fondoasign=" + fondoasign+ "&banco=" + 
			banco+ "&tipocuenta=" + tipocuenta+ "&nrocuenta=" + nrocuenta+ "&observacion=" +
			observacion;
						
			$.ajax({
				beforeSend: function(){
			    	//console.log('eliminando datos de la DB...')
			    	$('#btnGuardarRend').attr("disabled", true); //Este es un ejemplo. Revisar si funciona para que no se envíe dos veces un form
				},
						
				cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					// Validar mensaje de error
			    	if(response.respuesta == false){
			    		alert(response.mensaje);
			    	}
			    	else
					{							
			    		// si es exitosa la operación
						//var form=document.form;
						//form.reset();
						//$('#nrooc').removeAttr("readonly");
						//$('#idcomp').css({'background-color': 'rgba(238, 238, 238, 0)'});
						$('#folio').val(response.folio);
						$('#folio').attr("readonly","readonly");
						$('#show1').fadeOut(function() {
			                $('#pestaña1').css({'background-color': '#6ad5f5'});
			                $('#show2').fadeIn();
			                $('#pestaña2').css({'font-weight': 'bold'});
							$('#pestaña1').css({'font-weight': 'normal'});
							$('#pestaña2').css({'color': '#000000'});
							$('#pestaña1').css({'color': '#CCC'});
							$('#btnGuardarRend').attr("disabled", false); //Este es un ejemplo. Revisar si funciona para que no se envíe dos veces un form
			            });

			            cargargridrend();
					}
				},  
			});

		}		
	});
	//*/

	


//Guardar DETALLE RENDICIONES****************************************
	//

	$('#btnGuardarRendDet').click(function(){
		///////////
		var verificar = true;
		var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
		var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
		
		//var formulario = document.getElementById("form");
		var fechadet = document.getElementById("fechadet").value;
		var rutdet = document.getElementById("rutdet").value;
		var montodet = document.getElementById("montodet").value;
		var tipodocdet = document.getElementById("tipodocdetalle").value;
		var nrodocdet = document.getElementById("nrodocdet").value;
		var conceptodet = document.getElementById("conceptodet").value;
		var matrizdet = document.getElementById("matrizdet").value;
		
		if(!fechadet)
		{
			alert("La fecha es requerida.");
			fechadet.focus();
			verificar = false;
		}
		
		//else if(!expRegNombre.exec(nombre.value))
		//else if(!detalle.value && !salidaart.value)
		else if(!rutdet)
		{
			alert("El campo rut debe ser seleccionado.");
			rutdet.focus();
			verificar = false;	
		}
		
		else if(montodet == 0)
		{
			alert("El campo monto es requerido");
			montodet.focus();
			verificar = false;
		}

		else if(tipodocdet == 0)
		{
			alert("El campo tipo documento es requerido");
			tipodocdet.focus();
			verificar = false;
		}
		
		else if(nrodocdet == 0)
		{
			alert("El campo numero de documento es requerido");
			nrodocdet.focus();
			verificar = false;
		}
		
		else if(!conceptodet)
		{
			alert("El campo concepto es requerido");
			conceptodet.focus();
			verificar = false;
		}

		else if(!matrizdet)
		{
			alert("El campo matriz es requerido");
			matrizdet.focus();
			verificar = false;
		}

		/////
		if (verificar)
		{
			

			var accion= 'guardarrenddet';
			var folio= document.getElementById("folio").value;
			var iddetrend= document.getElementById("iddetrend").value;
			var fechadet = document.getElementById("fechadet").value;
			var rutdet = document.getElementById("rutdet").value;
			var montodet = document.getElementById("montodet").value;
			var tipodocdet = document.getElementById("tipodocdetalle").value;
			var nrodocdet = document.getElementById("nrodocdet").value;
			var conceptodet = document.getElementById("conceptodet").value;
			var matrizdet = document.getElementById("matrizdet").value;
			var fecha = document.getElementById("fecha").value;

			
			var data='accion=' + accion + "&folio=" + folio+ "&iddetrend=" +
			iddetrend+ "&fechadet=" + fechadet+ "&rutdet=" + rutdet + "&montodet=" +
			montodet+ "&tipodocdet=" + tipodocdet+ "&nrodocdet=" +
			nrodocdet+ "&conceptodet=" + conceptodet+ "&matrizdet=" + matrizdet+ "&fecha=" + fecha;
						
			$.ajax({
				beforeSend: function(){
			    	//console.log('eliminando datos de la DB...')
				},
						
				cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					// Validar mensaje de error
			    	if(response.respuesta == false){
			    		alert(response.mensaje);
			    	}
			    	else
					{							
			    		limpiarrenddet();
			    		cargargridrend();
			    		// si es exitosa la operación
						//var form=document.form;
						//form.reset();
					}
				},  
			});
		}
		
	});



	//Descargar ARCHIVOS****************************************
	//
	$('#btnDescargarRendArchRESERVA').click(function(){
		

	});
	//*/


	//Guardar ARCHIVOS****************************************
	//
	$('#btnGuardarRendArch').click(function(){
		///////////
		var verificar = true;
		var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
		var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
		
		var archivo = document.getElementById("subirarchivo").value;

		$('#archivodetarch').val(archivo);

		if(archivo == "")
		{
			$('#nuevoarchivo').val(null);
			alert("Debe seleccionar un archivo");
			archivo.focus();
			verificar = false;
		}
		
		else if(archivo == 0)
		{
			archivo.focus();
			verificar = false;	
		}
		
		
		
		/////
		
		if (verificar)
		{
			var accion= 'guardarrendarch';
			var folio= document.getElementById("folio").value;
			var iddetarch= document.getElementById("iddetarch").value;
			var archivo= document.getElementById("subirarchivo").value;
			var fecha= document.getElementById("fecha").value;

            var formData = new FormData();
        	//var files = $('#subirarchivo')[0].files[0];
        	var files =$("#subirarchivo").prop("files")[0];
 
        	formData.append('file',files);
        	formData.append('accion',accion);
        	formData.append('folio',folio);
        	formData.append('iddetarch',iddetarch);
        	formData.append('archivo',archivo);
        	formData.append('fecha',fecha);

			//alert(formData);
            $.ajax({
                url:'../controller/rendicionesController.php',
                type: "post",
                dataType: "text",
                data: formData,
                cache: false,
                contentType: false,
	     		processData: false,
	     		success: function(data) {
	                if (data == 0) {
	                	limpiarrendarch();
			    		cargargridarch();
	                    alert('Archivo subido exitosamente.');               
	                }
	                else
	                {
	                    var mens= 'Hay un problema. El archivo no se subio. Datos: ' + data;
	                    //alert('Hay un problema. El archivo no se subio.');
						//alert(data);
						alert(mens);
					}
            	}	
            });
		


		}		
	});
	//*/



	//*/
	$('#btnNuevoRegRendDet').click(function(){
		limpiarrenddet();
	});


	$('#btnBorrarRendDet').click(function(){
		var iddetrend= document.getElementById("iddetrend").value;
		var fecha= document.getElementById("fecha").value;
		if (iddetrend == '')
		{	
		}
		else
		{
			var accion= 'eliminarrenddet';
			$.ajax({
				beforeSend: function(){
			    // console.log('eliminando datos de la DB...')
			    },
						
			    cache: false,
			    type: 'POST',
			    dataType: 'json',
			    url:'../controller/rendicionesController.php', 
			    data:'accion=' + accion + '&iddetrend=' + iddetrend + '&fecha=' + fecha,
			    success: function(response){
			    	// Validar mensaje de error
			    	if(response.respuesta == false){
			        	alert(response.mensaje);
			        }
			        else
					{							
			        	// si es exitosa la operación
			        	limpiarrenddet();
				    	cargargridrend();
			            
					}
			    },
						
			    error:function(){
			        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			    }
			});
		}
	});


	//*/
	$('#btnNuevoRegRendArch').click(function(){
		limpiarrendarch();
	});

	$('#btnBorrarRendArch').click(function(){
		var iddetarch= document.getElementById("iddetarch").value;
		var fecha= document.getElementById("fecha").value;
		if (iddetarch == '')
		{	
		}
		else
		{
			var accion= 'eliminarrendarch';
			$.ajax({
				beforeSend: function(){
			    // console.log('eliminando datos de la DB...')
			    },
						
			    cache: false,
			    type: 'POST',
			    dataType: 'json',
			    url:'../controller/rendicionesController.php', 
			    data:'accion=' + accion + "&iddetarch=" + iddetarch + '&fecha=' + fecha,
			    success: function(response){
			    	// Validar mensaje de error
			    	if(response.respuesta == false){
			        	alert(response.mensaje);
			        }
			        else
					{							
			        	// si es exitosa la operación
			        	limpiarrendarch();
				    	cargargridarch();
			            
					}
			    },
						
			    error:function(){
			        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			    }
			});
		}
	});



$("#fondoasign").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value ) {
            return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{0})$/, '$1')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ".");
        });
    }
});
	

});
//FIN FUNCTION READY DOCUMENT

















function abrirEnPestana(url) {
	var a = document.createElement("a");
	a.target = "_blank";
	a.href = url;
	a.click();
}

function acceptNum(evt){  
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57  
	var key=window.event ? window.event.keyCode:e.which;
	// capturamos la tecla pulsada
        //var teclaPulsada=window.event ? window.event.keyCode:e.which;
        // capturamos el contenido del input
        //var key=document.getElementById("rut").value;

	return (key <= 13 || (key >= 48 && key <= 57)); 
} 



function NumCheck(e, field) {
    key = e.keyCode ? e.keyCode : e.which;
    if (key === 8) //Para backspace, borrar nuemros
        return true;
    if (key === 45) //Para signo negativo
        return true;
    if (field.value !== "") {
        if ((field.value.indexOf(",")) > 0) {
            if (key > 47 && key < 58) {
                if (field.value === "")
                    return true;
                regexp = /[0-9]{1,10}[,][0-9]{1,3}$/;
                regexp = /[0-9]{2}$/;
                return !(regexp.test(field.value))
            }
        }
    }
    if (key > 47 && key < 58) {
        if (field.value === "")
            return true;
        regexp = /[0-9]{10}/;
        return !(regexp.test(field.value));
    }
    if (key === 44) {
        if (field.value === "")
            return false;
        regexp = /^[0-9]+$/;
        return regexp.test(field.value);
 
    }
 
    return false;
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
        //var valor=document.getElementById("idcomp").value;
 
        if(valor.length<6)
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

function validarguardarComp()
{
	var verificar = true;
	var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
	var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
	
	var formulario = document.getElementById("form");
	var idcomp = document.getElementById("idcomp");
	var tipo = document.getElementById("tipo");
	var fecha = document.getElementById("fecha");
	var total = document.getElementById("total");
	
	if(!idcomp.value)
	{
		alert("El codigo es requerido");
		idcomp.focus();
		verificar = false;
	}
	
	//else if(!expRegNombre.exec(nombre.value))
	else if(tipo.value == 0)
	{
		alert("El campo tipo debe ser seleccionado");
		tipo.focus();
		verificar = false;	
	}
	
	else if(!fecha.value)
	{
		alert("El campo fecha es requerido");
		fecha.focus();
		verificar = false;
	}
	
	else if(!total.value)
	{
		alert("El campo total es requerido");
		total.focus();
		verificar = false;
	}

}


function limpiarrend()
{
	buscarDatosUsuarioSel();
	$('#folio').val(null);
	$('#archivo').val(null);
	$('#estado').val(null);
	$('#tipofondo').val(null);
	$('#fondoasign').val(null);
	$('#observacion').val(null);
	hoyFecha()
}

function buscarEncRend()
{
	var index= document.getElementById("folio").value;
	if ($.isNumeric(index)) { 

		$('#folio').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscar';
		var folio= document.getElementById("folio").value;
		
		if (folio=="")
		{	
		}
		else
		{

			var data='accion=' + accion + "&folio="+folio;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#fecha').val(response.fecha);
					//$('#empresa').val(response.empresa);
					//$('#usuario').val(response.usuario);
					//$('#rutusuario').val(response.rutusuario);
					$('#banco').val(response.banco);
					$('#tipocuenta').val(response.tipocuenta);
					$('#nrocuenta').val(response.nrocuenta);
					$('#archivo').val(response.archivo);
					$('#estado').val(response.estado);	
					$('#tipofondo').val(response.tipofondo);
					$('#fondoasign').val(response.fondoasign);
					$('#observacion').val(response.observacion);
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}
function descargarArchivoRend()
{
	var verificar = true;
	var iddetarch= document.getElementById("iddetarch").value;
	
	if(!$.isNumeric(iddetarch))
	{
		//alert("La fecha es requerida.");
		//fechadet.focus();
		verificar = false;
	}

	if (verificar)
	{
		var accion= 'descargarrendarch';
			
		var data='accion=' + accion + "&iddetarch="+iddetarch;
						
		$.ajax({
			beforeSend: function(){
			    //console.log('eliminando datos de la DB...')
			},
						
			cache: false,
			type: 'POST',
			dataType: 'json',
			url:'../controller/rendicionesController.php', 
			data: data,
			success: function(response){
				// Validar mensaje de error
			    if(response.respuesta == false){
			    	alert(response.mensaje);
			    }
			    else
				{							
			    	// si es exitosa la operación
					var nuevoarchivo = response.nuevoarchivo;
					var ruta = response.ruta;

					var visualizar= "<img src='../public/images/save_download_32.png' border='0' width='24' height='24' />";
					ruta = ruta.replaceAll("%","/");

					var linkdescarga = "../archivos" + ruta + "/" + nuevoarchivo;
					document.getElementById("btnDescargarRendArch").innerHTML = "<a href='" + linkdescarga + "' download='" + nuevoarchivo + "'>" + visualizar +"</a>";
				}
			},
			error:function(){
				alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			}  
		});
	}
}
function buscarRend()
{
	$('#tableRend').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscarrend"
				    }
	        },
	        "columns": [
	        	{ "data": "folio" },
	        	{ "data": "observacion" }
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

function buscarEncAux()
{
	var index= document.getElementById("rutdet").value;
	if ($.isNumeric(index)) { 

		//$('#rutaux').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscaraux';
		var rutdet= document.getElementById("rutdet").value;
		
		if (rutdet=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&rutdet="+rutdet;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					if (response.nombreaux=="No")
					{
						$('#proveedordet').val("No existe este auxiliar");
						$('#rutdet').val(null);
						//$('#dialogo-nuevoAux').dialog('open');
					}
					else
					{
					$('#proveedordet').val(response.nombreaux);
					//alert('Bieeeeen');
					//$('#direccion').val(response.direccion);
					//$('#comuna').val(response.comuna);
					//$('#telefono').val(response.telefono);
					//$('#celular').val(response.celular);
					//$('#mail').val(response.mail);
					//$('#contacto').val(response.contacto);
					//$('#ctacte').val(response.ctacte);
					//$('#banco').val(response.banco);
					}
					
						
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}
function buscarAux()
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

function buscarEncMatriz()
{
	//var index= document.getElementById("cuenta").value;
	//if ($.isNumeric(index)) { 

		//$('#rutaux').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscarmatriz';
		var matriz= document.getElementById("matrizdet").value;
		matriz=matriz.substring(0,12);

		if (matriz=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&matriz="+matriz;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#matrizdet').val(response.codigonombrecta);
						
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	//}
}
function buscarMatriz()
{
	$('#tableMatriz').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscarmatriz"
				    }
	        },

	        "columnDefs": [
			    { "width": "100px", "targets": 0 }
			  ],

	        "columns": [
	        	{ "data": "codigo" },
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

function buscarEncCentro()
{
	//var index= document.getElementById("cuenta").value;
	//if ($.isNumeric(index)) { 

		//$('#rutaux').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscarcentro';
		var centro= document.getElementById("centrocosto").value;
		centro=centro.substring(0,9);

		if (centro=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&centro="+centro;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#centrocosto').val(response.codigonombrecentro);
						
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	//}
}
function buscarCentro()
{
	$('#tableCentro').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscarcentro"
				    }
	        },

	        "columnDefs": [
			    { "width": "100px", "targets": 0 }
			  ],

	        "columns": [
	        	{ "data": "codigo" },
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
function revisafoliorend()
{
	
	//var index= document.getElementById("cuenta").value;
	//if ($.isNumeric(index)) { 

		//$('#rutaux').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		//$('#nrooc').removeAttr("readonly");
		var accion= 'revisafoliorend';
		var folio= document.getElementById("folio").value;

		if (folio=="" || !$.isNumeric(folio))
		{
			folio= 0;
		}
			
			var data='accion=' + accion + "&folio="+folio;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					
						$('#folio').val(response.usarfolio);
						$('#folio').attr("readonly","readonly");
						//alert("bien");
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});


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
function cargargridrend()
{
	var folio = document.getElementById("folio").value;
		$('#tablaDet').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": 'buscarrenddet',
				        "folio": folio
				    }
	        },

	        "columns": [
	        	{ "data": "id" },
	        	{ "data": "fecha" },
	        	{ "data": "rut" },
	        	{ "data": "proveedor" },
	        	{ "data": "monto" },
	        	{ "data": "tipodoc" },
	        	{ "data": "nrodoc" },
	        	{ "data": "concepto" },
	        	{ "data": "matriz" }
	        ],

	        "columnDefs": [
		        {"className": "dt-right", "targets": 4},
		        {"className": "dt-right", "targets": 6},
		        {"className": "dt-left", "targets": 7},
		        {"className": "dt-left", "targets": 8},


		        {
	                "targets": [ 5 ],
	                "visible": true,
	                "searchable": true
	            }



		        //{ "width": "80%", "targets": 0 }
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

function cargargridarch()
{
	var folio = document.getElementById("folio").value;
		$('#tablaArch').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": 'buscarrendarch',
				        "folio": folio
				    }
	        },

	        "columns": [
	        	{ "data": "id" },
	        	{ "data": "archivo" },
	        	{ "data": "nuevoarchivo" }
	        ],

	        "columnDefs": [
		        {"className": "dt-right", "targets": 0},
		        {"className": "dt-left", "targets": 1},
		        {"className": "dt-left", "targets": 2},


		        {
	                "targets": [ 0 ],
	                "visible": true,
	                "searchable": true
	            }



		        //{ "width": "80%", "targets": 0 }
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


function limpiarrenddet()
{
	$('#iddetrend').val(null);
	//$('#tipoart').checked(true);
	$('#fechadet').val(null);
	$('#rutdet').val(null);
	$('#proveedordet').val(null);
	$('#montodet').val(null); //$('#montodet').val(0);
	$('#tipodocdetalle').val(0);
	$('#nrodocdet').val(null);
	$('#conceptodet').val(null);
	$('#matrizdet').val(null);
	//$('#tipoart').attr('checked', 'checked');
	//$('#tipoart').removeAttr('checked');

}

function limpiarrendarch()
{
	$('#iddetarch').val(null);
	$('#archivodetarch').val(null);
	$('#nuevoarchivo').val(null);
	$('#subirarchivo').val(null);

	var visualizar= "<img src='../public/images/save_download_32.png' border='0' width='24' height='24' />";

	var linkdescarga = "javascript:void(0);";
	document.getElementById("btnDescargarRendArch").innerHTML = "<a href='" + linkdescarga + "' download=''>" + visualizar +"</a>";	
}

function CalculaNeto()
{
	//var cantidad= document.getElementById("cantidad").value;
	//var precio= document.getElementById("precio").value;
	//precio = precio.replace(",",".");
	//cantidad = cantidad.replace(",",".");

	//var neto= cantidad * precio;
	
	//$('#netodet').val(neto);
	

}
function QuitarPuntos()
{
	var fondoasign= document.getElementById("fondoasign").value;
	//var precio= document.getElementById("precio").value;
	fondoasign = fondoasign.replace(".","");
	//cantidad = cantidad.replace(",",".");

	//var neto= cantidad * precio;
	
	$('#fondoasign').val(fondoasign);
	

}

function PonerPuntos()
{
	var fondoasign= document.getElementById("fondoasign").value;
	
	
	$('#fondoasign').val(fondoasign);
	

}

function hoyFecha()
{
    var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();
        
        dd = addZero(dd);
        mm = addZero(mm);
 
        //return dd+'/'+mm+'/'+yyyy;
        //var fec=dd+'-'+mm+'-'+yyyy;
        var fec=yyyy+'-'+mm+'-'+dd;
	$('#fecha').val(fec);        
}

function addZero(i) 
{
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}
function buscarauxdet()
{
	var index= document.getElementById("rutdet").value;
	if ($.isNumeric(index)) { 
		//$('#idart').attr("readonly","readonly");

		var accion= 'buscarauxdet';
		var rutdet= document.getElementById("rutdet").value;
		
		if (rutdet=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&rutdet="+rutdet;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#proveedordet').val(response.nombreaux);
					//$('#um').val(response.um);
					//$('#um').val(campo6);
					//$('#detalle').attr("readonly","readonly");
					//$('#um').attr("readonly","readonly");	
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}
function buscarDatosUsuarioSel()
{
	var usuariosel_id= document.getElementById("usuariosel_id").value;
	if ($.isNumeric(usuariosel_id)) { 

		//$('#nrooc').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscardatosusuariosel';
		//var usuariosel_id= document.getElementById("usuariosel_id").value;
		
		if (usuariosel_id=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&usuariosel_id="+usuariosel_id;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/rendicionesController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#rutusuario').val(response.rutusuario);
					$('#banco').val(response.banco);
					$('#tipocuenta').val(response.tipocuenta);
					$('#nrocuenta').val(response.nrocuenta);
						
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}