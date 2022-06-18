<!-- Main content -->
<section class="content">
   <!-- INICIAMOS O MODO TELA -->
    <?php  
    if ( $_SESSION['op'] == "" ){
        $filtro_busca = $where = "";
        if ( !empty($_POST['filtro_busca']) ){
            $filtro_busca = retira_caracteres($_POST['filtro_busca']);
            $where = 
            " AND ( cfop_codigo    ILIKE '%{$filtro_busca}%' 
                  OR cfop_descricao ILIKE '%{$filtro_busca}%' )";

            $filtro_busca = $_POST['filtro_busca'];
        } 
    ?>
    <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">
            <form role="search" method="post" action="menu_sys.php">
                <div class="row">
                    <div class="col-sm-2">                  
                        <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_cfop','insert','', 'movimentacao','','')">
                            <span class="fas fa-plus"></span>
                            Novo Item
                        </button>                  
                    </div>
                    <div class="col-sm-8">
                        <div class="col-sm-12">                        
                            <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $_POST['filtro_busca'] ?>" placeholder="Busque pelo código ou descrição..."/>
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
            $intPaginaAtual = ( $_SESSION['p'] );
            $intPaginaAtual = filter_var( $intPaginaAtual, FILTER_VALIDATE_INT );
            $intLimite      = 10;
            $intInicio      = ( $intPaginaAtual != '' ? ( ( $intPaginaAtual - 1 ) * $intLimite ) : 0 );                                   

            #buscamos os dados
            $sql = "SELECT cfop_id 
                        , cfop_codigo 
                        , cfop_descricao 
                        , cfop_tipo
                    FROM t_cfop c
                    WHERE cfop_id IS NOT NULL 
                    {$where}
                    ORDER BY 1;";                     

            $dados = $bd->Execute($sql);

            #Setamos a quantidade de itens na busca
            $qtdRows = $dados->RecordCount();
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
                                <th width="5%" class="text-left"  >Código              </th>
                                <th width="5%" class="text-left"  >Tipo              </th>
                                <th width="65%" class="text-left"  >Descrição           </th>
                                <th width="10%" class="text-center">Ações               </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php  
                        if ( $dados->RecordCount() > 0 ){ 
                            while ( !$dados->EOF ) { ?>
                            <tr>
                                <td class="text-left"  ><?= $dados->fields['cfop_codigo']         ?></td>
                                <td class="text-left"  ><?= $dados->fields['cfop_tipo']         ?></td>
                                <td class="text-left"  ><?= $dados->fields['cfop_descricao']    ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_cfop','view','<?= $dados->fields['cfop_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-info" onclick="movPage('adm_cfop','edit','<?= $dados->fields['cfop_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="movPage('adm_cfop','delete','<?= $dados->fields['cfop_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar.">
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
            $sql = "
                SELECT cfop_id 
                    , cfop_codigo 
                    , cfop_descricao 
                    , cfop_tipo
                FROM t_cfop tc 
                WHERE cfop_id = '{$_SESSION['id']}';";

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
                  <label><?= $description ?> Dados do CFOP</label>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainCFOP.php" method="post" id="frmDados">
                <div class="form-group row">
                    <div class="col-sm-1">
                      <label for="cfop_codigo" >Código:</label>
                      <input type="text" class="form-control requeri" id="cfop_codigo" name="cfop_codigo" value="<?= $dados->fields['cfop_codigo']?>" <?=$disabled?>/>
                    </div>
                    <div class="col-sm-2">
                        <label for="cfop_codigo" >Tipo:</label>
                        <select class="form-control" id="cfop_tipo" name="cfop_tipo" <?=$disabled?> >
                            <option value="FISCAL"    <?= $dados->fields['cfop_tipo'] == "FISCAL"? "selected" : "" ?>>FISCAL</option>
                            <option value="GERENCIAL" <?= $dados->fields['cfop_tipo'] == "GERENCIAL"? "selected" : "" ?>>GERENCIAL</option>
                        </select>
                    </div>
                    <div class="col-sm-9">
                      <label for="cfop_descricao">Descrição:</label>
                      <input type="text" class="form-control requeri" id="cfop_descricao" name="cfop_descricao" value="<?= $dados->fields['cfop_descricao']?>" <?=$disabled?>/>
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
                    <button type="button" class="btn btn-danger form-control" id="btnSalvar">
                        <span class="fas fa-trash"></span>
                        Excluir
                    </button>                  
                 </div>
              <?php } ?>
              <div class="col-sm-2 ">                  
                <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_cfop','','', 'movimentacao','','')">
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