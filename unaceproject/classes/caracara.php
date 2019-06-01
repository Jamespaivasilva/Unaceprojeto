<?php

require_once("phpmailer/src/PHPMailer.php");
require_once("phpmailer/src/SMTP.php");
require_once("phpmailer/src/POP3.php");
require_once("phpmailer/src/Exception.php");
require_once("phpmailer/src/OAuth.php");
require_once("endereco.php");
require_once("conexao.php");

class Caracara extends Endereco{


private $quem;
private $data;
private $conversa;
private $empresa;
private $iniciou;
private $endereco1;



  function setQuem($quem){
        $this -> quem = $quem;
    }
  function getQuem(){
        return $this -> quem;
    }
 
  function setConversa($conversa){
        $this -> conversa = $conversa;
    }
  function getConversa(){
        return $this -> conversa;
    }
  function setData($data){
        $this -> data = $data;
    }
  function getData(){
        return $this -> data;
    }
 function setEmpresa($empresa){
        $this -> empresa = $empresa;
    }
 function getEmpresa(){
        return $this -> empresa;
    }
 function setIniciou($iniciou){
     $this->iniciou = $iniciou;
 }
 function getIniciou(){
     return $this->iniciou;
 }
 function setEndereco1($endereco1){
    $this->endereco1=$endereco1;
}
function getEndereco1(){
   return $this->endereco1;
}



//API, mostrar dados do caracara, serve para poder abrir um modal com a conversa, no analytics
public function mostrarCaracara($caracaraId){
    
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM CARA_CARA where cod_cara='$caracaraId'");
    $sql = mysqli_fetch_assoc($query);
    
    $json = array(
        "conversa"=>$sql['conversa_cara']
        );
        
        
        return json_encode($json);
}


// inserir através do formulário os dados de um caracara
public function inserir($caracara){
    
     $quem = $caracara->getQuem();
     $data = $caracara->getData();
     $conversa = $caracara->getConversa();
    // $rua = $caracara->getRua();
    // $bairro = $caracara->getBairro();
    // $numero = $caracara->getNumero();
     //$cep = $caracara->getCep();
     //$complemento = $caracara->getComplemento();
    // $cidade = $caracara->getCidade();
    // $estado = $caracara->getEstado();
     $empresa = $caracara->getEmpresa();
     $iniciou = $caracara->getIniciou();
     $endereco1 = $caracara->getEndereco1();
     
     //$reuniao = $caracara ->getReuniao();
     //$cod_endereco =$caracara->getEndereco();
    //pegar a hora atual
     date_default_timezone_set('America/Sao_Paulo');
    $data4 = date('Y-m-d H:i');
    $data2 = date('Y-m-d');
    
    //estabelecer conexão
    $conexao = new Conexao();
    
     $mysqli = new mysqli("35.199.110.234","unace", "james56118992", "u253536359_nuwe") or die ("deu erro");
    
    
    //buscando o grupo  que o membro pertence
    $query5 = mysqli_query($mysqli,"SELECT cod_cad_grupo_empresa_grupo from membros INNER JOIN juncao_grupo_empresa on membros.cod_membro_empresa=juncao_grupo_empresa.cod_cad_grupo_empresa_empresa where cod_membro='$iniciou'") or die("deu erro");
    
    $sql5 = mysqli_fetch_assoc($query5);
    
    $codigo_grupo = $sql5['cod_cad_grupo_empresa_grupo'];
    
    
    // inserindo na tabela contribuição
    $query= mysqli_query($mysqli,"INSERT INTO contribuicoes(cod_empresa_juncao_contribuicao,data) VALUES ('$empresa','$data4')") or die("deu erro1");
    
    $cod_contribuicoes = mysqli_insert_id($mysqli);
    
    if($query==true){
    //$query2 = mysqli_query($mysqli,"INSERT INTO endereco(descricao,cep,rua,bairro,numero,complemento,tipo,cidade,estado) VALUES ('$quem','$cep','$rua','$bairro','$numero','$complemento'//,'3','$cidade','$estado')") or die("deu erro");
    
    //$cod_endereco = mysqli_insert_id($mysqli);
    

    //inserir na tabela cara_cara
    $query3 = mysqli_query($mysqli,"INSERT INTO CARA_CARA(cod_cara_contribuicao,cod_iniciou,cod_comquem_cara,data_cara,endereco_cara,conversa_cara,codigo_grupo) VALUES ('$cod_contribuicoes','$iniciou','$quem','$data','$endereco1','$conversa','$codigo_grupo')") or die(mysqli_error($mysqli));
    
    $cod_caracara = mysqli_insert_id($mysqli);
    
    //aplicar pontuação
     $data5 =  date('Y-m-d');
    

    
    
    
    //inserir a pontuação no banco
     $query5 = mysqli_query($mysqli,"INSERT INTO pontuacao(valor,data_pontuacao,membro_pontuador,tipo,cod_tipo,codigo_grupo) VALUES ('1','$data5','$iniciou','1','$cod_caracara','$codigo_grupo')") or die(mysqli_error($mysqli));
    
    }
    
    $queryi = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN emails on membros.cod_membro=emails.cod_email_membro where cod_membro='$iniciou'");
    
    while($sql = mysqli_fetch_array($queryi)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_membro'];
    $emailenvio=$sql['end_email'];
    $tituloemail = "Cara-a-Cara, cadastrado com sucesso!";
    $msghtmlemail="<h4>Olá sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) que sua tentativa de cadastrar um 'Cara-a-Cara' foi concluída com sucesso!<br/><p><b>Informações adicionais:</b></p></br><p><b>Data e hora: </b>$date</p>";
        
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
    
    
    
     
     if($query==true && $query3==true){return true;}else{return false;}
     
     }
    
    
}




?>
