$(document).ready(function(){
    
    
    
   $('.editar').click(function(){
       
        $.getJSON("http://webunace.acejundiai.com.br/api/grupo.php?grupoId="+$(this).val()+"", function( data ) {
           $('.cod_grupo').val(data.cod_grupo);
           $('.nome').val(data.nome);
           $('.fundacao').val(data.fundacao);
            
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});
