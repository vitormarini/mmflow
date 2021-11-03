<?php
    $local = $bd->Execute(
      "SELECT 
            t_menu.menu_descricao AS menu
     ,	CASE 
                    WHEN menu_submenu_categoria = 'CADASTROS' THEN 'Cadastros'
                    WHEN menu_submenu_descricao = 'RELATORIO' THEN 'Relatórios'
                    WHEN menu_submenu_categoria = 'MOVIMENTO' THEN 'Movimentação'
            END AS categoria
     ,	t_menu_sub.menu_submenu_descricao AS sub
    FROM t_menu_sub
    INNER JOIN t_menu ON ( t_menu.menu_id = t_menu_sub.menu_id )
    WHERE menu_submenu_url  = 'adm_empresas';");
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gerenciamento dos Menus</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="menu_sys.php">Home</a></li>
              <li class="breadcrumb-item active"> <b><?= $local->fields['menu']?></b> > <i><?=$local->fields['categoria']?></i> > <u><?= $local->fields['sub'] ?></u></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

       <!-- INICIAMOS O MODO TELA -->
        <?php  if ( $_SESSION['op'] == "" ){
          
          $buscas = explode("&",$_SESSION["buscas"]);
          $filtro_busca = $where = "";
          if ( count($buscas) > 0 ){
              $where = 
              "WHERE menu_id IS NOT NULL 
                 AND ( menu_descricao ILIKE '%".explode("=", $buscas[0])[1]."%' 
                    OR menu_url       ILIKE '%".explode("=", $buscas[0])[1]."%' )";
              
              $filtro_busca = explode("=", $buscas[0])[1];
                      
          } 
        ?>
        
      <!-- Default box -->
      <div class="card body-view">
        <div class="card-header">          
          
          <div class="row">
                <div class="col-sm-2">                  
                    <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_menus','insert','', 'movimentacao','','')">
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
                  <button type="button" class="btn btn-info buscas" id="btnBusca" onclick="movPage('adm_menus','','', 'movimentacao','','')">
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
            $sql = "SELECT menu_id, menu_descricao, menu_icon, menu_url FROM public.t_menu {$where} ORDER BY 1;";
            
            
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
                                <th width="10%">#               </th>
                                <th width="60%">Descrição Menu  </th>
                                <th width="20%">URL             </th>
                                <th width="10%" class="text-center">Ações           </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ( $dados->RecordCount() > 0 ){ ?>
                                <?php while ( !$dados->EOF ) { ?>
                            <tr>
                                <td class="text-center"><?= $dados->fields['menu_id']           ?></td>
                                <td class="text-left"  ><?= $dados->fields['menu_descricao']    ?></td>
                                <td class="text-left"  ><?= $dados->fields['menu_url']          ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_menus','view','<?= $dados->fields['menu_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-info" onclick="movPage('adm_menus','edit','<?= $dados->fields['menu_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="movPage('adm_menus','delete','<?= $dados->fields['menu_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar.">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                </td>
                            </tr>
                                
                                <?php $dados->MoveNext(); } ?>
                                
                            <?php }else{ ?>
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
            $sql = "SELECT menu_id, menu_descricao, menu_icon, menu_url FROM public.t_menu WHERE menu_id = '{$_SESSION['id']}';";

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
                    <label><?= $description ?> Dados do Menu</label>
               </div>
              
          </div>
            
        </div>
        <div class="card-body">
            <form action="<?= $_SERVER['localhost']?>/sys/_man/manutencao/mainAdmMenus.php" method="post" id="frmDados">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="menu_descricao" >Descrição do Menu:</label>
                        <input type="text" class="form-control requeri" id="menu_descricao" name="menu_descricao" value="<?php print $dados->fields['menu_descricao']?>" <?=$disabled?>/>
                    </div>
                    <div class="col-sm-4">
                        <label for="menu_url">URL do Menu:</label>
                        <input type="text" class="form-control requeri" id="menu_url" name="menu_url" value="<?php print $dados->fields['menu_url']?>" <?=$disabled?>/>
                    </div>
                    <div class="col-sm-2">
                        <label for="menu_icone">Ícone de Apresentação ( fas-icons ):</label>
                        <input type="text" class="form-control requeri" id="menu_icone" name="menu_icone" value="<?php print $dados->fields['menu_icon']?>" <?=$disabled?>/>
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
                  <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_menus','','', 'movimentacao','','')">
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
  </div>


  <!-- /.content-wrapper -->