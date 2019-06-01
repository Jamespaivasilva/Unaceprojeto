<?php
require_once("conexao.php");
require_once("endereco.php");
//Define Charset UTF-8

class Membro extends Endereco{
  private $cod_membro;
  private $cod_endereço;
  private $cpf;
  private $nome;
  private $aniversario;
  private $foto;
  private $papel;
  private $cod_empresa;
  private $ddd;
  private $email;
  private $cod_tel;
  private $numero2;
  private $tipo;
  private $senha;  
  private $usuario;
  private $nova;
  private $nivel;
  private $expira;
  
  
  
  function setCpf($cpf){
        $this -> cpf = $cpf;
    }
 function getCpf(){
        return $this -> cpf;
    }
  function setAniversario($aniversario){
        $this -> aniversario = $aniversario;
    }
 function getAniversario(){
        return $this -> aniversario;
    }
 function setNome($nome){
        $this -> nome = $nome;
    }
 function getNome(){
        return $this -> nome;
    }
 function setFoto($foto){
        $this -> foto = $foto;
    }
 function getFoto(){
        return $this -> foto;
    }
 
 function setPapel($papel){
        $this -> papel = $papel;
    }
 function getPapel(){
        return $this -> papel;
    }
 function setCod_empresa($cod_empresa){
        $this -> cod_empresa = $cod_empresa;
    }
 function getCod_empresa(){
        return $this -> cod_empresa;
    }
 function setDdd($ddd){
        $this -> ddd = $ddd;
    }
 function getDdd(){
        return $this -> ddd;
    }
 function setEmail($email){
        $this -> email = $email;
    }
 function getEmail(){
        return $this -> email;
    }
 function setCod_tel($col_tel){
        $this -> col_tel = $col_tel;
    }
 function getCod_tel(){
        return $this -> col_tel;
    }
 function setNumero2($numero2){
        $this -> numero2 = $numero2;
    }
 function getNumero2(){
        return $this -> numero2;
    }
 function setTipo($tipo){
     $this -> tipo = $tipo;
 }
 function getTipo(){
     return $this -> tipo;
 }
 function setSenha($senha){
     $this -> senha = $senha;
 }
 function getSenha(){
     return $this -> senha;
 }
 function setCod_membro($cod_membro){
     $this -> cod_membro = $cod_membro;
 }
 function getCod_membro(){
     return $this -> cod_membro;
 }
 
 function setUsuario($usuario){
     $this -> usuario = $usuario;
 }
 function getUsuario(){
     return $this -> usuario;
 }
 
 function setNova($nova){
     $this -> nova = $nova;
 }
 function getNova(){
     return $this -> nova;
 }
 
 function setCod_endereco($cod_endereco){
     $this -> cod_endereco = $cod_endereco;
 }
 function getCod_endereco(){
     return $this -> cod_endereco;
 }
 
 function setNivel($nivel){
     $this -> nivel = $nivel;
 }
 function getNivel(){
     return $this -> nivel;
 }
 function setExpira($expira){
     $this -> expira = $expira;
 }
 function getExpira(){
     return $this -> expira;
 }
 
 //alterar grupo
 
