$(document).ready(function(){
    
     
          $('.editar').click(function(){
          $('#model').modal('handleUpdate')
          
           
          $.getJSON("http://webunace.acejundiai.com.br/api/mostrarcategoria.php?categoriaId="+$(this).val()+"", function( data ) {
                 
               $('.primeira').val(data.primeira);
               $('.segunda').val(data.segunda);
               $('.categoriaId').val(data.cod_cat);
               
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
