<?php
if (isset($_POST['submit'])){
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	$nome=$_POST['nome'];
	$email=$_POST['email'];
	$assunto=$_POST['assunto'];
	$mensagem=$_POST['mensagem'];
	
	
	function validaEmail($mail){
	if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $mail)) {
		return true;
	}else{
		return false;
	}
	}
	if(validaEmail($email)==true){
		mail("thesyncim@gmail.com",$assunto,$mensagem);
		}
	header('Location:contactos.html');
	
	
}

?>
