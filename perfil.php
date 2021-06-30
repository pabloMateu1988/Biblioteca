<?php
session_start();
include('persona.php');
$per=new persona('','');
try{
  $per->es_lector();
}catch (\Exception $e) {
  $_SESSION['error']=$e->getMessage();
  header('location:iniciarSesion.php'); //Setear mensaje de error
}

$conexion = conectar();

$consulta="SELECT li.id AS idLibro,li.portada,li.titulo,li.autores_id,au.id AS idAutor,au.apellido,au.nombre,op.lector_id,op.ultimo_estado,op.fecha_ultima_modificacion FROM operaciones op
INNER JOIN libros li ON op.libros_id = li.id
INNER JOIN autores au ON li.autores_id = au.id WHERE lector_id='".$_SESSION['id']."'";

$result=mysqli_query($conexion,$consulta);







?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Biblioteca</title>
    <LINK href="css/styles.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div  id="header">
      <div>
        <a href="index.php"><img id="logo" src="img/logo-biblioteca.png"></a>
      </div>
          <div  id="sesion">
            <a href="perfil.php">Usuario Loggeado:<?php echo $_SESSION['nombre'] . ' '?><?php echo $_SESSION['apellido']?></a> ||
            <a href="cerrar_sesion.php">Cerrar Sesión</a>
          </div>
    </div>
    <div id="bloquePerfil">
      <h1 class="titulos">Mi Perfil</h1>
      <table id="tablaPerfil">
        <tr>
          <th>Nombre:</th><td><?php echo $_SESSION['nombre']; ?></td><td id="fotoCarnet" rowspan="3">  <img class="perfil" src="mostrarImagen.php?id=<?php echo $_SESSION['id']?>"/></td>
        </tr>
        <tr>
          <th>Apellido:</th><td><?php echo $_SESSION['apellido']; ?></td>
        </tr>
        <tr>
          <th>Email:</th><td><?php echo $_SESSION['email']; ?></td>
        </tr>
      </table>
    </div>
    <div id="bloqueOperaciones">
      <h1 class="titulos">Historial de operaciones</h1>
      <div class="scrollTabla">
        <table border="1px">
          <thead>
            <tr>
              <th>Portada</th>
              <th><a href="titulo.php">Titulo</a></th>
              <th><a href="autor.php">Autor</a></th>
              <th>Estado</th>
              <th>Fecha</th>
            </tr>
            </thead>
          <tbody>
  <?php while ($row=mysqli_fetch_array($result)) {?>
          <tr>
            <td class="portada"><img src="mostrarImagenPortada.php?id_libro=<?php echo $row['idLibro'] ?>" class="portada"></td>
            <td><a href="titulo.php?id=<?php echo $row['idLibro'] ?>"><?php echo utf8_encode($row['titulo']); ?></a></td>
            <td><a href="libros_de_autor.php?autor=<?php echo $row['idAutor'] ?>"><?php echo utf8_encode($row['nombre']) . ' ' . utf8_encode($row['apellido']); ?> </a></td>
            <td><?php echo $row['ultimo_estado']?></td>
            <?php $fechas= explode ("-",$row['fecha_ultima_modificacion']);
            $fecha_invertida=$fechas[2]."-".$fechas[1]."-".$fechas[0]; ?>
            <td><?php echo $fecha_invertida ?> </td>
          </tr>
  <?php } ?>
          </tbody>
      </div>

    </div>

  </body>
</html>
