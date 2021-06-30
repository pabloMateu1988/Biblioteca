<?php
  session_start();
  include('conectar.php');

  $conexion = conectar();
  $busqueda= "SELECT libros.*, autores.apellido, autores.nombre, autores.id as id_autor FROM libros INNER JOIN autores ON (libros.autores_id = autores.id) WHERE libros.id=".$_GET['id'] ;
  $result= mysqli_query($conexion, $busqueda);
  $row=mysqli_fetch_array($result);
  $consulta2="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['id']."'AND ultimo_estado='RESERVADO'";
  $librosReservados=mysqli_query($conexion,$consulta2);
  $librosRes=mysqli_num_rows($librosReservados);
  $consulta3="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['id']."'AND ultimo_estado='PRESTADO'";
  $librosPrestados=mysqli_query($conexion,$consulta3);
  $librosPres=mysqli_num_rows($librosPrestados);

?>
<html>
  <head>
    <title>Biblioteca</title>
    <LINK href="css/styles.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div  id="header">
        <html>
        <div  id="sesion">
          <?php
          if(empty($_SESSION['rol'])){
          ?>
            <a href="iniciarSesion.php" >Iniciar Sesión ||</a>
            <a href="registrar.php" >Registrarse</a>
          <?php
          }else{
            if ($_SESSION['rol']=='LECTOR'){
            ?>
              <a href="perfil.php">Perfil Usuario:<?php echo $_SESSION['nombre'] . ' '. $_SESSION['apellido']?></a> ||
            <?php }?>
          <?php if ($_SESSION['rol'] == 'BIBLIOTECARIO') {?>
              <a href="bibliotecarioLoggeado.php">Listado de operaciones  ||</a>
              <a href="">Bibliotecario Loggeado: <?php echo $_SESSION['nombre'] . ' '?><?php echo $_SESSION['apellido']?></a> ||
          <?php  }
          ?>
          <a href="cerrar_sesion.php">Cerrar Sesión</a>
          <?php 
            }
        ?>

        </div>
        <a href="index.php">  <img id="logo" src="img/logo-biblioteca.png"></a>
      </div>
    </div>
    <div id="bloque_detalles_titulo">
      <div id="texto_detalles">
        <div>
          <h2 class="titulos">Título: <?php echo utf8_encode($row['titulo'])?></h2>
        </div>
        <u><h3 class="subtitulos">Autor:</u> <?php echo $row['nombre'] ?>  <?php echo $row['apellido'] ?>  </h3>
        <u><h4 class="subtitulos">Ejemplares:</u> <?php $disponibles=($row['cantidad'] - ($librosRes + $librosPres)); echo $row['cantidad'] ?> (<?php echo $disponibles ?> Disponibles - <?php echo $librosPres ?> Prestados - <?php echo $librosRes ?> Reservados )</h4>
        <div id="bloque_descripcion_titulo">
          <u><h4 class="subtitulos">Descripción:</u></h4>
          <p> <?php echo utf8_encode($row['descripcion']) ?> </p>
        </div>
      </div>
      <tr>
           <td><img id="img_titutlo" src="mostrarImagenPortada.php?id_libro=<?php echo $row['id'] ?>"></td>
      </tr>
    </div>
  </body>
</html>
