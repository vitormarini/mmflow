<!-- Main content -->

<head>
    <style>
        .escondido {
            display: none;
        }
    </style>
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

        function calcularEstoque() {
            inputEstoque = document.getElementById('estoque').value;
            inputEstoqueCorrigido = '';
            teclasEstoque = '0123456789,';
            for (i = 0; i < inputEstoque.length; i++) {
                for (j = 0; j < teclasEstoque.length; j++) {
                    if (inputEstoque[i] == teclasEstoque[j]) {
                        inputEstoqueCorrigido += inputEstoque[i];
                    }
                }
            }
            document.getElementById('estoque').value = inputEstoqueCorrigido;
        }

        function calcularPeso() {
            inputPeso = document.getElementById('pesoItem').value;
            inputPesoCorrigido = '';
            teclasPeso = '0123456789,';
            for (i = 0; i < inputPeso.length; i++) {
                for (j = 0; j < teclasPeso.length; j++) {
                    if (inputPeso[i] == teclasPeso[j]) {
                        inputPesoCorrigido += inputPeso[i];
                    }
                }
            }
            document.getElementById('pesoItem').value = inputPesoCorrigido;
        }

        function calcularAltura() {
            inputAltura = document.getElementById('alturaItem').value;
            inputAlturaCorrigido = '';
            teclasAltura = '0123456789,';
            for (i = 0; i < inputAltura.length; i++) {
                for (j = 0; j < teclasAltura.length; j++) {
                    if (inputAltura[i] == teclasAltura[j]) {
                        inputAlturaCorrigido += inputAltura[i];
                    }
                }
            }
            document.getElementById('alturaItem').value = inputAlturaCorrigido;
        }

        function calcularLargura() {
            inputLargura = document.getElementById('larguraItem').value;
            inputLarguraCorrigido = '';
            teclasLargura = '0123456789,';
            for (i = 0; i < inputLargura.length; i++) {
                for (j = 0; j < teclasLargura.length; j++) {
                    if (inputLargura[i] == teclasLargura[j]) {
                        inputLarguraCorrigido += inputLargura[i];
                    }
                }
            }
            document.getElementById('larguraItem').value = inputLarguraCorrigido;
        }

        function calcularComprimento() {
            inputComprimento = document.getElementById('comprimentoItem').value;
            inputComprimentoCorrigido = '';
            teclasComprimento = '0123456789,';
            for (i = 0; i < inputComprimento.length; i++) {
                for (j = 0; j < teclasComprimento.length; j++) {
                    if (inputComprimento[i] == teclasComprimento[j]) {
                        inputComprimentoCorrigido += inputComprimento[i];
                    }
                }
            }
            document.getElementById('comprimentoItem').value = inputComprimentoCorrigido;
        }

        function calcularDensidade() {
            inputDensidade = document.getElementById('densidadeItem').value;
            inputDensidadeCorrigido = '';
            teclasDensidade = '0123456789,';
            for (i = 0; i < inputDensidade.length; i++) {
                for (j = 0; j < teclasDensidade.length; j++) {
                    if (inputDensidade[i] == teclasDensidade[j]) {
                        inputDensidadeCorrigido += inputDensidade[i];
                    }
                }
            }
            document.getElementById('densidadeItem').value = inputDensidadeCorrigido;
        }

        function calcularICMS() {
            inputICMS = document.getElementById('icmsFiscal').value;
            inputICMSCorrigido = '';
            teclasICMS = '0123456789,';
            for (i = 0; i < inputICMS.length; i++) {
                for (j = 0; j < teclasICMS.length; j++) {
                    if (inputICMS[i] == teclasICMS[j]) {
                        inputICMSCorrigido += inputICMS[i];
                    }
                }
            }
            document.getElementById('icmsFiscal').value = inputICMSCorrigido;
        }

        function calcularFCP() {
            inputFCP = document.getElementById('fcpFiscal').value;
            inputFCPCorrigido = '';
            teclasFCP = '0123456789,';
            for (i = 0; i < inputFCP.length; i++) {
                for (j = 0; j < teclasFCP.length; j++) {
                    if (inputFCP[i] == teclasFCP[j]) {
                        inputFCPCorrigido += inputFCP[i];
                    }
                }
            }
            document.getElementById('fcpFiscal').value = inputFCPCorrigido;
        }

        function calcularICMSEF() {
            inputICMSEF = document.getElementById('redFiscal').value;
            inputICMSEFCorrigido = '';
            teclasICMSEF = '0123456789,';
            for (i = 0; i < inputICMSEF.length; i++) {
                for (j = 0; j < teclasICMSEF.length; j++) {
                    if (inputICMSEF[i] == teclasICMSEF[j]) {
                        inputICMSEFCorrigido += inputICMSEF[i];
                    }
                }
            }
            document.getElementById('redFiscal').value = inputICMSEFCorrigido;
        }

        function calcularAliqPer() {
            inputAliqPer = document.getElementById('aliqFiscal').value;
            inputAliqPerCorrigido = '';
            teclasAliqPer = '0123456789,';
            for (i = 0; i < inputAliqPer.length; i++) {
                for (j = 0; j < teclasAliqPer.length; j++) {
                    if (inputAliqPer[i] == teclasAliqPer[j]) {
                        inputAliqPerCorrigido += inputAliqPer[i];
                    }
                }
            }
            document.getElementById('aliqFiscal').value = inputAliqPerCorrigido;
        }

        function calcularAliqFCP() {
            inputAliqFCP = document.getElementById('aliqFcpFiscal').value;
            inputAliqFCPCorrigido = '';
            teclasAliqFCP = '0123456789,';
            for (i = 0; i < inputAliqFCP.length; i++) {
                for (j = 0; j < teclasAliqFCP.length; j++) {
                    if (inputAliqFCP[i] == teclasAliqFCP[j]) {
                        inputAliqFCPCorrigido += inputAliqFCP[i];
                    }
                }
            }
            document.getElementById('aliqFcpFiscal').value = inputAliqFCPCorrigido;
        }

        function calcularAliqPerPIS() {
            inputAliqPerPIS = document.getElementById('aliqPorc').value;
            inputAliqPerPISCorrigido = '';
            teclasAliqPerPIS = '0123456789,';
            for (i = 0; i < inputAliqPerPIS.length; i++) {
                for (j = 0; j < teclasAliqPerPIS.length; j++) {
                    if (inputAliqPerPIS[i] == teclasAliqPerPIS[j]) {
                        inputAliqPerPISCorrigido += inputAliqPerPIS[i];
                    }
                }
            }
            document.getElementById('aliqPorc').value = inputAliqPerPISCorrigido;
        }

        function calcularAliqPerCO() {
            inputAliqPerCO = document.getElementById('porCofins').value;
            inputAliqPerCOCorrigido = '';
            teclasAliqPerCO = '0123456789,';
            for (i = 0; i < inputAliqPerCO.length; i++) {
                for (j = 0; j < teclasAliqPerCO.length; j++) {
                    if (inputAliqPerCO[i] == teclasAliqPerCO[j]) {
                        inputAliqPerCOCorrigido += inputAliqPerCO[i];
                    }
                }
            }
            document.getElementById('porCofins').value = inputAliqPerCOCorrigido;
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
</head>
<section class="content">

    <!-- INICIAMOS O MODO TELA -->
    <?php
    if ($_SESSION['op'] == "") {
        $buscas = explode("&", $_SESSION["buscas"]);
        $filtro_busca = $where = "";
        if (!empty($_POST['filtro_busca'])) {
            $filtro_busca = retira_caracteres($_POST['filtro_busca']);
            $where =
                "WHERE item_id IS NOT NULL 
                AND ( item_codigo    ILIKE '%{$filtro_busca}%' 
                   OR item_descricao ILIKE '%{$filtro_busca}%' 
                   OR item_ncm       ILIKE '%{$filtro_busca}%' )";
        }
    ?>
        <!-- Default box -->
        <div class="card body-view">
            <div class="card-header">
                <form role="search" method="post" action="menu_sys.php">
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_itens','insert','', 'movimentacao','','')">
                                <span class="fas fa-plus"></span>
                                Novo Item
                            </button>
                        </div>
                        <div class="col-sm-8">
                            <div class="col-sm-12">
                                <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $_POST['filtro_busca'] ?>" placeholder="Busque pelo C??digo, Descri????o, NCM..." />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-info" id="btnBusca">
                                <span class="fas fa-search"></span>
                                Pesquisar
                            </button>
                        </div>
                    </div>
                </form>
                <?php
                #Preparamos o filtro da pesquisa
                $intPaginaAtual = ($_SESSION['p']);
                $intPaginaAtual = filter_var($intPaginaAtual, FILTER_VALIDATE_INT);
                $intLimite      = 10;
                $intInicio      = ($intPaginaAtual != '' ? (($intPaginaAtual - 1) * $intLimite) : 0);

                #buscamos os dados
                $sql = "SELECT item_id             ,   item_codigo		,   item_descricao 
                        ,   item_codigo_barra 	,   item_und_inv	,   item_tipo 
                        ,   item_ncm 		    ,   item_ex_ipi		,   item_cod_gen 
                        ,   item_cod_lst 	    ,   item_aliq_icms  ,   item_cest 
                        ,   item_situacao
                     FROM t_item ti  {$where} 
                     ORDER BY 2;";

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
                                    <th width="10%">C??digo </th>
                                    <th width="40%">Descri????o </th>
                                    <th width="10%">NCM </th>
                                    <th width="10%">Unidade </th>
                                    <th width="10%">Tipo </th>
                                    <th width="20%" class="text-center">A????es </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($dados->RecordCount() > 0) {
                                    while (!$dados->EOF) { ?>
                                        <tr>
                                            <td class="text-center"><?= $dados->fields['item_codigo']       ?></td>
                                            <td class="text-left"><?= $dados->fields['item_descricao']    ?></td>
                                            <td class="text-left"><?= $dados->fields['item_ncm']          ?></td>
                                            <td class="text-left"><?= $dados->fields['item_und_inv']      ?></td>
                                            <td class="text-left"><?= $dados->fields['item_tipo']         ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-success" onclick="movPage('adm_itens','view','<?= $dados->fields['item_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informa????o.">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-info" onclick="movPage('adm_itens','edit','<?= $dados->fields['item_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger" onclick="movPage('adm_itens','delete','<?= $dados->fields['item_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar.">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                        $dados->MoveNext();
                                    }
                                } else { ?>
                                    <tr>
                                        <td colspan="6" class="text-center">N??o existem dados a serem listados!!!</td>
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
                        <label><?php paginacao('menu_sys.php', $intPaginaAtual, $intLimite, $qtdRows); ?></label>
                    </div>
                </div>
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    <?php } else {

        if ($_SESSION['id'] != "") {
            #Monta SQL para busca
            $sql = "SELECT 
                    item_id                 ,	item_codigo		,   item_descricao 
                ,   item_codigo_barra       ,	item_und_inv		,   item_tipo 
                ,   item_ncm                ,	item_ex_ipi		,   item_cod_gen 
                ,   item_cod_lst            ,	item_aliq_icms          ,   item_cest 
                ,   item_situacao
                ,   t_ncm.ncm_codigo ||' - '||t_ncm.ncm_descricao AS ncm
                FROM t_item
                INNER JOIN t_ncm ON ( replace(t_ncm.ncm_codigo,'.','') = item_ncm )
                WHERE item_id = '{$_SESSION['id']}';";

            #Resgata os valores do Banco
            $dados = $bd->Execute($sql);
        }

        #Validamos as funcionalidades 
        if ($_SESSION["op"] == "view") {
            $description = "Visualiza????o dos ";
            $disabled = "disabled";
        } else if ($_SESSION["op"] == "insert") {
            $description = "Insira os ";
        } else if ($_SESSION["op"] == "delete") {
            $description = "Deletar esses ";
            $disabled = "disabled";
        } else if ($_SESSION["op"] == "edit") {
            $description = "Editar os ";
        }

    ?>
        <div class="card body-view">
            <div class="card-header">

                <div class="row">

                    <div class="col-sm-12">
                        <label><?= $description ?> Dados do Participante</label>
                    </div>

                </div>

            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['localhost'] ?>/mmflow/_man/manutencao/mainAdmItem.php" method="post" id="frmDados">
                    <ul class="nav nav-tabs row" role="tablist">
                        <li class="nav-item row">
                            <a href="#participante_geral" id="aba-participante-geral" role="tab" data-toggle="tab" class="col-sm nav-link <?= ($_SESSION['aba'] == "" ? "active" : "") ?>">Dados Gerais</a>
                            <a href="#dados_gerenciais" id="aba-dados-gerenciais" role="tab" data-toggle="tab" class="col-sm nav-link">Dados Gerenciais</a>
                            <a href="#dados_fiscais" id="aba-dados-fiscais" role="tab" data-toggle="tab" class="col-sm nav-link">Dados Fiscais</a>
                        </li>
                        <li class="nav-item escondido">
                            <a href="#participante_endereco" id="aba-participante-endereco" role="tab" data-toggle="tab" class="nav-link <?= ($_SESSION['aba'] == "aba-participante-endereco" ? "active" : "") ?>">Endere??o</a>
                        </li>
                        <li class="nav-item escondido">
                            <a href="#participante_contato" id="aba-participante-contato" role="tab" data-toggle="tab" class="nav-link <?= ($_SESSION['aba'] == "aba-participante-contato" ? "active" : "") ?>">Contato</a>
                        </li>
                    </ul>

                    <div class="tab-content" style="margin-top: 20px">
                        <div class="tab-pane <?= ($_SESSION['aba'] == "" ? "active" : "") ?> margin-top-15" id="participante_geral" role="tabpanel">
                            <div class="row">
                                <div class="row col-sm-12">
                                    <div class="col-sm-4  mb-2">
                                        <label for="item_tipo" class="requi">Tipo Item:</label>
                                        <select class="form-control requeri" id="item_tipo" name="item_tipo">
                                            <option value="">Selecione</option>
                                            <option value="00" <?php print $dados->fields['item_tipo'] == "00" ? "selected" : "" ?>>00: Mercadoria para Revenda </option>
                                            <option value="01" <?php print $dados->fields['item_tipo'] == "01" ? "selected" : "" ?>>01: Mat??ria-Prima; </option>
                                            <option value="02" <?php print $dados->fields['item_tipo'] == "02" ? "selected" : "" ?>>02: Embalagem; </option>
                                            <option value="03" <?php print $dados->fields['item_tipo'] == "03" ? "selected" : "" ?>>03: Produto em Processo; </option>
                                            <option value="04" <?php print $dados->fields['item_tipo'] == "04" ? "selected" : "" ?>>04: Produto Acabado; </option>
                                            <option value="05" <?php print $dados->fields['item_tipo'] == "05" ? "selected" : "" ?>>05: Subproduto; </option>
                                            <option value="06" <?php print $dados->fields['item_tipo'] == "06" ? "selected" : "" ?>>06: Produto Intermedi??rio; </option>
                                            <option value="07" <?php print $dados->fields['item_tipo'] == "07" ? "selected" : "" ?>>07: Material de Uso e Consumo;</option>
                                            <option value="08" <?php print $dados->fields['item_tipo'] == "08" ? "selected" : "" ?>>08: Ativo Imobilizado; </option>
                                            <option value="09" <?php print $dados->fields['item_tipo'] == "09" ? "selected" : "" ?>>09: Servi??os; </option>
                                            <option value="10" <?php print $dados->fields['item_tipo'] == "10" ? "selected" : "" ?>>10: Outros insumos; </option>
                                            <option value="99" <?php print $dados->fields['item_tipo'] == "99" ? "selected" : "" ?>>99: Outras </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2  mb-2">
                                        <label for="item_codigo" class="requi">C??digo:</label>
                                        <input type="text" class="form-control requeri unique" id="item_codigo" name="item_codigo" value="<?php print $dados->fields['item_codigo'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-6  mb-2">
                                        <label for="item_descricao" class="requi">Descri????o:</label>
                                        <input type="text" class="form-control requeri" id="item_descricao" name="item_descricao" value="<?php print $dados->fields['item_descricao'] ?>" <?= $disabled ?> />
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <div class="col-sm-4 mb-2">
                                        <label for="item_und_inv" class="requi">Unidade:</label>
                                        <select class="form-control requeri multiselect" id="item_und_inv" name="item_und_inv" title="Refer??ncia a tabela 0190 para os SPED Fiscal e Contribui????es">
                                            <option value="">Selecione</option>
                                            <?php
                                            $und = $bd->Execute($sql =
                                                "SELECT 	
                                              unidades_medidas_id
                                      ,	unidades_medidas_sigla 
                                      ,	unidades_medidas_descricao 
                                      FROM t_unidades_medidas  
                                      ORDER BY 2;");

                                            while (!$und->EOF) { ?>

                                                <option value="<?= $und->fields['unidades_medidas_sigla'] ?>" <?php print $dados->fields['item_und_inv'] == $und->fields['unidades_medidas_sigla'] ? "selected" : "" ?>>
                                                    <?= $und->fields['unidades_medidas_sigla'] . " - " . $und->fields['unidades_medidas_descricao'] ?>
                                                </option>

                                            <?php
                                                $und->MoveNext();
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-2 form-group ">
                                        <label for="item_aliq_icms" class="requi">Al??quota ICMS (%):</label>
                                        <input type="text" class="form-control" id="item_aliq_icms" name="item_aliq_icms" value="<?php print $dados->fields['item_aliq_icms'] ?>" <?= $disabled ?> title="C??digo de Exce????o de NCM de acordo com a Tabela TIPI" />
                                    </div>
                                    <div class="col-sm-6 form-group ">
                                        <label for="item_ex_ipi" class="requi">Ex IPI:</label>
                                        <input type="text" class="form-control" id="item_ex_ipi" name="item_ex_ipi" value="<?php print $dados->fields['item_ex_ipi'] ?>" <?= $disabled ?> title="C??digo de Exce????o de NCM de acordo com a Tabela TIPI" />
                                    </div>
                                    <div class="col-sm-4 form-group ">
                                        <label for="item_cest"><a href="https://www.confaz.fazenda.gov.br/legislacao/convenios/2015/CV146_15" class="requi">CEST:</a></label>
                                        <input type="text" class="form-control" id="item_cest" name="item_cest" value="<?php print $dados->fields['item_cest'] ?>" <?= $disabled ?> title="o valor informado no campo deve existir na Tabela C??digo Especificador da Substitui????o Tribut??ria- CEST, conforme Conv??nio ICMS 52, de 07 de abril de 2017." />
                                    </div>

                                    <div class="col-sm-8 form-group">
                                        <label for="item_cod_gen" class="requi">G??nero do Item:</label>
                                        <select class="form-control requeri" id="item_cod_gen" name="item_cod_gen">
                                            <option value="">Selecione</option>
                                            <option value="00" <?= $dados->fields['item_cod_gen']  == "00" ? "selected" : "" ?>>00 - Servi??o </option>
                                            <option value="01" <?= $dados->fields['item_cod_gen']  == "01" ? "selected" : "" ?>>01 - Animais vivos </option>
                                            <option value="02" <?= $dados->fields['item_cod_gen']  == "02" ? "selected" : "" ?>>02 - Carnes e miudezas, comest??veis </option>
                                            <option value="03" <?= $dados->fields['item_cod_gen']  == "03" ? "selected" : "" ?>>03 - Peixes e crust??ceos, moluscos e os outros invertebrados aqu??ticos </option>
                                            <option value="04" <?= $dados->fields['item_cod_gen']  == "04" ? "selected" : "" ?>>04 - Leite e latic??nios; ovos de aves; mel natural; produtos comest??veis de origem animal, n??o especificados nem com </option>
                                            <option value="05" <?= $dados->fields['item_cod_gen']  == "05" ? "selected" : "" ?>>05 - Outros produtos de origem animal, n??o especificados nem compreendidos em outros Cap??tulos da TIPI </option>
                                            <option value="06" <?= $dados->fields['item_cod_gen']  == "06" ? "selected" : "" ?>>06 - Plantas vivas e produtos de floricultura </option>
                                            <option value="07" <?= $dados->fields['item_cod_gen']  == "07" ? "selected" : "" ?>>07 - Produtos hort??colas, plantas, ra??zes e tub??rculos, comest??veis </option>
                                            <option value="08" <?= $dados->fields['item_cod_gen']  == "08" ? "selected" : "" ?>>08 - Frutas; cascas de c??tricos e de mel??es </option>
                                            <option value="09" <?= $dados->fields['item_cod_gen']  == "09" ? "selected" : "" ?>>09 - Caf??, ch??, mate e especiarias </option>
                                            <option value="10" <?= $dados->fields['item_cod_gen']  == "10" ? "selected" : "" ?>>10 - Cereais </option>
                                            <option value="11" <?= $dados->fields['item_cod_gen']  == "11" ? "selected" : "" ?>>11 - Produtos da ind??stria de moagem; malte; amidos e f??culas; inulina; gl??ten de trigo </option>
                                            <option value="12" <?= $dados->fields['item_cod_gen']  == "12" ? "selected" : "" ?>>12 - Sementes e frutos oleaginosos; gr??os, sementes e frutos diversos; plantas industriais ou medicinais; palha e fo </option>
                                            <option value="13" <?= $dados->fields['item_cod_gen']  == "13" ? "selected" : "" ?>>13 - Gomas, resinas e outros sucos e extratos vegetais 14 Mat??rias para entran??ar e outros produtos de origem vegeta </option>
                                            <option value="15" <?= $dados->fields['item_cod_gen']  == "15" ? "selected" : "" ?>>15 - Gorduras e ??leos animais ou vegetais; produtos da sua dissocia????o; gorduras alimentares elaboradas; ceras de or </option>
                                            <option value="16" <?= $dados->fields['item_cod_gen']  == "16" ? "selected" : "" ?>>16 - Prepara????es de carne, de peixes ou de crust??ceos, de moluscos ou de outros invertebrados aqu??ticos </option>
                                            <option value="17" <?= $dados->fields['item_cod_gen']  == "17" ? "selected" : "" ?>>17 - A????cares e produtos de confeitaria </option>
                                            <option value="18" <?= $dados->fields['item_cod_gen']  == "18" ? "selected" : "" ?>>18 - Cacau e suas prepara????es </option>
                                            <option value="19" <?= $dados->fields['item_cod_gen']  == "19" ? "selected" : "" ?>>19 - Prepara????es ?? base de cereais, farinhas, amidos, f??culas ou de leite; produtos de pastelaria </option>
                                            <option value="20" <?= $dados->fields['item_cod_gen']  == "20" ? "selected" : "" ?>>20 - Prepara????es de produtos hort??colas, de frutas ou de outras partes de plantas </option>
                                            <option value="21" <?= $dados->fields['item_cod_gen']  == "21" ? "selected" : "" ?>>21 - Prepara????es aliment??cias diversas </option>
                                            <option value="22" <?= $dados->fields['item_cod_gen']  == "22" ? "selected" : "" ?>>22 - Bebidas, l??quidos alco??licos e vinagres </option>
                                            <option value="23" <?= $dados->fields['item_cod_gen']  == "23" ? "selected" : "" ?>>23 - Res??duos e desperd??cios das ind??strias alimentares; alimentos preparados para animais </option>
                                            <option value="24" <?= $dados->fields['item_cod_gen']  == "24" ? "selected" : "" ?>>24 - Fumo (tabaco) e seus suced??neos, manufaturados </option>
                                            <option value="25" <?= $dados->fields['item_cod_gen']  == "25" ? "selected" : "" ?>>25 - Sal; enxofre; terras e pedras; gesso, cal e cimento </option>
                                            <option value="26" <?= $dados->fields['item_cod_gen']  == "26" ? "selected" : "" ?>>26 - Min??rios, esc??rias e cinzas </option>
                                            <option value="27" <?= $dados->fields['item_cod_gen']  == "27" ? "selected" : "" ?>>27 - Combust??veis minerais, ??leos minerais e produtos de sua destila????o; mat??rias betuminosas; ceras minerais </option>
                                            <option value="28" <?= $dados->fields['item_cod_gen']  == "28" ? "selected" : "" ?>>28 - Produtos qu??micos inorg??nicos; compostos inorg??nicos ou org??nicos de metais preciosos, de elementos radioativos </option>
                                            <option value="29" <?= $dados->fields['item_cod_gen']  == "29" ? "selected" : "" ?>>29 - Produtos qu??micos org??nicos </option>
                                            <option value="30" <?= $dados->fields['item_cod_gen']  == "30" ? "selected" : "" ?>>30 - Produtos farmac??uticos </option>
                                            <option value="31" <?= $dados->fields['item_cod_gen']  == "31" ? "selected" : "" ?>>31 - Adubos ou fertilizantes </option>
                                            <option value="32" <?= $dados->fields['item_cod_gen']  == "32" ? "selected" : "" ?>>32 - Extratos tanantes e tintoriais; taninos e seus derivados; pigmentos e outras mat??rias corantes, tintas e verniz </option>
                                            <option value="33" <?= $dados->fields['item_cod_gen']  == "33" ? "selected" : "" ?>>33 - ??leos essenciais e resin??ides; produtos de perfumaria ou de toucador preparados e prepara????es cosm??ticas </option>
                                            <option value="34" <?= $dados->fields['item_cod_gen']  == "34" ? "selected" : "" ?>>34 - Sab??es, agentes org??nicos de superf??cie, prepara????es para lavagem, prepara????es lubrificantes, ceras artificiais </option>
                                            <option value="35" <?= $dados->fields['item_cod_gen']  == "35" ? "selected" : "" ?>>35 - Mat??rias albumin??ides; produtos ?? base de amidos ou de f??culas modificados; colas; enzimas </option>
                                            <option value="36" <?= $dados->fields['item_cod_gen']  == "36" ? "selected" : "" ?>>36 - P??lvoras e explosivos; artigos de pirotecnia; f??sforos; ligas pirof??ricas; mat??rias inflam??veis </option>
                                            <option value="37" <?= $dados->fields['item_cod_gen']  == "37" ? "selected" : "" ?>>37 - Produtos para fotografia e cinematografia </option>
                                            <option value="38" <?= $dados->fields['item_cod_gen']  == "38" ? "selected" : "" ?>>38 - Produtos diversos das ind??strias qu??micas </option>
                                            <option value="39" <?= $dados->fields['item_cod_gen']  == "39" ? "selected" : "" ?>>39 - Pl??sticos e suas obras </option>
                                            <option value="40" <?= $dados->fields['item_cod_gen']  == "40" ? "selected" : "" ?>>40 - Borracha e suas obras </option>
                                            <option value="41" <?= $dados->fields['item_cod_gen']  == "41" ? "selected" : "" ?>>41 - Peles, exceto a peleteria (peles com p??lo*), e couros </option>
                                            <option value="42" <?= $dados->fields['item_cod_gen']  == "42" ? "selected" : "" ?>>42 - Obras de couro; artigos de correeiro ou de seleiro; artigos de viagem, bolsas e artefatos semelhantes; obras de </option>
                                            <option value="43" <?= $dados->fields['item_cod_gen']  == "43" ? "selected" : "" ?>>43 - Peleteria (peles com pelo*) e suas obras; peleteria (peles com pelo*) artificial </option>
                                            <option value="44" <?= $dados->fields['item_cod_gen']  == "44" ? "selected" : "" ?>>44 - Madeira, carv??o vegetal e obras de madeira </option>
                                            <option value="45" <?= $dados->fields['item_cod_gen']  == "45" ? "selected" : "" ?>>45 - Corti??a e suas obras </option>
                                            <option value="46" <?= $dados->fields['item_cod_gen']  == "46" ? "selected" : "" ?>>46 - Obras de espartaria ou de cestaria </option>
                                            <option value="47" <?= $dados->fields['item_cod_gen']  == "47" ? "selected" : "" ?>>47 - Pastas de madeira ou de outras mat??rias fibrosas celul??sicas; papel ou cart??o de reciclar (desperd??cios e apara </option>
                                            <option value="48" <?= $dados->fields['item_cod_gen']  == "48" ? "selected" : "" ?>>48 - Papel e cart??o; obras de pasta de celulose, de papel ou de cart??o </option>
                                            <option value="49" <?= $dados->fields['item_cod_gen']  == "49" ? "selected" : "" ?>>49 - Livros, jornais, gravuras e outros produtos das ind??strias gr??ficas; textos manuscritos ou datilografados, plan </option>
                                            <option value="50" <?= $dados->fields['item_cod_gen']  == "50" ? "selected" : "" ?>>50 - Seda </option>
                                            <option value="51" <?= $dados->fields['item_cod_gen']  == "51" ? "selected" : "" ?>>51 - L?? e pelos finos ou grosseiros; fios e tecidos de crina </option>
                                            <option value="52" <?= $dados->fields['item_cod_gen']  == "52" ? "selected" : "" ?>>52 - Algod??o </option>
                                            <option value="53" <?= $dados->fields['item_cod_gen']  == "53" ? "selected" : "" ?>>53 - Outras fibras t??xteis vegetais; fios de papel e tecido de fios de papel </option>
                                            <option value="54" <?= $dados->fields['item_cod_gen']  == "54" ? "selected" : "" ?>>54 - Filamentos sint??ticos ou artificiais </option>
                                            <option value="55" <?= $dados->fields['item_cod_gen']  == "55" ? "selected" : "" ?>>55 - Fibras sint??ticas ou artificiais, descont??nuas </option>
                                            <option value="56" <?= $dados->fields['item_cod_gen']  == "56" ? "selected" : "" ?>>56 - Pastas ("ouates"), feltros e falsos tecidos; fios especiais; cord??is, cordas e cabos; artigos de cordoaria </option>
                                            <option value="57" <?= $dados->fields['item_cod_gen']  == "57" ? "selected" : "" ?>>57 - Tapetes e outros revestimentos para pavimentos, de mat??rias t??xteis </option>
                                            <option value="58" <?= $dados->fields['item_cod_gen']  == "58" ? "selected" : "" ?>>58 - Tecidos especiais; tecidos tufados; rendas; tape??arias; passamanarias; bordados </option>
                                            <option value="59" <?= $dados->fields['item_cod_gen']  == "59" ? "selected" : "" ?>>59 - Tecidos impregnados, revestidos, recobertos ou estratificados; artigos para usos t??cnicos de mat??rias t??xteis </option>
                                            <option value="60" <?= $dados->fields['item_cod_gen']  == "60" ? "selected" : "" ?>>60 - Tecidos de malha </option>
                                            <option value="61" <?= $dados->fields['item_cod_gen']  == "61" ? "selected" : "" ?>>61 - Vestu??rio e seus acess??rios, de malha </option>
                                            <option value="62" <?= $dados->fields['item_cod_gen']  == "62" ? "selected" : "" ?>>62 - Vestu??rio e seus acess??rios, exceto de malha </option>
                                            <option value="63" <?= $dados->fields['item_cod_gen']  == "63" ? "selected" : "" ?>>63 - Outros artefatos t??xteis confeccionados; sortidos; artefatos de mat??rias t??xteis, cal??ados, chap??us e artefatos </option>
                                            <option value="64" <?= $dados->fields['item_cod_gen']  == "64" ? "selected" : "" ?>>64 - Cal??ados, polainas e artefatos semelhantes, e suas partes </option>
                                            <option value="65" <?= $dados->fields['item_cod_gen']  == "65" ? "selected" : "" ?>>65 - Chap??us e artefatos de uso semelhante, e suas partes </option>
                                            <option value="66" <?= $dados->fields['item_cod_gen']  == "66" ? "selected" : "" ?>>66 - Guarda-chuvas, sombrinhas, guarda-s??is, bengalas, bengalas-assentos, chicotes, e suas partes </option>
                                            <option value="67" <?= $dados->fields['item_cod_gen']  == "67" ? "selected" : "" ?>>67 - Penas e penugem preparadas, e suas obras; flores artificiais; obras de cabelo </option>
                                            <option value="68" <?= $dados->fields['item_cod_gen']  == "68" ? "selected" : "" ?>>68 - Obras de pedra, gesso, cimento, amianto, mica ou de mat??rias semelhantes </option>
                                            <option value="69" <?= $dados->fields['item_cod_gen']  == "69" ? "selected" : "" ?>>69 - Produtos cer??micos </option>
                                            <option value="70" <?= $dados->fields['item_cod_gen']  == "70" ? "selected" : "" ?>>70 - Vidro e suas obras </option>
                                            <option value="71" <?= $dados->fields['item_cod_gen']  == "71" ? "selected" : "" ?>>71 - P??rolas naturais ou cultivadas, pedras preciosas ou semipreciosas e semelhantes, metais preciosos, metais folhe </option>
                                            <option value="72" <?= $dados->fields['item_cod_gen']  == "72" ? "selected" : "" ?>>72 - Ferro fundido, ferro e a??o </option>
                                            <option value="73" <?= $dados->fields['item_cod_gen']  == "73" ? "selected" : "" ?>>73 - Obras de ferro fundido, ferro ou a??o </option>
                                            <option value="74" <?= $dados->fields['item_cod_gen']  == "74" ? "selected" : "" ?>>74 - Cobre e suas obras </option>
                                            <option value="75" <?= $dados->fields['item_cod_gen']  == "75" ? "selected" : "" ?>>75 - N??quel e suas obras </option>
                                            <option value="76" <?= $dados->fields['item_cod_gen']  == "76" ? "selected" : "" ?>>76 - Alum??nio e suas obras </option>
                                            <option value="77" <?= $dados->fields['item_cod_gen']  == "77" ? "selected" : "" ?>>77 - (Reservado para uma eventual utiliza????o futura no SH) </option>
                                            <option value="78" <?= $dados->fields['item_cod_gen']  == "78" ? "selected" : "" ?>>78 - Chumbo e suas obras </option>
                                            <option value="79" <?= $dados->fields['item_cod_gen']  == "79" ? "selected" : "" ?>>79 - Zinco e suas obras </option>
                                            <option value="80" <?= $dados->fields['item_cod_gen']  == "80" ? "selected" : "" ?>>80 - Estanho e suas obras </option>
                                            <option value="81" <?= $dados->fields['item_cod_gen']  == "81" ? "selected" : "" ?>>81 - Outros metais comuns; ceramais ("cermets"); obras dessas mat??rias </option>
                                            <option value="82" <?= $dados->fields['item_cod_gen']  == "82" ? "selected" : "" ?>>82 - Ferramentas, artefatos de cutelaria e talheres, e suas partes, de metais comuns </option>
                                            <option value="83" <?= $dados->fields['item_cod_gen']  == "83" ? "selected" : "" ?>>83 - Obras diversas de metais comuns </option>
                                            <option value="84" <?= $dados->fields['item_cod_gen']  == "84" ? "selected" : "" ?>>84 - Reatores nucleares, caldeiras, m??quinas, aparelhos e instrumentos mec??nicos, e suas partes </option>
                                            <option value="85" <?= $dados->fields['item_cod_gen']  == "85" ? "selected" : "" ?>>85 - M??quinas, aparelhos e materiais el??tricos, e suas partes; aparelhos de grava????o ou de reprodu????o de som, aparel </option>
                                            <option value="86" <?= $dados->fields['item_cod_gen']  == "86" ? "selected" : "" ?>>86 - Ve??culos e material para vias f??rreas ou semelhantes, e suas partes; aparelhos mec??nicos (inclu??dos os eletrome </option>
                                            <option value="88" <?= $dados->fields['item_cod_gen']  == "88" ? "selected" : "" ?>>88 - Aeronaves e aparelhos espaciais, e suas partes </option>
                                            <option value="89" <?= $dados->fields['item_cod_gen']  == "89" ? "selected" : "" ?>>89 - Embarca????es e estruturas flutuantes </option>
                                            <option value="90" <?= $dados->fields['item_cod_gen']  == "90" ? "selected" : "" ?>>90 - Instrumentos e aparelhos de ??ptica, fotografia ou cinematografia, medida, controle ou de precis??o; instrumentos </option>
                                            <option value="91" <?= $dados->fields['item_cod_gen']  == "91" ? "selected" : "" ?>>91 - Aparelhos de relojoaria e suas partes </option>
                                            <option value="92" <?= $dados->fields['item_cod_gen']  == "92" ? "selected" : "" ?>>92 - Instrumentos musicais, suas partes e acess??rios </option>
                                            <option value="93" <?= $dados->fields['item_cod_gen']  == "93" ? "selected" : "" ?>>93 - Armas e muni????es; suas partes e acess??rios </option>
                                            <option value="94" <?= $dados->fields['item_cod_gen']  == "94" ? "selected" : "" ?>>94 - M??veis, mobili??rio m??dico-cir??rgico; colch??es; ilumina????o e constru????o pr??-fabricadas </option>
                                            <option value="95" <?= $dados->fields['item_cod_gen']  == "95" ? "selected" : "" ?>>95 - Brinquedos, jogos, artigos para divertimento ou para esporte; suas partes e acess??rios </option>
                                            <option value="96" <?= $dados->fields['item_cod_gen']  == "96" ? "selected" : "" ?>>96 - Obras diversas </option>
                                            <option value="97" <?= $dados->fields['item_cod_gen']  == "97" ? "selected" : "" ?>>97 - Objetos de arte, de cole????o e antiguidades </option>
                                            <option value="98" <?= $dados->fields['item_cod_gen']  == "98" ? "selected" : "" ?>>98 - (Reservado para usos especiais pelas Partes Contratantes) </option>
                                            <option value="99" <?= $dados->fields['item_cod_gen']  == "99" ? "selected" : "" ?>>99 - Opera????es especiais (utilizado exclusivamente pelo Brasil para classificar opera????es especiais na exporta????o </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 mb-2">
                                        <label for="item_cod_lst" class="requi">C??digo LST:</label>
                                        <select class="form-control requeri " id="item_cod_lst" name="item_cod_lst" <?= $disabled ?> title="C??digo do servi??o conforme lista do Anexo I da Lei Complementar Federal n?? 116/2003">
                                            <option value="">Selecione</option>
                                            <option value="1.01" <?= $dados->fields['item_cod_lst'] == "101" ? "selected" : "" ?>> 1.01 - An??lise e desenvolvimento de sistemas. </option>
                                            <option value="1.02" <?= $dados->fields['item_cod_lst'] == "102" ? "selected" : "" ?>> 1.02 - Programa????o. </option>
                                            <option value="1.03" <?= $dados->fields['item_cod_lst'] == "103" ? "selected" : "" ?>> 1.03 - Processamento de dados e cong??neres. </option>
                                            <option value="1.04" <?= $dados->fields['item_cod_lst'] == "104" ? "selected" : "" ?>> 1.04 - Elabora????o de programas de computadores, inclusive </option>
                                            <option value="1.05" <?= $dados->fields['item_cod_lst'] == "105" ? "selected" : "" ?>> 1.05 - Licenciamento ou cess??o de direito de uso de progr </option>
                                            <option value="1.06" <?= $dados->fields['item_cod_lst'] == "106" ? "selected" : "" ?>> 1.06 - Assessoria e consultoria em inform??tica. </option>
                                            <option value="1.07" <?= $dados->fields['item_cod_lst'] == "107" ? "selected" : "" ?>> 1.07 - Suporte t??cnico em inform??tica, inclusive instala?? </option>
                                            <option value="1.08" <?= $dados->fields['item_cod_lst'] == "108" ? "selected" : "" ?>> 1.08 - Planejamento, confec????o, manuten????o e atualiza????o </option>
                                            <option value="2.01" <?= $dados->fields['item_cod_lst'] == "201" ? "selected" : "" ?>> 2.01 - Servi??os de pesquisas e desenvolvimento de qualque </option>
                                            <option value="3.01" <?= $dados->fields['item_cod_lst'] == "301" ? "selected" : "" ?>> 3.01 - (VETADO) </option>
                                            <option value="3.02" <?= $dados->fields['item_cod_lst'] == "302" ? "selected" : "" ?>> 3.02 - Cess??o de direito de uso de marcas e de sinais de </option>
                                            <option value="3.03" <?= $dados->fields['item_cod_lst'] == "303" ? "selected" : "" ?>> 3.03 - Explora????o de sal??es de festas, centro de conven???? </option>
                                            <option value="3.04" <?= $dados->fields['item_cod_lst'] == "304" ? "selected" : "" ?>> 3.04 - Loca????o, subloca????o, arrendamento, direito de pass </option>
                                            <option value="3.05" <?= $dados->fields['item_cod_lst'] == "305" ? "selected" : "" ?>> 3.05 - Cess??o de andaimes, palcos, coberturas e outras es </option>
                                            <option value="4.01" <?= $dados->fields['item_cod_lst'] == "401" ? "selected" : "" ?>> 4.01 - Medicina e biomedicina. </option>
                                            <option value="4.02" <?= $dados->fields['item_cod_lst'] == "402" ? "selected" : "" ?>> 4.02 - An??lises cl??nicas, patologia, eletricidade m??dica, </option>
                                            <option value="4.03" <?= $dados->fields['item_cod_lst'] == "403" ? "selected" : "" ?>> 4.03 - Hospitais, cl??nicas, laborat??rios, sanat??rios, man </option>
                                            <option value="4.04" <?= $dados->fields['item_cod_lst'] == "404" ? "selected" : "" ?>> 4.04 - Instrumenta????o cir??rgica. </option>
                                            <option value="4.05" <?= $dados->fields['item_cod_lst'] == "405" ? "selected" : "" ?>> 4.05 - Acupuntura. </option>
                                            <option value="4.06" <?= $dados->fields['item_cod_lst'] == "406" ? "selected" : "" ?>> 4.06 - Enfermagem, inclusive servi??os auxiliares. </option>
                                            <option value="4.07" <?= $dados->fields['item_cod_lst'] == "407" ? "selected" : "" ?>> 4.07 - Servi??os farmac??uticos. </option>
                                            <option value="4.08" <?= $dados->fields['item_cod_lst'] == "408" ? "selected" : "" ?>> 4.08 - Terapia ocupacional, fisioterapia e fonoaudiologia </option>
                                            <option value="4.09" <?= $dados->fields['item_cod_lst'] == "409" ? "selected" : "" ?>> 4.09 - Terapias de qualquer esp??cie destinadas ao tratame </option>
                                            <option value="4.10" <?= $dados->fields['item_cod_lst'] == "410" ? "selected" : "" ?>> 4.10 - Nutri????o. </option>
                                            <option value="4.11" <?= $dados->fields['item_cod_lst'] == "411" ? "selected" : "" ?>> 4.11 - Obstetr??cia. </option>
                                            <option value="4.12" <?= $dados->fields['item_cod_lst'] == "412" ? "selected" : "" ?>> 4.12 - Odontologia. </option>
                                            <option value="4.13" <?= $dados->fields['item_cod_lst'] == "413" ? "selected" : "" ?>> 4.13 - Ort??ptica. </option>
                                            <option value="4.14" <?= $dados->fields['item_cod_lst'] == "414" ? "selected" : "" ?>> 4.14 - Pr??teses sob encomenda. </option>
                                            <option value="4.15" <?= $dados->fields['item_cod_lst'] == "415" ? "selected" : "" ?>> 4.15 - Psican??lise. </option>
                                            <option value="4.16" <?= $dados->fields['item_cod_lst'] == "416" ? "selected" : "" ?>> 4.16 - Psicologia. </option>
                                            <option value="4.17" <?= $dados->fields['item_cod_lst'] == "417" ? "selected" : "" ?>> 4.17 - Casas de repouso e de recupera????o, creches, asilos </option>
                                            <option value="4.18" <?= $dados->fields['item_cod_lst'] == "418" ? "selected" : "" ?>> 4.18 - Insemina????o artificial, fertiliza????o in vitro e co </option>
                                            <option value="4.19" <?= $dados->fields['item_cod_lst'] == "419" ? "selected" : "" ?>> 4.19 - Bancos de sangue, leite, pele, olhos, ??vulos, s??me </option>
                                            <option value="4.20" <?= $dados->fields['item_cod_lst'] == "420" ? "selected" : "" ?>> 4.20 - Coleta de sangue, leite, tecidos, s??men, ??rg??os e </option>
                                            <option value="4.21" <?= $dados->fields['item_cod_lst'] == "421" ? "selected" : "" ?>> 4.21 - Unidade de atendimento, assist??ncia ou tratamento </option>
                                            <option value="4.22" <?= $dados->fields['item_cod_lst'] == "422" ? "selected" : "" ?>> 4.22 - Planos de medicina de grupo ou individual e conv??n </option>
                                            <option value="4.23" <?= $dados->fields['item_cod_lst'] == "423" ? "selected" : "" ?>> 4.23 - Outros planos de sa??de que se cumpram atrav??s de s </option>
                                            <option value="5.01" <?= $dados->fields['item_cod_lst'] == "501" ? "selected" : "" ?>> 5.01 - Medicina veterin??ria e zootecnia. </option>
                                            <option value="5.02" <?= $dados->fields['item_cod_lst'] == "502" ? "selected" : "" ?>> 5.02 - Hospitais, cl??nicas, ambulat??rios, prontos-socorro </option>
                                            <option value="5.03" <?= $dados->fields['item_cod_lst'] == "503" ? "selected" : "" ?>> 5.03 - Laborat??rios de an??lise na ??rea veterin??ria. </option>
                                            <option value="5.04" <?= $dados->fields['item_cod_lst'] == "504" ? "selected" : "" ?>> 5.04 - Insemina????o artificial, fertiliza????o in vitro e co </option>
                                            <option value="5.05" <?= $dados->fields['item_cod_lst'] == "505" ? "selected" : "" ?>> 5.05 - Bancos de sangue e de ??rg??os e cong??neres. </option>
                                            <option value="5.06" <?= $dados->fields['item_cod_lst'] == "506" ? "selected" : "" ?>> 5.06 - Coleta de sangue, leite, tecidos, s??men, ??rg??os e </option>
                                            <option value="5.07" <?= $dados->fields['item_cod_lst'] == "507" ? "selected" : "" ?>> 5.07 - Unidade de atendimento, assist??ncia ou tratamento </option>
                                            <option value="5.08" <?= $dados->fields['item_cod_lst'] == "508" ? "selected" : "" ?>> 5.08 - Guarda, tratamento, amestramento, embelezamento, a </option>
                                            <option value="5.09" <?= $dados->fields['item_cod_lst'] == "509" ? "selected" : "" ?>> 5.09 - Planos de atendimento e assist??ncia m??dico-veterin </option>
                                            <option value="6.01" <?= $dados->fields['item_cod_lst'] == "601" ? "selected" : "" ?>> 6.01 - Barbearia, cabeleireiros, manicuros, pedicuros e c </option>
                                            <option value="6.02" <?= $dados->fields['item_cod_lst'] == "602" ? "selected" : "" ?>> 6.02 - Esteticistas, tratamento de pele, depila????o e cong </option>
                                            <option value="6.03" <?= $dados->fields['item_cod_lst'] == "603" ? "selected" : "" ?>> 6.03 - Banhos, duchas, sauna, massagens e cong??neres. </option>
                                            <option value="6.04" <?= $dados->fields['item_cod_lst'] == "604" ? "selected" : "" ?>> 6.04 - Gin??stica, dan??a, esportes, nata????o, artes marciai </option>
                                            <option value="6.05" <?= $dados->fields['item_cod_lst'] == "605" ? "selected" : "" ?>> 6.05 - Centros de emagrecimento, spa e cong??neres. </option>
                                            <option value="7.01" <?= $dados->fields['item_cod_lst'] == "701" ? "selected" : "" ?>> 7.01 - Engenharia, agronomia, agrimensura, arquitetura, g </option>
                                            <option value="7.02" <?= $dados->fields['item_cod_lst'] == "702" ? "selected" : "" ?>> 7.02 - Execu????o, por administra????o, empreitada ou subempr </option>
                                            <option value="7.03" <?= $dados->fields['item_cod_lst'] == "703" ? "selected" : "" ?>> 7.03 - Elabora????o de planos diretores, estudos de viabili </option>
                                            <option value="7.04" <?= $dados->fields['item_cod_lst'] == "704" ? "selected" : "" ?>> 7.04 - Demoli????o. </option>
                                            <option value="7.05" <?= $dados->fields['item_cod_lst'] == "705" ? "selected" : "" ?>> 7.05 - Repara????o, conserva????o e reforma de edif??cios, est </option>
                                            <option value="7.06" <?= $dados->fields['item_cod_lst'] == "706" ? "selected" : "" ?>> 7.06 - Coloca????o e instala????o de tapetes, carpetes, assoa </option>
                                            <option value="7.07" <?= $dados->fields['item_cod_lst'] == "707" ? "selected" : "" ?>> 7.07 - Recupera????o, raspagem, polimento e lustra????o de pi </option>
                                            <option value="7.08" <?= $dados->fields['item_cod_lst'] == "708" ? "selected" : "" ?>> 7.08 - Calafeta????o. </option>
                                            <option value="7.09" <?= $dados->fields['item_cod_lst'] == "709" ? "selected" : "" ?>> 7.09 - Varri????o, coleta, remo????o, incinera????o, tratamento </option>
                                            <option value="7.10" <?= $dados->fields['item_cod_lst'] == "710" ? "selected" : "" ?>> 7.10 - Limpeza, manuten????o e conserva????o de vias e lograd </option>
                                            <option value="7.11" <?= $dados->fields['item_cod_lst'] == "711" ? "selected" : "" ?>> 7.11 - Decora????o e jardinagem, inclusive corte e poda de </option>
                                            <option value="7.12" <?= $dados->fields['item_cod_lst'] == "712" ? "selected" : "" ?>> 7.12 - Controle e tratamento de efluentes de qualquer nat </option>
                                            <option value="7.13" <?= $dados->fields['item_cod_lst'] == "713" ? "selected" : "" ?>> 7.13 - Dedetiza????o, desinfec????o, desinsetiza????o, imuniza?? </option>
                                            <option value="7.14" <?= $dados->fields['item_cod_lst'] == "714" ? "selected" : "" ?>> 7.14 - (VETADO) </option>
                                            <option value="7.15" <?= $dados->fields['item_cod_lst'] == "715" ? "selected" : "" ?>> 7.15 - (VETADO) </option>
                                            <option value="7.16" <?= $dados->fields['item_cod_lst'] == "716" ? "selected" : "" ?>> 7.16 - Florestamento, reflorestamento, semeadura, aduba???? </option>
                                            <option value="7.17" <?= $dados->fields['item_cod_lst'] == "717" ? "selected" : "" ?>> 7.17 - Escoramento, conten????o de encostas e servi??os cong </option>
                                            <option value="7.18" <?= $dados->fields['item_cod_lst'] == "718" ? "selected" : "" ?>> 7.18 - Limpeza e dragagem de rios, portos, canais, ba??as, </option>
                                            <option value="7.19" <?= $dados->fields['item_cod_lst'] == "719" ? "selected" : "" ?>> 7.19 - Acompanhamento e fiscaliza????o da execu????o de obras </option>
                                            <option value="7.20" <?= $dados->fields['item_cod_lst'] == "720" ? "selected" : "" ?>> 7.20 - Aerofotogrametria (inclusive interpreta????o), carto </option>
                                            <option value="7.21" <?= $dados->fields['item_cod_lst'] == "721" ? "selected" : "" ?>> 7.21 - Pesquisa, perfura????o, cimenta????o, mergulho, perfil </option>
                                            <option value="7.22" <?= $dados->fields['item_cod_lst'] == "722" ? "selected" : "" ?>> 7.22 - Nuclea????o e bombardeamento de nuvens e cong??neres. </option>
                                            <option value="8.01" <?= $dados->fields['item_cod_lst'] == "801" ? "selected" : "" ?>> 8.01 - Ensino regular pr??-escolar, fundamental, m??dio e s </option>
                                            <option value="8.02" <?= $dados->fields['item_cod_lst'] == "802" ? "selected" : "" ?>> 8.02 - Instru????o, treinamento, orienta????o pedag??gica e ed </option>
                                            <option value="9.01" <?= $dados->fields['item_cod_lst'] == "901" ? "selected" : "" ?>> 9.01 - Hospedagem de qualquer natureza em hot??is, apart-s </option>
                                            <option value="9.02" <?= $dados->fields['item_cod_lst'] == "902" ? "selected" : "" ?>> 9.02 - Agenciamento, organiza????o, promo????o, intermedia????o </option>
                                            <option value="9.03" <?= $dados->fields['item_cod_lst'] == "903" ? "selected" : "" ?>> 9.03 - Guias de turismo. </option>
                                            <option value="10.01" <?= $dados->fields['item_cod_lst'] == "1001" ? "selected" : "" ?>> 10.01 - Agenciamento, corretagem ou intermedia????o de c??m</option>
                                            <option value="10.02" <?= $dados->fields['item_cod_lst'] == "1002" ? "selected" : "" ?>> 10.02 - Agenciamento, corretagem ou intermedia????o de t??t</option>
                                            <option value="10.03" <?= $dados->fields['item_cod_lst'] == "1003" ? "selected" : "" ?>> 10.03 - Agenciamento, corretagem ou intermedia????o de dir</option>
                                            <option value="10.04" <?= $dados->fields['item_cod_lst'] == "1004" ? "selected" : "" ?>> 10.04 - Agenciamento, corretagem ou intermedia????o de con</option>
                                            <option value="10.05" <?= $dados->fields['item_cod_lst'] == "1005" ? "selected" : "" ?>> 10.05 - Agenciamento, corretagem ou intermedia????o de ben</option>
                                            <option value="10.06" <?= $dados->fields['item_cod_lst'] == "1006" ? "selected" : "" ?>> 10.06 - Agenciamento mar??timo. </option>
                                            <option value="10.07" <?= $dados->fields['item_cod_lst'] == "1007" ? "selected" : "" ?>> 10.07 - Agenciamento de not??cias. </option>
                                            <option value="10.08" <?= $dados->fields['item_cod_lst'] == "1008" ? "selected" : "" ?>> 10.08 - Agenciamento de publicidade e propaganda, inclus</option>
                                            <option value="10.09" <?= $dados->fields['item_cod_lst'] == "1009" ? "selected" : "" ?>> 10.09 - Representa????o de qualquer natureza, inclusive co</option>
                                            <option value="10.10" <?= $dados->fields['item_cod_lst'] == "1010" ? "selected" : "" ?>> 10.10 - Distribui????o de bens de terceiros. </option>
                                            <option value="11.01" <?= $dados->fields['item_cod_lst'] == "1101" ? "selected" : "" ?>> 11.01 - Guarda e estacionamento de ve??culos terrestres a</option>
                                            <option value="11.02" <?= $dados->fields['item_cod_lst'] == "1102" ? "selected" : "" ?>> 11.02 - Vigil??ncia, seguran??a ou monitoramento de bens e</option>
                                            <option value="11.03" <?= $dados->fields['item_cod_lst'] == "1103" ? "selected" : "" ?>> 11.03 - Escolta, inclusive de ve??culos e cargas. </option>
                                            <option value="11.04" <?= $dados->fields['item_cod_lst'] == "1104" ? "selected" : "" ?>> 11.04 - Armazenamento, dep??sito, carga, descarga, arruma</option>
                                            <option value="12.01" <?= $dados->fields['item_cod_lst'] == "1201" ? "selected" : "" ?>> 12.01 - Espet??culos teatrais. </option>
                                            <option value="12.02" <?= $dados->fields['item_cod_lst'] == "1202" ? "selected" : "" ?>> 12.02 - Exibi????es cinematogr??ficas. </option>
                                            <option value="12.03" <?= $dados->fields['item_cod_lst'] == "1203" ? "selected" : "" ?>> 12.03 - Espet??culos circenses. </option>
                                            <option value="12.04" <?= $dados->fields['item_cod_lst'] == "1204" ? "selected" : "" ?>> 12.04 - Programas de audit??rio. </option>
                                            <option value="12.05" <?= $dados->fields['item_cod_lst'] == "1205" ? "selected" : "" ?>> 12.05 - Parques de divers??es, centros de lazer e cong??ne</option>
                                            <option value="12.06" <?= $dados->fields['item_cod_lst'] == "1206" ? "selected" : "" ?>> 12.06 - Boates, taxi-dancing e cong??neres. </option>
                                            <option value="12.07" <?= $dados->fields['item_cod_lst'] == "1207" ? "selected" : "" ?>> 12.07 - Shows, ballet, dan??as, desfiles, bailes, ??peras,</option>
                                            <option value="12.08" <?= $dados->fields['item_cod_lst'] == "1208" ? "selected" : "" ?>> 12.08 - Feiras, exposi????es, congressos e cong??neres. </option>
                                            <option value="12.09" <?= $dados->fields['item_cod_lst'] == "1209" ? "selected" : "" ?>> 12.09 - Bilhares, boliches e divers??es eletr??nicas ou n??</option>
                                            <option value="12.10" <?= $dados->fields['item_cod_lst'] == "1210" ? "selected" : "" ?>> 12.10 - Corridas e competi????es de animais. </option>
                                            <option value="12.11" <?= $dados->fields['item_cod_lst'] == "1211" ? "selected" : "" ?>> 12.11 - Competi????es esportivas ou de destreza f??sica ou </option>
                                            <option value="12.12" <?= $dados->fields['item_cod_lst'] == "1212" ? "selected" : "" ?>> 12.12 - Execu????o de m??sica. </option>
                                            <option value="12.13" <?= $dados->fields['item_cod_lst'] == "1213" ? "selected" : "" ?>> 12.13 - Produ????o, mediante ou sem encomenda pr??via, de e</option>
                                            <option value="12.14" <?= $dados->fields['item_cod_lst'] == "1214" ? "selected" : "" ?>> 12.14 - Fornecimento de m??sica para ambientes fechados o</option>
                                            <option value="12.15" <?= $dados->fields['item_cod_lst'] == "1215" ? "selected" : "" ?>> 12.15 - Desfiles de blocos carnavalescos ou folcl??ricos,</option>
                                            <option value="12.16" <?= $dados->fields['item_cod_lst'] == "1216" ? "selected" : "" ?>> 12.16 - Exibi????o de filmes, entrevistas, musicais, espet</option>
                                            <option value="12.17" <?= $dados->fields['item_cod_lst'] == "1217" ? "selected" : "" ?>> 12.17 - Recrea????o e anima????o, inclusive em festas e even</option>
                                            <option value="13.01" <?= $dados->fields['item_cod_lst'] == "1301" ? "selected" : "" ?>> 13.01 - (VETADO) </option>
                                            <option value="13.02" <?= $dados->fields['item_cod_lst'] == "1302" ? "selected" : "" ?>> 13.02 - Fonografia ou grava????o de sons, inclusive trucag</option>
                                            <option value="13.03" <?= $dados->fields['item_cod_lst'] == "1303" ? "selected" : "" ?>> 13.03 - Fotografia e cinematografia, inclusive revela????o</option>
                                            <option value="13.04" <?= $dados->fields['item_cod_lst'] == "1304" ? "selected" : "" ?>> 13.04 - Reprografia, microfilmagem e digitaliza????o. </option>
                                            <option value="13.05" <?= $dados->fields['item_cod_lst'] == "1305" ? "selected" : "" ?>> 13.05 - Composi????o gr??fica, fotocomposi????o, clicheria, z</option>
                                            <option value="14.01" <?= $dados->fields['item_cod_lst'] == "1401" ? "selected" : "" ?>> 14.01 - Lubrifica????o, limpeza, lustra????o, revis??o, carga</option>
                                            <option value="14.02" <?= $dados->fields['item_cod_lst'] == "1402" ? "selected" : "" ?>> 14.02 - Assist??ncia t??cnica. </option>
                                            <option value="14.03" <?= $dados->fields['item_cod_lst'] == "1403" ? "selected" : "" ?>> 14.03 - Recondicionamento de motores (exceto pe??as e par</option>
                                            <option value="14.04" <?= $dados->fields['item_cod_lst'] == "1404" ? "selected" : "" ?>> 14.04 - Recauchutagem ou regenera????o de pneus. </option>
                                            <option value="14.05" <?= $dados->fields['item_cod_lst'] == "1405" ? "selected" : "" ?>> 14.05 - Restaura????o, recondicionamento, acondicionamento</option>
                                            <option value="14.06" <?= $dados->fields['item_cod_lst'] == "1406" ? "selected" : "" ?>> 14.06 - Instala????o e montagem de aparelhos, m??quinas e e</option>
                                            <option value="14.07" <?= $dados->fields['item_cod_lst'] == "1407" ? "selected" : "" ?>> 14.07 - Coloca????o de molduras e cong??neres. </option>
                                            <option value="14.08" <?= $dados->fields['item_cod_lst'] == "1408" ? "selected" : "" ?>> 14.08 - Encaderna????o, grava????o e doura????o de livros, rev</option>
                                            <option value="14.09" <?= $dados->fields['item_cod_lst'] == "1409" ? "selected" : "" ?>> 14.09 - Alfaiataria e costura, quando o material for for</option>
                                            <option value="14.10" <?= $dados->fields['item_cod_lst'] == "1410" ? "selected" : "" ?>> 14.10 - Tinturaria e lavanderia. </option>
                                            <option value="14.11" <?= $dados->fields['item_cod_lst'] == "1411" ? "selected" : "" ?>> 14.11 - Tape??aria e reforma de estofamentos em geral. </option>
                                            <option value="14.12" <?= $dados->fields['item_cod_lst'] == "1412" ? "selected" : "" ?>> 14.12 - Funilaria e lanternagem. </option>
                                            <option value="14.13" <?= $dados->fields['item_cod_lst'] == "1413" ? "selected" : "" ?>> 14.13 - Carpintaria e serralheria. </option>
                                            <option value="15.01" <?= $dados->fields['item_cod_lst'] == "1501" ? "selected" : "" ?>> 15.01 - Administra????o de fundos quaisquer, de cons??rcio,</option>
                                            <option value="15.02" <?= $dados->fields['item_cod_lst'] == "1502" ? "selected" : "" ?>> 15.02 - Abertura de contas em geral, inclusive conta-cor</option>
                                            <option value="15.03" <?= $dados->fields['item_cod_lst'] == "1503" ? "selected" : "" ?>> 15.03 - Loca????o e manuten????o de cofres particulares, de </option>
                                            <option value="15.04" <?= $dados->fields['item_cod_lst'] == "1504" ? "selected" : "" ?>> 15.04 - Fornecimento ou emiss??o de atestados em geral, i</option>
                                            <option value="15.05" <?= $dados->fields['item_cod_lst'] == "1505" ? "selected" : "" ?>> 15.05 - Cadastro, elabora????o de ficha cadastral, renova??</option>
                                            <option value="15.06" <?= $dados->fields['item_cod_lst'] == "1506" ? "selected" : "" ?>> 15.06 - Emiss??o, reemiss??o e fornecimento de avisos, com</option>
                                            <option value="15.07" <?= $dados->fields['item_cod_lst'] == "1507" ? "selected" : "" ?>> 15.07 - Acesso, movimenta????o, atendimento e consulta a c</option>
                                            <option value="15.08" <?= $dados->fields['item_cod_lst'] == "1508" ? "selected" : "" ?>> 15.08 - Emiss??o, reemiss??o, altera????o, cess??o, substitui</option>
                                            <option value="15.09" <?= $dados->fields['item_cod_lst'] == "1509" ? "selected" : "" ?>> 15.09 - Arrendamento mercantil (leasing) de quaisquer be</option>
                                            <option value="15.10" <?= $dados->fields['item_cod_lst'] == "1510" ? "selected" : "" ?>> 15.10 - Servi??os relacionados a cobran??as, recebimentos </option>
                                            <option value="15.11" <?= $dados->fields['item_cod_lst'] == "1511" ? "selected" : "" ?>> 15.11 - Devolu????o de t??tulos, protesto de t??tulos, susta</option>
                                            <option value="15.12" <?= $dados->fields['item_cod_lst'] == "1512" ? "selected" : "" ?>> 15.12 - Cust??dia em geral, inclusive de t??tulos e valore</option>
                                            <option value="15.13" <?= $dados->fields['item_cod_lst'] == "1513" ? "selected" : "" ?>> 15.13 - Servi??os relacionados a opera????es de c??mbio em g</option>
                                            <option value="15.14" <?= $dados->fields['item_cod_lst'] == "1514" ? "selected" : "" ?>> 15.14 - Fornecimento, emiss??o, reemiss??o, renova????o e ma</option>
                                            <option value="15.15" <?= $dados->fields['item_cod_lst'] == "1515" ? "selected" : "" ?>> 15.15 - Compensa????o de cheques e t??tulos quaisquer; serv</option>
                                            <option value="15.16" <?= $dados->fields['item_cod_lst'] == "1516" ? "selected" : "" ?>> 15.16 - Emiss??o, reemiss??o, liquida????o, altera????o, cance</option>
                                            <option value="15.17" <?= $dados->fields['item_cod_lst'] == "1517" ? "selected" : "" ?>> 15.17 - Emiss??o, fornecimento, devolu????o, susta????o, canc</option>
                                            <option value="15.18" <?= $dados->fields['item_cod_lst'] == "1518" ? "selected" : "" ?>> 15.18 - Servi??os relacionados a cr??dito imobili??rio, ava</option>
                                            <option value="16.01" <?= $dados->fields['item_cod_lst'] == "1601" ? "selected" : "" ?>> 16.01 - Servi??os de transporte de natureza municipal. </option>
                                            <option value="17.01" <?= $dados->fields['item_cod_lst'] == "1701" ? "selected" : "" ?>> 17.01 - Assessoria ou consultoria de qualquer natureza, </option>
                                            <option value="17.02" <?= $dados->fields['item_cod_lst'] == "1702" ? "selected" : "" ?>> 17.02 - Datilografia, digita????o, estenografia, expedient</option>
                                            <option value="17.03" <?= $dados->fields['item_cod_lst'] == "1703" ? "selected" : "" ?>> 17.03 - Planejamento, coordena????o, programa????o ou organi</option>
                                            <option value="17.04" <?= $dados->fields['item_cod_lst'] == "1704" ? "selected" : "" ?>> 17.04 - Recrutamento, agenciamento, sele????o e coloca????o </option>
                                            <option value="17.05" <?= $dados->fields['item_cod_lst'] == "1705" ? "selected" : "" ?>> 17.05 - Fornecimento de m??o-de-obra, mesmo em car??ter te</option>
                                            <option value="17.06" <?= $dados->fields['item_cod_lst'] == "1706" ? "selected" : "" ?>> 17.06 - Propaganda e publicidade, inclusive promo????o de </option>
                                            <option value="17.07" <?= $dados->fields['item_cod_lst'] == "1707" ? "selected" : "" ?>> 17.07 - (VETADO) </option>
                                            <option value="17.08" <?= $dados->fields['item_cod_lst'] == "1708" ? "selected" : "" ?>> 17.08 - Franquia (franchising). </option>
                                            <option value="17.09" <?= $dados->fields['item_cod_lst'] == "1709" ? "selected" : "" ?>> 17.09 - Per??cias, laudos, exames t??cnicos e an??lises t??c</option>
                                            <option value="17.10" <?= $dados->fields['item_cod_lst'] == "1710" ? "selected" : "" ?>> 17.10 - Planejamento, organiza????o e administra????o de fei</option>
                                            <option value="17.11" <?= $dados->fields['item_cod_lst'] == "1711" ? "selected" : "" ?>> 17.11 - Organiza????o de festas e recep????es; buf?? (exceto </option>
                                            <option value="17.12" <?= $dados->fields['item_cod_lst'] == "1712" ? "selected" : "" ?>> 17.12 - Administra????o em geral, inclusive de bens e neg??</option>
                                            <option value="17.13" <?= $dados->fields['item_cod_lst'] == "1713" ? "selected" : "" ?>> 17.13 - Leil??o e cong??neres. </option>
                                            <option value="17.14" <?= $dados->fields['item_cod_lst'] == "1714" ? "selected" : "" ?>> 17.14 - Advocacia. </option>
                                            <option value="17.15" <?= $dados->fields['item_cod_lst'] == "1715" ? "selected" : "" ?>> 17.15 - Arbitragem de qualquer esp??cie, inclusive jur??di</option>
                                            <option value="17.16" <?= $dados->fields['item_cod_lst'] == "1716" ? "selected" : "" ?>> 17.16 - Auditoria. </option>
                                            <option value="17.17" <?= $dados->fields['item_cod_lst'] == "1717" ? "selected" : "" ?>> 17.17 - An??lise de Organiza????o e M??todos. </option>
                                            <option value="17.18" <?= $dados->fields['item_cod_lst'] == "1718" ? "selected" : "" ?>> 17.18 - Atu??ria e c??lculos t??cnicos de qualquer natureza</option>
                                            <option value="17.19" <?= $dados->fields['item_cod_lst'] == "1719" ? "selected" : "" ?>> 17.19 - Contabilidade, inclusive servi??os t??cnicos e aux</option>
                                            <option value="17.20" <?= $dados->fields['item_cod_lst'] == "1720" ? "selected" : "" ?>> 17.20 - Consultoria e assessoria econ??mica ou financeira</option>
                                            <option value="17.21" <?= $dados->fields['item_cod_lst'] == "1721" ? "selected" : "" ?>> 17.21 - Estat??stica. </option>
                                            <option value="17.22" <?= $dados->fields['item_cod_lst'] == "1722" ? "selected" : "" ?>> 17.22 - Cobran??a em geral. </option>
                                            <option value="17.23" <?= $dados->fields['item_cod_lst'] == "1723" ? "selected" : "" ?>> 17.23 - Assessoria, an??lise, avalia????o, atendimento, con</option>
                                            <option value="17.24" <?= $dados->fields['item_cod_lst'] == "1724" ? "selected" : "" ?>> 17.24 - Apresenta????o de palestras, confer??ncias, semin??r</option>
                                            <option value="18.01" <?= $dados->fields['item_cod_lst'] == "1801" ? "selected" : "" ?>> 18.01 - Servi??os de regula????o de sinistros vinculados a </option>
                                            <option value="19.01" <?= $dados->fields['item_cod_lst'] == "1901" ? "selected" : "" ?>> 19.01 - Servi??os de distribui????o e venda de bilhetes e d</option>
                                            <option value="20.01" <?= $dados->fields['item_cod_lst'] == "2001" ? "selected" : "" ?>> 20.01 - Servi??os portu??rios, ferroportu??rios, utiliza????o</option>
                                            <option value="20.02" <?= $dados->fields['item_cod_lst'] == "2002" ? "selected" : "" ?>> 20.02 - Servi??os aeroportu??rios, utiliza????o de aeroporto</option>
                                            <option value="20.03" <?= $dados->fields['item_cod_lst'] == "2003" ? "selected" : "" ?>> 20.03 - Servi??os de terminais rodovi??rios, ferrovi??rios,</option>
                                            <option value="21.01" <?= $dados->fields['item_cod_lst'] == "2101" ? "selected" : "" ?>> 21.01 - Servi??os de registros p??blicos, cartor??rios e no</option>
                                            <option value="22.01" <?= $dados->fields['item_cod_lst'] == "2201" ? "selected" : "" ?>> 22.01 - Servi??os de explora????o de rodovia mediante cobra</option>
                                            <option value="23.01" <?= $dados->fields['item_cod_lst'] == "2301" ? "selected" : "" ?>> 23.01 - Servi??os de programa????o e comunica????o visual, de</option>
                                            <option value="24.01" <?= $dados->fields['item_cod_lst'] == "2401" ? "selected" : "" ?>> 24.01 - Servi??os de chaveiros, confec????o de carimbos, pl</option>
                                            <option value="25.01" <?= $dados->fields['item_cod_lst'] == "2501" ? "selected" : "" ?>> 25.01 - Funerais, inclusive fornecimento de caix??o, urna</option>
                                            <option value="25.02" <?= $dados->fields['item_cod_lst'] == "2502" ? "selected" : "" ?>> 25.02 - Crema????o de corpos e partes de corpos cadav??rico</option>
                                            <option value="25.03" <?= $dados->fields['item_cod_lst'] == "2503" ? "selected" : "" ?>> 25.03 - Planos ou conv??nio funer??rios. </option>
                                            <option value="25.04" <?= $dados->fields['item_cod_lst'] == "2504" ? "selected" : "" ?>> 25.04 - Manuten????o e conserva????o de jazigos e cemit??rios</option>
                                            <option value="26.01" <?= $dados->fields['item_cod_lst'] == "2601" ? "selected" : "" ?>> 26.01 - Servi??os de coleta, remessa ou entrega de corres</option>
                                            <option value="27.01" <?= $dados->fields['item_cod_lst'] == "2701" ? "selected" : "" ?>> 27.01 - Servi??os de assist??ncia social. </option>
                                            <option value="28.01" <?= $dados->fields['item_cod_lst'] == "2801" ? "selected" : "" ?>> 28.01 - Servi??os de avalia????o de bens e servi??os de qual</option>
                                            <option value="29.01" <?= $dados->fields['item_cod_lst'] == "2901" ? "selected" : "" ?>> 29.01 - Servi??os de biblioteconomia. </option>
                                            <option value="30.01" <?= $dados->fields['item_cod_lst'] == "3001" ? "selected" : "" ?>> 30.01 - Servi??os de biologia, biotecnologia e qu??mica. </option>
                                            <option value="31.01" <?= $dados->fields['item_cod_lst'] == "3101" ? "selected" : "" ?>> 31.01 - Servi??os t??cnicos em edifica????es, eletr??nica, el</option>
                                            <option value="32.01" <?= $dados->fields['item_cod_lst'] == "3201" ? "selected" : "" ?>> 32.01 - Servi??os de desenhos t??cnicos. </option>
                                            <option value="33.01" <?= $dados->fields['item_cod_lst'] == "3301" ? "selected" : "" ?>> 33.01 - Servi??os de desembara??o aduaneiro, comiss??rios, </option>
                                            <option value="34.01" <?= $dados->fields['item_cod_lst'] == "3401" ? "selected" : "" ?>> 34.01 - Servi??os de investiga????es particulares, detetive</option>
                                            <option value="35.01" <?= $dados->fields['item_cod_lst'] == "3501" ? "selected" : "" ?>> 35.01 - Servi??os de reportagem, assessoria de imprensa, </option>
                                            <option value="36.01" <?= $dados->fields['item_cod_lst'] == "3601" ? "selected" : "" ?>> 36.01 - Servi??os de meteorologia. </option>
                                            <option value="37.01" <?= $dados->fields['item_cod_lst'] == "3701" ? "selected" : "" ?>> 37.01 - Servi??os de artistas, atletas, modelos e manequi</option>
                                            <option value="38.01" <?= $dados->fields['item_cod_lst'] == "3801" ? "selected" : "" ?>> 38.01 - Servi??os de museologia. </option>
                                            <option value="39.01" <?= $dados->fields['item_cod_lst'] == "3901" ? "selected" : "" ?>> 39.01 - Servi??os de ourivesaria e lapida????o (quando o ma</option>
                                            <option value="40.01" <?= $dados->fields['item_cod_lst'] == "4001" ? "selected" : "" ?>> 40.01 - Obras de arte sob encomenda. </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mb-2">
                                        <label for="item_situacao" class="requi">Situa????o:</label>
                                        <select class="form-control requeri " id="item_situacao" name="item_situacao" <?= $disabled ?> title="C??digo do servi??o conforme lista do Anexo I da Lei Complementar Federal n?? 116/2003">
                                            <option value="">Selecione</option>
                                            <option value="A" <?= ($dados->fields['item_situacao'] == "A" || $_SESSION['op'] == "i") ? "selected" : "" ?>> ATIVO </option>
                                            <option value="I" <?= $dados->fields['item_situacao'] == "I" ? "selected" : "" ?>> INATIVO </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="item_ncm" class="requi">NCM:</label>
                                        <input type="text" class="form-control search requeri" id="item_ncm" name="t_item" value="<?php print $dados->fields['ncm'] ?>" <?= $disabled ?> title="Nomenclatura Comum Mercosul" placeholder="Digite para Buscar C??digo NCM">
                                        <input type="hidden" class="form-control" id="item_ncm_id" name="item_ncm_id" value="<?php print $dados->fields['item_ncm'] ?>" <?= $disabled ?> title="CPF, CNPJ ou Outro/">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane margin-top-15 <?= ($_SESSION['aba'] == "aba-dados-gerenciais" ? "active" : "") ?>" id="dados_gerenciais" role="tabpanel">
                            <h4> Descri????es </h4>
                            <div class="row" style="margin-top: 10px">
                                <div class="row col-sm-12">
                                    <div class="col-sm-5  mb-2">
                                        <label>Fornecedor:</label>
                                        <input type="text" onkeydown="javascript: fMasc( this, mCNPJ );" class="form-control requeri unique" id="fornecedor" name="fornecedor" placeholder="BUSCAR POR CPF/CNPJ OU RAZ??O SOCIAL" />
                                    </div>
                                    <div class="col-sm-5  mb-2">
                                        <label>Descri????o:</label>
                                        <input type="text" class="form-control requeri unique" id="descricao_gerenciais" name="descricao_gerenciais" placeholder="INFORME A DESCRI????O" />
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-success" style="margin-top: 32px" id="btnDescricao">
                                            REGISTRAR
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin: 10px 10px 10px 2px;">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th class="text-center" colspan="8" style="background-color: #E0E0E0; border: 2px solid white; border-radius: 8px;">Descri????es</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left" width="30%"> Fornecedor </th>
                                                <th class="text-left" width="20%"> Data Cadastro</th>
                                                <th class="text-left" width="40%"> Descri????o</th>
                                                <th class="text-left" width="10%"> A????o</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left"> Fornecedor </td>
                                                <td class="text-left"> 00/00/0000 </td>
                                                <td class="text-left"> Descri????o </td>
                                                <td class="text-left">
                                                    <button type="button" class="btn btn-secondary btn-sm" id="btnExcluirDes">
                                                        EXCLUIR
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h4> Modulando as Unidades de Entrada e Valores de Convers??o </h4>
                            <div class="row" style="margin-top: 10px">
                                <div class="row col-sm-12">
                                    <div class="col-sm-4  mb-2">
                                        <label>Fornecedor:</label>
                                        <input type="text" onkeydown="javascript: fMasc( this, mCNPJ );" class="form-control requeri unique" id="fornecedorMod" name="fornecedorMod" placeholder="BUSCAR POR CPF/CPNJ OU RAZ??O SOCIAL " />
                                    </div>
                                    <div class="col-sm-3 form-group">
                                        <label for="entradaMod">Unidade de Entrada</label>
                                        <select class="form-control endereco" id="entradaMod" name="entradaMod">
                                            <option value="">SELECIONE </option>
                                            <option value="und1"> Unidade </option>
                                            <option value="und2"> Unidade </option>
                                            <option value="und4"> Unidade </option>
                                            <option value="und5"> Unidade </option>
                                            <option value="und5"> Unidade </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3  mb-2">
                                        <label>Valor Convers??o:</label>
                                        <input type="text" class="form-control requeri unique" id="conversao" name="conversao" placeholder="0000" onkeydown="javascript: fMasc( this, mNum );" />
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-success" style="margin-top: 32px" id="btnModulo">
                                            REGISTRAR
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-12" style="margin: 10px 10px 10px 2px;">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th class="text-center" colspan="8" style="background-color: #E0E0E0; border: 2px solid white; border-radius: 8px;">Unidades Cadastradas</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left" width="30%"> Fornecedor </th>
                                                <th class="text-left" width="20%"> Data Cadastro</th>
                                                <th class="text-left" width="20%"> Unidade</th>
                                                <th class="text-left" width="20%"> Convers??o</th>
                                                <th class="text-left" width="20%"> A????o</th>
                                            </tr>
                                            <tr>
                                                <td class="text-left"> Fornecedor </td>
                                                <td class="text-left"> 00/00/0000 </td>
                                                <td class="text-left"> Descri????o </td>
                                                <td class="text-left"> Descri????o </td>
                                                <td class="text-left"> Descri????o </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <h4> Estoque </h4>
                            <div class="row" style="margin-top: 10px">
                                <div class="row col-sm-12">
                                    <div class="col-sm-4  mb-2">
                                        <label>Estoque m??nimo</label>
                                        <input type="text" class="form-control requeri unique" id="estoque" name="estoque" onkeyup="calcularEstoque()" placeholder="0" />
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="estoque_baixa">Baixa autom??tica?</label>
                                        <select class="form-control endereco" id="estoque_baixa" name="estoque_baixa">
                                            <option value="">SELECIONE </option>
                                            <option value="simB"> SIM </option>
                                            <option value="n??oB"> N??O </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label for="baixo_estoque">Alerta de baixo estoque?</label>
                                        <select class="form-control endereco" id="baixo_estoque" name="baixo_estoque">
                                            <option value="">SELECIONE </option>
                                            <option value="simA"> SIM </option>
                                            <option value="n??oA"> N??O </option>
                                        </select>
                                    </div>
                                </div>
                                <h6> Especifica????es do item </h6>
                                <div class="row" style="margin-top: 10px">
                                    <div class="row col-sm-12">
                                        <div class="col-sm-4  mb-2">
                                            <label>Altura</label>
                                            <input type="text" class="form-control requeri unique" id="alturaItem" name="alturaItem" onkeyup="calcularAltura()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-4  mb-2">
                                            <label>Largura</label>
                                            <input type="text" class="form-control requeri unique" id="larguraItem" name="larguraItem" onkeyup="calcularLargura()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-4  mb-2">
                                            <label>Comprimento</label>
                                            <input type="text" class="form-control requeri unique" id="comprimentoItem" name="comprimentoItem" onkeyup="calcularComprimento()" placeholder="00,00" />
                                        </div>
                                    </div>
                                    <div class="row col-sm-12">
                                        <div class="col-sm-4  mb-2">
                                            <label>Densidade</label>
                                            <input type="text" class="form-control requeri unique" id="densidadeItem" name="densidadeItem" onkeyup="calcularDensidade()" placeholder="00,0" />
                                        </div>
                                        <div class="col-sm-4  mb-2">
                                            <label>Peso</label>
                                            <input type="text" class="form-control requeri unique" id="pesoItem" name="pesoItem" onkeyup="calcularPeso()" placeholder="00,0" />
                                        </div>
                                        <div class="col-sm-4  mb-2">
                                            <label>Data de Validade</label>
                                            <input type="date" class="form-control requeri unique" id="validadeItem" name="validadeItem" />
                                        </div>
                                    </div>
                                    <div class="row col-sm-12">
                                        <div class="col-sm-6  mb-2">
                                            <label>C??digo Etiqueta</label>
                                            <input type="text" class="form-control requeri unique" id="etiquetaItem" name="etiquetaItem" onkeydown="javascript: fMasc( this, mNum );" placeholder="0000" />
                                        </div>
                                        <div class="col-sm-5  mb-2" style="margin-left: 0px">
                                            <label>Lote</label>
                                            <input type="text" class="form-control requeri unique" id="loteItem" name="loteItem" onkeydown="javascript: fMasc( this, mNum );" placeholder="0000" />
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="button" class="btn btn-success" style="margin-top: 32px" id="btnEstoque">
                                                REGISTRAR
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane margin-top-15 <?= ($_SESSION['aba'] == "aba-dados-fiscais" ? "active" : "") ?>" id="dados_fiscais" role="tabpanel">
                            <div class="row">
                                <div class="row col-sm-12 escondido" style="margin-left: 5px;">
                                    <div class="col-sm-4  mb-2" style="margin-right: 10px;">
                                        <label>Texto Fiscal</label>
                                        <input type="text" class="form-control escondido" id="textoFiscalEntrada" name="textoFiscalEntrada" />
                                    </div>
                                    <div class="col-sm-3  mb-2" style="margin-right: 10px;">
                                        <label>Imposto</label>
                                        <input type="text" class="form-control escondido" id="impostoFiscalEntrada" name="impostoFiscalEntrada" />
                                    </div>
                                    <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                        <label for="tributoFiscalEntrada">Tributo</label>
                                        <select class="escondido form-control" id="tributoFiscalEntrada" name="tributoFiscalEntrada">
                                            <option value=""> SELECIONE</option>
                                            <option value="simT"> SIM </option>
                                            <option value="n??oT"> N??O </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                        <label for="iatFiscalEntrada">IAT</label>
                                        <select class="escondido form-control" id="iatFiscalEntrada" name="iatFiscalEntrada">
                                            <option value=""> SELECIONE</option>
                                            <option value="simI"> SIM </option>
                                            <option value="n??oI"> N??O </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                        <label for="ipptFiscalEntrada">IPPT</label>
                                        <select class="escondido form-control" id="ipptFiscalEntrada" name="ipptFiscalEntrada">
                                            <option value="">SELECIONE</option>
                                            <option value="simIP"> SIM </option>
                                            <option value="n??oIP"> N??O </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1 form-group" style="margin-right: 5px;">
                                        <label for="tipoFiscalEntrada" style="width: 100px">Tipo do Item</label>
                                        <select class="escondido form-control" id="tipoFiscalEntrada" name="tipoFiscalEntrada">
                                            <option value=""> SELECIONE</option>
                                            <option value="simA"> SIM </option>
                                            <option value="n??oA"> N??O </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <h5> Tributa????o </h5>
                                    <div class="col-sm-12" style="margin-right: 0px;">
                                        <hr>
                                    </div>
                                        </div>
                                    <div class="row col-sm-12" style="margin-left: 5px;">
                                        <div class="col-sm-4  mb-2" style="margin-right: 0px">
                                            <label>NCM</label>
                                            <input type="search" class="form-control requeri unique" id="ncmFiscal" name="ncmFiscal" />
                                        </div>
                                        <div class="col-sm-1  mb-2 buttonSize">
                                            <button class="btn btn-info" id="buscarNCM">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </div>
                                        <div class="col-sm-3  mb-2" style="margin-right: 0px;">
                                            <label>CEST</label>
                                            <input type="search" class="form-control requeri unique" id="cestFiscal" name="cestFiscal" />
                                        </div>
                                        <div class="col-sm-1  mb-2 buttonSize">
                                            <button class="btn btn-info" id="buscarCEST">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </div>
                                        <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                            <label for="cfopFiscal">CFOP</label>
                                            <select class="form-control endereco" id="cfopFiscal" name="cfopFiscal">
                                                <option value="">SELECIONE</option>
                                                <option value="simC"> SIM </option>
                                                <option value="n??oC"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                            <label for="cstFiscal">CST</label>
                                            <select class="form-control endereco" id="cstFiscal" name="cstFiscal">
                                                <option value=""> SELECIONE</option>
                                                <option value="simCS"> SIM </option>
                                                <option value="n??oCS"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                            <label for="csosnFiscal">CSOSN</label>
                                            <select class="form-control endereco" id="csosnFiscal" name="csosnFiscal">
                                                <option value=""> SELECIONE</option>
                                                <option value="simCSO"> SIM </option>
                                                <option value="n??oCSO"> N??O </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-sm-12" style="margin-left: 5px;">
                                        <div class="col-sm-4  mb-2" style="margin-right: 10px;">
                                            <label>Texto Fiscal</label>
                                            <input type="text" class="form-control requeri unique" id="textoFiscalSaida" name="textoFiscalSaida" />
                                        </div>
                                        <div class="col-sm-3  mb-2" style="margin-right: 10px;">
                                            <label>Imposto</label>
                                            <input type="text" class="form-control requeri unique" id="impostoFiscalSaida" name="impostoFiscalSaida" />
                                        </div>
                                        <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                            <label for="tributoFiscalSaida">Tributo</label>
                                            <select class="form-control endereco" id="tributoFiscalSaida" name="tributoFiscalSaida">
                                                <option value=""> SELECIONE</option>
                                                <option value="simT"> SIM </option>
                                                <option value="n??oT"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                            <label for="iatFiscalSaida">IAT</label>
                                            <select class="form-control endereco" id="iatFiscalSaida" name="iatFiscalSaida">
                                                <option value="">SELECIONE </option>
                                                <option value="simI"> SIM </option>
                                                <option value="n??oI"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 form-group" style="margin-right: 10px;">
                                            <label for="ipptFiscalSaida">IPPT</label>
                                            <select class="form-control endereco" id="ipptFiscalSaida" name="ipptFiscalSaida">
                                                <option value=""> SELECIONE</option>
                                                <option value="simIP"> SIM </option>
                                                <option value="n??oIP"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1 form-group" style="margin-right: 5px;">
                                            <label for="tipoFiscalSaida" style="width: 100px">Tipo do Item</label>
                                            <select class="form-control endereco" id="tipoFiscalSaida" name="tipoFiscal">
                                                <option value="">SELECIONE</option>
                                                <option value="simA"> </option>
                                                <option value="n??oA"> </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row col-sm-12" style="margin-left: 5px;">
                                        <div class="col-sm-2  mb-2" style="margin-right: 0px;">
                                            <label>Redu????o ICMS (%) </label>
                                            <input type="search" class="form-control requeri unique" id="icmsFiscal" name="icmsFiscal" onkeyup="calcularICMS()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-2  mb-2" style="margin-right: 0px;">
                                            <label>FCP (%)</label>
                                            <input type="search" class="form-control requeri unique" id="fcpFiscal" name="fcpFiscal" onkeyup="calcularFCP()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-2 form-group" style="margin-right: 0px;">
                                            <label for="cfopFiscal">Benef??cio Fiscal</label>
                                            <select class="form-control endereco" id="benFiscal" name="benFiscal">
                                                <option value="">SELECIONE</option>
                                                <option value="simBen"> SIM </option>
                                                <option value="n??oBen"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2  mb-2" style="margin-right: 0px;">
                                            <label>Redu????o ICMS EF %</label>
                                            <input type="search" class="form-control requeri unique" id="redFiscal" name="redFiscal" onkeyup="calcularICMSEF()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-2  mb-2" style="margin-right: 0px;">
                                            <label>Al??quota (%) </label>
                                            <input type="search" class="form-control requeri unique" id="aliqFiscal" name="aliqFiscal" onkeyup="calcularAliqPer()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-2  mb-2" style="margin-right: 0px;">
                                            <label>Al??quota FCP (%) </label>
                                            <input type="search" class="form-control requeri unique" id="aliqFcpFiscal" name="aliqFcpFiscal" onkeyup="calcularAliqFCP()" placeholder="00,00" />
                                        </div>
                                    </div>
                                    <h5> ISS - NFC-e / NF-e / SAT </h5>
                                    <div class="col-sm-12  mb-2" style="margin-right: 0px;">
                                        <hr>
                                    </div>
                                    <div class="row col-sm-12" style="margin-left: 5px;">
                                        <div class="col-sm-3  mb-2" style="margin-right: 0px;">
                                            <label>C??digo Servi??o</label>
                                            <input type="search" class="form-control requeri unique" id="codFiscal" name="codFiscal" />
                                        </div>
                                        <div class="col-sm-1  mb-2 buttonSize">
                                            <button class="btn btn-info" id="buscarCOD">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </div>
                                        <div class="col-sm-2  mb-2" style="margin-right: 0px;">
                                            <label>Exigibilidade do ISS</label>
                                            <input type="search" class="form-control requeri unique" id="issFiscal" name="issFiscal" />
                                        </div>
                                        <div class="col-sm-1  mb-2 buttonSize">
                                            <button class="btn btn-info" id="buscarISS">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </div>
                                        <div class="col-sm-2  mb-2" style="margin-right: 0px;">
                                            <label>Natureza do ISSQN</label>
                                            <input type="search" class="form-control requeri unique" id="issqnFiscal" name="issqnFiscal" />
                                        </div>
                                        <div class="col-sm-1  mb-2 buttonSize">
                                            <button class="btn btn-info" id="buscarISSQN">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </div>
                                        <div class="col-sm-2  mb-2" style="padding: 32px 0px 0px 0px;  margin-left: 10px">
                                            <input class="form-check-input" type="checkbox" id="incFiscal">
                                            <label class="form-check-label" for="incFiscal">Indicador de Incentivo fiscal</label>
                                        </div>
                                    </div>
                                    <h5> CST PIS </h5>
                                    <div class="col-sm-12  mb-2" style="margin-right: 0px;">
                                        <hr>
                                    </div>
                                    <div class="row col-sm-12" style="margin-left: 5px;">
                                        <div class="col-sm-3 form-group">
                                            <label for="cstpFiscal">CST PIS</label>
                                            <select class="form-control endereco" id="cstpFiscal" name="cstpFiscal">
                                                <option value="">SELECIONE </option>
                                                <option value="simCSTP"> SIM </option>
                                                <option value="n??oCSPT"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3  mb-2" style="margin-right: 0px;">
                                            <label for="cfopFiscal">Tipo de c??lculo</label>
                                            <select class="form-control endereco" id="tipoCalc" name="tipoCalc">
                                                <option value="">SELECIONE</option>
                                                <option value="simCalc"> SIM </option>
                                                <option value="n??oCalc"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3  mb-2">
                                            <label>Al??quota (%)</label>
                                            <input type="text" class="form-control requeri unique" id="aliqPorc" name="aliqPorc" onkeyup="calcularAliqPerPIS()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-3  mb-2">
                                            <label>Al??quota (R$)</label>
                                            <input type="text" class="form-control requeri unique" id="aliqRS" name="aliqRS" onKeyPress="return(moeda(this,'.',',',event))" placeholder="00,00" />
                                        </div>
                                    </div>
                                    <h5> CST COFINS </h5>
                                    <div class="col-sm-12  mb-2" style="margin-right: 0px;">
                                        <hr>
                                    </div>
                                    <div class="row col-sm-12" style="margin-left: 5px;">
                                        <div class="col-sm-3 form-group">
                                            <label for="cofinsCst">CST COFINS</label>
                                            <select class="form-control endereco" id="cofinsCst" name="cofinsCst">
                                                <option value="">SELECIONE </option>
                                                <option value="simCofins"> SIM </option>
                                                <option value="n??oCofins"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3  mb-2" style="margin-right: 0px;">
                                            <label for="calcCofins">Tipo de c??lculo</label>
                                            <select class="form-control endereco" id="calcCofins" name="calcCofins">
                                                <option value=""> SELECIONE</option>
                                                <option value="sCalCo"> SIM </option>
                                                <option value="nCalCo"> N??O </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3  mb-2">
                                            <label>Al??quota (%)</label>
                                            <input type="text" class="form-control requeri unique" id="porCofins" name="porCofins" onkeyup="calcularAliqPerCO()" placeholder="00,00" />
                                        </div>
                                        <div class="col-sm-3  mb-2">
                                            <label>Al??quota (R$)</label>
                                            <input type="text" class="form-control requeri unique" id="rsCofins" name="rsCofins" onKeyPress="return(moeda(this,'.',',',event))" placeholder="00,00" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane  margin-top-15 <?= ($_SESSION['aba'] == "aba-participante-endereco" ? "active" : "") ?>" id="participante_endereco" role="tabpanel">

                                <div class="row mb-2 text-center" <?php print !empty($_SESSION['id']) ? "hidden" : "" ?>>
                                    <div class="col-sm-12 text-center">
                                        <label class="text-center">
                                            <h4 class="text-center">Grave primeiramente os dados para preencher os dados de Endere??o!</h4>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-2" <?php print empty($_SESSION['id']) ? "hidden" : "" ?>>
                                    <div class="col-sm-12 row">

                                        <div class="col-sm-1 form-group">
                                            <label for="participante_endereco_tipo" class="requi">Tipo:</label>
                                            <select class="form-control endereco" id="participante_endereco_tipo" name="participante_endereco_tipo">
                                                <option value="">Selecione </option>
                                                <option value="1">1 - Faturamento </option>
                                                <option value="2">2 - Comercial </option>
                                                <option value="3">3 - Entrega </option>
                                            </select>
                                        </div>

                                        <div class="col-sm-1 form-group">
                                            <label for="participante_endereco_cep" class="requi">CEP:</label>
                                            <input type="text" class="form-control endereco" id="participante_endereco_cep" name="participante_endereco_cep" value="<?php print $dados->fields['participante_endereco_cep'] ?>" <?= $disabled ?> />
                                        </div>

                                        <div class="col-sm-1 form-group">
                                            <label for="participante_endereco_uf" class="requi">UF:</label>
                                            <input type="text" class="form-control  cep endereco" id="participante_endereco_uf" name="participante_endereco_uf" value="<?php print $dados->fields['participante_endereco_uf'] ?>" <?= $disabled ?> />
                                        </div>

                                        <div class="col-sm-2 form-group">
                                            <label for="participante_endereco_descricao" class="requi">Munic??pio:</label>
                                            <input type="text" class="form-control  cep endereco" id="participante_endereco_descricao" name="participante_endereco_descricao" value="<?php print $dados->fields['participante_endereco_descricao'] ?>" <?= $disabled ?> />
                                            <input type="hidden" class="form-control   endereco" id="participante_codigo_municipio" name="participante_codigo_municipio" value="<?php print $dados->fields['participante_codigo_municipio'] ?>" <?= $disabled ?> />
                                        </div>

                                        <div class="col-sm-3 form-group">
                                            <label for="participante_endereco_logradouro" class="requi">Endere??o ( Logradouro ):</label>
                                            <input type="text" class="form-control  cep endereco" id="participante_endereco_logradouro" name="participante_endereco_logradouro" value="<?php print $dados->fields['participante_endereco_logradouro'] ?>" <?= $disabled ?> />
                                        </div>


                                        <div class="col-sm-1 form-group">
                                            <label for="participante_endereco_numero" class="requi">N??mero:</label>
                                            <input type="text" class="form-control  cep endereco" id="participante_endereco_numero" name="participante_endereco_numero" value="<?php print $dados->fields['participante_endereco_numero'] ?>" <?= $disabled ?> />
                                        </div>

                                        <div class="col-sm-1 form-group">
                                            <label for="participante_endereco_bairro" class="requi">Bairro:</label>
                                            <input type="text" class="form-control  cep endereco" id="participante_endereco_bairro" name="participante_endereco_bairro" value="<?php print $dados->fields['participante_endereco_bairro'] ?>" <?= $disabled ?> />
                                        </div>

                                        <div class="col-sm-2 form-group">
                                            <label for="participante_endereco_complemento">Complemento:</label>
                                            <input type="text" class="form-control  cep endereco" id="participante_endereco_complemento" name="participante_endereco_complemento" value="<?php print $dados->fields['participante_endereco_complemento'] ?>" <?= $disabled ?> />
                                        </div>

                                        <div class="col-sm-12 form-group">
                                            <button type="button" class="btn btn-success" id="btnAdicionarEndereco" style="width: 100%;">
                                                <span class="fas fa-plus"></span> Adicionar Endere??o
                                            </button>
                                        </div>
                                        <div class="col-sm-12 form-group">
                                            <div class="col-sm-12 row text-center col-sm-auto">

                                                <table class="table" id="tableItens">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" width="10%">Tipo </th>
                                                            <th class="text-center" width="5%">UF </th>
                                                            <th class="text-center" width="5%">CEP </th>
                                                            <th class="text-center" width="10%">Munic??pio </th>
                                                            <th class="text-center" width="35%">Endere??o </th>
                                                            <th class="text-center" width="10%">N??mero </th>
                                                            <th class="text-center" width="10%">Bairro </th>
                                                            <th class="text-center" width="15%">Complemento </th>
                                                            <th class="text-center" width="5%"> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        if ($_SESSION['id'] != "") {
                                                            $sql = "SELECT 
                                                          CASE 
                                                                  WHEN participante_endereco_tipo  = '1' THEN 'FATURAMENTO'
                                                                  WHEN participante_endereco_tipo  = '2' THEN 'COMERCIAL'
                                                                  WHEN participante_endereco_tipo  = '3' THEN 'ENTREGA'
                                                          END AS tipo
                                                       ,	participante_endereco_cep 
                                                       ,	participante_endereco_uf              
                                                       ,	participante_codigo_municipio 
                                                       ,	participante_endereco_logradouro                          
                                                       ,	participante_endereco_numero  
                                                       ,	participante_endereco_bairro 
                                                       ,	participante_endereco_complemento 
                                                       ,	participante_endereco_id 
                                                       FROM t_participante_enderecos WHERE participante_id = '{$_SESSION['id']}' ORDER BY 1,2,3,4;";

                                                            #Executa a linha de busca no banco
                                                            $objDados = $bd->Execute($sql);

                                                            while (!$objDados->EOF) {

                                                        ?>


                                                                <tr>
                                                                    <td class="text-center"><?= $objDados->fields[0] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[1] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[2] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[3] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[4] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[5] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[6] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[7] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[8] ?></td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="btn btn-danger btnRemoveItem" name="<?= $objDados->fields['participante_endereco_id'] ?>"> <i class="fas fa-trash"></i> </button>
                                                                    </td>
                                                                </tr>
                                                        <?php

                                                                $objDados->MoveNext();
                                                            }
                                                        }
                                                        ?>


                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane  margin-top-15 <?= ($_SESSION['aba'] == "aba-participante-contato" ? "active" : "") ?>" id="participante_contato" role="tabpanel">
                                <div class="row mb-2 text-center" <?php print !empty($_SESSION['id']) ? "hidden" : "" ?>>
                                    <div class="col-sm-12 text-center">
                                        <label class="text-center">
                                            <h4 class="text-center">Grave primeiramente os dados para preencher os dados de Endere??o!</h4>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-2" <?php print empty($_SESSION['id']) ? "hidden" : "" ?>>
                                    <div class="col-sm-12 row">

                                        <div class="col-sm-2 form-group">
                                            <label for="participante_contato_tipo" class="requi">Tipo:</label>
                                            <select class="form-control endereco" id="participante_contato_tipo" name="participante_contato_tipo">
                                                <option value="">Selecione </option>
                                                <option value="1">1 - Telefone Fixo </option>
                                                <option value="2">2 - Celular </option>
                                                <option value="3">3 - E-mail </option>
                                            </select>
                                        </div>

                                        <div class="col-sm-4 form-group">
                                            <label for="participante_contato_descricao">Descri????o do Contato:</label>
                                            <input type="text" class="form-control telefone_fixo" id="participante_contato_descricao" name="participante_contato_descricao" value="<?php print $dados->fields['participante_contato_descricao'] ?>" <?= $disabled ?> />
                                            <input type="text" class="form-control escondido" id="participante_contato_descricao_email" name="participante_contato_descricao_email" value="<?php print $dados->fields['participante_contato_descricao'] ?>" <?= $disabled ?> />
                                        </div>
                                        <div class="col-sm-6 form-group" style="padding-top: 29.5px;">
                                            <button type="button" class="btn btn-info" id="btnAdicionarContato" style="width: 100%; ">
                                                <span class="fas fa-plus"></span> Adicionar Contato
                                            </button>
                                        </div>
                                        <div class="col-sm-12 form-group">
                                            <div class="col-sm-12 row text-center col-sm-auto">

                                                <table class="table" id="tableItensContato">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" width="10%">Tipo </th>
                                                            <th class="text-center" width="85%">Descri????o </th>
                                                            <th class="text-center" width="5%"> </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        if ($_SESSION['id'] != "") {

                                                            $sql = "SELECT 
                                                      participante_contato_id 
                                              ,	CASE 
                                                          WHEN participante_contato_tipo  = '1' THEN 'Telefone Fixo'
                                                          WHEN participante_contato_tipo  = '2' THEN 'Celular'
                                                          WHEN participante_contato_tipo  = '3' THEN 'E-mail'
                                                      END AS participante_contato_tipo
                                              ,	participante_contato_descricao 
                                                FROM t_participante_contato
                                               WHERE participante_id =  '{$_SESSION['id']}' ORDER BY 1,2,3";

                                                            #Executa a linha de busca no banco
                                                            $objDados = $bd->Execute($sql);


                                                            while (!$objDados->EOF) { ?>


                                                                <tr>
                                                                    <td class="text-center"><?= $objDados->fields[1] ?></td>
                                                                    <td class="text-center"><?= $objDados->fields[2] ?></td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="btn btn-danger btnRemoveItemContato" name="<?= $objDados->fields[0] ?>"> <i class="fas fa-trash"></i> </button>
                                                                    </td>
                                                                </tr>

                                                        <?php
                                                                $objDados->MoveNext();
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
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
                    <?php if ($_SESSION['op'] == "insert" || $_SESSION['op'] == "edit") { ?>
                        <div class="col-sm-2 ">
                            <button type="button" class="btn btn-primary form-control" id="btnSalvar">
                                <span class="fas fa-save"></span>
                                Salvar
                            </button>
                        </div>
                    <?php }
                    if ($_SESSION['op'] == "delete") { ?>
                        <div class="col-sm-2 ">
                            <button type="button" class="btn btn-danger form-control" id="btnExcluir">
                                <span class="fas fa-trash"></span>
                                Excluir
                            </button>
                        </div>
                    <?php } ?>
                    <div class="col-sm-2 ">
                        <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_itens','','', 'movimentacao','','')">
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
    $("button").on("click", function() {
        console.log("teste")
    });

    $(document).ready(function($) {


        //M??scaras e valida????es        
        $('#item_aliq_icms').mask('000.000.000.000.000,00', {
            reverse: true
        });
        $("#item_aliq_icms").change(function() {
            $("#value").html($(this).val().replace(/\D/g, ''))
        })

        //        $("#item_aliq_icms").priceFormat({ prefix: '% ', centsSeparator: ',', thousandsSeparator: '.', limit: 6, centsLimit: 2, clearPrefix: true });
        addMascarasCPF_CNPJ();

        $("#item_cest").mask("99.999.99");
        $(".telefone_fixo").mask("(99) 9999-9999");
        $("#participante_endereco_cep").mask("99.999-999");
        $("#participante_tipo").on("change", function() {
            addMascarasCPF_CNPJ();
        });



        $("#btnAdicionarEndereco").on("click", function() {
            movimentaItens("novo", "", "endereco");
        });
        $(".btnRemoveItem").on("click", function() {
            movimentaItens("delete", $(this).prop("name"), "endereco");
        });
        $("#btnAdicionarContato").on("click", function() {
            movimentaItens("novo", "", "contato");
        });
        $(".btnRemoveItemContato").on("click", function() {
            movimentaItens("delete", $(this).prop("name"), "contato");
        });

        $("#aba-participante-endereco, #aba-participante-contato").on("click", function() {
            $("#btnSalvar, #btnExcluir, #btnVoltar").hide();
        });
        $("#aba-participante-geral").on("click", function() {
            $("#btnSalvar, #btnExcluir, #btnVoltar").show();
        });



        function addMascarasCPF_CNPJ() {
            var tipo = $("#participante_tipo").val();

            if (tipo === "J") {
                $("#participante_codigo").mask("99.999.999/9999-99");
            } else if (tipo === "F") {
                $("#participante_codigo").mask("999.999.999-99");
            } else if (tipo === "E") {
                $("#participante_codigo").mask("999.9999");
            } else {
                $("#participante_codigo").mask("999.9999");
            }
        }


        function movimentaItens(tipo, id, method) {
            $.ajax({
                url: "<?= $_SERVER['localhost'] ?>/mmflow/_man/manutencao/mainAdmParticipante.php",
                type: "post",
                dataType: "text",
                data: {
                    op: method,
                    type: tipo,
                    id_movim: id,
                    participante_endereco_tipo: $("#participante_endereco_tipo").val(),
                    participante_endereco_cep: $("#participante_endereco_cep").val(),
                    participante_endereco_uf: $("#participante_endereco_uf").val(),
                    participante_codigo_municipio: $("#participante_codigo_municipio").val(),
                    participante_endereco_logradouro: $("#participante_endereco_logradouro").val(),
                    participante_endereco_numero: $("#participante_endereco_numero").val(),
                    participante_endereco_bairro: $("#participante_endereco_bairro").val(),
                    participante_endereco_complemento: $("#participante_endereco_complemento").val(),
                    participante_contato_tipo: $("#participante_contato_tipo").val(),
                    participante_contato_descricao: $("#participante_contato_descricao").val(),
                    participante_contato_descricao_email: $("#participante_contato_descricao_email").val()
                },
                success: function(retorno) {
                    location.reload();
                }
            });
        }

        //Fim - M??scaras e Valida????es               
        $("#participante_contato_tipo").on("click", function() {
            var value = $(this).val();

            $("#participante_contato_descricao_email").addClass("escondido");
            $("#participante_contato_descricao").removeClass("escondido");

            if (value == 1) {
                $("#participante_contato_descricao").attr("placeholder", "Insira o contato telef??nico.");
                $("#participante_contato_descricao").mask("(18) 9999-9999");
            } else if (value == 2) {
                $("#participante_contato_descricao").attr("placeholder", "Insira o n??mero do celular!");
                $("#participante_contato_descricao").mask("(18) 9 9999-9999");
            } else if (value == 3) {
                $("#participante_contato_descricao").addClass("escondido");
                $("#participante_contato_descricao_email").removeClass("escondido");
                $("#participante_contato_descricao_email").attr("placeholder", "Inserir um e-mail v??lido!");
            }

        });

        //Fun????o que valida os dados inseridos no banco de dados.
        $(".unique").on("change", function() {
            var v1 = "t_item";
            var v2 = $(this).prop("name");
            var v3 = "=";
            var v4 = $(this).val();
            var v = "duplicate";

            validaData(v1, v2, v3, v4, v);
        });

        $("#participante_endereco_cep").on("change", function() {
            $(".cep").prop("disabled", true);

            $.ajax({
                url: "<?= $_SERVER['localhost'] ?>/mmflow/_man/rest_api/api_cep_correios.php",
                type: "post",
                dataType: "json",
                data: {
                    cep: $(this).val()
                },
                success: function(retorno) {

                    $(".cep").prop("disabled", false);
                    $("#participante_endereco_uf").val(retorno.dados.estado);
                    $("#participante_endereco_descricao").val(retorno.dados.cod_cidade + " - " + retorno.dados.cidade);
                    $("#participante_codigo_municipio").val(retorno.dados.cod_cidade);
                }
            });
        });

        $(".search").on("keypress", function() {
            var table = $(this).prop("name");
            var input = $(this).prop("id");

            $("#" + input).removeClass("alert-success");

            $(".search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/search/_searchData.php",
                        type: "post",
                        dataType: "json",
                        data: {
                            descricao: request.term,
                            table: table,
                            tipo: "ncm"
                        },
                        success: function(data) {
                            response($.map(data.dados, function(item) {
                                return {
                                    id: item.ret_1,
                                    value: item.ret_1 + ' - ' + item.ret_2
                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $('#item_ncm_id').val(ui.item.id);
                    $("#" + input).addClass("alert-success");
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