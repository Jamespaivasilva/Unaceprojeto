<?php


require_once('../classes/categoria.php');

//API para poder mostrar os dados da categoria para fazer a edição no gerenciamento de categoria


$categoria = new Categoria();


if(isset($_GET['categoriaId'])){

echo $categoria->mostrarCategoria($_GET['categoriaId']);

}else{
    echo "Não encontramos o conteúdo pelo id informado";
}

























?>