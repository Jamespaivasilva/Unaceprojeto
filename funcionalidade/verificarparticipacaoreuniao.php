
<?php

// VERIFICAR SE O MEMBRO TEM ALGUMA CONFIRMAÇÃO DE PRESENÇA DE REUNIÃO PENDENTE

require_once('../classes/conexao.php');

 $conexao = new Conexao();
 
  $codigo=0;
  $codigo_participa="";
  $titulo_reuniao="";
  $data_reunião="";
  $nome_membro="";
  $inicial="";
  $final="";
  $datateste=0;
  
  if(isset($_SESSION['id'])){
  $id_membro = $_SESSION['id'];
  }else{
    session_start();
   $id_membro = $_SESSION['id'];
   
  }  
  
  //data atual
  date_default_timezone_set('America/Sao_Paulo');
     $date = date('Y-m-d');
      
 //verificar se o membro tem uma confirmação de participação de reunião pendente
 $query30 = mysqli_query($conexao->conectar(),"SELECT * FROM participa_reuniao 
 INNER JOIN reunioes on participa_reuniao.cod_reuniao=reunioes.cod_reuniao 
 INNER JOIN disponibilidade on reunioes.cod_data_reuniao=disponibilidade.cod_disponibilidade
 INNER JOIN membros on participa_reuniao.cod_membro=membros.cod_membro
 where participa_reuniao.cod_membro='$id_membro' and conf_membro='0' and data_disponibilidade < '$date'
");

// Verificar se a data é igual ou superior a de hoje, se sim aparecer o modal

?>
 
  
  <?php while($sql30 = mysqli_fetch_array($query30)){ 
       $codigo+=1;
       $codigo_participa = $sql30['cod_participa'];
       $titulo_reuniao = $sql30['titulo_reuniao'];
       $data_reuniao= $sql30['data_disponibilidade'];
       $nome_membro = $sql30['nome_membro'];
       $inicial = $sql30['hora_inicial'];
       $final = $sql30['hora_final'];
       
      
    } 
 
 ?>
 
 
 
  <script>
       $(document).ready(function(){
           
           $('.periodo').change(function(){
               
              $('.formperiodo').submit();
           });
           
           <?php if($codigo!=0) {?>
           $('#teste').modal('show'); 
           
           $('.ausente').click(function(){
               $('.acao').val("ausenca");
               if($('.acao').val()!="" && $('.acao').val()!=null){
                   $('.formulario').submit();
               }
           });
           $('.presente').click(function(){
               $('.acao').val("presenca");
               if($('.acao').val()!="" && $('.acao').val()!=null){
                   $('.formulario').submit();
               }
           });
           <?php } ?>
       });
       
   </script>
   
    <div class="modal"  id="teste" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmação de presença</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <p>Olá <?php  echo "Sr(a) ".$nome_membro; ?></p>
         </br>
        <p>Queremos confirmar a sua presença na reunião '<?php echo $titulo_reuniao; ?>' que aconteceu em <?php echo str_replace('-','/',date('d/m/Y', strtotime($data_reuniao))); ?> das <?php echo $inicial; ?> até <?php echo $final; ?></p>
      </div>
      <div class="modal-footer">
        <form name="formulario" class="formulario" method="GET" action="../funcionalidade/presencareuniao.php" />
        <input type="hidden" name="tipo" class="tipo" value="membro"/>
        <input type="hidden" name="acao" class="acao"/>
        <input type="hidden" name="cod_participa" class="cod_participa" value="<?php echo $codigo_participa; ?>" />
        <button type="button" class="btn btn-danger ausente">Ausente</button>
        <button type="button" class="btn btn-success presente">Presente</button>
        </form>
        <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
      </div>
    </div>
  </div>
</div>






    
    
