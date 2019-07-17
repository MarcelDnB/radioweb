<?php
session_start();
include_once("gestionBD.php");
include_once("gestionarCosas.php");
	if (isset($_POST['like'])){
    $username= $_POST['logmodaluid'];
	$password = $_POST['logmodalpass'];
    $conexion = crearConexionBD();
	$num_usuarios = consultarUsuario($conexion,$username,$password);
	$_SESSION['consultarusuarios'] = $num_usuarios;
	cerrarConexionBD($conexion);
	if ($num_usuarios > 0){
	  $_SESSION['login'] = $username;
      Header("Location: principal.php");
    }else{
	  $_SESSION['login'] = "error";
	  Header("Location: principal.php");
		}
	}


?>