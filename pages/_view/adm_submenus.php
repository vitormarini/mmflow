<!-- Main content -->
<section class="content">
   <!-- INICIAMOS O MODO TELA -->
    <?php  if ( $_SESSION['op'] == "" ){
        $buscas = explode("&",$_SESSION["buscas"]);
        $filtro_busca = $where = "";
        if ( count($buscas) > 0 ){
            $where = 
            "WHERE menu_sub_id IS NOT NULL 
               AND ( menu_submenu_descricao ILIKE '%".explode("=", $buscas[0])[1]."%' 
                  OR menu_submenu_url       ILIKE '%".explode("=", $buscas[0])[1]."%' )";

            $filtro_busca = explode("=", $buscas[0])[1];
        } 
    ?>
    <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">
            <div class="row">
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_submenus','insert','', 'movimentacao','','')">
                      <span class="fas fa-plus"></span>
                      Novo Item
                  </button>                  
                </div>
                <div class="col-sm-8">
                    <div class="col-sm-12">                        
                        <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $filtro_busca?>" placeholder="Busque pela Descrição ou Url..."/>
                    </div>
                </div>
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-info buscas" id="btnBusca" onclick="movPage('adm_submenus','','', 'movimentacao','','')">
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
            $sql = "SELECT menu_sub_id, menu_submenu_descricao, menu_submenu_icon, menu_submenu_url, t_menu.menu_descricao, menu_submenu_categoria
                     FROM public.t_menu_sub
                     INNER JOIN t_menu ON ( t_menu.menu_id = t_menu_sub.menu_id ) 
                     {$where} ORDER BY 1;";


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
                                <th width="05%" class="text-center">#                   </th>
                                <th width="20%" class="text-left"  >Menu Principal      </th>
                                <th width="20%" class="text-left"  >SubMenu Descrição   </th>
                                <th width="17%" class="text-left"  >SubMenu Categoria   </th>
                                <th width="18%" class="text-left"  >URL                 </th>
                                <th width="20%" class="text-center">Ações               </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
                        if ( $dados->RecordCount() > 0 ){ 
                            while ( !$dados->EOF ) { ?>
                            <tr>
                                <td class="text-center"><?= $dados->fields['menu_sub_id']               ?></td>
                                <td class="text-left"  ><?= $dados->fields['menu_descricao']            ?></td>
                                <td class="text-left"  ><?= $dados->fields['menu_submenu_descricao']    ?></td>
                                <td class="text-left"  ><?= $dados->fields['menu_submenu_categoria']    ?></td>
                                <td class="text-left"  ><?= $dados->fields['menu_submenu_url']          ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_submenus','view','<?= $dados->fields['menu_sub_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-info" onclick="movPage('adm_submenus','edit','<?= $dados->fields['menu_sub_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="movPage('adm_submenus','delete','<?= $dados->fields['menu_sub_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar.">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php $dados->MoveNext();
                            } 
                        }else{?>
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
                    <label><?php paginacao( 'menu_sys.php', $intPaginaAtual, $intLimite, $qtdRows ); ?></label>                    
                </div>
            </div>
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
    <?php     
    } else {
        if ( $_SESSION['id'] != "" ){
            #Monta SQL para busca
            $sql = "SELECT menu_sub_id, menu_submenu_descricao, menu_submenu_icon, menu_submenu_url, menu_id FROM public.t_menu_sub WHERE menu_sub_id = '{$_SESSION['id']}';";

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
                  <label><?= $description ?> Dados do Sub-Menu</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= $_SERVER['localhost']?>/sys/_man/manutencao/mainAdmSubMenus.php" method="post" id="frmDados">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="menu_descricao" >Menu Principal:</label>
                        <select class="form-control requeri" id="menu_id" name="menu_id">
                            <option value="" <?php print $_SESSION['id'] != "" ? "disabled" : "" ?>> Selecione </option>
                            <?php $menu = $bd->Execute("SELECT menu_id, menu_descricao FROM t_menu order by 2;"); 
                                while ( !$menu->EOF ){ 
                                    $selected = $menu->fields['menu_id'] == $dados->fields['menu_id'] ? "selected" : "";
                                    print '<option value="'. $menu->fields['menu_id'] .'" '. $selected .'>'. $menu->fields['menu_descricao'] .'</option>';
                                    $menu->MoveNext();
                                }    
                            ?>
                      </select>
                    </div>
                    <div class="col-sm-2">
                      <label for="menu_descricao" >Categoria:</label>
                      <select class="form-control requeri" id="menu_submenu_categoria" name="menu_submenu_categoria">
                          <option value="" <?php print $_SESSION['id'] != "" ? "disabled" : "" ?>> Selecione </option>        
                          <option value="CADASTROS"    <?php print $dados->fields['menu_sub_id'] == "CADASTROS" ? "selected" : "" ?>> 01 - CADASTROS    </option>        
                          <option value="MOVIMENTO"    <?php print $dados->fields['menu_sub_id'] == "MOVIMENTO" ? "selected" : "" ?>> 02 - MOVIMENTAÇÃO </option>        
                          <option value="RELATORIO"    <?php print $dados->fields['menu_sub_id'] == "RELATORIO" ? "selected" : "" ?>> 03 - RELATÓRIOS   </option>        
                      </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-5">
                      <label for="menu_descricao" >Descrição do SubMenu:</label>
                      <input type="text" class="form-control requeri" id="menu_submenu_descricao" name="menu_submenu_descricao" value="<?php print $dados->fields['menu_submenu_descricao']?>" <?=$disabled?>/>
                    </div>
                    <div class="col-sm-4">
                      <label for="menu_url">URL do SubMenu:</label>
                      <input type="text" class="form-control requeri" id="menu_submenu_url" name="menu_submenu_url" value="<?php print $dados->fields['menu_submenu_url']?>" <?=$disabled?>/>
                    </div>
                    <div class="col-sm-3">
                      <label for="menu_icone">Ícone de Apresentação (fas-icons):</label>
                      <input type="text" class="form-control requeri" id="menu_submenu_icon" name="menu_submenu_icon" value="<?php print $dados->fields['menu_submenu_icon']?>" <?=$disabled?>/>
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
                <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_submenus','','', 'movimentacao','','')">
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