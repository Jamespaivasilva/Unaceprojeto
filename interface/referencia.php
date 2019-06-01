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
        
        //Iniciar o metódo para conectar
         $conexao->conectar();
        
         //Fazer a pesquisa no banco para listar empresas
         $query = mysqli_query($conexao->conectar(),"SELECT * FROM membros");
   
         //Fazer a pesquisa no banco para listar categoria
         $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM categorias");
         
         $membro = $_SESSION['id'];
         $nivel = $_SESSION['nivel'];
     
     ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Referência</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- CSS -->
   <link rel="stylesheet" href="../css/referencia.css">
   <link rel="stylesheet" href="../css/parsley.css">
   <!-- CSS do Bootstrap -->
   <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
      <form name="form1" class="formulario"  method="post" action="../funcionalidade/referencia.php" data-parsley-validate="">
         <div class="form-group">
            <div class="row">
               <div class="col-md-4"></div>
               <div class="col-md-4">
                  <center>
                     <h3 class="page-header">Referência qualificada</h3>
                  </center>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <!-- avisar se teve sucesso -->
                  <?php if(isset($_GET['resultado'])){echo '<div class="alert alert-success" role="alert">Referência qualificada registrada com sucesso!</div>';}?>
                  <br/>
                  <label for="exampleFormControlSelect1">Para:</label>
                  <select name="quem" class="selectpicker form-control quem" data-show-subtext="true" data-live-search="true">
                     <?php while($sql = mysqli_fetch_array($query)){ ?>
                     <option  value="<?php echo $sql['cod_membro']?>"><?php echo iconv("UTF-8", "ISO-8859-1", $sql['nome_membro']); ?></option>
                     <?php }?>
                  </select>
                  <br/>
                  <!-- id do membro que está cadastrando-->
                  <input type="hidden" name="registrou" value="<?php echo $membro; ?>"/>
                  <br/>
                  <label for="exampleFormControlSelect1">Empresa/Pessoa:</label>
                  <input type="text" class="form-control estabelecimento" name="estabelecimento"  placeholder="Empresa/Pessoa" required>
                  <br/>
                  <div class="form-group">
                  <label for="exampleFormControlSelect1">Categória da empresa</label>
                  <select name="categoria" class="categoria form-control js-example-basic-single"  id="exampleFormControlSelect1" required>
                     <!-- Passar todos os valores de categória -->
                     <option></option>
                     <option value="outro">Outra categoria</option>
                     <?php while($valor =  mysqli_fetch_array($query2)) { ?>
                     <option value="<?php echo $valor['cod_cat'] ?>"><?php echo $valor['pri_cat'] ."  |  ".$valor['sec_cat']; ?></option>
                     <?php } ?>
                  </select>
                 <?php if($nivel==2) {?>
                 <a href="categoria.php">Cadastrar nova categoria</a>
                 <?php }?>
                 </div>
                 <div class="categoria2"></div>
                  <br/><br/>
                  <label for="exampleFormControlSelect1">Endereço:</label>
                  <input type="text" name="local" class="form-control endereco" placeholder="Endereço" required/>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <label for="exampleFormControlSelect1">Contato:</label>
               </div>
            </div>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <input type="text" class="form-control ddd"  name="ddd" maxlength="2" data-parsley-type="digits" placeholder="ddd"/>
               </div>
               <div class="col-md-2">
                  <input type="text" class="form-control numero1"  name="numero1" maxlength="9" data-parsley-type="digits" placeholder="numero"/>
               </div>
               <div class="col-md-2">
                  <select class="form-control tipo" name="tipo">
                     <option value="empresarial">Empresarial</option>
                     <option value="residencial">Residencial</option>
                     <option value="particular">Particular</option>
                  </select>
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <label for="exampleFormControlSelect1">E-mail:</label>
                  <input type="email" name="email" class="form-control email" placeholder="E-mail"/>
               </div>
            </div>
            <br/>     
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <input type="radio" name="referencia"  value="interna" class="referencia" required=""/> Referência Interna
               </div>
               <div class="col-md-2">
                  <input type="radio" name="referencia"  value="externa" class="referencia"/> Referência Externa
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <input type="checkbox" name="cartao"  value="S" class="cartao"/> Entreguei seu cartão.
               </div>
               <div class="col-md-2">
                  <input type="checkbox" name="liga"  value="S" class="liga"/> Disse que você ligaria.
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <label for="exampleFormControlSelect1">Potencial:</label>
               </div>
            </div>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-2">
                  <input type="radio" name="potencial"  value="1" class="potencial" required=""/> 1 - Fraca
               </div>
               <div class="col-md-2">
                  <input type="radio" name="potencial"  value="2" class="potencial"/> 2 - Boa
               </div>
               <div class="col-md-2">
                  <input type="radio" name="potencial"  value="3" class="potencial"/> 3 - Forte
               </div>
               <div class="col-md-2">
                  <input type="radio" name="potencial"  value="4" class="potencial" /> 4 - Muito forte
               </div>
            </div>
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <label for="exampleFormControlSelect1">Data:</label>
                  <input type="date" class="form-control data" name="data"  placeholder="Data" required>
                  <input type="hidden" class="endereco" name="endereco"/>
                  <!--<label for="exampleFormControlSelect1">CEP:</label>-->
                  <input type="hidden" class="form-control cep" name="cep" placeholder="CEP" required>
                  <!--<label for="exampleFormControlSelect1">Rua:</label>-->
                  <input type="hidden" class="form-control rua" name="rua" placeholder="Rua" required>
                  <!--<label for="exampleFormControlSelect1">Bairro:</label>-->
                  <input type="hidden" class="form-control bairro" placeholder="Bairro" name="bairro" required>
               </div>
            </div>
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
            <br/>
            <div class="row">
               <div class="col-md-2"></div>
               <div class="col-md-8">
                  <label for="exampleFormControlSelect1">Comentários:</label>
                  <textarea class="form-control conversa" rows="6" name="comentario" maxlength="1000" placeholder="até 1000 caracteres"></textarea>
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
<!---------------------------------------------------------------- Script---------------------------------------------------------------->    
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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
   <script src="../scripts/parsley.js"></script>
   <script src="../scripts/referencia.js"></script>
</body>
<br/><br/><br/>
<?php require_once("rodape.php");?>
</html>
