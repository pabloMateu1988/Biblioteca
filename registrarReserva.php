<?php
  session_start();
  include('conectar.php');
  $conexion=conectar();
  date_default_timezone_set('America/Lima');
  $fecha=date('Y/m/d');
  $reservado="RESERVADO";
  $prestado="PRESTADO";
  $idUsuario=$_SESSION['id'];
  $idLibro=$_GET['id'];
  $consulta="SELECT * FROM operaciones WHERE lector_id='$idUsuario' AND libros_id='$idLibro' AND (ultimo_estado='$reservado' OR ultimo_estado='$prestado')";
  echo $consulta;
  $result=mysqli_query ($conexion,$consulta);
  $true=mysqli_num_rows($result);
  $condicion=mysqli_fetch_array($result);


  if($true==0){
    $reservar="INSERT INTO operaciones (ultimo_estado,fecha_ultima_modificacion,lector_id,libros_id) VALUES ('$reservado', '$fecha', '$idUsuario', '$idLibro')";

    if(mysqli_query($conexion,$reservar)){
      $_SESSION['aviso_reserva']='RESERVA EXITOSA!';
    }
  }
  else{
      if($condicion['ultimo_estado'] == "RESERVADO"){
            //header ('location: index.php?error=ERROR! Usted ya posee una reserva vigente de este título.');
            $_SESSION['error_reserva']='ERROR! Usted ya posee una reserva vigente de este título.';


      }elseif ($condicion['ultimo_estado'] == "PRESTADO") {
              $_SESSION['error_reserva']='ERROR! Usted dispone de un ejemplar prestado.';
      }
    }
    header ('location: index.php');

 ?>
