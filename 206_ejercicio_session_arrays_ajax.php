<?php

?>
<html>
<head>
	<title></title>
	<meta charset='UTF-8'>
	<style type="text/css">
		label {width: 150px; display: inline-block;}
		table {border: 1px solid blue;}
		td, th {border: 1px solid blue; width: 250px;}
		.wraper {margin: auto; border: 3px ridge blue;width: 650px;padding: 15px;}
		form {margin: 0px; display: inline-block;}
	</style>
	<script type="text/javascript" src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
	<script type="text/javascript">
		//no ejecuta hasta que no cargue la pagina
		window.onload = function() {
			//recuperar los datos del servidor
			consultaPersonas();
			//detectar la pulsación del botón de enviar (activar un listener)
			document.getElementById('alta').addEventListener('click', altaPersona);
			document.getElementById('baja').addEventListener('click', bajaPersonas);
		}

		function consultaPersonas() {
			//petición al servidor para recuperar todas las personas
			$.post('php_206_consPersonasJSON.php', {}, respuestaConsulta);
		}

		function respuestaConsulta(respuesta) {
			//estas funciones que esperan respuesta del servidor se llaman callback 
			//alert(respuesta);
			//document.getElementById('listapersonas').innerHTML+=respuesta;
			var titulos="<tr><th>NIF</th><th>Nombre</th><th>Dirección</th><th></th></tr>";
			//transformar la respuesta que viene en JSON a array de objetos
			var arrayPersonas=JSON.parse(respuesta);
			//console.log(arrayPersonas);
			//confeccionar todas la filas de la tabla
			var datosTabla='';
			//bucle for para array de objetos
			for (c in arrayPersonas) {
				//js no tiene array asociativos por eso el nif es el numero de array
				datosTabla+="<tr>";
					datosTabla+="<td class='nif' >" + c + "</td>";
					//se puede mejorar la codificación haciendo template string ``
					//tambien se puede referenciar a un objeto poniendo .xxxxxx pe. arrayPersonas[c].nombre
					datosTabla+="<td><input type='text' value='" + arrayPersonas[c].nombre + "' class='nombre' /> </td>";
					datosTabla+="<td><input type='text' value='" + arrayPersonas[c]['direccion'] + "' class='direccion' /> </td>";
					datosTabla+="<td>";
						datosTabla+="<form>";
							datosTabla+="<input type='hidden' class='nifpersona' name='nifpersona' >";
							datosTabla+="<input type='button' class='bajapersona' name='bajapersona' data-nif='" + c + "' value='baja'>";
						datosTabla+="</form>";
						datosTabla+="<input type='button' value='Modificar' class='modificar'>";
					datosTabla+="</td>";
				datosTabla+="</tr>";
			}


			document.getElementById('listapersonas').innerHTML=titulos+datosTabla;
			//activar listener baja y modificación //recuperar botones a recuperar
			var bajaPersona=document.querySelectorAll('.bajaPersona');
			//activar listener para baja persona (tipo de boton y función a lanzar)
			for (i=0; i< bajaPersona.length; i++) {
				bajaPersona[i].addEventListener('click', bajaNIF);
			}

			var botones=document.querySelectorAll('.modificar');
			//activar listener para modificar (tipo de boton y función a lanzar)
			for (i=0; i< botones.length; i++) {
				botones[i].addEventListener('click', modificar);
			}
		} 

		function altaPersona() {
			//alert('entro en altaPersona');
			//recuperar datos del formulario
			var nifAlta=document.getElementById('nifAlta').value;
			var nombreAlta=document.getElementById('nombreAlta').value;
			var direccionAlta=document.getElementById('direccionAlta').value;
			//enviar los datos al servidor
			//alert(nifAlta);

			$.ajax({
				//beforeSend() function opcional 
				url:'php_206_altaPersonas.php', 
				type: 'post',
				data: {'nif':nifAlta,'nombre':nombreAlta,'direccion':direccionAlta},
				beforeSend: function() {
					//acciones a realizar mientras no se recibe la respuesta
					//var reloj = "<img src='reloj_arena.gif'>";
					//document.getElementById('mensaje').innerHTML=reloj;
				},
				success: function(respuesta) {
					//respuesta del servidor
					document.getElementById('mensaje').innerText=respuesta;
					//alert (respuesta);
					//alert (respuesta);
					//refrescar la página
					consultaPersonas();
				},
				error: function() {
					//respuesta del servidor en caso de error
				},
				complete: function() {
					//acciones a realizar cuando finaliza la petición
				}
			})
		}

		function bajaPersonas() {
			//peticion al servidor previa confirmacion
			if (confirm('estas seguro?')) {
				$.ajax({
					//beforeSend() function opcional 
					url:'php_206_bajaPersonas.php', 
					type: 'post',
					data: {},
					beforeSend: function() {
						//acciones a realizar mientras no se recibe la respuesta
						var reloj = "<img src='reloj_arena.gif'>";
						document.getElementById('mensaje').innerHTML=reloj;
					},
					success: function(respuesta) {
						//respuesta del servidor
						document.getElementById('mensaje').innerText=respuesta;
						//alert (respuesta);
						alert (respuesta);
						//refrescar la página
						consultaPersonas();
					},
					error: function() {
						//respuesta del servidor en caso de error
					},
					complete: function() {
						//acciones a realizar cuando finaliza la petición
					}
				})
			}
		}
		
		//baja de un nif o persona
		function bajaNIF() {
			//alert (' entro en la función bajaPersona');
			
			//dos opciones para seleccionar 
			//recuperar los datos a partir de la etiqueta TR
			//			var tr=this.closest('tr');
			//          var nif=tr.querySelector('.nif').innerText;
			var nif = this.getAttribute('data-nif');
			if (confirm('estas seguro?')) {
				//petición al servidor 
				//dos opciones por $_post (jquery) o por AJAX ($.ajax)
				//$.post('php_206_bajaPersona.php', {'nifpersona':nif}, respuestaBaja);
				$.ajax({
					//beforeSend() function opcional 
					url:'php_206_bajaPersona.php', 
					type: 'post',
					data: {'nifpersona':nif},
					beforeSend: function() {
						//acciones a realizar mientras no se recibe la respuesta
						var reloj = "<img src='reloj_arena.gif'>";
						document.getElementById('mensaje').innerHTML=reloj;
					},
					success: function(respuesta) {
						//respuesta del servidor
						document.getElementById('mensaje').innerText=respuesta;
						//alert (respuesta);
						//alert (respuesta);
						//acciones a realizar mientras no se recibe la respuesta
						//refrescar la página
						consultaPersonas();
					},
					error: function() {
						//respuesta del servidor en caso de error
					},
					complete: function() {
						//acciones a realizar cuando finaliza la petición
					}
				}) //fin $.ajax
			}
		}


		function respuestaBaja(respuesta) {
			document.getElementById('mensaje').innerText=respuesta;
			//alert (respuesta);
			
			alert (respuesta);
			//refrescar la página // recargar la página
			consultaPersonas();
		}

		function modificar() {
			//alert ("modificar");
			//situarnos en la etiqueta TR de la fila sobre la que hemos pulsado el boton de modificar
			// opcion 1 >>>>> var tr=this.parentNode.parentNode;
			//opcion 2 >>>>>> closest busca la etiqueta más cercana del tipo que se indique
			var tr=this.closest('tr');
			//recuperar los datos a partir de la etiqueta TR
			var nif=tr.querySelector('.nif').innerText;
			var nom=tr.querySelector('.nombre').value;
			var dir=tr.querySelector('.direccion').value;
			//informar el formulario oculto
			//document.getElementById('nif').value=nif;
			//document.getElementById('nombre').value=nom;
			//document.getElementById('direccion').value=dir;

			//enviar formulario al servidor
			$.post('php_206_modificarPersona.php', {'nif':nif, 'nombre':nom,'direccion':dir}, respuestaModificar);
			
		}

		function respuestaModificar(respuesta) {
			document.getElementById('mensaje').innerText=respuesta;
			//alert (respuesta);
			//alert (respuesta);
			//refrescar la página // recargar la página
			consultaPersonas();
		}

	</script>
</head>
<body>
	<div class='wraper'>
		<form>
			<label>NIF</label>
			<input type='text' name='nif' id="nifAlta"><br>
			<label>Nombre</label>
			<input type='text' name='nombre' id="nombreAlta"><br>
			<label>Dirección</label>
			<input type='text' name='direccion' id="direccionAlta"><br>
			<input type='button' name='alta' id="alta" value='alta persona'>
			<span id="mensaje"></span>
		</form><br><br>
		<table id="listapersonas">
			<tr><th>NIF</th>
				<th>Nombre</th>
				<th>Dirección</th>
				<th></th>
			</tr>
						
		</table><br>
		<form>
			<input type='button' id="baja" name='baja' value='baja personas'>
		</form>
		
</body>
</html>