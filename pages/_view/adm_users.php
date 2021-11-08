<!-- Main content -->
<section class="content">

   <!-- INICIAMOS O MODO TELA -->
    <?php  if ( $_SESSION['op'] == "" ){

      $buscas = explode("&",$_SESSION["buscas"]);
      $filtro_busca = $where = "";
      if ( count($buscas) > 0 ){
          $where = 
          "WHERE user_id IS NOT NULL 
             AND ( user_nome ILIKE '%".explode("=", $buscas[0])[1]."%' 
                OR user_nickname       ILIKE '%".explode("=", $buscas[0])[1]."%' 
                OR user_email       ILIKE '%".explode("=", $buscas[0])[1]."%' )";

          $filtro_busca = explode("=", $buscas[0])[1];

      } 
    ?>

  <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">          
            <div class="row">
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_users','insert','', 'movimentacao','','')">
                        <span class="fas fa-plus"></span>
                        Novo Item
                    </button>                  
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-auto">                        
                        <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $filtro_busca?>" placeholder="Busque pelo Nome, Nickname ou E-mail..."/>
                    </div>
                </div>
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-info buscas" id="btnBusca" onclick="movPage('adm_users','','', 'movimentacao','','')">
                        <span class="fas fa-search"></span>
                        Pesquisar
                    </button>                  
                </div>
            </div>
            <?php      
            #Preparamos o filtro da pesquisa
            $intPaginaAtual = ( $_SESSION['p'] );
            $intPaginaAtual = filter_var( $intPaginaAtual, FILTER_VALIDATE_INT );
            $intLimite      = 10;
            $intInicio      = ( $intPaginaAtual != '' ? ( ( $intPaginaAtual - 1 ) * $intLimite ) : 0 );                                   

            #buscamos os dados
            $sql = "SELECT  user_id     , user_nome             , user_nickname
                        ,   user_email  , user_dt_nascimento    , user_tipo
                        ,   user_quest_1, user_quest_2          , user_resp_1
                        ,   user_resp_2 , user_celular,terms
                       FROM t_user  {$where} ORDER BY 2;";


            $dados = $bd->Execute($sql);


            #Setamos a quantidade de itens na busca
            $qtdRows        = $dados->RecordCount();
           ?>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="09%">                </th>
                                <th width="15%">Usuário         </th>
                                <th width="26%">Nome            </th>
                                <th width="13%">Dt Nascimento   </th>
                                <th width="22%">E-mail          </th>
                                <th width="15%" class="text-center">Ações           </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ( $dados->RecordCount() > 0 ){ 
                                while ( !$dados->EOF ) { ?>
                            <tr>
                                <td class="text-center"><img src="dist/img/user_<?=$dados->fields['user_id']?>.jpg" class="img-circle elevation-2" alt="No Image" style="width: 40px; height: 40px;"></td>
                                <td class="text-left"><?= $dados->fields['user_nickname']                       ?></td>
                                <td class="text-left"><?= $dados->fields['user_nome']                           ?></td>
                                <td class="text-left"><?= dataBrasil($dados->fields['user_dt_nascimento'])      ?></td>
                                <td class="text-left"><?= $dados->fields['user_email']                          ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_users','view','<?= $dados->fields['user_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-info" onclick="movPage('adm_users','edit','<?= $dados->fields['user_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="movPage('adm_users','delete','<?= $dados->fields['user_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar." hidden>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                    $dados->MoveNext();                                     
                                } 
                            }else{ ?>                            
                            <tr>
                                <td colspan="4" class="text-center">Não existem dados a serem listados!!!</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer  align-content-center">
            <div class="row text-center fix-center">
                <div class="col-sm-12 text-center align-items-center">   
                    <label><?php paginacao( 'menu_sys.php', $intPaginaAtual, $intLimite, $qtdRows ); ?></label>                    
                </div>
            </div>
        </div>
        <!-- /.card-footer-->
    </div>
  <!-- /.card -->
  <?php } else {

      if ( $_SESSION['id'] != "" ){
        #Monta SQL para busca
        $sql = "SELECT  user_id     , user_nome             , user_nickname
                    ,   user_email  , user_dt_nascimento    , user_tipo
                    ,   user_celular
                   FROM t_user 
                  WHERE user_id = '{$_SESSION['id']}';";



        #Resgata os valores do Banco
        $dados = $bd->Execute($sql);

        //Verificando se a empresa matriz está vinculada
        $descricaoEmpresaMatriz = $dados->fields['empresa_matriz_id'] !== "" ? formataCpfCnpj($dados->fields['empresa_cnpj_matriz'],$dados->fields['empresa_tipo_pessoa_matriz'])." - ".$dados->fields['empresa_razao_social_matriz'] : "";
      }

       #Validamos as funcionalidades          
       if      ( $_SESSION["op"] == "view"   ){ $description = "Visualização dos "; $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "insert" ){ $description = "Insira os "; }
       else if ( $_SESSION["op"] == "delete" ){ $description = "Deletar esses ";  $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "edit"   ){ $description = "Editar os "; }

       #Resgatando os Menus
       $dataMenu = $bd->Execute($sql = "SELECT menu_descricao ,	menu_id  FROM t_menu ORDER BY 1;");
      ?>
  <div class="card body-view">
    <div class="card-header">
      <div class="row">
            <div class="col-sm-12">           
                <label><?= $description ?> Dados do Usuário</label>
            </div>
      </div>
    </div>
    <div class="card-body">
        <form action="<?= $_SERVER['localhost']?>/sys/_man/manutencao/mainAdmUser.php" method="post" id="frmDados">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#user_geral" id="aba-user-geral"  role="tab" data-toggle="tab" class="nav-link active" >Dados Usuário</a>
                </li>   
                <li class="nav-item">
                    <a href="#user_permissao" id="aba-user-permissoes"  role="tab" data-toggle="tab" class="nav-link " >Permissões de Acesso</a>
                </li>   
            </ul>

            <div class="tab-content">
                <div class="tab-pane active margin-top-15" id="user_geral" role="tabpanel">
                    <div class="row">
                        <div class="row col-sm-12">
                            <div  class="col-sm-4  mb-2">
                                <label or="user_nome">Nome Usuário:</label>
                                <input type="text" class="form-control requeri unique" id="user_nome" name="user_nome" value="<?php print $dados->fields['user_nome']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2  mb-2">
                                <label for="user_nickname">Nickname:</label>
                                <input type="text" class="form-control requeri unique" id="user_nickname" name="user_nickname" value="<?php print $dados->fields['user_nickname']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-1  mb-2">
                                <label for="user_dt_nascimento">Dt Nascimento:</label>
                                <input type="date" class="form-control requeri" id="user_dt_nascimento" name="user_dt_nascimento" value="<?php print $dados->fields['user_dt_nascimento']?>" <?=$disabled?>/>
                            </div>
                            <div class="col-sm-2 mb-2">
                                <label for="user_tipo"> Tipo de Usuário:</label>
                                <div class="form-group input-group  ">
                                    <select class="form-control" id="user_tipo" name="user_tipo">
                                        <option value="COMUM"  <?php print $dados->fields['user_tipo'] == "COMUM"   ? "selected" : "" ?>>1 - USUÁRIO SISTEMA</option>
                                        <option value="ADM"    <?php print $dados->fields['user_tipo'] == "ADM"     ? "selected" : "" ?>>2 - ADMINISTRADOR  </option>
                                        <option value="SERVER" <?php print $dados->fields['user_tipo'] == "SERVER"  ? "selected" : "" ?>>3 - SERVER         </option>
                                    </select>                      
                                </div>
                            </div>
                            <div  class="col-sm-2  mb-2">
                                <label for="user_email">E-mail:</label>
                                <input type="text" class="form-control requeri" id="user_email" name="user_email" value="<?php print $dados->fields['user_email']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-1  mb-2">
                                <label for="user_celular">Celular:</label>
                                <input type="text" class="form-control requeri" id="user_celular" name="user_celular" value="<?php print $dados->fields['user_celular']?>" <?=$disabled?>/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane  margin-top-15" id="user_permissao" role="tabpanel">
                    <div class="row mb-2">
                        <div class="col-sm-12 row">

                            <div  class="col-sm-2 form-group">
                                <label for="user_menu">Selecione o Menu:</label>
                                <select class="form-control" id="user_menu" name="user_menu">
                                    <option value="">Selecione</option>
                                <?php
                                while ( !$dataMenu->EOF ){ ?>
                                    <option value="<?php print $dataMenu->fields['menu_id'] ?>" ><?php print $dataMenu->fields['menu_descricao'] ?>         </option>                                        
                                <?php
                                    $dataMenu->MoveNext();
                                }?>
                                </select>
                            </div>                                                                

                            <div  class="col-sm-2 form-group busca_categoria">
                                <label for="user_menu_categoria">Selecione a Categoria:</label>
                                <select class="form-control" id="user_menu_categoria" name="user_menu_categoria"></select>
                            </div>     

                            <div class="col-sm-4 busca_categoria" style="padding-top: 27.5px;" >                  
                                <button type="button" class="btn btn-info form-control" id="btnBuscar" style="width: 100%;" >
                                    <span class="fas fa-search"></span>
                                    Buscar Itens
                                </button>                  
                            </div>
                            <div class="col-sm-4 busca_categoria" style="padding-top: 27.5px;" >                  
                                <button type="button" class="btn btn-danger form-control" id="btnAtualizaPermissoes" style="width: 100%;" >
                                    <span class="fas fa-upload"></span> 
                                    Atualizar Permissões
                                </button>                  
                            </div>

                        </div>
                        <div class="col-sm-4 row text-center col-sm-auto" >

                            <table class="table" id="tableItens">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="10%">#</th>
                                        <th class="text-left"   width="90%">SubMenu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>


                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row col-sm-12 profile">
        <div  class="col-sm-2  mb-2">
            <label for="user_photo">Foto de Perfil (JPG):</label>
            <form method="POST" action="<?= $_SERVER["localhost"] ?>/sys/_man/manutencao/upload_imagem.php" enctype="multipart/form-data">
                <input  class="form-group" id="arquivo" name="arquivo" type="file" >
                <input  class="form-group" type="submit" value="Upload" >
            </form>
        </div>
        <?php
        if (file_exists("dist/img/user_{$dados->fields['user_id']}.jpg") ){ ?>
            <div  class="col-sm-1  mb-2">
                <div class="image" >
                    <img src="dist/img/user_<?=$dados->fields['user_id']?>.jpg" class="img-circle elevation-2" alt="Sem Imagem" style="width: 140px; height: 140px;">
                </div>
            </div>            
            <div  class="col-sm-2  mb-2 ">
                <form method="POST" action="<?= $_SERVER["localhost"] ?>/sys/_man/manutencao/drop_imagem.php">
                    <input  class="form-group text-danger" type="submit" value="Remover Imagem" >
                </form>
            </div>
        <?php } ?>
    </div>
    <!-- /.card-body -->
    <div class="card-footer  align-content-center">
        <div class="row">          
            <?php if ( $_SESSION['op'] == "insert" || $_SESSION['op'] == "edit" ){ ?>
            <div class="col-sm-2 ">                  
              <button type="button" class="btn btn-primary form-control" id="btnSalvar">
                  <span class="fas fa-save"></span>
                  Salvar
              </button>                  
           </div>
            <?php } ?>
            <?php if ( $_SESSION['op'] == "delete" ){ ?>
                <div class="col-sm-2 ">                  
                  <button type="button" class="btn btn-danger form-control" id="btnExcluir">
                      <span class="fas fa-trash"></span>
                      Excluir
                  </button>                  
               </div>
            <?php } ?>                    
            <div class="col-sm-2 ">                  
              <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_users','','', 'movimentacao','','')">
                  <span class="fas fa-retweet"></span>
                  Voltar
              </button>                  
           </div> 
      </div>
    </div>
    <!-- /.card-footer-->
  </div>  

  <?php } ?>




</section>
<?php include_once '../../_import/modals.php'; ?>
<?php include_once "../../_man/search/_searchData.php"; ?>
<script type="text/javascript">
    
$(document).ready(function($){
    var tableTd = "";

    //Máscaras e validações        
    $("#tableItens, .busca_categoria, #btnNovo").hide();

    $("#user_menu").on("change", function(){ buscaSelect(); });
    $("#btnBuscar").on("click", function(){ buscaTableLinha(); });

    $("#aba-user-geral").on("click",function(){ $("#btnSalvar, #btnExcluir, #btnVoltar, .profile").show(); });
    $("#aba-user-permissoes").on("click",function(){ $("#btnSalvar, #btnExcluir, #btnVoltar, .profile").hide(); });

    $("#btnAtualizaPermissoes").on("click",function(){
        tableTd = "";
       $("#tableItens > tbody > tr").each(function (el){
           var retorno = $(this).find('input[name^=id_]:checkbox:checked').prop("name");

           //Verificamos se está setado somente o item desejado
            if ( retorno !== undefined ){
                if ( tableTd == "" ){
                    tableTd = retorno.split("_")[1];                    
                }else{
                    tableTd = tableTd + "," + retorno.split("_")[1];
                }
            }
       });

       refeshPermissao();
    });

    function buscaSelect(){
        $.ajax({
            url: "<?= $_SERVER["localhost"] ?>/sys/_man/search/_searchSelect.php",
            type: "post",
            dataType: "json",
            data: { 
                busca: "submenu_categoria",
                id: $("#user_menu").val(),
            },
            success: function(retorno){
                if ( retorno.dados[0].status == "OK" ){
                    $("#user_menu_categoria").append(retorno.dados[0].html); 
                    $(".busca_categoria").show();
                }else{
                    $("#user_menu_categoria").val("");
                    $("#tableItens > tbody, #user_menu_categoria").empty();
                    $("#tableItens, .busca_categoria").hide();
                }                    
            }
        });  
    }

    function buscaTableLinha(){
        $.ajax({
            url: "<?= $_SERVER["localhost"] ?>/sys/_man/search/_selectTableLinha.php",
            type: "post",
            dataType: "json",
            data: { 
                busca: "submenu",
                categoria: $("#user_menu_categoria").val(),
                menu_id: $("#user_menu").val()
            },
            success: function(retorno){
                if ( retorno.dados[0].status == "OK" ){
                    $("#tableItens > tbody").empty();
                    $("#tableItens > tbody").append(retorno.dados[0].html); 
                    $("#tableItens").show();
                }
            }
        });  
    }

    function refeshPermissao(){                
        $.ajax({
            url: "<?= $_SERVER["localhost"] ?>/sys/_man/manutencao/mainAdmUser.php",
            type: "post",
            dataType: "text",
            data: { 
                exception: "update_permissoes",
                arrId: tableTd,
                id_menu: $("#user_menu").val(),
                categoria: $("#user_menu_categoria").val(),
                id_usuario: <?= $_SESSION['id'] ?>
            },
            success: function(retorno){
                $("#modal_success").modal("show");
                setTimeout(function(){
                    $("#modal_success").modal("hide");
                    $("#user_menu, #user_menu_categoria").val("");
                    $("#tableItens > tbody, #user_menu_categoria").empty();
                    $("#tableItens, .busca_categoria").hide();
                }, 500);                   
            }
        });  
    }


   //Função que valida os dados inseridos no banco de dados.
   $(".unique").on("change", function(){
       var v1   = "t_empresas";
       var v2   = $(this).prop("name");
       var v3   = "=";
       var v4   = $(this).val();
       var v    = "duplicate";

       validaData(v1, v2, v3, v4, v);
   });

   $("#empresa_cep").on("change",function(){
       $(".cep").prop("disabled",true);

        $.ajax({
            url: "<?= $_SERVER["localhost"] ?>/sys/_man/rest_api/api_cep_correios.php",
            type: "post",
            dataType: "json",
            data: { 
                cep: $(this).val()
            },
            success: function(retorno){

                $(".cep").prop("disabled", false);
                $("#empresa_uf").val(retorno.dados.estado);
                $("#empresa_codigo_municipio_descricao").val(retorno.dados.cod_cidade + " - " + retorno.dados.cidade);
                $("#empresa_codigo_municipio").val(retorno.dados.cod_cidade);
            }
        }); 
   });


    $(".search").on("keypress", function(){
       var table = $(this).prop("name");

       $(".search").autocomplete({                        
            source: function( request, response){
                $.ajax({
                    url: "<?= $_SERVER["localhost"] ?>/sys/_man/search/_searchData.php",
                    type: "post",
                    dataType: "json",
                    data: { 
                        descricao: request.term,
                        table: table,
                        tipo: "empresa_matriz"
                    },
                    success: function(data){
                        response($.map(data.dados, function(item){
                            return {
                                id    : item.ret_1,
                                value : item.ret_2
                            };
                        }));
                    }
                });
            },
            minLength: 2,
            select: function(event, ui){
                $('#empresa_matriz_id').val(ui.item.id);
            },
            open: function() {
                $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
            },
            close: function() {
                $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
            }
        });

    });

});
</script>

  <!-- /.content-wrapper -->