  
      $(document).ready(function(){
          
          
          
       // Inseri máscara no CEP
	    $(".cep").mask("99999-999");
      
       
    
      
      $(".cadastrar").click(function(){
      
      if($(".quem").val()==""){alert("Preencha o campo com quem!"); $(".quem").focus();}
      else if($(".data").val()==""){alert("Preencha a data do encontro"); $(".data").focus();}
      //else if($(".cep").val()==""){alert("Preencha o Cep!"); $(".cep").focus();}
      //else if($(".rua").val()==""){alert("Preencha a rua!"); $(".rua").focus();}
      //else if($(".bairro").val()==""){alert("Preencha o bairro!"); $(".bairro").focus();}
        //else if($(".cidade").val()==""){alert("Preencha a cidade!"); $(".cidade").focus();}
        //else if($(".estado").val()==""){alert("Preencha o estado!"); $(".estado").focus();}
      else{
      $(".formulario").submit();
      }
      
      
      });
      $(document).keypress(function(e) {
      if (e.which == 13) {
     if($(".quem").val()==""){alert("Preencha o campo com quem!"); $(".quem").focus();}
      else if($(".data").val()==""){alert("Preencha a data do encontro"); $(".data").focus();}
      //else if($(".cep").val()==""){alert("Preencha o Cep!"); $(".cep").focus();}
      //else if($(".rua").val()==""){alert("Preencha a rua!"); $(".rua").focus();}
      //else if($(".bairro").val()==""){alert("Preencha o bairro!"); $(".bairro").focus();}
      //else if($(".cidade").val()==""){alert("Preencha a cidade!"); $(".cidade").focus();}
      //else if($(".estado").val()==""){alert("Preencha o estado!"); $(".estado").focus();}
      else{
      $(".formulario").submit();
      }
      
          }
          });


    $('.cep').on('blur', function(){
        
        var cep =  $(".cep").val();
        
        if(!cep){
            return
        }else{
            
            var url = 'https://viacep.com.br/ws/'+cep+'/json';
            $.getJSON(url, function(data){
                if("erro" in data){
                    return 
                }
                
            $('.rua').val(data.logradouro);
            $('.bairro').val(data.bairro);
            $('.cidade').val(data.localidade);
            $('.estado').val(data.uf);
            
            });
            
        }
        
		});
		
		

		var valor2 = $('.grupo').val();
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar4.php',
            data:{valor2:valor2},
        success:function(data){
            $('.mostrar2').html(data);  
            }
    
		})
	
	$('.grupo').change(function(){

		
		var valor2 = $('.grupo').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar4.php',
            data:{valor2:valor2},
        success:function(data){
            $('.mostrar2').html(data);  
            }
    
		})
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
            }
    
		})
		
		
	});
		
		
	$('.data').click(function(){
	    
		var valor3 = $('.quem').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
            }
    
		})
	});
	
	
  function RetornaDataHoraAtual(){
        var dNow = new Date();
        var mes1 = "";
         var mes = ""+(dNow.getMonth()+1);
         if(mes.length==1){
            mes1="0"+mes;
         }else{
             mes1=mes;
         }
         
        var localdate = dNow.getDate() + '/' + mes1 + '/' + dNow.getFullYear();
        return localdate;
     }
	
	$('.data').blur(function(){
	    
		var valor3 = $('.quem').val();
		
		//var dataatual=""+RetornaDataHoraAtual();
		//var data =""+$('.data').val();
		
		//if(dataatual!=data){
		//    alert("Essa data não é a atual");
	//	}else{
	    //alert("data ok");
	//	}
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
            }
    
		})
	});
	
	
		$('.grupo').click(function(){
	    
		var valor3 = $('.quem').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
            }
    
		})
		
		
	});
	
		$('.cep').click(function(){
	    
		var valor3 = $('.quem').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
            }
    
		})
		
		
	});
	
	
	$('.cidade').click(function(){
	    
		var valor3 = $('.quem').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
            }
    
		})
		
		
	});
	
		$('.estado').click(function(){
	    
		var valor3 = $('.quem').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
            }
    
		})
		
		
	});
	
	
	

	
	
     
	});	
      
      
     
      
      
  