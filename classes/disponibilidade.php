<?php

require_once("conexao.php");

class Disponibilidade extends Conexao{

 private $endereco;
 private $data;
 private $inicial;
 private $fim;
 
 
 function setEndereco($endereco){
     $this -> endereco = $endereco; 
 }
 function getEndereco(){
     return $this->endereco;
 }
 function setData($data){
     $this -> data = $data;
 }
 function getData(){
   return $this->data;
 }
 function setInicial($inicial){
     $this->inicial = $inicial;
 }
 function getInicial(){
  return $this->inicial;
 }
 function setFim($fim){
     $this->fim = $fim;
 }
 function getFim(){
  return $this->fim;
 }
 
 public function validarExiste($data,$inicial,$final){
     
    $conexao =  new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM disponibilidade where data_disponibilidade='$data' and hora_inicial='$inicial' and hora_final='$final'");
    
    $numero = mysqli_num_rows($query);
        
    if($numero>0){
        return true;
    }else{
        return false;
    }
     
 }    
 
public function semana($data){
    
 $diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sabado');

// Aqui podemos usar a data atual ou qualquer outra data no formato Ano-mês-dia (2014-02-28)
//$data = date('Y-m-d');

// Varivel que recebe o dia da semana (0 = Domingo, 1 = Segunda ...)
$diasemana_numero = date('w', strtotime($data));

// Exibe o dia da semana com o Array
 return $diasemana[$diasemana_numero];
}
    
    
 public function Inserir($disponibilidade){
     
     $conexao =  new Conexao();
    
     
      $endereco = $disponibilidade->getEndereco();
      $data =$disponibilidade->getData();
      $inicial = $disponibilidade->getInicial();
      $final =$disponibilidade->getFim();


     $query = mysqli_query($conexao->conectar(),"INSERT INTO disponibilidade(hora_inicial,hora_final,data_disponibilidade,cod_endereco) VALUES ('$inicial','$final','$data','$endereco')") or die("deu erro");
     
     if($query==true){return true;}else{return false;}
     
      }
      
      
      
     
 }
    
    
   

?>