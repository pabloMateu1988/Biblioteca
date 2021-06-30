<?php
session_start();
include('conectar.php');
$conexion=conectar();


date_default_timezone_set('America/Lima');
$fecha=date('Y/m/d');
$usuario=$_GET['usuario'];
$libro=$_GET['libro'];
$idOp=$_GET['idOperaciones'];

$reservar="UPDATE operaciones SET ultimo_estado='PRESTADO', fecha_ultima_modificacion='$fecha' WHERE lector_id='$usuario' AND libros_id='$libro'  AND id='$idOp'";

if(mysqli_query($conexion,$reservar)){
  header ('location: bibliotecarioLoggeado.php');
}
?>
