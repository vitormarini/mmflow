<!-- Modal de Sucesso -->
<script type="text/javascript">
    function fMasc(objeto, mascara) {
        obj = objeto
        masc = mascara
        setTimeout("fMascEx()", 1)
    }

    function fMascEx() {
        obj.value = masc(obj.value)
    }

    function mCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, "")
        cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2")
        cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3")
        cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2")
        cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2")
        return cnpj
    }

    function mCPF(cpf) {
        cpf = cpf.replace(/\D/g, "")
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
        cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2")
        cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2")
        return cpf
    }

    function mNum(num) {
        num = num.replace(/\D/g, "")
        return num
    }

    function mascara(t, mask) {
        var i = t.value.length;
        var saida = mask.substring(1, 0);
        var texto = mask.substring(i)
        if (texto.substring(0, 1) != saida) {
            t.value += texto.substring(0, 1);
        }
    }
</script>
<script language="javascript">
    function moeda(a, e, r, t) {
        let n = "",
            h = j = 0,
            u = tamanho2 = 0,
            l = ajd2 = "",
            o = window.Event ? t.which : t.keyCode;
        if (13 == o || 8 == o)
            return !0;
        if (n = String.fromCharCode(o),
            -1 == "0123456789".indexOf(n))
            return !1;
        for (u = a.value.length,
            h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
        for (l = ""; h < u; h++)
            -
            1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
        if (l += n,
            0 == (u = l.length) && (a.value = ""),
            1 == u && (a.value = "0" + r + "0" + l),
            2 == u && (a.value = "0" + r + l),
            u > 2) {
            for (ajd2 = "",
                j = 0,
                h = u - 3; h >= 0; h--)
                3 == j && (ajd2 += e,
                    j = 0),
                ajd2 += l.charAt(h),
                j++;
            for (a.value = "",
                tamanho2 = ajd2.length,
                h = tamanho2 - 1; h >= 0; h--)
                a.value += ajd2.charAt(h);
            a.value += r + l.substr(u - 2, u)
        }
        return !1
    }
</script>
<div id="modal_success" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_success" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="margin-bottom-10">
                    <h2 class="modal-title text-center text-success" id="titulo_modal_success">Operação realizada com sucesso!</h2>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal de Erro Personalizado -->
<div id="modal_erro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_erro" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="margin-bottom-10">
                    <h2 class="modal-title text-center" id="titulo_modal_erro">Ops! Parece que temos um problema...</h2>
                </div>
                <div>
                    <div id="mensagem_erro" class="text-danger text-justify"></div>
                </div>
                <div class="margin-top-10 text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL DAS EMPRESAS -->
<div class="modal fade" id="modal_empresas" name="modal_empresas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ESCOLHA EMPRESA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <select class="form-control" id="empresa_modal" name="empresa_modal"></select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnContinuar" name="btnContinuar">Continuar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- MODAL PARA AVISOS OU CONFIRMAÇÃO -->
<div class="modal fade" id="modal_geral" name="modal_geral" aria-hidden="true" role="dialog" aria-labelledby="titulo_modal_geral">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="titulo_modal_geral"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="div_body" name="div_body">

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal visualiza nota -->
<div class="modal fade" id="modalDetalhesNota" name="modalDetalhesNota">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Detalhes NF-e</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <fieldset>
                            <legend> DADOS GERAIS </legend>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-9">
                                    <label for="chave_acesso_">Chave de Acesso:</label>
                                    <input type="text" class="form-control" id="chave_acesso_" name="chave_acesso_" placeholder="Chave de Acesso" />
                                </div>
                                <div class="col-sm-3">
                                    <label for="numero_nfe_">Número:</label>
                                    <input type="text" class="form-control" id="numero_nfe_" name="numero_nfe_" />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dados-gerais-tab" data-toggle="pill" href="#dados-gerais" role="tab" aria-controls="dados-gerais" aria-selected="true"> NFe </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-emitente-tab" data-toggle="pill" href="#dados-emitente" role="tab" aria-controls="dados-emitente" aria-selected="false"> Emitente </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-produtos-servicos-tab" data-toggle="pill" href="#dados-produtos-servicos" role="tab" aria-controls="dados-produtos-servicos" aria-selected="false"> Produtos/Serviços </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-totais-tab" data-toggle="pill" href="#dados-totais" role="tab" aria-controls="dados-totais" aria-selected="false"> Totais </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-transporte-tab" data-toggle="pill" href="#dados-transporte" role="tab" aria-controls="dados-transporte" aria-selected="false"> Transporte </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-duplicata-tab" data-toggle="pill" href="#dados-duplicata" role="tab" aria-controls="dados-duplicata" aria-selected="false"> Duplicata </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-info-gerais-tab" data-toggle="pill" href="#dados-info-gerais" role="tab" aria-controls="dados-info-gerais" aria-selected="false"> Informações Gerais </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="dados-gerais" role="tabpanel" aria-labelledby="dados-gerais-tab">
                                        <fieldset>
                                            <legend> Dados da NF-e </legend>
                                            <div class="row form-group col-lg-12">

                                                <div class="col-sm-2">
                                                    <label for="modelo_"> Modelo: </label>
                                                    <input type="text" class="form-control" id="modelo_" name="modelo_" onkeydown="javascript: fMasc( this, mNum );" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="serie_">Série:</label>
                                                    <input type="text" class="form-control" id="serie_" name="serie_" onkeydown="javascript: fMasc( this, mNum );" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="dt_emissao_">Data de Emissão:</label>
                                                    <input type="text" class="form-control" id="dt_emissao_" name="dt_emissao_" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="dt_saida_entr_">Data Saída/Entrada:</label>
                                                    <input type="text" class="form-control" id="dt_saida_entr_" name="dt_saida_entr_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="vl_total_">Valor Total da NFe:</label>
                                                    <input type="text" class="form-control" id="vl_total_" name="vl_total_" />
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend> Destinatário </legend>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-3">
                                                    <label for="cpf_cnpj_dest_"> CPF/CNPJ: </label>
                                                    <input type="text" class="form-control" id="cpf_cnpj_dest_" name="cpf_cnpj_dest_" onkeydown="javascript: fMasc( this, mNum );" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="razao_social_dest_">Nome/Razão Social:</label>
                                                    <input type="text" class="form-control" id="razao_social_dest_" name="razao_social_dest_" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="consumidor_final_dest_"> Consumidor final: </label>
                                                    <input type="text" class="form-control" id="consumidor_final_dest_" name="consumidor_final_dest_" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-5">
                                                    <label for="endereco_dest_"> Endereço: </label>
                                                    <input type="text" class="form-control" id="endereco_dest_" name="endereco_dest_" />
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="bairro_dest_">Bairro/Distrito:</label>
                                                    <input type="text" class="form-control" id="bairro_dest_" name="bairro_dest_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="cep_dest_">CEP:</label>
                                                    <input type="text" class="form-control" id="cep_dest_" name="cep_dest_" onkeydown="javascript: fMasc( this, mNum );" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-5">
                                                    <label for="municipio_dest_">Município:</label>
                                                    <input type="text" class="form-control" id="municipio_dest_" name="municipio_dest_" />
                                                </div>

                                                <div class="col-sm-2">
                                                    <label for="telefone_dest_"> Telefone: </label>
                                                    <input type="text" class="form-control" id="telefone_dest_" name="telefone_dest_" />
                                                </div>
                                                <div class="col-sm-1">
                                                    <label for="uf_dest_">UF:</label>
                                                    <input type="text" class="form-control" id="uf_dest_" name="uf_dest_" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="pais_dest_">País:</label>
                                                    <input type="text" class="form-control" id="pais_dest_" name="pais_dest_" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-4">
                                                    <label for="indicador_ie_dest_">Indicador IE:</label>
                                                    <select type="text" class="form-control" id="indicador_ie_dest_" name="indicador_ie_dest_">
                                                        <option>Selecione</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="insc_estadual_dest_">Inscrição Estadual:</label>
                                                    <input type="text" class="form-control" id="insc_estadual_dest_" name="insc_estadual_dest_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="insc_suframa_dest_">Inscrição SUFRAMA:</label>
                                                    <input type="text" class="form-control" id="insc_suframa_dest_" name="insc_suframa_dest_" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="email_dest_">E-mail:</label>
                                                    <input type="text" class="form-control" id="email_dest_" name="email_dest_" />
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend> Emissão </legend>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-2">
                                                    <label for="tipo_emissao_"> Tipo de Emissão: </label>
                                                    <input type="text" class="form-control" id="tipo_emissao_" name="tipo_emissao_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="finalidade_"> Finalidade:</label>
                                                    <input type="text" class="form-control" id="finalidade_" name="finalidade_" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="nat_oper_">Natureza de Operação:</label>
                                                    <input type="text" class="form-control" id="nat_oper_" name="nat_oper_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="tipo_operacao_">Tipo de Operação :</label>
                                                    <input type="text" class="form-control" id="tipo_operacao_" name="tipo_operacao_" />
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="tab-pane fade" id="dados-emitente" role="tabpanel" aria-labelledby="dados-emitente-tab">
                                        <fieldset>
                                            <legend> Emitente </legend>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-4">
                                                    <label for="cpf_cnpj_emit_"> CPF/CNPJ: </label>
                                                    <input type="text" class="form-control" id="cpf_cnpj_emit_" name="cpf_cnpj_emit_" />
                                                </div>
                                                <div class="col-sm-8">
                                                    <label for="razao_social_emit_">Nome/Razão Social:</label>
                                                    <input type="text" class="form-control" id="razao_social_emit_" name="razao_social_emit_" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-5">
                                                    <label for="endereco_emit_"> Endereço: </label>
                                                    <input type="text" class="form-control" id="endereco_emit_" name="endereco_emit_" />
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="bairro_emit_">Bairro/Distrito:</label>
                                                    <input type="text" class="form-control" id="bairro_emit_" name="bairro_emit_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="cep_emit_">CEP:</label>
                                                    <input type="text" class="form-control" id="cep_emit_" name="cep_emit_" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-4">
                                                    <label for="municipio_emit_">Município:</label>
                                                    <input type="text" class="form-control" id="municipio_emit_" name="municipio_emit_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="telefone_emit_"> Telefone: </label>
                                                    <input type="text" class="form-control" id="telefone_emit_" name="telefone_emit_" onkeypress="mascara(this, '## ####-####')" />
                                                </div>
                                                <div class="col-sm-1">
                                                    <label for="uf_emit_">UF:</label>
                                                    <input type="text" class="form-control" id="uf_emit_" name="uf_emit_" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="pais_emit_">País:</label>
                                                    <input type="text" class="form-control" id="pais_emit_" name="pais_emit_" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="insc_estadual_emit_">Inscrição Estadual:</label>
                                                    <input type="text" class="form-control" id="insc_estadual_emit_" name="insc_estadual_emit_" onkeydown="javascript: fMasc( this, mNum );" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-3">
                                                    <label for="ie_subst_tribu_emit_">IE do Substituto Tributário:</label>
                                                    <input type="text" class="form-control" id="ie_subst_tribu_emit_" name="ie_subst_tribu_emit_" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="insc_municipal_emit_">Inscrição Municipal:</label>
                                                    <input type="text" class="form-control" id="insc_municipal_emit_" name="insc_municipal_emit_" onkeydown="javascript: fMasc( this, mNum );" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="cnae_fiscal_emit_">CNAE Fiscal:</label>
                                                    <input type="text" class="form-control" id="cnae_fiscal_emit_" name="cnae_fiscal_emit_" onkeydown="javascript: fMasc( this, mNum );" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="cod_regime_trib_emit_">Código de Regime Tributário:</label>
                                                    <select class="form-control" id="cod_regime_trib_emit_" name="cod_regime_trib_emit_">
                                                        <option value=""> SELECIONE </option>
                                                        <option value="1"> 1 - Simples Nacional </option>
                                                        <option value="2"> 2 - Simples Nacional - excesso de sublimite da receita bruta</option>
                                                        <option value="3"> 3 - Regime Nacional </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="tab-pane fade" id="dados-produtos-servicos" role="tabpanel" aria-labelledby="dados-produtos-servicos-tab">
                                        <div class="row form-group col-lg-12">
                                            <table id="table_modal" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="05%"> # </th>
                                                        <th class="text-center" width="10%"> Código </th>
                                                        <th class="text-center" width="23%"> Descrição </th>
                                                        <th class="text-center" width="05%"> Unid. </th>
                                                        <th class="text-center" width="09%"> Qtde. </th>
                                                        <th class="text-center" width="09%"> Valor Unit. </th>
                                                        <th class="text-center" width="09%"> Valor Total </th>
                                                        <th class="text-center" width="05%"> CFOP </th>
                                                        <th class="text-center" width="25%"> Nat. Operação </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- <tr>
                                                        <td>
                                                            <a href="#" id="show_1"> Show Extra </a>
                                                        </td>
                                                        <td class="cod_prod">   codigo          </td>
                                                        <td class="descricao">  descricao       </td>
                                                        <td class="unidade">    unid            </td>
                                                        <td class="quantidade"> quantidade      </td>
                                                        <td class="v_unitario"> unit            </td>
                                                        <td class="v_produto">  total           </td>
                                                        <td class="cfop">       cfop            </td>
                                                        <td class="nat_oper">   nat oper        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">
                                                            <div id="extra_1" style="display: none;" class="row form-group col-lg-12">
                                                                <div class="row form-group col-lg-12">
                                                                    <div class="col-lg-4">
                                                                        <label for="ncm"> NCM </label>
                                                                        <input type="text" class="form-control" name="ncm" id="ncm">
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <label for="cod_ncm"> Número FCI </label>
                                                                        <input type="text" class="form-control" name="cod_ncm" id="cod_ncm">
                                                                    </div>
                                                                    <div class="col-sm-4">
                                                                        <label for="ie_subst_tribu_emit_">Indicador de Comp. Valor Total NFe:</label>
                                                                        <input type="text" class="form-control" id="ie_subst_tribu_emit_" name="ie_subst_tribu_emit_"/>
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group col-lg-12">
                                                                    <div class="col-sm-2">
                                                                        <label for="v_frete"> Vl Frete </label>
                                                                        <input type="text" class="form-control" name="v_frete" id="v_frete">
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <label for="v_seguro"> Vl Seguro </label>
                                                                        <input type="text" class="form-control" name="v_seguro" id="v_seguro">
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <label for="v_desconto"> Vl Desconto </label>
                                                                        <input type="text" class="form-control" name="v_desconto" id="v_desconto">
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <label for="v_outras"> Vl Outras Desp. </label>
                                                                        <input type="text" class="form-control" name="v_outras" id="v_outras">
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <label for="v_tot_trib"> Vl Aprox. Tributos </label>
                                                                        <input type="text" class="form-control" name="v_tot_trib" id="v_tot_trib">
                                                                    </div>
                                                                </div>                                                      
                                                                <div class="row form-group col-lg-12">                                                                                                 
                                                                    <div class="col-sm-3">
                                                                        <label for="cod_ean">Código EAN Comercial:</label>
                                                                        <input type="text" class="form-control" id="cod_ean" name="cod_ean"/>
                                                                    </div>                                                                                   
                                                                    <div class="col-sm-3">
                                                                        <label for="cnae_fiscal_emit_">Unidade Comercial:</label>
                                                                        <input type="text" class="form-control" id="cnae_fiscal_emit_" name="cnae_fiscal_emit_"/>
                                                                    </div>                                                                                                    
                                                                    <div class="col-sm-3">
                                                                        <label for="quantidade">Quantidade Comercial:</label>
                                                                        <input type="text" class="form-control" id="quantidade" name="quantidade"/>
                                                                    </div>                                                                                                    
                                                                    <div class="col-sm-3">
                                                                        <label for="v_unitario">Valor Unit. Comercial:</label>
                                                                        <input type="text" class="form-control" id="v_unitario" name="v_unitario"/>
                                                                    </div>                                                                                                    
                                                                </div>
                                                                <div class="row form-group col-lg-12">                                                                                                 
                                                                    <div class="col-sm-3">
                                                                        <label for="cod_ean_trib">Código EAN Tributável:</label>
                                                                        <input type="text" class="form-control" id="cod_ean_trib" name="cod_ean_trib"/>
                                                                    </div>                                                                                   
                                                                    <div class="col-sm-3">
                                                                        <label for="unidade_trib">Unidade Tributável:</label>
                                                                        <input type="text" class="form-control" id="unidade_trib" name="unidade_trib"/>
                                                                    </div>                                                                                                    
                                                                    <div class="col-sm-3">
                                                                        <label for="quantidade_trib">Quantidade Tributável:</label>
                                                                        <input type="text" class="form-control" id="quantidade_trib" name="quantidade_trib"/>
                                                                    </div>                                                                                                    
                                                                    <div class="col-sm-3">
                                                                        <label for="v_unitario_trib">Valor Unit. Tributável:</label>
                                                                        <input type="text" class="form-control" id="v_unitario_trib" name="v_unitario_trib"/>
                                                                    </div>                                                                                                    
                                                                </div>
                                                                <div class="row form-group col-lg-12">  
                                                                    <fieldset> 
                                                                        <legend> ICMS </legend>     
                                                                        <div class="row form-group col-sm-12">                                                                                         
                                                                            <div class="col-sm-3">
                                                                                <label for="cst_origem">CST ICMS Origem:</label>
                                                                                <input type="text" class="form-control" id="cst_origem" name="cst_origem"/>
                                                                            </div>                                                                                   
                                                                            <div class="col-sm-3">
                                                                                <label for="cst_trib">CST ICMS Trib.:</label>
                                                                                <input type="text" class="form-control" id="cst_trib" name="cst_trib"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="mod_bc">Modalidade:</label>
                                                                                <input type="text" class="form-control" id="mod_bc" name="mod_bc"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="cnae_fiscal_emit_">Valor Unit. Tributável:</label>
                                                                                <input type="text" class="form-control" id="cnae_fiscal_emit_" name="cnae_fiscal_emit_"/>
                                                                            </div>     
                                                                        </div>   
                                                                        <div class="row form-group col-sm-12">                                                                                         
                                                                            <div class="col-sm-3">
                                                                                <label for="bc_icms">Base de Cálculo</label>
                                                                                <input type="text" class="form-control" id="bc_icms" name="bc_icms"/>
                                                                            </div>                                                                                   
                                                                            <div class="col-sm-3">
                                                                                <label for="aliq_icms">Aliquota:</label>
                                                                                <input type="text" class="form-control" id="aliq_icms" name="aliq_icms"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="v_icms">Valor:</label>
                                                                                <input type="text" class="form-control" id="v_icms" name="v_icms"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="outras_icms">Outras:</label>
                                                                                <input type="text" class="form-control" id="outras_icms" name="outras_icms"/>
                                                                            </div>     
                                                                            <div class="col-sm-3">
                                                                                <label for="isento_icms">Isentas:</label>
                                                                                <input type="text" class="form-control" id="isento_icms" name="isento_icms"/>
                                                                            </div>     
                                                                        </div>   
                                                                        <div class="row form-group col-sm-12">                                                                                         
                                                                            <div class="col-sm-6">
                                                                                <label for="aliq_fcp">Percentual do Fundo de Combate à Pobreza (FCP)</label>
                                                                                <input type="text" class="form-control" id="aliq_fcp" name="aliq_fcp"/>
                                                                            </div>                                                                                   
                                                                            <div class="col-sm-6">
                                                                                <label for="v_fcp">Valor do Fundo de Combate à Pobreza (FCP):</label>
                                                                                <input type="text" class="form-control" id="v_fcp" name="v_fcp"/>
                                                                            </div>                                                                                                                                                                    
                                                                        </div>   
                                                                    </fieldset>                                                                                            
                                                                </div>
                                                                <div class="row form-group col-lg-12">  
                                                                    <fieldset> 
                                                                        <legend> IPI </legend>     
                                                                        <div class="row form-group col-sm-12">                                                                              
                                                                            <div class="col-sm-6">
                                                                                <label for="cod_enquad">Código de Enquadramento:</label>
                                                                                <input type="text" class="form-control" id="cod_enquad" name="cod_enquad"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-6">
                                                                                <label for="cst_ipi">CST:</label>
                                                                                <input type="text" class="form-control" id="cst_ipi" name="cst_ipi"/>
                                                                            </div>   
                                                                        </div>   
                                                                        <div class="row form-group col-sm-12">                                                                                         
                                                                            <div class="col-sm-3">
                                                                                <label for="bc_ipi">Base de Cálculo</label>
                                                                                <input type="text" class="form-control" id="bc_ipi" name="bc_ipi"/>
                                                                            </div>                                                                                   
                                                                            <div class="col-sm-3">
                                                                                <label for="aliq_ipi">Aliquota:</label>
                                                                                <input type="text" class="form-control" id="aliq_ipi" name="aliq_ipi"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="v_ipi">Valor:</label>
                                                                                <input type="text" class="form-control" id="v_ipi" name="v_ipi"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="outras_ipi">Outras:</label>
                                                                                <input type="text" class="form-control" id="outras_ipi" name="outras_ipi"/>
                                                                            </div>     
                                                                            <div class="col-sm-3">
                                                                                <label for="isento_ipi">Isentas:</label>
                                                                                <input type="text" class="form-control" id="isento_ipi" name="isento_ipi"/>
                                                                            </div>     
                                                                        </div>
                                                                    </fieldset>                                                                                            
                                                                </div>
                                                                <div class="row form-group col-lg-12">  
                                                                    <fieldset> 
                                                                        <legend> PIS </legend>                                                                           
                                                                        <div class="row form-group col-sm-12">   
                                                                            <div class="col-sm-3">
                                                                                <label for="cst_pis">CST:</label>
                                                                                <input type="text" class="form-control" id="cst_pis" name="cst_pis"/>
                                                                            </div>                                                                                       
                                                                            <div class="col-sm-3">
                                                                                <label for="bc_pis">Base de Cálculo</label>
                                                                                <input type="text" class="form-control" id="bc_pis" name="bc_pis"/>
                                                                            </div>                                                                                   
                                                                            <div class="col-sm-3">
                                                                                <label for="aliq_pis">Aliquota:</label>
                                                                                <input type="text" class="form-control" id="aliq_pis" name="aliq_pis"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="v_pis">Valor:</label>
                                                                                <input type="text" class="form-control" id="v_pis" name="v_pis"/>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>                                                                                            
                                                                </div>
                                                                <div class="row form-group col-lg-12">  
                                                                    <fieldset> 
                                                                        <legend> COFINS </legend>                                                                           
                                                                        <div class="row form-group col-sm-12">   
                                                                            <div class="col-sm-3">
                                                                                <label for="cst_cofins">CST:</label>
                                                                                <input type="text" class="form-control" id="cst_cofins" name="cst_cofins"/>
                                                                            </div>                                                                                       
                                                                            <div class="col-sm-3">
                                                                                <label for="bc_cofins">Base de Cálculo</label>
                                                                                <input type="text" class="form-control" id="bc_cofins" name="bc_cofins"/>
                                                                            </div>                                                                                   
                                                                            <div class="col-sm-3">
                                                                                <label for="aliq_cofins">Aliquota:</label>
                                                                                <input type="text" class="form-control" id="aliq_cofins" name="aliq_cofins"/>
                                                                            </div>                                                                                                    
                                                                            <div class="col-sm-3">
                                                                                <label for="v_cofins">Valor:</label>
                                                                                <input type="text" class="form-control" id="v_cofins" name="v_cofins"/>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>                                                                                            
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="dados-totais" role="tabpanel" aria-labelledby="dados-totais-tab">
                                        <div class="row form-group col-lg-12">
                                            <fieldset class="col-lg-12">
                                                <legend> ICMS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="vl_desp_acessor_">O. Desp. Acessórias:</label>
                                                        <input type="text" class="form-control" id="vl_desp_acessor_" name="vl_desp_acessor_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_frete_">Valor do Frete:</label>
                                                        <input type="text" class="form-control" id="vl_frete_" name="vl_frete_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_seguro_">Valor do Seguro:</label>
                                                        <input type="text" class="form-control" id="vl_seguro_" name="vl_seguro_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_total_prod_">Valor Total dos Prod.:</label>
                                                        <input type="text" class="form-control" id="vl_total_prod_" name="vl_total_prod_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_total_nf_"> Valor Total da NFe: </label>
                                                        <input type="text" class="form-control" id="vl_total_nf_" name="vl_total_nf_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_aprox_tributos_">V. Aprox dos Tributos:</label>
                                                        <input type="text" class="form-control" id="vl_aprox_tributos_" name="vl_aprox_tributos_" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="col-lg-12">
                                                <legend> ICMS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="vl_bc_icms_"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="vl_bc_icms_" name="vl_bc_icms_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_aliq_icms_">Alíquota:</label>
                                                        <input type="text" class="form-control" id="vl_aliq_icms_" name="vl_aliq_icms_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_icms_">Valor:</label>
                                                        <input type="text" class="form-control" id="vl_icms_" name="vl_icms_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_outras_icms_">Outras:</label>
                                                        <input type="text" class="form-control" id="vl_outras_icms_" name="vl_outras_icms_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_isento_icms_">Isento:</label>
                                                        <input type="text" class="form-control" id="vl_isento_icms_" name="vl_isento_icms_" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="col-lg-12">
                                                <legend> IPI </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="vl_bc_ipi_"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="vl_bc_ipi_" name="vl_bc_ipi_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_aliq_ipi_">Alíquota:</label>
                                                        <input type="text" class="form-control" id="vl_aliq_ipi_" name="vl_aliq_ipi_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_ipi_">Valor:</label>
                                                        <input type="text" class="form-control" id="vl_ipi_" name="vl_ipi_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_outras_ipi_">Outras:</label>
                                                        <input type="text" class="form-control" id="vl_outras_ipi_" name="vl_outras_ipi_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_isento_ipi_">Isento:</label>
                                                        <input type="text" class="form-control" id="vl_isento_ipi_" name="vl_isento_ipi_" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="col-lg-6">
                                                <legend> PIS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-4">
                                                        <label for="vl_bc_pis_"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="vl_bc_pis_" name="vl_bc_pis_" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="vl_aliq_pis_">Alíquota:</label>
                                                        <input type="text" class="form-control" id="vl_aliq_pis_" name="aliq_pvl_aliq_pis_is" />
                                                    </div>
                                                    <div class="col-sm-4 fix-right">
                                                        <label for="vl_pis_">Valor:</label>
                                                        <input type="text" class="form-control" id="vl_pis_" name="vl_pis_" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="col-lg-6">
                                                <legend> COFINS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-4">
                                                        <label for="vl_bc_cofins_"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="vl_bc_cofins_" name="vl_bc_cofins_" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="vl_aliq_cofins_">Alíquota:</label>
                                                        <input type="text" class="form-control" id="vl_aliq_cofins_" name="vl_aliq_cofins_" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="vl_cofins_">Valor:</label>
                                                        <input type="text" class="form-control" id="vl_cofins_" name="vl_cofins_" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="col-lg-12">
                                                <legend> OUTROS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="vl_icms_deson_"> ICMS Desonerado: </label>
                                                        <input type="text" class="form-control" id="vl_icms_deson_" name="vl_icms_deson_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_fcp_"> FCP:</label>
                                                        <input type="text" class="form-control" id="vl_fcp_" name="vl_fcp_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_icms_fcp_"> ICMS FCP:</label>
                                                        <input type="text" class="form-control" id="vl_icms_fcp_" name="vl_icms_fcp_" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="vl_icms_inter_uf_dest_"> ICMS Interestadual UF Destino: </label>
                                                        <input type="text" class="form-control" id="vl_icms_inter_uf_dest_" name="m_bc_covl_icms_inter_uf_dest_fins" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="vl_icms_inter_uf_rem_"> ICMS Interestadual UF Rem.:</label>
                                                        <input type="text" class="form-control" id="vl_icms_inter_uf_rem_" name="vl_icms_inter_uf_rem_" />
                                                    </div>
                                                </div>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="vl_bc_icms_st_">B. de Cálculo ICMS ST:</label>
                                                        <input type="text" class="form-control" id="vl_bc_icms_st_" name="vl_bc_icms_st_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_icms_subst_"> ICMS Substituição: </label>
                                                        <input type="text" class="form-control" id="vl_icms_subst_" name="vl_icms_subst_" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="vl_fcp_retido_st_">FCP retido por ST:</label>
                                                        <input type="text" class="form-control" id="vl_fcp_retido_st_" name="vl_fcp_retido_st_" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="vl_retido_ant_st_">FCP retido anteriormente por ST:</label>
                                                        <input type="text" class="form-control" id="vl_retido_ant_st_" name="vl_retido_ant_st_" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="dados-transporte" role="tabpanel" aria-labelledby="dados-transporte-tab">
                                        <div class="row form-group col-lg-12">
                                            <fieldset class="col-lg-12">
                                                <legend class="col-lg-12"> DADOS DO TRANSPORTE </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-4">
                                                        <label for="mod_frete_transp_">Modalidade do Frete:</label>
                                                        <select type="text" class="form-control" id="mod_frete_transp_" name="mod_frete_transp_">
                                                            <option value=""> Selecione </option>
                                                            <option value="0"> 0 - Contratação do Frete por conta do Remetente (CIF); </option>
                                                            <option value="1"> 1 - Contratação do Frete por conta do Destinatário (FOB); </option>
                                                            <option value="2"> 2 - Contratação do Frete por conta de Terceiros; </option>
                                                            <option value="3"> 3 - Transporte Próprio por conta do Remetente; </option>
                                                            <option value="4"> 4 - Transporte Próprio por conta do Destinatário; </option>
                                                            <option value="9"> 9 - Sem Ocorrência de Transporte. </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="cpf_cnpj_transp_"> CPF/CNPJ: </label>
                                                        <input type="text" class="form-control" id="cpf_cnpj_transp_" name="cpf_cnpj_transp_" />
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <label for="razao_social_transp_"> Razão Social:</label>
                                                        <input type="text" class="form-control" id="razao_social_transp_" name="razao_social_transp_" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="dados-duplicata" role="tabpanel" aria-labelledby="dados-duplicata-tab">

                                    </div>
                                    <div class="tab-pane fade" id="dados-info-gerais" role="tabpanel" aria-labelledby="dados-info-gerais-tab">
                                        <div class="row form-group col-lg-12">
                                            <fieldset class="col-lg-12">
                                                <legend class="col-lg-12"> INFORMAÇÕES ADICIONAIS </legend>
                                                <textarea type="text" class="form-control" id="info_adicionais_" name="info_adicionais_" rows="5"></textarea>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->