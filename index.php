<?php
    
    //Incia sessão
    session_start();

    //Se já tiver logado, redireciona para página inicial
    if(isset($_SESSION["autoriza"])) header("Location: menu_sys.php");
     
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title class="text-rigth">   Login </title>
  
  <link rel="icon" href="./docs/assets/img/favic_index.png">
  
  <?php include_once './_import/link_title.php'; ?>
  
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Login </b>SYS Tema</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Digite seu usário e senha :</p>

      <form action="./_man/validaLogin.php" method="post" id="frmDados">
        <div class="input-group mb-3">
            <select class="form-control" id="empresas" name="empresas">
                <option value="1"> 1 - Humana Alimentar</option>
            </select>
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="<?php print date("Y"); ?>" id="periodo" name="periodo"onkeypress="return event.charCode >= 48 && event.charCode <= 57"/>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-calendar"></span>
              </div>
            </div>
        </div>          
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Usuário" id="user" name="user">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Senha" id="pass" name="pass">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
        </div>
        <div class="row">          
          <!-- /.col -->
          <div class="col-12">
              <button type="button" class="btn btn-primary btn-block" id="btnLogin" name="btnLogin">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

<!--      <p class="mb-1">
        <a href="forgot-password.html">Esqueci minha Senha</a>
      </p>-->
      <p class="mb-0">
        <a href="register.php" class="text-center">Registrar Novo Membro</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php include_once './_import/scripts.php'; ?>

<script src="_man/functions.js"></script>
<script type="text/javascript">
    
    $(document).ready( function(){
                
       //Função para registrar evendo no banco de dados.
       $("#btnLogin").on("click", function(){    
        login('menu_sys.php');
    
    });              
       
                          
    });
</script>
</body>
</html>
