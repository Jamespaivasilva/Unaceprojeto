<?php

require_once("../classes/conexao.php");

$conexao = new Conexao();

$valor = $_POST['valor'];

//$query =mysqli_query($conexao->conectar(),"SELECT rua,bairro,cep,numero,complemento,cidade,estado FROM membros INNER JOIN endereco on membros.cod_membro_endereco=endereco.cod_endereco //where cod_membro='$valor'");

$query = mysqli_query($conexao->conectar(),"SELECT * from reunioes INNER JOIN endereco on reunioes.cod_endereco=endereco.cod_endereco where cod_reuniao = '$valor'");
 
  $sql = mysqli_fetch_array($query);


print json_encode(
	array(
		 'status' => true,
		'rua'  => $sql['rua'],
		'bairro'  => $sql['bairro'],
		'numero'  => $sql['numero'],
		'complemento'  => $sql['complemento'],
		'cidade'  => $sql['cidade'],
		'cep'  => $sql['cep'],
		'estado'  => $sql['estado'],
		'cod_endereco'  => $sql['cod_endereco'],
		
	)
);










?>