 $(document).ready(function(){
        
     $('.emails').click(function(){
         
           
          $.getJSON("http://webunace.acejundiai.com.br/api/email.php?emailId="+$(this).val()+"", function( data ) {
               $('.emailId').val(data.cod_email);
               $('.emailedit').val(data.email);
            });
          
          });
          
     $('.excluiremail').click(function(){
        $('.emailId').val($(this).val());
     });


    $('.editartelefone').click(function(){
         
           
          $.getJSON("http://webunace.acejundiai.com.br/api/telefone.php?telefoneId="+$(this).val()+"", function( data ) {
              
               //defindo a primeira letra em maiusculo
               var tipo = data.tipo_tel;
               var tamanho = 0;
               tamanho = tipo.length;
               var primeiraLetra = tipo.charAt(0).toUpperCase();
               var restoString = tipo.slice(1,tamanho);
               tipo = primeiraLetra+""+restoString;
              
               $('.ddd_tel').val(data.ddd);
               $('.num_tel').val(data.numero);
               $('.telefoneId').val(data.cod_telefone);
               $('.tipo').val($('option:contains('+tipo+')').val());
               $('.tipoatual').val(data.tipo_tel);
            });
          
          });
          
    $('.excluirtelefone').click(function(){
        $('.telefoneId').val($(this).val());
     });      
          
    
     
     
});
