<?php
  
   //impedir que quem não acessou tenha acesso ao conteúdo da página!
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
         
         //Fazer a pesquisa no banco para listar reuniões
         $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM grupos");
         
         $membro = $_SESSION['id'];
     
     ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
   <title>Negócio</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   
   <!-- CSS -->
   <link rel="stylesheet" href="../css/negocio.css">
   <link rel="stylesheet" href="../css/parsley.css">
   <!-- CSS do Bootstrap -->
   <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
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
   <!-- Formulário -->
   <div class="container-fluid">
      <form name="form1" class="formulario"  method="post" action="../funcionalidade/negocio.php" data-parsley-validate="">
         <div class="form-group">
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                  <center>
                     <h3 class="page-header">Negócio fechado</h3>
                  </center>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <!-- avisar se teve sucesso -->
                  <?php if(isset($_GET['resultado'])){echo '<div class="alert alert-success" role="alert">Negócio fechado registrado com sucesso!</div>';}?>
                  <br/>
                  <input type="hidden" name="cadastrou" value="<?php echo $membro; ?>" class="cadastrou" /> 
                  <label for="exampleFormControlSelect1">Obrigado(a):</label>
                  <select name="quem" class="selectpicker form-control quem" data-show-subtext="true" data-live-search="true" required>
                     <?php while($sql = mysqli_fetch_array($query)){ ?>
                     <option  value="<?php echo $sql['cod_membro']?>"><?php echo iconv("UTF-8", "ISO-8859-1",$sql['nome_membro']); ?></option>
                     <?php }?>
                  </select>
                  <br/><br/>
                  <label for="exampleFormControlSelect1">Data:</label>
                  <input type="date" name="data" class="form-control data" required/>  
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <input type="radio"  name="negocio"  value="novo" class="negocio parsley-validated" required=""/> Novo negócio
               </div>
               <div class="col-md-2">
                  <input type="radio" name="negocio" value="repetido" class="negocio"/> Repetição de negócio
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <input type="radio" name="referencia"  value="interna" class="referencia" required="" /> Referência interna
               </div>
               <div class="col-md-2">
                  <input type="radio" name="referencia" value="externa" class="referencia"/> Referência externa
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-4">
                  <label for="exampleFormControlSelect1">Referência gerou R$:</label>
                  <input type="text" name="gerou" class="form-control gerou" placeholder="R$" required/>    
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <label for="exampleFormControlSelect1">Comentários:</label>
                  <textarea name="comentario" class="form-control comentario" rows="6" placeholder="Comentários"></textarea>    
               </div>
            </div>
            <br/><br/><br/>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4"><button  type="submit" style="width:100%" class="btn btn-success cadastrar">Cadastrar</button></div>
      </form>
      </div>
      <br/><br/>
      </div>
   </div>
   
<!--------------------------------------------------------------------- Script-------------------------------------------->    
   <script src="../scripts/empresa2.js"></script>
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
   <script src="../scripts/negocio.js"></script>
   <script src="../scripts/parsley.js"></script>
</body>

<?php require_once("rodape.php");?>
</html>
