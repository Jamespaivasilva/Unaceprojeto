<?php


require_once("../classes/disponibilidade.php");
require_once("../classes/conexao.php");

 $disponibilidade =  new Disponibilidade();
 $conexao =  new Conexao();
 
 $disponibilidade ->setEndereco(mysqli_real_escape_string($conexao->conectar(),$_POST['endereco']));
 $disponibilidade ->setData(mysqli_real_escape_string($conexao->conectar(),$_POST['data']));
 $disponibilidade ->setInicial(mysqli_real_escape_string($conexao->conectar(),$_POST['inicial']));
 $disponibilidade ->setFim(mysqli_real_escape_string($conexao->conectar(),$_POST['final']));


// validar se não está sendo agendado no sabado ou domingo
 $semana = $disponibilidade->semana(mysqli_real_escape_string($conexao->conectar()
,$_POST['data']));




if($semana!="Sabado" && $semana!="Domingo"){

// Validar se não há duplicidade
$valida=$disponibilidade->validarExiste(mysqli_real_escape_string($conexao->conectar()
,$_POST['data']),mysqli_real_escape_string($conexao->conectar()
,$_POST['inicial']),mysqli_real_escape_string($conexao->conectar()
,$_POST['final']));

if($valida==true){
  header('Location: ../interface/disponibilidade.php?resultado=fail');
    
}else{
    

$resultado=$disponibilidade->inserir($disponibilidade);

if($resultado==true){
    header('Location: ../interface/disponibilidade.php?resultado=success');
    
}

}

}else{
    header('Location: ../interface/disponibilidade.php?resultado=semana');
}




?>