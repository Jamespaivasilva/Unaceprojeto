<?php

$novoNome="";
//tratar logo
if ( isset( $_FILES[ 'arquivo' ][ 'name' ] ) && $_FILES[ 'arquivo' ][ 'error' ] == 0 ) {
    //echo 'Você enviou o arquivo: <strong>' . $_FILES[ 'arquivo' ][ 'name' ] . '</strong><br />';
    //echo 'Este arquivo é do tipo: <strong > ' . $_FILES[ 'arquivo' ][ 'type' ] . ' </strong ><br />';
    //echo 'Temporáriamente foi salvo em: <strong>' . $_FILES[ 'arquivo' ][ 'tmp_name' ] . '</strong><br />';
    //echo 'Seu tamanho é: <strong>' . $_FILES[ 'arquivo' ][ 'size' ] . '</strong> Bytes<br /><br />';
 
    $arquivo_tmp = $_FILES[ 'arquivo' ][ 'tmp_name' ];
    $nome = $_FILES[ 'arquivo' ][ 'name' ];
 
    // Pega a extensão
    $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
 
    // Converte a extensão para minúsculo
    $extensao = strtolower ( $extensao );
 
    // Somente imagens, .jpg;.jpeg;.gif;.png
    // Aqui eu enfileiro as extensões permitidas e separo por ';'
    // Isso serve apenas para eu poder pesquisar dentro desta String
    if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {
        // Cria um nome único para esta imagem
        // Evita que duplique as imagens no servidor.
        // Evita nomes com acentos, espaços e caracteres não alfanuméricos
        $novoNome = uniqid ( time () ) . '.' . $extensao;
        // Concatena a pasta com o nome
        $destino = '../interface/logos/'.$novoNome;
 
        // tenta mover o arquivo para o destino
        if ( @move_uploaded_file ( $arquivo_tmp, $destino ) ) {
             'Arquivo salvo com sucesso em : <strong>' . $destino . '</strong><br />';
             ' < img src = "' . $destino . '" />';
        }
        else
             'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
    }
    else
         'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br />';
}
else
     'Você não enviou nenhum arquivo!';



require_once('../classes/conexao.php');
require_once('../classes/empresa.php');

$conexao = new Conexao();
$empresa = new Empresa();


//verificar se o logo foi inserido

if($novoNome==""){
    $novoNome=false;
}


//Verificar se a empresa já possui uma categoria
if(isset($_POST['categoriaatual']) && $_POST['categoriaatual']!=NULL && $_POST['categoriaatual']!=""){
    //Se sim, vamos verificar se foi solicitado uma mudança.
    if($_POST['categoriaatual']!=$_POST['categoria']){
        $categoria=$_POST['categoria'];
    }else{
        //Mudar sinal para função que existe um valor de categoria, mas esse valor já era existente anteriormente
        $categoria=false;
    }

//Se a categoria atual estiver não estiver ocupada, vamos verificar se o usuário está tentando adicionar uma categoria.
}else if(isset($_POST['categoria']) && $_POST['categoria']!=NULL && $_POST['categoria']!=""){
    $categoria=$_POST['categoria'];
}else{
    $categoria=false;
}


//Vamos tratar os -,. e / do CNPJ
//ponto
 $cnpj = str_replace(".","",mysqli_real_escape_string($conexao->conectar(),$_POST['cnpj']));
 //barra
 $cnpj = str_replace("/","",$cnpj);
 //ifen
 $cnpj = str_replace("-","",$cnpj);
 //possiveis espaços
 $cnpj = str_replace(" ","",$cnpj);


$empresa->setCnpj($cnpj);
$empresa->setCategoria(mysqli_real_escape_string($conexao->conectar(),$categoria));
$empresa->setDescricao(mysqli_real_escape_string($conexao->conectar(),$_POST['descricao']));
$empresa->setFundacao(mysqli_real_escape_string($conexao->conectar(),$_POST['data']));
$empresa->setNome(mysqli_real_escape_string($conexao->conectar(),$_POST['nome']));
$empresa->setLogo($novoNome);


$verificar = $empresa->mudarEmpresa(mysqli_real_escape_string($conexao->conectar(),$_POST['empresa']),$empresa);

if($verificar)
header('Location: ../interface/gerenciarempresas.php?resultado=success');
else
header('Location: ../interface/gerenciarempresas.php?resultado=fail');















?>