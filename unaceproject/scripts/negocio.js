
$(document).ready(function(){

   //usar mascara de dinheiro(real)
   $(".gerou").mask('#.##0,00', {reverse: true});
   
   
   
   //validar se os campos foram preenchidos
   //$(".cadastrar").click(function(){
      
    //  if($(".quem").val()==""){alert("Preencha o campo de quem você é grato!"); $(".quem").focus();}
     // else if($(".data").val()==""){alert("Preencha a data do negócio"); $(".data").focus();}
      //else if($(".empresa").val()==""){alert("Empresa não foi carregada!"); $(".empresa").focus();}
      //else if($(".gerou").val()==""){alert("Preencha o valor gerado!"); $(".gerou").focus();}
      //else if(!$(".negocio").is(':checked')){alert("Novo negocio ? Ou não ?"); $(".negocio").focus();}
      //else if(!$(".referencia").is(':checked')){alert("Referência externa ou interna"); $(".referencia").focus();}
        
      //else{
      //$(".formulario").submit();
     // }
      
      
     // });
   
   //carregar membros de grupos
    
    var valor2 = $('.grupo').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar4.php',
            data:{valor2:valor2},
        success:function(data){
            $('.mostrar2').html(data);  
            }
    
		})
		
		
  //carregar o campo para empresa vazio, só para não ficar sem um campo(não passo valor, é só para não da erro);
  var valor3 = 0;
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar5.php',
            data:{valor2:valor3},
        success:function(data){
            $('.mostrar3').html(data);  
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
	
	$('.negocio').click(function(){
	    
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





