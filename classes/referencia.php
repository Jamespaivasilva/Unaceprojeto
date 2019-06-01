<?php
require_once("phpmailer/src/PHPMailer.php");
require_once("phpmailer/src/SMTP.php");
require_once("phpmailer/src/POP3.php");
require_once("phpmailer/src/Exception.php");
require_once("phpmailer/src/OAuth.php");
require_once("endereco.php");
require_once("conexao.php");

class Referencia extends Endereco{
    

private $registrou;
private $para;
private $estabelecimento;
private $referencia1;
private $cartao;
private $liga;
private $ddd;
private $numero1;
private $tipo;
private $email;
private $comentario;
private $empresa;
private $potencial;
private $data;
private $endereco1;
private $categoria;
private $outra;




function setRegistrou($registrou){
    $this->registrou=$registrou;
}
function getRegistrou(){
    return $this->registrou;
}
function setPara($para){
    $this->para=$para;
}
function getPara(){
    return $this->para;
}
function setEstabelecimento($estabelecimento){
    $this->estabelecimento=$estabelecimento;
}
function getEstabelecimento(){
    return $this->estabelecimento;
}
function setReferencia1($referencia1){
    $this->referencia1=$referencia1;
}
function getReferencia1(){
    return $this->referencia1;
}
function setCartao($cartao){
    $this->cartao=$cartao;
}
function getCartao(){
   return $this->cartao;
}
function setLiga($liga){
    $this->liga=$liga;
}
function getLiga(){
    return $this->liga;
}
function setDdd($ddd){
    $this->ddd=$ddd;
}
function getDdd(){
   return $this->ddd;
}
function setTipo($tipo){
    $this->tipo=$tipo;
}
function getTipo(){
   return $this->tipo;
}
function setNumero1($numero1){
    $this->numero1=$numero1;
}
function getNumero1(){
   return $this->numero1;
}
function setEmail($email){
    $this->email=$email;
}
function getEmail(){
   return $this->email;
}
function setComentario($comentario){
    $this->comentario=$comentario;
}
function getComentario(){
   return $this->comentario;
}
function setEmpresa($empresa){
    $this->empresa=$empresa;
}
function getEmpresa(){
   return $this->empresa;
}
function setPotencial($potencial){
    $this->potencial=$potencial;
}
function getPotencial(){
   return $this->potencial;
}
function setData($data){
    $this->data=$data;
}
function getData(){
   return $this->data;
}
function setEndereco1($endereco1){
    $this->endereco1=$endereco1;
}
function getEndereco1(){
   return $this->endereco1;
}
function setCategoria($categoria){
    $this->categoria=$categoria;
}
function getCategoria(){
    return $this->categoria;
}
function setOutra($outra){
    $this->outra=$outra;
}
function getOutra(){
    return $this->outra;
}
function setEmpresaoupessoa($empresaoupessoa){
    $this->empresaoupessoa=$empresaoupessoa;
}
function getEmpresaoupessoa(){
    return $this->empresaoupessoa;
}


//Metodo para consultar dados de uma refência(uma utilização é para abrir o molde na parte de valor gerado individual).
//API
public function consultarReferencia($referenciaId){
    
    //conectar ao banco classe conexão
    $conexao = new Conexao();
    
    $query =  mysqli_query($conexao->conectar(),"SELECT DISTINCT mem.cod_membro_empresa,membro.cod_membro_empresa,cod_empresa,membro.cod_membro cod_iniciou, mem.nome_membro membro ,membro.nome_membro nome_membro,data_referencia,tipo_referencia,cartao,suspect_endereco_referencia,liga,suspect_email_referencia,suspect_potencial_referencia,suspect_comentarios_referencia FROM referencias 
INNER JOIN membros as membro on referencias.cod_para_referencia_juncao=membro.cod_membro 
INNER JOIN membros as mem on referencias.cod_membro_referenciou=mem.cod_membro 
INNER JOIN empresas on mem.cod_membro_empresa=empresas.cod_empresa 
 where cod_referencia='$referenciaId'");
    
    $sql = mysqli_fetch_assoc($query);
    
    $cod_empresa =$sql['cod_empresa'];
     $id_membro =$sql['cod_iniciou'];

    $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa
    INNER JOIN grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo=grupos.cod_grupo 
    where  repre_titular='$id_membro' || repre_substituto='$id_membro'");

     $sql2 = mysqli_fetch_assoc($query2);

    $json = array(
    "para" => $sql['nome_membro'],
    "membro" => $sql['membro'],
    "data"=>str_replace('-','/',date('d/m/Y', strtotime($sql['data_referencia']))),
    "referencia" => $sql['tipo_referencia'],
    "cartao"=>$sql['cartao'],
    "endereco"=>$sql['suspect_endereco_referencia'],
    "liga"=>$sql['liga'],
    "email"=>$sql['suspect_email_referencia'],
    "comentario"=>$sql['suspect_comentarios_referencia'],
    "potencial"=>$sql['suspect_potencial_referencia'],
    "grupo"=>$sql2['nome_grupo']
    );
    
    
    
 
    //transforma a string em um array associativo
    // $json_arr = json_decode($json_str);
    
    return json_encode($json);
    
    
}
      
 
// Inserir os dados pelo o formulário
public function inserir($referencia,$outra){
    
     $registrou = $referencia->getRegistrou();
     $para = $referencia->getPara();
     $data = $referencia->getData();
     $estabelecimento = $referencia->getEstabelecimento();
     $referencia1 = $referencia->getReferencia1();
     $cartao = $referencia->getCartao();
     $liga = $referencia->getLiga();
     $ddd = $referencia->getDdd();
     $numero1 = $referencia->getNumero1();
     $tipo = $referencia->getTipo();
     $email = $referencia->getEmail();
     $comentario = $referencia->getComentario();
     //Dados desativado a pedido dos stakeholders
     //$rua = $referencia->getRua();
     //$bairro = $referencia->getBairro();
     //$numero = $referencia->getNumero();
     //$cep = $referencia->getCep();
     //$complemento = $referencia->getComplemento();
     //$cidade = $referencia->getCidade();
     //$estado = $referencia->getEstado();
     $empresa = $referencia->getEmpresa();
     $potencial = $referencia->getPotencial();
     $endereco = $referencia->getEndereco1();
     $categoria = $referencia->getCategoria();
    
     //Outra categoria
     
     
     
     //$reuniao = $referencia ->getReuniao();
     //$cod_endereco =$referencia->getEndereco();
    //pegar a hora atual
     date_default_timezone_set('America/Sao_Paulo');
    $data4 = date('Y-m-d H:i');
    
    
    //estabelecer conexão
    $conexao = new Conexao();
    
     $mysqli = new mysqli("35.199.110.234","unace", "james56118992", "u253536359_nuwe") or die ("deu erro");
    
    
     //buscando o grupo  que o membro pertence
    $query5 = mysqli_query($mysqli,"SELECT cod_cad_grupo_empresa_grupo from membros INNER JOIN juncao_grupo_empresa on membros.cod_membro_empresa=juncao_grupo_empresa.cod_cad_grupo_empresa_empresa where cod_membro='$registrou'") or die("deu erro");
    $sql5 = mysqli_fetch_assoc($query5);
    $codigo_grupo = $sql5['cod_cad_grupo_empresa_grupo'];
    
    ////////////
    
    // inserindo na tabela contribuição
    $query= mysqli_query($mysqli,"INSERT INTO contribuicoes(cod_empresa_juncao_contribuicao,data) VALUES ('$empresa','$data4')") or die(mysqli_error($mysqli));
    $cod_contribuicoes = mysqli_insert_id($mysqli);
    
    if($query==true){
     //Endereço desativado a pedido dos stakeholders, inves ficou apenas um campo onde pode ser descrito o local.
     
    //$query2 = mysqli_query($mysqli,"INSERT INTO endereco(descricao,cep,rua,bairro,numero,complemento,tipo,cidade,estado) VALUES ('$empresa','$cep','$rua','$bairro','$numero'//,'$complemento','4','$cidade','$estado')") or die(mysqli_error($mysqli));
     //$cod_endereco = mysqli_insert_id($mysqli);
    
    //juntando o telefone
    $telefone = "".$ddd."".$numero1;
    
    if($categoria!="outro"){
    //inserir na tabela referência
    $query3 = mysqli_query($mysqli,"INSERT INTO referencias(cod_membro_referenciou,cod_para_referencia_juncao,data_referencia,tipo_referencia,cartao,liga,suspect_empresa_pessoa,suspect_endereco_referencia,suspect_categoria_referencia,suspect_telefone_referencia,suspect_email_referencia,suspect_comentarios_referencia,suspect_potencial_referencia,codigo_grupo) VALUES ('$registrou','$para','$data','$referencia1','$cartao','$liga','$estabelecimento','$endereco','$categoria','$telefone','$email','$comentario','$potencial','$codigo_grupo')") or die(mysqli_error($mysqli));
        $cod_referencia = mysqli_insert_id($mysqli);
    }else{
         //inserir na tabela referência
    $query3 = mysqli_query($mysqli,"INSERT INTO referencias(cod_membro_referenciou,cod_para_referencia_juncao,data_referencia,tipo_referencia,cartao,liga,suspect_empresa_pessoa,suspect_endereco_referencia,suspect_categoria_referencia,outra_categoria,suspect_telefone_referencia,suspect_email_referencia,suspect_comentarios_referencia,suspect_potencial_referencia,codigo_grupo) VALUES ('$registrou','$para','$data','$referencia1','$cartao','$liga','$estabelecimento','$endereco','0','$outra','$telefone','$email','$comentario','$potencial','$codigo_grupo')") or die(mysqli_error($mysqli));
        $cod_referencia = mysqli_insert_id($mysqli);
    }
    
    //aplicar pontuação
    
     $data5 =  date('Y-m-d');
    //inserir a pontuação no banco
     $query5 = mysqli_query($mysqli,"INSERT INTO pontuacao(valor,data_pontuacao,membro_pontuador,tipo,cod_tipo,codigo_grupo) VALUES ('1','$data5','$registrou','2','0','$codigo_grupo')") or die(mysqli_error($mysqli));
    
        
    }
    
    
    $queryi = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN emails on membros.cod_membro=emails.cod_email_membro where cod_membro='$registrou'");
    
    while($sql = mysqli_fetch_array($queryi)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_membro'];
    $emailenvio=$sql['end_email'];
    $tituloemail = "Referência qualificada, cadastrado com sucesso!";
    $msghtmlemail="<h4>Olá sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) que sua tentativa de cadastrar uma 'Referência qualificada' foi concluída com sucesso!<br/><p><b>Informações adicionais:</b></p></br><p><b>Data e hora: </b>$date</p>";
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP(); 
        $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = 587; // TLS only
        $mail->SMTPSecure = 'tls'; // ssl is depracated
        $mail->SMTPAuth = true;
        $mail->Username = 'suporteunace@gmail.com';
        $mail->Password = 'unace2019';
        $mail->setFrom('unacesuporte@gmail.com', 'Suporte Unace');
        $mail->addAddress($emailenvio, $nomeemail);
        $mail->Subject = $tituloemail;
        $mail->msgHTML($msghtmlemail); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        $mail->AltBody = 'HTML messaging not supported';
        // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
        //enviar o e-mail
        $mail->send();

    }
    
     //validar se as query foram bem sucedidas 
     if($query==true && $query3==true && $query5==true){return true;}else{return false;}
     
     }
     
 


}





?>
