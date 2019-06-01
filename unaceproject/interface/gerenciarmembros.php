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
         $query = mysqli_query($conexao->conectar(),"SELECT DISTINCT cod_membro_empresa,foto,nome_membro,nivel_acesso,membro_expira,cod_membro FROM membros INNER JOIN acesso on membros.cod_membro=acesso.cod_membro_acesso 
         INNER JOIN empresas on membros.cod_membro_empresa=empresas.cod_empresa
        
         ");
         
        
         $query2 =  mysqli_query($conexao->conectar(),"SELECT * FROM empresas");
         
         
         $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM grupos");
         
     
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
   <!-- Formulário -->
   <div class="container-fluid">
      <div class="form-group">
         <center>
            <h3 class="page-header">Gerenciar membros</h3>
         </center>
      </div>
      <br/><br/>
      <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo "<div class='alert alert-success' role='alert'>Ação realizada com sucesso!</div><br/><br/>";}else if($_GET['resultado']=="fail"){echo "<div class='alert alert-danger' role='alert'>Ação não realizada!</div><br/><br/>";}else if($_GET['resultado']=="usuario"){echo "<div class='alert alert-danger' role='alert'>Usuário já existe!</div><br/><br/>";}}?>
      <table id="myTable" class="table cell-border stripe hover" width="100%">
         <thead>
            <tr>
               <th scope="col">Ordem</th>
               <th scope="col">Foto</th>
               <th scope="col">Nome</th>
               <th scope="col">Grupo</th>
               <th>Acesso</th>
               <th scope="col">Vencimento</th>
               <th>Editar</th>
               <th>Bloquear</th>
            </tr>
         </thead>
         <?php 
            $cont=1;
            while($sql = mysqli_fetch_array($query)){?>
         <tr>
            <td><?php echo $cont++; ?></td>
            <th><img style="max-width:100px; max-height:85px;"src="fotos/<?php  if($sql['foto']!=""){echo $sql['foto'];}else{echo "padrao.png";}?>"/></th>
            <td><?php echo iconv("UTF-8", "ISO-8859-1",$sql['nome_membro']); ?></td>
            <?php 
               $empresa = $sql['cod_membro_empresa'];
               $codmembro = $sql['cod_membro'];
               $query4 =  mysqli_query($conexao->conectar(),"SELECT * from juncao_grupo_empresa inner join grupos on juncao_grupo_empresa.cod_cad_grupo_empresa_grupo=grupos.cod_grupo where repre_titular='$codmembro' or repre_substituto='$codmembro'");
               $sql2 = mysqli_fetch_assoc($query4); ?>
            <td><?php echo iconv("UTF-8", "ISO-8859-1",$sql2['nome_grupo']); ?></td>
            <td>
               <?php if($sql['nivel_acesso']==0){echo "bloqueado";}else if($sql['nivel_acesso']==1){echo "Membro";}else if($sql['nivel_acesso']==2){echo "Administrador";}?>
            </td>
            <td>
               <?php echo str_replace('-','/',date('d/m/Y', strtotime($sql['membro_expira']))); ?>
            </td>
            <td>
               <button type="button"  class="btn btn-warning editar" data-target="#model" data-toggle="modal" value="<?php echo $sql['cod_membro']; ?>">Editar</button>
            </td>
            <?php if($sql['nivel_acesso']!=0){ ?>
            <td>
               <button type="button" data-target="#conf" data-toggle="modal" value="<?php echo $sql['cod_membro']; ?>" class="btn btn-danger bloqueiar">Bloquear</button>
            </td>
            <?php }else{?>
            <td>
               <button type="button" data-target="#confdes" data-toggle="modal" value="<?php echo $sql['cod_membro']; ?>" class="btn btn-success desbloquear">Desbloquear</button>
            </td>
            <?php }?>
         </tr>
         <?php } ?>
         </tbody>
      </table>
   </div>
   <!-- Modal para confirmar o bloqueio -->
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
               <p>Completando essa ação você vai impedir que o membro possa ter acesso ao seus registro dentro da plataforma da Unace. É preciso avaliar bem.</p>
               <form name="bloquear" action="../funcionalidade/bloquearmembro.php" method="get">
            </div>
            <div class="modal-footer">
            <input type="hidden" name="acao" value="bloquear"/>
            <input type="hidden" name="membroId"  class="membroId"/>
            <button type="button" class="btn btn-success" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-danger">Confirmar bloqueio</button>
            </form>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal para confirmar o desbloqueio -->
   <div class="modal" id="confdes" tabindex="-1" role="dialog">
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
               <p>Completando essa ação você vai permitir que o membro possa ter acesso a suas informações no sistema. É preciso avaliar bem.</p>
               <form name="desbloquear" action="../funcionalidade/bloquearmembro.php" method="get">
            </div>
            <div class="modal-footer">
            <input type="hidden" name="acao" value="desbloquear"/>
            <input type="hidden" name="membroId"  class="membroId"/>
            <button type="button" class="btn btn-success" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-danger">Confirmar desbloqueio</button>
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
                  <form name="form1" class="formulario" enctype="multipart/form-data" method="post" data-parsley-validate="" action="../funcionalidade/mudarmembro.php">
                     <div class="form-group">
                        <br/>
                        <div class="row">
                           <div class="col-md-4">
                           </div>
                           <div class="col-md-6">
                              <h3>Editar Membro</h3>
                           </div>
                        </div>
                        <br/>
                        <div class="row">
                           <div class="col-md-2">
                           </div>
                           <div class="col-md-6">
                              <br/> <br/>
                              <input type="hidden" class="form-control cod_membro" name="cod_membro" placeholder="Nome da empresa" required/>
                              <div class="form-group">
                                 <label for="exampleFormControlSelect1">Nome:</label>
                                 <input type="text" class="form-control nome" name="nome" maxlength="150" placeholder="Nome da empresa" required/>
                              </div>
                              <div class="form-group">
                                 <label for="exampleFormControlSelect1">CPF:</label>
                                 <input type="text" class="form-control cpf" name="cpf"  placeholder="CPF" required/>
                              </div>
                              <div class="form-group">
                                 <label for="exampleFormControlSelect1">Data de nascimento:</label>
                                 <input type="date" class="form-control nascimento" name="nascimento" required/>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="exampleFormControlSelect1">Empresa</label>
                              <select class="form-control empresa" name="empresa">
                                 <?php while($sql = mysqli_fetch_array($query2)) {?>
                                 <option value="<?php echo $sql['cod_empresa']?>"><?php echo $sql['nome_empresa']; ?></option>
                                 <?php  }?>
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="exampleFormControlSelect1">Papel</label>
                              <select name="papel" class="form-control papel">
                                 <option value="1">Titular</option>
                                 <option value="2">Substituto</option>
                              </select>
                           </div>
                           <input type="hidden" name="pgrupo" class="pgrupo"/>
                           <div class="form-group">
                              <label>Grupo</label>
                              <p style="color:red;">Atenção!! Trocando o grupo as conquistas do grupo atual não serão desvinculadas.</p>
                              <select name="grupo" class="form-control grupos">
                                 <?php while($sql=mysqli_fetch_array($query3)) { ?>
                                 <option value="<?php echo $sql['cod_grupo']; ?>"><?php echo $sql['nome_grupo']; ?></option>
                                 <?php }?>
                              </select>
                           </div>
                           </br>
                           <div class="form-group">
                              <h4><u><i>Acesso</i></u></h4>
                           </div>
                           <br/>
                           <div class="form-group">
                              <label for="exampleFormControlSelect1">Nível de acesso:</label>
                              <select name="nivel" class="nivel form-control">
                                 <option value="1">Membro</option>
                                 <option value="2">Administrador</option>
                              </select>
                           </div>
                           <input type="hidden" name="vencimento" class="vencimento"/>
                           <div class="form-group">
                              <label for="exampleFormControlSelect1">Extender validade:</label>
                              <select name="validade" class="form-control" required>
                                 <option value="0"></option>
                                 <option value="4">1 mês</option>
                                 <option value="6">6 meses</option>
                                 <option value="1">1 anos</option>
                                 <option value="2">2 anos</option>
                                 <option value="5">5 anos</option>
                              </select>
                           </div>
                           <div class="form-group">
                              <label for="exampleFormControlSelect1">Usuario:</label>
                              <input type="hidden" class="usuarioatual" name="usuarioatual"/>
                              <input type="text" class="form-control usuario" name="usuario" placeholder="usuario" required/>
                           </div>
                           <div class="form-group">
                              <label for="exampleFormControlSelect1">Senha nova:</label>
                              <input type="password" class="form-control nova" name="senha" id="senha" placeholder="Senha nova" />
                           </div>
                           <div class="form-group">
                              <label for="exampleFormControlSelect1">Confirmar nova senha:</label>
                              <input type="password" class="form-control" name="nova" placeholder="Senha nova" data-parsley-equalto="#senha"/>
                           </div>
                           <div class="form-group">
                           </div>
                           <br/>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button  type="submit" style="width:100%" class="btn btn-success cadastrar">Alterar</button></div>
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
   <script src="../scripts/gerenciarmembros.js"></script>
</body>
<br/><br/><br/><br/><br/>
<?php require_once("rodape.php");?>
</html>
