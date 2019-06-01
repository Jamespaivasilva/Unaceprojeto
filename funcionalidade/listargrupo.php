<?php
// Essa página vai ser um gancho para ajax, da página confirmar prenseça, vamos aqui buscar a lista de membros que deveriam  estar presente.

require_once('../classes/conexao.php');

    $conexao = new Conexao();
    
    
    $cod_reuniao = $_POST['valor'];
    
    $query = mysqli_query($conexao->conectar(),"SELECT participa_reuniao.cod_reuniao reuniao,cod_participa,conf_membro,conf_adm,titulo_reuniao,nome_membro,nome_grupo,hora_inicial,hora_final,data_disponibilidade,nome_papel FROM participa_reuniao INNER JOIN membros on participa_reuniao.cod_membro=membros.cod_membro INNER JOIN grupos on participa_reuniao.cod_grupo=grupos.cod_grupo INNER JOIN reunioes on participa_reuniao.cod_reuniao=reunioes.cod_reuniao INNER JOIN disponibilidade on reunioes.cod_data_reuniao=disponibilidade.cod_disponibilidade INNER JOIN papel on membros.papel_membro_papel=papel.cod_papel WHERE participa_reuniao.cod_reuniao=' $cod_reuniao'");
    
    $query2 = mysqli_query($conexao->conectar(),"SELECT * FROM convidados 
    INNER JOIN membros on convidados.cod_dequem_convidado_juncao=membros.cod_membro
    INNER JOIN reunioes on convidados.cod_reuniao_participa=reunioes.cod_reuniao
    where cod_reuniao_participa='$cod_reuniao'")
    ?>
        
        
     
   
   
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
   
   <!-- Jquery -->
  
            <script>
                
                
         $(document).ready(function(){
        $("#myTable").dataTable({
                "scrollX": true,
                "bJQueryUI": true,
                "oLanguage": {
                    "sProcessing":   "Processando...",
                    "sLengthMenu":   "Mostrar _MENU_ registros",
                    "sZeroRecords":  "Não foram encontrados resultados",
                    "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                    "sInfoFiltered": "",
                    "sInfoPostFix":  "",
                    "sSearch":       "Buscar:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext":     "Seguinte",
                        "sLast":     "Último"
                    }
                }
            })  
             $('.dataTables_length').addClass('bs-select');

            });
            </script>
            
        </head>
        <body>
            <table id="myTable" class="table cell-border compact stripe hover table-responsive">
                <thead>
                <tr>
                    <th scope="col">Papel</th>
                    <th scope="col">Representante</th>
                    <th scope="col">Grupo</th>
                    <th scope="col">Reunião</th>
                    <th scope="col">Data</th>
                    <th scope="col">Hora inicial</th>
                    <th scope="col">Hora final</th>
                    <th scope="col">Confirmação do membro</th>
                    <th scope="col">Presença</th>
                    <th scope="col">Ausência</th>
                    
                </tr>
              </thead>
                 <tbody>
            <?php while($sql = mysqli_fetch_array($query)){ 
            $cod_reuniao = $sql['reuniao'];
            ?>
            
            <tr>
            <td><?php echo $sql['nome_papel'] ?></td>
            <td><?php echo $sql['nome_membro'] ?></td>
            <td><?php echo $sql['nome_grupo'] ?></td>
            <td><?php echo $sql['titulo_reuniao'] ?></td>
            <td><?php echo str_replace('-','/',date('d/m/Y', strtotime($sql['data_disponibilidade']))) ?></td>
            <td><?php echo $sql['hora_inicial'] ?></td>
            <td><?php echo $sql['hora_final'] ?></td>
            <td><?php 
                if($sql['conf_membro']=="0"){
                    echo "<h5>Não confirmado!</h5>";
                }else if($sql['conf_membro']=="1"){
                    echo "<h5 style='color:green;'>Confirmado!</h5>";
                }else if($sql['conf_membro']=="2"){
                    echo "<h5 style='color:red;'>Ausente!</h5>";
                }
                
                ?>
                </td>
            <td>
                <?php if($sql['conf_adm']=="0" || $sql['conf_adm']=="2"){ ?>
                <a href="/funcionalidade/presencareuniao.php?acao=presenca&tipo=adm&cod_participa=<?php echo $sql['cod_participa']; ?>&reuniao=<?php echo $cod_reuniao; ?>"><button class="btn btn-success">Presente</button></a>
                <?php }else{ ?>
                <h5 style='color:green;'>Confirmado!</h5>
                <?php } ?>
                
                </td>
                
            <td>
                <?php if($sql['conf_adm']=="0" || $sql['conf_adm']=="1"){ ?>
                <a href="/funcionalidade/presencareuniao.php?acao=ausenca&tipo=adm&cod_participa=<?php echo $sql['cod_participa'] ?>&reuniao=<?php echo $cod_reuniao; ?>"><button class="btn btn-danger">Ausente</button></a></td>
                <?php }else{ ?>
                <h5 style='color:red;'>Ausente!</h5>
                <?php } ?>
            <tr>
                
             <?php } ?>
            
            </tbody>
            </table>
            </br></br>
            <h4>Convidados</h4>
            <table id="myTable" class="table cell-border compact stripe hover table-responsive">
                
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Quem convidou</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Reunião</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Presente</th>
                    <th scope="col">Ausente</th>
                </tr>
                
                <?php while($sql = mysqli_fetch_array($query2)){ ?>
                  
                <tr>
                    <td><?php echo $sql['nome_convidado']; ?></td>
                    <td><?php echo $sql['nome_membro']; ?></td>
                    <td><?php echo $sql['empresa_convidado']; ?></td>
                    <td><?php echo $sql['titulo_reuniao']; ?></td>
                    <td><?php echo $sql['telefone_convidado']; ?></td>
                    <td><?php echo $sql['email_convidado']; ?></td>
                    <?php if($sql['conf_presenca']!='1'){?>
                    <td>
                        <a href="/funcionalidade/presencareuniao.php?acao=convidadopresenca&tipo=convidado&cod_participa=<?php echo $sql['cod_convidado'] ?>&reuniao=<?php echo $sql['cod_reuniao'];?>"><button type="button" class="btn btn-success">Presente</button></a>
                        
                        </td>
                    <?php }else{?>
                    <td><span style="color:green;">Presente!</span></td>
                    <?php } ?>
                    <?php if($sql['conf_presenca']!='2'){?>
                    <td><a href="/funcionalidade/presencareuniao.php?acao=convidadoausenca&tipo=convidado&cod_participa=<?php echo $sql['cod_convidado'] ?>&reuniao=<?php echo $sql['cod_reuniao']; ?>"><button type="button" class="btn btn-danger">Ausente</button></a></td>
                    <?php }else{?>
                    <td><span style="color:red;">Ausente!</span></td>
                    <?php } ?>
                </tr>
                
                <?php } ?>
                
                
                
            </table>
      </body>
       
     
       