<?php

require_once("conexao.php");

class Grupo extends Conexao{
    
    
private $nome;
private $fundacao;
    
    function setNome($nome){
        $this -> nome = $nome;
    }
    function getNome(){
        return $this -> nome;
    }
    function setFundacao($fundacao){
        $this -> fundacao = $fundacao;
    }
    function getFundacao(){
        return $this -> fundacao;
    }
    
    //API mostrar informações do grupo, vai ser utilizada em editar na página 'gerenciargrupo'
    public function mostrarGrupo($grupoId){
        
        $conexao = new Conexao();
        
        $query = mysqli_query($conexao->conectar(),"SELECT * FROM grupos where cod_grupo='$grupoId'");
        
        $sql = mysqli_fetch_assoc($query);
        
        $json = array(
            "cod_grupo" => $sql['cod_grupo'],
            "nome" => $sql['nome_grupo'],
            "fundacao" => $sql['fundacao_grupo']
            );
            
            
            return json_encode($json);
    }
    
//Inserir grupo
 public function inserir($grupo){
     $conexao = new Conexao();
     
     $nome = $grupo->getNome();
     $fundacao = $grupo->getFundacao();
     
     $query = mysqli_query($conexao->conectar(),"INSERT INTO grupos(nome_grupo,fundacao_grupo) VALUES ('$nome','$fundacao')") or die("deu erro");
     
     //Verificar se a query foi realizada.
     if($query==true){return true;}else{return false;}
     
 }
 
 
 //editar um grupo
 
 public function mudarGrupo($grupoId,$grupo){
     
     $nome = $grupo->getNome();
     $fundacao = $grupo->getFundacao();
     
     $conexao = new Conexao();
     
     $query =  mysqli_query($conexao->conectar(),"UPDATE grupos SET nome_grupo='$nome',fundacao_grupo='$fundacao' where cod_grupo='$grupoId'");
     
     if($query)
         return true;
     else
         return false;
     
 }
 
 
 
    
}




?>