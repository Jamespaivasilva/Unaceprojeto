$(document).ready(function(){
    
     
          $('.editar').click(function(){
          $('#model').modal('handleUpdate')
          
           
           
           
        $.getJSON("http://webunace.acejundiai.com.br/api/membro.php?membroId="+$(this).val()+"", function( data ) {
   	              
               $('.nome').val(data.nome);
               $('.nascimento').val(data.nascimento);
               $('.usuario').val(data.usuario);
               $('.usuarioatual').val(data.usuario);
               $('.cpf').val(data.cpf);
                $(".vencimento").val(data.validade);
               $(".empresa").val( $('option:contains('+data.nome_empresa+')').val() );
               $(".papel").val( $('option:contains('+data.papel+')').val() );
               $(".grupos").val( $('option:contains('+data.grupo+')').val() );
               $(".nivel").val( $('option:contains('+data.nivel_acesso+')').val() );
               $(".cod_membro").val(data.cod_membro);
               $(".pgrupo").val(data.cod_grupo);
               $('#model').modal('handleUpdate')
                
            });
          
          });
          
          //confirmação para bloquear o membro
          $('.bloqueiar').click(function(){
             $('#conf').modal('handleUpdate')  
             var valor = $(this).val();
             $('.membroId').val(valor);
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
       
       
    // Inseri máscara no CPF
     $(".cpf").mask('000.000.000-00', {reverse: true});
     
      
 
function validaCPF(cpf) {	
	cpf = cpf.replace(/[^\d]+/g,'');	
	if(cpf =='') return false;	
	// Elimina CPFs invalidos conhecidos	
	if (cpf.length != 11 || 
		cpf == "00000000000" || 
		cpf == "11111111111" || 
		cpf == "22222222222" || 
		cpf == "33333333333" || 
		cpf == "44444444444" || 
		cpf == "55555555555" || 
		cpf == "66666666666" || 
		cpf == "77777777777" || 
		cpf == "88888888888" || 
		cpf == "99999999999")
			return false;		
	// Valida 1o digito	
	add = 0;	
	for (i=0; i < 9; i ++)		
		add += parseInt(cpf.charAt(i)) * (10 - i);	
		rev = 11 - (add % 11);	
		if (rev == 10 || rev == 11)		
			rev = 0;	
		if (rev != parseInt(cpf.charAt(9)))		
			return false;		
	// Valida 2o digito	
	add = 0;	
	for (i = 0; i < 10; i ++)		
		add += parseInt(cpf.charAt(i)) * (11 - i);	
	rev = 11 - (add % 11);	
	if (rev == 10 || rev == 11)	
		rev = 0;	
	if (rev != parseInt(cpf.charAt(10)))
		return false;		
	return true;   
}



});
