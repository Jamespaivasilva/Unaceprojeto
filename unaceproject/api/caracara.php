<?php 



// API para pegar as informações do evento caracara através do id passado



require_once('../classes/caracara.php');
require_once('../classes/conexao.php');



 $conexao = new Conexao();
 $caracara = new Caracara();
 
 
 if(isset($_GET['caracaraId'])){
   echo $caracara->mostrarCaracara(mysqli_real_escape_string($conexao->conectar(),$_GET['caracaraId']));
 }else{
     echo "Cara-cara não localizado!";
 }






















?>