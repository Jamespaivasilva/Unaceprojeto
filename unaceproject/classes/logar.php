<?php

require_once("conexao.php");
class logar extends Conexao{
    
 
 
public function validarAcesso($usuario,$senha){
    
 $conexao = new Conexao();
    
 $query = mysqli_query($conexao->conectar(),"SELECT * FROM acesso INNER JOIN membros on acesso.cod_membro_acesso=membros.cod_membro  WHERE usuario = '$usuario'");
 
 $sql = mysqli_fetch_assoc($query);
 
 $empresa = $sql['cod_membro_empresa'];
 
 $idmembro = $sql['cod_membro_acesso'];
 
 $query2 =  mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa  INNER JOIN grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo =grupos.cod_grupo where cod_cad_grupo_empresa_empresa='$empresa' and repre_titular='$idmembro' or repre_substituto='$idmembro' ");
 
  $sql2 =  mysqli_fetch_assoc($query2);
  
  
  $senha_db = $sql['senha'];
 
 // fuso horário
    date_default_timezone_set('America/Sao_Paulo');
    //data atual
   $atual = date("Y-m-d");


     
  if(password_verify($senha,$senha_db)){
      // verificar o nível de acesso(verificar se não está bloqueado)
      
    if($sql['nivel_acesso']!=0){  
        
        //validar se o membro está com  a data de vencimento em dia
    if(strtotime($atual) < strtotime($sql['membro_expira'])){
    session_cache_expire(13); 
    $cache_expire = session_cache_expire();
    session_start();
   $_SESSION['id'] = $sql['cod_membro_acesso'];
   $_SESSION['email'] = $usuario;
   $_SESSION['senha'] = $senha;
   $_SESSION['nivel'] = $sql['nivel_acesso'];
   if(isset($sql2['nome_grupo'])){
   $_SESSION['nome_grupo'] = $sql2['nome_grupo'];
   $_SESSION['cod_grupo'] = $sql2['cod_grupo'];
   }else{
   $_SESSION['nome_grupo'] = "";
   $_SESSION['cod_grupo'] = 0;
   }
   $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    
    return "deu certo";
    }else{
         $_SESSION['status'] = "vencido";
    }
    
    }else{
        $_SESSION['status'] = "bloqueado";
    }
    
    
    
    
  }else{
       $_SESSION['status'] = "senha";
  }
  
  
 
  
}
    
    
    
}
    
    


?>