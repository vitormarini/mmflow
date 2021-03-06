<?php
    
    //Incia sessão
    session_start();

    //Se já tiver logado, redireciona para página inicial
    if(isset($_SESSION["autoriza"])) header("Location: menu_sys.php");

    #Teste da XIOVANNANANANAN
     
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
    <a href="#"><b>Flow </b> Gestão</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Digite os dados de acesso :</p>

      <form action="./_man/validaLogin.php" method="post" id="frmDados">
        <input type="hidden" id="empresas" name="empresas">
        <input type="hidden" id="empresas_desc" name="empresas_desc">

        <div class="input-group mb-3">
            <select class="form-control"id="tipo_login" name="tipo_login">
              <option value="1">Usuário e Senha</option>
              <option value="2">E-mail</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                Forma de Acesso
              </div>
            </div>
        </div>          
        <div class="input-group mb-3">
        <select class="form-control"id="periodo" name="periodo">
            <?php
              $ano       = 2022;
              $anoFiscal = date("Y");

              while ( $anoFiscal >= $ano ){

                print '<option value="'.$anoFiscal.'">'.$anoFiscal.'</option>';

                $anoFiscal --;

              }
            ?>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-calendar"> Ano Exercício</span>
              </div>
            </div>
        </div>          
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="CNPJ" id="cnpj" name="cnpj" onkeypress="maskcpfcnpj(this, mcpfcnpj);" onblur="maskcpfcnpj(this, mcpfcnpj);" value="02.786.436/0001-83" required readonly>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="far fa-address-card"></span>
              </div>
            </div>
        </div>
        <div class="input-group mb-3 login_2">
            <input type="email" class="form-control" placeholder="E-mail" id="email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
        </div>
        <div class="input-group mb-3 login_1">
            <input type="text" class="form-control" placeholder="Usuário" id="user" name="user" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Senha" id="pass" name="pass" required>
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
      <!-- <p class="mb-0">
        <a href="register.php" class="text-center">Registrar Novo Membro</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<!-- /.login-box -->
<?php include_once './_import/scripts.php'; 
      include_once './_import/modals.php'; 
?>

<script src="_man/functions.js"></script>
<script type="text/javascript">
    
$(document).ready( function(){

    //Movimentação do tipo do login
    $("#tipo_login").on("change",function(){
      tipoLogin();
    });

    //Chamada da Função ao iniciar o Objeto
    tipoLogin();

    //Função para movimentação.
    function tipoLogin(){
      var tipo = $("#tipo_login").val();

      $(".login_2, .login_1").show();

      if(tipo == "1"){
        $(".login_2").hide();
      }else{
        $(".login_1").hide();
      }
    }
            
    //Função para registrar evendo no banco de dados.
    $("#btnLogin").on("click", function(){  
        
        if($("#cnpj").val() != "" && $("#user").val() != "" && $("#pass").val() != ""){
           login('menu_sys.php');
        }else{
            alert("Formulário invalido!");
        }
    });              
    
    $("#btnContinuar").on("click",function(){
        selecionaEmpresa("login");        
    });
});
</script>
</body>
</html>
