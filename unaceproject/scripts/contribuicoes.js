 $(document).ready(function(){
       
           
           // Se o usuário selecionar uma ds opções disponíveis.
          $('.tipo').change(function(){
              if($('.inicial').val()==""){
                  alert("digite uma data inicial!");
              }else if($('.final').val()==""){
                  alert("digite uma data final!");
              }else{
              
              $('.formulario').submit();
              }
              
          });
          
          $('.conversa_cara').click(function(){
              
              var valor = $(this).val(); 
          $.getJSON("http://webunace.acejundiai.com.br/api/caracara.php?caracaraId="+valor+"", function( data ) {
               $('.conversa_text').val(data.conversa);
                
            });
              
          });
          
        
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
       
       
        $('.negocio').click(function(){
            
            
           var valor = $(this).val(); 
          $.getJSON("http://webunace.acejundiai.com.br/api/negocio.php?negocioId="+valor+"", function( data ) {
                 
               $('.obrigado').html(data.obrigado);
               $('.gruponego').html(data.grupo);
               $('.iniciou').html(data.iniciou);
               $('.data').html(data.data_negocio);
               $('.tipo_referencia').html(data.tipo_referencia);
               $('.tipo_negocio').html(data.tipo_negocio);
               $('.comentario').html(data.comentarios_negocio);
               
               
              $('#modal_negocio').modal('handleUpdate')
                
            });
       
            
        });
        
        $('.detalhesrefe').click(function(){
            
            
           var valor = $(this).val(); 
          $.getJSON("http://webunace.acejundiai.com.br/api/referencia.php?referenciaCode="+valor+"", function( data ) {
                 
               $('.para').html(data.para);
               $('.membro').html(data.membro);
               $('.grupo').html(data.grupo);
               $('.data').html(data.data);
               $('.referencia').html(data.referencia);
               $('.cartao').html(data.cartao);
               $('.endereco').html(data.endereco);
               $('.liga').html(data.liga);
               $('.email').html(data.email);
               $('.comentario').html(data.comentario);
               if(data.potencial==1){
                 $('.potencial').html("Fraco");
               }else if(data.potencial==2){
                 $('.potencial').html("Boa"); 
               }else if(data.potencial==3){
                 $('.potencial').html("Forte");
               }else if(data.potencial==4){
                 $('.potencial').html("Muito forte");
               }
               
               $('#model').modal('handleUpdate')
                
            });
       
            
        });
        
        
          
       });
       
