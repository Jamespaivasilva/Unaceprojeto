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
      $query = mysqli_query($conexao->conectar(),"SELECT * FROM reunioes 
      INNER JOIN endereco on reunioes.cod_endereco=endereco.cod_endereco
      INNER JOIN disponibilidade on reunioes.cod_data_reuniao=disponibilidade.cod_disponibilidade
      ");
      
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Contribuições</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="../css/contribuicoes.css">
   <!-- CSS do Bootstrap -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
</head>
<body>
   <?php
      //Mostrar o modal para confirmar presença ou ausencia
      include('../funcionalidade/verificarparticipacaoreuniao.php');
      ?>
   <!-- Menu!-->
   <?php require_once('menu.php')?>
   <div class="container-fluid">
      <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo "<div class='alert alert-success' role='alert'>Ação realizada com sucesso!</div><br/><br/>";}else if($_GET['resultado']=="fail"){echo "<div class='alert alert-danger' role='alert'>Ação não realizada!</div><br/><br/>";}else if($_GET['resultado']=="usuario"){echo "<div class='alert alert-danger' role='alert'>Usuário já existe!</div><br/><br/>";}}?>
      <div class="row">
         <div class="col-md-4"></div>
         <div class="col-md-4">
            <center>
               <h3 class="page-header">Lista de presença</h3>
            </center>
         </div>
      </div>
      <br/><br/>
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <div class="form-group">
               <label class="categoria" for="exampleFormControlSelect1">Selecione a reunião:</label>
               <select name="reuniao" id="reuniao" class="reuniao js-example-basic-single form-control" required>
                  <option>Nenhuma reunião selecionada</option>
                  <!-- Passar todos os valores de categória -->
                  <?php while($valor =  mysqli_fetch_array($query)) { ?>
                  <option value="<?php echo $valor['cod_reuniao'] ?>"><?php echo $valor['titulo_reuniao']." | ".$valor['descricao']." | ".str_replace('-','/',date('d/m/Y', strtotime($valor['data_disponibilidade'])))." | ".$valor['hora_inicial']." até ".$valor['hora_final']; ?></option>
                  <?php } ?>
               </select>
            </div>
            </br></br>
         </div>
      </div>
      <!-- Vamos carregar a lista selecionada ! Usaremos ajax! -->
      <div class="row">
         <div class="col-md-2"></div>
         <div class="col-md-8">
            <div class="carregar"></div>
         </div>
      </div>
   </div>
   
 <!----------------------------- Script------------------------------------------->    
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
   <script>
      $(document).ready(function(){
      
      $('.js-example-basic-single').select2();
      
      $('.reuniao').change(function(){
          
          var valor = $('.reuniao').val();
          
          $.ajax({
      type: 'post',
      url: '../funcionalidade/listargrupo.php',
            data:{valor:valor},
            success:function(data){
               $('.carregar').html(data);  
            }
      
      })
      
          
      });
      
      <?php if(isset($_GET['selecionado'])){ ?>
           var valor = <?php echo $_GET['selecionado']; ?>
          $.ajax({
            type: 'post',
            url: '../funcionalidade/listargrupo.php',
            data:{valor:valor},
            success:function(data){
               $('.carregar').html(data);  
            }
      
         })
         
         <?php }?>
      });
         

   </script>
</body>

<?php require_once("rodape.php");?>
</html>
