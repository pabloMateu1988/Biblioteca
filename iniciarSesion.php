<?php
	session_start();
	include('conectar.php');
	$conexion=conectar();

?>

<html>
	<head>
    	<title>Inicio de sesión</title>
    	<LINK href="./css/styles.css" rel="stylesheet" type="text/css">
				<script src="validaciones.js" type="text/javascript">
				</script>
  	</head>
  	<body>
  		<div id="header" >
				<div>
	        <a href="index.php">  <img id="logo" src="img/logo-biblioteca.png"></a>
	      </div>
			</div>
     	<div class="inicio">
				<?php if(isset($_SESSION['error'])){ ?>
					<html><label id="msjErrorReservas"><?php echo $_SESSION['error']; ?></label></html>
			<?php	} ?>
				<?php
					$_SESSION['error']=null; // Una vez mostrado el mensaje de error se limpia la variable
				?>

        		<h4>Inicio de sesión</h4>
        		<form action="validarInicioSesion.php" onsubmit="return validarVaciosIniciar()" method="post">
          			Dirección de correo: <br> <input id="input_dir_correo" type="text" name="email" size = "30"><br><br>
          			Contraseña: <br> <input id="input_contrasena" type="password" name="contraseña" ><br><br>
          			<div>
          				<br> <button id="boton_iniciar" type="submit">Iniciar sesión</button>
          			</div>
        		</form>
  		</div>

    </body>
</html>
