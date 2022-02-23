<style>
    .inputfile { width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute;  z-index: -1; }
    
  

    .inputfile:focus + label,
    .inputfile.has-focus + label {
        outline: 1px dotted #000;
        outline: -webkit-focus-ring-color auto 5px;
    }
    
    #arquivo_pfx:focus + label,
    #arquivo_pfx.has-focus + label,
    label[for='arquivo_fci']:hover {
        background-color: #449d44;
    } 
    .backgroundDescricao{
        background-color: #F2F2F2;
        border-radius: 10px;
    }
    
    #envio_arquivo      { margin-top: 20px;      }
    #insercao_manual    { font-size: 12px;       } 
</style>
<link rel="stylesheet" type="text/css" href="./DataTables/datatables.min.css"/>
<!-- Main content -->
<section class="content">
    
   <!-- INICIAMOS O MODO TELA -->
    <?php  if ( $_SESSION['op'] == "" ){  

        $filtro_busca = $where = "";
        if ( !empty($_POST['filtro_busca']) ){
            $filtro_busca = retira_caracteres($_POST['filtro_busca']);
            $where = 
            "WHERE empresa_id IS NOT NULL 
               AND ( empresa_cnpj           ILIKE '%{$filtro_busca}%' 
                  OR empresa_razao_social   ILIKE '%{$filtro_busca}%' )";            
        } 
    ?>
  <!-- Default box -->
  <div class="card body-view">
    <div class="card-header">  
        <form role="search" method="post" action="menu_sys.php">
            <div class="row">
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_chamados','insert','', 'movimentacao','','')">
                    <span class="fas fa-plus"></span>
                    Novo Item
                </button>                  
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-12">                        
                        <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $_POST['filtro_busca'] ?>" placeholder="Busque pela Razão Social o CNPJ..."/>
                    </div>
                </div>
                <div class="col-sm-2">                  
                <button type="submit" class="btn btn-info">
                    <span class="fas fa-search"></span>
                    Pesquisar
                </button>                  
                </div>
            </div>
        </form>
       <?php      
        #Preparamos o filtro da pesquisa
        $intPaginaAtual = ( $_SESSION['p'] );
        $intPaginaAtual = filter_var( $intPaginaAtual, FILTER_VALIDATE_INT );
        $intLimite      = 10;
        $intInicio      = ( $intPaginaAtual != '' ? ( ( $intPaginaAtual - 1 ) * $intLimite ) : 0 );                                   

        #buscamos os dados
        $sql = "SELECT 	empresa_tipo                            ,	empresa_tipo_pessoa 
                    ,	empresa_cnpj                            ,	empresa_razao_social 
                    ,	empresa_ie                              ,	empresa_cep 
                    ,	empresa_uf                              ,       empresa_nome_fantasia
                    ,   empresa_id
                FROM    t_empresas {$where} 
                ORDER BY empresa_cnpj;";

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
    <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped" id="table_lista_notas">
                    <thead>
                        <tr>                            
                            <th class="text-center" width="5%" >Status          </th>                            
                            <th class="text-center" width="5%" >ID             </th>                            
                            <th class="text-center" width="15%">Usuário         </th>                            
                            <th class="text-center" width="15%">Responsável     </th>
                            <th class="text-center" width="20%">Detalhe         </th>
                            <th class="text-center" width="10%">Tipo            </th>
                            <th class="text-center" width="10%">Dt Abertura     </th>
                            <th class="text-center" width="10%">Dt Conclusão    </th>
                            <th class="text-center" width="10%" colspan="2" >Opções          </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            for ( $x=0; $x <= 50; $x++ ){
                                ?>
                                <tr>
                                    <td class="text-center">
                                        <span class="fas fa-tags"></span>
                                        <span class="fas fa-save"></span>
                                    </td>
                                    <td> #1323  </td>                                    
                                    <td> Vitor Hugo  </td>                                    
                                    <td> Cristiano </td>
                                    <td> Solicitação de Migração de Servidor </td>
                                    <td> Chamado </td>
                                    <td> 10/02/2022 </td>
                                    <td></td>                          
                                    <td class="text-center">
                                        <button class="btn btn-success" onclick="movPage('adm_chamados','view','<?= $dados->fields['empresa_id'] ?>', 'movimentacao','','')" title="Clique para visualizar mais.">
                                            <span class="fas fa-search openDetalhes"></span>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-info" onclick="movPage('adm_chamados','edit','<?= $dados->fields['empresa_id'] ?>', 'movimentacao','','')" title="Encerrar o chamado.">
                                            <span class="far fa-paper-plane"></span>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }                            
                        ?>
                        
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
        $sql = "SELECT 
                    t_empresas.empresa_tipo	, t_empresas.empresa_razao_social          , t_empresas.empresa_nome_fantasia         , t_empresas.empresa_cnpj          , t_empresas.empresa_uf    , t_empresas.empresa_ie            , t_empresas.empresa_codigo_municipio
                ,   t_empresas.empresa_im	, t_empresas.empresa_matriz                , t_empresas.empresa_situacao              , t_empresas.empresa_logradouro    , t_empresas.empresa_numero, t_empresas.empresa_complemento   , t_empresas.empresa_bairro		
                ,   t_empresas.empresa_cep  , t_empresas.empresa_telefone_principal    , t_empresas.empresa_telefone_secundario   , t_empresas.empresa_email         , t_empresas.empresa_nire  , t_empresas.empresa_tipo_pessoa   
                ,   matriz.empresa_id           AS empresa_matriz_id
                ,   matriz.empresa_cnpj         AS empresa_cnpj_matriz
                ,   matriz.empresa_tipo_pessoa  AS empresa_tipo_pessoa_matriz
                ,   matriz.empresa_razao_social AS empresa_razao_social_matriz
            FROM    public.t_empresas 
       LEFT JOIN    t_empresas AS  matriz ON ( matriz.empresa_id = t_empresas.empresa_matriz::int AND t_empresas.empresa_tipo = 'FILIAL' )
           WHERE    t_empresas.empresa_id = '{$_SESSION['id']}';";



        #Resgata os valores do Banco
        $dados = $bd->Execute($sql);

        //Verificando se a empresa matriz está vinculada
        $descricaoEmpresaMatriz = $dados->fields['empresa_matriz_id'] !== "" ? formataCpfCnpj($dados->fields['empresa_cnpj_matriz'],$dados->fields['empresa_tipo_pessoa_matriz'])." - ".$dados->fields['empresa_razao_social_matriz'] : "";
      }

       #Validamos as funcionalidades          

       if      ( $_SESSION["op"] == "view"   ){ $description = "Visualização dos "; $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "insert" ){ $description = "Enviar uma Solicitação "; }
       else if ( $_SESSION["op"] == "delete" ){ $description = "Deletar esses ";  $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "edit"   ){ $description = "Editar os "; }

      ?>

  <div class="card body-view">
    <div class="card-header">          

      <div class="row">

            <div class="col-sm-12">           
                <label><?= $description ?></label>
           </div>

      </div>

    </div>
    <div class="card-body">
        <form action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainAdmChamados.php" method="post" id="frmDados">
            <div class="tab-content">
                <div class="tab-pane active margin-top-15" id="empresa_geral" role="tabpanel">
                    <div class="row">
                        <?php
                        if ( $_SESSION["op"] == "insert" ){?>
                        <div class="row col-sm-8"> 
                            <div  class="col-sm-6 form-group">
                                <label for="chamado_tipo" >Tipo:</label>
                                <select class="form-control requeri" id="chamado_tipo" name="chamado_tipo" <?=$disabled?>>
                                    <option value="CHAMADO"    <?php print $dados->fields['chamado_tipo'] == "CHAMADO"    ? "selected" : ""  ?>>1 - Chamado</option>
                                    <option value="REQUISICAO" <?php print $dados->fields['chamado_tipo'] == "REQUISICAO" ? "selected" : ""  ?>>2 - Requisição</option>
                                </select>
                            </div>                           
                            <div  class="col-sm-6 form-group">
                                <label for="chamado_departamento" >Para o Departamento de :</label>
                                <select class="form-control requeri" id="chamado_departamento" name="chamado_departamento" <?=$disabled?>>
                                    <option value="TI"    <?php print $dados->fields['chamado_tipo'] == "TI"    ? "selected" : ""  ?>>1 - T.I.</option>
                                    <option value="RH" <?php print $dados->fields['chamado_tipo'] == "TH" ? "selected" : ""  ?>>2 - RH</option>
                                </select>
                            </div>                           
                            <div  class="col-sm-12  mb-2">
                                <label for="chamado_responsavel">Responsável:</label>
                                <input type="text" class="form-control requeri " id="chamado_responsavel" name="chamado_responsavel" value="<?php print $dados->fields['chamado_assunto']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-12  mb-2">
                                <label for="chamado_assunto">Assunto:</label>
                                <input type="text" class="form-control requeri " id="chamado_assunto" name="chamado_assunto" value="<?php print $dados->fields['chamado_assunto']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-12  mb-2">
                                <label for="chamado_descricao">Descrição:</label>
                                <textarea rows="6" class="form-control requeri unique" id="chamado_descricao" name="chamado_descricao" <?=$disabled?>><?php print $dados->fields['chamado_descricao']?></textarea>
                            </div>
                            <div  class="col-sm-12 form-group">
                                <label for="chamado_servico" >Serviço :</label>
                                <select class="form-control requeri" id="chamado_servico" name="chamado_servico" <?=$disabled?>>
                                    <option value="AJUSTE"    <?php print $dados->fields['chamado_servico'] == "AJUSTE"    ? "selected" : ""  ?>>1 - Ajuste</option>
                                    <option value="SOLICITACAO" <?php print $dados->fields['chamado_servico'] == "SOLICITACAO" ? "selected" : ""  ?>>2 - Solicitação</option>
                                </select>
                            </div>    
                            <div  class="col-sm-12 form-group">                        
                                <input type="file" id="arquivo_pfx" name="arquivo_pfx" class="inputfile inputfile-1" style="width=100%;">                                                            
                                <label for="arquivo_pfx" class="fix-center btn btn-warning text-center" style="width=400px;">                                
                                    <span class="glyphicon glyphicon-arrow-up margin-right-10"></span>                        
                                    <span class="nome-arquivo" id="nome-arquivo" name="nome-arquivo">Adicione um anexo</span>
                                </label>
                            </div>       
                        </div>     
                        <?php } else { ?>
                        <div class="col-sm-8"> 
                            <div class="col-sm-12">                         
                                <div  class="col-sm-12 form-group">
                                     <img src="dist/img/user_1.jpg" class="img-circle elevation-2" alt="No Image" style="width: 60px; height: 60px;">
                                     Vitor Hugo Nunes Marini  - <b>ha 10 horas</b>
                                 </div>
                            </div>  
                            <div class="col-sm-12 form-group">                         
                                <div  class="col-sm-12 form-group">
                                     Encontrado um problema na implantação do sistema. Onde impossibilita a conexão ssh. Favor Verificar para que o mesmo seja resolvido.
                                     <br><br>
                                     Qual o tratamento para que esse tipo de ocorrênca não exista?
                                 </div>
                            </div>  
                            <div class="col-sm-12 form-group"> <hr> </div>      
                            <div class="col-sm-12">                         
                                <div  class="col-sm-12 form-group">
                                     <img src="dist/img/smigle.jpg" class="img-circle elevation-2" alt="No Image" style="width: 60px; height: 60px;">
                                     Smigle  - <b>ha 12 horas</b>
                                 </div>
                            </div>  
                            <div class="col-sm-12 form-group">                         
                                <div  class="col-sm-12 form-group">
                                     Meu precioso, é só seguir os passos que o Sr. Thiago instruiu que irá funcionar.
                                     <br><br>
                                     Algo a mais ou podemos encerrar o chamado?
                                 </div>
                            </div>  
                            <div class="col-sm-12 form-group"> <hr> </div>      
                            <div class="col-sm-12">                         
                                <div  class="col-sm-6 form-group">
                                     <img src="dist/img/user_1.jpg" class="img-circle elevation-2" alt="No Image" style="width: 40px; height: 40px;">
                                     <button type="button" class="btn btn-success " id="btnGravaConversa" onclick="movPage('adm_chamados','','', 'gravaConversa','','')">
                                        <span class="fas fa-retweet"></span>
                                        Gravar
                                    </button> 
                                 </div>
                                <div  class="col-sm-12 form-group">
                                     <textarea rows="2" class="form-control" id="adicao_conversa" name="adicao_conversa" placeholder="Adicionar à conversa"></textarea>
                                 </div>
                            </div>  
                        </div>

                        <div class="row col-sm-4 backgroundDescricao"> 
                            <div class="col-sm-4"> 
                                <div  class="col-sm-12 form-group mb-2"> <label>Solicitante          </label> </div>
                                <div  class="col-sm-12 form-group mb-2"> <label>Criado               </label> </div>
                                <div  class="col-sm-12 form-group mb-2"> <label>Última atividade     </label> </div>
                            </div>
                            <div class="col-sm-8"> 
                                <div  class="col-sm-12 form-group"> Vitor Hugo Nunes Marini </div>
                                <div  class="col-sm-12 form-group"> Hoje ás 11:33 </div>
                                <div  class="col-sm-12 form-group"> Hoje ás 20:30 </div>
                            </div>                            
                            <div class="col-sm-12 form-group"> <hr> </div>      
                            <div class="col-sm-4"> 
                                <div  class="col-sm-12 form-group mb-2"> <label>Atribuído a          </label> </div>
                                <div  class="col-sm-12 form-group mb-2"> <label>ID                   </label> </div>
                                <div  class="col-sm-12 form-group mb-2"> <label>Status               </label> </div>
                                <div  class="col-sm-12 form-group mb-2"> <label>Prioridade           </label> </div>
                                <div  class="col-sm-12 form-group mb-2"> <label>Serviços             </label> </div>
                            </div>
                            <div class="col-sm-8"> 
                                <div  class="col-sm-12 form-group"> Cristiano </div>
                                <div  class="col-sm-12 form-group"> #342342 </div>
                                <div  class="col-sm-12 form-group"> [EM ANDAMENTO] </div>
                                <div  class="col-sm-12 form-group"> Alta </div>
                                <div  class="col-sm-12 form-group"> Ajuste </div>
                            </div>                         
                            <div class="col-sm-12 form-group"> <hr> </div>
                            <div class="col-sm-4"> 
                                <div  class="col-sm-12 form-group mb-2"> <label>Anexos          </label> </div>                                
                            </div>
                        </div>  
                        <?php } ?>                                       
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
              <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_chamados','','', 'movimentacao','','')">
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
  
