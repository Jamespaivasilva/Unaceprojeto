<?php

// Esssa classe vai ser herdada.

class Endereco{
    
private $cep;
private $rua;
private $bairro;
private $estado;
private $cidade;
private $numero;
private $complemento;



    
 function setCep($cep){
        $this -> cep = $cep;
    }
 function getCep(){
        return $this -> cep;
    }
 function setRua($rua){
        $this -> rua = $rua;
    }
 function getRua(){
        return $this -> rua;
    }
 function setBairro($bairro){
        $this -> bairro = $bairro;
    }
 function getBairro(){
        return $this -> bairro;
    }
 function setEstado($estado){
        $this -> estado = $estado;
    }
 function getEstado(){
        return $this -> estado;
    }
 function setCidade($cidade){
        $this -> cidade = $cidade;
    }
 function getCidade(){
        return $this -> cidade;
    }
 function setNumero($numero){
        $this -> numero = $numero;
    }
 function getNumero(){
        return $this -> numero;
    }
 function setComplemento($complemento){
        $this -> complemento = $complemento;
    }
 function getComplemento(){
        return $this -> complemento;
    }   
    
    

    
    
    
}




?>