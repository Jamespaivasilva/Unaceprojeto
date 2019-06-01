$(document).ready(function(){
    
    $('.js-example-basic-single').select2();
    
$('.categoria').change(function(){
    
    var valor = $(this).val();

    if(valor=="outro"){
        $('.categoria2').append('<label>Qual outra?</label><input type="text" name="outro" class="form-control outro"  required/>');
        
    }else{
        $('.categoria2').remove();
    }
    
});
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
});