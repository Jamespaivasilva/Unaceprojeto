<?php




require_once("../classes/conexao.php");
require_once("../classes/grupo.php");

$conexao = new Conexao();
$grupo = new Grupo();


if(isset($_GET['grupoId'])){
echo $grupo->mostrarGrupo($_GET['grupoId']);
}else{
    echo "Não conseguimos localizar os dados pelo id passado.";
}





















?>