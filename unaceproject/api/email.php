<?php


// API para mostrar um especifico e-mail, de acordo com o id passado, usado na pagina 'minhaconta'


require_once('../classes/conexao.php');
require_once('../classes/membro.php');

$conexao = new Conexao();
$membro = new Membro();


if(isset($_GET['emailId'])){
    echo $membro->mostrarEmail(mysqli_real_escape_string($conexao->conectar(),$_GET['emailId'])); 
}else{
    echo "E-mail não encontrado.";
}





?>