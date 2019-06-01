<?php
$novoNome="";
//tratar foto
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
        $destino = '../interface/fotos/'.$novoNome;
 
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
    

require_once("../classes/conexao.php");
require_once('../classes/membro.php');


//estabelecer conexão com o banco de dados
$conexao = new Conexao();


//tratar a data de validade
$validade="";

if($_POST['validade']=="6"){
$data = date('Y-m-d'); 
$validade = date('Y/m/d', strtotime("+180 days",strtotime($data))); 
}
else if($_POST['validade']=="4"){
$data = date('Y-m-d'); 
$validade = date('Y/m/d', strtotime("+30 days",strtotime($data))); 
}
else if($_POST['validade']=="1"){
$data = date('Y-m-d'); 
$validade = date('Y/m/d', strtotime("+365 days",strtotime($data))); 
}else if($_POST['validade']=="2"){
$data = date('Y-m-d'); 
$validade = date('Y/m/d', strtotime("+730 days",strtotime($data))); 
}
else if($_POST['validade']=="5"){
$data = date('Y-m-d'); 
$validade = date('Y/m/d', strtotime("+1825 days",strtotime($data))); 
}

// tratar os caracteres especiais do cpf
//ponto
$cpf = str_replace(".","",mysqli_real_escape_string($conexao->conectar(),$_POST['cpf']));

//traço
$cpf = str_replace("-","",$cpf);


 // setar dados no objeto e encaminhar ao método
 $membro = new Membro();

 $membro->setCpf($cpf);
 $membro->setNome(mysqli_real_escape_string($conexao->conectar(),$_POST['nome']));
 $membro->setSenha(trim(password_hash($_POST['senha'], PASSWORD_BCRYPT, [12])));
 $membro->setUsuario(mysqli_real_escape_string($conexao->conectar(),$_POST['usuario']));
 $membro->setAniversario(mysqli_real_escape_string($conexao->conectar(),$_POST['nascimento']));
 $membro->setNivel(mysqli_real_escape_string($conexao->conectar(),$_POST['nivel']));
 $membro->setFoto($novoNome);
 $membro->setPapel(mysqli_real_escape_string($conexao->conectar(),$_POST['papel']));
 $membro->setCod_empresa(mysqli_real_escape_string($conexao->conectar(),$_POST['empresa']));
 $membro->setDdd($_POST['ddd']);
 $membro->setEmail($_POST['email']);
 $membro->setNumero2($_POST['numero']);
 $membro->setTipo($_POST['tipo']);
 $membro->setCep(mysqli_real_escape_string($conexao->conectar(),$_POST['cep']));
 $membro->setBairro(mysqli_real_escape_string($conexao->conectar(),$_POST['bairro']));
 $membro->setRua(mysqli_real_escape_string($conexao->conectar(),$_POST['rua']));
 $membro->setNumero(mysqli_real_escape_string($conexao->conectar(),$_POST['numero2']));
 $membro->setCidade(mysqli_real_escape_string($conexao->conectar(),$_POST['cidade']));
 $membro->setEstado(mysqli_real_escape_string($conexao->conectar(),$_POST['estado']));
 $membro->setComplemento(mysqli_real_escape_string($conexao->conectar(),$_POST['complemento']));
 $membro->setExpira($validade);
 
 
 

 
 //valida se o usuario já existe
 $valida2 = $membro->validarUsuario(mysqli_real_escape_string($conexao->conectar(),$_POST['usuario']));
 
 // testa a resposta se usuario existe
 if($valida2==true){
    header('Location: ../interface/membro.php?resultado=usuario'); 
}else{
//valida se o cpf já existe
$valida = $membro->validarCPF($cpf);

//teste se existe
if($valida==true){
  header('Location: ../interface/membro.php?resultado=fail');
 
}else{
//inseri no banco
$resultado=$membro->inserir($membro);

//testa se foi inserido
if($resultado==true){
     header('Location: ../interface/membro.php?resultado=success');
 }

}   


}

?>
