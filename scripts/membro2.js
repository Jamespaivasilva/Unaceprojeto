$(document).ready(function(){
    
       $(document).keypress(function(e) {
      if (e.which == 13) {
       var cnpj = $(".cnpj").val();
      if(validarCNPJ(cnpj)!=true){alert("CNPJ inválido!");}
      else if($(".empresa").val()==""){alert("Campo nome da empresa está vázio."); $(".empresa").focus();}
      else if($(".cnpj").val()==""){alert("Campo Cnpj está vázio."); $(".cnpj").focus();}
      else if($(".fundacao").val()==""){alert("Campo Data de fundaçao está vázio."); $(".fundacao").focus();}
      else{
      $(".formulario").submit();
      }
          }
          });
    
    $('.js-example-basic-single').select2();
    // Inseri máscara no CEP
	    $(".cep").mask("99999-999");
     $(".cpf").mask('000.000.000-00', {reverse: true});
      
      var cont = 1;
      var cont2 = 1;
      
     $('.maistelefone').click(function(){
         cont++;
         $('.telefone2').append('</br><div class="telefone2" id="campo'+ cont +'"><div class="row"><div class="col-md-2"></div><div class="col-md-4"><label for="exampleFormControlSelect1">Contato:</label></div></div><div class="row"><div class="col-md-2"></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control ddd"  name="ddd[]" placeholder="ddd"  maxlength="2" data-parsley-type="digits" required/></div></div><div class="col-md-2"><div class="form-group"><input type="text" class="form-control numero" name="numero[]" placeholder="numero"  maxlength="9" data-parsley-type="digits" required/></div></div><div class="col-md-2"><div class="form-group"><select class="form-control tipo" name="tipo[]"><option value="residencial">Residencial</option><option value="particular">Particular</option></select></div></div> </div><div class="row"><div class="col-md-2"></div> <div class="col-md-4"> <button type="button" class="btn btn-danger menostelefone" id="'+ cont +'">-Telefone</button></div></div></div>');
     });
     
     $('.telefone2').on("click",".menostelefone", function(){
         
         var button_id = $(this).attr("id");
         
         $('#campo'+ button_id +'').remove();
     });
     
     
     $('.maisemail').click(function(){
         cont2++;
         $('.email2').append('</br></br><div class="form-group email2" id="campo'+ cont2 +'"><label for="exampleFormControlSelect1">E-mail:</label><input type="email" class="form-control email" name="email[]" placeholder="E-mail" required></br><button type="button" class="btn btn-danger menosemail" id="'+ cont2 +'">- Email</button></div>');
     });
     
     $('.email2').on("click",".menosemail", function(){
         
         var button_id = $(this).attr("id");
         
         $('#campo'+ button_id +'').remove();
     });
      
      
      $(document).keypress(function(e) {
      if (e.which == 13) {
      var cpf = $(".cpf").val();
      if(validaCPF(cpf)!=true){alert("CPF inválido!");}
      else if($(".nome").val()==""){alert("Campo nome está vázio."); $(".nome").focus();}
      else if($(".nascimento").val()==""){alert("Campo data de nascimento está vazio."); $(".nascimento").focus();}
      else if($(".ddd").val()==""){alert("Campo DDD está vázio."); $(".ddd").focus();}
      else if($(".numero").val()==""){alert("Campo numero está vázio."); $(".numero").focus();}
      else if($(".email").val()==""){alert("Campo e-mail está vázio."); $(".email").focus();}
      else if($(".senha").val()==""){alert("Campo senha está vázio."); $(".senha").focus();}
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
                    return }
               
            $('.rua').val(data.logradouro);
            $('.bairro').val(data.bairro);
            $('.cidade').val(data.localidade);
            $('.estado').val(data.uf);
            
            });
            
        }
	
		}); 
    
    
    
    
});


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



