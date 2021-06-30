<?php
session_start();

include('conectar.php');
$conexion=conectar();


date_default_timezone_set('America/Lima');
$fecha=date('Y/m/d');
$usuario=$_GET['usuario'];
$libro=$_GET['libro'];
$idOp=$_GET['idOperaciones'];

$devuelto="UPDATE operaciones SET ultimo_estado='DEVUELTO', fecha_ultima_modificacion='$fecha' WHERE lector_id='$usuario' AND libros_id='$libro' AND id='$idOp'";

if(mysqli_query($conexion,$devuelto)){
  header ('location: bibliotecarioLoggeado.php');
}
?>
