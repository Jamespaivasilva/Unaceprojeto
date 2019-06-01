<?php
   //verificar se o usuário tem uma sessão, se sim, eliminar-la.
   include("../classes/destruir.php");
   $destruir = new Destruir();
   $destruir->avaliar();
   
   ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <title>Acesso</title>
   <link rel="shortcut icon" href="images/logo.png" type="image/x-icon" />
   <!-- ZOOM na página -->
   <meta name="viewport" content="width=device-width initial-scale=1">

   <!-- CSS -->
   <link rel="stylesheet" href="../css/login2.css">
   <link rel="stylesheet" href="../css/parsley.css">
   
   <!-- CSS do Bootstrap -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  
   
 
</head>

<body>
    
   <div class="container-fluid text-center">
   <div class="row">
   </div>
   <div class="row">
   </div>
   <div class="row">
   </div>
   <div class="row">
      <div class="col-md-2">
      </div>
      <div class="col-md-2"></div>
      <div class="col-md-4">
         <!-- imagem do login -->
         <img class="imagem2" src="images/unace.png" />  
      </div>
   </div>
   <br/>
   <div class="form-group">
      <form name="logar" class="logar" method="POST" action="../funcionalidade/conduzir.php" data-parsley-validate="">
         <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
               <!-- Mostrar se a senha está incorreta ou não-->
               <?php if(isset($_GET['resultado'])){if($_GET['resultado']=="senha"){echo'<div class="alert alert-danger" role="alert">Usuário ou senha incorreto!</div><br/>';}else if($_GET['resultado']=="vencido"){echo'<div class="alert alert-danger" role="alert">Cadastro vencido!</div><br/>';}else if($_GET['resultado']=="bloqueado"){echo'<div class="alert alert-danger" role="alert">Cadastro bloqueado!</div><br/>';}} ?>
              
               <input type="text" name="email" class="email form-control" placeholder="Usuário" required/>
               
            </div>
         </div>
         <br/>
         <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="form-group">
               <input type="password" name="senha" class="senha form-control" placeholder="Senha" required/>
               </div>
               <div class="form-group">
                   <div class="float-left"><input type="checkbox" class="verSenha" name="mostrar"> Ver senha</div>
                </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <br>
              <div class="form-group">
               <button class="text-center btn btn-success entrar  w-50" type="submit">Entrar</button>
               </div>
            </div>
         </div>
         <br/><br/>
         <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
               
            </div>
         </div>
      </form>
   </div>
   

 <!-- Jquery -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <!-- Script-->
   <script src="../scripts/parsley.js"></script>
   <!--Bootstrap Script -->
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   
   
   <script>
       
       $(document).ready(function(){
        $(".verSenha").change(function() {
            if(this.checked) {
               $(".senha").attr("type", "text");       
            }else{
              $(".senha").attr("type", "password");         
            }
            
            });
           
       });
       
       
   </script>
</body>
</html>