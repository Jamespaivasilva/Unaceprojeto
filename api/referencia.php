<?php
// API

// Essa api tem como função devolver informações sobre uma referencia, vai receber apenas o id da referencia e devolver uma referencia


//instanciar a class referência
require_once("../classes/referencia.php");
require_once("../classes/conexao.php");

// verificar se o id está sendo passado
if(isset($_GET['referenciaCode'])){
    
    $referencia = new Referencia();
    $conexao = new Conexao();
    
    echo $json_str = $referencia->consultarReferencia(mysqli_real_escape_string($conexao->conectar(),$_GET['referenciaCode']));
    
}else{
    
        echo "<h3>Não conseguimos localizar a referência, por favor verifica o codigo.</h3>";
    
    
}
















?>