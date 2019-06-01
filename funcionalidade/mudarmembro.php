<?php


//Vamos utilizar esse arquivo para poder rodar apenas uma função mudar.
//Diferente da página 'minhaconta', esse mudar vem da ação do botão editar na pagina gerenciarmembro.


require_once('../classes/conexao.php');
require_once('../classes/membro.php');

 $membro = new Membro();
 $conexao = new Conexao();
 
 $testargrupo = false;
 //verificar se vai existir uma troca de grupo
 
 if(isset($_POST['pgrupo']) && $_POST['grupo']!=null && $_POST['grupo']!=""){
     
     if($_POST['pgrupo']!="" && $_POST['pgrupo']!=null  && $_POST['pgrupo']!=0){
         //verificar se foi solicitado a solicitação, fazendo comparação anterior e depois
         
         if($_POST['pgrupo']!=$_POST['grupo']){
             //sim é diferente, vamos solicitar a troca.
             
             //  rodar a função localizada em membros para trocar
             $verificar22 =$membro->mudarGrupo(mysqli_real_escape_string($conexao->conectar(),$_POST['pgrupo']),mysqli_real_escape_string($conexao->conectar(),$_POST['papel']),mysqli_real_escape_string($conexao->conectar(),$_POST['grupo']),mysqli_real_escape_string($conexao->conectar(),$_POST['cod_membro']),mysqli_real_escape_string($conexao->conectar(),$_POST['empresa']));
             
             if($verificar22){
                 $testargrupo = true;
             }else{
                 echo $_POST['grupo'];
                 echo $_POST['pgrupo'];
                 $testargrupo =  false;
             }
             
         }else{
             $testargrupo =  true;
         }
     }
     
 }else{
     $testargrupo=true;
 }
 
 // verificar se a senha foi preenchida, se não vamos mandar um sinal para uma condição
 if(isset($_POST['senha'])){
     
     if($_POST['senha']!="" && $_POST['senha']!=null){
    $senha = trim(password_hash(mysqli_real_escape_string($conexao->conectar(),$_POST['senha']), PASSWORD_BCRYPT, [12]));
     }else{
      $senha = false;
     }
 }else{
     $senha = false;
 }
 
 //extender o período caso for solicitado
 
 if($_POST['validade']!=0){
    if($_POST['validade']=="6"){
    $data = date('Y-m-d'); 
    $validade = date('Y/m/d', strtotime("+180 days",strtotime($_POST['vencimento']))); 
    }
    else if($_POST['validade']=="4"){
    $data = date('Y-m-d'); 
    $validade = date('Y/m/d', strtotime("+30 days",strtotime($_POST['vencimento']))); 
    }
    else if($_POST['validade']=="1"){
    $data = date('Y-m-d'); 
    $validade = date('Y/m/d', strtotime("+365 days",strtotime($_POST['vencimento']))); 
    }else if($_POST['validade']=="2"){
    $data = date('Y-m-d'); 
    $validade = date('Y/m/d', strtotime("+730 days",strtotime($_POST['vencimento']))); 
    }
    else if($_POST['validade']=="5"){
    $data = date('Y-m-d'); 
    $validade = date('Y/m/d', strtotime("+1825 days",strtotime($_POST['vencimento']))); 
    
  }
     
 }else{
     $validade=false;
 }
 
 
 if($_POST['usuarioatual']!=$_POST['usuario']){
 $existeusuario = $membro->validarUsuario2(mysqli_real_escape_string($conexao->conectar(),$_POST['usuario']),mysqli_real_escape_string($conexao->conectar(),$_POST['cod_membro']));
}else{
 $existeusuario = false;   
}
 
if($existeusuario==false){
// definindo a instancia de um membro com os dados do form
$membro->setCod_membro(mysqli_real_escape_string($conexao->conectar(),$_POST['cod_membro']));
$membro->setNome(mysqli_real_escape_string($conexao->conectar(),$_POST['nome']));
$membro->setCpf(mysqli_real_escape_string($conexao->conectar(),$_POST['cpf']));
$membro->setAniversario(mysqli_real_escape_string($conexao->conectar(),$_POST['nascimento']));
$membro->setCod_empresa(mysqli_real_escape_string($conexao->conectar(),$_POST['empresa']));
$membro->setPapel(mysqli_real_escape_string($conexao->conectar(),$_POST['papel']));
$membro->setNivel(mysqli_real_escape_string($conexao->conectar(),$_POST['nivel']));
$membro->setUsuario(mysqli_real_escape_string($conexao->conectar(),$_POST['usuario']));
$membro->setSenha($senha);
$membro->setExpira(mysqli_real_escape_string($conexao->conectar(),$validade));

// rodando a função para fazer o update e conferindo o resultado.
if($membro->mudarMembro($_POST['grupo'],$membro) && $testargrupo==true){
 header('Location: ../interface/gerenciarmembros.php?resultado=success');
}else{
 header('Location: ../interface/gerenciarmembros.php?resultado=fail');
}

}else{
    
    header('Location: ../interface/gerenciarmembros.php?resultado=usuario'); 
}























?>