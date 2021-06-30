<?php
function conectar(){
  $conexion = mysqli_connect('localhost', 'root', '', 'biblio')
	or die(mysqli_error($conexion));

  return $conexion;

}


?>
