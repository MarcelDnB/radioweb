<?php
	session_start();
  include_once("gestionBD.php");
 	include_once("gestionarUsuarios.php");
	
	if (isset($_POST['submit'])){
    $username= $_POST['logmodaluid'];
		$password = $_POST['logmodalpass'];
    $conexion = crearConexionBD();
		$num_usuarios = consultarUsuario($conexion,$username,$password);
		$_SESSION['consultarusuarios'] = $num_usuarios;

		cerrarConexionBD($conexion);	

		if ($num_usuarios > 0){
      $_SESSION['login'] = $username;
      Header("Location: principal.php");
    }
		else{
      $_SESSION['login'] = "error";
      Header("Location: limbo.php");
		}
	}
?>
























<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css'>
  <link rel="stylesheet" href="css/style.css">
  <script  src="js/navbar.js"></script>
  <link rel="stylesheet" href="css/logo.css">
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
</head>

<body>

      <!-- Fixed navbar -->
    <nav class="navbar navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Beats & Vibes</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a class="btn" href="principal.php">Home</a></li>

            <?php 
            if(isset($_SESSION['consultarusuarios'])){
              if(!($_SESSION['consultarusuarios']>0)) { 
                 ?>
            <li><a class="btn" data-toggle="modal" data-target="#myModalRegister" id="btnreg">
  Register
</a></li>
            <?php }
          } ?>
            <li><a class="btn" data-toggle="modal" data-target="#myModalLogin">
  Login
</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <!-- Modal Register-->
    <div class="modal fade-scale" id="myModalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Beats & Vibes</h4>
      </div>
      <div class="modal-body">
      <fieldset>
      <legend>
      Register
          </legend>
          <div><label for="regmodaluid">Username: </label><input type="text" id="regmodaluid" name="regmodaluid"></div>
          <div><label for="regmodalemail">Email: </label><input type="text" id="regmodalemail" name="regmodalemail"></div>
          <div><label for="regmodalpass">Password: </label><input type="text" id="regmodalpass" name="regmodalpass"></div>  
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Register</button>
      </div>
    </div>
  </div>
</div>
 <!-- Modal Login -->
 <div class="modal fade-scale" id="myModalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Beats & Vibes</h4>
      </div>
      <div class="modal-body">
      <fieldset>
      <legend>
      Login
          </legend>
          <form action="principal.php" method="post">
          <div><label for="logmodaluid">Username: </label><input type="text" id="logmodaluid" name="logmodaluid"></div>
          <div><label for="logmodalpass">Password: </label><input type="password" id="logmodalpass" name="logmodalpass"></div>
        </fieldset>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>
            </form>
</body>
</html>
