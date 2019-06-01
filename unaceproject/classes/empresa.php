<?php

require_once("conexao.php");

class Empresa extends Conexao{
    
 private $nome;
 private $cnpj;
 private $fundacao;
 private $categoria;
 private $descricao;
 private $dataunace;
 private $logo;
 

 function setNome($nome){
        $this -> nome = $nome;
    }
 function getNome(){
        return $this -> nome;
    }
    
 function setCnpj($cnpj){
        $this -> cnpj = $cnpj;
    }
 function getCnpj(){
        return $this -> cnpj;
    }
 function setFundacao($fundacao){
        $this -> fundacao = $fundacao;
    }
 function getFundacao(){
        return $this -> fundacao;
    }
 function setCategoria($categoria){
        $this -> categoria = $categoria;
    }
 function getCategoria(){
        return $this -> categoria;
    }
 function setDescricao($descricao){
        $this -> descricao = $descricao;
    }
 function getDescricao(){
        return $this -> descricao;
    }
 function setDataunace($dataunace){
        $this -> dataunace = $dataunace;
    }
 function getDataunace(){
        return $this -> dataunace;
    }
 function setLogo($logo){
     $this->logo = $logo;
 }
 function getLogo(){
     return $this->logo;
 }
    
    
 // Verificar se o CNPJ existe.
public function validarCNPJ($cnpj){
    
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM empresas where cnpj_empresa='$cnpj'");
    
    $numero = mysqli_num_rows($query);
        
    if($numero>0){
        return true;
    }else{
        return false;
    }
    
}
    
 
public function inserir($empresa){
    
     $conexao = new Conexao();
     
     $cnpj = $empresa->getCnpj();
     $nome = $empresa->getNome();
     $fundacao = $empresa->getFundacao();
     $categoria = $empresa->getCategoria();
     $descricao = $empresa->getDescricao();
     $dataunace = $empresa->getDataunace();
     $logo2 = $empresa->getLogo();
     
     $query = mysqli_query($conexao->conectar(),"INSERT INTO empresas(cnpj_empresa,nome_empresa,fundacao_empresa,cat_empresa_categoria,descr_empresa,data_unace_empresa,logo) VALUES ('$cnpj','$nome','$fundacao','$categoria','$descricao','$dataunace','$logo2')") or die("deu erro");
     
     // Verificar se a query foi realizada.
     if($query==true){return true;}else{return false;}
     
      }
      
      
      
// API para mostrar os dados de uma única empresa
public function mostrarEmpresa($empresaId){
    
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM empresas where cod_empresa='$empresaId'");
    
    $sql =  mysqli_fetch_assoc($query);
    
    $categoria = $sql['cat_empresa_categoria'];
    
    $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM categorias where cod_cat='$categoria'");
    
    $sql2 = mysqli_fetch_assoc($query2);
    
    $json = array(
        'cod_empresa'=>$sql['cod_empresa'],
        'nome_empresa' =>$sql['nome_empresa'],
        'cnpj'=>$sql['cnpj_empresa'],
        'pricategoria'=>$sql2['pri_cat'],
        'seccategoria'=>$sql2['sec_cat'],
        'cod_cat' => $sql2['cod_cat'],
        'descricao' =>$sql['descr_empresa'],
        'data_fundacao'=>$sql['fundacao_empresa']
        );
        
    return json_encode($json);
}

// Editar empresa de acordo com o id
public function mudarEmpresa($empresaId,$empresa){
    
    $conexao = new Conexao();
    
    $cnpj = $empresa->getCnpj();
    $nome = $empresa->getNome();
    $categoria = $empresa->getCategoria();
    $descricao = $empresa->getDescricao();
    $data = $empresa->getFundacao();
    $logo = $empresa->getLogo();
    
    // Vamos tratar o sinal de mudança lá da pagina funcionalidade(mudarempresa.php)
    
    if($logo==false){
        if($categoria!=false){
        $query = mysqli_query($conexao->conectar(),"UPDATE empresas SET cnpj_empresa='$cnpj',nome_empresa='$nome',cat_empresa_categoria='$categoria',descr_empresa='$descricao',fundacao_empresa='$data' WHERE cod_empresa='$empresaId'");
        }else{
         $query = mysqli_query($conexao->conectar(),"UPDATE empresas SET cnpj_empresa='$cnpj',nome_empresa='$nome',descr_empresa='$descricao',fundacao_empresa='$data' WHERE cod_empresa='$empresaId'");
        }
    }else{
        if($categoria!=false){
        $query = mysqli_query($conexao->conectar(),"UPDATE empresas SET cnpj_empresa='$cnpj',nome_empresa='$nome',cat_empresa_categoria='$categoria',descr_empresa='$descricao',fundacao_empresa='$data',logo='$logo' WHERE cod_empresa='$empresaId'");
        }else{
         $query = mysqli_query($conexao->conectar(),"UPDATE empresas SET cnpj_empresa='$cnpj',nome_empresa='$nome',descr_empresa='$descricao',fundacao_empresa='$data',logo='$logo' WHERE cod_empresa='$empresaId'");
        }
    }
    
    if($query){
        return true;
    }else{
        return false;
    }
    
    
}

}

?>
