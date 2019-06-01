
    
    $(document).ready(function(){
 	$('.js-example-basic-single').select2();       
        
        //validar campos
        
        $('#cadastrar').click(function(){
          
          var titular = $('.titular').val();
          var sub = $('.sub').val();
          var data = $('.data').val();
          
          if(titular==null){
              alert("A empresa precisa ter um membro titular");
          }else if(data==""){
              alert("A data deve ser preenchida!");
          }else{
              
              $('.empresagrupo').submit();
          }
      
      }); 
      
      var valor = 0;
      function carregar(){
          
          $.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar.php',
            data:{valor:valor},
        success:function(data){
            $('.mostrar').html(data);  
            }
    
		})
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar2.php',
            data:{valor:valor},
        success:function(data){
            $('.mostrar2').html(data);  
            }
    
		})
		
      }  
      
      
      carregar();
        
    $('.empresa').change(function(){
       
      

		var valor = $('.empresa').val();
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar.php',
            data:{valor:valor},
        success:function(data){
            $('.mostrar').html(data);  
            }
    
		})
		
		
		$.ajax({
		    type: 'post',
			url: '../funcionalidade/pesquisar2.php',
            data:{valor:valor},
        success:function(data){
            $('.mostrar2').html(data);  
            }
    
		})
		
     
  
       
     
    }); 
    
    
        
        
        
    });
    
    
