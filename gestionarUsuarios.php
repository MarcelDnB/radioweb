<?php
//Se ha hecho una función por departamento de la empresa que cuenta el total de empleados que pertenecen a cada departamento según el email y password introducidos
function consultarUsuario($conexion,$username,$password) {
   $consulta = "SELECT COUNT(*) AS TOTAL FROM USERS WHERE username=:username AND password=:password";
   $stmt = $conexion->prepare($consulta);
   $stmt->bindParam(':username',$username);
   $stmt->bindParam(':password',$password);
   $stmt->execute();
   return $stmt->fetchColumn();
}
function registrarUsuario($conexion,$username,$email,$password) {
   try {
   $stmt=$conexion->prepare("CALL registrar_usuario(:username,:email,:password,user)");
   $stmt->bindParam(':username',$username);
   $stmt->bindParam(':email',$email);
   $stmt->bindParam(':password',$password);
   $stmt->execute();
   return "";
   } catch(PDOException $e) {
		return $e->getMessage();
    }
}
?>