<?php 
	//sesion
	session_start();
	//recuperar  info
	$nif=$_POST['nif']; 
	$nombre=$_POST['nombre'];
	$direccion=$_POST['direccion'];
	$mensaje='';
	// validar si esta informado
	if (trim($nif)=='') {
		$mensaje=$mensaje.'NIF no informado';
	}
	if (trim($nombre)=='') {
		$mensaje=$mensaje.'// nombre no informado';
	}
	if (trim($direccion)=='') {
		$mensaje=$mensaje.' // dirección no informada';
	}
	if (trim($nif)=='' || trim($nombre)=='' || trim($direccion)=='') {
		$mensaje=$mensaje.'--> DATOS OBLIGATORIOS';
	} else {
		//si informado modificar en el array utilizando el nif como clave
		$_SESSION['personas'][$nif] = array('nombre'=>$nombre, 'direccion'=>$direccion);
		//mensaje de modificación realizada
		$mensaje='nif:'.$nif.' Modificación persona efectuada';
	}				
	sleep(3);
	echo $mensaje;

 ?>