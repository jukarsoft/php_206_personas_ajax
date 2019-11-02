<?php 
	//sesion
	session_start();
	$nif='';
	$nombre='';
	$direccion='';
	$datosPersona=null;
	$datosTabla= array();


	if (isset($_SESSION['personas'])){
		//ordenar el array por nif (clave principal)
		ksort($_SESSION['personas']);
		//ordenar el array por primera clave del segundo array (ordenar por nombre)
		//asort($_SESSION['personas']);
		//multisort (por direccion)  - extraer valor 
		//creamos un array con las claves del array de personas (el nif)
		$claves = array_keys($_SESSION['personas']);
		//creamos un array con el dato (columna) que queremos ordenar (la dirección)
		$direcciones = array_column($_SESSION['personas'], 'direccion');
		//ordenamos el array de direcciones de forma ascendente y, simultaneamente, se ordenara el array de personas y el de claves por la misma ordenación de claves que el primero
		array_multisort($direcciones, SORT_ASC, $_SESSION['personas'], $claves);
		//substituimos las claves del array de personas por las del array de claves 
		$_SESSION['personas'] = array_combine($claves, $_SESSION['personas']);
		// print_r($_SESSION['personas']);
			$datosTabla = $_SESSION['personas'];
	} 
	//trasforma a JSON y es la respuesta al ja
	echo json_encode($datosTabla);

 ?>