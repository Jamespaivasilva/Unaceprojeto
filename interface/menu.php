<?php
   //iniciar sessão para verificar o nível de acesso do usuário
       
       //verificar o nível de acesso 1 é normal, 2 é administrador
       $nivel = $_SESSION['nivel'];
   
   ?>
<head>
   <link rel="stylesheet" href="../css/menu.css" />
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light menu2">
   <a class="navbar-brand" href="inicio.php"><img style="max-width:70px" src="images/logo.png"/></a>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
         <li class="nav-item cor5">
            <a class="nav-link cor5" href="inicio.php"><span class="cor5">Ínicio</span><span class="sr-only">(current)</span></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="#"></a>
         </li>
         <li class="nav-item dropdown cor2">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="cor5">
            Cadastrar</span>
            </a>
            <div class="dropdown-menu cormenu" aria-labelledby="navbarDropdown">
               <?php if($nivel==2){ ?>
               <a class="dropdown-item" href="membro.php">Membro</a>
               <a class="dropdown-item" href="empresa.php">Empresa</a>
               <a class="dropdown-item" href="categoria.php">Categoria</a>
               <a class="dropdown-item" href="grupo.php">Grupo</a>
               <div class="dropdown-divider"></div>
               <?php } ?>
               <a class="dropdown-item" href="caracara.php">Cara-a-Cara</a>
               <a class="dropdown-item" href="referencia.php">Referência qualificada</a>
               <a class="dropdown-item" href="negocio.php">Negócio fechado</a>
               <a class="dropdown-item" href="convidado.php">Convidado</a>
            </div>
         </li>
         <?php if($nivel==2){?>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="cor5">Adicionar</span>
            </a>
            
            <div class="dropdown-menu cormenu" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="reuniao.php">Reunião</a>
               <a class="dropdown-item" href="empresagrupo.php">Empresa a grupo</a>
               <a class="dropdown-item" href="disponibilidade.php">Disponibilidade</a>
               <!-- <a class="dropdown-item" href="empresa.php"></a>-->
               <!-- <a class="dropdown-item" href="grupo.php">Grupo</a>-->
               <!-- <div class="dropdown-divider"></div>-->
               <!--  <a class="dropdown-item" href="caracara.php">Cara-a-Cara</a>-->
            </div>
           
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="cor5">Gerenciar</span>
            </a>
            
            <div class="dropdown-menu cormenu" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="listareuniao.php">Lista de presença</a>
               <a class="dropdown-item" href="gerenciarmembros.php">Membro</a>
               <a class="dropdown-item" href="gerenciarempresas.php">Empresa</a>
               <a class="dropdown-item" href="gerenciarcategorias.php">Categoria</a>
               <a class="dropdown-item" href="gerenciargrupos.php">Grupo</a>
            </div>
            <?php } ?>
         </li>
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="cor5">Analytics</span>
            </a>
            <div class="dropdown-menu cormenu" aria-labelledby="navbarDropdown">
               <a class="dropdown-item" href="contribuicoes.php">Contribuições</a>
            </div>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="minhaconta.php"><span class="cor5">Minha conta</span></a>
         </li>
         <li class="nav-item">
            <a class="nav-link" href="../funcionalidade/sair.php"><span class="cor5">Sair</span></a>
         </li>
      </ul>
   </div>
</nav>