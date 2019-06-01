

$(document).ready(function(){
    
    
    //$('.js-example-basic-single').select2();
    
    
    	var valor = $('.endereco').val();
    	
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar3.php',
            data:{valor:valor},
        success:function(data){
            $('.mostrar').html(data);  
            }
    
		})
    
    
   $('.endereco').change(function(){
    

		var valor = $('.endereco').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar3.php',
            data:{valor:valor},
        success:function(data){
            $('.mostrar').html(data);  
            }
    
		})
   
     
  
     
    });  
    
    
    $(".cadastrar").click(function(){
	    if($(".titulo2").val()==""){alert("Campo título vazio"); $(".titulo").focus();}
	    else if($(".disponibilidade").val()==null){alert("Não há disponibilidade");}else{
            $('.formulario').submit();
        }
	});
	
	 
    
    
    
     $(document).keypress(function(e) {
        if (e.which == 13) {
	   if($(".titulo2").val()==""){alert("Campo título vazio"); $(".titulo").focus();}
	    else if($(".disponibilidade").val()==null){alert("Não há disponibilidade"); }
        else{
            $('.formulario').submit();
        }
        }
	
	  });
    
    
    
});