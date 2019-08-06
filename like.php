<?php
session_start();
include_once("gestionBD.php");
include_once("gestionarCosas.php");
	
if (isset($_REQUEST['like'])){
	$username = $_SESSION['login'];
	$conexion = crearConexionBD();
	$excepcion = add($conexion,$_SESSION['CANCIONACTUAL']);
	$excepcion = like($conexion,$username,$_SESSION['CANCIONACTUAL']);
	cerrarConexionBD($conexion);
	if ($excepcion<>""){
		$_SESSION['exepcion'] = $excepcion;
      Header("Location: principal.php");
    }else{
	  Header("Location: principal.php");
		}
	}else {
		Header("Location: PENE.php");
	}
?>