<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page (v2)</title>

  <?php include_once './_import/link_title.php'; ?>
  
</head>
<style>
    .box-register{
        padding-top: 20px;
    }
</style>
<body class="hold-transition register-page col-lg-12">
<div class="col-sm-8 box-register">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="#" class="h1"><b>Register usuário </b>FLow</a>
    </div>
    <div class="card-body">
        <p class="login-box-msg">Dados para registrar um <b>novo</b> membro!!! </p>

        <form action="./_man/validateNewLogin.php" method="post" id="frmDados">
            <div class="row">                
                <div class="form-group col-sm-6">
                    <label for="user_nome"> Nome Completo:</label>
                    <div class="form-group input-group mb-1">                      
                        <input type="text" class="form-control unique" placeholder="Vitor Hugo Marini" id="user_nome" name="user_nome" title="Digite seu nome completo.">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user"></span>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="user_nickname"> Usuário:</label>
                    <div class="form-group input-group mb-1">
                        <input type="text" class="form-control unique" placeholder="vhmarini" id="user_nickname" name="user_nickname" title="Confira seu Nickname.">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user-shield"></span>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="form-group col-sm-3">
                    <label for="user_dt_nascimento"> Data Nascimento:</label>
                    <div class="form-group input-group mb-1">
                        <input type="date" class="form-control" id="user_dt_nascimento" name="user_dt_nascimento" title="Data de Nascimento."/>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-calendar"></span>
                        </div>
                      </div>
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label for="user_email"> E-mail:</label>
                    <div class="form-group input-group mb-1 ">
                      <input type="text" class="form-control" placeholder="Email" id="user_email" name="user_email">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-envelope"></span>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-group col-sm-2">
                    <label for="user_celular"> Contato Celular:</label>
                    <div class="form-group input-group mb-1 ">
                        <input type="text" class="form-control" id="user_celular" name="user_celular" placeholder="18997891261" title="Insira um número de celular."    />                      
                    </div>
                </div>
                <div class="form-group col-sm-2 mb-2">
                    <label for="user_tipo"> Tipo de Usuário:</label>
                    <div class="form-group input-group mb-4 ">
                        <select class="form-control" id="user_tipo" name="user_tipo">
                            <option value="COMUM"  selected>1 - USUÁRIO SISTEMA</option>
                            <option value="ADM"    >2 - ADMINISTRADOR  </option>
                            <option value="SERVER" disabled>3 - SERVER         </option>
                        </select>                      
                    </div>
                </div>
                <div class="form-group col-sm-4">
                    <label for="user_pass"> Senha:</label>
                    <div class="form-group input-group mb-1 ">
                      <input type="password" class="form-control" placeholder="Senha" id="user_pass" name="user_pass">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          
            <p class="login-box-msg mb-2">Questionário para <b>recuperação</b> de usuário. </p>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="user_quest_1"> Pergunta 1:</label>
                    <div class="form-group input-group mb-1 ">
                        <select class="form-control" id="user_quest_1" name="user_quest_1">
                            <option value="" > Selecione </option>
                            <option value="1" >1 - Local de Nascimento          </option>
                            <option value="2" >2 - Comida Favorita              </option>
                            <option value="3" >3 - Um sonho de infância         </option>
                        </select>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-question"></span>
                        </div>
                      </div>
                    </div>                        
                </div>
                <div class="form-group col-sm-8">
                    <label for="user_resp_1"> Resposta 1:</label>
                    <div class="form-group input-group mb-1 ">
                        <input type="text" class="form-control" placeholder="Resposta 1:" id="user_resp_1" name="user_resp_1">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-question"></span>
                        </div>
                      </div>
                    </div>                        
                </div>
                <div class="form-group col-sm-4">
                    <label for="user_quest_2"> Pergunta 2:</label>
                    <div class="form-group input-group mb-1 ">
                        <select class="form-control" id="user_quest_2" name="user_quest_2">
                            <option value="" > Selecione </option>
                            <option value="1" >1 - Time Favorito                </option>
                            <option value="2" >2 - Filme da Adolecência         </option>
                            <option value="3" >3 - Nome de um familiar          </option>
                        </select>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-question"></span>
                        </div>
                      </div>
                    </div>                        
                </div>
                <div class="form-group col-sm-8">
                    <label for="user_resp_2"> Resposta 2:</label>
                    <div class="form-group input-group mb-1 ">
                        <input type="text" class="form-control" placeholder="Resposta 2:" id="user_resp_2" name="user_resp_2">
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-question"></span>
                        </div>
                      </div>
                    </div>                        
                </div>
                  <!-- /.col -->
                <div class="form-group col-sm-12">
                    <div class="form-group col-sm-4">
                        <div class="icheck-primary">
                          <input type="checkbox" id="agreeTerms" name="terms" value="agree" >
                          <label for="agreeTerms"> Eu aceito os <a href="./pages/_report/" target="blank">Termos de Uso</a> </label>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <button type="button" class="btn btn-primary btn-block" id="btnRegister" disabled >Register</button>
                    </div>
                </div>

            </div>
        </form>

        <a href="index.php" class="text-center">Já é registrado, faça login.</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
    
<?php include_once './_import/modals.php'; ?>     
    
<!-- /.register-box -->

<?php include_once './_import/scripts.php'; ?>

<script src="_man/functions.js"></script>
<script type="text/javascript">
    
    $(document).ready( function(){
        
        var agree = true;
        
       //VALIDANDO O BOTÃO DE REGISTRO
       $("#agreeTerms").on("click",function(){
           agree = (agree ? false : true);
           
           $("#btnRegister").prop("disabled",agree);
       })
       
       //Funçção que calcula o NickName
       $("#user_nome").on("change", function(){
          var nome = $(this).val();
          var arrN = nome.split(" ");
          var nick = "";
          var limit = ( arrN.length - 1);
                              
          for (  var x = 0; x <= limit ; x ++){              
              nick = nick + ( limit == x ? nome.split(" ")[x] : nome.split(" ")[x].substr(0,1));
          }
          
          $("#user_nickname").val(nick);                            
          
       });
       
       //Função para registrar evendo no banco de dados.
       $("#btnRegister").on("click", function(){  salvar('index.php'); });              
       
       //Função que valida os dados inseridos no banco de dados.
       $(".unique").on("change", function(){
           var v1   = "t_user";
           var v2   = $(this).prop("name");
           var v3   = "=";
           var v4   = $(this).val();
           var v    = "duplicate";
           
           validaData(v1, v2, v3, v4, v);
       });
                          
    });
    
</script>
</body>
</html>
