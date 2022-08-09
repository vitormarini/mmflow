<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">-->
<!--<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>



<script>
    $(document).ready(function() {
        $('#table_lista_notas').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ itens por página",
                "zeroRecords": "Nada encontrado",
                "info": "Mostrando _PAGE_ de _PAGES_ páginas",
                "infoEmpty": "Nenhum resultado encontrado",
                "infoFiltered": "(Filtrado de _MAX_ resultados totais)",
                paginate: {
                    first: 'Primeira',
                    previous: 'Anterior',
                    next: 'Próxima',
                    last: 'Última',
                },
                aria: {
                    paginate: {
                        first: 'Primeira',
                        previous: 'Anterior',
                        next: 'Próxima',
                        last: 'Última'
                    }
                }
            },
        });
    });
    $(document).ready(function() {
        $('#table_lista_notas').DataTable();
        $.fn.dataTable.ext.errMode = 'none';
    });
    $('#table_lista_notas').dataTable({
        pagingType: "string"
    });
</script>
<!--<script src="./plugins/jquery/jquery.dataTables.min.js" type="text/javascript"></script>-->
<style>
    legend {
        font-size: 13px;
        font-weight: bold;
        color: #808080;
        /* style | color */
        border-bottom: 2px outset #DCDCDC;
    }

    .circulo {
        border-radius: 50%;
        display: inline-block;
        height: 26px;
        width: 26px;
        /* margin: 2px 2px 2px 2px; */
        border: 1px solid #C0C0C0;
        background-color: #C0C0C0;
    }

    #example {
        width: 100% !Important;
    }

    .btnStyle {
        margin: 1px 1px 1px 1px;
        width: 30px;
        position: sticky;
    }
