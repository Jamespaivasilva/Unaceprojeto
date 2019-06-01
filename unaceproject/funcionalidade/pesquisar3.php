<?php
 
 $endereco = $_POST['valor'];

// Conectar ao banco, pra que ? Para puxar todos os registros de categorias
    require_once('../classes/conexao.php');
    
    //usar o método verificar dia da semana
    require_once('../classes/disponibilidade.php');
    
    // Instanciar class Conexão
     $conexao = new Conexao();
    
    //Iniciar o metódo para conectar
     $conexao->conectar();
    
     //Fazer a pesquisa no banco
     
     $query3 = mysqli_query($conexao->conectar(),"SELECT * FROM disponibilidade where cod_endereco='$endereco' and cod_disp_reuniao='0'");


    $disponibilidade = new Disponibilidade();
    
    

?>

        <select name="disponibilidade" class="form-control disponibilidade" id="exampleFormControlSelect1" required>
          <!-- Passar todos os valores de categória -->
         <?php while($valor =  mysqli_fetch_array($query3)) { ?>
            <option value="<?php echo $valor['cod_disponibilidade'] ?>"><?php echo date('d/m/Y', strtotime($valor['data_disponibilidade'])) ."  |  ".$disponibilidade->semana($valor['data_disponibilidade'])." | ".$valor['hora_inicial']." às ".$valor['hora_final']; ?></option>
           
            <?php } ?>
            
        </select>
        
        
    