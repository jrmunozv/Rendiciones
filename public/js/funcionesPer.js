/* Desarrollado por Jose Munoz */

$(document).ready(function(){
	

	$('#ano').change(function(){
		buscar();
	});

	restablecer()

	$('#btnEne').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/ENE_ACT.BMP')
		            ? '../public/images/bitmaps/ENE_INA.BMP'
		            : '../public/images/bitmaps/ENE_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/ENE_INA.BMP')
		         {
		         	cerrar(1);
		         }
		         else
		         {
		         	abrir(1);
		         }
	     	 }

	    }
	});


	$('#btnFeb').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/FEB_ACT.BMP')
		            ? '../public/images/bitmaps/FEB_INA.BMP'
		            : '../public/images/bitmaps/FEB_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/FEB_INA.BMP')
		         {
		         	cerrar(2);
		         }
		         else
		         {
		         	abrir(2);
		         }
	     	 }
	    }
	});

	
	$('#btnMar').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/MAR_ACT.BMP')
		            ? '../public/images/bitmaps/MAR_INA.BMP'
		            : '../public/images/bitmaps/MAR_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/MAR_INA.BMP')
		         {
		         	cerrar(3);
		         }
		         else
		         {
		         	abrir(3);
		         }
	     	 }
	    }
	});

	
	$('#btnAbr').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/ABR_ACT.BMP')
		            ? '../public/images/bitmaps/ABR_INA.BMP'
		            : '../public/images/bitmaps/ABR_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/ABR_INA.BMP')
		         {
		         	cerrar(4);
		         }
		         else
		         {
		         	abrir(4);
		         }
	     	 }
	    }
	});

	
	$('#btnMay').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/MAY_ACT.BMP')
		            ? '../public/images/bitmaps/MAY_INA.BMP'
		            : '../public/images/bitmaps/MAY_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/MAY_INA.BMP')
		         {
		         	cerrar(5);
		         }
		         else
		         {
		         	abrir(5);
		         }
	     	 }
	    }
	});

	
	$('#btnJun').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/JUN_ACT.BMP')
		            ? '../public/images/bitmaps/JUN_INA.BMP'
		            : '../public/images/bitmaps/JUN_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/JUN_INA.BMP')
		         {
		         	cerrar(6);
		         }
		         else
		         {
		         	abrir(6);
		         }
	     	 }
	    }
	});

	
	$('#btnJul').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/JUL_ACT.BMP')
		            ? '../public/images/bitmaps/JUL_INA.BMP'
		            : '../public/images/bitmaps/JUL_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/JUL_INA.BMP')
		         {
		         	cerrar(7);
		         }
		         else
		         {
		         	abrir(7);
		         }
	     	 }
	    }
	});

	
	$('#btnAgo').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/AGO_ACT.BMP')
		            ? '../public/images/bitmaps/AGO_INA.BMP'
		            : '../public/images/bitmaps/AGO_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/AGO_INA.BMP')
		         {
		         	cerrar(8);
		         }
		         else
		         {
		         	abrir(8);
		         }
	     	 }
	    }
	});

	
	$('#btnSep').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/SEP_ACT.BMP')
		            ? '../public/images/bitmaps/SEP_INA.BMP'
		            : '../public/images/bitmaps/SEP_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/SEP_INA.BMP')
		         {
		         	cerrar(9);
		         }
		         else
		         {
		         	abrir(9);
		         }
	     	 }
	    }
	});

	
	$('#btnOct').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/OCT_ACT.BMP')
		            ? '../public/images/bitmaps/OCT_INA.BMP'
		            : '../public/images/bitmaps/OCT_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/OCT_INA.BMP')
		         {
		         	cerrar(10);
		         }
		         else
		         {
		         	abrir(10);
		         }
	     	 }
	    }
	});

	
	$('#btnNov').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/NOV_ACT.BMP')
		            ? '../public/images/bitmaps/NOV_INA.BMP'
		            : '../public/images/bitmaps/NOV_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/NOV_INA.BMP')
		         {
		         	cerrar(11);
		         }
		         else
		         {
		         	abrir(11);
		         }
	     	 }
	    }
	});

	
	$('#btnDic').on({
	    'click': function() {
	         var ano= document.getElementById("ano").value;
	         if(ano!=0)
	         {
		         var src = ($(this).attr('src') === '../public/images/bitmaps/DIC_ACT.BMP')
		            ? '../public/images/bitmaps/DIC_INA.BMP'
		            : '../public/images/bitmaps/DIC_ACT.BMP';
		         $(this).attr('src', src);

		         if(src=='../public/images/bitmaps/DIC_INA.BMP')
		         {
		         	cerrar(12);
		         }
		         else
		         {
		         	abrir(12);
		         }
	     	 }
	    }
	});
	
	
});
//FIN FUNCTION READY DOCUMENT

