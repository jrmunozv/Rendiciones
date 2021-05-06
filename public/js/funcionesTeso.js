/* Desarrollado por Jose Munoz */

$(document).ready(function(){
	
	

	// Mostrar dialogo maestro de registros
	//$('#table').DataTable();
	//var table = $('#table').DataTable();
 
    var tablaReg = $('#tablaReg').DataTable({
        "destroy": true,
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });


    $('#btnGenerar').click(function(){
		cargargridrend()
		
	});



    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth();
    var year = date.getFullYear();
    if (month < 10)
    {
        month = "0" + month;
    }
    if (day < 10)
    {
        day = "0" + day;
    }
    var today = year + "-" + month + "-" + '01';
    desdefecha= today;
    document.getElementById("desdefecha").value = today;


    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth()+1;
    var year = date.getFullYear();
    if (month < 10)
    {
        month = "0" + month;
    }
    if (day < 10)
    {
        day = "0" + day;
    }
    var today = year + "-" + month + "-" + day;
    hastafecha= today;
    document.getElementById("hastafecha").value = today;
    //alert(today);



    $('#listaregistros').on('click', 'tr', function (){
        
    //  var celda = $(this).children("td");
     //   $('#lin').val(celda.html());
      //  alert(celda.html());

        var campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8, campo9, campo10;
        $(this).children("td").each(function (index2) 
        {
               
            if(index2==0)
            {
                campo1 = $(this).text();
                $('#codrend').val(campo1);
            }

            if(index2==1)
            {
                campo2 = $(this).text();
                $('#folio').val(campo2);
            }

            if(index2==2)
            {
                campo3 = $(this).text();
                $('#fecha').val(campo3);
            }

            if(index2==3)
            {
                campo4 = $(this).text();
                $('#usuario').val(campo4);
            }

            if(index2==4)
            {
                campo5 = $(this).text();
                $('#empresa').val(campo5);
            }

            if(index2==5)
            {
                campo6 = $(this).text();
                $('#estado').val(campo6);
            }

            if(index2==6)
            {
                campo7 = $(this).text();
                $('#monto').val(campo7);
            }

            if(index2==8)
            {
                campo8 = $(this).text();
                $('#aprobar').val(campo8);
            }

            if(index2==9)
            {
                campo9 = $(this).text();
                $('#contab').val(campo9);
            }

            if(index2==10)
            {
                campo10 = $(this).text();

                if (campo10 == 'Impago')
                {
                    $('#pago').removeAttr('checked');
                }
                else
                {
                    $('#pago').attr('checked', 'checked');
                }
            }
        })
    });



    //Guardar RENDICIONES****************************************
    //
    $('#btnGuardarRend').click(function(){
        ///////////
        var verificar = true;
        
        var codrend = document.getElementById("codrend").value;
        
        if(!codrend)
        {
            alert("Tiene que seleccionar una rendicion.");
            //archivo.focus();
            verificar = false;
        }
        
        /////
        
        if (verificar)
        {
            var accion= 'editarrend';
            var codrend = document.getElementById("codrend").value;
            if( $('#pago').prop('checked') ) {
                var pago= 1;
            }
            else
            {
                var pago= 0; 
            }

            var data='accion=' + accion + '&codrend=' + codrend + '&pago=' + pago;
                        
            $.ajax({
                beforeSend: function(){
                    //console.log('eliminando datos de la DB...')
                },
                        
                cache: false,
                type: 'POST',
                dataType: 'json',
                url:'../controller/tesoreriaController.php', 
                data: data,
                success: function(response){
                    // Validar mensaje de error
                    if(response.respuesta == false){
                        alert(response.mensaje);
                    }
                    else
                    {                           
                        //alert(response.aprobar);
                        limpiarrend();
                        cargargridrend();
                    }
                },  
            });

        }       
    });
    //*/


















});
//FIN FUNCTION READY DOCUMENT






/**
     * Función que solo permite la entrada de numeros, un signo negativo y
     * un punto para separar los decimales
     */
function soloNumeros(e)
{
    // capturamos la tecla pulsada
    var teclaPulsada=window.event ? window.event.keyCode:e.which;
    // capturamos el contenido del input
    var valor=document.getElementById("idart").value;

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

function cargargridrend()
{
	//document.getElementById("desdefecha").value = "2014-02-09";
	var desdefecha = document.getElementById("desdefecha").value;
	var hastafecha = document.getElementById("hastafecha").value;
	if (!desdefecha)
	{
		var date = new Date();
        var day = date.getDate();
        var month = date.getMonth();
        var year = date.getFullYear();
        if (month < 10)
        {
            month = "0" + month;
        }
        if (day < 10)
        {
            day = "0" + day;
        }
        var today = year + "-" + month + "-" + '01';
        desdefecha= today;
        document.getElementById("desdefecha").value = today;
	}
	if (!hastafecha)
	{
		var date = new Date();
		var day = date.getDate();
		var month = date.getMonth()+1;
		var year = date.getFullYear();
		if (month < 10) month = "0" + month;
		if (day < 10) day = "0" + day;
		var today = year + "-" + month + "-" + day;       

		hastafecha= today;
		document.getElementById("hastafecha").value = today;
	}
	
	$('#tablaReg').DataTable({
    	//"autoWidth": false,
        "destroy": true,
    	"pageLength": 5,
        "ajax": {
            "url": "../controller/tablasController.php",
            "type": "POST",
            "data": {
			        "accion": "buscarrendaprob",
			        "desdefecha": desdefecha,
			        "hastafecha": hastafecha
			    }
        },
        "columns": [
        	{ "data": "codrend" },
        	{ "data": "folio" },
        	{ "data": "fecha" },
        	{ "data": "usuario" },
            { "data": "empresa" },
        	{ "data": "estado" },
            { "data": "monto" },
        	{ "data": "detalle" },
        	{ "data": "aprobar" },
            { "data": "contab" },
            { "data": "pago" }
        ],

        "columnDefs": [
            {"className": "dt-left", "targets": 2},
            {"className": "dt-left", "targets": 3},
            {"className": "dt-left", "targets": 4},
            {"className": "dt-right", "targets": 6},
            //{ "width": "2%", "targets": [ 0 ] },

            {
                "targets": [ 0 ],
                "visible": true,
                "searchable": true
            }
        ],

        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sRowSelect": "single",
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]

    })

}

function limpiarrend()
{
    $('#codrend').val(null);
    $('#folio').val(null);
    $('#fecha').val(null);
    $('#usuario').val(null);
    $('#empresa').val(null);
    $('#estado').val(null);
    $('#monto').val(null);
    $('#aprobar').val(null);
    $('#contab').val(null);
    $('#pago').removeAttr('checked');
    
}