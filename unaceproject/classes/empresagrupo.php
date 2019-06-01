<?php

require_once("conexao.php");

class Empresagrupo {
    
 private $empresa;
 private $grupo;
 private $data;
 private $titular;
 private $substituto;



function setEmpresa($empresa){
        $this -> empresa = $empresa;
    }
 function getEmpresa(){
        return $this-> empresa;
    } 
    
function setGrupo($grupo){
        $this -> grupo= $grupo;
    }
 function getGrupo(){
        return $this -> grupo;
    }  
    
function setData($data){
        $this -> data = $data;
    }
 function getData(){
        return $this -> data;
    }  
function setTitular($titular){
        $this -> titular = $titular;
    }
 function getTitular(){
        return $this -> titular;
    }  
 function setSubstituto($substituto){
      $this -> substituto = $substituto;
 }
 function getSubstituto(){
      return $this -> substituto;
 }
    

//Verificar se o membro ja é pertencente a um grupo
public function verificarParticipacao($empresagrupo){
    
      $titular = $empresagrupo->getTitular();
      $substituto = $empresagrupo->getSubstituto();
      $grupo =$empresagrupo->getGrupo();
      $data = $empresagrupo->getData();
      $empresa =$empresagrupo->getEmpresa();
    
    $conexao = new Conexao();
    
    // verificar se o representante titular tem registro
    if($titular!=0){
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where repre_titular='$titular' or repre_substituto='$titular'");
    }
    if($substituto!=0){
    //Verificar se o representante substituto tem registro
    $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where repre_titular='$substituto' or repre_substituto='$substituto'");
    
    }
    
    // validar e devolver boolean
    $cont1 = mysqli_num_rows($query);
    
    if(isset($query2))
    $cont2 = mysqli_num_rows($query2);
    else
    $cont2=0;
    
    if($cont1>0 || $cont2>0){
        return false;
    }else{
        return true;
    }
    
}

//inserir no banco de dados
public function Inserir($empresagrupo){
     
     $conexao =  new Conexao();

     
      $titular = $empresagrupo->getTitular();
      $substituto = $empresagrupo->getSubstituto();
      $grupo =$empresagrupo->getGrupo();
      $data = $empresagrupo->getData();
      $empresa =$empresagrupo->getEmpresa();
     
     
     $query = mysqli_query($conexao->conectar(),"INSERT INTO juncao_grupo_empresa(cod_cad_grupo_empresa_grupo,cod_cad_grupo_empresa_empresa,data_cad_grupo_empresa,repre_titular,repre_substituto) VALUES('$grupo','$empresa','$data','$titular','$substituto')") or die("Reporte a um administrador");
     
    
     
     //validar se etodos a query foram sucedidas
     if($query==true){return true;}else{return false;}
      }


}



?>
