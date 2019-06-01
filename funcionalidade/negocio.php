<?php



 require_once("../classes/negocio.php");
 require_once("../classes/conexao.php");
 
 //conexão com o banco de dados
 $conexao = new Conexao();
 
 //set dados no objeto classe para enviar para o método
 $negocio = new Negocio();
 
 $quem =$_POST['quem'];
 
 
 //tirar a virgula do valor gerado
  $valorgerado = str_replace(".","",$_POST['gerou']);
   $valorgerado = str_replace(",",".",$valorgerado);
 
 $query = mysqli_query($conexao->conectar(),"SELECT * FROM membros where cod_membro='$quem'");
 
 $sql = mysqli_fetch_array($query);
 
 $empresa = $sql['cod_membro_empresa'];

 $negocio->setCadastrou(mysqli_real_escape_string($conexao->conectar(),$_POST['cadastrou'])); 
 $negocio->setObrigado(mysqli_real_escape_string($conexao->conectar(),$_POST['quem'])); 
 $negocio->setData(mysqli_real_escape_string($conexao->conectar(),$_POST['data'])); 
 $negocio->setNegocio(mysqli_real_escape_string($conexao->conectar(),$_POST['negocio'])); 
 $negocio->setReferencia(mysqli_real_escape_string($conexao->conectar(),$_POST['referencia'])); 
 $negocio->setGerou(mysqli_real_escape_string($conexao->conectar(),$valorgerado)); 
 $negocio->setEmpresa(mysqli_real_escape_string($conexao->conectar(),$empresa)); 
 $negocio->setComentario(mysqli_real_escape_string($conexao->conectar(),$_POST['comentario'])); 
 
 
 
 //Inserir no banco de dados
 $resultado = $negocio->inserir($negocio);
 
 if($resultado==true){
     echo "<script>window.location.assign('../interface/negocio.php?resultado=success')</script>";
     //header('Location: ../interface/negocio.php?resultado=success');
 }

 
 
 
 
 
 
 
 
 