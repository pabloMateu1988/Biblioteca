<?php
include('conectar.php');


class persona {

  public $email;
  public $clave;

  public function __construct($e, $c) {
    $this->email = $e;
    $this->clave = $c;
  }


  /*public function getEmail() {
     echo $this-> $email;
  }

  public function setEmail($e) {
      $this->email = $e;
  }
  public function __getClave() {
    echo $this-> $clave;
  }

  public function setClave($c) {
      $this->clave = $c;
  }*/

  public function mostrarPanel(){
    if ((!empty($_SESSION['rol'])) && ($_SESSION['rol'] == 'BIBLIOTECARIO')) {
        header('location:bibliotecarioLoggeado.php');
    }else{
        if ((!empty($_SESSION['rol'])) && ($_SESSION['rol'] == 'LECTOR')) {
            header('location:index.php');
          }else{
            header('location:iniciarSesion.php');
          }
    }
  }

public function es_bibliotecario (){
  if ((!empty($_SESSION['rol'])) && ($_SESSION['rol'] == 'BIBLIOTECARIO')) {
    return true;
  }
  else {
    throw new Exception('No tiene permiso de bibliotecario!');
  }
}
public function es_lector (){
  if ((!empty($_SESSION['rol'])) && ($_SESSION['rol'] == 'LECTOR')) {
    return true;
  }
  else {
    throw new Exception('No tiene permiso para realizar esta accion!');
  }

}
public function existe_en_la_bd()
  {
    $conexion = conectar();
    $consulta="SELECT * FROM usuarios WHERE email='".$this->email."' and clave='".$this->clave."'";
    $result=mysqli_query($conexion,$consulta)or die(mysqli_error($consulta));
    $filas=mysqli_num_rows($result) ;
      if($filas!=0){ // NO es legible
        $usuario=mysqli_fetch_array($result);
        $_SESSION['rol']=$usuario['rol'];
        $_SESSION['nombre']=$usuario['nombre'];
        $_SESSION['apellido']=$usuario['apellido'];
        $_SESSION['email']=$usuario['email'];
        $_SESSION['id']=$usuario['id'];
      }
      else {
        throw new Exception('No existe el usuario en la base de datos!'); // La excepción queda generada por más que salga y vuelva a entrar
      }

  }

}


?>
