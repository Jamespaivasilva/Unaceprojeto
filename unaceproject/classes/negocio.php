<?php

require_once("phpmailer/src/PHPMailer.php");
require_once("phpmailer/src/SMTP.php");
require_once("phpmailer/src/POP3.php");
require_once("phpmailer/src/Exception.php");
require_once("phpmailer/src/OAuth.php");


require_once("conexao.php");


class Negocio{
    
  private $cadastrou;
  private $obrigado;
  private $data;
  private $negocio;
  private $referencia;
  private $gerou;
  private $empresa;
  private $comentario;
  
  
  function setObrigado($obrigado){
      $this-> obrigado = $obrigado;
  }
  function getObrigado(){
      return $this->obrigado;
  }
  function setData($data){
      $this->data=$data;
  }
  function getData(){
      return $this->data;
  }
  function setNegocio($negocio){
      $this->negocio=$negocio;
  }
  function getNegocio(){
      return $this->negocio;
  }
  function setReferencia($referencia){
      $this->referencia=$referencia;
  }
  function getReferencia(){
      return $this->referencia;
  }
  function setGerou($gerou){
      $this->gerou=$gerou;
  }
  function getGerou(){
      return $this->gerou;
  }
  function setCadastrou($cadastrou){
      $this->cadastrou=$cadastrou;
  }
  function getCadastrou(){
      return $this->cadastrou;
  }
  function setEmpresa($empresa){
      $this->empresa=$empresa;
  }
  function getEmpresa(){
      return $this->empresa;
  }
  function setComentario($comentario){
      $this->comentario=$comentario;
  }
  function getComentario(){
      return $this->comentario;
  }
  
 
 
 //API mostrar informações, para o analytics
 
