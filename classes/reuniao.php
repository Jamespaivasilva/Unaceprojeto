<?php

require_once("phpmailer/src/PHPMailer.php");
require_once("phpmailer/src/SMTP.php");
require_once("phpmailer/src/POP3.php");
require_once("phpmailer/src/Exception.php");
require_once("phpmailer/src/OAuth.php");
require_once("conexao.php");

class Reuniao{
    
 private $titulo;
 private $grupo;
 private $endereco;
 private $disponibilidade;


function setTitulo($titulo){
        $this -> titulo = $titulo;
    }
 function getTitulo(){
        return $this -> titulo;
    } 
    
function setGrupo($grupo){
        $this -> grupo= $grupo;
    }
 function getGrupo(){
        return $this -> grupo;
    }  
    
function setEndereco($endereco){
        $this -> endereco = $endereco;
    }
 function getEndereco(){
        return $this -> endereco;
    }  
function setDisponibilidade($disponibilidade){
        $this -> disponibilidade = $disponibilidade;
    }
 function getDisponibilidade(){
        return $this -> disponibilidade;
    }  
    


//confirmar presença de membro e  adm

public function confirmarPresenca($tipo,$cod_participa){
    $conexao =  new Conexao();

    if($tipo=="membro")
    $query = mysqli_query($conexao->conectar(),"UPDATE participa_reuniao SET conf_membro='1' WHERE cod_participa='$cod_participa'"); 
    else if($tipo=="adm")
    $query = mysqli_query($conexao->conectar(),"UPDATE participa_reuniao SET conf_adm='1' WHERE cod_participa='$cod_participa'"); 
    else if($tipo=="convidado")
    $query = mysqli_query($conexao->conectar(),"UPDATE convidados SET conf_presenca='1' where cod_convidado='$cod_participa'");
    
    
    if($query==true){
    return true;
    }
    
}

//comunicar a ausencia 
public function comunicarAusenca($tipo,$cod_participa){
    $conexao =  new Conexao();
    
    if($tipo=="membro")
    $query = mysqli_query($conexao->conectar(),"UPDATE participa_reuniao SET conf_membro='2' WHERE cod_participa='$cod_participa'"); 
    else if($tipo=="adm")
    $query = mysqli_query($conexao->conectar(),"UPDATE participa_reuniao SET conf_adm='2' WHERE cod_participa='$cod_participa'");
    else if($tipo=="convidado")
    $query = mysqli_query($conexao->conectar(),"UPDATE convidados SET conf_presenca='2' where cod_convidado='$cod_participa'");
    
    
    if($query==true)
    return true;
    
}

//inserir no banco de dados
public function Inserir($reuniao){
     
     $conexao =  new Conexao();
     
      date_default_timezone_set('America/Sao_Paulo');  
      $data = date('Y-m-d');  
      $titulo = $reuniao->getTitulo();
      $grupo =$reuniao->getGrupo();
      $endereco = $reuniao->getEndereco();
      $disponibilidade =$reuniao->getDisponibilidade();
     
     $mysqli = new mysqli() or die ();
     
     $query = mysqli_query($mysqli,"INSERT INTO reunioes(cod_data_reuniao,cod_grupo_grupo,titulo_reuniao,cod_endereco) VALUES('$disponibilidade','$grupo','$titulo','$endereco')") or die("error");
     
      $cod_reuniao =  mysqli_insert_id($mysqli);
      
      
     // atualizar o campo cod_reuniao para 1 , para ele não mais aparecer como disponível
     $query2 = mysqli_query($conexao->conectar(),"UPDATE disponibilidade SET cod_disp_reuniao='1' WHERE cod_disponibilidade='$disponibilidade'")or die("deu erro 2");
     
     
     $query1 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa INNER JOIN grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo=grupos.cod_grupo WHERE juncao_grupo_empresa.cod_cad_grupo_empresa_grupo='$grupo'");
     
     
     while($sql4 = mysqli_fetch_array($query1)){
        
         if($sql4['repre_titular']!="0"){
             
             $titular = $sql4['repre_titular'];
             
       
        
        $queryi4 = mysqli_query($conexao->conectar(),"SELECT * FROM disponibilidade where cod_disponibilidade='$disponibilidade'");
         
         $sqli1 = mysqli_fetch_assoc($queryi4);
         
         $data_reuniao = $sqli1['data_disponibilidade'];
         $hora_inicial = $sqli1['hora_inicial'];
         $hora_final = $sqli1['hora_final'];
             
         $query4 = mysqli_query($conexao->conectar(),"INSERT INTO participa_reuniao(cod_membro,cod_grupo,cod_reuniao,data_reuniao,conf_membro,conf_adm) VALUES('$titular','$grupo','$cod_reuniao','$data_reuniao','0','0')") or die('erro');
        
         
         
        //e-mail integrante do grupo
         $queryi1 = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN emails on membros.cod_membro=emails.cod_email_membro where cod_membro='$titular'");
         
    while($sql = mysqli_fetch_array($queryi1)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_membro'];
    $emailenvio=$sql['end_email'];
    $tituloemail = "Unace. Reuniao agendada.";
    $msghtmlemail="<h4>Ola sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) da reuniao ".$titulo.", agendada para o Grupo ".$grupo.", na Unace Jundiai em ".str_replace('-','/',date('d/m/Y', strtotime($data_reuniao)))."  com inicio às ".$hora_inicial." com termino as ".$hora_final."<br/><p><b>Informacoes adicionais:</b></p></br><p><b>Agendada em: </b>$date</p>";
        
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
         
         
         //pegar a data da disponibilidade usada na marcação da reunião
         $queryi = mysqli_query($conexao->conectar(),"SELECT * FROM disponibilidade where cod_disponibilidade='$disponibilidade'")or die("Deu erro 3");
        
         
         $sqli = mysqli_fetch_assoc($queryi);
         
         $data_final = $sqli['data_disponibilidade'];
         
         //subtrair data 
         $data_inicial = date('d/m/Y', strtotime('-7 days', strtotime($data_final)));
         
         $queryi2 = mysqli_query($conexao->conectar(),"UPDATE convidados SET cod_reuniao_participa='$cod_reuniao' where cod_dequem_convidado_juncao='$titular' and cod_reuniao_participa='0' and data_convidado BETWEEN '$data_inicial' and '$data_final' ");
         
         
         
         //e-mail convidado
          $queryi3 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados where cod_dequem_convidado_juncao='$titular' and cod_reuniao_participa='$cod_reuniao' and data_convidado BETWEEN '$data_inicial' and '$data_final'");
    
    while($sql = mysqli_fetch_array($queryi3)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_convidado'];
    $emailenvio=$sql['email_convidado'];
    $tituloemail = "Unace. Reuniao agendada com o grupo ".$grupo."";
    $msghtmlemail="<h4>Ola sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) da reuniao ".$titulo.", agendada para com o Grupo ".$grupo.", na Unace Jundiai, em ".str_replace('-','/',date('d/m/Y', strtotime($data_reuniao)))."  com inicio às ".$hora_inicial." e termino as ".$hora_final."<br/><p><b>Informacoes adicionais::</b></p></br><p><b>Agendada em: </b>$date</p>";
        
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
         
         
         
         
         }
         if($sql4['repre_substituto']!="0"){
             
         $substituto = $sql4['repre_substituto'];
          
             
            
        $queryi4 = mysqli_query($conexao->conectar(),"SELECT * FROM disponibilidade where cod_disponibilidade='$disponibilidade'");
         
         $sqli1 = mysqli_fetch_assoc($queryi4);
         
         $data_reuniao = $sqli1['data_disponibilidade'];
         $hora_inicial = $sqli1['hora_inicial'];
         $hora_final = $sqli1['hora_final'];
         
         $query4 = mysqli_query($conexao->conectar(),"INSERT INTO participa_reuniao(cod_membro,cod_grupo,cod_reuniao,data_reuniao,conf_membro,conf_adm) VALUES('$substituto','$grupo','$cod_reuniao','$data_reuniao','0','0')");
         
         
        
         
        //e-mail integrante do grupo
         $queryi1 = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN emails on membros.cod_membro=emails.cod_email_membro where cod_membro='$substituto'");
         
    while($sql = mysqli_fetch_array($queryi1)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_membro'];
    $emailenvio=$sql['end_email'];
    $tituloemail = "Unace. Reuniao agendada.";
    $msghtmlemail="<h4>Ola sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) da reuniao ".$titulo.", agendada para o Grupo ".$grupo.", na Unace Jundiai em ".str_replace('-','/',date('d/m/Y', strtotime($data_reuniao)))."  com inicio as ".$hora_inicial." e termino as ".$hora_final."<br/><p><b>Informacoes adicionais::</b></p></br><p><b>Agendada em: </b>$date</p>";
        
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
         
         
         
         //pegar a data da disponibilidade usada na marcação da reunião
         $queryi = mysqli_query($conexao->conectar(),"SELECT * FROM disponibilidade where cod_disponibilidade='$disponibilidade'")or die("Deu erro 3");
         
         $sqli = mysqli_fetch_assoc($queryi);
         
         $data_final = $sqli['data_disponibilidade'];
         
         //subtrair data 
         $data_inicial = date('d/m/Y', strtotime('-7 days', strtotime($data_final)));
         
         $queryi2 = mysqli_query($conexao->conectar(),"UPDATE convidados SET cod_reuniao_participa='$cod_reuniao' where cod_dequem_convidado_juncao='$substituto' and cod_reuniao_participa='0' and data_convidado BETWEEN '$data_inicial' and '$data_final'");
         
         
            //e-mail convidado
          $queryi3 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados where  cod_dequem_convidado_juncao='$substituto' and cod_reuniao_participa='$cod_reuniao' and data_convidado BETWEEN '$data_inicial' and '$data_final'");
    
    while($sql = mysqli_fetch_array($queryi3)){
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');
    $nomeemail=$sql['nome_convidado'];
    $emailenvio=$sql['email_convidado'];
    $tituloemail = "Unace. Reuniao agendada com o grupo ".$grupo."";
    $msghtmlemail="<h4>Olá sr(a)".$nomeemail."</h4><p>Queremos por meio desse e-mail informa-lo(a) da reuniao ".$titulo.", agendada para com o Grupo ".$grupo.", na Unace Jundiai, em ".str_replace('-','/',date('d/m/Y', strtotime($data_reuniao)))."  com inicio às ".$hora_inicial." e termino as ".$hora_final."<br/><p><b>Informacoes adicionais::</b></p></br><p><b>Agendada em: </b>$date</p>";
        
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
        
         
         }
     
     }
     
     //validar se etodos as query foram sucedidas
     if($query==true && $query2==true){return true;}else{return false;}
     
      }


}



?>
