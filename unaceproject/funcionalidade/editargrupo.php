<?php


require_once('../classes/conexao.php');
require_once('../classes/grupo.php');


$conexao = new Conexao();
$grupo = new Grupo();



$grupo->setNome(mysqli_real_escape_string($conexao->conectar(),$_POST['nome']));
$grupo->setFundacao(mysqli_real_escape_string($conexao->conectar(),$_POST['fundacao']));


if($grupo->mudarGrupo(mysqli_real_escape_string($conexao->conectar(),$_POST['cod_grupo']),$grupo))
 header('Location: ../interface/gerenciargrupos.php?resultado=success');
else
 header('Location: ../interface/gerenciargrupos.php?resultado=fail');




























?>