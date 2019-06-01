<?php



// API construida para mostrar os dados no analytic valor gerado.


require_once("../classes/negocio.php");
require_once("../classes/conexao.php");


$conexao = new Conexao();
$negocio = new Negocio();


 if(isset($_GET['negocioId'])){
     //imprimir o resultado, que deve estar em json
    echo $negocio->mostrarNegocio(mysqli_real_escape_string($conexao->conectar(),$_GET['negocioId']));
     
 }else{
     echo "Não conseguimos localizar os dados do negócio";
 }




















?>