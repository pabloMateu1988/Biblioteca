<?php
  session_start();
  include('conectar.php');

  $conexion = conectar();
  $busqueda= "SELECT libros.*, autores.apellido, autores.nombre, autores.id as id_autor FROM libros INNER JOIN autores ON (libros.autores_id = autores.id) WHERE 1=1  ";
  $titulo="";
  $autor="";
  if(!empty($_GET['titulo'])){
    $titulo=$_GET['titulo'];
    $busqueda=$busqueda. "AND libros.titulo like '%" .utf8_decode($titulo). "%'";
  }
  if(!empty($_GET['autor'])){
    $autor=$_GET['autor'];
    $busqueda=$busqueda."AND concat_ws(' ',autores.nombre,autores.apellido) like '%" .utf8_decode($autor). "%'";
  }
  if(empty($_GET['numero_pagina'])){
    $num_pagina=1;
  }
  else {
    $num_pagina=$_GET['numero_pagina'];
  }
  $busqueda=$busqueda."ORDER BY titulo ASC";
  $result= mysqli_query($conexion, $busqueda);
  $cant_libros= mysqli_num_rows($result);
  $cant_de_pagina=0;
  $url= $_SERVER["REQUEST_URI"];
  if (isset($_SESSION['id'])) { //Es para que no me salga el siguiente error cuando cierro sesion: Notice: Undefined index: id in C:\xampp\htdocs\Biblioteca\index.php on line 28
    $consulta="SELECT ultimo_estado, lector_id FROM operaciones WHERE lector_id='".$_SESSION['id']."'AND ultimo_estado='RESERVADO'";//Consulta para saber los libros reservados y prestados del lector
    $reservas=mysqli_query($conexion,$consulta);
    $reservasLector=mysqli_num_rows($reservas);
    $consulta2="SELECT ultimo_estado, lector_id FROM operaciones WHERE lector_id='".$_SESSION['id']."'AND ultimo_estado='PRESTADO'";
    $prestados=mysqli_query($conexion,$consulta2);
    $prestadosLector=mysqli_num_rows($prestados);
  }


 ?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Biblioteca</title>
    <LINK href="css/styles.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div  id="header">
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
              <a href="cerrar_sesion.php">Cerrar Sesión</a>
            <?php }?>
            <?php if ($_SESSION['rol'] == 'BIBLIOTECARIO') {?>
                <a href="bibliotecarioLoggeado.php">Listado de operaciones  ||</a>
                <a href="">Bibliotecario Loggeado: <?php echo $_SESSION['nombre'] . ' '?><?php echo $_SESSION['apellido']?></a> ||
                <a href="cerrar_sesion.php">Cerrar Sesión</a>
            <?php  } ?>


        <?php
            }
        ?>

        </div>
      <fieldset id="buscador">
        <legend>Refinar Busqueda</legend>
        <form action="index.php" method="GET">
          Titulo:<input type="search" name="titulo" value= "<?php echo $titulo ?>"><br><br>
          Autor:<input type="search" name="autor" value="<?php echo $autor ?>">
          <button>Buscar</button>
        </form>
  		</fieldset>
      <div>
        <a href="index.php"><img id="logo" src="img/logo-biblioteca.png"></a>
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
          			<th>Título</th>
          			<th>Autor</th>
          			<th>Ejemplares</th>
                <?php
                if(!empty($_SESSION['rol']) && $_SESSION['rol']=='LECTOR' && ($reservasLector+$prestadosLector) < 3){
                ?>
                    <th>Acción</th>
                    <?php
                }
                ?>
          		 </tr>
        		  </thead>
              <tbody>
          <?php
        }
        else{ // Si no hay liros lo notifico
          if((empty($_GET['titulo']))  && (empty($_GET['autor']))) { // No existen libros en la base de datos
            ?>
              <h3><center>No existen libros en la base de datos.</h3>
            <?php
          }
          else{ // No existen resultados para la busqueda
          ?>

            <h3><center>Ningún libro coincide con sus parámetros de búsqueda...</h3>
        <?php
          }
        }
         if (isset($_SESSION['rol']) && $_SESSION['rol']=="LECTOR" && ($reservasLector+$prestadosLector) == 3) {
           ?>
           <h3 style=color:#FF0000;><center>Usted ha alcanzado el número máximo de libros prestados o reservados, retorne alguno de sus prestamos o cancele una reserva vigente para poder realizar una nueva reserva.</h3>
             <?php
         }
          $inicio = ($num_pagina - 1) * 5;

          $query1= $busqueda." LIMIT $inicio, 5";
          $result= mysqli_query($conexion, $query1);

          if (isset($_SESSION['aviso_reserva'])) {
            ?>
             <h3 style=color:#00FF00;><center><?php echo $_SESSION['aviso_reserva'] ?></h3>
               <?php
            $_SESSION['aviso_reserva']=null;
          }
          if (isset($_SESSION['error_reserva'])) {
            ?>
             <h3 style=color:#FF0000;><center><?php echo $_SESSION['error_reserva'] ?></h3>
               <?php
            $_SESSION['error_reserva']=null;
          }
          if (isset($_SESSION['$registro'])) {
            ?>
            <h3 style=color:#00FF00;><center><?php echo $_SESSION['$registro'] ?></h3>
              <?php
            $_SESSION['$registro']=null;
          }
            while (($row=mysqli_fetch_array($result)) && ($cant_de_pagina < ($num_pagina * 5))  )  {
              $cant_de_pagina++;
              $consulta2="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['id']."'AND ultimo_estado='RESERVADO'";//Consulta para hacer la operacion de cantidad de libros disponibles
              $librosReservados=mysqli_query($conexion,$consulta2);
              $librosRes=mysqli_num_rows($librosReservados);
              $consulta3="SELECT ultimo_estado,libros_id FROM operaciones WHERE libros_id='".$row['id']."'AND ultimo_estado='PRESTADO'";
              $librosPrestados=mysqli_query($conexion,$consulta3);
              $librosPres=mysqli_num_rows($librosPrestados);
          ?>

        		  <tr>
        			     <td class="portada"><img src="mostrarImagenPortada.php?id_libro=<?php echo $row['id'] ?>" class="portada"></td>
                   <td><a href="titulo.php?id=<?php echo $row['id'] ?>"><?php echo utf8_encode($row['titulo']); ?></a></td>
                   <td><a href="libros_de_autor.php?autor=<?php echo $row['id_autor'] ?>"><?php echo utf8_encode($row['nombre']) . ' ' . utf8_encode($row['apellido']); ?> </a></td>
                   <td> <?php  $disponibles=($row['cantidad'] - ($librosRes + $librosPres));  ?> (<?php echo $disponibles ?> Disponibles - <?php echo $librosPres ?> Prestados - <?php echo $librosRes ?> Reservados )</td>
                   <?php
                   if (isset($_SESSION['rol']) && $_SESSION['rol']=="LECTOR" && ($reservasLector+$prestadosLector) < 3) {//Chequea la cantidad de libros reservados y prestados que tiene el lector y deshabilita columna
                   ?>
                       <td><?php
                              if(($disponibles=($row['cantidad'] - ($librosRes + $librosPres))) > 0){//Chequea los libros disponibles y habilita el boton reservar?>
                                    <input type="button" value="Reservar" onClick="location.href='registrarReserva.php?id=<?php echo $row['id']?>'">
                              <?php
                            }else {
                              ?>
                              <a id="noEjemplares"> No hay ejemplares disponibles </a>
                              <?php
                            }
                      }
                    ?>

        		  </tr>

          <?php
              }

           ?>

  		  </tbody>
  		</table>
    </div>
        <?php
        $cant_paginas=intdiv($cant_libros,5);
        if ($cant_libros % 5 > 0 ){
          $cant_paginas++;
        }
        if ($cant_paginas > 0){
        ?>
        	<div class="container">
        <?php
	            for ($i=1;$i<=$cant_paginas;$i++){
	                if ($num_pagina == $i){ //si muestro el índice de la página actual, no coloco enlace
                    ?>
	                    <font id="indice">
	                        <big>
	                        	<?php
	                        		echo $num_pagina . " "
	                        	?>
	                        </big>
	                    </font>
                    <?php
	                }else{//si indice es distinto de pagina, coloco el enlace
                    ?>
		                	<font id="indice">
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




		                        </big>
		                    </font>
<?php
	                }
	            }
?>
        	</div>
          </html>
<?php

        }
