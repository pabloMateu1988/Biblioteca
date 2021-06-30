<?php
  session_start();
  include ('persona.php');
  $per=new persona('','');
  try{
    $per->es_bibliotecario();
  }catch (\Exception $e) {
    $_SESSION['error']=$e->getMessage();
    header('location:iniciarSesion.php'); //Setear mensaje de error
  }

  $conexion = conectar();


  $operaciones="SELECT us.nombre,us.apellido,li.id AS libroID,li.titulo,li.cantidad,au.id,au.apellido AS ape_autor,au.nombre AS nom_autor,op.ultimo_estado,op.id AS idOperaciones,op.fecha_ultima_modificacion,op.lector_id,op.libros_id FROM operaciones op
  INNER JOIN usuarios us ON op.lector_id = us.id
  INNER JOIN libros li ON op.libros_id = li.id
  INNER JOIN autores au ON li.autores_id = au.id WHERE 1=1 ";

  $titulo="";
  $autor="";
  $lector="";
  $fechaDesde="";
  $fechaHasta="";

  if(!empty($_GET['titulo'])){
    $titulo=$_GET['titulo'];
    $operaciones=$operaciones. "AND titulo like '%" .$titulo. "%'";
  }
  if(!empty($_GET['autor'])){
    $autor=$_GET['autor'];
    $operaciones=$operaciones."AND concat_ws(' ',au.nombre,au.apellido) like '%" .$autor. "%'";
  }
  if(!empty($_GET['lector'])){
    $lector=$_GET['lector'];
    $operaciones=$operaciones."AND concat_ws(' ',us.nombre,us.apellido) like '%" .$lector. "%'";
  }

  if(!empty($_GET['fecha_desde']) AND !empty($_GET['fecha_hasta'])){
    $fechaDesde=$_GET['fecha_desde'];
    $fechaHasta=$_GET['fecha_hasta'];
    $operaciones=$operaciones. "AND fecha_ultima_modificacion BETWEEN '".$fechaDesde."' AND '".$fechaHasta."'";
  }
  if(!empty($_GET['fecha_desde'])){
    $fechaDesde=$_GET['fecha_desde'];
    $operaciones=$operaciones. "AND fecha_ultima_modificacion >= '" .$fechaDesde."' ";
  }
  if(!empty($_GET['fecha_hasta'])){
    $fechaHasta=$_GET['fecha_hasta'];
    $operaciones=$operaciones. "AND fecha_ultima_modificacion <= '" .$fechaHasta."'" ;
  }
  $operaciones=$operaciones. "ORDER BY ultimo_estado,fecha_ultima_modificacion DESC";


  $result2=mysqli_query($conexion,$operaciones);



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
      <html>
        <div  id="sesion">
          <a href="">Bibliotecario Loggeado: <?php echo $_SESSION['nombre'] . ' '?><?php echo $_SESSION['apellido']?></a> ||
          <a href="cerrar_sesion.php">Cerrar Sesión</a>
        </div>
    <fieldset class="right" id="buscadorBibliotecario">
        <legend>Refinar Busqueda</legend>
        <form action="bibliotecarioLoggeado.php" method="GET" name="buscador">
          Titulo:<input class="input" type="text" name="titulo" value="<?php echo isset($_GET['titulo'])?$_GET['titulo']:"" ?>">
          Autor:<input class="input" type="text" name="autor" value="<?php echo isset($_GET['autor'])?$_GET['autor']:"" ?>">
          Lector:<input class="input" type="text" name="lector" value="<?php echo isset($_GET['lector'])?$_GET['lector']:""?>" ><br><br>
          Fecha Desde:<input class="input" type="date" name="fecha_desde" value="<?php echo isset($_GET['fecha_desde'])?$_GET['fecha_desde']:"" ?>" >
          Fecha Hasta:<input class="input" type="date" name="fecha_hasta" value="<?php echo isset($_GET['fecha_hasta'])?$_GET['fecha_hasta']:"" ?>" >
          <button>Buscar</button>
          <input type="button" value="Limpiar búsqueda" onclick="location.href='bibliotecarioLoggeado.php'">
        </form>
      </fieldset>
      <div class="left">
      <a href="index.php">  <img id="logoBibliotecario" src="img/logo-biblioteca.png"></a>
      </div>
    </div>

    <h2 class="titulos" id="tituloBibliotecario">Operaciones</h2>
      <table border="1px" id="tableBibliotecario">
        <thead>
          <tr>
            <th>Titulo</a></th>
            <th>Autor</a></th>
            <th>Lector</th>
            <th>Estado</th>
            <th>Fecha</th>
            <th>Ejemplares</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row=mysqli_fetch_array($result2)) {
            $consulta2="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['libros_id']."'AND ultimo_estado='RESERVADO'";
            $librosReservados=mysqli_query($conexion,$consulta2);
            $librosRes=mysqli_num_rows($librosReservados);
            $consulta3="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['libros_id']."'AND ultimo_estado='PRESTADO'";
            $librosPrestados=mysqli_query($conexion,$consulta3);
            $librosPres=mysqli_num_rows($librosPrestados);
            ?>


          <tr>
                <td><a href="titulo.php?id=<?php echo $row['libros_id'] ?>"><?php echo utf8_encode($row['titulo']); ?></a></td>
                <td><a href="autor.php?id=<?php echo $row['id'] ?>"><?php echo  $_row['autor_id'] =  utf8_encode($row['nom_autor']) . ' ' . utf8_encode($row['ape_autor']); ?></a></td>
                <td> <?php echo $_GET['lector']= utf8_encode($row['nombre']) . ' ' . utf8_encode($row['apellido']); ?> </td>
                <td><?php echo $row['ultimo_estado']?></td>
                 <?php $fechas= explode ("-",$row['fecha_ultima_modificacion']);
                 $fecha_invertida=$fechas[2]."-".$fechas[1]."-".$fechas[0]; ?>
                 <td><?php echo $fecha_invertida ?> </td>
                <td> <?php $disponibles=($row['cantidad'] - ($librosRes + $librosPres)); echo $row['cantidad'] ?> (<?php echo $disponibles ?> Disponibles - <?php echo $librosPres ?> Prestados - <?php echo $librosRes ?> Reservados )</td>
                <?php if ($row['ultimo_estado'] == "RESERVADO"){ ?>
                    <td> <a href="prestarLibros.php?libro=<?php echo $row['libroID'] ?>&usuario=<?php echo $row['lector_id']?>&idOperaciones=<?php echo $row['idOperaciones'] ?>">Prestar</a></td>
                  <?php } elseif($row['ultimo_estado'] == "PRESTADO") { ?>
                      <td> <a href="devolverLibro.php?libro=<?php echo $row['libroID'] ?>&usuario=<?php echo $row['lector_id'] ?>&idOperaciones=<?php echo $row['idOperaciones'] ?>">Devolver</a></td>
                    <?php } elseif ($row['ultimo_estado'] == "DEVUELTO") {?>

                    <?php }
                } ?>

          </tr>
        </tbody>
      </table>
  </body>
</html>
