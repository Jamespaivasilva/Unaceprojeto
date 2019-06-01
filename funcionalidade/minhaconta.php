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

//estabelecer conexão com o banco de dados
$conexao = new Conexao();

$options = [
  'cost'  =>10,
    
];

$cod_membro =  mysqli_real_escape_string($conexao->conectar(),$_POST['membro']);
$nome = mysqli_real_escape_string($conexao->conectar(),$_POST['nome']);
$cpf = mysqli_real_escape_string($conexao->conectar(),$_POST['cpf']);
$nascimento = mysqli_real_escape_string($conexao->conectar(),$_POST['nascimento']);
//$empresa = mysqli_real_escape_string($conexao->conectar(),$_POST['empresa']);
//$papel = mysqli_real_escape_string($conexao->conectar(),$_POST['papel']);
$ddd = mysqli_real_escape_string($conexao->conectar(),$_POST['ddd']);
$numero = mysqli_real_escape_string($conexao->conectar(),$_POST['numero']);
$tipo = mysqli_real_escape_string($conexao->conectar(),$_POST['tipo']);
$email = mysqli_real_escape_string($conexao->conectar(),$_POST['email']);
$usuario = mysqli_real_escape_string($conexao->conectar(),$_POST['usuario']);
$cep = mysqli_real_escape_string($conexao->conectar(),$_POST['cep']);
$rua = mysqli_real_escape_string($conexao->conectar(),$_POST['rua']);
$bairro = mysqli_real_escape_string($conexao->conectar(),$_POST['bairro']);
$cidade = mysqli_real_escape_string($conexao->conectar(),$_POST['cidade']);
$estado = mysqli_real_escape_string($conexao->conectar(),$_POST['estado']);
$complemento = mysqli_real_escape_string($conexao->conectar(),$_POST['complemento']);
$numero2 = mysqli_real_escape_string($conexao->conectar(),$_POST['numero2']);
$endereco = mysqli_real_escape_string($conexao->conectar(),$_POST['endereco']);



require_once('../classes/membro.php');
 // setar dados no objeto e encaminhar ao método
 $membro = new Membro();
 
 if($_POST['senha']==null ||$_POST['senha']=="" ){
     $senha = 1;
 }else{
     $senha = $_POST['senha'];
 }
 
 if($_POST['nova']==null ||$_POST['nova']==""){
     $nova = 1;
 }else{
     $nova = trim(password_hash($_POST['nova'], PASSWORD_BCRYPT, [12]));
 }
 
 if($novoNome=="" || $novoNome==null){
     $foto = mysqli_real_escape_string($conexao->conectar(),$_POST['foto2']);
 }else{
     $foto = mysqli_real_escape_string($conexao->conectar(),$novoNome);
 }
 
 

 $membro->setCpf($cpf);
 $membro->setNome($nome);
 $membro->setSenha($senha);
 $membro->setNova($nova);
 $membro->setUsuario($usuario);
 $membro->setAniversario($nascimento);
 $membro->setFoto($foto);
 $membro->setDdd($ddd);
 $membro->setEmail($email);
 $membro->setNumero2($numero2);
 $membro->setTipo($tipo);
 $membro->setCep($cep);
 $membro->setBairro($bairro);
 $membro->setRua($rua);
 $membro->setNumero($numero);
 $membro->setCidade($cidade);
 $membro->setEstado($estado);
 $membro->setCod_membro($cod_membro);
 $membro->setComplemento($complemento);
 $membro->setCod_endereco($endereco);
 
 


$validar4 = $membro->validarSenha($usuario,$senha);




$resultado=$membro->mudar($membro,$validar4);

//testa se foi alterado
if($resultado==true && $validar4==true){
   header('Location: ../interface/minhaconta.php?resultado=success');
 }


else if($resultado==true && $validar4==false && $nova!=1){
   header('Location: ../interface/minhaconta.php?resultado=fail');
    
}else{
    header('Location: ../interface/minhaconta.php?resultado=success');
}


?>
