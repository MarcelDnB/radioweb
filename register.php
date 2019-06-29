<?php
session_start();
include_once("gestionBD.php");
include_once("gestionarUsuarios.php");
	if (isset($_POST['subreg'])){
    $username= $_POST['regmodaluid'];
    $email = $_POST['regmodalemail'];
    $password = $_POST['regmodalpass'];
    $conexion = crearConexionBD();
	$excepcion = registrarUsuario($conexion,$username,$email,$password);
	cerrarConexionBD($conexion);
	if($excepcion<>"") {
        $_SESSION["excepcion"] = $excepcion;
        $_SESSION["destino"] = "principal.php";
        $_SESSION["borrado"] = 1;
        Header("Location: principal.php");
    }else {
        Header("Location: principal.php");
    }

	}else {
        Header("Location: principal.php");
    }
?>