

<?php

$valor = $_POST['valor2'];




// Conectar ao banco, pra que ? Para puxar todos os registros de categorias
    require_once('../classes/conexao.php');
    
    // Instanciar class Conexão
     $conexao = new Conexao();
    
    //Iniciar o metódo para conectar
     $conexao->conectar();
     
     $query = mysqli_query($conexao->conectar(),"select cod_membro,nome_membro,cod_empresa,nome_empresa from membros INNER JOIN empresas on membros.cod_membro_empresa=empresas.cod_empresa where cod_membro='$valor';");

?>


<!DOCTYPE html>

<head>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>    
    
</head>


<select name="empresa" class="selectpicker form-control empresa" id="exampleFormControlSelect1" data-show-subtext="true" data-live-search="true">
          <!-- Passar todos os valores de categória -->
         <?php while($sql =  mysqli_fetch_array($query)) {?>
            <option data-subtext="" value="<?php echo $sql['cod_empresa'] ?>"><?php echo $sql['nome_empresa']; ?></option>

            <?php } ?>
            
        </select>
        
        
        
</html>
      