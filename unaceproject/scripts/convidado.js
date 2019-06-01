


$(document).ready(function(){
    
    $('.js-example-basic-single').select2();

    //validar se é cnpj ou cpf

    $(".cpfecnpj").keydown(function(){
    try {
        $(".cpfecnpj").unmask();
    } catch (e) {}
 
    var tamanho = $(".cpfecnpj").val().length;
 
    if(tamanho < 11){
        $(".cpfecnpj").mask("999.999.999-99");
    } else {
        $(".cpfecnpj").mask("99.999.999/9999-99");
    }                   
});    
    
    

    
$('.categoria').change(function(){
    
    var valor = $(this).val();

    if(valor=="outro"){
        $('.categoria2').append('<label>Qual outra?</label><input type="text" name="outro" class="form-control outro"  required/>');
        
    }else{
        $('.categoria2').remove();
    }
    
});

    
    
    
    
    
    
    
    
});