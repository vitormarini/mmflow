<!-- Main content -->
<section class="content">

   <!-- INICIAMOS O MODO TELA -->
    <?php  if ( $_SESSION['op'] == "" ){

      $buscas = explode("&",$_SESSION["buscas"]);
      $filtro_busca = $where = "";
      if ( count($buscas) > 0 ){
          $where = 
          "WHERE item_id IS NOT NULL 
             AND ( item_codigo    ILIKE '%".explode("=", $buscas[0])[1]."%' 
                OR item_descricao ILIKE '%".explode("=", $buscas[0])[1]."%' 
                OR item_ncm       ILIKE '%".explode("=", $buscas[0])[1]."%' )";

          $filtro_busca = explode("=", $buscas[0])[1];
      } 
    ?>
    <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">          
            <div class="row">
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_itens','insert','', 'movimentacao','','')">
                        <span class="fas fa-plus"></span>
                        Novo Item
                    </button>                  
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-12">                        
                        <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $filtro_busca?>" placeholder="Busque pelo Código, Descrição, NCM..."/>
                    </div>
                </div>
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-info buscas" id="btnBusca" onclick="movPage('adm_itens','','', 'movimentacao','','')">
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
             $sql = "SELECT item_id             ,   item_codigo		,   item_descricao 
                        ,   item_codigo_barra 	,   item_und_inv	,   item_tipo 
                        ,   item_ncm 		,   item_ex_ipi		,   item_cod_gen 
                        ,   item_cod_lst 	,   item_aliq_icms      ,   item_cest 
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
                                <th width="10%">Código          </th>
                                <th width="50%">Descrição       </th>
                                <th width="10%">NCM             </th>
                                <th width="10%">Unidade         </th>
                                <th width="10%">Tipo            </th>
                                <th width="10%" class="text-center">Ações           </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ( $dados->RecordCount() > 0 ){ 
                                while ( !$dados->EOF ) { ?>
                            <tr>
                                <td class="text-center"><?= $dados->fields['item_codigo']       ?></td>
                                <td class="text-left"  ><?= $dados->fields['item_descricao']    ?></td>
                                <td class="text-left"  ><?= $dados->fields['item_ncm']          ?></td>
                                <td class="text-left"  ><?= $dados->fields['item_und_inv']      ?></td>
                                <td class="text-left"  ><?= $dados->fields['item_tipo']         ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_itens','view','<?= $dados->fields['item_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
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
                            }else{ ?>
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
       if      ( $_SESSION["op"] == "view"   ){ $description = "Visualização dos "; $disabled = "disabled"; }
       else if ( $_SESSION["op"] == "insert" ){ $description = "Insira os ";                                }
       else if ( $_SESSION["op"] == "delete" ){ $description = "Deletar esses ";  $disabled = "disabled";   }
       else if ( $_SESSION["op"] == "edit"   ){ $description = "Editar os ";                                }

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
          <form action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainAdmItem.php" method="post" id="frmDados">
              <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item">
                      <a href="#participante_geral" id="aba-participante-geral"  role="tab" data-toggle="tab" class="nav-link <?= ( $_SESSION['aba'] == "" ? "active" : "" ) ?>" >Dados Gerais</a>
                  </li>   
                  <li class="nav-item escondido">
                      <a href="#participante_endereco" id="aba-participante-endereco"  role="tab" data-toggle="tab" class="nav-link <?= ( $_SESSION['aba'] == "aba-participante-endereco" ? "active" : "" ) ?>" >Endereço</a>
                  </li>   
                  <li class="nav-item escondido">
                      <a href="#participante_contato" id="aba-participante-contato"  role="tab" data-toggle="tab" class="nav-link <?= ( $_SESSION['aba'] == "aba-participante-contato" ? "active" : "" ) ?>" >Contato</a>
                  </li>   
              </ul>

              <div class="tab-content">
                  <div class="tab-pane <?= ( $_SESSION['aba'] == "" ? "active" : "" ) ?> margin-top-15" id="participante_geral" role="tabpanel">
                      <div class="row">
                          <div class="row col-sm-12">
                              <div  class="col-sm-2  mb-2">
                                  <label for="item_tipo" class="requi">Tipo Item:</label>
                                  <select class="form-control requeri" id="item_tipo" name="item_tipo">
                                      <option value="">Selecione</option>
                                      <option value="00" <?php print $dados->fields['item_tipo'] == "00" ? "selected" : "" ?>>00: Mercadoria para Revenda   </option>
                                      <option value="01" <?php print $dados->fields['item_tipo'] == "01" ? "selected" : "" ?>>01: Matéria-Prima;            </option>
                                      <option value="02" <?php print $dados->fields['item_tipo'] == "02" ? "selected" : "" ?>>02: Embalagem;                </option>
                                      <option value="03" <?php print $dados->fields['item_tipo'] == "03" ? "selected" : "" ?>>03: Produto em Processo;      </option>
                                      <option value="04" <?php print $dados->fields['item_tipo'] == "04" ? "selected" : "" ?>>04: Produto Acabado;          </option>
                                      <option value="05" <?php print $dados->fields['item_tipo'] == "05" ? "selected" : "" ?>>05: Subproduto;               </option>
                                      <option value="06" <?php print $dados->fields['item_tipo'] == "06" ? "selected" : "" ?>>06: Produto Intermediário;    </option>
                                      <option value="07" <?php print $dados->fields['item_tipo'] == "07" ? "selected" : "" ?>>07: Material de Uso e Consumo;</option>
                                      <option value="08" <?php print $dados->fields['item_tipo'] == "08" ? "selected" : "" ?>>08: Ativo Imobilizado;        </option>
                                      <option value="09" <?php print $dados->fields['item_tipo'] == "09" ? "selected" : "" ?>>09: Serviços;                 </option>
                                      <option value="10" <?php print $dados->fields['item_tipo'] == "10" ? "selected" : "" ?>>10: Outros insumos;           </option>
                                      <option value="99" <?php print $dados->fields['item_tipo'] == "99" ? "selected" : "" ?>>99: Outras                    </option>
                                  </select>
                              </div>
                              <div  class="col-sm-2  mb-2">
                                  <label for="item_codigo"  class="requi">Código:</label>
                                  <input type="text" class="form-control requeri unique" id="item_codigo" name="item_codigo" value="<?php print $dados->fields['item_codigo']?>" <?=$disabled?>/>
                              </div>
                              <div  class="col-sm-8  mb-2">
                                  <label for="item_descricao"  class="requi">Descrição:</label>
                                  <input type="text" class="form-control requeri" id="item_descricao" name="item_descricao" value="<?php print $dados->fields['item_descricao']?>" <?=$disabled?>/>
                              </div>                         
                          </div>
                          <div class="row col-sm-12">
                              <div  class="col-sm-4 mb-2">
                                  <label for="item_und_inv" class="requi">Unidade:</label>
                                  <select class="form-control requeri multiselect" id="item_und_inv" name="item_und_inv" title="Referência a tabela 0190 para os SPED Fiscal e Contribuições">
                                      <option value="">Selecione</option>
                                      <?php
                                      $und = $bd->Execute($sql = 
                                      "SELECT 	
                                              unidades_medidas_id
                                      ,	unidades_medidas_sigla 
                                      ,	unidades_medidas_descricao 
                                      FROM t_unidades_medidas  
                                      ORDER BY 2;");

                                      while ( !$und->EOF ){ ?>

                                          <option value="<?= $und->fields['unidades_medidas_sigla'] ?>" 
                                              <?php print $dados->fields['item_und_inv'] == $und->fields['unidades_medidas_sigla'] ? "selected" : "" ?>>
                                              <?= $und->fields['unidades_medidas_sigla']." - ".$und->fields['unidades_medidas_descricao'] ?>
                                          </option>

                                          <?php
                                          $und->MoveNext();
                                      }?>
                                  </select>
                              </div>

                              <div  class="col-sm-3 form-group ">
                                  <label for="item_aliq_icms" class="">Alíquota ICMS:</label>
                                  <input type="text" class="form-control" id="item_aliq_icms" name="item_aliq_icms" value="<?php print $dados->fields['item_aliq_icms']?>" <?=$disabled?> title="Código de Exceção de NCM de acordo com a Tabela TIPI"/>
                              </div>      
                              <div  class="col-sm-1 form-group ">
                                  <label for="item_aliq_icms" class="" style="padding-top: 40px;">%</label>
                              </div>      
                              <div  class="col-sm-4 form-group ">
                                  <label for="item_ex_ipi" class="">Ex IPI:</label>
                                  <input type="text" class="form-control" id="item_ex_ipi" name="item_ex_ipi" value="<?php print $dados->fields['item_ex_ipi']?>" <?=$disabled?> title="Código de Exceção de NCM de acordo com a Tabela TIPI"/>
                              </div>      
                              <div  class="col-sm-2 form-group ">
                                  <label for="item_cest" class=""><a href="https://www.confaz.fazenda.gov.br/legislacao/convenios/2015/CV146_15">CEST:</a></label>
                                  <input type="text" class="form-control" id="item_cest" name="item_cest" value="<?php print $dados->fields['item_cest']?>" <?=$disabled?> title="o valor informado no campo deve existir na Tabela Código Especificador da Substituição Tributária- CEST, conforme Convênio ICMS 52, de 07 de abril de 2017."/>
                              </div>      

                              <div  class="col-sm-5 form-group">
                                  <label for="item_cod_gen" class="requi">Gênero do Item:</label>
                                  <select class="form-control requeri" id="item_cod_gen" name="item_cod_gen">
                                      <option value="">Selecione</option>
                                      <option value="00" <?= $dados->fields['item_cod_gen']  == "00" ? "selected" : ""?> >00 - Serviço                                                                                                            </option>
                                      <option value="01" <?= $dados->fields['item_cod_gen']  == "01" ? "selected" : ""?> >01 - Animais vivos                                                                                                      </option>
                                      <option value="02" <?= $dados->fields['item_cod_gen']  == "02" ? "selected" : ""?> >02 - Carnes e miudezas, comestíveis                                                                                     </option>
                                      <option value="03" <?= $dados->fields['item_cod_gen']  == "03" ? "selected" : ""?> >03 - Peixes e crustáceos, moluscos e os outros invertebrados aquáticos                                                  </option>
                                      <option value="04" <?= $dados->fields['item_cod_gen']  == "04" ? "selected" : ""?> >04 - Leite e laticínios; ovos de aves; mel natural; produtos comestíveis de origem animal, não especificados nem com    </option>
                                      <option value="05" <?= $dados->fields['item_cod_gen']  == "05" ? "selected" : ""?> >05 - Outros produtos de origem animal, não especificados nem compreendidos em outros Capítulos da TIPI                  </option>
                                      <option value="06" <?= $dados->fields['item_cod_gen']  == "06" ? "selected" : ""?> >06 - Plantas vivas e produtos de floricultura                                                                           </option>
                                      <option value="07" <?= $dados->fields['item_cod_gen']  == "07" ? "selected" : ""?> >07 - Produtos hortícolas, plantas, raízes e tubérculos, comestíveis                                                     </option>
                                      <option value="08" <?= $dados->fields['item_cod_gen']  == "08" ? "selected" : ""?> >08 - Frutas; cascas de cítricos e de melões                                                                             </option>
                                      <option value="09" <?= $dados->fields['item_cod_gen']  == "09" ? "selected" : ""?> >09 - Café, chá, mate e especiarias                                                                                      </option>
                                      <option value="10" <?= $dados->fields['item_cod_gen']  == "10" ? "selected" : ""?> >10 - Cereais                                                                                                            </option>
                                      <option value="11" <?= $dados->fields['item_cod_gen']  == "11" ? "selected" : ""?> >11 - Produtos da indústria de moagem; malte; amidos e féculas; inulina; glúten de trigo                                 </option>
                                      <option value="12" <?= $dados->fields['item_cod_gen']  == "12" ? "selected" : ""?> >12 - Sementes e frutos oleaginosos; grãos, sementes e frutos diversos; plantas industriais ou medicinais; palha e fo    </option>
                                      <option value="13" <?= $dados->fields['item_cod_gen']  == "13" ? "selected" : ""?> >13 - Gomas, resinas e outros sucos e extratos vegetais 14 Matérias para entrançar e outros produtos de origem vegeta    </option>
                                      <option value="15" <?= $dados->fields['item_cod_gen']  == "15" ? "selected" : ""?> >15 - Gorduras e óleos animais ou vegetais; produtos da sua dissociação; gorduras alimentares elaboradas; ceras de or    </option>
                                      <option value="16" <?= $dados->fields['item_cod_gen']  == "16" ? "selected" : ""?> >16 - Preparações de carne, de peixes ou de crustáceos, de moluscos ou de outros invertebrados aquáticos                 </option>
                                      <option value="17" <?= $dados->fields['item_cod_gen']  == "17" ? "selected" : ""?> >17 - Açúcares e produtos de confeitaria                                                                                 </option>
                                      <option value="18" <?= $dados->fields['item_cod_gen']  == "18" ? "selected" : ""?> >18 - Cacau e suas preparações                                                                                           </option>
                                      <option value="19" <?= $dados->fields['item_cod_gen']  == "19" ? "selected" : ""?> >19 - Preparações à base de cereais, farinhas, amidos, féculas ou de leite; produtos de pastelaria                       </option>
                                      <option value="20" <?= $dados->fields['item_cod_gen']  == "20" ? "selected" : ""?> >20 - Preparações de produtos hortícolas, de frutas ou de outras partes de plantas                                       </option>
                                      <option value="21" <?= $dados->fields['item_cod_gen']  == "21" ? "selected" : ""?> >21 - Preparações alimentícias diversas                                                                                  </option>
                                      <option value="22" <?= $dados->fields['item_cod_gen']  == "22" ? "selected" : ""?> >22 - Bebidas, líquidos alcoólicos e vinagres                                                                            </option>
                                      <option value="23" <?= $dados->fields['item_cod_gen']  == "23" ? "selected" : ""?> >23 - Resíduos e desperdícios das indústrias alimentares; alimentos preparados para animais                              </option>
                                      <option value="24" <?= $dados->fields['item_cod_gen']  == "24" ? "selected" : ""?> >24 - Fumo (tabaco) e seus sucedâneos, manufaturados                                                                     </option>
                                      <option value="25" <?= $dados->fields['item_cod_gen']  == "25" ? "selected" : ""?> >25 - Sal; enxofre; terras e pedras; gesso, cal e cimento                                                                </option>
                                      <option value="26" <?= $dados->fields['item_cod_gen']  == "26" ? "selected" : ""?> >26 - Minérios, escórias e cinzas                                                                                        </option>
                                      <option value="27" <?= $dados->fields['item_cod_gen']  == "27" ? "selected" : ""?> >27 - Combustíveis minerais, óleos minerais e produtos de sua destilação; matérias betuminosas; ceras minerais           </option>
                                      <option value="28" <?= $dados->fields['item_cod_gen']  == "28" ? "selected" : ""?> >28 - Produtos químicos inorgânicos; compostos inorgânicos ou orgânicos de metais preciosos, de elementos radioativos    </option>
                                      <option value="29" <?= $dados->fields['item_cod_gen']  == "29" ? "selected" : ""?> >29 - Produtos químicos orgânicos                                                                                        </option>
                                      <option value="30" <?= $dados->fields['item_cod_gen']  == "30" ? "selected" : ""?> >30 - Produtos farmacêuticos                                                                                             </option>
                                      <option value="31" <?= $dados->fields['item_cod_gen']  == "31" ? "selected" : ""?> >31 - Adubos ou fertilizantes                                                                                            </option>
                                      <option value="32" <?= $dados->fields['item_cod_gen']  == "32" ? "selected" : ""?> >32 - Extratos tanantes e tintoriais; taninos e seus derivados; pigmentos e outras matérias corantes, tintas e verniz    </option>
                                      <option value="33" <?= $dados->fields['item_cod_gen']  == "33" ? "selected" : ""?> >33 - Óleos essenciais e resinóides; produtos de perfumaria ou de toucador preparados e preparações cosméticas           </option>
                                      <option value="34" <?= $dados->fields['item_cod_gen']  == "34" ? "selected" : ""?> >34 - Sabões, agentes orgânicos de superfície, preparações para lavagem, preparações lubrificantes, ceras artificiais    </option>
                                      <option value="35" <?= $dados->fields['item_cod_gen']  == "35" ? "selected" : ""?> >35 - Matérias albuminóides; produtos à base de amidos ou de féculas modificados; colas; enzimas                         </option>
                                      <option value="36" <?= $dados->fields['item_cod_gen']  == "36" ? "selected" : ""?> >36 - Pólvoras e explosivos; artigos de pirotecnia; fósforos; ligas pirofóricas; matérias inflamáveis                    </option>
                                      <option value="37" <?= $dados->fields['item_cod_gen']  == "37" ? "selected" : ""?> >37 - Produtos para fotografia e cinematografia                                                                          </option>
                                      <option value="38" <?= $dados->fields['item_cod_gen']  == "38" ? "selected" : ""?> >38 - Produtos diversos das indústrias químicas                                                                          </option>
                                      <option value="39" <?= $dados->fields['item_cod_gen']  == "39" ? "selected" : ""?> >39 - Plásticos e suas obras                                                                                             </option>
                                      <option value="40" <?= $dados->fields['item_cod_gen']  == "40" ? "selected" : ""?> >40 - Borracha e suas obras                                                                                              </option>
                                      <option value="41" <?= $dados->fields['item_cod_gen']  == "41" ? "selected" : ""?> >41 - Peles, exceto a peleteria (peles com pêlo*), e couros                                                              </option>
                                      <option value="42" <?= $dados->fields['item_cod_gen']  == "42" ? "selected" : ""?> >42 - Obras de couro; artigos de correeiro ou de seleiro; artigos de viagem, bolsas e artefatos semelhantes; obras de    </option>
                                      <option value="43" <?= $dados->fields['item_cod_gen']  == "43" ? "selected" : ""?> >43 - Peleteria (peles com pelo*) e suas obras; peleteria (peles com pelo*) artificial                                   </option>
                                      <option value="44" <?= $dados->fields['item_cod_gen']  == "44" ? "selected" : ""?> >44 - Madeira, carvão vegetal e obras de madeira                                                                         </option>
                                      <option value="45" <?= $dados->fields['item_cod_gen']  == "45" ? "selected" : ""?> >45 - Cortiça e suas obras                                                                                               </option>
                                      <option value="46" <?= $dados->fields['item_cod_gen']  == "46" ? "selected" : ""?> >46 - Obras de espartaria ou de cestaria                                                                                 </option>
                                      <option value="47" <?= $dados->fields['item_cod_gen']  == "47" ? "selected" : ""?> >47 - Pastas de madeira ou de outras matérias fibrosas celulósicas; papel ou cartão de reciclar (desperdícios e apara    </option>
                                      <option value="48" <?= $dados->fields['item_cod_gen']  == "48" ? "selected" : ""?> >48 - Papel e cartão; obras de pasta de celulose, de papel ou de cartão                                                  </option>
                                      <option value="49" <?= $dados->fields['item_cod_gen']  == "49" ? "selected" : ""?> >49 - Livros, jornais, gravuras e outros produtos das indústrias gráficas; textos manuscritos ou datilografados, plan    </option>
                                      <option value="50" <?= $dados->fields['item_cod_gen']  == "50" ? "selected" : ""?> >50 - Seda                                                                                                               </option>
                                      <option value="51" <?= $dados->fields['item_cod_gen']  == "51" ? "selected" : ""?> >51 - Lã e pelos finos ou grosseiros; fios e tecidos de crina                                                            </option>
                                      <option value="52" <?= $dados->fields['item_cod_gen']  == "52" ? "selected" : ""?> >52 - Algodão                                                                                                            </option>
                                      <option value="53" <?= $dados->fields['item_cod_gen']  == "53" ? "selected" : ""?> >53 - Outras fibras têxteis vegetais; fios de papel e tecido de fios de papel                                            </option>
                                      <option value="54" <?= $dados->fields['item_cod_gen']  == "54" ? "selected" : ""?> >54 - Filamentos sintéticos ou artificiais                                                                               </option>
                                      <option value="55" <?= $dados->fields['item_cod_gen']  == "55" ? "selected" : ""?> >55 - Fibras sintéticas ou artificiais, descontínuas                                                                     </option>
                                      <option value="56" <?= $dados->fields['item_cod_gen']  == "56" ? "selected" : ""?> >56 - Pastas ("ouates"), feltros e falsos tecidos; fios especiais; cordéis, cordas e cabos; artigos de cordoaria         </option>
                                      <option value="57" <?= $dados->fields['item_cod_gen']  == "57" ? "selected" : ""?> >57 - Tapetes e outros revestimentos para pavimentos, de matérias têxteis                                                </option>
                                      <option value="58" <?= $dados->fields['item_cod_gen']  == "58" ? "selected" : ""?> >58 - Tecidos especiais; tecidos tufados; rendas; tapeçarias; passamanarias; bordados                                    </option>
                                      <option value="59" <?= $dados->fields['item_cod_gen']  == "59" ? "selected" : ""?> >59 - Tecidos impregnados, revestidos, recobertos ou estratificados; artigos para usos técnicos de matérias têxteis      </option>
                                      <option value="60" <?= $dados->fields['item_cod_gen']  == "60" ? "selected" : ""?> >60 - Tecidos de malha                                                                                                   </option>
                                      <option value="61" <?= $dados->fields['item_cod_gen']  == "61" ? "selected" : ""?> >61 - Vestuário e seus acessórios, de malha                                                                              </option>
                                      <option value="62" <?= $dados->fields['item_cod_gen']  == "62" ? "selected" : ""?> >62 - Vestuário e seus acessórios, exceto de malha                                                                       </option>
                                      <option value="63" <?= $dados->fields['item_cod_gen']  == "63" ? "selected" : ""?> >63 - Outros artefatos têxteis confeccionados; sortidos; artefatos de matérias têxteis, calçados, chapéus e artefatos    </option>
                                      <option value="64" <?= $dados->fields['item_cod_gen']  == "64" ? "selected" : ""?> >64 - Calçados, polainas e artefatos semelhantes, e suas partes                                                          </option>
                                      <option value="65" <?= $dados->fields['item_cod_gen']  == "65" ? "selected" : ""?> >65 - Chapéus e artefatos de uso semelhante, e suas partes                                                               </option>
                                      <option value="66" <?= $dados->fields['item_cod_gen']  == "66" ? "selected" : ""?> >66 - Guarda-chuvas, sombrinhas, guarda-sóis, bengalas, bengalas-assentos, chicotes, e suas partes                       </option>
                                      <option value="67" <?= $dados->fields['item_cod_gen']  == "67" ? "selected" : ""?> >67 - Penas e penugem preparadas, e suas obras; flores artificiais; obras de cabelo                                      </option>
                                      <option value="68" <?= $dados->fields['item_cod_gen']  == "68" ? "selected" : ""?> >68 - Obras de pedra, gesso, cimento, amianto, mica ou de matérias semelhantes                                           </option>
                                      <option value="69" <?= $dados->fields['item_cod_gen']  == "69" ? "selected" : ""?> >69 - Produtos cerâmicos                                                                                                 </option>
                                      <option value="70" <?= $dados->fields['item_cod_gen']  == "70" ? "selected" : ""?> >70 - Vidro e suas obras                                                                                                 </option>
                                      <option value="71" <?= $dados->fields['item_cod_gen']  == "71" ? "selected" : ""?> >71 - Pérolas naturais ou cultivadas, pedras preciosas ou semipreciosas e semelhantes, metais preciosos, metais folhe    </option>
                                      <option value="72" <?= $dados->fields['item_cod_gen']  == "72" ? "selected" : ""?> >72 - Ferro fundido, ferro e aço                                                                                         </option>
                                      <option value="73" <?= $dados->fields['item_cod_gen']  == "73" ? "selected" : ""?> >73 - Obras de ferro fundido, ferro ou aço                                                                               </option>
                                      <option value="74" <?= $dados->fields['item_cod_gen']  == "74" ? "selected" : ""?> >74 - Cobre e suas obras                                                                                                 </option>
                                      <option value="75" <?= $dados->fields['item_cod_gen']  == "75" ? "selected" : ""?> >75 - Níquel e suas obras                                                                                                </option>
                                      <option value="76" <?= $dados->fields['item_cod_gen']  == "76" ? "selected" : ""?> >76 - Alumínio e suas obras                                                                                              </option>
                                      <option value="77" <?= $dados->fields['item_cod_gen']  == "77" ? "selected" : ""?> >77 - (Reservado para uma eventual utilização futura no SH)                                                              </option>
                                      <option value="78" <?= $dados->fields['item_cod_gen']  == "78" ? "selected" : ""?> >78 - Chumbo e suas obras                                                                                                </option>
                                      <option value="79" <?= $dados->fields['item_cod_gen']  == "79" ? "selected" : ""?> >79 - Zinco e suas obras                                                                                                 </option>
                                      <option value="80" <?= $dados->fields['item_cod_gen']  == "80" ? "selected" : ""?> >80 - Estanho e suas obras                                                                                               </option>
                                      <option value="81" <?= $dados->fields['item_cod_gen']  == "81" ? "selected" : ""?> >81 - Outros metais comuns; ceramais ("cermets"); obras dessas matérias                                                  </option>
                                      <option value="82" <?= $dados->fields['item_cod_gen']  == "82" ? "selected" : ""?> >82 - Ferramentas, artefatos de cutelaria e talheres, e suas partes, de metais comuns                                    </option>
                                      <option value="83" <?= $dados->fields['item_cod_gen']  == "83" ? "selected" : ""?> >83 - Obras diversas de metais comuns                                                                                    </option>
                                      <option value="84" <?= $dados->fields['item_cod_gen']  == "84" ? "selected" : ""?> >84 - Reatores nucleares, caldeiras, máquinas, aparelhos e instrumentos mecânicos, e suas partes                         </option>
                                      <option value="85" <?= $dados->fields['item_cod_gen']  == "85" ? "selected" : ""?> >85 - Máquinas, aparelhos e materiais elétricos, e suas partes; aparelhos de gravação ou de reprodução de som, aparel    </option>
                                      <option value="86" <?= $dados->fields['item_cod_gen']  == "86" ? "selected" : ""?> >86 - Veículos e material para vias férreas ou semelhantes, e suas partes; aparelhos mecânicos (incluídos os eletrome    </option>
                                      <option value="88" <?= $dados->fields['item_cod_gen']  == "88" ? "selected" : ""?> >88 - Aeronaves e aparelhos espaciais, e suas partes                                                                     </option>
                                      <option value="89" <?= $dados->fields['item_cod_gen']  == "89" ? "selected" : ""?> >89 - Embarcações e estruturas flutuantes                                                                                </option>
                                      <option value="90" <?= $dados->fields['item_cod_gen']  == "90" ? "selected" : ""?> >90 - Instrumentos e aparelhos de óptica, fotografia ou cinematografia, medida, controle ou de precisão; instrumentos    </option>
                                      <option value="91" <?= $dados->fields['item_cod_gen']  == "91" ? "selected" : ""?> >91 - Aparelhos de relojoaria e suas partes                                                                              </option>
                                      <option value="92" <?= $dados->fields['item_cod_gen']  == "92" ? "selected" : ""?> >92 - Instrumentos musicais, suas partes e acessórios                                                                    </option>
                                      <option value="93" <?= $dados->fields['item_cod_gen']  == "93" ? "selected" : ""?> >93 - Armas e munições; suas partes e acessórios                                                                         </option>
                                      <option value="94" <?= $dados->fields['item_cod_gen']  == "94" ? "selected" : ""?> >94 - Móveis, mobiliário médico-cirúrgico; colchões; iluminação e construção pré-fabricadas                              </option>
                                      <option value="95" <?= $dados->fields['item_cod_gen']  == "95" ? "selected" : ""?> >95 - Brinquedos, jogos, artigos para divertimento ou para esporte; suas partes e acessórios                             </option>
                                      <option value="96" <?= $dados->fields['item_cod_gen']  == "96" ? "selected" : ""?> >96 - Obras diversas                                                                                                     </option>
                                      <option value="97" <?= $dados->fields['item_cod_gen']  == "97" ? "selected" : ""?> >97 - Objetos de arte, de coleção e antiguidades                                                                         </option>
                                      <option value="98" <?= $dados->fields['item_cod_gen']  == "98" ? "selected" : ""?> >98 - (Reservado para usos especiais pelas Partes Contratantes)                                                          </option>
                                      <option value="99" <?= $dados->fields['item_cod_gen']  == "99" ? "selected" : ""?> >99 - Operações especiais (utilizado exclusivamente pelo Brasil para classificar operações especiais na exportação       </option>
                                  </select>
                              </div>
                              <div class="col-sm-5 mb-2">
                                  <label for="item_cod_lst"  class="requi">Código LST:</label>
                                  <select class="form-control requeri " id="item_cod_lst" name="item_cod_lst" <?=$disabled?> title="Código do serviço conforme lista do Anexo I da Lei Complementar Federal nº 116/2003"> 
                                      <option value="">Selecione</option>
                                      <option value="1.01" <?= $dados->fields['item_cod_lst'] == "101" ? "selected" : "" ?> > 1.01 -	Análise e desenvolvimento de sistemas.             </option>
                                      <option value="1.02" <?= $dados->fields['item_cod_lst'] == "102" ? "selected" : "" ?> > 1.02 -	Programação.                                       </option>
                                      <option value="1.03" <?= $dados->fields['item_cod_lst'] == "103" ? "selected" : "" ?> > 1.03 -	Processamento de dados e congêneres.               </option>
                                      <option value="1.04" <?= $dados->fields['item_cod_lst'] == "104" ? "selected" : "" ?> > 1.04 -	Elaboração de programas de computadores, inclusive </option>
                                      <option value="1.05" <?= $dados->fields['item_cod_lst'] == "105" ? "selected" : "" ?> > 1.05 -	Licenciamento ou cessão de direito de uso de progr </option>
                                      <option value="1.06" <?= $dados->fields['item_cod_lst'] == "106" ? "selected" : "" ?> > 1.06 -	Assessoria e consultoria em informática.           </option>
                                      <option value="1.07" <?= $dados->fields['item_cod_lst'] == "107" ? "selected" : "" ?> > 1.07 -	Suporte técnico em informática, inclusive instalaç </option>
                                      <option value="1.08" <?= $dados->fields['item_cod_lst'] == "108" ? "selected" : "" ?> > 1.08 -	Planejamento, confecção, manutenção e atualização  </option>
                                      <option value="2.01" <?= $dados->fields['item_cod_lst'] == "201" ? "selected" : "" ?> > 2.01 -	Serviços de pesquisas e desenvolvimento de qualque </option>
                                      <option value="3.01" <?= $dados->fields['item_cod_lst'] == "301" ? "selected" : "" ?> > 3.01 -	(VETADO)                                           </option>
                                      <option value="3.02" <?= $dados->fields['item_cod_lst'] == "302" ? "selected" : "" ?> > 3.02 -	Cessão de direito de uso de marcas e de sinais de  </option>
                                      <option value="3.03" <?= $dados->fields['item_cod_lst'] == "303" ? "selected" : "" ?> > 3.03 -	Exploração de salões de festas, centro de convençõ </option>
                                      <option value="3.04" <?= $dados->fields['item_cod_lst'] == "304" ? "selected" : "" ?> > 3.04 -	Locação, sublocação, arrendamento, direito de pass </option>
                                      <option value="3.05" <?= $dados->fields['item_cod_lst'] == "305" ? "selected" : "" ?> > 3.05 -	Cessão de andaimes, palcos, coberturas e outras es </option>
                                      <option value="4.01" <?= $dados->fields['item_cod_lst'] == "401" ? "selected" : "" ?> > 4.01 -	Medicina e biomedicina.                            </option>
                                      <option value="4.02" <?= $dados->fields['item_cod_lst'] == "402" ? "selected" : "" ?> > 4.02 -	Análises clínicas, patologia, eletricidade médica, </option>
                                      <option value="4.03" <?= $dados->fields['item_cod_lst'] == "403" ? "selected" : "" ?> > 4.03 -	Hospitais, clínicas, laboratórios, sanatórios, man </option>
                                      <option value="4.04" <?= $dados->fields['item_cod_lst'] == "404" ? "selected" : "" ?> > 4.04 -	Instrumentação cirúrgica.                          </option>
                                      <option value="4.05" <?= $dados->fields['item_cod_lst'] == "405" ? "selected" : "" ?> > 4.05 -	Acupuntura.                                        </option>
                                      <option value="4.06" <?= $dados->fields['item_cod_lst'] == "406" ? "selected" : "" ?> > 4.06 -	Enfermagem, inclusive serviços auxiliares.         </option>
                                      <option value="4.07" <?= $dados->fields['item_cod_lst'] == "407" ? "selected" : "" ?> > 4.07 -	Serviços farmacêuticos.                            </option>
                                      <option value="4.08" <?= $dados->fields['item_cod_lst'] == "408" ? "selected" : "" ?> > 4.08 -	Terapia ocupacional, fisioterapia e fonoaudiologia </option>
                                      <option value="4.09" <?= $dados->fields['item_cod_lst'] == "409" ? "selected" : "" ?> > 4.09 -	Terapias de qualquer espécie destinadas ao tratame </option>
                                      <option value="4.10" <?= $dados->fields['item_cod_lst'] == "410" ? "selected" : "" ?> > 4.10 -	Nutrição.                                          </option>
                                      <option value="4.11" <?= $dados->fields['item_cod_lst'] == "411" ? "selected" : "" ?> > 4.11 -	Obstetrícia.                                       </option>
                                      <option value="4.12" <?= $dados->fields['item_cod_lst'] == "412" ? "selected" : "" ?> > 4.12 -	Odontologia.                                       </option>
                                      <option value="4.13" <?= $dados->fields['item_cod_lst'] == "413" ? "selected" : "" ?> > 4.13 -	Ortóptica.                                         </option>
                                      <option value="4.14" <?= $dados->fields['item_cod_lst'] == "414" ? "selected" : "" ?> > 4.14 -	Próteses sob encomenda.                            </option>
                                      <option value="4.15" <?= $dados->fields['item_cod_lst'] == "415" ? "selected" : "" ?> > 4.15 -	Psicanálise.                                       </option>
                                      <option value="4.16" <?= $dados->fields['item_cod_lst'] == "416" ? "selected" : "" ?> > 4.16 -	Psicologia.                                        </option>
                                      <option value="4.17" <?= $dados->fields['item_cod_lst'] == "417" ? "selected" : "" ?> > 4.17 -	Casas de repouso e de recuperação, creches, asilos </option>
                                      <option value="4.18" <?= $dados->fields['item_cod_lst'] == "418" ? "selected" : "" ?> > 4.18 -	Inseminação artificial, fertilização in vitro e co </option>
                                      <option value="4.19" <?= $dados->fields['item_cod_lst'] == "419" ? "selected" : "" ?> > 4.19 -	Bancos de sangue, leite, pele, olhos, óvulos, sême </option>
                                      <option value="4.20" <?= $dados->fields['item_cod_lst'] == "420" ? "selected" : "" ?> > 4.20 -	Coleta de sangue, leite, tecidos, sêmen, órgãos e  </option>
                                      <option value="4.21" <?= $dados->fields['item_cod_lst'] == "421" ? "selected" : "" ?> > 4.21 -	Unidade de atendimento, assistência ou tratamento  </option>
                                      <option value="4.22" <?= $dados->fields['item_cod_lst'] == "422" ? "selected" : "" ?> > 4.22 -	Planos de medicina de grupo ou individual e convên </option>
                                      <option value="4.23" <?= $dados->fields['item_cod_lst'] == "423" ? "selected" : "" ?> > 4.23 -	Outros planos de saúde que se cumpram através de s </option>
                                      <option value="5.01" <?= $dados->fields['item_cod_lst'] == "501" ? "selected" : "" ?> > 5.01 -	Medicina veterinária e zootecnia.                  </option>
                                      <option value="5.02" <?= $dados->fields['item_cod_lst'] == "502" ? "selected" : "" ?> > 5.02 -	Hospitais, clínicas, ambulatórios, prontos-socorro </option>
                                      <option value="5.03" <?= $dados->fields['item_cod_lst'] == "503" ? "selected" : "" ?> > 5.03 -	Laboratórios de análise na área veterinária.       </option>
                                      <option value="5.04" <?= $dados->fields['item_cod_lst'] == "504" ? "selected" : "" ?> > 5.04 -	Inseminação artificial, fertilização in vitro e co </option>
                                      <option value="5.05" <?= $dados->fields['item_cod_lst'] == "505" ? "selected" : "" ?> > 5.05 -	Bancos de sangue e de órgãos e congêneres.         </option>
                                      <option value="5.06" <?= $dados->fields['item_cod_lst'] == "506" ? "selected" : "" ?> > 5.06 -	Coleta de sangue, leite, tecidos, sêmen, órgãos e  </option>
                                      <option value="5.07" <?= $dados->fields['item_cod_lst'] == "507" ? "selected" : "" ?> > 5.07 -	Unidade de atendimento, assistência ou tratamento  </option>
                                      <option value="5.08" <?= $dados->fields['item_cod_lst'] == "508" ? "selected" : "" ?> > 5.08 -	Guarda, tratamento, amestramento, embelezamento, a </option>
                                      <option value="5.09" <?= $dados->fields['item_cod_lst'] == "509" ? "selected" : "" ?> > 5.09 -	Planos de atendimento e assistência médico-veterin </option>
                                      <option value="6.01" <?= $dados->fields['item_cod_lst'] == "601" ? "selected" : "" ?> > 6.01 -	Barbearia, cabeleireiros, manicuros, pedicuros e c </option>
                                      <option value="6.02" <?= $dados->fields['item_cod_lst'] == "602" ? "selected" : "" ?> > 6.02 -	Esteticistas, tratamento de pele, depilação e cong </option>
                                      <option value="6.03" <?= $dados->fields['item_cod_lst'] == "603" ? "selected" : "" ?> > 6.03 -	Banhos, duchas, sauna, massagens e congêneres.     </option>
                                      <option value="6.04" <?= $dados->fields['item_cod_lst'] == "604" ? "selected" : "" ?> > 6.04 -	Ginástica, dança, esportes, natação, artes marciai </option>
                                      <option value="6.05" <?= $dados->fields['item_cod_lst'] == "605" ? "selected" : "" ?> > 6.05 -	Centros de emagrecimento, spa e congêneres.        </option>
                                      <option value="7.01" <?= $dados->fields['item_cod_lst'] == "701" ? "selected" : "" ?> > 7.01 -	Engenharia, agronomia, agrimensura, arquitetura, g </option>
                                      <option value="7.02" <?= $dados->fields['item_cod_lst'] == "702" ? "selected" : "" ?> > 7.02 -	Execução, por administração, empreitada ou subempr </option>
                                      <option value="7.03" <?= $dados->fields['item_cod_lst'] == "703" ? "selected" : "" ?> > 7.03 -	Elaboração de planos diretores, estudos de viabili </option>
                                      <option value="7.04" <?= $dados->fields['item_cod_lst'] == "704" ? "selected" : "" ?> > 7.04 -	Demolição.                                         </option>
                                      <option value="7.05" <?= $dados->fields['item_cod_lst'] == "705" ? "selected" : "" ?> > 7.05 -	Reparação, conservação e reforma de edifícios, est </option>
                                      <option value="7.06" <?= $dados->fields['item_cod_lst'] == "706" ? "selected" : "" ?> > 7.06 -	Colocação e instalação de tapetes, carpetes, assoa </option>
                                      <option value="7.07" <?= $dados->fields['item_cod_lst'] == "707" ? "selected" : "" ?> > 7.07 -	Recuperação, raspagem, polimento e lustração de pi </option>
                                      <option value="7.08" <?= $dados->fields['item_cod_lst'] == "708" ? "selected" : "" ?> > 7.08 -	Calafetação.                                       </option>
                                      <option value="7.09" <?= $dados->fields['item_cod_lst'] == "709" ? "selected" : "" ?> > 7.09 -	Varrição, coleta, remoção, incineração, tratamento </option>
                                      <option value="7.10" <?= $dados->fields['item_cod_lst'] == "710" ? "selected" : "" ?> > 7.10 -	Limpeza, manutenção e conservação de vias e lograd </option>
                                      <option value="7.11" <?= $dados->fields['item_cod_lst'] == "711" ? "selected" : "" ?> > 7.11 -	Decoração e jardinagem, inclusive corte e poda de  </option>
                                      <option value="7.12" <?= $dados->fields['item_cod_lst'] == "712" ? "selected" : "" ?> > 7.12 -	Controle e tratamento de efluentes de qualquer nat </option>
                                      <option value="7.13" <?= $dados->fields['item_cod_lst'] == "713" ? "selected" : "" ?> > 7.13 -	Dedetização, desinfecção, desinsetização, imunizaç </option>
                                      <option value="7.14" <?= $dados->fields['item_cod_lst'] == "714" ? "selected" : "" ?> > 7.14 -	(VETADO)                                           </option>
                                      <option value="7.15" <?= $dados->fields['item_cod_lst'] == "715" ? "selected" : "" ?> > 7.15 -	(VETADO)                                           </option>
                                      <option value="7.16" <?= $dados->fields['item_cod_lst'] == "716" ? "selected" : "" ?> > 7.16 -	Florestamento, reflorestamento, semeadura, adubaçã </option>
                                      <option value="7.17" <?= $dados->fields['item_cod_lst'] == "717" ? "selected" : "" ?> > 7.17 -	Escoramento, contenção de encostas e serviços cong </option>
                                      <option value="7.18" <?= $dados->fields['item_cod_lst'] == "718" ? "selected" : "" ?> > 7.18 -	Limpeza e dragagem de rios, portos, canais, baías, </option>
                                      <option value="7.19" <?= $dados->fields['item_cod_lst'] == "719" ? "selected" : "" ?> > 7.19 -	Acompanhamento e fiscalização da execução de obras </option>
                                      <option value="7.20" <?= $dados->fields['item_cod_lst'] == "720" ? "selected" : "" ?> > 7.20 -	Aerofotogrametria (inclusive interpretação), carto </option>
                                      <option value="7.21" <?= $dados->fields['item_cod_lst'] == "721" ? "selected" : "" ?> > 7.21 -	Pesquisa, perfuração, cimentação, mergulho, perfil </option>
                                      <option value="7.22" <?= $dados->fields['item_cod_lst'] == "722" ? "selected" : "" ?> > 7.22 -	Nucleação e bombardeamento de nuvens e congêneres. </option>
                                      <option value="8.01" <?= $dados->fields['item_cod_lst'] == "801" ? "selected" : "" ?> > 8.01 -	Ensino regular pré-escolar, fundamental, médio e s </option>
                                      <option value="8.02" <?= $dados->fields['item_cod_lst'] == "802" ? "selected" : "" ?> > 8.02 -	Instrução, treinamento, orientação pedagógica e ed </option>
                                      <option value="9.01" <?= $dados->fields['item_cod_lst'] == "901" ? "selected" : "" ?> > 9.01 -	Hospedagem de qualquer natureza em hotéis, apart-s </option>
                                      <option value="9.02" <?= $dados->fields['item_cod_lst'] == "902" ? "selected" : "" ?> > 9.02 -	Agenciamento, organização, promoção, intermediação </option>
                                      <option value="9.03" <?= $dados->fields['item_cod_lst'] == "903" ? "selected" : "" ?> > 9.03 -	Guias de turismo.                                  </option>
                                      <option value="10.01" <?= $dados->fields['item_cod_lst'] == "1001" ? "selected" : "" ?> > 10.01 -	Agenciamento, corretagem ou intermediação de câm</option>
                                      <option value="10.02" <?= $dados->fields['item_cod_lst'] == "1002" ? "selected" : "" ?> > 10.02 -	Agenciamento, corretagem ou intermediação de tít</option>
                                      <option value="10.03" <?= $dados->fields['item_cod_lst'] == "1003" ? "selected" : "" ?> > 10.03 -	Agenciamento, corretagem ou intermediação de dir</option>
                                      <option value="10.04" <?= $dados->fields['item_cod_lst'] == "1004" ? "selected" : "" ?> > 10.04 -	Agenciamento, corretagem ou intermediação de con</option>
                                      <option value="10.05" <?= $dados->fields['item_cod_lst'] == "1005" ? "selected" : "" ?> > 10.05 -	Agenciamento, corretagem ou intermediação de ben</option>
                                      <option value="10.06" <?= $dados->fields['item_cod_lst'] == "1006" ? "selected" : "" ?> > 10.06 -	Agenciamento marítimo.                          </option>
                                      <option value="10.07" <?= $dados->fields['item_cod_lst'] == "1007" ? "selected" : "" ?> > 10.07 -	Agenciamento de notícias.                       </option>
                                      <option value="10.08" <?= $dados->fields['item_cod_lst'] == "1008" ? "selected" : "" ?> > 10.08 -	Agenciamento de publicidade e propaganda, inclus</option>
                                      <option value="10.09" <?= $dados->fields['item_cod_lst'] == "1009" ? "selected" : "" ?> > 10.09 -	Representação de qualquer natureza, inclusive co</option>
                                      <option value="10.10" <?= $dados->fields['item_cod_lst'] == "1010" ? "selected" : "" ?> > 10.10 -	Distribuição de bens de terceiros.              </option>
                                      <option value="11.01" <?= $dados->fields['item_cod_lst'] == "1101" ? "selected" : "" ?> > 11.01 -	Guarda e estacionamento de veículos terrestres a</option>
                                      <option value="11.02" <?= $dados->fields['item_cod_lst'] == "1102" ? "selected" : "" ?> > 11.02 -	Vigilância, segurança ou monitoramento de bens e</option>
                                      <option value="11.03" <?= $dados->fields['item_cod_lst'] == "1103" ? "selected" : "" ?> > 11.03 -	Escolta, inclusive de veículos e cargas.        </option>
                                      <option value="11.04" <?= $dados->fields['item_cod_lst'] == "1104" ? "selected" : "" ?> > 11.04 -	Armazenamento, depósito, carga, descarga, arruma</option>
                                      <option value="12.01" <?= $dados->fields['item_cod_lst'] == "1201" ? "selected" : "" ?> > 12.01 -	Espetáculos teatrais.                           </option>
                                      <option value="12.02" <?= $dados->fields['item_cod_lst'] == "1202" ? "selected" : "" ?> > 12.02 -	Exibições cinematográficas.                     </option>
                                      <option value="12.03" <?= $dados->fields['item_cod_lst'] == "1203" ? "selected" : "" ?> > 12.03 -	Espetáculos circenses.                          </option>
                                      <option value="12.04" <?= $dados->fields['item_cod_lst'] == "1204" ? "selected" : "" ?> > 12.04 -	Programas de auditório.                         </option>
                                      <option value="12.05" <?= $dados->fields['item_cod_lst'] == "1205" ? "selected" : "" ?> > 12.05 -	Parques de diversões, centros de lazer e congêne</option>
                                      <option value="12.06" <?= $dados->fields['item_cod_lst'] == "1206" ? "selected" : "" ?> > 12.06 -	Boates, taxi-dancing e congêneres.              </option>
                                      <option value="12.07" <?= $dados->fields['item_cod_lst'] == "1207" ? "selected" : "" ?> > 12.07 -	Shows, ballet, danças, desfiles, bailes, óperas,</option>
                                      <option value="12.08" <?= $dados->fields['item_cod_lst'] == "1208" ? "selected" : "" ?> > 12.08 -	Feiras, exposições, congressos e congêneres.    </option>
                                      <option value="12.09" <?= $dados->fields['item_cod_lst'] == "1209" ? "selected" : "" ?> > 12.09 -	Bilhares, boliches e diversões eletrônicas ou nã</option>
                                      <option value="12.10" <?= $dados->fields['item_cod_lst'] == "1210" ? "selected" : "" ?> > 12.10 -	Corridas e competições de animais.              </option>
                                      <option value="12.11" <?= $dados->fields['item_cod_lst'] == "1211" ? "selected" : "" ?> > 12.11 -	Competições esportivas ou de destreza física ou </option>
                                      <option value="12.12" <?= $dados->fields['item_cod_lst'] == "1212" ? "selected" : "" ?> > 12.12 -	Execução de música.                             </option>
                                      <option value="12.13" <?= $dados->fields['item_cod_lst'] == "1213" ? "selected" : "" ?> > 12.13 -	Produção, mediante ou sem encomenda prévia, de e</option>
                                      <option value="12.14" <?= $dados->fields['item_cod_lst'] == "1214" ? "selected" : "" ?> > 12.14 -	Fornecimento de música para ambientes fechados o</option>
                                      <option value="12.15" <?= $dados->fields['item_cod_lst'] == "1215" ? "selected" : "" ?> > 12.15 -	Desfiles de blocos carnavalescos ou folclóricos,</option>
                                      <option value="12.16" <?= $dados->fields['item_cod_lst'] == "1216" ? "selected" : "" ?> > 12.16 -	Exibição de filmes, entrevistas, musicais, espet</option>
                                      <option value="12.17" <?= $dados->fields['item_cod_lst'] == "1217" ? "selected" : "" ?> > 12.17 -	Recreação e animação, inclusive em festas e even</option>
                                      <option value="13.01" <?= $dados->fields['item_cod_lst'] == "1301" ? "selected" : "" ?> > 13.01 -	(VETADO)                                        </option>
                                      <option value="13.02" <?= $dados->fields['item_cod_lst'] == "1302" ? "selected" : "" ?> > 13.02 -	Fonografia ou gravação de sons, inclusive trucag</option>
                                      <option value="13.03" <?= $dados->fields['item_cod_lst'] == "1303" ? "selected" : "" ?> > 13.03 -	Fotografia e cinematografia, inclusive revelação</option>
                                      <option value="13.04" <?= $dados->fields['item_cod_lst'] == "1304" ? "selected" : "" ?> > 13.04 -	Reprografia, microfilmagem e digitalização.     </option>
                                      <option value="13.05" <?= $dados->fields['item_cod_lst'] == "1305" ? "selected" : "" ?> > 13.05 -	Composição gráfica, fotocomposição, clicheria, z</option>
                                      <option value="14.01" <?= $dados->fields['item_cod_lst'] == "1401" ? "selected" : "" ?> > 14.01 -	Lubrificação, limpeza, lustração, revisão, carga</option>
                                      <option value="14.02" <?= $dados->fields['item_cod_lst'] == "1402" ? "selected" : "" ?> > 14.02 -	Assistência técnica.                            </option>
                                      <option value="14.03" <?= $dados->fields['item_cod_lst'] == "1403" ? "selected" : "" ?> > 14.03 -	Recondicionamento de motores (exceto peças e par</option>
                                      <option value="14.04" <?= $dados->fields['item_cod_lst'] == "1404" ? "selected" : "" ?> > 14.04 -	Recauchutagem ou regeneração de pneus.          </option>
                                      <option value="14.05" <?= $dados->fields['item_cod_lst'] == "1405" ? "selected" : "" ?> > 14.05 -	Restauração, recondicionamento, acondicionamento</option>
                                      <option value="14.06" <?= $dados->fields['item_cod_lst'] == "1406" ? "selected" : "" ?> > 14.06 -	Instalação e montagem de aparelhos, máquinas e e</option>
                                      <option value="14.07" <?= $dados->fields['item_cod_lst'] == "1407" ? "selected" : "" ?> > 14.07 -	Colocação de molduras e congêneres.             </option>
                                      <option value="14.08" <?= $dados->fields['item_cod_lst'] == "1408" ? "selected" : "" ?> > 14.08 -	Encadernação, gravação e douração de livros, rev</option>
                                      <option value="14.09" <?= $dados->fields['item_cod_lst'] == "1409" ? "selected" : "" ?> > 14.09 -	Alfaiataria e costura, quando o material for for</option>
                                      <option value="14.10" <?= $dados->fields['item_cod_lst'] == "1410" ? "selected" : "" ?> > 14.10 -	Tinturaria e lavanderia.                        </option>
                                      <option value="14.11" <?= $dados->fields['item_cod_lst'] == "1411" ? "selected" : "" ?> > 14.11 -	Tapeçaria e reforma de estofamentos em geral.   </option>
                                      <option value="14.12" <?= $dados->fields['item_cod_lst'] == "1412" ? "selected" : "" ?> > 14.12 -	Funilaria e lanternagem.                        </option>
                                      <option value="14.13" <?= $dados->fields['item_cod_lst'] == "1413" ? "selected" : "" ?> > 14.13 -	Carpintaria e serralheria.                      </option>
                                      <option value="15.01" <?= $dados->fields['item_cod_lst'] == "1501" ? "selected" : "" ?> > 15.01 -	Administração de fundos quaisquer, de consórcio,</option>
                                      <option value="15.02" <?= $dados->fields['item_cod_lst'] == "1502" ? "selected" : "" ?> > 15.02 -	Abertura de contas em geral, inclusive conta-cor</option>
                                      <option value="15.03" <?= $dados->fields['item_cod_lst'] == "1503" ? "selected" : "" ?> > 15.03 -	Locação e manutenção de cofres particulares, de </option>
                                      <option value="15.04" <?= $dados->fields['item_cod_lst'] == "1504" ? "selected" : "" ?> > 15.04 -	Fornecimento ou emissão de atestados em geral, i</option>
                                      <option value="15.05" <?= $dados->fields['item_cod_lst'] == "1505" ? "selected" : "" ?> > 15.05 -	Cadastro, elaboração de ficha cadastral, renovaç</option>
                                      <option value="15.06" <?= $dados->fields['item_cod_lst'] == "1506" ? "selected" : "" ?> > 15.06 -	Emissão, reemissão e fornecimento de avisos, com</option>
                                      <option value="15.07" <?= $dados->fields['item_cod_lst'] == "1507" ? "selected" : "" ?> > 15.07 -	Acesso, movimentação, atendimento e consulta a c</option>
                                      <option value="15.08" <?= $dados->fields['item_cod_lst'] == "1508" ? "selected" : "" ?> > 15.08 -	Emissão, reemissão, alteração, cessão, substitui</option>
                                      <option value="15.09" <?= $dados->fields['item_cod_lst'] == "1509" ? "selected" : "" ?> > 15.09 -	Arrendamento mercantil (leasing) de quaisquer be</option>
                                      <option value="15.10" <?= $dados->fields['item_cod_lst'] == "1510" ? "selected" : "" ?> > 15.10 -	Serviços relacionados a cobranças, recebimentos </option>
                                      <option value="15.11" <?= $dados->fields['item_cod_lst'] == "1511" ? "selected" : "" ?> > 15.11 -	Devolução de títulos, protesto de títulos, susta</option>
                                      <option value="15.12" <?= $dados->fields['item_cod_lst'] == "1512" ? "selected" : "" ?> > 15.12 -	Custódia em geral, inclusive de títulos e valore</option>
                                      <option value="15.13" <?= $dados->fields['item_cod_lst'] == "1513" ? "selected" : "" ?> > 15.13 -	Serviços relacionados a operações de câmbio em g</option>
                                      <option value="15.14" <?= $dados->fields['item_cod_lst'] == "1514" ? "selected" : "" ?> > 15.14 -	Fornecimento, emissão, reemissão, renovação e ma</option>
                                      <option value="15.15" <?= $dados->fields['item_cod_lst'] == "1515" ? "selected" : "" ?> > 15.15 -	Compensação de cheques e títulos quaisquer; serv</option>
                                      <option value="15.16" <?= $dados->fields['item_cod_lst'] == "1516" ? "selected" : "" ?> > 15.16 -	Emissão, reemissão, liquidação, alteração, cance</option>
                                      <option value="15.17" <?= $dados->fields['item_cod_lst'] == "1517" ? "selected" : "" ?> > 15.17 -	Emissão, fornecimento, devolução, sustação, canc</option>
                                      <option value="15.18" <?= $dados->fields['item_cod_lst'] == "1518" ? "selected" : "" ?> > 15.18 -	Serviços relacionados a crédito imobiliário, ava</option>
                                      <option value="16.01" <?= $dados->fields['item_cod_lst'] == "1601" ? "selected" : "" ?> > 16.01 -	Serviços de transporte de natureza municipal.   </option>
                                      <option value="17.01" <?= $dados->fields['item_cod_lst'] == "1701" ? "selected" : "" ?> > 17.01 -	Assessoria ou consultoria de qualquer natureza, </option>
                                      <option value="17.02" <?= $dados->fields['item_cod_lst'] == "1702" ? "selected" : "" ?> > 17.02 -	Datilografia, digitação, estenografia, expedient</option>
                                      <option value="17.03" <?= $dados->fields['item_cod_lst'] == "1703" ? "selected" : "" ?> > 17.03 -	Planejamento, coordenação, programação ou organi</option>
                                      <option value="17.04" <?= $dados->fields['item_cod_lst'] == "1704" ? "selected" : "" ?> > 17.04 -	Recrutamento, agenciamento, seleção e colocação </option>
                                      <option value="17.05" <?= $dados->fields['item_cod_lst'] == "1705" ? "selected" : "" ?> > 17.05 -	Fornecimento de mão-de-obra, mesmo em caráter te</option>
                                      <option value="17.06" <?= $dados->fields['item_cod_lst'] == "1706" ? "selected" : "" ?> > 17.06 -	Propaganda e publicidade, inclusive promoção de </option>
                                      <option value="17.07" <?= $dados->fields['item_cod_lst'] == "1707" ? "selected" : "" ?> > 17.07 -	(VETADO)                                        </option>
                                      <option value="17.08" <?= $dados->fields['item_cod_lst'] == "1708" ? "selected" : "" ?> > 17.08 -	Franquia (franchising).                         </option>
                                      <option value="17.09" <?= $dados->fields['item_cod_lst'] == "1709" ? "selected" : "" ?> > 17.09 -	Perícias, laudos, exames técnicos e análises téc</option>
                                      <option value="17.10" <?= $dados->fields['item_cod_lst'] == "1710" ? "selected" : "" ?> > 17.10 -	Planejamento, organização e administração de fei</option>
                                      <option value="17.11" <?= $dados->fields['item_cod_lst'] == "1711" ? "selected" : "" ?> > 17.11 -	Organização de festas e recepções; bufê (exceto </option>
                                      <option value="17.12" <?= $dados->fields['item_cod_lst'] == "1712" ? "selected" : "" ?> > 17.12 -	Administração em geral, inclusive de bens e negó</option>
                                      <option value="17.13" <?= $dados->fields['item_cod_lst'] == "1713" ? "selected" : "" ?> > 17.13 -	Leilão e congêneres.                            </option>
                                      <option value="17.14" <?= $dados->fields['item_cod_lst'] == "1714" ? "selected" : "" ?> > 17.14 -	Advocacia.                                      </option>
                                      <option value="17.15" <?= $dados->fields['item_cod_lst'] == "1715" ? "selected" : "" ?> > 17.15 -	Arbitragem de qualquer espécie, inclusive jurídi</option>
                                      <option value="17.16" <?= $dados->fields['item_cod_lst'] == "1716" ? "selected" : "" ?> > 17.16 -	Auditoria.                                      </option>
                                      <option value="17.17" <?= $dados->fields['item_cod_lst'] == "1717" ? "selected" : "" ?> > 17.17 -	Análise de Organização e Métodos.               </option>
                                      <option value="17.18" <?= $dados->fields['item_cod_lst'] == "1718" ? "selected" : "" ?> > 17.18 -	Atuária e cálculos técnicos de qualquer natureza</option>
                                      <option value="17.19" <?= $dados->fields['item_cod_lst'] == "1719" ? "selected" : "" ?> > 17.19 -	Contabilidade, inclusive serviços técnicos e aux</option>
                                      <option value="17.20" <?= $dados->fields['item_cod_lst'] == "1720" ? "selected" : "" ?> > 17.20 -	Consultoria e assessoria econômica ou financeira</option>
                                      <option value="17.21" <?= $dados->fields['item_cod_lst'] == "1721" ? "selected" : "" ?> > 17.21 -	Estatística.                                    </option>
                                      <option value="17.22" <?= $dados->fields['item_cod_lst'] == "1722" ? "selected" : "" ?> > 17.22 -	Cobrança em geral.                              </option>
                                      <option value="17.23" <?= $dados->fields['item_cod_lst'] == "1723" ? "selected" : "" ?> > 17.23 -	Assessoria, análise, avaliação, atendimento, con</option>
                                      <option value="17.24" <?= $dados->fields['item_cod_lst'] == "1724" ? "selected" : "" ?> > 17.24 -	Apresentação de palestras, conferências, seminár</option>
                                      <option value="18.01" <?= $dados->fields['item_cod_lst'] == "1801" ? "selected" : "" ?> > 18.01 -	Serviços de regulação de sinistros vinculados a </option>
                                      <option value="19.01" <?= $dados->fields['item_cod_lst'] == "1901" ? "selected" : "" ?> > 19.01 -	Serviços de distribuição e venda de bilhetes e d</option>
                                      <option value="20.01" <?= $dados->fields['item_cod_lst'] == "2001" ? "selected" : "" ?> > 20.01 -	Serviços portuários, ferroportuários, utilização</option>
                                      <option value="20.02" <?= $dados->fields['item_cod_lst'] == "2002" ? "selected" : "" ?> > 20.02 -	Serviços aeroportuários, utilização de aeroporto</option>
                                      <option value="20.03" <?= $dados->fields['item_cod_lst'] == "2003" ? "selected" : "" ?> > 20.03 -	Serviços de terminais rodoviários, ferroviários,</option>
                                      <option value="21.01" <?= $dados->fields['item_cod_lst'] == "2101" ? "selected" : "" ?> > 21.01 -	Serviços de registros públicos, cartorários e no</option>
                                      <option value="22.01" <?= $dados->fields['item_cod_lst'] == "2201" ? "selected" : "" ?> > 22.01 -	Serviços de exploração de rodovia mediante cobra</option>
                                      <option value="23.01" <?= $dados->fields['item_cod_lst'] == "2301" ? "selected" : "" ?> > 23.01 -	Serviços de programação e comunicação visual, de</option>
                                      <option value="24.01" <?= $dados->fields['item_cod_lst'] == "2401" ? "selected" : "" ?> > 24.01 -	Serviços de chaveiros, confecção de carimbos, pl</option>
                                      <option value="25.01" <?= $dados->fields['item_cod_lst'] == "2501" ? "selected" : "" ?> > 25.01 -	Funerais, inclusive fornecimento de caixão, urna</option>
                                      <option value="25.02" <?= $dados->fields['item_cod_lst'] == "2502" ? "selected" : "" ?> > 25.02 -	Cremação de corpos e partes de corpos cadavérico</option>
                                      <option value="25.03" <?= $dados->fields['item_cod_lst'] == "2503" ? "selected" : "" ?> > 25.03 -	Planos ou convênio funerários.                  </option>
                                      <option value="25.04" <?= $dados->fields['item_cod_lst'] == "2504" ? "selected" : "" ?> > 25.04 -	Manutenção e conservação de jazigos e cemitérios</option>
                                      <option value="26.01" <?= $dados->fields['item_cod_lst'] == "2601" ? "selected" : "" ?> > 26.01 -	Serviços de coleta, remessa ou entrega de corres</option>
                                      <option value="27.01" <?= $dados->fields['item_cod_lst'] == "2701" ? "selected" : "" ?> > 27.01 -	Serviços de assistência social.                 </option>
                                      <option value="28.01" <?= $dados->fields['item_cod_lst'] == "2801" ? "selected" : "" ?> > 28.01 -	Serviços de avaliação de bens e serviços de qual</option>
                                      <option value="29.01" <?= $dados->fields['item_cod_lst'] == "2901" ? "selected" : "" ?> > 29.01 -	Serviços de biblioteconomia.                    </option>
                                      <option value="30.01" <?= $dados->fields['item_cod_lst'] == "3001" ? "selected" : "" ?> > 30.01 -	Serviços de biologia, biotecnologia e química.  </option>
                                      <option value="31.01" <?= $dados->fields['item_cod_lst'] == "3101" ? "selected" : "" ?> > 31.01 -	Serviços técnicos em edificações, eletrônica, el</option>
                                      <option value="32.01" <?= $dados->fields['item_cod_lst'] == "3201" ? "selected" : "" ?> > 32.01 -	Serviços de desenhos técnicos.                  </option>
                                      <option value="33.01" <?= $dados->fields['item_cod_lst'] == "3301" ? "selected" : "" ?> > 33.01 -	Serviços de desembaraço aduaneiro, comissários, </option>
                                      <option value="34.01" <?= $dados->fields['item_cod_lst'] == "3401" ? "selected" : "" ?> > 34.01 -	Serviços de investigações particulares, detetive</option>
                                      <option value="35.01" <?= $dados->fields['item_cod_lst'] == "3501" ? "selected" : "" ?> > 35.01 -	Serviços de reportagem, assessoria de imprensa, </option>
                                      <option value="36.01" <?= $dados->fields['item_cod_lst'] == "3601" ? "selected" : "" ?> > 36.01 -	Serviços de meteorologia.                       </option>
                                      <option value="37.01" <?= $dados->fields['item_cod_lst'] == "3701" ? "selected" : "" ?> > 37.01 -	Serviços de artistas, atletas, modelos e manequi</option>
                                      <option value="38.01" <?= $dados->fields['item_cod_lst'] == "3801" ? "selected" : "" ?> > 38.01 -	Serviços de museologia.                         </option>
                                      <option value="39.01" <?= $dados->fields['item_cod_lst'] == "3901" ? "selected" : "" ?> > 39.01 -	Serviços de ourivesaria e lapidação (quando o ma</option>
                                      <option value="40.01" <?= $dados->fields['item_cod_lst'] == "4001" ? "selected" : "" ?> > 40.01 -	Obras de arte sob encomenda.                    </option>
                                  </select>
                              </div>                                   
                              <div class="col-sm-3 mb-2">
                                  <label for="item_situacao"  class="requi">Situação:</label>
                                  <select class="form-control requeri " id="item_situacao" name="item_situacao" <?=$disabled?> title="Código do serviço conforme lista do Anexo I da Lei Complementar Federal nº 116/2003"> 
                                      <option value="">Selecione</option>                                        
                                      <option value="A" <?= ($dados->fields['item_situacao'] == "A" || $_SESSION['op'] == "i") ? "selected" : "" ?> > ATIVO </option>
                                      <option value="I" <?= $dados->fields['item_situacao'] == "I" ? "selected" : "" ?> > INATIVO </option>
                                  </select>
                              </div>                                   
                              <div  class="col-sm-9 mb-2">
                                  <label for="item_ncm" class="requi">NCM:</label>
                                  <input type="text" class="form-control search requeri" id="item_ncm" name="t_item" value="<?php print $dados->fields['ncm']?>" <?=$disabled?> title="Nomenclatura Comum Mercosul" placeholder="Digite para Buscar Código NCM">
                                  <input type="hidden" class="form-control" id="item_ncm_id" name="item_ncm_id" value="<?php print $dados->fields['item_ncm']?>" <?=$disabled?> title="CPF, CNPJ ou Outro/">
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="tab-pane  margin-top-15 <?= ( $_SESSION['aba'] == "aba-participante-endereco" ? "active" : "" ) ?>" id="participante_endereco" role="tabpanel">

                      <div class="row mb-2 text-center" <?php print !empty($_SESSION['id']) ? "hidden" : ""?>>
                          <div class="col-sm-12 text-center">
                              <label class="text-center"><h4 class="text-center">Grave primeiramente os dados para preencher os dados de Endereço!</h4></label>
                          </div>
                      </div>
                      <div class="row mb-2" <?php print empty($_SESSION['id']) ? "hidden" : ""?>>
                          <div class="col-sm-12 row">                                

                              <div  class="col-sm-1 form-group">
                                  <label for="participante_endereco_tipo" class="requi">Tipo:</label>
                                  <select class="form-control endereco" id="participante_endereco_tipo" name="participante_endereco_tipo">
                                      <option value="" >Selecione </option>
                                      <option value="1">1 - Faturamento   </option>
                                      <option value="2">2 - Comercial     </option>
                                      <option value="3">3 - Entrega       </option>
                                  </select>
                              </div>

                              <div  class="col-sm-1 form-group">
                                  <label for="participante_endereco_cep" class="requi">CEP:</label>
                                  <input type="text" class="form-control endereco" id="participante_endereco_cep" name="participante_endereco_cep" value="<?php print $dados->fields['participante_endereco_cep']?>" <?=$disabled?>/>
                              </div>                                

                              <div  class="col-sm-1 form-group">
                                  <label for="participante_endereco_uf" class="requi">UF:</label>
                                  <input type="text" class="form-control  cep endereco" id="participante_endereco_uf" name="participante_endereco_uf" value="<?php print $dados->fields['participante_endereco_uf']?>" <?=$disabled?>/>
                              </div>

                              <div  class="col-sm-2 form-group" >
                                  <label for="participante_endereco_descricao" class="requi">Município:</label>
                                  <input type="text" class="form-control  cep endereco" id="participante_endereco_descricao" name="participante_endereco_descricao" value="<?php print $dados->fields['participante_endereco_descricao']?>" <?=$disabled?>/>
                                  <input type="hidden" class="form-control   endereco" id="participante_codigo_municipio" name="participante_codigo_municipio" value="<?php print $dados->fields['participante_codigo_municipio']?>" <?=$disabled?>/>
                              </div>

                              <div  class="col-sm-3 form-group" >
                                  <label for="participante_endereco_logradouro" class="requi">Endereço ( Logradouro ):</label>
                                  <input type="text" class="form-control  cep endereco" id="participante_endereco_logradouro" name="participante_endereco_logradouro" value="<?php print $dados->fields['participante_endereco_logradouro']?>" <?=$disabled?>/>
                              </div>


                              <div  class="col-sm-1 form-group">
                                  <label for="participante_endereco_numero" class="requi">Número:</label>
                                  <input type="text" class="form-control  cep endereco" id="participante_endereco_numero" name="participante_endereco_numero" value="<?php print $dados->fields['participante_endereco_numero']?>" <?=$disabled?>/>
                              </div>

                              <div  class="col-sm-1 form-group">
                                  <label for="participante_endereco_bairro" class="requi">Bairro:</label>
                                  <input type="text" class="form-control  cep endereco" id="participante_endereco_bairro" name="participante_endereco_bairro" value="<?php print $dados->fields['participante_endereco_bairro']?>" <?=$disabled?>/>
                              </div>

                               <div  class="col-sm-2 form-group">
                                  <label for="participante_endereco_complemento">Complemento:</label>
                                  <input type="text" class="form-control  cep endereco" id="participante_endereco_complemento" name="participante_endereco_complemento" value="<?php print $dados->fields['participante_endereco_complemento']?>" <?=$disabled?>/>
                              </div>

                               <div  class="col-sm-12 form-group">
                                   <button type="button" class="btn btn-success" id="btnAdicionarEndereco" style="width: 100%;">
                                       <span class="fas fa-plus"></span> Adicionar Endereço
                                   </button>
                              </div>
                               <div  class="col-sm-12 form-group">
                                   <div class="col-sm-12 row text-center col-sm-auto" >

                                      <table class="table" id="tableItens">
                                          <thead>
                                              <tr>
                                                  <th class="text-center" width="10%">Tipo            </th>
                                                  <th class="text-center" width="5%" >UF              </th>
                                                  <th class="text-center" width="5%" >CEP             </th>
                                                  <th class="text-center" width="10%">Município       </th>
                                                  <th class="text-center" width="35%">Endereço        </th>
                                                  <th class="text-center" width="10%">Número          </th>
                                                  <th class="text-center" width="10%">Bairro          </th>
                                                  <th class="text-center" width="15%">Complemento     </th>
                                                  <th class="text-center" width="5%">    </th>
                                              </tr>
                                          </thead>
                                          <tbody>

                                              <?php
                                          if ( $_SESSION['id'] != "" ){
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

                                              while(!$objDados->EOF){       

                                                  ?>


                                                  <tr>
                                                      <td class="text-center"  ><?= $objDados->fields[0] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[1] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[2] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[3] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[4] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[5] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[6] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[7] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[8] ?></td>
                                                      <td class="text-center"  >
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

                  <div class="tab-pane  margin-top-15 <?= ( $_SESSION['aba'] == "aba-participante-contato" ? "active" : "" ) ?>" id="participante_contato" role="tabpanel">
                      <div class="row mb-2 text-center" <?php print !empty($_SESSION['id']) ? "hidden" : ""?>>
                          <div class="col-sm-12 text-center">
                              <label class="text-center"><h4 class="text-center">Grave primeiramente os dados para preencher os dados de Endereço!</h4></label>
                          </div>
                      </div>
                      <div class="row mb-2" <?php print empty($_SESSION['id']) ? "hidden" : ""?>>
                          <div class="col-sm-12 row" >

                              <div  class="col-sm-2 form-group">
                                  <label for="participante_contato_tipo" class="requi">Tipo:</label>
                                  <select class="form-control endereco" id="participante_contato_tipo" name="participante_contato_tipo">
                                      <option value="" >Selecione </option>
                                      <option value="1">1 - Telefone Fixo     </option>
                                      <option value="2">2 - Celular           </option>
                                      <option value="3">3 - E-mail            </option>
                                  </select>
                              </div>

                              <div  class="col-sm-4 form-group" >
                                  <label for="participante_contato_descricao">Descrição do Contato:</label>
                                  <input type="text" class="form-control telefone_fixo" id="participante_contato_descricao" name="participante_contato_descricao" value="<?php print $dados->fields['participante_contato_descricao']?>" <?=$disabled?>/>
                                  <input type="text" class="form-control escondido" id="participante_contato_descricao_email" name="participante_contato_descricao_email" value="<?php print $dados->fields['participante_contato_descricao']?>" <?=$disabled?>/>
                              </div>    
                              <div  class="col-sm-6 form-group" style="padding-top: 29.5px;">
                                   <button type="button" class="btn btn-info" id="btnAdicionarContato" style="width: 100%; ">
                                       <span class="fas fa-plus"></span> Adicionar Contato
                                   </button>
                              </div>
                              <div  class="col-sm-12 form-group">
                                   <div class="col-sm-12 row text-center col-sm-auto" >

                                      <table class="table" id="tableItensContato">
                                          <thead>
                                              <tr>
                                                  <th class="text-center" width="10%" >Tipo            </th>
                                                  <th class="text-center" width="85%" >Descrição       </th>
                                                  <th class="text-center" width="5%"  > </th>
                                              </tr>
                                          </thead>
                                          <tbody>

                                          <?php
                                          if ( $_SESSION['id'] != "" ){

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


                                              while(!$objDados->EOF){?>


                                                  <tr>
                                                      <td class="text-center"  ><?= $objDados->fields[1] ?></td>
                                                      <td class="text-center"  ><?= $objDados->fields[2] ?></td>    
                                                      <td class="text-center"  >
                                                          <button type="button" class="btn btn-danger btnRemoveItemContato" name="<?= $objDados->fields[0] ?>"> <i class="fas fa-trash"></i> </button>
                                                      </td>
                                                   </tr>

                                                   <?php
                                                  $objDados->MoveNext();
                                              }  
                                          }?>
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
    
      $("button").on("click",function(){
           console.log("teste") 
        });
    
    $(document).ready(function($){

        
        //Máscaras e validações        
        $('#item_aliq_icms').mask('000.000.000.000.000,00', {reverse: true});
        $("#item_aliq_icms").change(function(){ $("#value").html($(this).val().replace(/\D/g,'')) })
        
        //        $("#item_aliq_icms").priceFormat({ prefix: '% ', centsSeparator: ',', thousandsSeparator: '.', limit: 6, centsLimit: 2, clearPrefix: true });
        addMascarasCPF_CNPJ();
        
        $("#item_cest").mask("99.999.99");
        $(".telefone_fixo").mask("(99) 9999-9999");
        $("#participante_endereco_cep").mask("99.999-999");
        $("#participante_tipo"   ).on("change",function(){ addMascarasCPF_CNPJ();        });
        
        
        
        $("#btnAdicionarEndereco").on("click", function(){ movimentaItens("novo","","endereco"); });
        $(".btnRemoveItem"       ).on("click", function(){ movimentaItens("delete",$(this).prop("name"),"endereco"); });
        $("#btnAdicionarContato" ).on("click", function(){ movimentaItens("novo","","contato"); });        
        $(".btnRemoveItemContato").on("click", function(){ movimentaItens("delete",$(this).prop("name"),"contato");  });        
                                
        $("#aba-participante-endereco, #aba-participante-contato").on("click",function(){ $("#btnSalvar, #btnExcluir, #btnVoltar").hide(); });
        $("#aba-participante-geral").on("click",function(){ $("#btnSalvar, #btnExcluir, #btnVoltar").show(); });

      
        
        function addMascarasCPF_CNPJ(){
            var tipo = $("#participante_tipo").val();
                      
            if ( tipo === "J" )      {  $("#participante_codigo").mask("99.999.999/9999-99"); }           
            else if ( tipo === "F" ) {  $("#participante_codigo").mask("999.999.999-99");     }          
            else if ( tipo === "E" ) {  $("#participante_codigo").mask("999.9999");           }            
            else                     {  $("#participante_codigo").mask("999.9999");           }
        }        
        
        
        function movimentaItens(tipo,id, method){
            $.ajax({
                url: "<?= $_SERVER['localhost'] ?>/mmflow/_man/manutencao/mainAdmParticipante.php",
                type: "post",
                dataType: "text",
                data: { 
                    op: method,
                    type: tipo,          
                    id_movim: id,
                    participante_endereco_tipo          : $("#participante_endereco_tipo").val(),
                    participante_endereco_cep           : $("#participante_endereco_cep").val(),
                    participante_endereco_uf            : $("#participante_endereco_uf").val(),
                    participante_codigo_municipio       : $("#participante_codigo_municipio").val(),
                    participante_endereco_logradouro    : $("#participante_endereco_logradouro").val(),
                    participante_endereco_numero        : $("#participante_endereco_numero").val(),
                    participante_endereco_bairro        : $("#participante_endereco_bairro").val(),
                    participante_endereco_complemento   : $("#participante_endereco_complemento").val(),
                    participante_contato_tipo           : $("#participante_contato_tipo").val(),
                    participante_contato_descricao      : $("#participante_contato_descricao").val(),
                    participante_contato_descricao_email: $("#participante_contato_descricao_email").val()
                },
                success: function(retorno){
                    location.reload();
                }
            }); 
        }        
                                   
       //Fim - Máscaras e Validações               
       $("#participante_contato_tipo").on("click",function(){
           var value = $(this).val();          
           
            $("#participante_contato_descricao_email").addClass("escondido");
            $("#participante_contato_descricao").removeClass("escondido");
           
           if ( value == 1 ){
               $("#participante_contato_descricao").attr("placeholder","Insira o contato telefônico.");
               $("#participante_contato_descricao").mask("(18) 9999-9999");
           }
           else if ( value == 2 ){
               $("#participante_contato_descricao").attr("placeholder","Insira o número do celular!");
               $("#participante_contato_descricao").mask("(18) 9 9999-9999");
           }
           else if ( value == 3 ){
               $("#participante_contato_descricao").addClass("escondido");
               $("#participante_contato_descricao_email").removeClass("escondido");
               $("#participante_contato_descricao_email").attr("placeholder","Inserir um e-mail válido!");
           }
                                 
       });
       
       //Função que valida os dados inseridos no banco de dados.
       $(".unique").on("change", function(){
           var v1   = "t_item";
           var v2   = $(this).prop("name");
           var v3   = "=";
           var v4   = $(this).val();
           var v    = "duplicate";
           
           validaData(v1, v2, v3, v4, v);
       });
       
       $("#participante_endereco_cep").on("change",function(){
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
                    $("#participante_endereco_uf").val(retorno.dados.estado);
                    $("#participante_endereco_descricao").val(retorno.dados.cod_cidade + " - " + retorno.dados.cidade);
                    $("#participante_codigo_municipio").val(retorno.dados.cod_cidade);
                }
            }); 
        });                                                   

        $(".search").on("keypress", function(){
           var table = $(this).prop("name");
           var input = $(this).prop("id");
           
           $("#"+input).removeClass("alert-success");
           
           $(".search").autocomplete({                        
                source: function( request, response){
                    $.ajax({
                        url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/search/_searchData.php",
                        type: "post",
                        dataType: "json",
                        data: { 
                            descricao: request.term,
                            table: table,
                            tipo: "ncm"
                        },
                        success: function(data){
                            response($.map(data.dados, function(item){
                                return {
                                    id    : item.ret_1,
                                    value : item.ret_1 + ' - ' + item.ret_2
                                };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui){
                    $('#item_ncm_id').val(ui.item.id);
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
        
        

        
                          
    });
    </script>

  <!-- /.content-wrapper -->