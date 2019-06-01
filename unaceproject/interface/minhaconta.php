<?php
   //ignorar erros e alertas
   error_reporting(0);
   //impedir que quem não acessou tenha acesso ao conteúdo da página! 
   require_once("../classes/validar.php");
   
   
   
   $validar = new Validar();
   $validar->sessao();
   
   
        // Conectar ao banco, pra que ? Para puxar todos os registros de categorias
        require_once('../classes/conexao.php');
        
        // Instanciar class Conexão
         $conexao = new Conexao();
        
         
        $id = $_SESSION['id'];
        
         //Fazer a pesquisa no banco para listar empresas
         $query = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN emails on membros.cod_membro=emails.cod_email_membro INNER JOIN tels on membros.cod_membro=tels.cod_tel_membro INNER JOIN endereco on membros.cod_membro_endereco=endereco.cod_endereco INNER JOIN acesso on membros.cod_membro = acesso.cod_membro_acesso where cod_membro='$id'");
         
         //Fazer a pesquisa no banco para listar papeis
       
         //fazer uma busca no membro
         $sql=mysqli_fetch_array($query);
         
         $membro = $_SESSION['id'];
         
         $endereco = $sql['cod_endereco'];
         
         //fazer pesquisar de e-mails do membro
         $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM emails where cod_email_membro='$id'");
         
         $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM tels where cod_tel_membro='$id'");
     
     ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="utf-8">
   <title>Minha Conta</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="../css/minhaconta.css">
   <link rel="stylesheet" href="../css/parsley.css">
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
   <script src="../scripts/parsley.js"></script>
   <script src="../scripts/minhaconta.js"></script>
   <script>
      $(document).ready(function(){
       
       $(".nome").val("<?php echo $sql['nome_membro']?>");
       $(".cpf").val("<?php echo $sql['cpf_membro']?>");
       $(".nascimento").val("<?php echo $sql['niver_membro']?>");
       $(".bairro").val("<?php echo iconv("UTF-8", "ISO-8859-1",$sql['bairro'])?>");
       $(".cidade").val("<?php echo iconv("UTF-8", "ISO-8859-1",$sql['cidade']);?>");
       $(".estado").val("<?php echo iconv("UTF-8", "ISO-8859-1",$sql['estado']);?>");
       $(".numero").val("<?php echo $sql['numero']?>");
       $(".complemento").val("<?php echo iconv("UTF-8", "ISO-8859-1",$sql['complemento'])?>");
       $(".cep").val("<?php echo $sql['cep']?>");
       $(".rua").val("<?php echo iconv("UTF-8", "ISO-8859-1",$sql['rua']);?>");
       $(".usuario").val("<?php echo iconv("UTF-8", "ISO-8859-1",$sql['usuario']);?>");
       $(".foto2").val("<?php echo $sql['foto']?>");
       
      });
      
      
   </script>
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
      <form name="form1" class="formulario" enctype="multipart/form-data" method="post" data-parsley-validate="" action="../funcionalidade/minhaconta.php">
         <div class="form-group">
            <br/>
            <div class="row">
               <div class="col-xs-0 col-md-2"></div>
               <div class="col-xs-4 col-md-2">
                  </br>
                  <div><img src="fotos/<?php if($sql['foto']!=""){echo $sql['foto'];}else{echo 'padrao.png';} ?>" alt="..." style="max-height:150px; max-width:170px;" class=" img-thumbnail rounded "></div>
               </div>
               <div class="col-xs-2 col-md-0"></div>
               <div class="col-xs-4 col-md-2">
                  <h3 class="page-header mx-auto" style="width="145px;">Minha Conta</h3>
               </div>
               <div class="col-xs-2 col-md-4"></div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-4">
               </div>
               <div class="col-md-6">
                  <!-- avisar se teve sucesso -->
                  <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo '<div class="alert alert-success" role="alert">Dados alterado com sucesso!</div>';}else if($_GET['resultado']=="fail"){
                     echo '<div class="alert alert-danger" role="alert">Senha atual inválida!</div>';
                     }else{ echo '<div class="alert alert-warning" role="alert">Erro! E-MAIL já cadastrado no sistema!</div>'; } } ?>
                  <br/>
                  <div class="form-group">
                     <input type="hidden" name="endereco"  value="<?php echo $endereco; ?>"class="endereco" required/> 
                     <input type="hidden" name="membro"  value="<?php echo $membro; ?>"class="membro"/> 
                     <label for="exampleFormControlSelect1">Nome:</label>
                     <input type="text" class="form-control nome" name="nome" placeholder="Nome da empresa" required/>
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
            </br>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-6">
                  <div class="form-group">
                     <h4><u><i>Contatos</i></u></h4>
                  </div>
                  </br>
                  <div class="form-group">
                     <h5>E-mails</h5>
                     <table class="table-fixed table table-responsive">
                        <tr>
                           <td>Endereço</td>
                           <td>Editar</td>
                           <td>Excluir</td>
                        </tr>
                        <?php while($sql = mysqli_fetch_array($query2)){ ?>      
                        <tr>
                           <td><?php  echo $sql['end_email'];?></td>
                           <td><button type="button" name="editaremail" class="editaremail btn btn-warning emails" data-toggle="modal" data-target="#editarEmail" value="<?php echo $sql['cod_email'];?>">Editar</button></td>
                           <td><button type="button" name="excluiremail" class="excluiremail btn btn-danger" data-toggle="modal" data-target="#excluirEmail" value="<?php echo $sql['cod_email'];?>">Excluir</button></td>
                        </tr>
                        <?php }?>
                     </table>
                     <button type="button" class="btn btn-success maisemail" data-toggle="modal" data-target="#adicionarEmail">+ E-mail</button>
                  </div>
                  </br>
                  <div >
                     <h5>Telefone</h5>
                     <table class="table-fixed table table-responsive">
                        <tr>
                           <td>DDD</td>
                           <td>Número</td>
                           <td>Tipo</td>
                           <td>Editar</td>
                           <td>Excluir</td>
                        </tr>
                        <?php while($sql = mysqli_fetch_array($query3)){ ?>      
                        <tr>
                           <td><?php  echo $sql['tel_ddd'];?></td>
                           <td><?php  echo $sql['num_tel'];?></td>
                           <td><?php  echo $sql['tipo_tel'];?></td>
                           <td><button type="button" name="editaremail" class="editartelefone btn btn-warning" data-toggle="modal" data-target="#editarTelefone" value="<?php echo $sql['cod_tel'];?>">Editar</button></td>
                           <td><button type="button" name="excluiremail" class="excluirtelefone btn btn-danger" data-toggle="modal" data-target="#excluirTelefone" value="<?php echo $sql['cod_tel'];?>">Excluir</button></td>
                        </tr>
                        <?php }?>
                     </table>
                     <button type="button" data-toggle="modal" data-target="#adicionarTelefone" class="btn btn-success maistelefone">+Telefone</button>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4"></div>
            </div>
            <br/><br/>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-6">
                  <h4><u><i>Endereço</i></u></h4>
                  </br>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">CEP:</label>
                     <input type="text" class="form-control cep" name="cep" placeholder="CEP" required/>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Rua:</label>
                     <input type="text" class="form-control rua" name="rua" placeholder="Rua" required/>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Bairro:</label>
                     <input type="text" class="form-control bairro" placeholder="Bairro" name="bairro" required/>
                  </div>
               </div>
               <br/>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-2">
                  <label for="exampleFormControlSelect1">Cidade e Estado:</label>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-2">
                  <div class="form-group">
                     <input type="text" name="cidade" class="form-control cidade" placeholder="Cidade" required/>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <input type="text" name="estado" class="form-control estado" placeholder="Estado" required/>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                     <input type="text" name="numero" class="form-control numero" placeholder="Número" />
                  </div>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Complemento</label>
                     <input type="text" name="complemento" class="form-control complemento" placeholder="complemento do endereço" />
                  </div>
                  <div class="form-group">
                     <h4><u><i>Acesso</i></u></h4>
                  </div>
                  <br/>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Usuario:</label>
                     <input type="text" class="form-control usuario" name="usuario" placeholder="usuario" required/>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Senha atual:</label>
                     <input type="password" class="form-control senha" name="senha"  placeholder="Senha" />
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Senha nova:</label>
                     <input type="password" class="form-control nova" name="nova" id="senha" placeholder="Senha nova" />
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Confirmar nova senha:</label>
                     <input type="password" class="form-control nova" name="nova" placeholder="Senha nova" data-parsley-equalto="#senha"/>
                  </div>
                  <div class="form-group">
                     <input type="hidden" name="foto2" class="foto2"/>
                     <label for="exampleFormControlSelect1">Enviar uma foto:</label>
                     <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
                     <input type="file" name="arquivo"/>
                  </div>
                  <br/>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                  <div class="form-group">
                     <button type="submit" style="width:100%" class="btn btn-success cadastrar">Alterar</button>
                  </div>
               </div>
      </form>
      </div>
      </div>
   </div>
   <!--Modais-->
   <!-- Editar E-mail -->
   <div class="modal fade" id="editarEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">
               <h4>Editar E-mail</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form name="email" method="POST" action="../funcionalidade/gerenciaremail.php" data-parsley-validate="">
                  </br>
                  <input type="hidden" name="emailId" class="emailId"/>
                  <input type="hidden" name="acao" value="editar" class="editar" required/>
                  <div class="form-group">
                     <label for="editemail">E-mail:</label>
                     <input type="email" class="form-control emailedit" name="email" required/>
                  </div>
                  </br>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-danger">Salvar mudanças</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   <!-- adicionar E-mail -->
   <div class="modal fade" id="adicionarEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">
               <h4>Adicionar novo e-mail</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form  method="POST" action="../funcionalidade/gerenciaremail.php" data-parsley-validate="">
                  </br>
                  <input type="hidden" name="acao" value="adicionar" class="editar" required/>
                  <div class="form-group">
                     <label for="editemail">E-mail:</label>
                     <input type="email" class="form-control emailedit" name="email" required/>
                  </div>
                  </br>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-success">Adicionar</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   <!-- excluir e-mail -->
   <div class="modal" id="excluirEmail" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Excluir e-mail</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form  method="POST" action="../funcionalidade/gerenciaremail.php" data-parsley-validate="">
                  <input type="hidden" name="acao" value="excluir"/>
                  <input type="hidden" name="emailCod" class="emailId"/>
                  <div class="alert alert-danger" role="alert">
                     É importante ressaltar que ao clicar no botão 'Excluir' o registro não estará mais disponível,e não poderá ser recuperado..
                  </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-danger">Excluir</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   <!-- Editar telefone -->
   <div class="modal fade" id="editarTelefone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">
               <h4>Editar telefone</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form name="email" method="POST" action="../funcionalidade/gerenciartelefone.php" data-parsley-validate="">
                  </br>
                  <input type="hidden" name="telefoneId" class="telefoneId"/>
                  <input type="hidden" name="tipoatual" class="tipoatual"/>
                  <input type="hidden" name="acao" value="editar" class="editar"/>
                  <div class="form-group">
                     <input type="text" class="form-control ddd_tel" placeholder="DDD" maxlength="2" data-parsley-type="digits" name="ddd_tel" required/>  
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control num_tel" maxlength="9" data-parsley-type="digits" placeholder="Número de telefone" name="num_tel" required/>
                  </div>
                  <div class="form-group">
                     <select name="tipo" class="form-control tipo">
                        <option value="residencial">Residencial</option>
                        <option value="particular">Particular</option>
                     </select>
                  </div>
                  </br>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-danger">Salvar mudanças</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   <!-- excluir telefone -->
   <div class="modal" id="excluirTelefone" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Excluir telefone</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form  method="POST" action="../funcionalidade/gerenciartelefone.php" data-parsley-validate="">
                  <input type="hidden" name="acao" value="excluir"/>
                  <input type="hidden" name="telefoneId" class="telefoneId"/>
                  <div class="alert alert-danger" role="alert">
                     É importante ressaltar que ao clicar no botão 'Excluir' o registro não estará mais disponível, e não poderá ser recuperado.
                  </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-danger">Excluir</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   <!-- Adicionar telefone -->
   <div class="modal fade" id="adicionarTelefone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLongTitle">
               <h4>Adicionar novo telefone</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <form  method="POST" action="../funcionalidade/gerenciartelefone.php" data-parsley-validate="">
                  </br>
                  <input type="hidden" name="acao" value="adicionar" class="editar"/>
                  <div class="form-group">
                     <label for="editemail">DDD:</label>
                     <input type="text" class="form-control" placeholder="DDD"  maxlength="2" data-parsley-type="digits" name="ddd" required/>
                  </div>
                  <div class="form-group">
                     <input type="text" class="form-control" placeholder="Numero"  maxlength="9" data-parsley-type="digits" name="numero" required/>
                  </div>
                  <div class="form-group">
                     <select name="tipo" class="form-control">
                        <option value="residencial">Residencial</option>
                        <option value="particular">Particular</option>
                     </select>
                  </div>
                  </br>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Desistir</button>
            <button type="submit" class="btn btn-success">Adicionar</button>
            </div>
            </form>
         </div>
      </div>
   </div>
   
</body>
<br/><br/><br/>
<?php require_once("rodape.php");?>
</html>
