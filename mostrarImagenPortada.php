<?php
include('conectar.php');
$id = $_GET['id_libro'];
$conexion=conectar();
$consulta="SELECT portada FROM libros l WHERE id=$id ";
$result=mysqli_query($conexion,$consulta);
$row=mysqli_fetch_array($result);
header("Content-type: image/jpg");
echo $row['portada'];

 ?>
