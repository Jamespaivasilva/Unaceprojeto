

<?php

$valor = $_POST['valor2'];




// Conectar ao banco, pra que ? Para puxar todos os registros de categorias
    require_once('../classes/conexao.php');
    
    // Instanciar class Conexão
     $conexao = new Conexao();
    
    //Iniciar o metódo para conectar
     $conexao->conectar();
     
     $query = mysqli_query($conexao->conectar(),"SELECT * FROM grupos INNER JOIN juncao_grupo_empresa ON grupos.cod_grupo=juncao_grupo_empresa.cod_cad_grupo_empresa_grupo INNER JOIN empresas ON juncao_grupo_empresa.cod_cad_grupo_empresa_empresa=empresas.cod_empresa INNER JOIN membros ON empresas.cod_empresa=membros.cod_membro_empresa where cod_grupo='$valor' ");

?>





      <select name="quem" class="quem selectpicker form-control" data-show-subtext="true" data-live-search="true">
          <!-- Passar todos os valores de categória -->
          
         <?php while($sql =  mysqli_fetch_array($query)) {?>
         
            <option data-subtext="" value="<?php echo $sql['cod_membro'] ?>"><?php echo $sql['nome_membro']; ?></option>

            <?php } ?>
            
        </select>
        
        
      