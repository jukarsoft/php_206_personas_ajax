<?php 
	//sesion
	session_start();
	//recuperar datos del formularil
	$nif=$_POST['nif']; 
	$nombre=$_POST['nombre'];
	$direccion=$_POST['direccion'];
	$mensaje='';
	//echo "$nif $nombre $direccion";
	//validar los datos: NIF, Nombre, Dirección, esten informados.
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
		//validar que la persona (nif) no exista en el array
		if (isset ($_SESSION['personas']) && array_key_exists($nif, $_SESSION['personas'])) {
			$mensaje=$nif.' nif ya existente';
		} else {
			//dar de alta la persona en la variable de sesion
			//forma1
				//$_SESSION['personas'][$nif]['nombre']=$nombre;
				//$_SESSION['personas'][$nif]['direccion']=$direccion;
			//forma2
				$_SESSION['personas'][$nif] = array('nombre'=>$nombre, 'direccion'=>$direccion);
			//$_SESSION['personas'][$nif] = ['nombre'=>$nombre, 'direccion'=>$direccion];
				$mensaje='nif:'.$nif.' alta persona efectuada';
			//print_r($_SESSION['personas']);
		}
	}
	sleep(1);
	echo $mensaje;
 ?>