<?php include_once "../../_man/search/_searchData.php"; ?>
<?php include_once './_import/modals.php'; ?>
<script type="text/javascript" charset="utf8" src="./DataTables/datatables.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function($){

        
        //Máscaras e validações        
        validaEmpresaMatriz();
        addMascarasCPF_CNPJ();
        
        $("#empresa_cep").mask("99.999-999");
        $(".telefone_fixo").mask("(99) 9999-9999");
        $("#empresa_tipo_pessoa").on("change",function(){ addMascarasCPF_CNPJ();  });
        
        $("#empresa_tipo").on("change", function(){ validaEmpresaMatriz(); });
        
        /* aplica DataTable na tabela. */
        new DataTable( '#table_lista_notas', {
            paging: false,
            scrollY: 500
        } );

        function addMascarasCPF_CNPJ(){
            var tipo = $("#empresa_tipo_pessoa").val();
                      
            if ( tipo === "J" )      {  $("#empresa_cnpj").mask("99.999.999/9999-99"); }           
            else if ( tipo === "F" ) {  $("#empresa_cnpj").mask("999.999.999-99");     }          
            else if ( tipo === "E" ) {  $("#empresa_cnpj").mask("999.9999");           }            
            else                     {  $("#empresa_cnpj").mask("999.9999");           }
        }
        
        
        function validaEmpresaMatriz(){
            var tipo = $("#empresa_tipo").val();
          
          if ( tipo === "FILIAL" ){
              $(".empresa_busca, #empresa_matriz_id").addClass("require");
              $(".empresa_busca").show();
          }else{
              $("#empresa_busca, #empresa_matriz_id").removeClass("require");
              $(".empresa_busca").hide();
          }
        }
        
                           
       //Fim - Máscaras e Validações
       
       
       
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
                url: "<?= $_SERVER['localhost'] ?>/mmflow/_man/rest_api/api_cep_correios.php",
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
        
        //Mostra o nome do arquivo escolhido para o usuário
        $("#arquivo_pfx").on("change", function(e){           
            //Obtem nome do arquivo
            var nomeArquivo = "";
            if(e.target.value) nomeArquivo = e.target.value.split("\\").pop();
                            
            //Mostra o nome do arquivo se algo for selecionado
            if(nomeArquivo){
                $("label[for='arquivo_pfx']").find(".nome-arquivo").html(nomeArquivo);
                $("#btnProsseguir").removeClass("disabled");
            }
            else{
                $("label[for='arquivo_pfx']").find(".nome-arquivo").html("Escolha um arquivo...");
                $("#btnProsseguir").addClass("disabled");
            }           
        });

        
                          
    });
    </script>

  <!-- /.content-wrapper -->