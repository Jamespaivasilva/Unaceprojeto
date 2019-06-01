$(document).ready(function(){
     $(".cnpj").mask('00.000.000/0000-00');
     
          $('.editar').click(function(){
          $('#model').modal('handleUpdate')
     
          $.getJSON("http://webunace.acejundiai.com.br/api/empresa.php?empresaId="+$(this).val()+"", function( data ) {
              
              var categoria ="";
              var cnpj2 ="";
              
              cnpj2 = data.cnpj;
              
              cnpj2 = cnpj2.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1 $2 $3/$4-$5")
                 
               $('.empresa').val(data.cod_empresa);
               $('.nome').val(data.nome_empresa);
               $('.cnpj').val(cnpj2);
               categoria = data.pricategoria+" | "+data.seccategoria;
               $('.categoria').val( $('option:contains('+categoria+')').val() );
               $('.descricao').val(data.descricao);
               $('.categoriaatual').val(data.cod_cat);
               $('.data').val(data.data_fundacao);
               $('#model').modal('handleUpdate')
                
            });
          
          });
          
          //confirmação para bloquear o membro
          $('.excluir').click(function(){
             $('#conf').modal('handleUpdate')  
             var valor = $(this).val();
             alert($(this).val());
             $('.categoriaId').val(valor);
          });
          
          //confirmação para desbloquear o membro
          $('.desbloquear').click(function(){
             $('#confdes').modal('handleUpdate')  
             var valor = $(this).val();
             $('.membroId').val(valor);
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
       
       

     
      

});
