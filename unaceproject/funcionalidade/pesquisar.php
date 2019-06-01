<?php


$valor = $_POST['valor'];

 require_once('../classes/conexao.php');
    
    // Instanciar class Conexão
     $conexao = new Conexao();
    
    //Iniciar o metódo para conectar
     $conexao->conectar();
    
     //Fazer a pesquisa no banco
     $query = mysqli_query($conexao->conectar(),"select * from membros where cod_membro_empresa='$valor' and papel_membro_papel='1'");

      

?>


<!DOCTYPE html>


   
</head>


                    <select class="form-control titular" name="titular" required>
                  <?php while($sql = mysqli_fetch_array($query)){ ?>
                  <option data-subtext="" value="<?php echo $sql['cod_membro']?>"><?php echo $sql['nome_membro']; ?></option>
                  <?php }?>
                  </select>





<html/>