<?php
include('conectar.php');
$id = $_GET['id'];
$conexion=conectar();
$consulta="SELECT foto FROM usuarios WHERE id=$id ";
$result=mysqli_query($conexion,$consulta);
$row=mysqli_fetch_array($result);
header("Content-type: image/jpg");
echo $row['foto'];


 ?>
