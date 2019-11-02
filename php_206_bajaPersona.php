<?php 
	//baja de una persona
	//sesion	
	session_start();
	//echo "entro";
	//recuperear nif a dar de baja
	$nifpersona=$_POST['nifpersona'];
	//borrar de la variable de sesion la fila correspondiente al nif
	//echo $nifpersona;
	unset($_SESSION['personas'][$nifpersona]);
	$mensaje='nif:'.$nifpersona.' baja persona efectuada';
	sleep(1);
	echo $mensaje;


?>