 public function mudarGrupo($grupo,$papel,$novogrupo,$id_membro,$empresa){
     
     $conexao = new Conexao();
     
     $mudar =0 ;
     
     date_default_timezone_set('America/Sao_Paulo');
     $data = date('Y-m-d'); 
    
    if($papel=="1"){
        
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where repre_titular='$id_membro' and cod_cad_grupo_empresa_grupo='$grupo'");
    
    //pegando o substituto para colocar como membro titular
    $sql =  mysqli_fetch_assoc($query);
    $substituto = $sql['repre_substituto'];
    $id_juncao = $sql['cod_cad_grupo_empresa'];
    
    // verificando se foi encontrado um registro
    if(isset($sql['repre_substituto'])){
    //colocando o membro substituto como titular
    // fazer uma troca de posiçoes
    $query2 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET repre_titular='0' WHERE cod_cad_grupo_empresa='$id_juncao'");
    //mudando também no perfil dele seu novo papel
    //$query5 = mysqli_query($conexao->conectar(),"UPDATE membros SET papel_membro_papel='1' where cod_membro='$substituto'");
    
    //Checando se existe uma vaga de representante titular no grupo que o membro quer entrar
    $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where cod_cad_grupo_empresa_grupo='$novogrupo' and cod_cad_grupo_empresa_empresa='$empresa' and repre_titular='0' ");
    
    $verificar = mysqli_fetch_assoc($query3);

    // verificar se existe, se sim, vamos substituir o 0  pelo titular
    if($verificar==true && $verificar['repre_titular']==0){
         $id_empresagrupo = $verificar['cod_cad_grupo_empresa'];
         
         //Atualizar a posição titular, tirando 0 colocando o membro
        $query4 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET data_cad_grupo_empresa='$data',repre_titular='$id_membro' where cod_cad_grupo_empresa_grupo='$novogrupo' and cod_cad_grupo_empresa='$id_empresagrupo'");
    }else{
    
         $query4 = mysqli_query($conexao->conectar(),"INSERT INTO juncao_grupo_empresa(cod_cad_grupo_empresa_grupo,cod_cad_grupo_empresa_empresa,repre_titular,data_cad_grupo_empresa)VALUES('$novogrupo','$empresa','$id_membro','$data')");
    }
    
    }else{
        return false;
    }
    if($query==true && $query2==true && $query3==true && $query4==true){
    
        return true;
    }else{
        return false;
    }
    
    }else if($papel=="2"){
        
         //LOCALIZAR A SUA PRESENÇA EM UM GRUPO
        $query = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where repre_substituto='$id_membro' and cod_cad_grupo_empresa_grupo='$grupo' and cod_cad_grupo_empresa_empresa='$empresa'");
        
        $sql = mysqli_fetch_assoc($query);
        
        
            $cod_registro = $sql['cod_cad_grupo_empresa'];
            $substituto = $sql['repre_substituto'];
            //vamos zerar a participação do membro no grupo atual localizado $sql
            $query2 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET repre_substituto='0' where repre_substituto='$id_membro'");
            
            //se atualização foi bem sucedida

                //vamos tentar achar uma posição disponivel
            $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where repre_substituto=0 and cod_cad_grupo_empresa_grupo='$novogrupo' and cod_cad_grupo_empresa_empresa='$empresa'");
            
            $verificar = mysqli_num_rows($query3);
            
             if($verificar){
                 //encontrou um registro
                 $sql2 = mysqli_fetch_assoc($query3);
                 
                 
                 $cod_registro3 =$sql2['cod_cad_grupo_empresa'];
                 
                 $query97 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET repre_substituto='$id_membro' where cod_cad_grupo_empresa='$cod_registro3'");
                 
             }else{
                 //inserir novo registro
                  $query97 = mysqli_query($conexao->conectar(),"INSERT INTO juncao_grupo_empresa(cod_cad_grupo_empresa_grupo,cod_cad_grupo_empresa_empresa,repre_titular,repre_substituto,data_cad_grupo_empresa)VALUES('$novogrupo','$empresa','0','$substituto','$data')");
             }
                
                
     // validar se as ação no banco de dados deram certo.
    if($query==true && $query2==true && $query3==true && $query97==true){
        return true;
        }else{
        return false;
        }
      
    
    }
    

   
    
   
 }
 
 
 //API
 //retorn json com as informações de e-mail
 public function mostrarEmail($emailId){
     
     $conexao = new Conexao();
     
     $query = mysqli_query($conexao->conectar(),"SELECT * FROM emails where cod_email='$emailId'");
     $sql = mysqli_fetch_assoc($query);
     
     $json  = array(
     'cod_email'=>$sql['cod_email'],
     'email'=>$sql['end_email']
     );
     
     return json_encode($json);
     
 }
 
 //retorn json com as informações de e-mail
 public function mostrarTelefone($telefoneId){
     
     $conexao = new Conexao();
     
     $query = mysqli_query($conexao->conectar(),"SELECT * FROM tels where cod_tel='$telefoneId'");
     $sql = mysqli_fetch_assoc($query);
     
     $json  = array(
     'cod_telefone'=>$sql['cod_tel'],
     'ddd' => $sql['tel_ddd'],
     'numero'=> $sql['num_tel'],
     'tipo_tel'=> $sql['tipo_tel']
     );
     
     return json_encode($json);
     
 }
 
 
 

