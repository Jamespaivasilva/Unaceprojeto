<?php

require_once("phpmailer/src/PHPMailer.php");
require_once("phpmailer/src/SMTP.php");
require_once("phpmailer/src/POP3.php");
require_once("phpmailer/src/Exception.php");
require_once("phpmailer/src/OAuth.php");
require_once("conexao.php");

class Convidado extends Conexao{

private $convidou;
private $convidado1;
private $data;
private $empresa;
private $cpfecnpj;
private $telefone;
private $categoria;
private $email;
    
    
    
function setConvidou($convidou){
    $this->convidou = $convidou;
}
function getConvidou(){
    return $this->convidou;
}
function setConvidado($convidado){
    $this->convidado = $convidado;
}
function getConvidado1(){
    return $this->convidado1;
}
function setConvidado1($convidado1){
    $this->convidado1= $convidado1;
}
function getConvidado(){
    return $this->convidado;
}
function setData($data){
    $this->data = $data;
}
function getData(){
    return $this->data;
}
function setEmpresa($empresa){
    $this->empresa = $empresa;
}
function getEmpresa(){
    return $this->empresa;
}
function setCpfecnpj($cpfecnpj){
    $this->cpfecnpj = $cpfecnpj;
}
function getCpfecnpj(){
    return $this->cpfecnpj;
}
function setTelefone($telefone){
    $this->telefone = $telefone;
}
function getTelefone(){
    return $this->telefone;
}
function setCategoria($categoria){
    $this->categoria = $categoria;
}
function getCategoria(){
    return $this->categoria;
}
function setEmail($email){
    $this->email = $email;
}
function getEmail(){
    return $this->email;
}

    
    
// inserir no banco.   
public function inserir($convidado,$outro){
    
    //chamar a classe que conecta com o banco de dados
     $conexao =  new Conexao();
  	 $convidou = $convidado->getConvidou();
    	 $convidado2 = $convidado->getConvidado1();
    	 $data = $convidado->getData();
     	 $empresa = $convidado->getEmpresa();
   	 $cpfecnpj = $convidado->getCpfecnpj();
    	 $telefone = $convidado->getTelefone();
         $categoria = $convidado->getCategoria();
    	 $email = $convidado->getEmail();
     
      //buscando o grupo  que o membro pertence
    $query5 = mysqli_query($conexao->conectar(),"SELECT cod_cad_grupo_empresa_grupo from membros INNER JOIN juncao_grupo_empresa on membros.cod_membro_empresa=juncao_grupo_empresa.cod_cad_grupo_empresa_empresa where repre_titular='$convidou' or repre_substituto='$convidou'") or die("deu erro1");
    
    $sql5 = mysqli_fetch_assoc($query5);
    
    $codigo_grupo = $sql5['cod_cad_grupo_empresa_grupo'];
    if($codigo_grupo==""){
	$codigo_grupo=0;
}
    
    if($outro==false){
    $query = mysqli_query($conexao->conectar(),"INSERT INTO convidados(cod_dequem_convidado_juncao,data_convidado,nome_convidado,empresa_convidado,empresa_categoria,cpf_cnpj_convidado,telefone_convidado,email_convidado,codigo_grupo) VALUES('$convidou','$data','$convidado2','$empresa','$categoria','$cpfecnpj','$telefone','$email','$codigo_grupo')")or die("deu erro2");
    }else{
       $query = mysqli_query($conexao->conectar(),"INSERT INTO convidados(cod_dequem_convidado_juncao,data_convidado,nome_convidado,empresa_convidado,empresa_categoria,outra_categoria,cpf_cnpj_convidado,telefone_convidado,email_convidado,codigo_grupo) VALUES('$convidou','$data','$convidado2','$empresa','0','$outro','$cpfecnpj','$telefone','$email','$codigo_grupo')")or die(""); 
    }
    
    
    
      $queryi = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN emails on membros.cod_membro=emails.cod_email_membro where cod_membro='$convidou'");
    
    while($sql = mysqli_fetch_array($queryi)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_membro'];
    $emailenvio=$sql['end_email'];
    $tituloemail = "Cara-a-Cara, cadastrado com sucesso!";
    $msghtmlemail="<h4>Olá sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) que sua tentativa de cadastrar um 'Convidado' foi concluída com sucesso!<br/><p><b>Informações adicionais:</b></p></br><p><b>Data e hora: </b>$date</p>";
        
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
    
    // Verificar se a query foi realizada.
     if($query==true){return true;}else{return false;}
    
    
}
    
    
    
    
    
    
    
}





?>
