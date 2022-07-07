<!-- Main content -->

<head>
    <style>
        @media only screen and (min-width: 576px) {
            .labels {
                margin: 0px 15px 0px 0px;
            }

            .margin {
                margin: 0px 10px 0px 33px;
            }

            .marginEnd {
                margin: 0px 10px 0px 30px;
            }

            .marginBtn {
                margin: 0px 30px 0px 30px;
            }
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

        function mascara(t, mask) {
            var i = t.value.length;
            var saida = mask.substring(1, 0);
            var texto = mask.substring(i)
            if (texto.substring(0, 1) != saida) {
                t.value += texto.substring(0, 1);
            }
        }
    </script>
</head>
<section class="content">
    <!-- INICIAMOS O MODO TELA -->
    <?php
    if ($_SESSION['op'] == "") {
        if (!empty($_POST['filtro_busca'])) {
            $filtro_busca = retira_caracteres($_POST['filtro_busca']);
            $where =
                "WHERE   participante_id IS NOT NULL 
                AND ( participante_codigo     ILIKE '%{$filtro_busca}%' 
                   OR participante_nome       ILIKE '%{$filtro_busca}%' )";
        }
    ?>

        <!-- Default box -->
        <div class="card body-view">
            <div class="card-header">
                <form role="search" method="post" action="menu_sys.php">
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_participantes','insert','', 'movimentacao','','')">
                                <span class="fas fa-plus"></span>
                                Novo Item
                            </button>
                        </div>
                        <div class="col-sm-8">
                            <div class="col-sm-12">
                                <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $_POST['filtro_busca'] ?>" placeholder="Busque pela Razão Social o CNPJ..." />
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
                #Preparamos o filtro da pesquisa
                $intPaginaAtual = ($_SESSION['p']);
                $intPaginaAtual = filter_var($intPaginaAtual, FILTER_VALIDATE_INT);
                $intLimite      = 10;
                $intInicio      = ($intPaginaAtual != '' ? (($intPaginaAtual - 1) * $intLimite) : 0);

                #buscamos os dados
                $sql = "SELECT 	participante_id                            ,   participante_codigo                            ,   participante_nome
                    ,   participante_codigo_pais                   ,   participante_tipo                              ,   participante_ie
                    ,   participante_ie_st                         ,   participante_suframa                           ,   participante_nit
                    ,   participante_im                            
                    ,   CASE participante_cliente    WHEN 'S' THEN 'SIM' ELSE 'NAO' END AS participante_cliente
                    ,   CASE participante_fornecedor WHEN 'S' THEN 'SIM' ELSE 'NAO' END AS participante_fornecedor                    
                    ,   participante_representante
                FROM    t_participante {$where} 
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
                                    <th width="03%" class="text-center">Tipo </th>
                                    <th width="15%" class="text-left">Código </th>
                                    <th width="41%" class="text-left">Nome </th>
                                    <th width="07%" class="text-center">Cliente </th>
                                    <th width="07%" class="text-center">Fornecedor </th>
                                    <th width="08%" class="text-center">IE </th>
                                    <th width="19%" class="text-center">Ações </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($dados->RecordCount() > 0) {
                                    while (!$dados->EOF) { ?>
                                        <tr>
                                            <td class="text-center"><?= $dados->fields['participante_tipo']             ?></td>
                                            <td class="text-left"><?= formataCpfCnpj($dados->fields['participante_codigo'], $dados->fields['participante_tipo'])    ?></td>
                                            <td class="text-left"><?= $dados->fields['participante_nome']             ?></td>
                                            <td class="text-center"><?= $dados->fields['participante_cliente']          ?></td>
                                            <td class="text-center"><?= $dados->fields['participante_fornecedor']       ?></td>
                                            <td class="text-center"><?= $dados->fields['participante_ie']               ?></td>
                                            <td class="text-center">
                                                <button class="btn btn-success" onclick="movPage('adm_participantes','view','<?= $dados->fields['participante_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-info" onclick="movPage('adm_participantes','edit','<?= $dados->fields['participante_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-danger" onclick="movPage('adm_participantes','delete','<?= $dados->fields['participante_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar.">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php
                                        $dados->MoveNext();
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Não existem dados a serem listados!!!</td>
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
            $sql = "SELECT 	participante_id                            ,   cpf_cnpj(participante_codigo,'') AS participante_codigo                           ,   participante_nome
                    ,   participante_codigo_pais                   ,   participante_tipo                              ,   participante_ie
                    ,   participante_ie_st                         ,   participante_suframa                           ,   participante_nit
                    ,   participante_im                            ,   participante_cliente                           ,   participante_fornecedor        , participante_funcionario
                    ,   participante_cliente
                    ,   participante_representante                 ,   participante_codigo_pais||' - '||pais_nome AS participante_pais_descricao
                    ,   participante_cargo_id
                    ,   participante_dpto_id
                    ,   participante_func_dt_adm
                    ,   participante_func_dt_nasc
                FROM   t_participante  
                INNER JOIN t_paises AS pais ON ( pais.pais_codigo::Text = t_participante.participante_codigo_pais)
                WHERE participante_id = '{$_SESSION['id']}';";

            #Resgata os valores do Banco
            $dados = $bd->Execute($sql);
        }

        #Validamos as funcionalidades          
        if ($_SESSION["op"] == "view") {
            $description = "Visualização dos ";
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
                <form action="<?= $_SERVER['localhost'] ?>/mmflow/_man/manutencao/mainAdmParticipante.php" method="post" id="frmDados">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#participante_geral" id="aba-participante-geral" role="tab" data-toggle="tab" class="nav-link <?= ($_SESSION['aba'] == "" ? "active" : "") ?>">Dados Gerais</a>
                        </li>
                        <li class="nav-item">
                            <a href="#participante_endereco" id="aba-participante-endereco" role="tab" data-toggle="tab" class="nav-link <?= ($_SESSION['aba'] == "aba-participante-endereco" ? "active" : "") ?>">Endereço</a>
                        </li>
                        <li class="nav-item">
                            <a href="#participante_contato" id="aba-participante-contato" role="tab" data-toggle="tab" class="nav-link <?= ($_SESSION['aba'] == "aba-participante-contato" ? "active" : "") ?>">Contato</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane <?= ($_SESSION['aba'] == "" ? "active" : "") ?> margin-top-15" id="participante_geral" role="tabpanel">
                            <div class="row">
                                <div class="row col-sm-12" style="margin-top:20px">
                                    <div class="col-sm-2 mb-2 margin">
                                        <label for="participante_tipo" class="requi">Tipo Pessoa:</label>
                                        <select class="form-control requeri" id="participante_tipo" name="participante_tipo">
                                            <option value="">Selecione</option>
                                            <option value="F" <?php print $dados->fields['participante_tipo'] == "F" ? "selected" : "" ?>>Física </option>
                                            <option value="J" <?php print $dados->fields['participante_tipo'] == "J" ? "selected" : "" ?>>Jurídica</option>
                                            <option value="E" <?php print $dados->fields['participante_tipo'] == "E" ? "selected" : "" ?>>Exterior</option>
                                            <option value="O" <?php print $dados->fields['participante_tipo'] == "O" ? "selected" : "" ?>>Outros </option>
                                        </select>
                                        <input type="hidden" id="op" name="op" value="<?php print $_SESSION['op'] ?>" />
                                    </div>
                                    <div class="col-sm-3  mb-2 labels">
                                        <label for="participante_nome" class="requi">Nome Participante:</label>
                                        <input type="text" class="form-control requeri" id="participante_nome" name="participante_nome" value="<?php print $dados->fields['participante_nome'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-2  mb-2 labels">
                                        <label for="participante_funcionario" class="requi">É Funcionário?</label>
                                        <select class="form-control requeri" id="participante_funcionario" name="participante_funcionario">
                                            <option value=""> Selecione </option>
                                            <option value="S" <?php print $dados->fields['participante_funcionario'] == "S" ? "selected" : "" ?>>SIM </option>
                                            <option value="N" <?php print $dados->fields['participante_funcionario'] == "N" ? "selected" : "" ?>>NÃO</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2  mb-2 labels">
                                        <label for="participante_cliente" class="requi">É Cliente?</label>
                                        <select class="form-control requeri" id="participante_cliente" name="participante_cliente">
                                            <option value=""> Selecione </option>
                                            <option value="S" <?php print $dados->fields['participante_cliente'] == "S" ? "selected" : "" ?>>SIM </option>
                                            <option value="N" <?php print $dados->fields['participante_cliente'] == "N" ? "selected" : "" ?>>NÃO</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2  mb-2">
                                        <label for="participante_fornecedor" class="requi">É Fornecedor?</label>
                                        <select class="form-control requeri" id="participante_fornecedor" name="participante_fornecedor">
                                            <option value=""> Selecione </option>
                                            <option value="S" <?php print $dados->fields['participante_fornecedor'] == "S" ? "selected" : "" ?>>SIM </option>
                                            <option value="N" <?php print $dados->fields['participante_fornecedor'] == "N" ? "selected" : "" ?>>NÃO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-sm-12">
                                    <div class="col-sm-2 mb-2 margin">
                                        <label for="participante_codigo" class="requi" id="text_cod_par">Código Parcipante:</label>
                                        <input type="text" class="form-control requeri" id="participante_codigo" name="participante_codigo" value="<?php print $dados->fields['participante_codigo'] ?>" <?= $disabled ?> title="CPF, CNPJ ou Outro/" onkeypress="maskcpfcnpj(this, mcpfcnpj);" onblur="maskcpfcnpj(this, mcpfcnpj);">
                                    </div>
                                    <div class="col-sm-3 form-group labels">
                                        <label for="participante_ie" class="requi">Inscrição Estadual:</label>
                                        <input type="text" class="form-control requeri" id="participante_ie" name="participante_ie" value="<?php print $dados->fields['participante_ie'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-2 form-group labels">
                                        <label for="participante_ie_st" style="width: 200px">Inscrição Estadual (ST):</label>
                                        <input type="text" class="form-control " id="participante_ie_st" name="participante_ie_st" onkeydown="javascript: fMasc( this, mNum );" value="<?php print $dados->fields['participante_ie_st'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-2 form-group labels" style="position: sticky">
                                        <label for="participante_im">Inscrição Municipal:</label>
                                        <input type="text" class="form-control " id="participante_im" name="participante_im" onkeydown="javascript: fMasc( this, mNum );" value="<?php print $dados->fields['participante_im'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-2 form-group">
                                        <label for="participante_suframa">SUFRAMA:</label>
                                        <input type="text" class="form-control " id="participante_suframa" name="participante_suframa" value="<?php print $dados->fields['participante_suframa'] ?>" <?= $disabled ?> />
                                    </div>
                                </div>
                            </div>
                            <div class="row escondido" id="parametros_funcionario">
                                <div class="row col-sm-12">
                                    <div class="col-sm-2 mb-2 margin">
                                        <label for="participante_cargo_id" class="requi">Cargo:</label>
                                        <select class="form-control " id="participante_cargo_id" name="participante_cargo_id" <?= $disabled ?>>
                                            <option value="">Selecione</option>
                                            <?php
                                            $dadosCargo = $bd->Execute($sql = "SELECT cargo_id, cargo_nome  FROM t_cargos td WHERE cargo_ativo = 'S' ORDER BY 1");

                                            while (!$dadosCargo->EOF) {

                                                print '<option value="' . $dadosCargo->fields['cargo_id'] . '"' . ($dadosCargo->fields['cargo_id'] == $dados->fields['participante_cargo_id'] ? "selected" : "") . '>' . $dadosCargo->fields['cargo_id'] . ' - ' . $dadosCargo->fields['cargo_nome'] . '</option>';

                                                $dadosCargo->MoveNext();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 mb-2 labels">
                                        <label for="participante_dpto_id" class="requi">Departamento:</label>
                                        <select class="form-control " id="participante_dpto_id" name="participante_dpto_id" <?= $disabled ?>>
                                            <option value="">Selecione</option>
                                            <?php
                                            $dadosDpto = $bd->Execute($sql = "SELECT dpto_id, dpto_nome, dpto_descricao  FROM t_departamentos td WHERE dpto_ativo = 'S' ORDER BY 1");

                                            while (!$dadosDpto->EOF) {

                                                print '<option value="' . $dadosDpto->fields['dpto_id'] . '"' . ($dadosDpto->fields['dpto_id'] == $dados->fields['participante_dpto_id'] ? "selected" : "") . '>' . $dadosDpto->fields['dpto_id'] . ' - ' . $dadosDpto->fields['dpto_nome'] . '</option>';

                                                $dadosDpto->MoveNext();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 mb-2 labels">
                                        <label for="participante_func_dt_adm" class="requi">Dt Admissão:</label>
                                        <input type="date" class="form-control" id="participante_func_dt_adm" name="participante_func_dt_adm" value="<?php print $dados->fields['participante_func_dt_adm'] ?>" <?= $disabled ?> placeholder="Busque pelo Nome ou Código do Pais" />
                                    </div>
                                    <div class="col-sm-2 mb-2">
                                        <label for="participante_func_dt_nasc" class="requi">Dt Nascimento:</label>
                                        <input type="date" class="form-control" id="participante_func_dt_nasc" name="participante_func_dt_nasc" value="<?php print $dados->fields['participante_func_dt_nasc'] ?>" <?= $disabled ?> placeholder="Busque pelo Nome ou Código do Pais" />
                                    </div>
                                </div>
                            </div>
                            <div class="row col-sm-12">
                                <div class="col-sm-2 form-group margin">
                                    <label for="participante_nit">Número NIT:</label>
                                    <input type="text" class="form-control unique" id="participante_nit" name="participante_nit" onkeydown="javascript: fMasc( this, mNum );" value="<?php print $dados->fields['participante_nit'] ?>" <?= $disabled ?> title="'Número de Identificação do Trabalhador, Pis, Pasep, SUS'" />
                                </div>
                                <div class="col-sm-3 mb-2 labels">
                                    <label for="participante_situacao" class="requi">Situação Empresa:</label>
                                    <select class="form-control requeri " id="participante_situacao" name="participante_situacao" <?= $disabled ?>>
                                        <option value="" <?php print $_SESSION['id'] != "" ? "disabled" : "" ?>>Selecione</option>
                                        <option value="1" <?php print $dados->fields['participante_situacao'] == "1" ? "selected" : ""  ?>>1 - Ativo</option>
                                        <option value="2" <?php print $dados->fields['participante_situacao'] == "2" ? "selected" : ""  ?>>2 - Inativo</option>
                                        <option value="3" <?php print $dados->fields['participante_situacao'] == "2" ? "selected" : ""  ?>>3 - Inadimplente</option>
                                    </select>
                                </div>
                                <div class="col-sm-2  mb-2 labels">
                                    <label for="participante_busca" class="requi">Código do País:</label>
                                    <input type="text" class="form-control   search " id="participante_busca" name="t_pais" value="<?php print $dados->fields['participante_pais_descricao'] ?>" <?= $disabled ?> placeholder="Busque pelo Nome ou Código do Pais" />
                                    <input type="hidden" class="form-control  require" id="participante_codigo_pais" name="participante_codigo_pais" value="<?php print $dados->fields['participante_codigo_pais'] ?>" <?= $disabled ?> />
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane  margin-top-12 <?= ($_SESSION['aba'] == "aba-participante-endereco" ? "active" : "") ?>" id="participante_endereco" role="tabpanel">

                            <div class="row mb-2 text-center" <?php print !empty($_SESSION['id']) ? "hidden" : "" ?>>
                                <div class="col-sm-12 text-center">
                                    <label class="text-center">
                                        <h4 class="text-center">Grave primeiramente os dados para preencher os dados de Endereço!</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="row mb-2" <?php print empty($_SESSION['id']) ? "hidden" : "" ?> style="margin: 20px 0px 20px 0px">
                                <div class="col-sm-14 row" style="margin: 2px 0px 0px 0px">
                                    <div class="col-sm-3 form-group marginEnd">
                                        <label for="participante_endereco_tipo" class="requi">Tipo:</label>
                                        <select class="form-control endereco" id="participante_endereco_tipo" name="participante_endereco_tipo">
                                            <option value="">Selecione </option>
                                            <option value="1">1 - Faturamento </option>
                                            <option value="2">2 - Comercial </option>
                                            <option value="3">3 - Entrega </option>
                                            <option value="4">4 - Residencial </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 form-group labels">
                                        <label for="participante_endereco_cep" class="requi">CEP:</label>
                                        <input type="text" class="form-control endereco" id="participante_endereco_cep" name="participante_endereco_cep" onkeypress="mascara(this, '#####-###')" maxlength="9" value="<?php print $dados->fields['participante_endereco_cep'] ?>" <?= $disabled ?> />
                                    </div>

                                    <div class="col-sm-2 form-group labels">
                                        <label for="participante_endereco_uf" class="requi">UF:</label>
                                        <input type="text" class="form-control  cep endereco" id="participante_endereco_uf" name="participante_endereco_uf" value="<?php print $dados->fields['participante_endereco_uf'] ?>" <?= $disabled ?> />
                                    </div>

                                    <div class="col-sm-3 form-group labels">
                                        <label for="participante_endereco_descricao" class="requi" style="position: sticky">Município:</label>
                                        <input type="text" class="form-control  cep endereco" id="participante_endereco_descricao" name="participante_endereco_descricao" value="<?php print $dados->fields['participante_endereco_descricao'] ?>" <?= $disabled ?> />
                                        <input type="hidden" class="form-control   endereco" id="participante_codigo_municipio" name="participante_codigo_municipio" value="<?php print $dados->fields['participante_codigo_municipio'] ?>" <?= $disabled ?> />
                                    </div>
                                </div>
                                <div class="col-sm-14 row" style="margin: 10px 0px 0px 0px">
                                    <div class="col-sm-3 form-group marginEnd">
                                        <label for="participante_endereco_logradouro" class="requi">Endereço ( Logradouro ):</label>
                                        <input type="text" class="form-control  cep endereco" id="participante_endereco_logradouro" name="participante_endereco_logradouro" value="<?php print $dados->fields['participante_endereco_logradouro'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-3 form-group labels">
                                        <label for="participante_endereco_bairro" class="requi">Bairro:</label>
                                        <input type="text" class="form-control  cep endereco" id="participante_endereco_bairro" name="participante_endereco_bairro" value="<?php print $dados->fields['participante_endereco_bairro'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-2 form-group labels">
                                        <label for="participante_endereco_numero" class="requi">Número:</label>
                                        <input type="text" class="form-control  cep endereco" id="participante_endereco_numero" name="participante_endereco_numero" onkeydown="javascript: fMasc( this, mNum );" value="<?php print $dados->fields['participante_endereco_numero'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-3 form-group labels">
                                        <label for="participante_endereco_complemento">Complemento:</label>
                                        <input type="text" class="form-control  cep endereco" id="participante_endereco_complemento" name="participante_endereco_complemento" value="<?php print $dados->fields['participante_endereco_complemento'] ?>" <?= $disabled ?> />
                                    </div>

                                    <div class="col-sm-12 form-group" style="margin: 20px 0px 15px 20px">
                                        <button type="button" class="btn btn-success" id="btnAdicionarEndereco" style="width: 95%;margin: 0px 0px 0px 12px">
                                            <span class="fas fa-plus"></span> Adicionar Endereço
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
                                                        <th class="text-center" width="10%">Município </th>
                                                        <th class="text-center" width="35%">Endereço </th>
                                                        <th class="text-center" width="10%">Número </th>
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
                                        <h4 class="text-center">Grave primeiramente os dados para preencher os dados de Endereço!</h4>
                                    </label>
                                </div>
                            </div>
                            <div class="row mb-2" <?php print empty($_SESSION['id']) ? "hidden" : "" ?>>
                                <div class="col-sm-12 row" style="margin: 20px 0px 0px 0px">
                                    <div class="col-sm-3 form-group margin">
                                        <label for="participante_contato_tipo" class="requi">Tipo:</label>
                                        <select class="form-control endereco" id="participante_contato_tipo" name="participante_contato_tipo">
                                            <option value="">Selecione </option>
                                            <option value="1">1 - Telefone Fixo </option>
                                            <option value="2">2 - Celular </option>
                                            <option value="3">3 - E-mail </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 form-group labels">
                                        <label for="participante_contato_descricao">Descrição do Contato:</label>
                                        <input type="text" class="form-control telefone_fixo" id="participante_contato_descricao" name="participante_contato_descricao" value="<?php print $dados->fields['participante_contato_descricao'] ?>" <?= $disabled ?> />
                                    </div>
                                    <div class="col-sm-4 form-group labels">
                                        <label for="participante_contato_descricao"> </label>
                                        <input type="text" class="form-control escondido" id="participante_contato_descricao_email" name="participante_contato_descricao_email" value="<?php print $dados->fields['participante_contato_descricao'] ?>" <?= $disabled ?> style="margin: 8px 0px 0px 0px" />
                                    </div>
                                    <div class="col-sm-12 form-group" style="padding-top: 29.5px;">
                                        <button type="button" class="btn btn-info marginBtn" id="btnAdicionarContato" style="width: 94%;">
                                            <span class="fas fa-plus"></span> Adicionar Contato
                                        </button>
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        <div class="col-sm-12 row text-center col-sm-auto">
                                            <table class="table" id="tableItensContato">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="10%">Tipo </th>
                                                        <th class="text-center" width="85%">Descrição </th>
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
                        <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_participantes','','', 'movimentacao','','')">
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
    $(document).ready(function($) {


        //Máscaras e validações    
        if ($("#op").val() != "insert") addMascarasCPF_CNPJ();
        validaFuncionario();

        $("#empresa_cep").mask("99.999-999");
        $(".telefone_fixo").mask("(99) 9999-9999");
        $("#participante_endereco_cep").mask("99.999-999");
        $("#participante_tipo").on("change", function() {
            addMascarasCPF_CNPJ();
        });
        $("#participante_funcionario").on("change", function() {
            validaFuncionario();
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
            $("#text_cod_par").html("Código Participante:");


            if (tipo === "J") {
                console.log("Entrou")
                $("#participante_codigo").mask("99.999.999/9999-99");
                $("#text_cod_par").html("CNPJ Participante:");
            } else if (tipo === "F") {
                $("#participante_codigo").mask("999.999.999-99");
                $("#text_cod_par").html("CPF Participante:");
            } else if (tipo === "E") {
                $("#participante_codigo").mask("999.9999");
            } else {
                $("#participante_codigo").mask("999.9999");
            }
        }

        //Validamos a apresentação dos campos relacionados a funcionários
        function validaFuncionario() {
            var funcionario = $("#participante_funcionario").val();

            $("#parametros_funcionario").addClass("escondido");
            console.log(funcionario);
            exit;
            if (funcionario == "S") $("#parametros_funcionario").removeClass("escondido");

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

        //Fim - Máscaras e Validações               
        $("#participante_contato_tipo").on("click", function() {
            var value = $(this).val();

            $("#participante_contato_descricao_email").addClass("escondido");
            $("#participante_contato_descricao").removeClass("escondido");

            if (value == 1) {
                $("#participante_contato_descricao").attr("placeholder", "Insira o contato telefônico.");
                $("#participante_contato_descricao").mask("(18) 9999-9999");
            } else if (value == 2) {
                $("#participante_contato_descricao").attr("placeholder", "Insira o número do celular!");
                $("#participante_contato_descricao").mask("(18) 9 9999-9999");
            } else if (value == 3) {
                $("#participante_contato_descricao").addClass("escondido");
                $("#participante_contato_descricao_email").removeClass("escondido");
                $("#participante_contato_descricao_email").attr("placeholder", "Inserir um e-mail válido!");
            }

        });

        //Função que valida os dados inseridos no banco de dados.
        $(".unique").on("change", function() {
            var v1 = "t_participante";
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
                            tipo: "codigo_pais"
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
                    $('#participante_codigo_pais').val(ui.item.id);
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