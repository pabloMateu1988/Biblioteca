<?php
  include ('persona.php');
  $per=new persona($_POST['email'], $_POST['contraseña']);
  session_start();

  try{
    $per->existe_en_la_bd();
    }
    catch (\Exception $e) {
      $_SESSION['error']=$e->getMessage();
      header('location:iniciarSesion.php'); //Setear mensaje de error
    }

    $per->mostrarPanel();

  mysqli_free_result($result);
  mysqli_close($conexion);

 ?>
