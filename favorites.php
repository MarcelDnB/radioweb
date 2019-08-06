<?php
include_once("paginacion_consulta.php");
include_once("gestionBD.php");
include_once("gestionarCosas.php");  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
</head>

<?php
//                                                      	 PAGINACION                                                           //
if (isset($_SESSION["paginacion"]))
$paginacion = $_SESSION["paginacion"];
$pagina_seleccionada = isset($_GET["PAG_NUM"]) ? (int)$_GET["PAG_NUM"] : (isset($paginacion) ? (int)$paginacion["PAG_NUM"] : 1);
$pag_tam = isset($_GET["PAG_TAM"]) ? (int)$_GET["PAG_TAM"] : (isset($paginacion) ? (int)$paginacion["PAG_TAM"] : 5);
if ($pagina_seleccionada < 1) 		$pagina_seleccionada = 1;
if ($pag_tam < 1) 		$pag_tam = 5;
unset($_SESSION["paginacion"]);
$conexion = crearConexionBD();
$query = "SELECT * from favorites where username='".$_SESSION['login']."'";
$total_registros = total_consulta($conexion, $query);
$total_paginas = (int)($total_registros / $pag_tam);
if ($total_registros % $pag_tam > 0)		$total_paginas++;
if ($pagina_seleccionada > $total_paginas)		$pagina_seleccionada = $total_paginas;
$paginacion["PAG_NUM"] = $pagina_seleccionada;
$paginacion["PAG_TAM"] = $pag_tam;
$_SESSION["paginacion"] = $paginacion;
$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
cerrarConexionBD($conexion);
$conexion = crearConexionBD();
$filas = consulta_paginada($conexion, $query, $pagina_seleccionada, $pag_tam);
cerrarConexionBD($conexion);
?>

<body>
  
<nav>
  <form method="get" action="principal.php" class="formpaginacion">
    <input id="PAG_NUM" name="PAG_NUM" type="hidden" value="<?php echo $pagina_seleccionada ?>" />
    <a class="mostrando">Mostrando</a>
    <input id="PAG_TAM" name="PAG_TAM" class="PAG_TAM" type="number" min="1" max="<?php echo $total_registros; ?>" value="<?php echo $pag_tam ?>" autofocus="autofocus" />
    entradas de <?php echo $total_registros ?>
    <input id="pagin" name="pagin" type="submit" value="Cambiar" class="subpaginacion">
  </form>
</nav>
<!--                                                      	 PAGINACION                                                           -->
<div id="enlaces" class="enlaces">

					<?php
					for ($pagina = 1; $pagina <= $total_paginas; $pagina++)
						if ($pagina == $pagina_seleccionada) { 	?>

						<span class="current"><?php echo $pagina; ?></span>

					<?php } else { ?>

						<a href="principal.php?PAG_NUM=<?php echo $pagina; ?>&PAG_TAM=<?php echo $pag_tam; ?>"><?php echo $pagina; ?></a>
            <?php } ?>

				</div>
<div class="titulofav">FAVORITES</div>
<div>
  
<table class="cuadrofav">
  <tr>
    <th>Song Name</th>
    <th>Total Likes</th> 
  </tr>
  
  <?php
  	$conexion = crearConexionBD();
  foreach ($filas as $fila) { ?>
  <?php $aux = cuentaLikes($conexion,$fila['SONGNAME']); ?>
  <tr>
  <td><?php echo $fila['SONGNAME']; ?></td>
	<td><?php echo $aux[0]; ?></td>
  </tr>
  <?php }
  cerrarConexionBD($conexion); ?>
</div>

				
</body>
</html>