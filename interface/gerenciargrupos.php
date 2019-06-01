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
        
         //Fazer a pesquisa no banco para listar empresas
         $query = mysqli_query($conexao->conectar(),"SELECT * FROM grupos");
         
         
     
     ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Gerenciar membros</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="../css/gerenciarmembros.css">
   <link rel="stylesheet" href="../css/parsley.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
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
      <div class="form-group">
         <center>
            <h3 class="page-header">Gerenciar grupos</h3>
         </center>
      </div>
      <br/><br/>
      <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo "<div class='alert alert-success' role='alert'>Ação realizada com sucesso!</div><br/><br/>";}else if($_GET['resultado']=="fail"){echo "<div class='alert alert-danger' role='alert'>Ação não realizada!</div><br/><br/>";}else if($_GET['resultado']=="usuario"){echo "<div class='alert alert-danger' role='alert'>Usuário já existe!</div><br/><br/>";}}?>
      <table id="myTable" class="table cell-border stripe hover" width="100%">
         <thead>
            <tr>
               <th scope="col">Ordem</th>
               <th scope="col">Nome</th>
               <th>Fundação</th>
               <th>Editar</th>
            </tr>
         </thead>
         <?php
            $cont=1;
            while($sql = mysqli_fetch_array($query)){?>
         <tr>
            <td><?php echo $cont++; ?></td>
            <td><?php echo $sql['nome_grupo']; ?></td>
            <td><?php echo str_replace('-','/',date('d/m/Y', strtotime($sql['fundacao_grupo'])));  ?></td>
            <td><button type="button" class="btn btn-warning editar" data-target="#model" data-toggle="modal" value="<?php echo $sql['cod_grupo']?>">Editar</button></td>
         </tr>
         <?php } ?>
         </tbody>
      </table>
   </div>
   <!-- Modal para confirmar a exclusão-->
   <div class="modal" id="conf" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <div class='alert alert-danger' role='alert'>Aviso importante!</div>
               </h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <p>Tem certeza que quer completar essa ação ?</p>
               <form  action="../funcionalidade/excluircategoria.php" method="get">
            </div>
            <div class="modal-footer">
            <input type="hidden" name="categoriaId"  class="categoriaId"/>
            <button type="button" class="btn btn-success" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-danger">Confirmar</button>
            </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal  para editar -->
   <div class="modal" id="model" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header" style="background-color:#00A650">
               <center>
                  <h3 class="modal-title text-center"></h3>
               </center>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="container-fluid" width="100%">
                  <form name="form1" class="formulario"  method="post" data-parsley-validate="" action="../funcionalidade/editargrupo.php">
                     <div class="form-group">
                        <br/>
                        <div class="row">
                           <div class="col-md-2">
                           </div>
                           <div class="col-md-6">
                              <h3>Editar grupo</h3>
                           </div>
                        </div>
                        <br/>
                        <div class="row">
                           <div class="col-md-2">
                           </div>
                           <div class="col-md-6">
                              <br/> <br/>
                              <div class="form-group">
                                 <input type="hidden"  name="cod_grupo" class="cod_grupo"/>
                                 <label for="exampleFormControlSelect1">Nome:</label>
                                 <input type="text" class="form-control nome" name="nome" placeholder="Nome do grupo" maxlength="120" required/>
                              </div>
                              <div class="form-group">
                                 <label for="exampleFormControlSelect1">Fundação:</label>
                                 <input type="date" class="form-control fundacao" name="fundacao"  placeholder="Data da fundação do grupo" required/>
                              </div>
                              </br>
                              <button  type="submit" style="width:100%" class="btn btn-success cadastrar">Alterar</button>
                           </div>
                  </form>
                  </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer" style="background-color:#00A650">
               <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Fechar</button>
            </div>
         </div>
      </div>
   </div>
   </div>

<!-- Script-->    
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
   <script src="../scripts/parsley.js"></script>
   <script src="../scripts/gerenciargrupo.js"></script>
</body>
<br/><br/><br/><br/><br/>
<?php require_once("rodape.php");?>
</html>