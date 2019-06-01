<?php

require_once('../classes/conexao.php');
require_once('../classes/categoria.php');


$conexao = new Conexao();
$categoria = new Categoria();


$categoria->setPrimeira(mysqli_real_escape_string($conexao->conectar(),$_POST['primeira']));
$categoria->setSegunda(mysqli_real_escape_string($conexao->conectar(),$_POST['segunda']));


if($categoria->editarCategoria($_POST['categoriaId'],$categoria)){
    header('Location: ../interface/gerenciarcategorias.php?resultado=success');
}else{
    header('Location: ../interface/gerenciarcategorias.php?resultado=fail');
}

















?>