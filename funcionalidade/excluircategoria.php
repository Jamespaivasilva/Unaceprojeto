<?php



// Vamos excluir uma categoria de acordo com o ID passado, esse request vem da pagina "Gerenciar categorias".


require_once("../classes/conexao.php");
require_once("../classes/categoria.php");


$conexao = new Conexao();
$categoria = new Categoria();


if(isset($_GET['categoriaId'])){
    if($categoria->excluirCategoria(mysqli_real_escape_string($conexao->conectar(),$_GET['categoriaId']))){
       header('Location: ../interface/gerenciarcategorias.php?resultado=success'); 
    }else{
       header('Location: ../interface/gerenciarcategorias.php?resultado=fail'); 
    }

}else{
    header('Location: ../interface/gerenciarcategorias.php?resultado=fail');
}























?>