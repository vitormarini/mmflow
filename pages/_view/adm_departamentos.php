<section class="content">

   <!-- INICIAMOS O MODO TELA -->
    <?php  
    if ( $_SESSION['op'] == "" ){

      $buscas = explode("&",$_SESSION["buscas"]);
      
      $filtro_busca = $where = "";
        if ( !empty($_POST['filtro_busca']) ){
            $filtro_busca = retira_caracteres($_POST['filtro_busca']);
            $where = 
            "WHERE dpto_id IS NOT NULL 
                AND ( dpto_nome      ILIKE '%{$filtro_busca}%' 
                   OR dpto_descricao ILIKE '%{$filtro_busca}%' )";
        } 
    ?>

  <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">   
            <form role="search" method="post" action="menu_sys.php">       
                <div class="row">
                    <div class="col-sm-2">                  
                        <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_departamentos','insert','', 'movimentacao','','')">
                            <span class="fas fa-plus"></span>
                            Novo
                        </button>                  
                    </div>
                    <div class="col-sm-8">
                        <div class="col-sm-auto">                        
                            <input type="text" class="form-control buscas" id="filtro_busca" name="filtro_busca" value="<?= $_POST['filtro_busca'] ?>" placeholder="Busque pelo Nome, Nickname ou E-mail..."/>
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
            $intPaginaAtual = ( $_SESSION['p'] );
            $intPaginaAtual = filter_var( $intPaginaAtual, FILTER_VALIDATE_INT );
            $intLimite      = 10;
            $intInicio      = ( $intPaginaAtual != '' ? ( ( $intPaginaAtual - 1 ) * $intLimite ) : 0 );                                   

            #buscamos os dados
            $sql = "SELECT  dpto_id         , dpto_nome             , dpto_descricao
                            , CASE 
                                    WHEN dpto_ativo = 'S' THEN 'Ativo'
                                    ELSE 'INATIVO'
                              END AS dpto_ativo_desc
                    FROM t_departamentos  {$where} 
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="09%"> #           </th>
                                <th width="10%">Situação     </th>
                                <th width="20%">Nome         </th>
                                <th width="46%">Descrição    </th>
                                <th width="15%" class="text-center">Ações           </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ( $dados->RecordCount() > 0 ){ 
                                while ( !$dados->EOF ) {
                                    
                                    $alert = $dados->fields['dpto_ativo_desc'] == "Ativo" ? "" : "alert-danger";

                                    ?>
                            <tr>
                                <td class="text-left"><?= $dados->fields['dpto_id']                       ?></td>
                                <td class="text-left <?= $alert ?>"><?= $dados->fields['dpto_ativo_desc']                       ?></td>
                                <td class="text-left"><?= $dados->fields['dpto_nome']                       ?></td>
                                <td class="text-left"><?= $dados->fields['dpto_descricao']                           ?></td>
                                <td class="text-center">
                                    <button class="btn btn-success" onclick="movPage('adm_departamentos','view','<?= $dados->fields['dpto_id'] ?>', 'movimentacao','','')" title="Clique para visualizar a informação.">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-info" onclick="movPage('adm_departamentos','edit','<?= $dados->fields['dpto_id'] ?>', 'movimentacao','','')" title="Clique para Editar.">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" onclick="movPage('adm_departamentos','delete','<?= $dados->fields['dpto_id'] ?>', 'movimentacao','','')" title="Clique para Eliminar." hidden>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                    $dados->MoveNext();                                     
                                } 
                            }else{ ?>                            
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
  <?php } else {

      if ( $_SESSION['id'] != "" ){
        #Monta SQL para busca
        $sql = "SELECT  dpto_id     , dpto_nome             , dpto_descricao, dpto_ativo
                   FROM t_departamentos 
                  WHERE dpto_id = '{$_SESSION['id']}';";



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

       #Resgatando os Menus
       $dataMenu = $bd->Execute($sql = "SELECT menu_descricao ,	menu_id FROM t_menu ORDER BY 1;");
      ?>
  <div class="card body-view">
    <div class="card-header">
      <div class="row">
            <div class="col-sm-12">           
                <label><?= $description ?> Dados do Departamento</label>
            </div>
      </div>
    </div>
    <div class="card-body">
        <form action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainAdmDepartamento.php" method="post" id="frmDados">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a href="#user_geral" id="aba-user-geral"  role="tab" data-toggle="tab" class="nav-link  active" >Dados Departamento</a>
                </li>     
            </ul>
            <div class="tab-content">
                <div class="tab-pane margin-top-15 active" id="user_geral" role="tabpanel">
                    <div class="row">
                        <div class="row col-sm-12">
                            <div  class="col-sm-4  mb-2">
                                <label or="dpto_nome">Nome Departamento:</label>
                                <input type="text" class="form-control requeri unique" id="dpto_nome" name="dpto_nome" value="<?php print $dados->fields['dpto_nome']?>" <?=$disabled?>/>
                            </div>
                            <div  class="col-sm-6  mb-2">
                                <label for="dpto_descricao">Descrição:</label>
                                <input type="text" class="form-control requeri unique" id="dpto_descricao" name="dpto_descricao" value="<?php print $dados->fields['dpto_descricao']?>" <?=$disabled?>/>
                            </div>                            
                            <div  class="col-sm-2  mb-2">
                                <label or="dpto_ativo">Situação:</label>
                                <select class="form-control" id="dpto_ativo" name="dpto_ativo">
                                    <option value="S" <?php print $dados->fields['dpto_ativo'] == "S" ? "selected": ""?>>Sim</option>
                                    <option value="N" <?php print $dados->fields['dpto_ativo'] == "N" ? "selected": ""?>>Não</option>
                                </select>
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
              <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_departamentos','','', 'movimentacao','','')">
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
<?php include_once '../../_import/modals.php'; ?>
<?php include_once "../../_man/search/_searchData.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>