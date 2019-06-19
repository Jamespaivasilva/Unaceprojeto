<?php
   /
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
       $query = mysqli_query($conexao->conectar(),"SELECT * FROM endereco where tipo=2");
   
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Disponibilidade</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="../css/disponibilidade.css">
   <!-- CSS do Bootstrap -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
</head>
<body>
  
   <!-- Menu!-->
   <?php require_once('menu.php')?>
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-4"></div>
         <div class="col-md-4">
            <center>
               <h3 class="page-header">Adicionar disponibilidade</h3>
            </center>
         </div>
      </div>
      <br/><br/>
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-6">
            <form action="../funcionalidade/disponibilidade.php" method="post">
               <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo '<div class="alert alert-success" role="alert">Disponibilidade adicionada com sucesso!</div>';}elseif($_GET['resultado']=="fail"){
                  echo '<div class="alert alert-danger" role="alert">Erro! Data e horários já cadastrados!</div>';
                  }else{echo '<div class="alert alert-warning" role="alert">Erro! A empresa não tem agendamento nos finais de semana!</div>';} } ?>
               <br/>
               <label for="exampleFormControlSelect1">Local:</label>
               <select name="endereco" class="form-control" id="exampleFormControlSelect1" required>
                  <!-- Passar todos os valores de categória -->
                  <?php while($valor =  mysqli_fetch_array($query)) { ?>
                  <option value="<?php echo $valor['cod_endereco'] ?>"><?php echo $valor['descricao'] ."  |  ".$valor['cidade']; ?></option>
                  <?php } ?>
               </select>
               <br/>
               <label for="exampleFormControlSelect1">Data:</label>
               <input type="date" class="form-control" name="data" placeholder="data" required>
         </div>
      </div>
      <br/>
      <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-2">
      <label for="exampleFormControlSelect1">Horário inicial</label>
      <select class="form-control" name="inicial">
      <option>06:30</option>
      </select>
      </div>
      <div class="col-md-2">
      <label for="exampleFormControlSelect1">Horário final:</label>
      <select class="form-control" name="final">
      <option>09:00</option>
      </select>
      </div>
      </div>
      <br/><br/>
      <div class="row">
      <div class="col-md-2"></div>
      <div class="col-md-4">
      <br/>
      <button  type="submit" style="width:100%" class="btn btn-success cadastrar">Adicionar</button>
      </form>
      </div>
      </div>
   </div>
   
<!------------------------------------------------------------------ Script---------------------------------------------------------->    
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

<?php require_once("rodape.php");?>
</html>