 //retorna json com as informações do membro
 public function mostrarMembro($membroId){
     
     $conexao = new Conexao();
     
     // verificar se a empresa do membro tem um vinculo na juncao_grupo_empresa
     $query1 = mysqli_query($conexao->conectar(),"SELECT * from membros INNER JOIN juncao_grupo_empresa on membros.cod_membro_empresa=juncao_grupo_empresa.cod_cad_grupo_empresa_empresa where cod_membro='$membroId'");
     
     // contar para verificar >0  tem  0  não.
     $contar = mysqli_num_rows($query1);
     
     //verificar
     if($contar>0){
        // Grupo tem vinculo juncao_grupo_empresa
     $query = mysqli_query($conexao->conectar(),"SELECT *  FROM membros 
     INNER JOIN acesso on membros.cod_membro=acesso.cod_membro_acesso 
     INNER JOIN empresas  on membros.cod_membro_empresa=cod_empresa 
     INNER JOIN papel on membros.papel_membro_papel=papel.cod_papel
     INNER JOIN juncao_grupo_empresa on empresas.cod_empresa=cod_cad_grupo_empresa_empresa
     INNER JOIN grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo=grupos.cod_grupo
     where cod_membro='$membroId'");
     
     }else{
	
      // Grupo não tem nenhum vinculo  juncao_grupo_empresa
	$query = mysqli_query($conexao->conectar(),"SELECT  *  FROM membros 
     INNER JOIN acesso on membros.cod_membro=acesso.cod_membro_acesso 
     INNER JOIN empresas on membros.cod_membro_empresa=empresas.cod_empresa 
     INNER JOIN papel on membros.papel_membro_papel=papel.cod_papel
     where cod_membro='$membroId'");
     }
     
     
     
     $sql = mysqli_fetch_assoc($query);
     $acesso ="";
    
     
     
     if($sql['cod_papel']=="1"){
         $query2 = mysqli_query($conexao->conectar(),"SELECT * from juncao_grupo_empresa INNER JOIN grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo=grupos.cod_grupo where repre_titular='$membroId'");
     }
     else{
        $query2 = mysqli_query($conexao->conectar(),"SELECT * from juncao_grupo_empresa INNER JOIN grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo=grupos.cod_grupo where repre_substituto='$membroId'");
     }
        
    if($sql['nivel_acesso']=="1"){$acesso="Membro";}else{$acesso="Administrador";}
        
     $sql2 = mysqli_fetch_assoc($query2);
     

     $json = array(
          "cod_membro" => $sql['cod_membro'],
          "nome" =>  iconv("UTF-8", "ISO-8859-1",$sql['nome_membro']),
          "cpf" => $sql['cpf_membro'],
          "nascimento" => $sql['niver_membro'],
          "foto" => $sql['foto'],
          "nome_empresa"=>iconv("UTF-8", "ISO-8859-1",$sql['nome_empresa']),
          "cod_empresa" => $sql['cod_empresa'],
          "nivel_acesso" => $acesso ,
          "usuario" => iconv("UTF-8", "ISO-8859-1", $sql['usuario']),
          "papel" =>iconv("UTF-8", "ISO-8859-1", $sql['nome_papel']),
          "validade" => $sql['membro_expira'],
          "grupo" =>iconv("UTF-8", "ISO-8859-1", $sql2['nome_grupo']),
          "cod_grupo"=>$sql2['cod_grupo'],
          "cod_papel" => $sql['cod_papel'],
          
          
     );
     
     
      return json_encode($json);
     
     
 }
 
 ///
 
 //Verificar se o CPF já não está cadastrado.
public function validarCPF($cpf){
    
     $mysqli = new mysqli("localhost","u253536359_nuwe", "james56118992", "u253536359_nuwe") or die ("deu erro"); 
    
    $query = mysqli_query($mysqli,"SELECT * FROM membros where cpf_membro='$cpf'");
    
    $numero = mysqli_num_rows($query);
        
    if($numero>0){
        return true;
    }else{
        return false;
    }
    
}


public function trueoufalse($resultado){
    return $resultado;
}

public function validarSenha($usuario,$senha){
	$conexao = new Conexao();    
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM acesso where usuario ='$usuario'");
    
    $sql = mysqli_fetch_array($query);
    
    $senha_db = $sql['senha'];
    
    if(password_verify($senha,$senha_db)){
        return true;
    }else{
        return false;
    }
    
}

// Verificar se usuario já existe.
public function validarUsuario($usuario){
    
	$conexao = new Conexao();    
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM acesso where usuario ='$usuario'");
    
    $contar = mysqli_num_rows($query);
    
    if($contar!=0){
        return true;
    }else{
        return false;
    }
    
}

//validar se o usuário existe de uma outra forma, para o gerenciamento de membros
public function validarUsuario2($usuario,$membroId){
    
    $conexao =  new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"SELECT *  FROM acesso where usuario='$usuario' and cod_membro_acesso!='$membroId'");
    
    $sql = mysqli_fetch_assoc($query);
    
    
    if(isset($sql['cod_membro_acesso'])){
         return true;
    }else{
         return false;
    }
}

//Bloquear o acesso do membro, definindo como 0(1 é membro, 2  é administrador)
public function bloquearMembro($membroId){
    $conexao = new Conexao();

    $query = mysqli_query($conexao->conectar(),"UPDATE acesso SET nivel_acesso = 0 WHERE cod_membro_acesso='$membroId'");
 
    if($query){
        
        return true;
    }else{
        return false;
    }
    
    
}

//Bloquear o acesso do membro, definindo como 0(1 é membro, 2  é administrador)
public function desbloquearMembro($membroId){
    $conexao = new Conexao();
    $query = mysqli_query($conexao->conectar(),"UPDATE acesso SET nivel_acesso = 1 WHERE cod_membro_acesso='$membroId'");
    if($query){
        
        return true;
    }else{
        return false;
    }
    
}

// fazer alteração nas tabelas, função da pagina 'minha conta'
public function mudar($membro,$validar){
    
     $cpf = $membro->getCpf();
     $nome = $membro->getNome();
     $cod_membro = $membro->getCod_membro();
     $aniversario = $membro->getAniversario();
     $foto = $membro->getFoto();
     $papel = $membro->getPapel();
     $cod_empresa = $membro->getCod_empresa();
     $ddd = $membro->getDdd();
     $email = $membro->getEmail();
     $numero2 = $membro->getNumero2();
     $tipo = $membro->getTipo();
     $senha = $membro->getSenha();
     $rua = $membro->getRua();
     $bairro = $membro->getBairro();
     $cep = $membro->getCep();
     $cidade = $membro->getCidade();
     $estado = $membro->getEstado();
     $complemento = $membro->getComplemento();
     $numero = $membro ->getNumero();
     $nova = $membro ->getNova();
     $cod_endereco = $membro ->getCod_endereco();
     $usuario = $membro ->getUsuario();
     $nivel = $membro ->getNivel();
     
	$mysqli = new mysqli("35.199.110.234","unace", "james56118992", "u253536359_nuwe") or die ("deu erro");
    
    $query = mysqli_query($mysqli,"UPDATE membros SET cpf_membro = '$cpf', nome_membro = '$nome',niver_membro='$aniversario',foto='$foto' WHERE cod_membro='$cod_membro'");
    
    $query2 = mysqli_query($mysqli,"UPDATE endereco SET rua = '$rua', bairro= '$bairro',cep='$cep',cidade='$cidade',estado='$estado',complemento='$complemento',numero='$numero' WHERE cod_endereco='$cod_endereco'");
    
    //$query3 = mysqli_query($mysqli,"UPDATE tels SET tel_ddd = '$ddd', num_tel = '$numero2',tipo_tel='$tipo' WHERE cod_tel_membro='$cod_membro'");
    
    
    //$query4 = mysqli_query($mysqli,"UPDATE emails SET end_email = '$email' WHERE cod_email_membro='$cod_membro'");
    
    echo $validar;
    
    if($nova!=1 && $validar==true){
        
    $query5 = mysqli_query($mysqli,"UPDATE acesso SET usuario = '$usuario', senha = '$nova' WHERE cod_membro_acesso='$cod_membro'");
    }else{
    $query5 = mysqli_query($mysqli,"UPDATE acesso SET usuario = '$usuario' WHERE cod_membro_acesso='$cod_membro'");
    
    }
    
    
    if($query==true && $query2==true && $query3==true && $query4==true && $query5==true){return true;}else{return false;}
     
    }
    
    
// mudar membro do formulário
public function mudarMembro($cod_grupo,$membro){
    
     $cod_membro = $membro->getCod_membro();
     $cpf = $membro->getCpf();
     $nome = $membro->getNome();
     $cod_membro = $membro->getCod_membro();
     $aniversario = $membro->getAniversario();
     $papel = $membro->getPapel();
     $cod_empresa = $membro->getCod_empresa();
     $senha = $membro->getSenha();
     $usuario = $membro ->getUsuario();
     $nivel = $membro ->getNivel();
     $expira = $membro->getExpira();
     
     $conexao = new Conexao();
     
    
    
    if($cod_grupo!=0 && $cod_grupo!=NULL && $cod_grupo!=""){
        
    //ANTES DE MUDAR, VAMOS VERIFICAR SE O PAPEL DEFINIDO É O MESMO DO GRUPO, SENÃO FOR VAMOS ALTERAR O PAPEL TANTO NO GRUPO QUANTO NO CADASTRO DO MEMBRO
    if($papel=='1'){
    $query = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where cod_cad_grupo_empresa_empresa='$cod_empresa' and repre_titular='$cod_membro'");
    
      //SE NÃO ENCONTRAR UM REGISTRO É PORQUE FOI ALTERADO O PAPEL E NO GRUPO NÃO ESTÁ DE ACORDO, VAMOS FAZER A ALTERAÇÃO DE ACORDO COM A REQUISIÇÃO DO USUARIO
      $sql = mysqli_fetch_assoc($query);
      if($sql['repre_titular']=="" || $sql['repre_titular']==null || $sql['repre_titular']==0){
          
       // VAMOS DEFINIR 0 PARA A POSIÇÃO QUE O MEMBRO OCUPA
      $query2 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET repre_substituto=0 WHERE repre_substituto='$cod_membro'");
         
        //VAMOS VERIFICAR PRIMEIRO SE EXISTE UMA POSIÇÃO 'VAGA' SENÃO VAMOS CRIAR UM NOVO REGISTRO
      $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where cod_cad_grupo_empresa_grupo='$cod_grupo' and cod_cad_grupo_empresa_empresa='$cod_empresa' and repre_titular=0 ");
      
       $sql = mysqli_fetch_assoc($query3);
       
       $data = date('Y-m-d');
       if($sql['repre_titular']!=0){
           $query4 = mysqli_query($conexao->conectar(),"INSERT INTO juncao_grupo_empresa(cod_cad_grupo_empresa_grupo,cod_cad_grupo_empresa_empresa,repre_titular,data_cad_grupo_empresa)VALUES('$cod_grupo','$cod_empresa','$cod_membro','$data')");
       }else{
           $cod_cad_grupo_empresa = $sql['cod_cad_grupo_empresa'];
           $query4 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET repre_titular='$cod_membro' WHERE cod_cad_grupo_empresa='$cod_cad_grupo_empresa'");
       }
          
      }
    }else if($papel=='2'){
        
         $query = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa WHERE cod_cad_grupo_empresa_empresa='$cod_empresa' and repre_substituto='$cod_membro'");
    
      //SE NÃO ENCONTRAR UM REGISTRO É PORQUE FOI ALTERADO O PAPEL E NO GRUPO NÃO ESTÁ DE ACORDO, VAMOS FAZER A ALTERAÇÃO DE ACORDO COM A REQUISIÇÃO DO USUARIO
      $sql = mysqli_fetch_assoc($query);
      if($sql['repre_substituto']=="" || $sql['repre_substituto']==null || $sql['repre_substituto']==0){
          
       // VAMOS DEFINIR 0 PARA A POSIÇÃO QUE O MEMBRO OCUPA
      $query2 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET repre_titular=0 WHERE repre_titular='$cod_membro'");
         
        //VAMOS VERIFICAR PRIMEIRO SE EXISTE UMA POSIÇÃO 'VAGA' SENÃO VAMOS CRIAR UM NOVO REGISTRO
      $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM juncao_grupo_empresa where cod_cad_grupo_empresa_grupo='$cod_grupo' and cod_cad_grupo_empresa_empresa='$cod_empresa' and repre_substituto=0 ");
      
       $sql = mysqli_fetch_assoc($query3);
       
       $data = date('Y-m-d');
       if($sql['repre_substituto']!=0){
           $query4 = mysqli_query($conexao->conectar(),"INSERT INTO juncao_grupo_empresa(cod_cad_grupo_empresa_grupo,cod_cad_grupo_empresa_empresa,repre_substituto,data_cad_grupo_empresa)VALUES('$cod_grupo','$cod_empresa','$cod_membro','$data')");
       }else{
           $cod_cad_grupo_empresa = $sql['cod_cad_grupo_empresa'];
           $query4 = mysqli_query($conexao->conectar(),"UPDATE juncao_grupo_empresa SET repre_substituto='$cod_membro' WHERE cod_cad_grupo_empresa='$cod_cad_grupo_empresa'");
       }
    }
    
    }

    $query5 = mysqli_query($conexao->conectar(),"UPDATE membros SET cpf_membro = '$cpf', nome_membro = '$nome',niver_membro='$aniversario',papel_membro_papel='$papel',cod_membro_empresa='$cod_empresa' WHERE cod_membro='$cod_membro'");
    

    
    //SE NÃO FOI DEFINIDO UM PROLOGAMENTO DA VALIDADE VAI RETORNAR FALSE SENÃO RETORNA A DATA
    if($expira==false){
    
    if($senha!=false){
    $query6 = mysqli_query($conexao->conectar(),"UPDATE acesso SET usuario = '$usuario', senha = '$senha',nivel_acesso='$nivel' WHERE cod_membro_acesso='$cod_membro'");
    }else{
    $query6 = mysqli_query($conexao->conectar(),"UPDATE acesso SET usuario = '$usuario',nivel_acesso='$nivel' WHERE cod_membro_acesso='$cod_membro'");
    }
    }else{
    if($senha!=false){
    $query6 = mysqli_query($conexao->conectar(),"UPDATE acesso SET usuario = '$usuario', senha = '$senha',nivel_acesso='$nivel',membro_expira='$expira' WHERE cod_membro_acesso='$cod_membro'");
    }else{
    $query6 = mysqli_query($conexao->conectar(),"UPDATE acesso SET usuario = '$usuario',nivel_acesso='$nivel',membro_expira='$expira' WHERE cod_membro_acesso='$cod_membro'");
    }
        
    }
    //validar
    if($query5==true && $query6==true){
        return true;
    }else{
        return false;
    }
    
     
    }
    
    
}
    
public function adicionarEmail($membroId,$email){
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"INSERT INTO emails(cod_email_membro,end_email) VALUES('$membroId','$email')");
    
    if($query)
     return true;
    else
     return false;
}
    
   
public function excluirEmail($emailId){
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"DELETE FROM emails WHERE emails.cod_email = '$emailId'");
    
