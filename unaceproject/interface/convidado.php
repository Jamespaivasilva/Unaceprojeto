<?php
   //ignorar erros e alertas
   error_reporting(0);
   //impedir que quem não logou, tenha acesso ao conteúdo da página!
   require_once("../classes/validar.php");
   
   
   
   $validar = new Validar();
   $validar->sessao();
        // Conectar ao banco, pra que ? Para puxar todos os registros de categorias
        require_once('../classes/conexao.php');
        
        // Instanciar class Conexão
         $conexao = new Conexao();
         
        //Iniciar o metódo para conectar
         $conexao->conectar();
         
         //Fazer a pesquisa no banco para listar empresas
         $query = mysqli_query($conexao->conectar(),"SELECT * FROM membros");
         
         
         //Fazer pesquisa no banco e pegar todas as categorias
         $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM categorias");
         
         
         // pegar o do membro para adicionar no registro de quem convidou
         $membro = $_SESSION['id'];
     
     ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Convidados</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->   
   <link rel="stylesheet" href="../css/convidado.css" />
   <link rel="stylesheet" href="../css/parsley.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  
</head>
<body>
   <?php
      //Mostrar o modal para confirmar presença ou ausencia
      include('../funcionalidade/verificarparticipacaoreuniao.php');
      ?>
   <!-- Menu!-->
   <?php require_once('menu.php')?>
   <!-- Formulário -->
   <div class="container-fluid">
      <form name="form1" class="formulario"  method="post" data-parsley-validate="" action="../funcionalidade/convidado.php">
         <div class="form-group">
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                  <center>
                     <h3 class="page-header">Adicionar convidado</h3>
                  </center>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <!-- avisar se teve sucesso -->
                  <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo "<div class='alert alert-success' role='alert'>Convidado registrado com sucesso!</div><br/><br/>";}else{echo "<div class='alert alert-success' role='alert'>Convidado não registrado!</div><br/><br/>";}}?>
                  <div class="form-group">
                     <input type="hidden" name="membro" value="<?php echo $membro; ?>" class="membro"/>
                     <label for="exampleFormControlSelect1">Nome do convidado:</label>
                     <input type="text" name="convidado" class="form-control convidado"  maxlength="100" placeholder="Nome do convidado" required/>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">CPF/CNPJ:</label>
                     <input type="text" name="cpfecnpj" class="form-control cpfecnpj" placeholder="Documento" required/>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">E-mail:</label>
                     <input type="email" name="email" class="form-control email" placeholder="E-mail do convidado" />
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Telefone:</label>
                     <input type="number" name="telefone" class="form-control telefone" placeholder="Telefone do convidado" required/>
                  </div>
                  
                  <!--<label for="exampleFormControlSelect1">CEP:</label>-->
                  <input type="hidden" class="form-control cep" name="cep" placeholder="CEP" >
                  <!--<label for="exampleFormControlSelect1">Rua:</label>-->
                  <input type="hidden" class="form-control rua" name="rua" placeholder="Rua" >
                  <!--<label for="exampleFormControlSelect1">Bairro:</label>-->
                  <input type="hidden" class="form-control bairro" placeholder="Bairro" name="bairro" >
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <!--<label for="exampleFormControlSelect1">Cidade e Estado:</label>-->
               </div>
            </div>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <input type="hidden" name="cidade" class="form-control cidade" placeholder="Cidade"/>
               </div>
               <div class="col-md-2">
                  <input type="hidden" name="estado" class="form-control estado" placeholder="Estado"/>
               </div>
               <div class="col-md-2">
                  <input type="hidden" name="numero" class="form-control numero" placeholder="Número"/>
               </div>
            </div>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <label for="exampleFormControlSelect1">Empresa:</label>
                  <input type="text" name="empresa" class="form-control empresa"  maxlength="100" placeholder="Empresa do convidado:"/>
                  <br/>
                  <div class="form-group">
                  <label class="categoria" for="exampleFormControlSelect1">Categória da empresa:</label>
                  <select name="categoria" class="form-control js-example-basic-single categoria" id="exampleFormControlSelect1" required>
                      <option></option>
                      <option value="outro">Outra categoria</option>
                     <!-- Passar todos os valores de categória -->
                     <?php while($valor =  mysqli_fetch_array($query2)) { ?>
                     <option value="<?php echo $valor['cod_cat'] ?>"><?php echo $valor['pri_cat'] ."  |  ".$valor['sec_cat']; ?></option>
                     <?php } ?>
                  </select>
                  </div>
                  <div class="form-group">
                      <div class="categoria2"></div>
                  </div>
               </div>
            </div>
            <br/><br/>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4"><button  type="submit" style="width:100%" class="btn btn-success cadastrar">Cadastrar</button></div>
      </form>
      </div>
      </div>
   </div>
   
 <!----------------------------------------------------------- Script------------------------------------------------------------------------>    
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
   <script src="../scripts/convidado.js"></script>
   <script src="../scripts/parsley.js"></script>
</body>
<br/><br/><br/>
<?php require_once("rodape.php");?>
</html>