<?php 
//    require_once('../../_man/_aux.php');
?>
<section class="content">

   <!-- INICIAMOS O MODO TELA -->
    <?php  
    if ( $_SESSION['op'] == "" ){

      $buscas = explode("&",$_SESSION["buscas"]);
      
      $filtro_busca = $where = "";
        if ( !empty($_POST['filtro_busca']) ){
            $filtro_busca = retira_caracteres($_POST['filtro_busca']);
            $where = 
            "WHERE dpto_id IS NOT NULL 
                AND ( dpto_nome      ILIKE '%{$filtro_busca}%' 
                   OR dpto_descricao ILIKE '%{$filtro_busca}%' )";
        } 
    ?>

  <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">   
            <form role="search" method="post" action="menu_sys.php">       
                <div class="row">
                    <div class="col-sm-2">                  
                        <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_cargos','insert','', 'movimentacao','','')">
                            <span class="fas fa-plus"></span>
                            Novo
                        </button>                  
                    </div>
                    <div class="col-sm-8">
                        <div class="col-sm-auto">                        
                            <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $_POST['filtro_busca'] ?>" placeholder="Busque pelo Nome, Nickname ou E-mail..."/>
                        </div>
                    </div>
                    <div class="col-sm-2">                  
                        <button type="submit" class="btn btn-info buscas" id="btnBusca">
                            <span class="fas fa-search"></span>
                            Pesquisar
                        </button>                  
                    </div>
                </div>
            </form>
            <?php      
            $_SESSION['p'] = $_GET['p'];
            #Preparamos o filtro da pesquisa
            $intPaginaAtual = ($_SESSION['p']);
            $intPaginaAtual = filter_var( $intPaginaAtual, FILTER_VALIDATE_INT );
            $intPaginaAtual = (!empty($intPaginaAtual )) ? $intPaginaAtual : 1;
            $intLimite      = 10;
            $intInicio      = ($intPaginaAtual - 1) * $intLimite;

            #buscamos os dados
            $sql = "
                SELECT  cargo_id
                    , cargo_nome             
                    , CASE 
                        WHEN cargo_ativo = 'S' THEN 'ATIVO'
                        ELSE 'INATIVO'
                      END AS cargo_ativo_desc
                FROM t_cargos  {$where} 
                ORDER BY 2
                LIMIT  {$intLimite} OFFSET {$intInicio}";
                
            $dados = $bd->Execute($sql);

            #Setamos a quantidade de itens na busca
            $qtdRows = $bd->Execute("SELECT * FROM t_cargos  {$where}");
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
                                <th width="05%" class="text-center"> #          </th>
                                <th width="10%" class="text-center">Situação    </th>
                                <th width="70%" class="text-center">Descrição   </th>
                                <th width="15%" class="text-center">Ações       </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ( $dados->RecordCount() > 0 ){ 
                                while ( !$dados->EOF ) {
                                    $alert = $dados->fields['cargo_ativo_desc'] == "ATIVO" ? "" : "alert-danger";
                                ?>
                            <tr>
                                <td class="text-left"><?= $dados->fields['cargo_id']                       ?></td>
                                <td class="text-left <?= $alert ?>"><?= $dados->fields['cargo_ativo_desc']                       ?></td>
                                <td class="text-left"><?= $dados->fields['cargo_nome']                       ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_cargos','view','<?= $dados->fields['cargo_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-info" onclick="movPage('adm_cargos','edit','<?= $dados->fields['cargo_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="movPage('adm_cargos','delete','<?= $dados->fields['cargo_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar." hidden>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                    $dados->MoveNext();                                     
                                } 
                            }else{ ?>                            
                            <tr>
                                <td colspan="6" class="text-center">Não existem dados a serem listados!!!</td>
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
                    <label><?php paginacao('', $intPaginaAtual, $intLimite, $qtdRows->RecordCount() ); ?></label>                    
                </div>
            </div>
        </div>
        <!-- /.card-footer-->
    </div>
  <!-- /.card -->
  <?php } else {

      if ( $_SESSION['id'] != "" ){
        #Monta SQL para busca
        $sql = "
            SELECT cargo_id
            , cargo_nome
            , cargo_cbo
            , cargo_ref
            , cargo_ativo
            , cargo_dt_inicio
            FROM t_cargos tc 
            WHERE cargo_id = {$_SESSION['id']}
            ORDER BY 1;";

        #Resgata os valores do Banco
        $dados = $bd->Execute($sql);
      }

       #Validamos as funcionalidades          
       if      ( $_SESSION["op"] == "view"   ){ $description = "Visualização dos "; $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "insert" ){ $description = "Insira os "; }
       else if ( $_SESSION["op"] == "delete" ){ $description = "Deletar esses ";  $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "edit"   ){ $description = "Editar os "; }
    ?>
  <div class="card body-view">
    <div class="card-header">
      <div class="row">
            <div class="col-sm-12">           
                <label><?= $description ?> Dados do Cargo</label>
            </div>
      </div>
    </div>
    <div class="card-body">
        <form action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainAdmCargos.php" method="post" id="frmDados">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#user_geral" id="aba-user-geral"  role="tab" data-toggle="tab" class="nav-link  active" >Dados Cargo</a>
                </li>     
            </ul>
            <div class="tab-content">
                <div class="tab-pane margin-top-15 active" id="user_geral" role="tabpanel">
                    <div class="row">
                        <div class="row col-sm-12">
                            <div  class="col-sm-4  mb-2">   
                                <label or="dpto_cargo_nomenome">Nome Cargo:</label>
                                <input type="text" class="form-control requeri  " id="cargo_nome" name="cargo_nome" value="<?php print $dados->fields['cargo_nome']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-4  mb-2">   
                                <label or="cargo_cbo">CBO Cargo:</label>
                                <input type="text" class="form-control requeri" id="cargo_cbo" name="cargo_cbo" value="<?php print $dados->fields['cargo_cbo']?>" <?=$disabled?>/>
                            </div>
                                                   
                            <div  class="col-sm-2  mb-2">
                                <label or="cargo_ativo">Situação:</label>
                                <select class="form-control" id="cargo_ativo" name="cargo_ativo">
                                    <option value="S" <?= $dados->fields['cargo_ativo'] == "S" ? "selected": ""?>>ATIVO   </option>
                                    <option value="N" <?= $dados->fields['cargo_ativo'] == "N" ? "selected": ""?>>INATIVO </option>
                                </select>
                            </div>
                        </div>                        
                    </div>                
                </div>                
            </div>
        </form>
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
              <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_cargos','','', 'movimentacao','','')">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>

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
        $("#checkboxes").empty();
        $.ajax({
            url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/search/_searchSelect.php",
            type: "post",
            dataType: "json",
            data: { 
                busca: "submenu_categoria_cb",
                id: $("#user_menu").val(),
            },
            success: function(retorno){
                if ( retorno.dados[0].status == "OK" ){
                    $("#checkboxes").append(retorno.dados[0].html); 
                    $(".busca_categoria").show();
                    $(".lista_sub").removeClass("escondido");
                }else{
                    $("#checkboxes").val("");
                    $("#tableItens > tbody, #checkboxes").empty();
                    $("#tableItens, .busca_categoria").hide();
                    $(".lista_sub").addClass("escondido");
                }                    
            }
        });  
    }

    function buscaTableLinha(){
        var checados = [];
            $.each($("input[name='cb_list']:checked"), function(){           
                checados.push("'"+$(this).val()+"'");
            });
        $.ajax({
            url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/search/_selectTableLinha.php",
            type: "post",
            dataType: "json",
            data: { 
                busca: "submenu",
                categoria: checados.join(","),
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
            url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/manutencao/mainAdmUser.php",
            type: "post",
            dataType: "text",
            data: { 
                exception: "update_permissoes",
                arrId: tableTd,
                id_menu: $("#user_menu").val(),
                categoria: $("#user_menu_categoria").val(),
                id_usuario: <?= $_SESSION['user_id'] ?>
            },
            success: function(retorno){
                $("#modal_success").modal("show");
                setTimeout(function(){
                    $("#modal_success").modal("hide");
                    $("#user_menu, #user_menu_categoria").val("");
                    $("#tableItens > tbody, #user_menu_categoria").empty();
                    $("#tableItens, .busca_categoria").hide();
                    $(".lista_sub").addClass("escondido");
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
            url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/rest_api/api_cep_correios.php",
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
                    url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/search/_searchData.php",
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