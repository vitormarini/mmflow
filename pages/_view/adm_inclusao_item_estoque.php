<!-- Main content -->
<section class="content">
    <!-- INICIAMOS O MODO TELA -->
    <?php  if ( $_SESSION['op'] == "" ){

    $buscas = explode("&",$_SESSION["buscas"]);
    $filtro_busca = $where = "";
    if ( count($buscas) > 0 ){
        $where =
        "WHERE ped.pedido_simples_id IS NOT NULL
            AND ( ped.pedido_simples_id::text ILIKE '%".explode("=", $buscas[0])[1]."%' )";

        $filtro_busca = explode("=", $buscas[0])[1];
    }
    ?>
    <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-2">
                    <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_inclusao_item_estoque','insert','', 'movimentacao','','')">
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
                    <button type="button" class="btn btn-info buscas" id="btnBusca" onclick="movPage('adm_inclusao_item_estoque','','', 'movimentacao','','')">
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
            $sql = "
                SELECT  ped.pedido_simples_id	        , ped.pedido_simples_data_abertura
                    , 	ped.pedido_simples_situacao	    , ped.participante_id
                    ,	CASE
                            WHEN ped.pedido_simples_situacao = '1' THEN 'ABERTO'
                            WHEN ped.pedido_simples_situacao = '2' THEN 'Cancelado'
                            WHEN ped.pedido_simples_situacao = '3' THEN 'Eliminado'
                            WHEN ped.pedido_simples_situacao = '4' THEN 'Pago'
                            WHEN ped.pedido_simples_situacao = '5' THEN 'Pendente'
                        END AS situacao_descricao
                    ,	cpf_cnpj(p.participante_codigo,p.participante_tipo)|| ' - ' || p.participante_nome  AS participante_descricao
                FROM public.t_pedido_simples AS ped
                INNER JOIN t_participante AS p ON ( p.participante_id = ped.participante_id  )
                {$where}
                AND ped.pedido_simples_situacao NOT IN ( '3' ) ";


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
                                <th width="10%" class="text-center">Número Pedido   </th>
                                <th width="10%" class="text-center">Data            </th>
                                <th width="30%" class="text-center">Cliente         </th>
                                <th width="20%" class="text-center">Situação        </th>
                                <th width="20%" class="text-center">Valor Total     </th>
                                <th width="10%" class="text-center">Ações           </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ( $dados->RecordCount() > 0 ){
                                while ( !$dados->EOF ) { ?>
                            <tr>
                                <td class="text-center"><?= $dados->fields['pedido_simples_id']                 ?></td>
                                <td class="text-left"  ><?= $dados->fields['pedido_simples_data_abertura']      ?></td>
                                <td class="text-left"  ><?= $dados->fields['participante_descricao']            ?></td>
                                <td class="text-left"  ><?= $dados->fields['situacao_descricao']                ?></td>
                                <td class="text-left"  ><?= $dados->fields['pedido_simples_situacao']           ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_inclusao_item_estoque','view','<?= $dados->fields['pedido_simples_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <?php
                                    if ( $dados->fields['pedido_simples_situacao'] == '1' ){?>

                                        <button class="btn btn-info" onclick="movPage('adm_inclusao_item_estoque','edit','<?= $dados->fields['pedido_simples_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                    <?php } ?>
                                    <!-- <button class="btn btn-danger" onclick="movPage('adm_inclusao_item_estoque','delete','<?= $dados->fields['pedido_simples_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar.">
                                        <i class="fas fa-trash"></i>
                                    </button> -->
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
            $sql = "SELECT  ped.pedido_simples_id	        , ped.pedido_simples_data_abertura
                        , 	ped.pedido_simples_situacao	    , ped.participante_id
                        ,	CASE
                                WHEN ped.pedido_simples_situacao = '1' THEN 'ABERTO'
                                WHEN ped.pedido_simples_situacao = '1' THEN 'Cancelado'
                                WHEN ped.pedido_simples_situacao = '1' THEN 'Eliminado'
                                WHEN ped.pedido_simples_situacao = '1' THEN 'Pago'
                                WHEN ped.pedido_simples_situacao = '1' THEN 'Pendente'
                            END AS situacao_descricao
                        ,	cpf_cnpj(p.participante_codigo,p.participante_tipo)|| ' - ' || p.participante_nome  AS participante_descricao
                        ,	SUM(tip.item_pedido_valor_total) AS total
                        ,	SUM(tip.item_pedido_valor_desconto) AS desconto
                        ,	SUM(tip.item_pedido_quantidade) AS quantidade
                        FROM public.t_pedido_simples AS ped
                        INNER JOIN t_participante AS p ON ( p.participante_id = ped.participante_id  )
                        LEFT JOIN t_item_pedido AS tip ON ( tip.pedido_simples_id = ped.pedido_simples_id  )
                            WHERE ped.pedido_simples_id = '{$_SESSION['id']}'
                            GROUP BY 1,2,3,4,5,6;";



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
                    <label><?= $description ?> Dados do Pedido</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= $_SERVER['localhost']?>/sys/_man/manutencao/mainInclusaoItemEstoque.php" method="post" id="frmDados">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#pedido_geral" id="aba-pedido-geral"  role="tab" data-toggle="tab" class=" escondido nav-link " >Dados Gerais</a>
                    </li>
                    <li class="nav-item">
                        <a href="#pedido_item" id="aba-pedido-item"  role="tab" data-toggle="tab" class="nav-link active" >Itens</a>
                    </li>
                    <li class="nav-item">
                        <a href="#pedido_contato" id="aba-pedido-contato"  role="tab" data-toggle="tab" class="escondido nav-link <?= ( $_SESSION['aba'] == "aba-pedido-contato" ? "active" : "" ) ?>" >Contato</a>
                    </li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane margin-top-15 escondido" id="pedido_geral" role="tabpanel">
                        <div class="row">
                            <div class="row col-sm-12">
                                <div  class="col-sm-2 mb-2">
                                    <label for="pedido_numero">Número :<h1><?php print $dados->fields['pedido_simples_id'] ?></h1></label>
                                </div>
                                <div  class="col-sm-2 mb-2">
                                    <label for="data_abertura">Data de Abertura Pedido:</label>
                                    <input type="date" class="form-control  cnpj" id="data_abertura" name="data_abertura" value="<?php print $dados->fields['pedido_simples_data_abertura']?>" <?=$disabled?>/>
                                </div>
                                <div  class="col-sm-2 form-group">
                                    <label or="pedido_total">Valor Total:</label>
                                    <input type="text" class="form-control " id="pedido_total" name="pedido_total" value="<?php print $dados->fields['total']?>" readonly/>
                                </div>
                                <div  class="col-sm-2 form-group">
                                    <label or="qtd_itens">Quantidade de Itens:</label>
                                    <input type="text" class="form-control " id="qtd_itens" name="qtd_itens" value="<?php print $dados->fields['quantidade']?>" readonly/>
                                </div>
                                <div  class="col-sm-2 form-group">
                                    <label or="valor_desconto">Total em Desconto:</label>
                                    <input type="text" class="form-control " id="valor_desconto" name="valor_desconto" value="<?php print $dados->fields['desconto']?>" readonly/>
                                </div>
                                <div  class="col-sm-2 form-group ">
                                    <label or="pedido_situacao">Situação:</label>
                                    <select class="form-control  " id="pedido_situacao" name="pedido_situacao" <?=$disabled?>>
                                        <option value=""       <?php print $_SESSION['id'] != "" ? "disabled" : "" ?>>Selecione</option>
                                        <option value="1" <?php print $dados->fields['pedido_situacao'] == "1" ? "selected" : ""  ?>>1 - Aberto</option>
                                        <option value="2" <?php print $dados->fields['pedido_situacao'] == "2" ? "selected" : ""  ?>>2 - Cancelado</option>
                                        <option value="3" <?php print $dados->fields['pedido_situacao'] == "3" ? "selected" : ""  ?>>3 - Eliminado</option>
                                        <option value="4" <?php print $dados->fields['pedido_situacao'] == "4" ? "selected" : ""  ?>>4 - Pago</option>
                                        <option value="5" <?php print $dados->fields['pedido_situacao'] == "5" ? "selected" : ""  ?>>5 - Pendente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row col-sm-12">
                                <div  class="col-sm-12  mb-2">
                                    <label or="pedido_cliente">Dados do Cliente:</label>
                                    <input type="text" class="form-control   search" id="cliente_busca" name="t_participante" value="<?php print $dados->fields['participante_descricao']; ?>" <?=$disabled?>/>
                                    <input type="hidden" class="form-control  " id="pedido_cliente_id" name="pedido_cliente_id" value="<?php print $dados->fields['participante_id']?>" <?=$disabled?>/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  active margin-top-15" id="pedido_item" role="tabpanel">
                        <div class="row mb-2">
                            <div  class="col-sm-2 form-group ">
                                <label or="tipo_inclusao">Tipo:</label>
                                <select class="form-control  " id="tipo_inclusao" name="tipo_inclusao" <?=$disabled?>>
                                    <option value="" <?php print $_SESSION['id'] != "" ? "disabled" : "" ?>>Selecione</option>
                                    <option value="ESTOQUE_INICIAL" >1 - Estoque Inicial    </option>
                                    <option value="NFE_COMPLETA"    >2 - NFe Completa       </option>
                                    <option value="NFE_MEIA"        >3 - NFe Simples        </option>
                                    <option value="OUTROS"          >4 - Outros Doc.        </option>
                                </select>
                            </div>
                            <div  class="col-sm-6  mb-2">
                                <label or="pedido_item">Dados do Item:</label>
                                <input type="text" class="form-control   search" id="item_busca" name="t_item" value="" <?=$disabled?>/>
                                <input type="hidden" class="form-control  " id="pedido_item_id" name="pedido_item_id" value="" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group">
                                <label or="numero_registro">Núm. Documento:</label>
                                <input type="text" class="form-control " id="numero_registro" name="numero_registro" value="" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group">
                                <label or="data_registro">Data:</label>
                                <input type="date" class="form-control " id="data_registro" name="data_registro" value="" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-6 form-group ">
                                <label or="codigo_barras">Código de Barras:</label>
                                <input type="text" class="form-control " id="codigo_barras" name="codigo_barras" value=""  placeholder="Insira o código de barras!" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group ">
                                <label or="item_pedido_valor_unitario">Valor Unitário:</label>
                                <input type="text" class="form-control  money" id="item_pedido_valor_unitario" name="item_pedido_valor_unitario" value="" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-2 form-group ">
                                <label or="item_pedido_quantidade">Quantidade:</label>
                                <input type="text" class="form-control  " id="item_pedido_quantidade" name="item_pedido_quantidade" value="" <?=$disabled?>/>
                            </div>

                            <div  class="col-sm-2 form-group ">
                                <label or="item_pedido_valor_total">Total:</label>
                                <input type="text" class="form-control money " id="item_pedido_valor_total" name="item_pedido_valor_total" value="" readonly/>
                            </div>
                            <div  class="col-sm-12 form-group" style="padding-top: 25px;">
                                <button type="button" class="btn btn-info" id="btnAdicionaItem" style="width: 100%; " disabled >
                                    <span class="fas fa-plus"></span> Adicionar Item
                                </button>
                            </div>
                            <?php
                                $itens = $bd->Execute($sql ="
                                    SELECT
                                        mi.tipo_entrada         ,	mi.valor_unitario                               ,	mi.valor_total
                                        ,	mi.quantidade       ,	databrasil(mi.data_registro) AS data_registro   ,	mi.numero_documento
                                        ,	mi.codigo_barras
                                        ,	ti.item_codigo ||' - '||ti.item_descricao AS produto
                                    FROM movimentacao_item mi
                                    INNER JOIN t_item AS ti ON ( ti.item_id = mi.id_item_produto  )
                                    ORDER BY mi.data_registro ");
                                ?>

                                <div class="col-sm-12 row">
                                    <table class="table" id="itens_table">
                                        <thead>
                                            <tr>
                                                <th class="text-center" width="08%" >Data       </th>
                                                <th class="text-center" width="35%" >Produto    </th>
                                                <th class="text-center" width="10%" >Tipo       </th>
                                                <th class="text-center" width="10%" >Documento  </th>
                                                <th class="text-center" width="10%" >C.Barras   </th>
                                                <th class="text-center" width="10%" >R$ Unt.    </th>
                                                <th class="text-center" width="10%" >Quantidade </th>
                                                <th class="text-center" width="10%" >R$ TOTAL   </th>
                                                <th class="text-center" width="10%" >Ações      </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ( !$itens->EOF ){ ?>
                                                <tr>
                                                    <td class="text-center"><?php print $itens->fields['data_registro']                              ?></td>
                                                    <td class="text-center"><?php print $itens->fields['produto']                                    ?></td>
                                                    <td class="text-center"><?php print $itens->fields['tipo_entrada']                               ?></td>
                                                    <td class="text-center"><?php print $itens->fields['numero_documento']                           ?></td>
                                                    <td class="text-center"><?php print $itens->fields['codigo_barras']                              ?></td>
                                                    <td class="text-center"><?php print number_format($itens->fields['valor_unitario'],2,",",".")    ?></td>
                                                    <td class="text-center"><?php print $itens->fields['quantidade']                                 ?></td>
                                                    <td class="text-center"><?php print number_format($itens->fields['valor_total'],2,",",".")       ?></td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btnRemoveItem" id="btnRemoveItem_<?php print $itens->fields['item_pedido_id']?>" name="<?php print $itens->fields['item_pedido_id']?>" <?=$disabled?>>
                                                            <span class="fas fa-trash"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php
                                                $itens->MoveNext();
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer  align-content-center escondido">
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
                <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_inclusao_item_estoque','','', 'movimentacao','','')">
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
<!-- /.content -->

<?php include_once "../../_man/search/_searchData.php"; ?>
<script type="text/javascript">

    function removeMaskMoney (x){
        x = ""+x;
        if ((x.replace(",", ".") != x )){
            if (x.replace(".", "") != x ){
                aux = x;
                x = x.replace(".", "");
            }
            else {
                aux = x;
            }
            if(x.replace(",", ".") != x){
                x = x.replace(",", ".")
            }else{
                x = aux;
            }
        }
        if (isNaN(parseFloat(x)) ){
            x = 0;
        }else{
            x = parseFloat(x)
        }
        return x;
    }

    $(document).ready(function($){


        //Máscaras e validações
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
        $(".money").change(function(){ $("#value").html($(this).val().replace(/\D/g,''))});

        $("#aba-pedido-item, #aba-participante-contato").on("click",function(){ $("#btnSalvar, #btnExcluir, #btnVoltar").hide(); });
        $("#aba-pedido-geral").on("click",function(){ $("#btnSalvar, #btnExcluir, #btnVoltar").show(); });


        //Calculando os valores totais
        $(".money, #item_pedido_quantidade").on("change", function(){
            //Validamos o botão, caso tenha algum item modificado
            $("#btnAdicionaItem").prop("disabled", true);

            //Alimentamos as variáveis
            var quantidade = removeMaskMoney($("#item_pedido_quantidade").val())        > 0 ? removeMaskMoney($("#item_pedido_quantidade").val())     : 0 ;
            var unitario   = removeMaskMoney($("#item_pedido_valor_unitario").val())    > 0 ? removeMaskMoney($("#item_pedido_valor_unitario").val()) : 0 ;
            var total      = 0;

            //Calculando o Total
            total = ( quantidade * unitario );

            //Verificando o Total
            if ( total > 0 ){
                $("#item_pedido_valor_total").val(total);
                $("#btnAdicionaItem").prop("disabled", false);
            }

        });

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
           var input = $(this).prop("id");

           $(".search").autocomplete({
                source: function( request, response){
                    $.ajax({
                        url: "<?= $_SERVER["localhost"] ?>/sys/_man/search/_searchData.php",
                        type: "post",
                        dataType: "json",
                        data: {
                            descricao: request.term,
                            table: table,
                            tipo: "busca_item"
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
                    $('#pedido_item_id').val(ui.item.id);
                    $("#"+input).addClass("alert-success");
                },
                open: function() {
                    $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {
                    $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });

        });

        //Movimentações do botões que farão a função de modificar os itens
        $("#btnAdicionaItem").on("click", function(){ movimentaItens("novo", "", "item_pedido") });
        $(".btnRemoveItem").on("click", function(){ movimentaItens("delete", $(this).prop("name"), "item_pedido") });

        // $("#btnAdicionarEndereco").on("click", function(){ movimentaItens("novo","","endereco"); });
        // $(".btnRemoveItem"       ).on("click", function(){ movimentaItens("delete",$(this).prop("name"),"endereco"); });
        // $("#btnAdicionarContato" ).on("click", function(){ movimentaItens("novo","","contato"); });
        // $(".btnRemoveItemContato").on("click", function(){ movimentaItens("delete",$(this).prop("name"),"contato");  });

        function movimentaItens(tipo,id, method){
            $.ajax({
                url: "<?= $_SERVER['localhost'] ?>/sys/_man/manutencao/mainInclusaoItemEstoque.php",
                type: "post",
                dataType: "text",
                data: {
                    op: method,
                    type: tipo,
                    id_movim: id,
                    tipo                          : $("#tipo_inclusao").val(),
                    item_pedido_item_id           : $("#pedido_item_id").val(),
                    item_pedido_valor_unitario    : $("#item_pedido_valor_unitario").val(),
                    item_pedido_quantidade        : $("#item_pedido_quantidade").val(),
                    numero_registro               : $("#numero_registro").val(),
                    codigo_barras                 : $("#codigo_barras").val(),
                    data_registro                 : $("#data_registro").val(),
                    item_pedido_valor_total       : $("#item_pedido_valor_total").val()
                },
                success: function(retorno){
                    location.reload();
                }
            });
        }



    });
    </script>

  <!-- /.content-wrapper -->
