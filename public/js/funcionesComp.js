/* Desarrollado por Jose Munoz */

$(document).ready(function(){
	hoyFecha();
	$('#show2').hide();
    $('#pestaña1').css({'background-color': 'rgba(102, 64, 131, 0.86)'});
	$('#pestaña1').css({'font-weight': 'bold'});
	$('#pestaña2').css({'color': '#CCC'});
    
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
                $('#pestaña2').css({'background-color': '#6ad5f5'});
                $('#pestaña1').css({'font-weight': 'bold'});
				$('#pestaña2').css({'font-weight': 'normal'});
                $('#show1').fadeIn();
                $('#pestaña1').css({'color': '#000000'});
				$('#pestaña2').css({'color': '#CCC'});
				buscarEncOCTotales();
            });    
        });
    	

    	
		$('#pestaña2').click(function(){
		    
		    var nrooc = document.getElementById("nrooc").value;
		    if (nrooc == "")
		    {

		    	$('#show1').fadeOut(function() {
					            $('#pestaña1').css({'background-color': '#6ad5f5'});
					            $('#show2').fadeIn();
					            $('#pestaña2').css({'font-weight': 'bold'});
								$('#pestaña1').css({'font-weight': 'normal'});
								$('#pestaña2').css({'color': '#000000'});
								$('#pestaña1').css({'color': '#CCC'});
					        });
		    }
		    else
		    {		        
		    	var accion= 'buscar';				
				var data='accion=' + accion + "&nrooc="+nrooc;
			
				$.ajax({ 
					//cache: false,
					type: 'POST',
					dataType: 'json',
					url:'../controller/comprobanteController.php', 
					data: data,
					success: function(response){
						if(!response.solicitante)
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

					        cargargridart();
				            
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
	$('#btnImprimirOC').click(function(){
		//alert("Se debe generar codigo para guardar");
		var nrooc= document.getElementById("nrooc").value;
		window.open('../model/imprcompModel.php/?nrooc='+nrooc);

		
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

	

	$('#listadetoc').on('click', 'tr', function (){
		
	//	var celda = $(this).children("td");
     //   $('#lin').val(celda.html());
      //  alert(celda.html());

      	var campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8;
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		campo1 = $(this).text();
        		$('#iddetoc').val(campo1);
        	}

        	if(index2==1)
        	{
        		campo2 = $(this).text();
        		//$('#tipoart').val(campo2);
        		if (campo2 == 1)
        		{
        			$('#tipoart').attr('checked', 'checked');
        			$('#idart').removeAttr("readonly");
	        		$('#detalle').attr("readonly","readonly");
	        		document.getElementById("um").disabled=true;
        		}
        		else
        		{
        			$('#tipoart').removeAttr('checked');
        			$('#detalle').removeAttr("readonly");
	        		$('#idart').attr("readonly","readonly");
	        		document.getElementById("um").disabled=false;
        		}

        	}

        	if(index2==2)
        	{
        		campo3 = $(this).text();
        		$('#idart').val(campo3);
        	}

        	if(index2==3)
        	{
        		campo4 = $(this).text();
        		$('#detalle').val(campo4);
        	}

        	if(index2==4)
        	{
        		campo5 = $(this).text();
        		campo5 = campo5.replace('.', '');
        		$('#cantidad').val(campo5);
        	}

        	if(index2==5)
        	{
        		campo6 = $(this).text();
        		$('#um').val(campo6);
        	}

        	if(index2==6)
        	{
        		
        	}

        	if(index2==7)
        	{
        		campo7 = $(this).text();
        		campo7 = campo7.replace('.', '');
        		$('#precio').val(campo7);
        	}

        	if(index2==8)
        	{
        		campo8 = $(this).text();
        		$('#netodet').val(campo8);
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


   $('#btnMaestroOC').click(function(){
   		buscarOC();
		$('#dialogo-maestroOC').dialog('open');

	});

	$('#dialogo-maestroOC').dialog({
		title: 'Listado de Ordenes de Compra',
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
				$('#nrooc').val(codoc);
				buscarEncOC();
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				limpiaroc();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codoc;
	$('#listaencoc').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		codoc = $(this).text();
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
				$('#rutaux').val(codaux);
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


$('#btnMaestroCuenta').click(function(){
   		buscarCuenta();
		$('#dialogo-maestroCuenta').dialog('open');

	});

	$('#dialogo-maestroCuenta').dialog({
		title: 'Listado de Cuentas contables',
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
				$('#cuenta').val(codcuenta);
				buscarEncCuenta();
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				//limpiaroc();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codcuenta;
	$('#listaenccuenta').on('click', 'tr', function (){
		
        $(this).children("td").each(function (index2) 
        {
               
        	if(index2==0)
        	{
        		//campo1 = $(this).text();
        		codcuenta = $(this).text();
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
				$('#um').val(um);
				$(this).dialog( "close" );
			},
			Cancelar: function() {
				// Cerrar ventana de diálogo
				//limpiarcomp();
				$(this).dialog( "close" );
			}
		}
		
	});

	var codart, nomart; um;
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
        		um = $(this).text();
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
	$('#dialogo-folioOC').dialog({
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
	

	//Guardar ORDEN COMPRA****************************************
	//
	$('#btnGuardarOC').click(function(){
		///////////
		var verificar = true;
		var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
		var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
		
		

		//var nrooc= document.getElementById("nrooc").value;
		//var formulario = document.getElementById("form").value;
		var estado = document.getElementById("estado").value;
		var rutaux = document.getElementById("rutaux").value;
		var solicitante = document.getElementById("solicitante").value;
		var lugarentrega = document.getElementById("lugarentrega").value;
		var condpago = document.getElementById("condpago").value;
		var tipocambio = document.getElementById("tipocambio").value;
		var cuenta = document.getElementById("cuenta").value;
		var centrocosto = document.getElementById("centrocosto").value;
		var ctacte= document.getElementById("ctacte").value;

		hoyFecha();

		revisafoliooc();
		
		if(estado == 0)
		{
			alert("El campo Estado debe ser seleccionado");
			estado.focus();
			verificar = false;
		}
		
		else if(!rutaux)
		{
			alert("El campo Rut auxiliar es requerido");
			rutaux.focus();
			verificar = false;	
		}
		
		else if(solicitante == 0)
		{
			alert("El campo Solicitante debe ser seleccionado");
			solicitante.focus();
			verificar = false;
		}
		
		else if(lugarentrega == 0)
		{
			alert("El campo Lugar de Entrega debe ser seleccionado");
			lugarentrega.focus();
			verificar = false;
		}

		else if(condpago == 0)
		{
			alert("El campo Condicion de Pago debe ser seleccionado");
			condpago.focus();
			verificar = false;
		}

		else if(condpago == 1 && !ctacte)
		{
			alert("El campo cuenta corriente y banco es requerido");
			condpago.focus();
			verificar = false;
		}

		else if(!tipocambio)
		{
			alert("El campo Tipode Cambio es requerido");
			tipocambio.focus();
			verificar = false;	
		}

		else if(!cuenta)
		{
			alert("El campo Cuenta es requerido");
			cuenta.focus();
			verificar = false;	
		}

		else if(!centrocosto)
		{
			alert("El campo Centro Costo es requerido");
			centrocosto.focus();
			verificar = false;	
		}
		
		/////
		
		if (verificar)
		{
			var accion= 'guardaroc';
			var nrooc= document.getElementById("nrooc").value;
			var solicitante= document.getElementById("solicitante").value;
			var lugarentrega= document.getElementById("lugarentrega").value;
			var fecha= document.getElementById("fecha").value;
			var entrega= document.getElementById("entrega").value;
			var estado= document.getElementById("estado").value;
			var condpago= document.getElementById("condpago").value;
			var cotizacion= document.getElementById("cotizacion").value;
			var porcentpago= document.getElementById("porcentpago").value;
			var rutaux= document.getElementById("rutaux").value;
			var presupuesto= document.getElementById("presupuesto").value;
			var tipocambio= document.getElementById("tipocambio").value;
			var cuenta= document.getElementById("cuenta").value;
			var centrocosto= document.getElementById("centrocosto").value;
			var observacion= document.getElementById("observacion").value;
			var neto= document.getElementById("neto").value;
			var iva= document.getElementById("iva").value;
			var total= document.getElementById("total").value;



			var data='accion=' + accion + "&nrooc=" + nrooc+ "&solicitante=" +
			solicitante+ "&lugarentrega=" + lugarentrega+ "&fecha=" + fecha+
			"&entrega=" + entrega + "&estado=" + estado+ "&condpago=" +
			condpago+ "&cotizacion=" + cotizacion+ "&porcentpago=" +
			porcentpago+ "&rutaux=" + rutaux+ "&presupuesto=" + presupuesto+
			"&tipocambio=" + tipocambio+ "&cuenta=" + cuenta+ "&centrocosto="
			+ centrocosto+ "&observacion=" + observacion+ "&neto=" + neto+ "&iva=" + iva+ "&total=" + total;
						
			$.ajax({
				beforeSend: function(){
			    	//console.log('eliminando datos de la DB...')
				},
						
				cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
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
						$('#show1').fadeOut(function() {
			                $('#pestaña1').css({'background-color': '#6ad5f5'});
			                $('#show2').fadeIn();
			                $('#pestaña2').css({'font-weight': 'bold'});
							$('#pestaña1').css({'font-weight': 'normal'});
							$('#pestaña2').css({'color': '#000000'});
							$('#pestaña1').css({'color': '#CCC'});
			            });

			            cargargridart();
					}
				},  
			});

		}		
	});
	//*/

	


//Guardar DETALLE ARTICULOS****************************************
	//

	$('#btnGuardarOCDet').click(function(){
		///////////
		var verificar = true;
		var expRegNombre=/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
		var expRegEmail=/^[\w-\.]+@([\w]+\.)+[\w-]{2,4}$/;
		
		//var formulario = document.getElementById("form");
		var idart = document.getElementById("idart").value;
		var detalle = document.getElementById("detalle").value;
		var um = document.getElementById("um").value;
		
		
		if(!idart)
		{
			alert("El codigo es requerido.");
			idart.focus();
			verificar = false;
		}
		
		//else if(!expRegNombre.exec(nombre.value))
		//else if(!detalle.value && !salidaart.value)
		else if(!detalle)
		{
			alert("El campo detalle debe tener una descripcion.");
			detalle.focus();
			verificar = false;	
		}
		
		else if(um == 0)
		{
			alert("El campo unidad de medida es requerido");
			centroart.focus();
			verificar = false;
		}
		
		

		/////
		if (verificar)
		{
			

			var accion= 'guardarocdet';
			var nrooc= document.getElementById("nrooc").value;
			var iddetoc= document.getElementById("iddetoc").value;
			//var tipoart= document.getElementById("tipoart").checked;
			if( $('#tipoart').prop('checked') ) {
			    var tipoart= 1;
			}
			else
			{
				var tipoart= 0;	
			}
			var idart= document.getElementById("idart").value;
			var detalle= document.getElementById("detalle").value;
			var cantidad= document.getElementById("cantidad").value;
			var um= document.getElementById("um").value;
			var precio= document.getElementById("precio").value;
			if (cantidad == '0,00')
			{
				cantidad = 0;
			}
			else
			{
				cantidad = cantidad.replace(",",".");
			}

			if (precio == '0,00')
			{
				precio = 0;
			}
			else
			{
				precio = precio.replace(",",".");
			}

			
			var data='accion=' + accion + "&nrooc=" + nrooc+ "&iddetoc=" +
			iddetoc+ "&tipoart=" + tipoart+ "&idart=" + idart + "&detalle=" +
			detalle+ "&cantidad=" + cantidad+ "&um=" +
			um+ "&precio=" + precio;
						
			$.ajax({
				beforeSend: function(){
			    	//console.log('eliminando datos de la DB...')
				},
						
				cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// Validar mensaje de error
			    	if(response.respuesta == false){
			    		alert(response.mensaje);
			    	}
			    	else
					{							
			    		limpiarocdet();
			    		cargargridart();
			    		// si es exitosa la operación
						//var form=document.form;
						//form.reset();
					}
				},  
			});
		}
		
	});




	//*/
	$('#btnNuevoRegOCDet').click(function(){
		limpiarocdet();
	});


	$('#btnBorrarOCDet').click(function(){
		var iddetoc= document.getElementById("iddetoc").value;
		if (iddetoc == '')
		{	
		}
		else
		{
			var accion= 'eliminarocdet';
			$.ajax({
				beforeSend: function(){
			    // console.log('eliminando datos de la DB...')
			    },
						
			    cache: false,
			    type: 'POST',
			    dataType: 'json',
			    url:'../controller/comprobanteController.php', 
			    data:'accion=' + accion + "&iddetoc=" + iddetoc,
			    success: function(response){
			    	// Validar mensaje de error
			    	if(response.respuesta == false){
			        	alert(response.mensaje);
			        }
			        else
					{							
			        	// si es exitosa la operación
			        	limpiarocdet();
				    	cargargridart();
			            
					}
			    },
						
			    error:function(){
			        alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
			    }
			});
		}
	});

	$('#tipoart22').on( 'change', function() {
	    if( $(this).is(':checked') ) {
	        // Hacer algo si el checkbox ha sido seleccionado
	        $('#idart').removeAttr("readonly");
	        $('#detalle').attr("readonly","readonly");
	        //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
	    } else {
	        // Hacer algo si el checkbox ha sido deseleccionado
	        $('#idart').attr("readonly","readonly");
	        $('#detalle').removeAttr("readonly");
	        //alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
	    }
	});

	$('#tipoart').on( 'click', function() {
	    if( $(this).is(':checked') ){
	        // Hacer algo si el checkbox ha sido seleccionado
	        $('#idart').val(null);
	        $('#idart').removeAttr("readonly");
	        $('#detalle').attr("readonly","readonly");
	        document.getElementById("um").disabled=true;
	        //$('#idart').removeAttr('checked');
	        //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
	    } else {
	        // Hacer algo si el checkbox ha sido deseleccionado
	        $('#idart').val(1000);
	        $('#idart').attr("readonly","readonly");
	        $('#detalle').removeAttr("readonly");
	        document.getElementById("um").disabled=false;
	        //alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
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
    if (key === 8)
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


function limpiaroc()
{
	$('#nrooc').val(null);
	$('#solicitante').val(null);
	$('#lugarentrega').val(null);
	$('#fecha').val(null);
	$('#entrega').val(null);
	$('#estado').val(null);
	$('#condpago').val(null);
	$('#cotizacion').val(null);
	$('#porcentpago').val(null);
	$('#rutaux').val(null);
	$('#presupuesto').val(null);
	$('#tipocambio').val(null);
	$('#cuenta').val(null);
	$('#centrocosto').val(null);
	$('#observacion').val(null);
	$('#nombreaux').val(null);
	$('#contacto').val(null);
	$('#celular').val(null);
	$('#direccion').val(null);
	$('#comuna').val(null);
	$('#telefono').val(null);
	$('#ctacte').val(null);
	$('#banco').val(null);
	$('#mail').val(null);


}

function buscarEncOC()
{
	var index= document.getElementById("nrooc").value;
	if ($.isNumeric(index)) { 

		$('#nrooc').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscar';
		var nrooc= document.getElementById("nrooc").value;
		
		if (nrooc=="")
		{	
		}
		else
		{

			var data='accion=' + accion + "&nrooc="+nrooc;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#solicitante').val(response.solicitante);
					$('#lugarentrega').val(response.lugarentrega);
					$('#fecha').val(response.fecha);
					$('#entrega').val(response.entrega);
					$('#estado').val(response.estado);
					$('#condpago').val(response.condpago);
					$('#cotizacion').val(response.cotizacion);
					$('#porcentpago').val(response.porcentpago);
					$('#rutaux').val(response.rutaux);
					$('#presupuesto').val(response.presupuesto);
					$('#tipocambio').val(response.tipocambio);
					$('#cuenta').val(response.cuenta);
					$('#centrocosto').val(response.centrocosto);
					$('#observacion').val(response.observacion);
					$('#nombreaux').val(response.nombreaux);
					$('#contacto').val(response.contacto);
					$('#celular').val(response.celular);
					$('#direccion').val(response.direccion);
					$('#comuna').val(response.comuna);
					$('#telefono').val(response.telefono);
					$('#ctacte').val(response.ctacte);
					$('#banco').val(response.banco);
					$('#mail').val(response.mail);
					$('#neto').val(response.neto);
					$('#iva').val(response.iva);
					$('#total').val(response.total);
						
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}
function buscarOC()
{
	$('#tableOC').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscaroc"
				    }
	        },
	        "columns": [
	        	{ "data": "nrooc" },
	        	{ "data": "proveedor" }
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
	var index= document.getElementById("rutaux").value;
	if ($.isNumeric(index)) { 

		//$('#rutaux').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscaraux';
		var rutaux= document.getElementById("rutaux").value;
		
		if (rutaux=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&rutaux="+rutaux;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					if (response.nombreaux=="No")
					{
						$('#nombreaux').val("No existe este auxiliar");
						$('#dialogo-nuevoAux').dialog('open');
					}
					else
					{
					$('#nombreaux').val(response.nombreaux);
					$('#direccion').val(response.direccion);
					$('#comuna').val(response.comuna);
					$('#telefono').val(response.telefono);
					$('#celular').val(response.celular);
					$('#mail').val(response.mail);
					$('#contacto').val(response.contacto);
					$('#ctacte').val(response.ctacte);
					$('#banco').val(response.banco);
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

function buscarEncCuenta()
{
	//var index= document.getElementById("cuenta").value;
	//if ($.isNumeric(index)) { 

		//$('#rutaux').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscarcuenta';
		var cuenta= document.getElementById("cuenta").value;
		cuenta=cuenta.substring(0,12);

		if (cuenta=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&cuenta="+cuenta;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#cuenta').val(response.codigonombrecta);
						
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	//}
}
function buscarCuenta()
{
	$('#tableCuenta').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": "buscarcuenta"
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
function revisafoliooc()
{
	//var index= document.getElementById("cuenta").value;
	//if ($.isNumeric(index)) { 

		//$('#rutaux').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		//$('#nrooc').removeAttr("readonly");
		var accion= 'revisafoliooc';
		var nrooc= document.getElementById("nrooc").value;

		if (nrooc=="" || !$.isNumeric(nrooc))
		{
			nrooc= 0;
		}
		
			var data='accion=' + accion + "&nrooc="+nrooc;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					if (response.usarfolio=="Supera")
					{
						$('#dialogo-folioOC').dialog('open');
						nrooc.focus();
					}
					else if (response.usarfolio=="Editar")
					{
						//alert("bien");
					}
					else
					{	
						$('#nrooc').val(response.usarfolio);
						$('#nrooc').attr("readonly","readonly");
						//alert("bien");
					}
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
function cargargridart()
{
	var nrooc = document.getElementById("nrooc").value;
		$('#tablaDet').DataTable({
	    	"destroy": true,
        	"pageLength": 5,
	        "ajax": {
	            "url": "../controller/tablasController.php",
	            "type": "POST",
	            "data": {
				        "accion": 'buscarocdet',
				        "nrooc": nrooc
				    }
	        },

	        "columns": [
	        	{ "data": "id" },
	        	{ "data": "tipo" },
	        	{ "data": "id_art" },
	        	{ "data": "detalle" },
	        	{ "data": "cantidad" },
	        	{ "data": "um" },
	        	{ "data": "umdesc" },
	        	{ "data": "precio" },
	        	{ "data": "neto" }
	        ],

	        "columnDefs": [
		        {"className": "dt-right", "targets": 4},
		        {"className": "dt-right", "targets": 7},
		        {"className": "dt-right", "targets": 8},

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
function limpiarocdet()
{
	$('#iddetoc').val(null);
	//$('#tipoart').checked(true);
	$('#idart').val(null);
	$('#detalle').val(null);
	$('#cantidad').val(null);
	$('#um').val(0);
	$('#precio').val(null);
	$('#netodet').val(null);
	$('#tipoart').attr('checked', 'checked');
	//$('#tipoart').removeAttr('checked');

}

function CalculaNeto()
{
	var cantidad= document.getElementById("cantidad").value;
	var precio= document.getElementById("precio").value;
	precio = precio.replace(",",".");
	cantidad = cantidad.replace(",",".");

	var neto= cantidad * precio;
	
	$('#netodet').val(neto);
	

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
function buscarartdet()
{
	var index= document.getElementById("idart").value;
	if ($.isNumeric(index)) { 
		//$('#idart').attr("readonly","readonly");

		var accion= 'buscarart';
		var idart= document.getElementById("idart").value;
		
		if (idart=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&idart="+idart;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#detalle').val(response.nombre);
					$('#um').val(response.um);
					//$('#um').val(campo6);
					//$('#detalle').attr("readonly","readonly");
					$('#um').attr("readonly","readonly");	
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}
function buscarEncOCTotales()
{
	var index= document.getElementById("nrooc").value;
	if ($.isNumeric(index)) { 

		$('#nrooc').attr("readonly","readonly");
		//$('#idcomp').css({'background-color': 'rgba(128, 128, 128, 0.86)'});
		var accion= 'buscartotales';
		var nrooc= document.getElementById("nrooc").value;
		
		if (nrooc=="")
		{	
		}
		else
		{
			var data='accion=' + accion + "&nrooc="+nrooc;
		
			$.ajax({ 
				//cache: false,
				type: 'POST',
				dataType: 'json',
				url:'../controller/comprobanteController.php', 
				data: data,
				success: function(response){
					// si es exitosa la operación
					$('#neto').val(response.neto);
					$('#iva').val(response.iva);
					$('#total').val(response.total);
						
				},
				error:function(){
					alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
				}
			});				
		}
	}
}