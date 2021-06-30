<?php
  session_start();

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <script src="validaciones.js" type="text/javascript" ></script>
  </head>
  <body>
    <div  id="header">
      <div>
        <a href="index.php">  <img id="logo" src="img/logo-biblioteca.png"></a>
      </div>
    </div>
    <h1 class="titulos">Registro de Lector</h1>
    <div class="registro">
      <form class="registro" action="insertarRegistro.php"  onsubmit="return validarVaciosRegistrar()" method="post" enctype="multipart/form-data">
        <fieldset>
          <label class="msjErrorCampos"><?php if (isset($_SESSION['$error'])) {echo $_SESSION['$error']; $_SESSION['$error']=null;}?></label> <br><br>
          Nombre: <input type="text" id="nombre" name="nombre" value="<?php echo (isset($_SESSION['nombre_fallido']))?  $_SESSION['nombre_fallido']:''; $_SESSION['nombre_fallido']=null;?>">
          </label><br><br>
          Apellido: <input type="text" id="apellido" name="apellido" value="<?php echo (isset($_SESSION['apellido_fallido']))?  $_SESSION['apellido_fallido']:''; $_SESSION['apellido_fallido']=null;?>">
         </label><br><br>
          Foto: <input type="file" id="foto" name="foto">
         </label> <br><br>
          Email: <input type="text" id="email" name="email" value="<?php echo (isset($_SESSION['email_fallido']))?  $_SESSION['email_fallido']:'';  $_SESSION['email_fallido']=null;?>">
          </label><br><br>
          Clave: <input type="password" id="clave"  name="clave" >
          </label><br><br>
          Confirmación de la clave: <input type="password" id="confirmacion" name="confirmacion" >
          </label><br><br>
          <button id="boton_registrar" type="submit">Registrarse</button>

        </fieldset>

      </form>
    </div>
  </body>
</html>
