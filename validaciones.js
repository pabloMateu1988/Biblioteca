
  const expr_mail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  const expr_texto = /^[a-zA-Z\s]+$/;
  const exp_clave_sin_digitos = /^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{6,35}$/;
  const exp_clave_sin_caracesp = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,35}$/;

  function validarVaciosIniciar(){
    var email = document.getElementById('input_dir_correo').value;
    var contrasena = document.getElementById('input_contrasena').value;

    if((email.length == 0) || (contrasena.length == 0 )) {
      alert('Complete todos los campos!');
      return false;
    }
    if ( !expr_mail.test(email) ){
      alert('Error: La dirección de correo es incorrecta');
      return false;
    }
  }

 function validarVaciosRegistrar(){

      var email = document.getElementById('email').value;
      var apellido = document.getElementById('apellido').value;
      var nombre = document.getElementById('nombre').value;
      var clave = document.getElementById('clave').value;
      var foto = document.getElementById('foto').value;
      var separador=".";
      var extension = (foto.split(separador)[(foto.split(separador)).length -1 ]).toLowerCase();//

      if((document.getElementById('nombre').value.length == 0) || (document.getElementById('apellido').value.length == 0 ) || (document.getElementById('foto').value.length == 0) || (document.getElementById('email').value.length == 0)
      || (document.getElementById('clave').value.length == 0) || (document.getElementById('confirmacion').value.length == 0)) {
        alert('Complete todos los campos!');
        console.log("asdas");
        return false;
      }
      if( document.getElementById('clave').value != document.getElementById('confirmacion').value){
          alert('Las claves no coinciden');
          return false;
      }
      if ( !expr_mail.test(email) ){
          alert("Error: La dirección de correo es incorrecta.");
          return false;
      }
      if ( !expr_texto.test(nombre) ){
          alert("Error: El nombre del usuario debe contener sólo letras!");
          return false;
      }
      if ( !expr_texto.test(apellido) ){
          alert("Error: El apellido del usuario debe contener sólo letras!");
          return false;
      }

      //Detecta el tamaño mínimo de clave de 6 caracteres, la presencia de una mayúscula, una minúscula y un número o caracter esepcial
      if ( !((exp_clave_sin_digitos.test(clave)) || (exp_clave_sin_caracesp.test(clave)) )) {
        alert("Error: La clave debe tener letras mayúsculas y minúsculas, números o algún caracter especial y una longitud mínima de 6 caracteres!");
        return false;
      }
      //Detecta que la extension de la imagen sea de los tipos expuestos

      if (! ( ( extension.indexOf("jpeg") > -1 ) || ( extension.indexOf("png") > -1 ) || ( extension.indexOf("jpg") > -1) ) ) {
        alert("Error: La extensión de la imagen debe ser de los tipos permitidos JPG, JPEG, o PNG!");
        return false;
      }

  }
