<?php

require_once("../classes/logar.php");
require_once("../classes/conexao.php");


 
// instanciar a classe
$valide = new Logar();
$conexao = new Conexao();

//pegar conexão com banco


// validar o usuário email e senha
$valide->validarAcesso(mysqli_real_escape_string($conexao->conectar(),$_POST['email']),mysqli_real_escape_string($conexao->conectar(),$_POST['senha']));




//validar se o usuário passou pela validação
if(isset($_SESSION['id']) && isset($_SESSION['email']) && isset($_SESSION['senha'])){
    // encaminhar para tela de inicio
   header('Location: ../interface/inicio.php');
}else{
//negar acesso e enviar para a tela de login
  header('Location: ../interface/login.php?resultado='.$_SESSION['status'].'');
    }





?>