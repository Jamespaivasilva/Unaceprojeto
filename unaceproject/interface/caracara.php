<?php
   
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
         $membro = $_SESSION['id'];
           
     ?>
<!DOCTYPE html>
<html lang="pt-br">
    
<head>
   
   <meta charset="utf-8">
   <title>Cara-a-Cara</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <meta name="viewport" content="width=device-width initial-scale=1">
   
   <!-- CSS --> 
   <link rel="stylesheet" href="../css/caracara.css" />
   <link rel="stylesheet" href="../css/parsley.css">
   <!-- CSS do Bootstrap -->
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
   
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
      <form name="form1" class="formulario"  method="post" data-parsley-validate="" action="../funcionalidade/caracara.php">
         <div class="form-group">
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                  <center>
                     <h3 class="page-header">Cara-a-Cara</h3>
                  </center>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <!-- avisar se teve sucesso -->
                  <?php if(isset($_GET['resultado'])){echo '<div class="alert alert-success"  role="alert">Cara-a-Cara registrado com sucesso!</div>';}?>
                  <br/>
                  <input type="hidden" name="registrou" value="<?php echo $membro ?>"  class="registrou"/>
                  <label for="exampleFormControlSelect1">Com quem ?:</label>
                  <select name="quem" class="selectpicker form-control quem" data-show-subtext="true" data-live-search="true" required>
                     <?php while($sql = mysqli_fetch_array($query)){ ?>
                     <option  value="<?php echo $sql['cod_membro']?>"><?php echo iconv("UTF-8", "ISO-8859-1",$sql['nome_membro'])?></option>
                     <?php }?>
                  </select>
                  <br/><br/>
                  <label for="exampleFormControlSelect1">Data:</label>
                  <input type="date" class="form-control data" name="data"  placeholder="Data" >
                  <!--<label for="exampleFormControlSelect1">CEP:</label>-->
                  <input type="hidden" class="form-control cep" name="cep" placeholder="CEP" >
                  <!--<label for="exampleFormControlSelect1">Rua:</label>-->
                  <input type="hidden" class="form-control rua" name="rua" placeholder="Rua" >
                  <!--<label for="exampleFormControlSelect1">Bairro:</label>-->
                  <input type="hidden" class="form-control bairro" placeholder="Bairro" name="bairro">
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
                  <label for="exampleFormControlSelect1">Local de encontro:</label>
                  <input type="text" name="endereco" class="form-control endereco"  maxlength="120" placeholder="Local de encontro:" required/>
                  <br/>
                  <label for="exampleFormControlSelect1">Conversa:</label>
                  <textarea class="form-control conversa" rows="6" name="conversa" placeholder="Conversa:"></textarea>
               </div>
            </div>
            <br/><br/>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4"><button  type="submit" style="width:100%" class="btn btn-success cadastrar">Registrar</button></div>
      </form>
      </div>
      </div>
   </div>
   
   
<!---------------------------------- Scripts ------------------------->    
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
   <script src="../scripts/parsley.js"></script>
</body>

<?php require_once("rodape.php");?>
</html>
