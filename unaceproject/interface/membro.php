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
         $query = mysqli_query($conexao->conectar(),"SELECT * FROM empresas");
         
         //Fazer a pesquisa no banco para listar papeis
         $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM papel");
         
         //Fazer a pesquisa no banco para listar grupos
         $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM grupos");
         
         
     
     ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Membro</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="../css/membro.css">
   <link rel="stylesheet" href="../css/parsley.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
      <form name="form1" class="formulario" enctype="multipart/form-data" method="post"  data-parsley-validate="" action="../funcionalidade/membro.php">
         <div class="form-group">
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                  <center>
                     <h3 class="page-header">Cadastro de membro</h3>
                  </center>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <!-- avisar se teve sucesso ou não -->
                  <?php if(isset($_GET['resultado'])){ if($_GET['resultado']=="success"){echo '<div class="alert alert-success" role="alert">Membro cadastrado com sucesso!</div>';}else if($_GET['resultado']=="fail"){
                     echo '<div class="alert alert-danger" role="alert">Erro! CPF já cadastrado no sistema!</div>';
                     }else{ echo '<div class="alert alert-warning" role="alert">Erro! Usuário já cadastrado no sistema!</div>'; } } ?>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Nome:</label>
                     <input type="text" class="form-control nome" name="nome" maxlength="105" placeholder="Nome da empresa" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">CPF:</label>
                     <input type="text" class="form-control cpf" name="cpf"  placeholder="CPF" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Data de nascimento:</label>
                     <input type="date" class="form-control nascimento" name="nascimento" min="1920-01-01">
                  </div>
                  <div class="form-group">
                     <label class="categoria" for="exampleFormControlSelect1">Empresa:</label>
                     </br>
                     <select name="empresa" class="form-control empresa js-example-basic-single" required>
                        <!-- Passar todos os valores de categória -->
                        <?php while($valor =  mysqli_fetch_array($query)) { ?>
                        <option value="<?php echo $valor['cod_empresa'] ?>"><?php echo $valor['nome_empresa']; ?></option>
                        <?php } ?>
                     </select>
                     <a href="empresa.php">Cadastrar nova empresa</a>
                  </div>
                  <div class="form-group">
                     <label  for="exampleFormControlSelect1">Papel:</label>
                     <select name="papel" class="form-control papel"  id="exampleFormControlSelect1" required>
                        <!-- Passar todos os valores de categória -->
                        <?php while($valor =  mysqli_fetch_array($query2)) { ?>
                        <option value="<?php echo $valor['cod_papel'] ?>"><?php echo $valor['nome_papel']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
            </div>
            </br>
            <div class="telefone2">
               <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                     <label for="exampleFormControlSelect1">Contato:</label>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <input type="text" class="form-control ddd"  name="ddd[]"   maxlength="2" data-parsley-type="digits" placeholder="ddd" required/>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <input type="text" class="form-control numero"  name="numero[]" maxlength="9" data-parsley-type="digits" placeholder="numero" required/>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <div class="form-group">
                        <select class="form-control tipo" name="tipo[]">
                           <option value="residencial">Residencial</option>
                           <option value="particular">Particular</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-4">
                     <button type="button" class="btn btn-success maistelefone">+Telefone</button>
                  </div>
               </div>
            </div>
            </br>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <div class="form-group email2">
                     <label for="exampleFormControlSelect1">E-mail:</label>
                     <input type="email" class="form-control email" name="email[]" placeholder="E-mail" required>
                     </br>
                     <button type="button" class="maisemail btn btn-success">+ E-mail</button>
                  </div>
                  </br>
                  <div class="form-group">
                     <h4><u><i>Endereço</i></u></h4>
                     <hr>
                  </div>
                  </br>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">CEP:</label>
                     <input type="text" class="form-control cep" name="cep" placeholder="CEP" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Rua:</label>
                     <input type="text" class="form-control rua" name="rua" placeholder="Rua" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Bairro:</label>
                     <input type="text" class="form-control bairro" placeholder="Bairro" name="bairro" required>
                  </div>
               </div>
               <br/>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Cidade e Estado:</label>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-2"></div>
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
                     <input type="text" name="numero2" class="form-control numero numero2" placeholder="Número"/>
                  </div>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Complemento</label>
                     <input type="text" name="complemento" class="form-control complemento" placeholder="complemento do endereço"/>
                  </div>
                  </br>
                  <div class="form-group">
                     <h4><u><i>Acesso</i></u></h4>
                     <hr>
                  </div>
                  <br/>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Usuario:</label>
                     <input type="text" class="form-control usuario" name="usuario" placeholder="usuario" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Senha:</label>
                     <input type="password" class="form-control senha" id="senha" name="senha" placeholder="Senha" required>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Confirmar senha:</label>
                     <input type="password" class="form-control" id="repetirsenha" placeholder="confirmar senha" data-parsley-equalto="#senha">
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Nível de acesso:</label>
                     <select name="nivel" class="form-control" required>
                        <option value="1">Normal</option>
                        <option value="2">Administrador</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Validade:</label>
                     <select name="validade" class="form-control" required>
                        <option value="4">1 mês</option>
                        <option value="6">6 meses</option>
                        <option value="1">1 anos</option>
                        <option value="2">2 anos</option>
                        <option value="5">5 anos</option>
                     </select>
                  </div>
                  <br/>
                  <div class="form-group">
                     <label for="exampleFormControlSelect1">Enviar uma foto:</label>
                     <input type="hidden" name="MAX_FILE_SIZE" value="4194304" />
                     <input type="file" name="arquivo"/>
                  </div>
                  <br/>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4"><button  type="submit" style="width:100%" class="btn btn-success cadastrar">Cadastrar</button></div>
      </form>
      </div>
      </div>
   </div>
   
   
<!--------------------------------------------------- Scripts ---------------------------------------------->
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
   <script src="../scripts/membro2.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
</body>
<br/><br/><br/>
<?php require_once("rodape.php");?>
</html>