function buscar()
{
	var ano= document.getElementById("ano").value;
	var accion= 'cargarano';
	var data='accion=' + accion + "&ano="+ano;

	$.ajax({ 
		//cache: false,
		type: 'POST',
		dataType: 'json',
		url:'../controller/periodoController.php', 
		data: data,
		success: function(response){
			// si es exitosa la operación
			//alert(response.mes);
			/*alert(response.contenido[0]+response.contenido[1]+response.contenido[2]
				+response.contenido[3]+response.contenido[4]+response.contenido[5]
				+response.contenido[6]+response.contenido[7]+response.contenido[8]
				+response.contenido[9]+response.contenido[10]+response.contenido[11]
				+response.contenido[12]);
			
			$.each(response.contenido, function(d, v){
		        alert(response.contenido.value);
		    });
				*/
			restablecer();
			var mes;
			for (mes=0; mes <= 11; mes++)
			{
				//alert(response.contenido[0][mes]+response.contenido[1][mes]);
				if(response.contenido[0][mes]==1)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnEne").attr("src",'../public/images/bitmaps/ENE_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==2)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnFeb").attr("src",'../public/images/bitmaps/FEB_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==3)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnMar").attr("src",'../public/images/bitmaps/MAR_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==4)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnAbr").attr("src",'../public/images/bitmaps/ABR_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==5)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnMay").attr("src",'../public/images/bitmaps/MAY_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==6)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnJun").attr("src",'../public/images/bitmaps/JUN_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==7)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnJul").attr("src",'../public/images/bitmaps/JUL_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==8)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnAgo").attr("src",'../public/images/bitmaps/AGO_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==9)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnSep").attr("src",'../public/images/bitmaps/SEP_INA.BMP');
					}

				}
				
				if(response.contenido[0][mes]==10)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnOct").attr("src",'../public/images/bitmaps/OCT_INA.BMP');
					}

				}
				
				if(response.contenido[0][mes]==11)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnNov").attr("src",'../public/images/bitmaps/NOV_INA.BMP');
					}

				}

				if(response.contenido[0][mes]==12)
				{

					if(response.contenido[1][mes]==0)
					{
						$("#btnDic").attr("src",'../public/images/bitmaps/DIC_INA.BMP');
					}

				}
				


			};

			//alert(response.contenido[0][10]);
			//alert(response.contenido[1][9]);

		},
		error:function(){
			alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
		}
	});				
}
function restablecer()
{
	$("#btnEne").attr("src",'../public/images/bitmaps/ENE_ACT.BMP');
	
	$("#btnFeb").attr("src",'../public/images/bitmaps/FEB_ACT.BMP');
	
	$("#btnMar").attr("src",'../public/images/bitmaps/MAR_ACT.BMP');
	
	$("#btnAbr").attr("src",'../public/images/bitmaps/ABR_ACT.BMP');
	
	$("#btnMay").attr("src",'../public/images/bitmaps/MAY_ACT.BMP');
	
	$("#btnJun").attr("src",'../public/images/bitmaps/JUN_ACT.BMP');
	
	$("#btnJul").attr("src",'../public/images/bitmaps/JUL_ACT.BMP');
	
	$("#btnAgo").attr("src",'../public/images/bitmaps/AGO_ACT.BMP');
	
	$("#btnSep").attr("src",'../public/images/bitmaps/SEP_ACT.BMP');
	
	$("#btnOct").attr("src",'../public/images/bitmaps/OCT_ACT.BMP');
	
	$("#btnNov").attr("src",'../public/images/bitmaps/NOV_ACT.BMP');
	
	$("#btnDic").attr("src",'../public/images/bitmaps/DIC_ACT.BMP');
	
}

function cerrar(mes)
{
	//alert('cerrar'+mes);
	var ano= document.getElementById("ano").value;
	var accion= 'cerrarmes';
	var data='accion=' + accion + "&mes="+mes + "&ano="+ano;

	$.ajax({ 
		//cache: false,
		type: 'POST',
		dataType: 'json',
		url:'../controller/periodoController.php', 
		data: data,
		success: function(response){
			
		},
		error:function(){
			alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
		}
	});				

}
function abrir(mes)
{
	var ano= document.getElementById("ano").value;
	var accion= 'abrirmes';
	var data='accion=' + accion + "&mes="+mes + "&ano="+ano;

	$.ajax({ 
		//cache: false,
		type: 'POST',
		dataType: 'json',
		url:'../controller/periodoController.php', 
		data: data,
		success: function(response){
			
		},
		error:function(){
			alert('ERROR GENERAL DEL SISTEMA, INTENTE MAS TARDE');
		}
	});		
}
