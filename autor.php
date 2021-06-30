<?php
  session_start();
  include('conectar.php');
  

  $conexion = conectar();
  $consulta= "SELECT libros.*, autores.apellido, autores.nombre, autores.id as id_autor FROM libros INNER JOIN autores ON (libros.autores_id = autores.id) WHERE autores.id=".$_GET['id'] ;  
  $result= mysqli_query($conexion, $consulta);

  while ($row=mysqli_fetch_array($result)  )  {
      $consulta2="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['id']."'AND ultimo_estado='RESERVADO'";//Consulta para hacer la operacion de cantidad de libros disponibles
      $librosReservados=mysqli_query($conexion,$consulta2);
      $librosRes=mysqli_num_rows($librosReservados);
      $consulta3="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['id']."'AND ultimo_estado='PRESTADO'";
      $librosPrestados=mysqli_query($conexion,$consulta3);
      $librosPres=mysqli_num_rows($librosPrestados);
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
      <div  id="sesionAutor">
        <a href="iniciarSesion.php">Iniciar Sesión</a> ||
        <a href="registrar.php">Registrarse</a>
      </div>
      <div>
        <a href="index.php"><img id="logo" src="img/logo-biblioteca.png"></a>
      </div>
    </div>
    <h1 class="titulos"><?php echo $row['nombre'] ?>  <?php echo $row['apellido'] ?></h1>
    <div class="scrollTabla">
      <table border="1px">
        <thead>
          <tr>
            <th>Portada</th>
            <th>Titulo</a></th>
            <th>Autor</a></th>
            <th>Ejemplares</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="portada"><img id="img_titutlo" src="mostrarImagenPortada.php?id_libro=<?php echo $row['id'] ?>"></td>
            <td class="tamañoCelda"><?php echo utf8_encode($row['titulo'])?></a></td>
            <td class="tamañoCelda"><?php echo $row['nombre'] ?>  <?php echo $row['apellido'] ?></td>
            <td class="tamañoCelda"><?php $disponibles=($row['cantidad'] - ($librosRes + $librosPres)); echo $row['cantidad'] ?> (<?php echo $disponibles ?> Disponibles - <?php echo $librosPres ?> Prestados - <?php echo $librosRes ?> Reservados )</td>
          </tr>
        </tbody>
<?php } ?>

    </div>

  </body>
</html>
