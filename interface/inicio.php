<?php
   //impedir que quem não acessou tenha acesso ao conteúdo da página!
   require_once("../classes/validar.php");
   require_once("../classes/conexao.php");
   $validar = new Validar();
   $validar->sessao();
   
   //estabelecer conexão com o banco 
   $conexao = new Conexao();
  
   $id = $_SESSION['id'];
   
   $codigo_grupo  = $_SESSION['cod_grupo'];
   
   
   //data para utlizar como parametro de consulta
   
   $datafinal = date('Y-m-d'); 
   $datainicial = date('Y/m/d', strtotime("-365 days",strtotime($datafinal))); 
   
   //membro
   $query = mysqli_query($conexao->conectar(),"SELECT * FROM membros INNER JOIN acesso on membros.cod_membro=acesso.cod_membro_acesso where cod_membro='$id'");
   
   // analytcs
   
   //contar negocio
           $query1 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios where data_negocio BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
   
   //pontuação
   $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao where data_pontuacao BETWEEN '$datainicial' and '$datafinal' and membro_pontuador='$id'");
   
   //referência
   $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM referencias where data_referencia BETWEEN '$datainicial' and '$datafinal' and cod_membro_referenciou='$id'");
   
   //cara-a-cara
   $query6 = mysqli_query($conexao->conectar(),"SELECT * FROM CARA_CARA where data_cara BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
   
   
   //negocio valor gerado
           $query4 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios INNER JOIN pontuacao on negocios.cod_negocio=pontuacao.cod_donegocio INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where cod_iniciou='$id' and cod_membro_referenciou<>'$id' and data_negocio between '$datainicial' and '$datafinal'");
   
   //convidado
   $query5 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados where data_convidado BETWEEN '$datainicial' and '$datafinal' and cod_dequem_convidado_juncao='$id'");
   
   //Valor faturado
   $query7 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio where membro_pontuador='$id' and tipo=4 and data_pontuacao BETWEEN '$datainicial' and '$datafinal'
   ");
   
    // Somar reunioes que o membro participou e foi confirmar a presença por ele e pelo administrador
          $query9 = mysqli_query($conexao->conectar(),"SELECT * FROM participa_reuniao WHERE cod_membro='$id' and conf_membro='1' and conf_adm='1' and data_reuniao BETWEEN '$datainicial' and '$datafinal'");
   
   //Calcular o valor faturado pelo o grupo
           $query8 =mysqli_query($conexao->conectar(),"SELECT * from pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio INNER JOIN membros on negocios.cod_iniciou=membros.cod_membro INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where referencias.codigo_grupo='$codigo_grupo' and tipo=4 and data_negocio BETWEEN '$datainicial' and '$datafinal'");
   
   
   if(isset($_POST['periodo'])){
       
       
       if($_POST['periodo'] == 3){
           
          
           
           
           $datafinal = date('Y-m-d'); 
           $datainicial = date('Y/m/d', strtotime("-90 days",strtotime($datafinal))); 
   
           
           //contar negocio
           $query1 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios where data_negocio BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           
           //pontuação
           $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao where data_pontuacao BETWEEN '$datainicial' and '$datafinal' and membro_pontuador='$id'");
           
           //referência
           $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM referenciass where data_referencia BETWEEN '$datainicial' and '$datafinal' and cod_membro_referenciou='$id'");
           
           //cara-a-cara
           $query6 = mysqli_query($conexao->conectar(),"SELECT * FROM CARA_CARA where data_cara BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           
          //negocio valor gerado
           $query4 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios INNER JOIN pontuacao on negocios.cod_negocio=pontuacao.cod_donegocio INNER JOIN referenciass on pontuacao.cod_tipo=referenciass.cod_referencia where cod_iniciou='$id' and cod_membro_referenciou<>'$id' and data_negocio between '$datainicial' and '$datafinal'");
           
           //convidado
           $query5 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados where data_convidado BETWEEN '$datainicial' and '$datafinal' and cod_dequem_convidado_juncao='$id'");
           
           //Valor faturado
           $query7 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio where membro_pontuador='$id' and tipo=4 and data_pontuacao BETWEEN '$datainicial' and '$datafinal'
           ");
           
           //Calcular o valor faturado pelo o grupo
           $query8 =mysqli_query($conexao->conectar(),"SELECT * from pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio INNER JOIN membros on negocios.cod_iniciou=membros.cod_membro INNER JOIN referenciass on pontuacao.cod_tipo=referenciass.cod_referencia where referenciass.codigo_grupo='$codigo_grupo' and tipo=4 and data_negocio BETWEEN '$datainicial' and '$datafinal'");
           
           // Somar reunioes que o membro participou e foi confirmar a presença por ele e pelo administrador
          $query9 = mysqli_query($conexao->conectar(),"SELECT * FROM participa_reuniao WHERE cod_membro='$id' and conf_membro='1' and conf_adm='1' and data_reuniao BETWEEN '$datainicial' and '$datafinal'");
           
       }else if($_POST['periodo'] == 6){
           
           
           $datafinal = date('Y-m-d'); 
           $datainicial = date('Y/m/d', strtotime("-180 days",strtotime($datafinal))); 
           
           //contar negocio
           $query1 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios where data_negocio BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           //pontuação
           $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao where data_pontuacao BETWEEN '$datainicial' and '$datafinal' and membro_pontuador='$id'");
           
           //referência
           $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM referenciass where data_referencia BETWEEN '$datainicial' and '$datafinal' and cod_membro_referenciou='$id'");
           
           //cara-a-cara
           $query6 = mysqli_query($conexao->conectar(),"SELECT * FROM CARA_CARA where data_cara BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           
           //negocio valor gerado
           $query4 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios INNER JOIN pontuacao on negocios.cod_negocio=pontuacao.cod_donegocio INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where cod_iniciou='$id' and cod_membro_referenciou<>'$id' and data_negocio between '$datainicial' and '$datafinal'");
           
           //convidado
           $query5 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados where data_convidado BETWEEN '$datainicial' and '$datafinal' and cod_dequem_convidado_juncao='$id'");
           
           //Valor faturado
           $query7 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio where membro_pontuador='$id' and tipo=4 and data_pontuacao BETWEEN '$datainicial' and '$datafinal'
           ");
           
           //Calcular o valor faturado pelo o grupo
           $query8 =mysqli_query($conexao->conectar(),"SELECT * from pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio INNER JOIN membros on negocios.cod_iniciou=membros.cod_membro INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where referencias.codigo_grupo='$codigo_grupo' and tipo=4 and data_negocio BETWEEN '$datainicial' and '$datafinal'");
           
           // Somar reunioes que o membro participou e foi confirmar a presença por ele e pelo administrador
          $query9 = mysqli_query($conexao->conectar(),"SELECT * FROM participa_reuniao WHERE cod_membro='$id' and conf_membro='1' and conf_adm='1' and data_reuniao BETWEEN '$datainicial' and '$datafinal'");
           
       }else if($_POST['periodo'] == 12){
           
           
           $datafinal = date('Y-m-d'); 
           $datainicial = date('Y/m/d', strtotime("-365 days",strtotime($datafinal))); 
   
           //contar negocio
           $query1 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios where data_negocio BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           //pontuação
           $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao where data_pontuacao BETWEEN '$datainicial' and '$datafinal' and membro_pontuador='$id'");
           
           //referência
           $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM referencias where data_referencia BETWEEN '$datainicial' and '$datafinal' and cod_membro_referenciou='$id'");
           
           //cara-a-cara
           $query6 = mysqli_query($conexao->conectar(),"SELECT * FROM CARA_CARA where data_cara BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           
           //negocio valor gerado
           $query4 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios INNER JOIN pontuacao on negocios.cod_negocio=pontuacao.cod_donegocio INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where cod_iniciou='$id' and cod_membro_referenciou<>'$id' and data_negocio between '$datainicial' and '$datafinal'");
           
           //convidado
           $query5 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados where data_convidado BETWEEN '$datainicial' and '$datafinal' and cod_dequem_convidado_juncao='$id'");
           
           //Valor faturado
           $query7 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio where membro_pontuador='$id' and tipo=4 and data_pontuacao BETWEEN '$datainicial' and '$datafinal'
           ");
           
           //Calcular o valor faturado pelo o grupo
           $query8 =mysqli_query($conexao->conectar(),"SELECT * from pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio INNER JOIN membros on negocios.cod_iniciou=membros.cod_membro INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where referencias.codigo_grupo='$codigo_grupo' and tipo=4 and data_negocio BETWEEN '$datainicial' and '$datafinal'");
           
            // Somar reunioes que o membro participou e foi confirmar a presença por ele e pelo administrador
          $query9 = mysqli_query($conexao->conectar(),"SELECT * FROM participa_reuniao WHERE cod_membro='$id' and conf_membro='1' and conf_adm='1' and data_reuniao BETWEEN '$datainicial' and '$datafinal'");
           
       }else if($_POST['periodo'] == 1){
           
           
           $datafinal = date('Y-m-d'); 
           $datainicial = date('Y/m/d', strtotime("-31 days",strtotime($datafinal))); 
           
           //contar negocio
           $query1 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios where data_negocio BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           //pontuação
           $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao where data_pontuacao BETWEEN '$datainicial' and '$datafinal' and membro_pontuador='$id'");
           
           //referência
           $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM referencias where data_referencia BETWEEN '$datainicial' and '$datafinal' and cod_membro_referenciou='$id'");
           
           //cara-a-cara
           $query6 = mysqli_query($conexao->conectar(),"SELECT * FROM CARA_CARA where data_cara BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
           
           
           ///negocio valor gerado
           $query4 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios INNER JOIN pontuacao on negocios.cod_negocio=pontuacao.cod_donegocio INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where cod_iniciou='$id' and cod_membro_referenciou<>'$id' and data_negocio between '$datainicial' and '$datafinal'");
           
           //convidado
           $query5 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados where data_convidado BETWEEN '$datainicial' and '$datafinal' and cod_dequem_convidado_juncao='$id'");
           
           //Valor faturado
           $query7 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio where membro_pontuador='$id' and tipo=4 and data_pontuacao BETWEEN '$datainicial' and '$datafinal'
           ");
           
          //Calcular o valor faturado pelo o grupo
           $query8 =mysqli_query($conexao->conectar(),"SELECT * from pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio INNER JOIN membros on negocios.cod_iniciou=membros.cod_membro INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where referencias.codigo_grupo='$codigo_grupo' and tipo=4 and data_negocio BETWEEN '$datainicial' and '$datafinal'");
           
            // Somar reunioes que o membro participou e foi confirmar a presença por ele e pelo administrador
          $query9 = mysqli_query($conexao->conectar(),"SELECT * FROM participa_reuniao WHERE cod_membro='$id' and conf_membro='1' and conf_adm='1' and data_reuniao BETWEEN '$datainicial' and '$datafinal'");
   
       }
       
   }
   
   
   //contar negocio
   if($query1){
   $negocio = mysqli_num_rows($query1);
   }else{
   $negocio = 0;    
   }
   //contar convidados
   if($query5){
   $convidados= mysqli_num_rows($query5);
   }else{
   $convidados=0;    
   }
   //contar referencias
   if($query3){
   $referencias = mysqli_num_rows($query3);
   }else{
   $referencias=0;
   }
   //contar cara-a-cara
   if($query6){
   $caracara = mysqli_num_rows($query6);
   }else{
   $caracara = 0;
   }
   
   $pontuacao = 0;
   $gerado = 0.0;
   $faturado = 0.0;
   //somar pontuação do período
   if($query2){
   while($sql2 = mysqli_fetch_array($query2)){
        $pontuacao+=intval($sql2['valor']);
   }
   }else{
       $pontuacao=0;
   }
   //somar o valor total dos negocio
   if($query4){
   while($sql3 = mysqli_fetch_array($query4)){
       $gerado+=floatval($sql3['valor_negocio']);
      
   }
   }else{
       $gerado=0;
   }
   if($query7){
    //somar o valor total faturado dos negocio 
   while($sql3 = mysqli_fetch_array($query7)){
       $faturado+=floatval($sql3['valor_negocio']);
        
   }
   }else{
     $faturado=0;
   }
   
   $totalgrupo=0;
   //somar o valor total do grupo
   if($query8){
   while($sql = mysqli_fetch_array($query8)){
       $totalgrupo+= $sql['valor_negocio'];
   }
   }else{
       $totalgrupo = 0;
   }
   
   if($query9){
   //somar valor totais de reunioes confirmada pelo membro eo adm no periodo ditado
    $totalreuniao = mysqli_num_rows($query9);
   }else{
      $totalreuniao = 0; 
   }
   
   // dados do usuário
   $sql = mysqli_fetch_assoc($query);
   
   ?>
<?php
   ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>ínicio</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">
   <!-- Script-->    
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <!-- CSS -->
   <link rel="stylesheet" href="../css/inicio.css">
   <!-- CSS do Bootstrap -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <style>
   </style>
</head>
<body>
   <?php
      //Mostrar o modal para confirmar presença ou ausencia
      include('../funcionalidade/verificarparticipacaoreuniao.php');
      ?>
    <div class="sticky-top">
   <!-- Menu!-->
   <?php require_once('menu.php')?>
   </div>
   <br/>
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-4">
         </div>
         <div class="col-md-4 card-body mostrar">
            <img class="img-fluid float-left img-thumbnail foto"  src="fotos/<?php if($sql['foto']!=null && $sql['foto']!=""){echo $sql['foto'];}else{
            echo 'padrao.png';} ?>"/>
            <h3 class="text-center"><?php echo $sql['nome_membro']; ?></h3>
            <a  href="minhaconta.php"><span width="60px;" class="float-right glyphicon glyphicon-edit btn edit"></span></a>
            <h4 class="desde">Grupo: <?php echo $_SESSION['nome_grupo']; ?></h4>
            <br/>
            <h4 class="desde">Validade: <?php echo str_replace('-','/',date('d/m/Y', strtotime($sql['membro_expira']))); ?></h4>
            <br/>
         </div>
         
         <br/><br/>
      </div>
      <br/><br/>
      <div class="card text-center">
         <h5 class="text-center"><?php if(isset($_POST['periodo'])) 
            echo  $_POST['periodo']."  meses";
            
            ?></h5>
         <div class="card-header" id="card-header">
            <h4>Contribuições</h4>
         </div>
         <div class="card-body">
            <div class="row">
               <div class="col-md-2 float-left">
                  <br/>
                  <div class="form-group">
                  <form name="formperiodo" class="formperiodo" method="post" action="inicio.php">
                     <label for="exampleFormControlSelect1">Selecione o período:</label>
                     <select class="periodo form-control" name="periodo">
                        <option></option>
                        <option value="1">1 mês</option>
                        <option value="3">3 meses</option>
                        <option value="6">6 meses</option>
                        <option value="12">1 ano</option>
                     </select>
                  </form>
                  </div>
               </div>
               <div class="col-md-2">
                   </br>
                  <div class="form-group">
                  <label for="exampleFormControlSelect1"> Pontuação</label>
                  <h5>
                  <a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=pontuacao"><b style="font-size:17px;"><?php echo $pontuacao; ?></b><a/>
                  </h5>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               <div class="col-md-2">
                <div class="form-group">
                    
               <label for="exampleFormControlSelect1">  Referência qualificada</label>
               <h5><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=referencias"><b style="font-size:17px;"><?php echo $referencias; ?></b></a></h5>
                <center><div class="barra"></div></center>
               </div>
              
               </div>
               <div class="col-md-2">
                   </br>
                   <div class="form-group">
                  <label for="exampleFormControlSelect1">  Negócio fechado</label>
                  <h5 class=""><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=negocio"><b style="font-size:17px;"><?php echo $negocio; ?></b></a></h5>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               <div class="col-md-2">
                   <div class="form-group">
                  <label for="exampleFormControlSelect1">  Cara-a-Cara</label>
                  <h5><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=caracara"><b style="font-size:17px;"><?php echo $caracara; ?></b></a></h5>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               <br/><br/>
            </div>
            <br/><br/>
            <div class="row">
               <div class="col-md-2">
                  <div class="form-group">
                  <label for="exampleFormControlSelect1">  Grupo <?php echo " ".$_SESSION['nome_grupo']; ?></label>
                  <?php if($codigo_grupo!=0){?>
                  <h5><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=faturadogrupo"><span style="font-size:20px;">R$ <?php echo number_format($totalgrupo, 2, ',', '.'); ?></span><a/></h5>
                  <?php }else{echo "<br/>Sem grupo";} ?>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               <div class="col-md-2">
                   </br>
                  <div class="form-group">
                  <label for="exampleFormControlSelect1">  Valor gerado</label>
                  <h5><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=gerado"><b style="font-size:17px;">R$ <?php echo number_format($gerado, 2, ',', '.'); ?></b><a/></h5>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group">
                  <label for="exampleFormControlSelect1">  Valor faturado</label>
                  <h5><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=faturado"><b style="font-size:17px;">R$ <?php echo number_format($faturado, 2, ',', '.'); ?></b><a/></h5>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               <div class="col-md-2">
                   </br>
                  <div class="form-group">
                  <label for="exampleFormControlSelect1"> Convidado</label>
                  <h5><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=convidado"><b style="font-size:17px;" ><?php echo $convidados; ?></b><a/></h5>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               <div class="col-md-2">
                   <div class="form-group">
                  <label for="exampleFormControlSelect1">  Reunião</label>
                  <h5><a href="contribuicoes.php?data=<?php echo $datainicial; ?>&tipo=reuniao"><b style="font-size:17px;"><?php echo $totalreuniao; ?></b><a/></h5>
                  <center><div class="barra"></div></center>
                  </div>
               </div>
               
               <br/><br/>
            </div>
            <br/><br/>
         </div>
         <br/><br/>
         <div class="card-footer">
            <?php
               //data e hora
                 date_default_timezone_set('America/Sao_Paulo');
                 $date = str_replace('-','/',date('d-m-Y H:i'));
                 echo "Atualizado em  ".$date;
               ?>
         </div>
      </div>
      <br/><br/>
   </div>
   <?php require_once('rodape.php')?>
</body>
</html>
