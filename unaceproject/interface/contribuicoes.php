<?php
   //ignorar erros e alertas
   error_reporting(0);
   //impedir que quem não acessou tenha acesso ao conteúdo da página!
   require_once("../classes/validar.php");
   
   
   $validar = new Validar();
   $validar->sessao();
   
   //Validar se tem permissão de acesso a página
   $nivel = $_SESSION['nivel'];
   
   //id do membro
   $id = $_SESSION['id'];
   
   //codigo do grupo
   $codigo_grupo = $_SESSION['cod_grupo'];
   
   
   // se o nível não for dois, levaremos o usuario a pagina inicial
   //if($nivel==){
    //   echo '<script>alert("Você não tem permissão para acessar essa página!"); window.location.href = "https://unace//.000webhostapp.com/interface/inicio.php"</script>';
   //}
   
      // Conectar ao banco, pra que ? Para puxar todos os registros de categorias
      require_once('../classes/conexao.php');
      
      // Instanciar class Conexão
       $conexao = new Conexao();
      
      //Iniciar o metódo para conectar
       $conexao->conectar();
      
       //Fazer a pesquisa no banco
       $query = mysqli_query($conexao->conectar(),"SELECT * FROM categorias");
       
       $tipo="";
       
       
       //mostrar dados quando clicado nos hiperlink da tela inicial
       
       // se a data e o tipo estiver setado é porque está vindo da tela inicial, vamos pegar a data e o tipo
       if(isset($_GET['data']) and  isset($_GET['tipo'])){
          
          if(isset($_GET['inicial']) and isset($_GET['final'])){ 
           $datafinal =  $_GET['final'];
           $datainicial = $_GET['inicial'];
           
          }
          
          // se inicial e final não tiver setado é porque está vindo da tela de contribuição, vamos pegar a data final
          if(!isset($_GET['inicial']) and !isset($_GET['final'])){
           $datafinal = date('Y-m-d');
           $datainicial = $_GET['data'];
           
          }
          
           //pegar o tipo da pesquisa
           $tipo = $_GET['tipo'];
           
           
           //individuais//
           if($tipo=="referencias"){
               //referência
           $query20 = mysqli_query($conexao->conectar(),"SELECT * FROM referencias INNER JOIN membros on referencias.cod_para_referencia_juncao=membros.cod_membro where data_referencia BETWEEN '$datainicial' and '$datafinal' and cod_membro_referenciou='$id'");
           
           }else if($tipo=="faturado"){
               //negocio
           $query4 = mysqli_query($conexao->conectar(),"SELECT * from pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio INNER JOIN membros on negocios.cod_iniciou=membros.cod_membro
           where membro_pontuador='$id' and tipo=4 and data_negocio BETWEEN '$datainicial' and '$datafinal'");
           
           }else if($tipo=="gerado"){
               
               //negocio valor gerado
            $query9 = mysqli_query($conexao->conectar(),"SELECT DISTINCT cod_negocio,nome_membro,cod_tipo,referencias.tipo_referencia,nome_empresa,data_negocio,valor_negocio,tipo_negocio FROM negocios 
               INNER JOIN pontuacao on negocios.cod_negocio=pontuacao.cod_donegocio 
               INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia 
               INNER JOIN membros on referencias.cod_membro_referenciou=membros.cod_membro
               INNER JOIN empresas on membros.cod_membro_empresa=empresas.cod_empresa
               INNER JOIN juncao_grupo_empresa on empresas.cod_empresa=juncao_grupo_empresa.cod_cad_grupo_empresa_empresa
               where cod_iniciou='$id' and cod_membro_referenciou<>'$id' and data_negocio between '$datainicial' and '$datafinal' order by valor_negocio");
           
           }else if($tipo=="convidado"){
               
           //convidado
           $query5 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados 
               where data_convidado BETWEEN '$datainicial' and '$datafinal' and cod_dequem_convidado_juncao='$id'");
   
   
           }else if($tipo =="caracara"){
               
               //cara-a-cara
           $query6 = mysqli_query($conexao->conectar(),"SELECT * FROM CARA_CARA 
               INNER JOIN membros on CARA_CARA.cod_comquem_cara=membros.cod_membro
               where data_cara BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'");
               
           }else if($tipo=="pontuacao"){
               
              //pontuação
           $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM pontuacao where data_pontuacao BETWEEN '$datainicial' and '$datafinal' and membro_pontuador='$id'"); 
               
           }else if($tipo=="negocio"){
               
              //negocios
           $query10 = mysqli_query($conexao->conectar(),"SELECT * FROM negocios INNER JOIN membros on negocios.cod_membro_obrigado=membros.cod_membro where data_negocio BETWEEN '$datainicial' and '$datafinal' and cod_iniciou='$id'"); 
               
           }
           
           //Grupo//
           
           else if($tipo=="geradogrupo"){
           $query8 =mysqli_query($conexao->conectar(),"SELECT cod_negocio,valor_negocio,codigo_grupo,data_negocio,cod_iniciou,cod_membro_obrigado,nome_membro iniciou from negocios INNER JOIN membros on negocios.cod_iniciou=membros.cod_membro where codigo_grupo='$codigo_grupo'
           and data_negocio BETWEEN '$datainicial' and '$datafinal'");
           
           }else if($tipo=="faturadogrupo"){
               
                $query22 = mysqli_query($conexao->conectar(),"SELECT * from pontuacao INNER JOIN negocios on pontuacao.cod_donegocio=negocios.cod_negocio INNER JOIN membros on pontuacao.membro_pontuador=membros.cod_membro INNER JOIN referencias on pontuacao.cod_tipo=referencias.cod_referencia where referencias.codigo_grupo='$codigo_grupo' and tipo=4 and data_negocio BETWEEN '$datainicial' and '$datafinal'");
               
   
           }else if($tipo=="grupocaracara"){
    
               //cara-a-cara
           $query31 = mysqli_query($conexao->conectar(),"SELECT cod_cara,membro.nome_membro quem,mem.nome_membro membro,endereco_cara,data_cara FROM CARA_CARA 
               INNER JOIN membros as membro on CARA_CARA.cod_comquem_cara=membro.cod_membro
               INNER JOIN membros as mem on CARA_CARA.cod_iniciou = mem.cod_membro
               where codigo_grupo='$codigo_grupo' and data_cara BETWEEN '$datainicial' and '$datafinal'");
               
           }else if($tipo=="gruponegocio"){
               
              //negocios
           $query32 = mysqli_query($conexao->conectar(),"SELECT membro.nome_membro obrigado,mem.nome_membro membro,data_negocio,tipo_referencia,valor_negocio,tipo_negocio FROM negocios INNER JOIN membros as membro on negocios.cod_membro_obrigado=membro.cod_membro INNER JOIN membros as mem on negocios.cod_iniciou=mem.cod_membro where data_negocio BETWEEN '$datainicial' and '$datafinal' and codigo_grupo='$codigo_grupo'"); 
               
           }else if($tipo=="gruporeferencias"){
               
              //referencias
            $query33 = mysqli_query($conexao->conectar(),"SELECT suspect_empresa_pessoa,outra_categoria,suspect_categoria_referencia,membro.nome_membro para,mem.nome_membro membro,data_referencia,tipo_referencia,cartao,liga,suspect_endereco_referencia,suspect_telefone_referencia,suspect_email_referencia FROM referencias INNER JOIN membros membro on referencias.cod_para_referencia_juncao=membro.cod_membro INNER JOIN membros as mem on referencias.cod_membro_referenciou=mem.cod_membro where data_referencia BETWEEN '$datainicial' and '$datafinal' and codigo_grupo='$codigo_grupo'");
               
           }else if($tipo=="grupoconvidado"){
               
           //convidado
           $query34 = mysqli_query($conexao->conectar(),"SELECT empresa_categoria,outra_categoria,conf_presenca,email_convidado,membro.nome_membro membro,nome_convidado,empresa_convidado,cpf_cnpj_convidado,telefone_convidado,data_convidado FROM convidados  INNER JOIN membros as membro on convidados.cod_dequem_convidado_juncao=membro.cod_membro
               where data_convidado BETWEEN '$datainicial' and '$datafinal' and codigo_grupo='$codigo_grupo'");
               
           }else if($tipo=="grupopontuacao"){
           //pontuação
           $query35 = mysqli_query($conexao->conectar(),"SELECT data_pontuacao,membro.nome_membro membro,tipo,valor FROM pontuacao INNER JOIN membros as membro on pontuacao.membro_pontuador=membro.cod_membro where data_pontuacao BETWEEN '$datainicial' and '$datafinal' and codigo_grupo='3'"); 
               
           }else if($tipo=="reuniao"){
               
               $query36 = mysqli_query($conexao->conectar(),"SELECT * FROM participa_reuniao
               INNER JOIN reunioes on participa_reuniao.cod_reuniao=reunioes.cod_reuniao
               INNER JOIN grupos on participa_reuniao.cod_grupo=grupos.cod_grupo
               where data_reuniao BETWEEN '$datainicial' and '$datafinal' and cod_membro='$id'");
               
            }else{
               
           }
           
       }
       
      
   
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
   
   
   <style>
      .mytable {
      max-width: 600px;
      margin: 0 auto;
      }
      #myTable th, td {
      white-space: nowrap;
      }
      table.dataTable thead .sorting:after,
      table.dataTable thead .sorting:before,
      table.dataTable thead .sorting_asc:after,
      table.dataTable thead .sorting_asc:before,
      table.dataTable thead .sorting_asc_disabled:after,
      table.dataTable thead .sorting_asc_disabled:before,
      table.dataTable thead .sorting_desc:after,
      table.dataTable thead .sorting_desc:before,
      table.dataTable thead .sorting_desc_disabled:after,
      table.dataTable thead .sorting_desc_disabled:before {
      bottom: .5em;
      }
   </style>
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
      <br/>
      <div class="row">
         <div class="col-md-4"></div>
         <div class="col-md-6">
            <h3>Analytics: Contribuições</h3>
         </div>
      </div>
      <br/><br/><br/>
      <form class="formulario" name="form" action="contribuicoes.php" method="GET">
         <div class="row">
            <div class="col-md-6">
               <input type="hidden" value="pesquisa" name="data"/>
               <label for="exampleFormControlSelect1">Tipo da busca:</label>
               <select name="tipo" class="form-control tipo">
                  <option value=""></option>
                  <option value="referencias">Referências qualificada</option>
                  <option value="negocio">Negócios fechados</option>
                  <option value="caracara">Cara-a-cara</option>
                  <option value="gerado">Valor gerado</option>
                  <option value="faturado">Valor faturado</option>
                  <option value="convidado">Convidado</option>
                  <?php if($codigo_grupo!=0){ ?>
                  <option value="grupocaracara">Grupo: Cara-a-cara</option>
                  <option value="gruponegocio">Grupo: Negócio fechado</option>
                  <option value="gruporeferencias">Grupo: Referências qualificada</option>
                  <option value="grupoconvidado">Grupo: Convidado</option>
                  <option value="grupopontuacao">Grupo: Pontuação</option>
                  <option value="geradogrupo">Grupo: Valor gerado</option>
                  <option value="faturadogrupo">Grupo: Valor faturado</option>
                  <?php } ?>
               </select>
            </div>
            <div class="col-md-2">
               <label for="exampleFormControlSelect1">Data inicial</label>
               <input type="date" class="form-control inicial" name="inicial" />
            </div>
            <div class="col-md-2">
               <label for="exampleFormControlSelect1">Data final</label>
               <input type="date" class="form-control final" name="final" />
            </div>
         </div>
      </form>
      <br/><br/><br/>
      <?php 
         if($tipo=="grupocaracara"){
              echo "<center><h3 class='pager-header'>Grupo: ".$_SESSION['nome_grupo']."</h3></center><center>Cara-a-Cara</center></br>";
               echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                 <th scope="col">Membro</th>
                   <th scope="col">Com quem ?</th>
                   <th scope="col">Data</th>
                   <th scope="col">Local</th>
                   <th scope="col">Conversa</th>
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query31)){
                
                
                echo' <tr>
                   <th>'.$sql['membro'].'</th>
                   <th>'.$sql['quem'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_cara']))).'</td>
                   <td>'.$sql['endereco_cara'].'</td>
                   <td><center><button type="button" class="btn btn-primary conversa_cara"  data-target="#caracara_modal" data-toggle="modal" value="'.$sql['cod_cara'].'">Visualizar</button></center></td>
                 </tr>';
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="gruporeferencias"){
                echo "<center><h3 class='pager-header'>Grupo: ".$_SESSION['nome_grupo']."</h3></center><center><h5>Referência qualificada</h5></center></br>";
                 echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Membro</th>
                   <th scope="col">Referência para</th>
                   <th scope="col">Data</th>
                   <th scope="col">Tipo</th>
                   <th scope="col">Deu Cartão ?</th>
                   <th scope="col">Falou que Liga?</th>
                   <th scope="col">Endereço</th>
                   <th scope="col">Empresa/Pessoa</th>
                   <th scope="col">Categoria</th>
                   <th scope="col">Telefone</th>
                   <th scope="col">E-mail</th>
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query33)){
                   
                  $cat = $sql['suspect_categoria_referencia'];
                  $queryi33 = mysqli_query($conexao->conectar(),"SELECT * FROM categorias where cod_cat='$cat'");
                  $sql2 = mysqli_fetch_assoc($queryi33);
                  
                echo' <tr>
                   <th>'.$sql['membro'].'</th>
                   <th>'.$sql['para'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_referencia']))).'</td>
                   <td>'.$sql['tipo_referencia'].'</td>
                   <td>'.$sql['cartao'].'</td>
                   <td>'.$sql['liga'].'</td>
                   <td>'.$sql['suspect_endereco_referencia'].'</td>
                   <td>'.$sql['suspect_empresa_pessoa'].'</td>
                   ';
                   if($sql2['pri_cat']!=null && $sql2['pri_cat']!=""){
                   echo '<td>'.$sql2['pri_cat'].' | '.$sql2['sec_cat'].' </td>';
                   }else{
                       echo '<td>'.$sql['outra_categoria'].'</td>';
                   }
                   echo '<td>'.$sql['suspect_telefone_referencia'].'</td>
                   <td>'.$sql['suspect_email_referencia'].'</td>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="gruponegocio"){
         echo "<center><h3 class='pager-header'>Grupo: ".$_SESSION['nome_grupo']."</h3></center></br><center><h5>Negócio fechado</h5></center></br>";
          echo "<hr>";
         echo'<table class="table cell-border compact stripe hover" id="myTable" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Membro</th>
                   <th scope="col">Obrigado(a)</th>
                   <th scope="col">Data</th>
                   <th scope="col">Valor</th>
                   <th scope="col">Referência</th>
                   <th scope="col">Negócio</th>
                 </tr>
               </thead>
               <tbody>';
               $total=0.0;
               while($sql = mysqli_fetch_array($query32)){
                $total+=$sql['valor_negocio'];
                echo' <tr>
                   <th>'.$sql['membro'].'</th>
                   <th>'.$sql['obrigado'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_negocio']))).'</td>
                   <td>R$ '.$sql['valor_negocio'].'</td>
                   <td>'.$sql['tipo_referencia'].'</td>
                   <td>'.$sql['tipo_negocio'].'</td>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             echo '
                 <center><h3>Valor total: R$ '.number_format($total,2,",",".").'</h3></center>';
             
           }else if($tipo=="grupoconvidado"){
         echo "<center><h3 class='pager-header'>Grupo: ".$_SESSION['nome_grupo']."</h3></center></br><center><h5>Convidado</h5></center></br>";
          echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Membro</th>
                   <th scope="col">Convidado</th>
                   <th scope="col">Documento</th>
                   <th scope="col">Empresa</th>
                   <th scope="col">Categoria</th>
                   <th scope="col">Data</th>
                   <th scope="col">Telefone</th>
                   <th scope="col">E-mail</th>
                   <th scope="col">Status</th>
                   
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query34)){
                   
                   
               $categoria = $sql['empresa_categoria'];
               $cate = mysqli_query($conexao->conectar(),"SELECT * FROM categorias where cod_cat='$categoria'");
               $sql2 = mysqli_fetch_assoc($cate);
                
                echo' <tr>
                    <th>'.$sql['membro'].'</th>
                   <th>'.$sql['nome_convidado'].'</th>
                   <th>'.$sql['cpf_cnpj_convidado'].'</th>
                   <td>'.$sql['empresa_convidado'].'</td>';
                  if($sql2['pri_cat']!="" && $sql2['pri_cat']!=null){
                    echo '<td>'.$sql2['pri_cat'].' | '.$sql2['sec_cat'].'</td>';
                  }else{
                      echo '<td>'.$sql['outra_categoria'].'</td>';
                  }
                  
                  echo '<td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_convidado']))).'</td>';
                   echo '
                   
                   <td>'.$sql['telefone_convidado'].'</td>
                   <td>'.$sql['email_convidado'].'</td>';
                   if($sql['conf_presenca']==0){
                       echo '<td><p style="color:blue">Pendente</p></td>';
                   }
                  else if($sql['conf_presenca']==1){
                       echo '<td><p style="color:green">Presente</p></td>';
                     }
                  else if($sql['conf_presenca']==2){
                       echo '<td><p style="color:red">Ausente</p></td>';
                  }
                
                echo '</tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="grupopontuacao"){
               echo "<center><h3 class='pager-header'>Grupo: ".$_SESSION['nome_grupo']."</h3></center></br><center><h5>Pontuação</h5></center></br>";
                echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Pontuador</th>
                   <th scope="col">Tipo</th>
                   <th scope="col">Pontuação</th>
                   <th scope="col">Data</th>
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query35)){
                   $tipo2="";
                   if($sql['tipo']=="1"){
                       $tipo2="Cara-a-Cara";
                   }else if($sql['tipo']=="2"){
                      $tipo2="Referência";
                   }else if($sql['tipo']=="3"){
                       $tipo2="Negócio fechado";
                   }else if($sql['tipo']=="4"){
                       $tipo2="Referência que virou um negócio fechado";
                   }else if($sql['tipo']=="5"){
                        $tipo2="Convidado";
                   }
                
                echo' <tr>
                   <th>'.$sql['membro'].'</th>
                   <th>'.$tipo2.'</th>
                   <th>'.$sql['valor'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_pontuacao']))).'</td>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="faturado"){
               echo '<h3 class="text-center pager-header">Valor faturado</h3><br/><br/>';
                echo "<hr>";
         echo'<table class="table cell-border compact stripe hover" id="myTable" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Quem faturou?</th>
                   <th scope="col">Referência que gerou</th>
                   <th scope="col">Data</th>
                   <th scope="col">Valor</th>
                   <th scope="col">Referência</th>
                   <th scope="col">Negócio</th>
                 </tr>
               </thead>
               <tbody>';
               $total=0;
               while($sql = mysqli_fetch_array($query4)){
                $total+= $sql['valor_negocio'];
                echo' <tr>
                   <th>'.$sql['nome_membro'].'</th>
                   <td><center><button class="btn btn-success detalhesrefe" data-target="#model" data-toggle="modal" value="'.$sql['cod_tipo'].'">Referência</button></center></td>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_negocio']))).'</td>
                   <td>R$ '.$sql['valor_negocio'].'</td>
                   <td>'.$sql['tipo_referencia'].'</td>
                   <td>'.$sql['tipo_negocio'].'</td>
                 </tr>';
                 
               }
               
              echo' </tbody>
             </table>';
             echo '
                 <center><h3>Valor total: R$ '.number_format($total,2,",",".").'</h3></center>';
           }else if($tipo=="gerado"){
               echo '<h3 class="text-center">Valor gerado</h3><br/><br/>';
                echo "<hr>";
         echo'
         <div class="bodycontainer scrollable">
         <table  id="myTable" class="table cell-border compact stripe hover table-scrollable" width="100%" >
               <thead>
                 <tr>
                   <th scope="col">Gerado para quem?</th>
                   <th scope="col">Referência que gerou</th>
                    <th scope="col">Empresa</th>
                   <th scope="col">Data</th>
                   <th scope="col">Valor</th>
                   <th scope="col">Referência</th>
                   <th scope="col">Negócio</th>
                 </tr>
               </thead>
               <tbody>';
               $total=0;
               while($sql = mysqli_fetch_array($query9)){
                $total+=$sql['valor_negocio'];
                echo' <tr>
                   <th>'.$sql['nome_membro'].'</th>
                   <td><center><button class="btn btn-success detalhesrefe" data-target="#model" data-toggle="modal" value="'.$sql['cod_tipo'].'">Referência</button></center></td>
                   <td>'.$sql['nome_empresa'].'</td>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_negocio']))).'</td>
                   <td>R$ '.$sql['valor_negocio'].'</td>
                   <td>'.$sql['tipo_referencia'].'</td>
                   <td>'.$sql['tipo_negocio'].'</td>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table></div>';
             
             echo '<center><h3>Valor total: R$ '.number_format($total,2,",",".").'</h3></center>';
             
           }else if($tipo=="negocio"){
               echo '<h3 class="text-center pager-header">Negócio fechado</h3><br/><br/>';
                echo "<hr>";
         echo'<table id="myTable" class="table table cell-border compact stripe hover" width="100%" >
               <thead>
                 <tr>
                   <th scope="col">Obrigado(a)</th>
                   <th scope="col">Data</th>
                   <th scope="col">Valor</th>
                   <th scope="col">Referência</th>
                   <th scope="col">Negócio</th>
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query10)){
                
                echo' <tr>
                   <th>'.$sql['nome_membro'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_negocio']))).'</td>
                   <td>R$ '.$sql['valor_negocio'].'</td>
                   <td>'.$sql['tipo_referencia'].'</td>
                   <td>'.$sql['tipo_negocio'].'</td>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="referencias"){
                echo '<h3 class="text-center pager-header">Referência qualificada</h3><br/><br/>';
                 echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Referência para</th>
                   <th scope="col">Data</th>
                   <th scope="col">Tipo</th>
                   <th scope="col">Cartão</th>
                   <th scope="col">Liga</th>
                   <th scope="col">Endereco</th>
                   <th scope="col">Categoria</th>
                   <th scope="col">Telefone</th>
                   <th scope="col">E-mail</th>
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query20)){
                  $cat = $sql['suspect_categoria_referencia'];
                  $queryi20 = mysqli_query($conexao->conectar(),"SELECT * FROM categorias where cod_cat='$cat'");
                  
                  $sql2 =mysqli_fetch_assoc($queryi20);
                
                echo' <tr>
                   <th>'.$sql['nome_membro'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_referencia']))).'</td>
                   <td>'.$sql['tipo_referencia'].'</td>
                   <td>'.$sql['cartao'].'</td>
                   <td>'.$sql['liga'].'</td>
                   <td>'.$sql['suspect_endereco_referencia'].'</td>';
                   
                   if($sql2['pri_cat']!=null && $sql2['pri_cat']!=""){
                   echo '<td>'.$sql2['pri_cat'].' | '.$sql2['sec_cat'].' </td>';
                   }else{
                       echo '<td>'.$sql['outra_categoria'].'</td>';
                   }
                   echo'<td>'.$sql['suspect_telefone_referencia'].'</td>
                   <td>'.$sql['suspect_email_referencia'].'</td>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="caracara"){
                echo '<h3 class="text-center pager-header">Cara-a-Cara</h3><br/><br/>';
                 echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover table-hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Com quem ?</th>
                   <th scope="col">Data</th>
                   <th scope="col">Local</th>
                   <th scoe="col">Conversa</th>
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query6)){
                
                echo' <tr>
                   <th>'.$sql['nome_membro'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_cara']))).'</td>
                   <td>'.$sql['endereco_cara'].'</td>
                   <td><center><button type="button" class="btn btn-primary conversa_cara"  data-target="#caracara_modal" data-toggle="modal" value="'.$sql['cod_cara'].'">Visualizar</button></center>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="convidado"){
                echo '<h3 class="text-center pager-header">Convidado</h3><br/><br/>';
                 echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Convidado</th>
                   <th scope="col">Documento</th>
                   <th scope="col">Empresa</th>
                   <th scope="col">Categoria</th>
                   <th scope="col">Data</th>
                   <th scope="col">Telefone</th>
                   <th scope="col">E-mail</th>
                   <th scope="col">Status</th>
                   
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query5)){
               
               $categoria = $sql['empresa_categoria'];
               $cate = mysqli_query($conexao->conectar(),"SELECT * FROM categorias where cod_cat='$categoria'");
                $sql2 = mysqli_fetch_assoc($cate);
                echo' <tr>
                   <th>'.$sql['nome_convidado'].'</th>
                   <th>'.$sql['cpf_cnpj_convidado'].'</th>
                   <td>'.$sql['empresa_convidado'].'</td>
                   ';
                   
                   if($sql2['pri_cat']!="" && $sql2['pri_cat']!=null ){
                   
                   echo '<td>'.$sql2['pri_cat'].' | '.$sql2['sec_cat'].'</td>';
                   }else{
                       echo '<td>'.$sql['outra_categoria'].'</td>';
                   }
                   echo '<td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_convidado']))).'</td>
                   <td>'.$sql['telefone_convidado'].'</td>
                   <td>'.$sql['email_convidado'].'</td>';
                   
                    if($sql['conf_presenca']==0){
                       echo '<td><p style="color:blue">Pendente</p></td>';
                   }
                  else if($sql['conf_presenca']==1){
                       echo '<td><p style="color:green">Presente</p></td>';
                     }
                  else if($sql['conf_presenca']==2){
                       echo '<td><p style="color:red">Ausente</p></td>';
                  }
                 echo'</tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="pontuacao"){
                echo '<h3 class="text-center pager-header">Pontuação</h3><br/><br/>';
                 echo "<hr>";
         echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Tipo</th>
                   <th scope="col">Pontuação</th>
                   <th scope="col">Data</th>
                 </tr>
               </thead>
               <tbody>';
               while($sql = mysqli_fetch_array($query2)){
                   $tipo2="";
                   if($sql['tipo']=="1"){
                       $tipo2="Cara-a-Cara";
                   }else if($sql['tipo']=="2"){
                      $tipo2="Referência";
                   }else if($sql['tipo']=="3"){
                       $tipo2="Negócio fechado";
                   }else if($sql['tipo']=="4"){
                       $tipo2="Referência que virou um negócio fechado";
                   }else if($sql['tipo']=="5"){
                        $tipo2="Convidado";
                   }
                
                echo' <tr>
                   <th>'.$tipo2.'</th>
                   <th>'.$sql['valor'].'</th>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_pontuacao']))).'</td>
                    </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
           }else if($tipo=="geradogrupo"){
               
               echo '<h3 class="text-center page-header">Grupo: '.$_SESSION['nome_grupo'].'</h3><center>Valor gerado</center><br/>';
                echo "<hr>";
             echo'<table id="myTable" class="table cell-border compact stripe hover" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Membro</th>
                   <th scope="col">Data</th>
                   <th scope="col">Valor</th>
                   <th scope="col">Negócio</th>
                 </tr>
               </thead>
               <tbody>';
               $total=0.0;
               while($sql = mysqli_fetch_array($query8)){
                   $total+=$sql['valor_negocio'];
                echo' <tr>
                   <td>'.$sql['iniciou'].'</td>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_negocio']))).'</td>
                   <td>R$ '.$sql['valor_negocio'].'</td>
                  <td><center><button type="button" class="btn btn-primary negocio"  data-target="#negocio_modal" data-toggle="modal" value="'.$sql['cod_negocio'].'">Visualizar</button></center>
                 </tr>';
                 
               }
                 
              echo' </tbody>
             </table>';
             
             echo '
                 <center><h3>Valor total: R$ '.number_format($total,2,",",".").'</h3></center>';
             
           }else if($tipo=="faturadogrupo"){
                   echo "<center><h3 class='pager-header'>Grupo: ".$_SESSION['nome_grupo']."</h3></center><center>Faturado</center><br/>";
                    echo "<hr>";
         echo'<table class="table cell-border compact stripe hover" id="myTable" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Quem faturou?</th>
                   <th scope="col">Referência que gerou</th>
                   <th scope="col">Data</th>
                   <th scope="col">Valor</th>
                   <th scope="col">Referência</th>
                   <th scope="col">Negócio</th>
                 </tr>
               </thead>
               <tbody>';
               $total=0.0;
               while($sql = mysqli_fetch_array($query22)){
                   $total+=$sql['valor_negocio'];
                echo' <tr>
                   <th>'.$sql['nome_membro'].'</th>
                   <td><center><button class="btn btn-success detalhesrefe" data-target="#model" data-toggle="modal" value="'.$sql['cod_tipo'].'">Referência</button></center></td>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_negocio']))).'</td>
                   <td>R$ '.$sql['valor_negocio'].'</td>
                   <td>'.$sql['tipo_referencia'].'</td>
                   <td>'.$sql['tipo_negocio'].'</td>
                 </tr>';
                 
               }
                echo' </tbody>
             </table>';
               
               echo '
                 <center><h3>Valor total: R$ '.number_format($total,2,",",".").'</h3></center>';
               
           }else if($tipo=="reuniao"){
                        echo "<center><h3 class='pager-header'>Grupo: ".$_SESSION['nome_grupo']."</h3></center><center>Reunião</center><br/><div class='clear-fix'></div>";
                        echo "<hr>";
         echo'<table class="table cell-border compact stripe hover" id="myTable" width="100%">
               <thead>
                 <tr>
                   <th scope="col">Ordem</th>
                   <th scope="col">Reuniao</th>
                   <th scope="col">Grupo</th>
                   <th scope="col">Data</th>
                   <th scope="col">Confirmação do Administrador</th>
                   <th scope="col">Minha confirmação</th>
                 </tr>
               </thead>
               <tbody>';
               $i=0;
               while($sql = mysqli_fetch_array($query36)){
                   $i++;
                echo' <tr>
                   <th>'.$i.'</th>
                   <td>'.$sql['titulo_reuniao'].'</td>
                   <td>'.$sql['nome_grupo'].'</td>
                   <td>'.str_replace('-','/',date('d/m/Y', strtotime($sql['data_reuniao']))).'</td>';
                   if($sql['conf_adm']=="1"){
                       echo '<td><p class="text-success">Confirmado</p></td>';
                   }else if($sql['conf_adm']=="2"){
                        echo '<td><p class="text-danger">Ausente</p></td>';
                   }else{
                       echo '<td><p class="text-warning">Pendente</p></td>'; 
                   }
                   if($sql['conf_membro']=="1"){
                       echo '<td><p class="text-success">Confirmado</p></td>';
                   }else if($sql['conf_membro']=="2"){
                        echo '<td><p class="text-danger">Ausente</p></td>';
                   }else{
                       echo '<td><p class="text-warning">Pendente</p></td>'; 
                   }
                   
                   
                 echo'</tr>';
                 
               }
                echo' </tbody>
             </table>';
               
               
               
           }else{
               
           }
           
           
             
             ?>
   </div>
   
   
   <!------------------------------------------------------------------ Modais-------------------------------- -->
   <div class="modal" id="negocio_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header" style="background-color:#00A650">
               <center>
                  <h3 class="modal-title text-center">Negócio</h3>
               </center>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <label>Obrigado(a):</label>
               <div class="form-group obrigado"></div>
               <label>Grupo obrigado(a):</label>
               <div class="form-group gruponego"></div>
               <label>Iniciou:</label>
               <div class="form-group iniciou"></div>
               <label>Data</label>
               <div class="form-group tipo_referencia"></div>
               <label>Tipo de referência</label>
               <div class="form-group tipo_negocio"></div>
               <label>Tipo negócio</label>
               <div class="form-group tipo_negocio"></div>
               </br>
               <div class="form-group">
                  <label>Comentários</label>
                  <textarea class="comentario form-control" col="6" row="6" disabled></textarea>
               </div>
               
            </div>
            <div class="modal-footer" style="background-color:#00A650">
               <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Fechar</button>
            </div>
         </div>
      </div>
   </div>
   <!-- modal para mostrar os negocios -->
   <div class="modal" id="model" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header" style="background-color:#00A650">
               <center>
                  <h3 class="modal-title text-center">Referência</h3>
               </center>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <label>Para:</label>
               <div class="form-group para"></div>
               <label>Referenciou:</label>
               <div class="form-group membro"></div>
               <label>Grupo de quem referenciou:</label>
               <div class="form-group grupo"></div>
               <label>Data</label>
               <div class="form-group data"></div>
               <label>Tipo de referência</label>
               <div class="form-group referencia"></div>
               <label>Falou que liga ?</label>
               <div class="form-group liga"></div>
               <label>Deu cartão ?</label>
               <div class="form-group cartao"></div>
               <label>Local</label>
               <div class="form-group endereco"></div>
               <label>E-mail</label>
               <div class="form-group email"></div>
               <div class="form-group">
                  <label>Comentários</label>
                  </br>
                  <textarea class="comentario" cols="36" rows="5" disabled></textarea>
               </div>
               <label>Potencial</label>
               <div class="form-group potencial"></div>
            </div>
            <div class="modal-footer" style="background-color:#00A650">
               <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Fechar</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal para mostrar a conversa do Cara-a-Cara -->
   <div class="modal" id="caracara_modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header" style="background-color:#00A650">
               <center>
                  <h3 class="modal-title text-center">Conversa</h3>
               </center>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <textarea class="conversa_text form-control" disabled></textarea>
               </div>
            </div>
            <div class="modal-footer" style="background-color:#00A650">
               <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Fechar</button>
            </div>
         </div>
      </div>
   </div>

   
  
                 <!-------------------------------------------------------------- Scripts  -----------------------------------------------------------------> 
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.js"></script>
   <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
   <!-- Script-->    
   <script src="../scripts/contribuicoes.js"></script>
</body>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
<?php require_once("rodape.php");?>
</html>