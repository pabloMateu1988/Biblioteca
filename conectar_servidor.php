<?php
function conectar(){

$conexion = mysqli_connect('localhost', 'root', '', 'bibliotecabd') or die ("Error" . mysqli_error($conexion));//or die ("Error " . mysqli_error($conexion))


return $conexion;

}
?>
