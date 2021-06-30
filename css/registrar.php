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
        <img id="logo" src="img/logo-biblioteca.png">
      </div>
    </div>
    <h1 class="titulos">Registro de Lector</h1>
    <div class="registro">
      <form class="registro" action="usuarioLoggeado.php"  onsubmit="return validarVaciosRegistrar()" method="post">
        <fieldset>
          Nombre: <input type="text" id="nombre" value=""> <br><br>
          Apellido: <input type="text" id="apellido" value=""> <br><br>
          Foto: <input type="file" id="foto" value=""> <br><br>
          Email: <input type="text" id="email" value=""> <br><br>
          Clave: <input type="password" id="clave" > <br><br>
          Confirmación de la clave: <input type="password" id="confirmacion" ><br><br>
          <button id="boton_registrar" type="submit">Registrarse</button>

        </fieldset>

      </form>


    </div>
  </body>
</html>