</style>
<section class="content">
    <div class="card body-view">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-12">
                    <button class="btn btn-info" id="btnConsultar" name="btnConsultar"><span class="fas fa-cloud-upload-alt"></span> Consultar API </button>
                    <button class="btn btn-info" id="btnPesquisas" name="btnPesquisas"><span class="fas fa-search	"></span> Pesquisas </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= $_SERVER['localhost'] ?>/mmflow/_man/manutencao/mainAdmConsultaDANFE.php" method="post" id="frmDados">
                <div id="div_pesquisas" name="div_pesquisas" class="escondido">
                    <div class="form-group pull-left col-lg-6 col-md-6 col-sm-6">
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default btn-sm">
                                <input type="radio" name="tipo_pesq" value="pesq_simples" autocomplete="off" checked> Pesquisa
                            </label>
                            <label class="btn btn-default btn-sm">
                                <input type="radio" name="tipo_pesq" value="pesq_avancada" autocomplete="off"> Pesquisa Avançada
                            </label>
                        </div>
                    </div>
                    <div class="row form-group div_pesq_simples">
                        <fieldset class="row form-group col-sm-12">
                            <legend> INFORMAÇÕES GERIAS DO DOCUMENTO </legend>
                            <div class="col-sm-2">
                                <label for="numero_nfe">Número NFe:</label>
                                <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="Número NFe" />
                            </div>
                            <div class="col-sm-5">
                                <label for="chave_acesso_nfe">Chave de Acesso:</label>
                                <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="Chave de Acesso" />
                            </div>
                            <div class="col-sm-2">
                                <label for="data_receb_nfe">Data de Recebimento:</label>
                                <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-info" id="btnBusca" style="margin-top:30px;">
                                    <span class="fas fa-search"></span>
                                    Pesquisar
                                </button>
                            </div>
                        </fieldset>
                    </div>
                    <div class="row div_pesq_avancada escondido">
                        <fieldset class="row form-group col-sm-12">
                            <legend> INFORMAÇÕES GERIAS DO DOCUMENTO </legend>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-4">
                                    <label for="chave_acesso_nfe">Chave de Acesso:</label>
                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="Chave de Acesso" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Número NFe:</label>
                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="serie_nfe">Série:</label>
                                    <input type="text" class="form-control" id="serie_nfe" name="serie_nfe" placeholder="" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="data_receb_nfe">Data Receb.(Inicial):</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="data_receb_nfe">Data Receb.(Final):</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                            </div>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Ambiente:</label>
                                    <select type="text" class="form-control" id="numero_nfe" name="numero_nfe">
                                        <option>Selecione</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Tipo da Nota:</label>
                                    <select type="text" class="form-control" id="numero_nfe" name="numero_nfe">
                                        <option>Selecione</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="data_receb_nfe">Natureza da Operação:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="data_receb_nfe">Data Emissão:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Situação:</label>
                                    <select type="text" class="form-control" id="numero_nfe" name="numero_nfe">
                                        <option>Selecione</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="row form-group col-sm-12">
                            <legend> EMPRESA </legend>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-4">
                                    <label for="numero_nfe">CPF/CNPJ:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-8">
                                    <label for="numero_nfe">Razão Social:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="row form-group col-sm-12">
                            <legend> TRANSPORTADORA </legend>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-4">
                                    <label for="numero_nfe">CPF/CNPJ:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-8">
                                    <label for="numero_nfe">Razão Social:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                            </div>
                        </fieldset>
                        <div class="row">
                            <button type="submit" class="btn btn-info pull-right" id="btnBusca" style="margin-top:30px;">
                                <span class="fas fa-search"></span>
                                Pesquisar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-sm-12" style="margin-left:0px;padding-left: 0">
                <table class="table table-striped table-bordered" id="table_lista_notas">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="checkAll" id="checkAll" width="03%"></th>
                            <th class="text-center" width="25%">Emitente </th>
                            <th class="text-center" width="25%">Número/Série </th>
                            <th class="text-center" width="25%">Valor </th>
                            <th class="text-center" width="25%">Origem </th>
                            <th class="text-center" width="25%">Emissão </th>
                            <th class="text-center" width="25%">Status </th>
                            <th class="text-center" width="25%">Registro </th>
                            <th class="text-center" width="25%">Recebimento </th>
                            <th class="text-center" width="25%">Opções </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $dados = $bd->Execute("
                            SELECT ef_id 
                                , (ef_cnpj_emit ||' - '|| ef_razao_social_emit) AS emit_nfe
                                , (ef_num_nf ||'/'||ef_serie) AS nf_serie
                                , moedabrasil(ef_v_nf::numeric) AS ef_v_nf
                                , databrasil(ef_dt_emissao::date) AS ef_dt_emissao
                                , ef_status 
                                , databrasil(ef_data_hora::date) AS ef_data_hora  
                                , SUBSTR(ef_ident,4,44) AS ef_ident
                            FROM t_escrita_fiscal tef 
                            ORDER BY 1 DESC;");

                        while (!$dados->EOF) {
                            print '
                                    <tr>
                                        <td class="text-center"><input type="checkbox" name="checkbox" class="check_nota"></td>
                                        <td class="text-center">' . $dados->fields['emit_nfe']       . '</td>                                    
                                        <td class="text-center">' . $dados->fields['nf_serie']       . '</td>
                                        <td class="text-center">' . $dados->fields['ef_v_nf']        . '</td>
                                        <td class="text-center">  </td>
                                        <td class="text-center">' . $dados->fields['ef_dt_emissao']  . '</td>
                                        <td class="text-center">' . $dados->fields['ef_status']      . '</td>
                                        <td class="text-center">  </td>
                                        <td class="text-center">' . $dados->fields['ef_data_hora']   . '</td>
                                        <td class="text-center btnTable">
                                                <button class="openDetalhes btn btn-info btn-sm btnStyle" id="'. $dados->fields['ef_id'] .'"> <span class="fas fa-search"></span></button>
                                                <button class="btn btn-info btn-sm btnStyle"><span class="fas fa-tags"></span></button>
                                                <button class="btn btn-info btn-sm btnStyle"><span class="far fa-paper-plane"></span></button>
                                                <button class="btn btn-info btn-sm btnStyle"><span class="far fa-map"></span></div>
                                                <button class="btn btn-info btn-sm btnStyle"><span class="fas fa-cloud-upload-alt"></span></button>
                                                <button class="btn btn-info btn-sm btnStyle"><span class="fas fa-heartbeat"></span></button> 
                                        </td>
                                    </tr>';
                            $dados->MoveNext();
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer  align-content-center">
            <div class="row">
                <?php if ($_SESSION['op'] == "insert" || $_SESSION['op'] == "edit") { ?>
                    <div class="col-sm-2 ">
                        <button type="button" class="btn btn-primary form-control" id="btnSalvar">
                            <span class="fas fa-save"></span>
                            Salvar
                        </button>
                    </div>
                <?php } ?>
                <?php if ($_SESSION['op'] == "delete") { ?>
                    <div class="col-sm-2 ">
                        <button type="button" class="btn btn-danger form-control" id="btnExcluir">
                            <span class="fas fa-trash"></span>
                            Excluir
                        </button>
                    </div>
                <?php } ?>
                <div class="col-sm-2 ">
                    <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_submenus','','', 'movimentacao','','')">
                        <span class="fas fa-retweet"></span>
                        Voltar
                    </button>
                </div>
            </div>
        </div>
        <!-- /.card-footer-->
    </div>
</section>

<!-- /.modal -->
<?php include_once './_import/modals.php'; ?>
<script type="text/javascript">
    $(document).ready(function() {

        /* valida método de pesquisa */
        $("[name='tipo_pesq']").on("change", function() {
            if ($(this).val() == "pesq_simples") {
                $(".div_pesq_avancada").hide();
                $(".div_pesq_simples").show();
            } else {
                $(".div_pesq_simples").hide();
                $(".div_pesq_avancada").show();
            }
        });

        /** validação btnPesquisas */
        $("#btnPesquisas").on("click", function() {
            if ($("#div_pesquisas").hasClass('escondido')) {
                $("#div_pesquisas").removeClass("escondido");
            } else {
                $("#div_pesquisas").addClass("escondido");
            }
        });

        /* aplica DataTable na tabela. */
        new DataTable('#table_lista_notas', {
            paging: false,
            scrollY: 500
        });

        /* valida checkbox "checkar/descheckar" */
        $("#checkAll").on("click", function() {
            if ($(this).is(":checked")) {
                $(".check_nota").prop("checked", true);
            } else {
                $(".check_nota").prop("checked", false);
            }
        });

        $("#btnConsultar").on("click", function() {
            console.log("tamara");
            $("#titulo_modal_success").html("Aguarde, consulta sendo realizada!");
            $("#modal_success").modal("show");
            $.ajax({
                url: "<?= $_SERVER['localhost'] ?>/mmflow/_man/rest_api/arquiveiDFe/requestArquivei.php",
                method: "post",
                dataType: "text",
                data: {
                    op: "retorna_detalhes"
                },
                error: function () {
                    $("#mensagem_erro").html("Ocorreu um erro imprevisto ao enviar os dados para o banco. Por favor, contate o administrador do sistema.");
                    $("#modal_erro").modal("show");
                },
                success: function(retorno) {
                    console.log(retorno);
                    if (retorno.trim() == "OK") {
                        console.log( "retornou ok " );
                        $("#titulo_modal_success").html("Operação realizada com sucesso!");
                        $("#modal_success").modal("show");
                        setTimeout(function () {
                            $("#modal_success").modal("hide");
                            history.go(0);
                        }, 1000);
                    } else {
                        $("#mensagem_erro").html("Não foi possível completar a operação, tente novamente!<br/><br/>" + retorno );
                        $("#modal_erro").modal("show");
                    }
                }
            });
        });

        /** ABRE O MODAL DETALHES DA NOTA */
        var _tr_td = "";
        var id;
        $(document).on("click", ".openDetalhes", function() {
            id = this.id;
            $("#table_modal tbody").empty();
            $(document).find("#dados-gerais-tab,#dados-gerais").prop("selected",true);
            $("#modalDetalhesNota").modal("show");
        });

        /* FECHA O MODAL DAS NOTAS */
        $('#modalDetalhesNota').on('hidden.bs.modal', function(event) {
            $(this).removeData('bs.modal');
        });


        /* ABRE O MODAL DAS NOTAS */
        $('#modalDetalhesNota').on('show.bs.modal', function(event) {
            _tr_td = "";
            $.ajax({
                url: $("#frmDados").prop("action"),
                method: "post",
                dataType: "json",
                data: {
                    op: "retorna_detalhes",
                    id: id
                },
                success: function(retorno) {
                    var dados = Object.keys(retorno); // Array com as chaves do array

                    // Loop do array
                    $.each(dados, function() {
                        var value = this;
                        $("#" + value).val(retorno[value]); // Determina valor para os inputs 
                    });

                    // Loop do array item
                    var i = 0;
                    var item;
                    
                    var _num_item;
                    $.each(retorno.item, function() {
                        item_key = Object.keys(retorno.item[i]); // Array com as chaves do array do item
                        item = retorno.item[i];
                        _tr_td = '';
                        $.each(item_key, function() {
                            var value_ = this;
                            _num_item = item['num_item'];

                            _tr_td = '\n\
                            <td>\n\
                                <button class="openDetalhes btn btn-info btn-sm btnStyle" id="show_'+ _num_item +'" title="Clique para visualizar mais."><span class="fas fa-plus"></span></button>\n\
                            </td>\n\
                            <td>' + item["cod_prod"]    + '</td>\n\
                            <td>' + item["descricao"]   + '</td>\n\
                            <td>' + item["unidade"]     + '</td>\n\
                            <td>' + item["quantidade"]  + '</td>\n\
                            <td>' + item["v_unitario"]  + '</td>\n\
                            <td>' + item["v_produto"]   + '</td>\n\
                            <td>' + item["cfop"]        + '</td>\n\
                            <td>' + _num_item           + '</td>';
                        });
                        /* chama a função que alimenta a tabela dos itens */
                        _tr(_tr_td, _num_item, retorno.item[i]);
                        i++;
                    });
                }
            });
        });

        /** ABRE OS DETALHES DOS ITENS NO MODAL */
        $(document).on("button[id^=show_]").click(function(event) {
            event.preventDefault();
            var target = $(document).find(event.target);
            var id = target.attr('id').substr(5);
            $(document).find("#extra_" + id).slideToggle("slow");
        });

        // $(document).on("button[class^=show_]").click(function(event) {
        //     event.preventDefault();
        //     var target = $(document).find(event.target);
        //     var id = target.attr('id').substr(5);
        //     $(document).find("#extra_" + id).slideToggle("slow");
        // });
    });

    function _tr(corpo_div, valor, item) {
        var tr = '\n\
        <tr>\n\
            ' + corpo_div + '\n\
        </tr>\n\
        <tr>\n\
            <td colspan="9">\n\
                <div id="extra_' + valor + '" style="display: none;" class="row form-group col-lg-12">\n\
                    <div class="row form-group col-lg-12">\n\
                        <div class="col-lg-4">\n\
                            <label for="ncm_' + valor + '"> NCM </label>\n\
                            <input type="text" class="form-control" name="ncm_' + valor + '" id="ncm_' + valor + '" value="' + item['ncm'] + '">\n\
                        </div>\n\
                        <div class="col-lg-4">\n\
                            <label for="cod_fci_' + valor + '"> Número FCI </label>\n\
                            <input type="text" class="form-control" name="cod_fci_' + valor + '" id="cod_fci_' + valor + '" value="">\n\
                        </div>\n\
                        <div class="col-sm-4">\n\
                            <label for="ie_subst_tribu_emit_' + valor + '">Indicador de Comp. Valor Total NFe:</label>\n\
                            <input type="text" class="form-control" id="ie_subst_tribu_emit_' + valor + '" name="ie_subst_tribu_emit_' + valor + '" value=""/>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row form-group col-lg-12">\n\
                        <div class="col-sm-2">\n\
                            <label for="v_frete_' + valor + '"> Vl Frete </label>\n\
                            <input type="text" class="form-control" name="v_frete_' + valor + '" id="v_frete_' + valor + '" value="' + item['v_frete'] + '">\n\
                        </div>\n\
                        <div class="col-sm-2">\n\
                            <label for="v_seguro_' + valor + '"> Vl Seguro </label>\n\
                            <input type="text" class="form-control" name="v_seguro_' + valor + '" id="v_seguro_' + valor + '" value="' + item['v_seguro'] + '">\n\
                        </div>\n\
                        <div class="col-sm-2">\n\
                            <label for="v_desconto_' + valor + '"> Vl Desconto </label>\n\
                            <input type="text" class="form-control" name="v_desconto_' + valor + '" id="v_desconto_' + valor + '" value="' + item['v_desconto'] + '">\n\
                        </div>\n\
                        <div class="col-sm-2">\n\
                            <label for="v_outras_' + valor + '"> Vl Outras Desp. </label>\n\
                            <input type="text" class="form-control" name="v_outras_' + valor + '" id="v_outras_' + valor + '" value="' + item['v_outras'] + '">\n\
                        </div>\n\
                        <div class="col-sm-2">\n\
                            <label for="v_tot_trib_' + valor + '"> Vl Aprox. Tributos </label>\n\
                            <input type="text" class="form-control" name="v_tot_trib_' + valor + '" id="v_tot_trib_' + valor + '" value="0,00">\n\
                        </div>\n\
                    </div>\n\
                    <div class="row form-group col-lg-12">\n\
                        <div class="col-sm-3">\n\
                            <label for="cod_ean">Código EAN Comercial:</label>\n\
                            <input type="text" class="form-control" id="cod_ean_' + valor + '" name="cod_ean" value="' + item['cod_ean'] + '"/>\n\
                        </div>\n\
                        <div class="col-sm-3">\n\
                            <label for="v_unitario">Unidade Comercial:</label>\n\
                            <input type="text" class="form-control" id="v_unitario_' + valor + '" name="v_unitario" value="' + item['v_unitario'] + '"/>\n\
                        </div>\n\
                        <div class="col-sm-3">\n\
                            <label for="quantidade">Quantidade Comercial:</label>\n\
                            <input type="text" class="form-control" id="quantidade_' + valor + '" name="quantidade" value="' + item['quantidade'] + '"/>\n\
                        </div>\n\
                        <div class="col-sm-3">\n\
                            <label for="v_unitario">Valor Unit. Comercial:</label>\n\
                            <input type="text" class="form-control" id="v_unitario_' + valor + '" name="v_unitario" value="' + item['v_unitario'] + '"/>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row form-group col-lg-12">\n\
                        <div class="col-sm-3">\n\
                            <label for="cod_ean_trib">Código EAN Tributável:</label>\n\
                            <input type="text" class="form-control" id="cod_ean_trib_' + valor + '" name="cod_ean_trib" value="' + item['cod_ean_trib'] + '"/>\n\
                        </div>\n\
                        <div class="col-sm-3">\n\
                            <label for="unidade_trib">Unidade Tributável:</label>\n\
                            <input type="text" class="form-control" id="unidade_trib_' + valor + '" name="unidade_trib" value="' + item['unidade_trib'] + '"/>\n\
                        </div>\n\
                        <div class="col-sm-3">\n\
                            <label for="quantidade_trib">Quantidade Tributável:</label>\n\
                            <input type="text" class="form-control" id="quantidade_trib_' + valor + '" name="quantidade_trib value="' + item['quantidade_trib'] + '""/>\n\
                        </div>\n\
                        <div class="col-sm-3">\n\
                            <label for="v_unitario_trib">Valor Unit. Tributável:</label>\n\
                            <input type="text" class="form-control" id="v_unitario_trib_' + valor + '" name="v_unitario_trib" value="' + item['v_unitario_trib'] + '"/>\n\
                        </div>\n\
                    </div>\n\
                    <div class="row form-group col-lg-12">\n\
                        <fieldset>\n\
                            <legend> ICMS </legend>\n\
                            <div class="row form-group col-sm-12">\n\
                                <div class="col-sm-3">\n\
                                    <label for="cst_origem">CST ICMS Origem:</label>\n\
                                    <input type="text" class="form-control" id="cst_origem_' + valor + '" name="cst_origem" value="' + item['cst_origem'] + '"/>\n\
                                </div>\n\
                                <div class="col-sm-3">\n\
                                    <label for="cst_trib">CST ICMS Trib.:</label>\n\
                                    <input type="text" class="form-control" id="cst_trib_' + valor + '" name="cst_trib" value="' + item['cst_trib'] + '"/>\n\
                                </div>\n\
                                <div class="col-sm-3">\n\
                                    <label for="mod_bc">Modalidade:</label>\n\
                                    <input type="text" class="form-control" id="mod_bc" name="mod_bc" value="' + item['mod_bc'] + '"/>\n\
                                </div>\n\
                                <div class="col-sm-3">\n\
                                    <label for="v_unitario_trib">Valor Unit. Tributável:</label>\n\
                                    <input type="text" class="form-control" id="v_unitario_trib_' + valor + '" name="v_unitario_trib" value="' + item['v_unitario_trib'] + '"/>\n\
                                </div>\n\
                            </div>\n\
                            <div class="row form-group col-sm-12">\n\
                                <div class="col-sm-3">\n\
                                    <label for="bc_icms">Base de Cálculo</label>\n\
                                    <input type="text" class="form-control" id="bc_icms_' + valor + '" name="bc_icms" value="' + item['bc_icms'] + '"/>\n\
                                </div>                                                                                   \n\
                                <div class="col-sm-3">\n\
                                    <label for="aliq_icms">Aliquota:</label>\n\
                                    <input type="text" class="form-control" id="aliq_icms_' + valor + '" name="aliq_icms" value="' + item['aliq_icms'] + '"/>\n\
                                </div>                                                                                                    \n\
                                <div class="col-sm-3">\n\
                                    <label for="v_icms">Valor:</label>\n\
                                    <input type="text" class="form-control" id="v_icms_' + valor + '" name="v_icms" value="' + item['v_icms'] + '"/>\n\
                                </div>                                                                                                    \n\
                                <div class="col-sm-3">\n\
                                    <label for="outras_icms">Outras:</label>\n\
                                    <input type="text" class="form-control" id="outras_icms_' + valor + '" name="outras_icms" value="0,00"/>\n\
                                </div>     \n\
                                <div class="col-sm-3">\n\
                                    <label for="isento_icms">Isentas:</label>\n\
                                    <input type="text" class="form-control" id="isento_icms_' + valor + '" name="isento_icms" value="0,00"/>\n\
                                </div>     \n\
                            </div>   \n\
                            <div class="row form-group col-sm-12">                                                                                         \n\
                                <div class="col-sm-6">\n\
                                    <label for="aliq_fcp">Percentual do Fundo de Combate à Pobreza (FCP)</label>\n\
                                    <input type="text" class="form-control" id="aliq_fcp_' + valor + '" name="aliq_fcp" value="0,00"/>\n\
                                </div>                                                                                   \n\
                                <div class="col-sm-6">\n\
                                    <label for="v_fcp">Valor do Fundo de Combate à Pobreza (FCP):</label>\n\
                                    <input type="text" class="form-control" id="v_fcp_' + valor + '" name="v_fcp" value="0,00"/>\n\
                                </div>                                                                                                                                                                    \n\
                            </div>   \n\
                        </fieldset>                                                                                            \n\
                    </div>\n\
                    <div class="row form-group col-lg-12">  \n\
                        <fieldset> \n\
                            <legend> IPI </legend>     \n\
                            <div class="row form-group col-sm-12">                                                                              \n\
                                <div class="col-sm-6">\n\
                                    <label for="cod_enquad">Código de Enquadramento:</label>\n\
                                    <input type="text" class="form-control" id="cod_enquad_' + valor + '" name="cod_enquad" value="' + item['cod_enquad'] + '"/>\n\
                                </div>                                                                                                    \n\
                                <div class="col-sm-6">\n\
                                    <label for="cst_ipi">CST:</label>\n\
                                    <input type="text" class="form-control" id="cst_ipi_' + valor + '" name="cst_ipi" value="' + item['cst_ipi'] + '"/>\n\
                                </div>   \n\
                            </div>   \n\
                            <div class="row form-group col-sm-12">                                                                                         \n\
                                <div class="col-sm-3">\n\
                                    <label for="bc_ipi">Base de Cálculo</label>\n\
                                    <input type="text" class="form-control" id="bc_ipi_' + valor + '" name="bc_ipi" value="' + item['bc_ipi'] + '"/>\n\
                                </div>                                                                                   \n\
                                <div class="col-sm-3">\n\
                                    <label for="aliq_ipi">Aliquota:</label>\n\
                                    <input type="text" class="form-control" id="aliq_ipi_' + valor + '" name="aliq_ipi" value="' + item['aliq_ipi'] + '"/>\n\
                                </div>                                                                                                    \n\
                                <div class="col-sm-3">\n\
                                    <label for="v_ipi">Valor:</label>\n\
                                    <input type="text" class="form-control" id="v_ipi_' + valor + '" name="v_ipi" value="' + item['v_ipi'] + '"/>\n\
                                </div>                                                                                                    \n\
                                <div class="col-sm-3">\n\
                                    <label for="outras_ipi">Outras:</label>\n\
                                    <input type="text" class="form-control" id="outras_ipi_' + valor + '" name="outras_ipi" value="0,00"/>\n\
                                </div>     \n\
                                <div class="col-sm-3">\n\
                                    <label for="isento_ipi">Isentas:</label>\n\
                                    <input type="text" class="form-control" id="isento_ipi_' + valor + '" name="isento_ipi" value="0,00"/>\n\
                                </div>     \n\
                            </div>\n\
                        </fieldset>                                                                                            \n\
                    </div>\n\
                    <div class="row form-group col-lg-12">  \n\
                        <fieldset> \n\
                            <legend> PIS </legend>                                                                           \n\
                            <div class="row form-group col-sm-12">   \n\
                                <div class="col-sm-3">\n\
                                    <label for="cst_pis">CST:</label>\n\
                                    <input type="text" class="form-control" id="cst_pis_' + valor + '" name="cst_pis" value="' + item['cst_pis'] + '"/>\n\
                                </div>                                                                                       \n\
                                <div class="col-sm-3">\n\
                                    <label for="bc_pis">Base de Cálculo</label>\n\
                                    <input type="text" class="form-control" id="bc_pis_' + valor + '" name="bc_pis" value="' + item['bc_pis'] + '"/>\n\
                                </div>                                                                                   \n\
                                <div class="col-sm-3">\n\
                                    <label for="aliq_pis">Aliquota:</label>\n\
                                    <input type="text" class="form-control" id="aliq_pis_' + valor + '" name="aliq_pis" value="' + item['aliq_pis'] + '"/>\n\
                                </div>                                                                                                    \n\
                                <div class="col-sm-3">\n\
                                    <label for="v_pis">Valor:</label>\n\
                                    <input type="text" class="form-control" id="v_pis_' + valor + '" name="v_pis" value="' + item['v_pis'] + '"/>\n\
                                </div>\n\
                            </div>\n\
                        </fieldset>                                                                                            \n\
                    </div>\n\
                    <div class="row form-group col-lg-12">  \n\
                        <fieldset> \n\
                            <legend> COFINS </legend>                                                                           \n\
                            <div class="row form-group col-sm-12">   \n\
                                <div class="col-sm-3">\n\
                                    <label for="cst_cofins">CST:</label>\n\
                                    <input type="text" class="form-control" id="cst_cofins_' + valor + '" name="cst_cofins" value="' + item['cst_cofins'] + '"/>\n\
                                </div>                                                                                       \n\
                                <div class="col-sm-3">\n\
                                    <label for="bc_cofins">Base de Cálculo</label>\n\
                                    <input type="text" class="form-control" id="bc_cofins_' + valor + '" name="bc_cofins" value="' + item['bc_cofins'] + '"/>\n\
                                </div>                                                                                   \n\
                                <div class="col-sm-3">\n\
                                    <label for="aliq_cofins">Aliquota:</label>\n\
                                    <input type="text" class="form-control" id="aliq_cofins_' + valor + '" name="aliq_cofins" value="' + item['aliq_cofins'] + '"/>\n\
                                </div>                                                                                                    \n\
                                <div class="col-sm-3">\n\
                                    <label for="v_cofins">Valor:</label>\n\
                                    <input type="text" class="form-control" id="v_cofins_' + valor + '" name="v_cofins" value="' + item['v_cofins'] + '"/>\n\
                                </div>\n\
                            </div>\n\
                        </fieldset>                                                                                            \n\
                    </div>\n\
                </div>\n\
            </td>\n\
        <tr>';

        $("#table_modal tbody").append(tr);
    }
</script>