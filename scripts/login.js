$(document).ready(function(){
          
         //Fazer submit no login, levar até a página de ínicio.
        $('.entrar').click(function(){
            var email = $('.email').val();
            var senha = $('.senha').val();
            
            if(email=="" || email==null || senha=="" || senha==null){
                alert("Olá Membro, por favor preencha os campos de acesso");
            }else{
             $('.logar').submit();
            }
        });
        
        $(document).keypress(function(e){
      if (e.which == 13){
            var email = $('.email').val();
            var senha = $('.senha').val();
            
            if(email=="" || email==null || senha=="" || senha==null){
                alert("Olá Membro, por favor preencha os campos de acesso");
            }else{
             $('.logar').submit();
            }
          
      
          
        }
      
        });
       
      });