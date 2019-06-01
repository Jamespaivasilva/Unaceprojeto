<?php

require_once("conexao.php");

class Categoria{

private $primeira;
private $segunda;



 function setPrimeira($primeira){
        $this -> primeira = $primeira;
    }
 function getPrimeira(){
        return $this -> primeira;
    }
    
 function setSegunda($segunda){
        $this -> segunda = $segunda;
    }
 function getSegunda(){
        return $this -> segunda;
    }
    
    
// inserir os dados do formulário na database    
 public function inserir($categoria){

     $conexao = new Conexao();
     
     $primeira = $categoria->getPrimeira();
     $segunda = $categoria->getSegunda();
     
     
     $query = mysqli_query($conexao->conectar(),"INSERT INTO categorias(pri_cat,sec_cat) VALUES ('$primeira','$segunda')") or die("deu erro");
     
     if($query==true){return true;}else{return false;}
     

     
 }
      
// API mostrar categorioa
public function mostrarCategoria($categoriaId){
    
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM categorias where cod_cat='$categoriaId'");
    
    $sql = mysqli_fetch_assoc($query);
    
    $json = array(
    'primeira'=>$sql['pri_cat'], 
    'segunda'=>$sql['sec_cat'],  
    'cod_cat'=>$sql['cod_cat'],
    );
    
    return json_encode($json);
    
}

// excluir a categoria de acordo com seu id
public function excluirCategoria($categoriaId){
    
    $conexao = new Conexao();
    
    //excluir
    $query = mysqli_query($conexao->conectar(),"DELETE FROM categorias where cod_cat='$categoriaId'");
    
    //VALIDAR E RETORNAR
    if($query)
        return true;
    else
        return false;
    
    
    
}

// alterar a categoria
public function editarCategoria($categoriaId,$categoria){
    
    $conexao = new Conexao();
    
    $pri = $categoria->getPrimeira();
    $sec = $categoria->getSegunda();

    $query = mysqli_query($conexao->conectar(),"UPDATE categorias SET pri_cat='$pri',sec_cat='$sec' where cod_cat='$categoriaId'");
    
    if($query){
        return true;
    }else{
        return false;
    }
    
}



}




?>