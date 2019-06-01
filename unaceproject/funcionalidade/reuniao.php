<?php


require_once("../classes/reuniao.php");
require_once("../classes/conexao.php");

 $reuniao =  new Reuniao();
 $conexao =  new Conexao();
 
 $reuniao ->setTitulo(mysqli_real_escape_string($conexao->conectar(),$_POST['titulo']));
 $reuniao ->setGrupo(mysqli_real_escape_string($conexao->conectar(),$_POST['grupo']));
 $reuniao ->setEndereco(mysqli_real_escape_string($conexao->conectar(),$_POST['endereco']));
 $reuniao ->setDisponibilidade(mysqli_real_escape_string($conexao->conectar(),$_POST['disponibilidade']));




$resultado=$reuniao->inserir($reuniao);

if($resultado==true){
    
    echo "<script>window.location.assign('../interface/reuniao.php?resultado=success')</script>";
    //header('Location: ../interface/reuniao.php?resultado=success');
    
}




?>