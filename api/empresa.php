<?php



require_once('../classes/empresa.php');
require_once('../classes/conexao.php');



$conexao = new Conexao();
$empresa = new Empresa();

if(isset($_GET['empresaId'])){
    
echo $empresa->mostrarEmpresa(mysqli_real_escape_string($conexao->conectar(),$_GET['empresaId']));
    
}else{
    echo "Dados não encontrado";
}






















?>