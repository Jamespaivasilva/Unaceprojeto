<?php

require_once("../classes/referencia.php");
require_once("../classes/conexao.php");

$referencia =  new Referencia();
$conexao = new Conexao();

$para1 = $_POST['quem'];



// Tratar casos em que checkbox e radio não foram selecionados
if(!isset($_POST['referencia'])){
    $referencia1=" ";
}
if(isset($_POST['referencia'])){
    $referencia1=$_POST['referencia'];
}

if(!isset($_POST['potencial'])){
    $potencial=" ";
}
if(isset($_POST['potencial'])){
    $potencial=$_POST['potencial'];
}
if(!isset($_POST['liga'])){
    $liga ="N";
}
if(isset($_POST['liga'])){
    $liga =$_POST['liga'];
}
if(!isset($_POST['cartao'])){
    $cartao ="N";
}
if(isset($_POST['cartao'])){
    $cartao =$_POST['cartao'];
}




// Fazer uma pesquisa no banco sobre o id da empresa pertecente ao membro que recebeu indicação
$query = mysqli_query($conexao->conectar(),"SELECT * FROM membros where cod_membro='$para1'");
$sql = mysqli_fetch_assoc($query);
$empresa = $sql['cod_membro_empresa'];

 $_POST['local'];
echo $_POST['estabelecimento'];
$referencia->setRegistrou(mysqli_real_escape_string($conexao->conectar(),$_POST['registrou']));
$referencia->setPara(mysqli_real_escape_string($conexao->conectar(),$_POST['quem']));
$referencia->setEstabelecimento(mysqli_real_escape_string($conexao->conectar(),$_POST['estabelecimento']));
$referencia->setReferencia1(mysqli_real_escape_string($conexao->conectar(),$referencia1));
$referencia->setCartao(mysqli_real_escape_string($conexao->conectar(), $cartao));
$referencia->setLiga(mysqli_real_escape_string($conexao->conectar(), $liga));
$referencia->setDdd(mysqli_real_escape_string($conexao->conectar(),$_POST['ddd']));
$referencia->setNumero1(mysqli_real_escape_string($conexao->conectar(),$_POST['numero1']));
$referencia->setTipo(mysqli_real_escape_string($conexao->conectar(),$_POST['tipo']));
$referencia->setEmail(mysqli_real_escape_string($conexao->conectar(),$_POST['email']));
$referencia->setComentario(mysqli_real_escape_string($conexao->conectar(),$_POST['comentario']));
$referencia->setPotencial(mysqli_real_escape_string($conexao->conectar(),$potencial));
//$referencia->setBairro(mysqli_real_escape_string($conexao->conectar(),$_POST['bairro']));
//$referencia->setRua(mysqli_real_escape_string($conexao->conectar(),$_POST['rua']));
//$referencia->setCep(mysqli_real_escape_string($conexao->conectar(),$_POST['cep']));
$referencia->setEmpresa(mysqli_real_escape_string($conexao->conectar(),$empresa));
$referencia->setCategoria(mysqli_real_escape_string($conexao->conectar(),$_POST['categoria']));
$referencia->setEndereco1($_POST['local']);
$referencia->setData(mysqli_real_escape_string($conexao->conectar(),$_POST['data']));
//Outra categoria
if(isset($_POST['outro'])){
$outra= mysqli_real_escape_string($conexao->conectar(),$_POST['outro']);
}else{
 $outra= mysqli_real_escape_string($conexao->conectar(),"");   
}
//$referencia->setNumero(mysqli_real_escape_string($conexao->conectar(),$_POST['numero']));
//$referencia->setCidade(mysqli_real_escape_string($conexao->conectar(),$_POST['cidade']));
//$referencia->setEstado(mysqli_real_escape_string($conexao->conectar(),$_POST['estado']));
//$referencia->setComplemento(mysqli_real_escape_string($conexao->conectar(),$_POST['complemento']));




$resultado = $referencia->inserir($referencia,$outra);

if($resultado){
    echo "<script>window.location.assign('../interface/referencia.php?resultado=success')</script>";
  //header('Location: ../interface/referencia.php?resultado=success');
}










?>
