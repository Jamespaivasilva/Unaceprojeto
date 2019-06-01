<?php
   //ignorar erros e alertas
   error_reporting(0);
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
       $query = mysqli_query($conexao->conectar(),"SELECT * FROM empresas");
       
       $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM grupos");
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Empresa a Grupo</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

   <link rel="stylesheet" href="../css/empresagrupo.css">
   <!-- CSS do Bootstrap -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   
</head>
<body>
   <?php
      //Mostrar o modal para confirmar presença ou ausencia
      include('../funcionalidade/verificarparticipacaoreuniao.php');
      ?>
   <!-- Menu!-->
   <?php require_once('menu.php')?>
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-4"></div>
         <div class="col-md-4">
            <center>
               <h3 class="page-header">Vincular Empresa a grupo</h3>
            </center>
         </div>
      </div>
      <br/><br/>
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <form  name="empresagrupo" class="empresagrupo" action="../funcionalidade/empresagrupo.php" method="post">
               <?php if(isset($_GET['resultado'])){if($_GET['resultado']!="fail"){echo '<div class="alert alert-success" role="alert">Empresa vinculada ao grupo com sucesso!</div>';}
                  else{echo '<div class="alert alert-danger" role="alert">Membro já pertece a grupos!</div>';}
                  }?>
               <br/>
               <label class="categoria" for="exampleFormControlSelect1">Empresa:</label>
               <select name="empresa" id="empresa" class="form-control empresa js-example-basic-single" id="exampleFormControlSelect1" required>
                  <option></option>
                  <!-- Passar todos os valores de categória -->
                  <?php while($valor =  mysqli_fetch_array($query)) { ?>
                  <option value="<?php echo $valor['cod_empresa'] ?>"><?php echo $valor['nome_empresa'] ?></option>
                  <?php } ?>
               </select>
               <br/><br>
               <label class="categoria" for="exampleFormControlSelect1">Grupo:</label>
               <select name="grupo" class="form-control" id="exampleFormControlSelect1" required>
                  <!-- Passar todos os valores de categória -->
                  <?php while($valor =  mysqli_fetch_array($query2)) { ?>
                  <option value="<?php echo $valor['cod_grupo'] ?>"><?php echo $valor['nome_grupo']; ?></option>
                  <?php } ?>
               </select>
               <br/>
               <br/>
               <label class="categoria" for="exampleFormControlSelect1">Representante titular:</label>
               <div class="mostrar"></div>
               <br/>
               <label class="categoria" for="exampleFormControlSelect1">Representante substituto:</label>
               <div class="mostrar2"></div>
               <br/>
               <label for="exampleFormControlSelect1">Data do vínculo:</label>
               <input type="date"  class="form-control data" name="data" placeholder="Data de vinculo" required>
               <br/><br/>
               <button  type="button" style="width:100%" id="cadastrar" class="btn btn-success">Vincular</button>
         </div>
         </form>
      </div>
   </div>
   
   <!---------------------------------- Script--------------------------------------------------->   
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="../scripts/empresagrupo.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</body>
<br/><br/><br/>
<?php require_once("rodape.php");?>
</html>