    if($query)
    return true;
    else
    return false;
}    
    
public function mudarEmail($emailId,$email){
    
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"UPDATE emails SET end_email='$email' where cod_email='$emailId'");
    
    if($query)
    return true;
    else
    return false;
    
}


public function adicionarTelefone($membroId,$membro){
    
    $conexao = new Conexao();
    
    $ddd = $membro->getDdd();
    $numero = $membro->getNumero2();
    $tipo = $membro->getTipo();
    
    $query = mysqli_query($conexao->conectar(),"INSERT INTO tels(cod_tel_membro,tel_ddd,num_tel,tipo_tel) VALUES('$membroId','$ddd','$numero','$tipo')");
    
    if($query)
     return true;
    else
     return false;
    
}
    
 
public function excluirTelefone($telefoneId){
    
    $conexao = new Conexao();
    
    $query = mysqli_query($conexao->conectar(),"DELETE FROM tels WHERE cod_tel = '$telefoneId'");
    
    if($query)
    return true;
    else
    return false;
    
}    
    
public function mudarTelefone($telefoneId,$membro){
    
    $conexao = new Conexao();
    $ddd = $membro->getDdd();
    $numero = $membro->getNumero2();
    $tipo = $membro->getTipo();
    
    $query = mysqli_query($conexao->conectar(),"UPDATE tels SET tel_ddd='$ddd',num_tel='$numero',tipo_tel='$tipo' where cod_tel='$telefoneId'");
    
    if($query)
    return true;
    else
    return false;
    
}


 
 
  //Inserir o membro nas tabelas do banco de dados
 public function inserir($membro){
    
     
    $mysqli = new mysqli("35.199.110.234","unace", "james56118992", "u253536359_nuwe") or die ("deu erro");     
     $cpf = $membro->getCpf();
     $nome = $membro->getNome();
     $aniversario = $membro->getAniversario();
     $foto = $membro->getFoto();
     $papel = $membro->getPapel();
     $cod_empresa = $membro->getCod_empresa();
     $ddd = $membro->getDdd();
     $email = $membro->getEmail();
     $nivel = $membro->getNivel();
     $numero2 = $membro->getNumero2();
     $tipo = $membro->getTipo();
     $senha = $membro->getSenha();
     $rua = $membro->getRua();
     $bairro = $membro->getBairro();
     $cep = $membro->getCep();
     $cidade = $membro->getCidade();
     $estado = $membro->getEstado();
     $complemento = $membro->getComplemento();
     $numero = $membro ->getNumero();
     $usuario = $membro ->getUsuario();
     $expira = $membro ->getExpira();
     
     //Inserir endereço
     $query0 = mysqli_query($mysqli,"INSERT INTO endereco(descricao,cep,rua,bairro,numero,complemento,tipo,cidade,estado) VALUES ('$nome','$cep','$rua','$bairro','$numero','$complemento','1','$cidade','$estado')") or die("deu erro");
     
     $id_endereco = mysqli_insert_id($mysqli);
     
     //Verificar se foi inserido
     if($id_endereco!=0){
     
     //Inserir membro
     $query = mysqli_query($mysqli,"INSERT INTO membros(cpf_membro,nome_membro,niver_membro,foto,papel_membro_papel,cod_membro_empresa,cod_membro_endereco) VALUES ('$cpf','$nome','$aniversario','$foto','$papel','$cod_empresa','$id_endereco')") or die("deu erro");
     
     //Pegar o id do membro
     $id_membro = mysqli_insert_id($mysqli);
    
     $tamanho = count($email);
        
     for($i = 0;$i<$tamanho;$i++){
     //Inserir na tabela emails
     $query2 = mysqli_query($mysqli,"INSERT INTO emails(cod_email_membro,end_email) VALUES ('$id_membro','$email[$i]')") or die("deu erro");
     
     }
     
     //Inserir na tabela telefone
        $tamanho = count($numero2);
        
        for($i = 0;$i<$tamanho;$i++){
            
        $query3 = mysqli_query($mysqli,"INSERT INTO tels(cod_tel_membro,num_tel,tipo_tel,tel_ddd) VALUES('$id_membro','$numero2[$i]','$tipo[$i]','$ddd[$i]')")or die("deu erro");
            
        }
        
     
     
     //Inserir na tabela de acesso
     $query4 = mysqli_query($mysqli,"INSERT INTO acesso(usuario,senha,cod_membro_acesso,nivel_acesso,membro_expira) VALUES('$usuario','$senha','$id_membro','$nivel','$expira')")or die("deu erro");
     
     //Validar se deu tudo certo.
     if($query==true && $query2==true && $query3==true && $query4==true){return true;}else{return false;}
     
      }
      

     
}


}






?>
