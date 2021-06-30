<?php
  session_start();
  if (empty($_SESSION['rol']) || (!empty($_SESSION['rol']) && $_SESSION['rol'] == "BIBLIOTECARIO")) {
    $_SESSION['error']= "NO PUEDE ACCEDER A ESTA PAGINA SI NO ES UN LECTOR";
    header('location:iniciarSesion.php');
  }
  include('conectar.php');

  $conexion = conectar();
  $busqueda= "SELECT libros.*, autores.apellido, autores.nombre, autores.id as id_autor FROM libros INNER JOIN autores ON (libros.autores_id = autores.id) WHERE 1=1  ";
  $titulo="";
  $autor="";

  if(!empty($_GET['titulo'])){
    $titulo=$_GET['titulo'];
    $busqueda=$busqueda. "AND libros.titulo like '%" .$titulo. "%'";
  }
  if(!empty($_GET['autor'])){
    $autor=$_GET['autor'];
    $busqueda=$busqueda."AND concat_ws(' ',autores.nombre,autores.apellido) like '%" .$autor. "%'";
  }
  if(empty($_GET['numero_pagina'])){
    $num_pagina=1;
  }
  else {
    $num_pagina=$_GET['numero_pagina'];
  }
  $busqueda=$busqueda."ORDER BY titulo ASC";
  $result= mysqli_query($conexion, $busqueda);
  $cant_libros= $result->num_rows;
  $cant_de_pagina=0;
  $url= $_SERVER["REQUEST_URI"];


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
      <div  id="sesion">
        <a href="perfil.php">Usuario Loggeado:<?php echo $_SESSION['nombre'] . ' '?><?php echo $_SESSION['apellido']?></a> ||
        <a href="cerrar_sesion.php">Cerrar Sesión</a>
      </div>
      <div id="buscador">
        <h4 id="refinarbusqueda">Refinar Busqueda</h4>
        <form action="usuarioLoggeado.php">
          Titulo:<input type="search" name="titulo"><br><br>
          Autor:<input type="search" name="autor">
          <button>Buscar</button>
        </form>
  		</div>
      <div>
        <a href="index.php">  <img id="logo" src="img/logo-biblioteca.png"></a>
      </div>
    </div>
    <h1 class="titulos">Catálogos de Libros</h1>
    <?php
      if($cant_libros!=0) // Si hay libros creo la grilla
        {
    ?>
    <div>
      <table border="1px">
        <thead>
          <tr>
            <th>Portada</th>
            <th>Titulo</a></th>
            <th>Autor</a></th>
            <th>Ejemplares</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <?php
        }
        else{ // Si no hay liros lo notifico
          if((empty($_GET['titulo']))  && (empty($_GET['autor']))) { // No existen libros en la base de datos
            ?>
            <html>
              <h3><center>No existen libros en la base de datos.</h3>
            </html>
            <?php
          }
          else{ // No existen resultados para la busqueda
          ?>
          <html>
            <h3><center>Ningún libro coincide con sus parámetros de búsqueda...</h3>
          </html>
        <?php
          }
        }
          $inicio = ($num_pagina - 1) * 5;

          $query1= $busqueda." LIMIT $inicio, 5";
          $result= mysqli_query($conexion, $query1);

            while (($row=mysqli_fetch_array($result)) && ($cant_de_pagina < ($num_pagina * 5))  )  {
              $cant_de_pagina++;
          ?>
              <html>
        		  <tr>
        			     <td class="portada"><img src="mostrarImagenPortada.php?id_libro=<?php echo $row['id'] ?>" class="portada"></td>
                   <td><a href="titulo.php?id=<?php echo $row['id'] ?>"><?php echo $row['titulo']; ?></a></td>
                   <td><a href="index.php?autor=<?php echo $row['nombre']?> <?php echo $row['apellido'] ?>"><?php echo $row['nombre'] . ' ' . $row['apellido']; ?> </a></td>
                   <td> <?php echo $row['cantidad'] ?> (2 Disponibles - 3 Prestados - 0 Reservados )</td>
                   <td><a href="usuarioLoggeado.php">Reservar</a></td>
        		  </tr>
              </html>
          <?php
              }
           ?>
          <html>
        </tbody>
      </table>
    </div>

  </body>
</html>
<?php
$cant_paginas=intdiv($cant_libros,5);
if ($cant_libros % 5 > 0 ){
  $cant_paginas++;
}
if ($cant_paginas > 1){
?>
  <div class="container" align="center">
<?php
      for ($i=1;$i<=$cant_paginas;$i++){
          if ($num_pagina == $i){ //si muestro el índice de la página actual, no coloco enlace
            ?>
              <font face="arial" color="#FE2E2E">
                  <big>
                    <?php
                      echo $num_pagina . " "
                    ?>
                  </big>
              </font>
            <?php
          }else{//si indice es distinto de pagina, coloco el enlace
            ?>
              <font face="arial" color="#FE2E2E">
                <?php
                  $pos=strpos($url,"numero_pagina");
                  if(!($pos == false)) //Se detecta si el link actual ya contiene un numero de página
                  {
                    $url2=str_replace($_GET['numero_pagina'],$i,$url); //Se toma ese link y se intercambia el N° de página actual por el N° de página del link
                  }
                  else {
                    $pos2=strpos($url,"?");
                    if($pos2 == false) //Se detecta si el link actual ya contiene el "?"
                      { // El link no contiene el simbolo  "?"
                             $url2=$url."?numero_pagina=$i";
                      }
                    else { // El link ya contiene el simbolo  "?"
                            $url2=$url."&numero_pagina=$i";
                    }
                  }
                ?>
                    <big>
                      <?php
                        echo "<a style=color:#070000; href='$url2'> $i </a> "
                      ?>



            </html>
                    </big>
                </font>
<?php
          }
      }
?>
  </div>
<?php
}
