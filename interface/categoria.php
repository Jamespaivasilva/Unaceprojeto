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
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">
    
<head>
    <meta charset="utf-8">
   <title>Categoria</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="../css/login.css">
   <link rel="stylesheet" href="../css/parsley.css">
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
               <h3 class="page-header">Cadastrar categoria</h3>
            </center>
         </div>
      </div>
      <br/><br/>
      <div class="row">
         <div class="col-md-4"></div>
         <div class="col-md-4">
            <form action="../funcionalidade/categoria.php" method="post" data-parsley-validate="">
               <?php if(isset($_GET['resultado'])){echo '<div class="alert alert-success" role="alert">Categoria cadastrada com sucesso!</div>';}?>
               <label for="exampleFormControlSelect1">Primeira categoria:</label>
               <input type="text" class="form-control" name="pri_cat" maxlength="150" placeholder="primeira categoria" required>
               <br/>
               <label for="exampleFormControlSelect1">Segunda categoria:</label>
               <input type="text"  class="form-control" name="sec_cat" maxlength="150" placeholder="segunda categoria" required>
               <br/>
               <button  type="submit" style="width:100%" class="btn btn-success cadastrar">Cadastrar</button>
         </div>
         </form>
      </div>
   </div>
   
<!-- Scripts-->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>  
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="../scripts/parsley.js"></script>
   <script src="../scripts/categoria.js"></script>
</body>
<br/><br/><br/><br/><br/><br/>
<?php require_once("rodape.php");?>
</html>