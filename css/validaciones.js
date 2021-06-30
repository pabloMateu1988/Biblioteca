  function validarVaciosIniciar(){
    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var email = document.getElementById('input_dir_correo').value;
    if((document.getElementById('input_dir_correo').value.length == 0) || (document.getElementById('input_contrasena').value.length == 0 )) {
      alert('Complete todos los campos!');
      return false;
    }
    if ( !expr.test(email) ){
        alert("Error: La dirección de correo es incorrecta.");
        return false;
    }
  }

  function validarVaciosRegistrar(){
    var expr_mail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    //var expr_nom_ap = /^([a-z])$;
  //  var apellido= document.getElementById("apellido").value;
  //  var apellido= document.getElementById("nombre").value;
    var email = document.getElementById('email').value;
    if((document.getElementById('nombre').value.length == 0) || (document.getElementById('apellido').value.length == 0 ) || (document.getElementById('foto').value.length == 0) || (document.getElementById('email').value.length == 0)
    || (document.getElementById('clave').value.length == 0) || (document.getElementById('confirmacion').value.length == 0)) {
      alert('Complete todos los campos!');
      return false;
    }
    if(document.getElementById('clave').value != document.getElementById('confirmacion').value){
            alert('Las claves no coinciden');
            return false;
    }
    if ( !expr_mail.test(email) ){
        alert("Error: La dirección de correo es incorrecta.");
        return false;
    }
  //  if(!expr_nom_ap.test(nombre)){
      //  alert("Error: El nombre debe del usuario debe contener sólo letras!.");
        //retrun false;
  //  }
    //if(!expr_nom_ap.test(apellido)){
      //  alert("Error: El apellido del usuario debe contener sólo letras!.");
      //  retrun false;
    }

    }
