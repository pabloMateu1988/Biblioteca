<?php
function isValidPassword($pass,&$error,$min){
		if(!empty($pass)){
			if(strlen($pass)>=$min){
				if((preg_match('/[a-z]/',$pass)) && (preg_match('/[A-Z]/',$pass)) && (preg_match('/[^a-z]/i',$pass))){
					$error="";
					return true;
				}else{
					$error="La contraseña debe contener mayusculas, minisculas y al menos un numero o caracter especial";
				}
			}else{
				$error="La contraseña debe tener al menos ".$min." caracteres";
			}
		}else{
			$error="Ingresar contraseña";
		}
		return false;
	}
?>