 public function mostrarNegocio($negocioId){
     
     $conexao = new Conexao();
     
     $query = mysqli_query($conexao->conectar(),"SELECT distinct mem.cod_membro_empresa,cod_empresa,comentarios_negocio,mem.nome_membro obrigado,membro.nome_membro iniciou,membro.cod_membro cod_iniciou,data_negocio,valor_negocio,tipo_referencia,tipo_negocio,comentarios_negocio FROM negocios
	INNER JOIN membros as mem on negocios.cod_membro_obrigado=mem.cod_membro 
	INNER JOIN membros as membro on negocios.cod_iniciou=membro.cod_membro
	INNER JOIN empresas on mem.cod_membro_empresa=empresas.cod_empresa 
	where cod_negocio='$negocioId'");
     
     $sql = mysqli_fetch_assoc($query);
     $cod_empresa =$sql['cod_empresa'];
     $id_membro =$sql['cod_iniciou'];

    $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa
    INNER JOIN grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo=grupos.cod_grupo 
    where cod_cad_grupo_empresa_empresa='$cod_empresa' and repre_titular='$id_membro' || repre_substituto='$id_membro'");

     $sql2 = mysqli_fetch_assoc($query2);

      $json = array(
          "obrigado" => $sql['obrigado'],
          "iniciou" => $sql['iniciou'],
          "data_negocio" => $sql['data_negocio'],
          "tipo_referencia" => $sql['tipo_referencia'],
          "tipo_negocio" => $sql['tipo_negocio'],
          "comentarios_negocio" => $sql['comentarios_negocio'],
          "grupo" => $sql2['nome_grupo']
          );
          
          return json_encode($json);
     
 }
 
 
 public function inserir($negocio1){
    
     $cadastrou = $negocio1->getCadastrou();
     $obrigado = $negocio1->getObrigado();
     $data = $negocio1->getData();
     $negocio = $negocio1->getNegocio();
     $referencia = $negocio1->getReferencia();
     $gerou = $negocio1->getGerou();
     $empresa = $negocio1->getEmpresa();
     $comentario = $negocio1->getComentario();
     
     
    //pegar a data e a hora atual para inserir na tabela contribuição
     date_default_timezone_set('America/Sao_Paulo');
    $data4 = date('Y-m-d H:i');
    
    
    //estabelecer conexão
    $conexao = new Conexao();
    
      $mysqli = new mysqli("35.199.110.234","unace", "james56118992", "u253536359_nuwe") or die ("deu erro");
    
     //buscando o grupo  que o membro pertence
    $query5 = mysqli_query($mysqli,"SELECT cod_cad_grupo_empresa_grupo from membros INNER JOIN juncao_grupo_empresa on membros.cod_membro_empresa=juncao_grupo_empresa.cod_cad_grupo_empresa_empresa where cod_membro='$cadastrou'") or die("deu erro");
    
    $sql5 = mysqli_fetch_assoc($query5);
    
    $codigo_grupo = $sql5['cod_cad_grupo_empresa_grupo'];
    
    
    // inserindo na tabela contribuição
    $query= mysqli_query($mysqli,"INSERT INTO contribuicoes(cod_empresa_juncao_contribuicao,data) VALUES ('$empresa','$data4')") or die("deu erro1");
    
    $cod_contribuicoes = mysqli_insert_id($mysqli);
    
    
    // se a primeira query der certo, roda o codigo abaixo
    if($query==true){
    
    //inserir na tabela cara_cara
    $query2 = mysqli_query($mysqli,"INSERT INTO negocios(cod_contribuicao,cod_membro_obrigado,cod_iniciou,data_negocio,valor_negocio,tipo_referencia,tipo_negocio,comentarios_negocio,codigo_grupo) VALUES ('$cod_contribuicoes','$obrigado','$cadastrou','$data','$gerou','$referencia','$negocio','$comentario','$codigo_grupo')") or die(mysqli_error($mysqli));
    
    $cod_negocio = mysqli_insert_id($mysqli);
    
    
    //aplicar pontuação
     $data5 =  date('Y-m-d');
     
    $verifica = mysqli_query($mysqli,"SELECT * FROM referencias where cod_para_referencia_juncao='$obrigado' and gerou_pontuacao<>1");
    
    $num = mysqli_num_rows($verifica);
    if($num!=0){
        
    while($sql = mysqli_fetch_array($verifica)){
        $referenciou = $sql['cod_membro_referenciou'];
        $cod_referencia = $sql['cod_referencia'];
        
     $query8 = mysqli_query($mysqli,"UPDATE referencias set gerou_pontuacao=1 where cod_referencia='$cod_referencia'") or die(mysqli_error($mysqli));      
 
     //inserir a pontuação no banco de quem referenciou o membro que está fazendo sua contribuição
     $query5 = mysqli_query($mysqli,"INSERT INTO pontuacao(valor,data_pontuacao,membro_pontuador,tipo,cod_tipo,cod_donegocio,codigo_grupo) VALUES ('1','$data5','$referenciou','4','$cod_referencia','$cod_negocio','$codigo_grupo')") or die(mysqli_error($mysqli));
     
    
        
    }
    
    }
    
    
    //inserir a pontuação no banco para quem cadastrou
    // $query5 = mysqli_query($mysqli,"INSERT INTO pontuacao(valor,data_pontuacao,membro_pontuador,tipo,cod_tipo) VALUES ('1','$data5','$cadastrou','3','$cod_negocio')") or die//(mysqli_error($mysqli));
    
    
    }
    
    $queryi = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN emails on membros.cod_membro=emails.cod_email_membro where cod_membro='$cadastrou'");
    
    while($sql = mysqli_fetch_array($queryi)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_membro'];
    $emailenvio=$sql['end_email'];
    $tituloemail = "Negocio fechado, cadastrado com sucesso!";
    $msghtmlemail="<h4>Olá sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) que sua tentativa de cadastrar um 'Negócio fechado' foi concluída com sucesso!<br/><p><b>Informações adicionais:</b></p></br><p><b>Data e hora: </b>$date</p>";
        
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
    
     //se as duas forem positivas, devolve true senão false
     if($query==true && $query2==true){return true;}else{return false;}
     
     }
    
    
    
}








?>
