<?php
session_start();
include('conectar.php');
$conexion=conectar();
$id=$_SESSION['id'];
$consulta="SELECT cantidad FROM libros WHERE id=$id";
$result=mysqli_query($conexion,$consulta);
if($fila=mysqli_fetch_array($result)){
  $fi=$fila['cantidad'] - 1;
  $sql="UPDATE libros SET cantidad='$fi' WHERE id=$id";
  mysqli_query($conexion,$sql);
  header('location:usuarioLoggeado.php');

}




 ?>
