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
		cargargridart()
		
	});

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

function cargargridart()
{
	//document.getElementById("desdefecha").value = "2014-02-09";
	var desdefecha = document.getElementById("desdefecha").value;
	var hastafecha = document.getElementById("hastafecha").value;
	var desdeidart = document.getElementById("desdeidart").value;
	var hastaidart = document.getElementById("hastaidart").value;
	var tipo = document.getElementById("tipo").value;
	if (!desdefecha)
	{
		desdefecha= '01-01-2010';
		document.getElementById("desdefecha").value = "2010-01-01";
		//var x = document.getElementById("myDate");
    //var defaultVal = x.defaultValue;
    //var currentVal = x.value;
		
	}
	if (!hastafecha)
	{
		var date = new Date();

		var day = date.getDate();
		var month = date.getMonth();
		var year = date.getFullYear();
		if (month < 10) month = "0" + month;
		if (day < 10) day = "0" + day;
		var today = year + "-" + month + "-" + day;       

		hastafecha= today;
		document.getElementById("hastafecha").value = today;
	}
	if (!desdeidart)
	{
		desdeidart= 1;
		document.getElementById("desdeidart").value = 1;
	}

	if (!hastaidart)
	{
		hastaidart= 1000;
		document.getElementById("hastaidart").value = 1000;
	}

	$('#tablaReg').DataTable({
    	"destroy": true,
    	"pageLength": 5,
        "ajax": {
            "url": "../controller/tablasController.php",
            "type": "POST",
            "data": {
			        "accion": "buscarreg",
			        "desdefecha": desdefecha,
			        "hastafecha": hastafecha,
			        "desdeidart": desdeidart,
			        "hastaidart": hastaidart,
			        "tipo": tipo
			    }
        },
        "columns": [
        	{ "data": "folio" },
        	{ "data": "tipo" },
        	{ "data": "fecha" },
        	{ "data": "comentario" },
        	{ "data": "id" },
        	{ "data": "codigo" },
        	{ "data": "articulo" },
        	{ "data": "entrada" },
        	{ "data": "salida" },
        	{ "data": "centro" },
        	{ "data": "cuenta" }
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