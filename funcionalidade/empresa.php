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
     

 require_once("../classes/empresa.php");
 require_once("../classes/conexao.php");
 

 
 //setar dados no objeto para enviar ao método
 $empresa = new Empresa();
 //estabelecer conexão com o banco de dados
 $conexao = new Conexao();
 
 
 //Vamos retirar os caracteres especiais como -/. do CNPJ
 
 //ponto
 $cnpj = str_replace(".","",mysqli_real_escape_string($conexao->conectar(),$_POST['cnpj']));
 //barra
 $cnpj = str_replace("/","",$cnpj);
 //ifen
 $cnpj = str_replace("-","",$cnpj);

 $empresa->setNome(mysqli_real_escape_string($conexao->conectar(),$_POST['empresa'])); 
 $empresa->setCnpj($cnpj); 
 $empresa->setFundacao(mysqli_real_escape_string($conexao->conectar(),$_POST['fundacao'])); 
 $empresa->setCategoria(mysqli_real_escape_string($conexao->conectar(),$_POST['categoria'])); 
 $empresa->setDescricao(mysqli_real_escape_string($conexao->conectar(),$_POST['descricao'])); 
 $empresa->setDataunace(mysqli_real_escape_string($conexao->conectar(),$_POST['unace']));
 $empresa->setLogo($novoNome);
 
 
 
 //validar se o CNPJ existe
 $validar = $empresa->validarCNPJ(mysqli_real_escape_string($conexao->conectar(),$_POST['cnpj']));
 
 
 if($validar==true){
     header('Location: ../interface/empresa.php?resultado=fail');
 }else{
 //Inserir no banco de dados
 $resultado = $empresa->inserir($empresa);
 
 if($resultado==true){
     header('Location: ../interface/empresa.php?resultado=success');
 }
     
 }
 


 
?>