<!-- Main content -->
<section class="content">
   <!-- INICIAMOS O MODO TELA -->
    <?php  if ( $_SESSION['op'] == "" ){

        $buscas = explode("&",$_SESSION["buscas"]);
        $filtro_busca = $where = "";
        if ( count($buscas) > 0 ){
            $where = 
            "WHERE empresa_id IS NOT NULL 
               AND ( empresa_cnpj ILIKE '%".explode("=", $buscas[0])[1]."%' 
                  OR empresa_razao_social       ILIKE '%".explode("=", $buscas[0])[1]."%' )";

            $filtro_busca = explode("=", $buscas[0])[1];
        } 
    ?>
  <!-- Default box -->
  <div class="card body-view">
    <div class="card-header">          
        <div class="row">
            <div class="col-sm-2">                  
                <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_empresas','insert','', 'movimentacao','','')">
                  <span class="fas fa-plus"></span>
                  Novo Item
              </button>                  
            </div>
            <div class="col-sm-8">
                <div class="col-sm-12">                        
                    <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $filtro_busca?>" placeholder="Busque pela Razão Social o CNPJ..."/>
                </div>
            </div>
            <div class="col-sm-2">                  
              <button type="button" class="btn btn-info buscas" id="btnBusca" onclick="movPage('adm_empresas','','', 'movimentacao','','')">
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
        <div class="row">
            <div class="col-sm-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="07%" class="text-center">Tipo            </th>
                            <th width="15%" class="text-center">CNPJ            </th>
                            <th width="24%" class="text-center">Razão Social    </th>
                            <th width="18%" class="text-center">Fantasia        </th>
                            <th width="08%" class="text-center">IE              </th>
                            <th width="09%" class="text-center">CEP             </th>
                            <th width="04%" class="text-center">UF              </th>
                            <th width="15%" class="text-center">Ações           </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ( $dados->RecordCount() > 0 ){
                            while ( !$dados->EOF ) { ?>
                        <tr>
                            <td class="text-center"><?= "MATRIZ"                                                          ?></td>
                            <td class="text-center"><?= formataCpfCnpj($dados->fields['empresa_cnpj'],$dados->fields['empresa_tipo_pessoa'])    ?></td>
                            <td class="text-left"  ><?= $dados->fields['empresa_razao_social']    ?></td>
                            <td class="text-left"  ><?= $dados->fields['empresa_nome_fantasia']   ?></td>
                            <td class="text-left"  ><?= $dados->fields['empresa_ie']              ?></td>
                            <td class="text-left"  ><?= formataCep($dados->fields['empresa_cep']) ?></td>
                            <td class="text-left"  ><?= $dados->fields['empresa_uf']              ?></td>
                            <td class="text-center">
                                <button class="btn btn-success" onclick="movPage('adm_empresas','view','<?= $dados->fields['empresa_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-info" onclick="movPage('adm_empresas','edit','<?= $dados->fields['empresa_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger" onclick="movPage('adm_empresas','delete','<?= $dados->fields['empresa_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar.">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $dados->MoveNext(); 
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
       else if ( $_SESSION["op"] == "insert" ){ $description = "Insira os "; }
       else if ( $_SESSION["op"] == "delete" ){ $description = "Deletar esses ";  $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "edit"   ){ $description = "Editar os "; }

      ?>

  <div class="card body-view">
    <div class="card-header">          

      <div class="row">

            <div class="col-sm-12">           
                <label><?= $description ?> Dados da Empresa</label>
           </div>

      </div>

    </div>
    <div class="card-body">
        <form action="<?= $_SERVER['localhost']?>/sys/_man/manutencao/mainAdmEmpresas.php" method="post" id="frmDados">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#empresa_geral" id="aba-empresa-geral"  role="tab" data-toggle="tab" class="nav-link active" >Dados Gerais</a>
                </li>   
                <li class="nav-item">
                    <a href="#empresa_endereco" id="aba-empresa-endereco"  role="tab" data-toggle="tab" class="nav-link " >Endereço</a>
                </li>   
                <li class="nav-item">
                    <a href="#empresa_contato" id="aba-empresa-contato"  role="tab" data-toggle="tab" class="nav-link " >Contato</a>
                </li>   
            </ul>

            <div class="tab-content">
                <div class="tab-pane active margin-top-15" id="empresa_geral" role="tabpanel">
                    <div class="row">
                        <div class="row col-sm-12">
                            <div  class="col-sm-2 mb-2">
                                <label for="empresa_tipo_pessoa">Tipo Pessoa:</label>
                                <select class="form-control requeri" id="empresa_tipo_pessoa" name="empresa_tipo_pessoa">
                                    <option value="">Selecione</option>
                                    <option value="F" <?php print $dados->fields['empresa_tipo_pessoa'] == "F" ? "selected" : "" ?>>Física  </option>
                                    <option value="J" <?php print $dados->fields['empresa_tipo_pessoa'] == "J" ? "selected" : "" ?>>Jurídica</option>
                                    <option value="E" <?php print $dados->fields['empresa_tipo_pessoa'] == "E" ? "selected" : "" ?>>Exterior</option>
                                    <option value="O" <?php print $dados->fields['empresa_tipo_pessoa'] == "O" ? "selected" : "" ?>>Outros  </option>
                                </select>
                            </div>
                            <div  class="col-sm-6  mb-2">
                                <label or="empresa_razao_social">Razão Social:</label>
                                <input type="text" class="form-control requeri unique" id="empresa_razao_social" name="empresa_razao_social" value="<?php print $dados->fields['empresa_razao_social']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-4  mb-2">
                                <label for="empresa_nome_fantasia">Nome Fantasia:</label>
                                <input type="text" class="form-control requeri" id="empresa_nome_fantasia" name="empresa_nome_fantasia" value="<?php print $dados->fields['empresa_nome_fantasia']?>" <?=$disabled?>/>
                            </div>
                        </div>
                        <div class="row col-sm-12">
                            <div  class="col-sm-2 mb-2">
                                <label for="empresa_cnpj">CNPJ:</label>
                                <input type="text" class="form-control requeri cnpj" id="empresa_cnpj" name="empresa_cnpj" value="<?php print $dados->fields['empresa_cnpj']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group ">
                                <label or="empresa_ie">Inscrição Estadual:</label>
                                <input type="text" class="form-control requeri unique" id="empresa_ie" name="empresa_ie" value="<?php print $dados->fields['empresa_ie']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group">
                                <label or="empresa_im">Inscrição Municipal:</label>
                                <input type="text" class="form-control " id="empresa_im" name="empresa_im" value="<?php print $dados->fields['empresa_im']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group ">
                                <label or="empresa_nire">Núm. NIRE:</label>
                                <input type="text" class="form-control unique" id="empresa_nire" name="empresa_nire" value="<?php print $dados->fields['empresa_nire']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group">
                                <label for="empresa_tipo" >Tipo da Empresa:</label>
                                <select class="form-control requeri" id="empresa_tipo" name="empresa_tipo" <?=$disabled?>>
                                    <option value=""       <?php print $_SESSION['id'] != "" ? "disabled" : "" ?>>Selecione</option>
                                    <option value="MATRIZ" <?php print $dados->fields['empresa_tipo'] == "MATRIZ" ? "selected" : ""  ?>>1 - Matriz</option>
                                    <option value="FILIAL" <?php print $dados->fields['empresa_tipo'] == "FILIAL" ? "selected" : ""  ?>>2 - Filial</option>
                                </select>
                            </div>
                            <div class="col-sm-2 mb-2">
                                <label for="empresa_situacao" >Situação Empresa:</label>
                                <select class="form-control requeri " id="empresa_situacao" name="empresa_situacao" <?=$disabled?>>
                                    <option value=""       <?php print $_SESSION['id'] != "" ? "disabled" : "" ?>>Selecione</option>
                                    <option value="1" <?php print $dados->fields['empresa_situacao'] == "1" ? "selected" : ""  ?>>1 - Ativa</option>
                                    <option value="2" <?php print $dados->fields['empresa_situacao'] == "2" ? "selected" : ""  ?>>2 - Inativa</option>
                                </select>
                            </div>      
                        </div>
                        <div class="row col-sm-12 empresa_busca">                                
                            <div  class="col-sm-12  mb-2">
                                <label or="empresa_matriz">Empresa Matriz:</label>
                                <input type="text" class="form-control   search" id="empresa_busca" name="t_empresa" value="<?php print $descricaoEmpresaMatriz?>" <?=$disabled?>/>
                                <input type="hidden" class="form-control  " id="empresa_matriz_id" name="empresa_matriz_id" value="<?php print $dados->fields['empresa_matriz_id']?>" <?=$disabled?>/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane  margin-top-15" id="empresa_endereco" role="tabpanel">
                    <div class="row mb-2">
                        <div class="col-sm-12 row">

                            <div  class="col-sm-2 form-group">
                                <label for="empresa_cep">CEP:</label>
                                <input type="text" class="form-control requeri " id="empresa_cep" name="empresa_cep" value="<?php print $dados->fields['empresa_numero']?>" <?=$disabled?>/>
                            </div>

                            <div  class="col-sm-4 form-group" >
                                <label for="empresa_logradouro">Endereço ( Logradouro ):</label>
                                <input type="text" class="form-control requeri cep" id="empresa_logradouro" name="empresa_logradouro" value="<?php print $dados->fields['empresa_logradouro']?>" <?=$disabled?>/>
                            </div>


                            <div  class="col-sm-2 form-group">
                                <label for="empresa_numero">Número:</label>
                                <input type="text" class="form-control requeri cep" id="empresa_numero" name="empresa_numero" value="<?php print $dados->fields['empresa_numero']?>" <?=$disabled?>/>
                            </div>

                            <div  class="col-sm-4 form-group">
                                <label for="empresa_bairro">Bairro:</label>
                                <input type="text" class="form-control requeri cep" id="empresa_bairro" name="empresa_bairro" value="<?php print $dados->fields['empresa_numero']?>" <?=$disabled?>/>
                            </div>

                        </div>
                        <div class="col-sm-12 row">

                            <div  class="col-sm-2 form-group">
                                <label for="empresa_uf">UF:</label>
                                <input type="text" class="form-control requeri cep" id="empresa_uf" name="empresa_uf" value="<?php print $dados->fields['empresa_uf']?>" <?=$disabled?>/>
                            </div>

                            <div  class="col-sm-4 form-group" >
                                <label for="empresa_codigo_municipio">Município:</label>
                                <input type="text" class="form-control  cep" id="empresa_codigo_municipio_descricao" name="empresa_codigo_municipio_descricao" value="<?php print $dados->fields['empresa_codigo_municipio_descricao']?>" <?=$disabled?>/>
                                <input type="hidden" class="form-control requeri " id="empresa_codigo_municipio" name="empresa_codigo_municipio" value="<?php print $dados->fields['empresa_codigo_municipio']?>" <?=$disabled?>/>
                            </div>


                            <div  class="col-sm-6 form-group">
                                <label for="empresa_complemento">Complemento:</label>
                                <input type="text" class="form-control  cep" id="empresa_complemento" name="empresa_complemento" value="<?php print $dados->fields['empresa_complemento']?>" <?=$disabled?>/>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane  margin-top-15" id="empresa_contato" role="tabpanel">
                    <div class="row mb-2">
                        <div class="col-sm-12 row">

                            <div  class="col-sm-4 form-group">
                                <label for="empresa_telefone_principal">Telefone Principal:</label>
                                <input type="text" class="form-control requeri telefone_fixo" id="empresa_telefone_principal" name="empresa_telefone_principal" value="<?php print $dados->fields['empresa_telefone_principal']?>" <?=$disabled?>/>
                            </div>

                            <div  class="col-sm-4 form-group" >
                                <label for="empresa_telefone_secundario">Telefone Secundário:</label>
                                <input type="text" class="form-control telefone_fixo" id="empresa_telefone_secundario" name="empresa_telefone_secundario" value="<?php print $dados->fields['empresa_telefone_secundario']?>" <?=$disabled?>/>
                            </div>


                            <div  class="col-sm-4 form-group">
                                <label for="empresa_email">E-mail:</label>
                                <input type="text" class="form-control " id="empresa_email" name="empresa_email" value="<?php print $dados->fields['empresa_email']?>" <?=$disabled?>/>
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
              <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_empresas','','', 'movimentacao','','')">
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
<script type="text/javascript">
    
    $(document).ready(function($){

        
        //Máscaras e validações        
        validaEmpresaMatriz();
        addMascarasCPF_CNPJ();
        
        $("#empresa_cep").mask("99.999-999");
        $(".telefone_fixo").mask("(99) 9999-9999");
        $("#empresa_tipo_pessoa").on("change",function(){ addMascarasCPF_CNPJ();  });
        
        $("#empresa_tipo").on("change", function(){ validaEmpresaMatriz(); });
        
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
                url: "<?= $_SERVER[localhost] ?>/sys/_man/rest_api/api_cep_correios.php",
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