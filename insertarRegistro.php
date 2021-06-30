<?php
session_start();


$exp_clave_sin_digitos = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,35}$/";
$exp_clave_sin_caracesp = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,35}$/";

include("conectar.php");
$conexion=conectar();


$email=$_POST['email'];
$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$clave=$_POST['clave'];
$clave2=$_POST['confirmacion'];
$tipoFoto = $_FILES['foto']['type'];
$foto= $_FILES['foto']['tmp_name'];
$imgContent = addslashes(file_get_contents($foto));
$buscarCorreo="SELECT email FROM usuarios WHERE email='$email'";
$result=mysqli_query($conexion,$buscarCorreo);
$jpg= "image/jpeg";
$jpeg= "image/jpg";
$png= "image/png";
$_SESSION['$error']="";


if ($nombre == "" or $apellido == "" or $email == "" or $foto == "" or $clave == "" or $clave2 == "") {
        $_SESSION['$error'] =$_SESSION['$error']."Completar Campos";
        header('location:registrar.php');
}
else{
  if (!preg_match("/^[ a-zA-Z]+$/",$nombre)){
    $_SESSION['$error'] =$_SESSION['$error'].  "<br>Error: El nombre del usuario debe contener sólo letras!";
    header('location:registrar.php');
  }
  if (!preg_match("/^[ a-zA-Z]+$/",$apellido)) {
    $_SESSION['$error'] =$_SESSION['$error'].  "<br>Error: El apellido del usuario debe contener sólo letras!";
    header('location:registrar.php');
  }
  if (!preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/",$email)) {
    $_SESSION['$error'] = $_SESSION['$error']. "<br>Error: La dirección de correo es incorrecta";
    header('location:registrar.php');
  }
  if (!(preg_match($exp_clave_sin_caracesp,$clave) || preg_match($exp_clave_sin_digitos,$clave))) {
    $_SESSION['$error'] = $_SESSION['$error']."<br>";
    $_SESSION['$error'] =$_SESSION['$error']. "Error: La clave es incorrecta";
    header ('location: registrar.php');
  }
  if (!($tipoFoto == "image/jpg" or $tipoFoto == "image/jpeg" or $tipoFoto == "image/png")) {
    $_SESSION['$error'] = $_SESSION['$error']."<br>";
    $_SESSION['$error'] = $_SESSION['$error']."Error: La extension de la imagen es incorrecta ";
    header ('location: registrar.php');
  }
  if ($clave != $clave2) {
    $_SESSION['$error'] = $_SESSION['$error']."<br>";
    $_SESSION['$error'] = $_SESSION['$error']."<br> Error: Las claves no coinciden";
    header('location:registrar.php');
  }
 if (mysqli_num_rows($result)) {
  $_SESSION['$error'] = $_SESSION['$error']."<br>";
  $_SESSION['$error'] = $_SESSION['$error']. "Error: El correo ya existe";
  header('location:registrar.php');
  }
}
if (strlen($_SESSION['$error']) == 0 ){
  $insertar="INSERT INTO usuarios(email,nombre,apellido,foto,clave) VALUES ('$email','$nombre','$apellido','$imgContent','$clave')";
  if(mysqli_query($conexion,$insertar)){
    session_destroy();
    header ('location: index.php');
    session_start();
    $_SESSION['$registro']="Registro exitoso! Inicie sesión para acceder al sistema";

  }
  else{
    header ('location: registrar.php');
  }
}
else{
    $_SESSION['email_fallido']=trim($email);
    $_SESSION['nombre_fallido']=trim($nombre);
    $_SESSION['apellido_fallido']=trim($apellido);
  }
mysqli_close($conexion);
?>
