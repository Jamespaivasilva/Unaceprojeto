<?php
   
   //impedir que quem não acessou tenha acesso ao conteúdo da página!
   require_once("../classes/validar.php");
   
   
   $validar = new Validar();
   $validar->sessao();
   
   //Validar se tem permissão de acesso a página
   $nivel = $_SESSION['nivel'];
   
   // se o nível não for dois, levaremos o usuario a pagina inicial
   if($nivel!=2){
       echo '<script>alert("Você não tem permissão para acessar essa página!"); window.location.href = "https://unace.000webhostapp.com/interface/inicio.php"</script>';
   }
   
   
      // Conectar ao banco, pra que ? Para puxar todos os registros de categorias
      require_once('../classes/conexao.php');
      
      // Instanciar class Conexão
       $conexao = new Conexao();
      
      //Iniciar o metódo para conectar
       $conexao->conectar();
      
       //Fazer a pesquisa no banco
       $query = mysqli_query($conexao->conectar(),"SELECT * FROM categorias");
       
      
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Empresa</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="../css/parsley.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
      <form name="form1" enctype="multipart/form-data" class="formulario" method="post" action="../funcionalidade/empresa.php" data-parsley-validate="" >
         <div class="form-group">
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                  <center>
                     <h3 class="page-header">Cadastro de empresa</h3>
                  </center>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <!-- avisar se teve sucesso ou nao -->
                  <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo '<div class="alert alert-success" role="alert">Empresa cadastrada com sucesso!</div><br/>';}else{
                     echo '<div class="alert alert-danger" role="alert">Erro! CNPJ já cadastrado no sistema!</div>';
                     } } ?>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Nome da empresa:</label>
                     <input type="text" class="form-control empresa" name="empresa" maxlength="110" placeholder="Nome da empresa" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">CNPJ:</label>
                     <input type="text" class="form-control cnpj" name="cnpj"  placeholder="CNPJ" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Data da fundação da empresa:</label>
                     <input type="date" class="form-control fundacao" name="fundacao" >
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Data de adesão ao UNACE:</label>
                     <input type="date" class="form-control unace" name="unace" required>
                  </div>
                  <div class="form-group">
                     <label class="categoria" >Categória da empresa</label>
                     <select name="categoria" class="form-control js-example-basic-single" id="exampleFormControlSelect1" required>
                        <!-- Passar todos os valores de categória -->
                        <?php while($valor =  mysqli_fetch_array($query)) { ?>
                        <option value="<?php echo $valor['cod_cat'] ?>"><?php echo $valor['pri_cat'] ."  |  ".$valor['sec_cat']; ?></option>
                        <?php } ?>
                     </select>
                     <a href="categoria.php">Cadastrar nova categoria</a>
                  </div>
                  <br/>
                  <div class="form-group">
                     <label for="exampleFormControlTextarea1">Descrição da empresa:</label>
                     <textarea class="form-control" name="descricao" id="exampleFormControlTextarea1" rows="3" maxlength="900" placeholder="Descrição da empresa:" ></textarea>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlTextarea1">Logo:</label>
                     <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
                     <input type="file" name="arquivo"/>
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
 <!-----------------------------------------------------scripts---------------------------------------------------------- !>
 <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="../scripts/empresa2.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
   <script src="../scripts/parsley.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
</body>

<?php require_once("rodape.php");?>
</html>
