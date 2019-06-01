<?php


require_once('../classes/conexao.php');
require_once('../classes/reuniao.php');


 $conexao = new Conexao();
 $reuniao =  new Reuniao();
 
 if($_GET['tipo']=="adm" || $_GET['tipo']=="convidado"){
 $cod_reuniao = $_GET['reuniao'];
 }
 
if($_GET['acao']=="ausenca"){
$validar = $reuniao->comunicarAusenca(mysqli_real_escape_string($conexao->conectar(),$_GET['tipo']),mysqli_real_escape_string($conexao->conectar(),$_GET['cod_participa']));
}else if($_GET['acao']=="presenca"){
$validar = $reuniao->confirmarPresenca(mysqli_real_escape_string($conexao->conectar(),$_GET['tipo']),mysqli_real_escape_string($conexao->conectar(),$_GET['cod_participa']));
}else if($_GET['acao']=="convidadoausenca"){
 $validar = $reuniao->comunicarAusenca(mysqli_real_escape_string($conexao->conectar(),$_GET['tipo']),mysqli_real_escape_string($conexao->conectar(),$_GET['cod_participa']));
}else if($_GET['acao']=="convidadopresenca"){
 $validar = $reuniao->confirmarPresenca(mysqli_real_escape_string($conexao->conectar(),$_GET['tipo']),mysqli_real_escape_string($conexao->conectar(),$_GET['cod_participa']));
}

if($validar==true){
    if($_GET['tipo']=="adm" || $_GET['tipo']=="convidado"){
    header('Location: ../interface/listareuniao.php?resultado=success&selecionado='.$cod_reuniao.'');
    }else{
     header('Location: ../interface/inicio.php');
    }
}























?>