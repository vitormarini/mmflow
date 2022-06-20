<!--<link rel="stylesheet" type="text/css" href="../../DataTables/datatables.min.css"/>-->
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">-->
<style>
    .inputfile { width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute;  z-index: -1; }      

    .inputfile:focus + label,
    .inputfile.has-focus + label {
        outline: 1px dotted #000;
        outline: -webkit-focus-ring-color auto 5px;
    }
    
    #arquivo:focus + label,
    #arquivo.has-focus + label,
    .backgroundDescricao{
        background-color: #F2F2F2;
        border-radius: 10px;
    }
    
    #envio_arquivo      { margin-top: 20px;      }
    #insercao_manual    { font-size: 12px;       } 
</style>

<!-- Main content -->
<section class="content">    
   <!-- INICIAMOS O MODO TELA -->
    <?php  
    if ( $_SESSION['op'] == "" ){
        $filtro_busca = $where = "";
        if ( !empty($_POST['filtro_busca']) ){
            $filtro_busca = retira_caracteres($_POST['filtro_busca']);
            $where = 
            "AND (chamados_id            ILIKE '%{$filtro_busca}%' 
                OR empresa_cnpj           ILIKE '%{$filtro_busca}%' 
                OR empresa_razao_social   ILIKE '%{$filtro_busca}%')";
        } 
        if (  strlen($_POST['filtro_busca_select']) > 2 ){
            $filtro_busca = $_POST['filtro_busca_select'];
            $where = ($where != "" ? "AND " : "AND ").
            "c_status = '{$filtro_busca}'";
        } 
    ?>
    <!-- Default box -->
    <div class="card body-view">
        <div class="card-header">  
            <form role="search" method="post" action="menu_sys.php">
                <div class="row">
                    <div class="col-sm-2">                  
                        <button type="button" class="btn btn-success" id="btnNovo" onclick="movPage('adm_chamados','insert','', 'movimentacao','','')">
                            <span class="fas fa-plus"></span>
                            Novo Item
                        </button>                  
                    </div>
                    <div class="col-sm-2">
                        <div class="col-sm-12">                        
                            <select class="form-control buscas" id="filtro_busca_select" name="filtro_busca_select">
                                <option value="">TODOS</option>
                                <option value="ABERTO"      <?php print ($_POST['filtro_busca_select'] == "ABERTO" ? "selected" : "" ); ?>>ABERTO</option>
                                <option value="EM_ANDAMENTO"<?php print ($_POST['filtro_busca_select'] == "EM_ANDAMENTO" ? "selected" : "" ); ?>>EM_ANDAMENTO</option>
                                <option value="ENCERRADO"   <?php print ($_POST['filtro_busca_select'] == "ENCERRADO" ? "selected" : "" ); ?>>ENCERRADO</option>
                            </select> 
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-sm-12">                        
                            <input type="text" class="form-control buscas" id="filtro_buscca" name="filtro_busca" value="<?= $_POST['filtro_busca'] ?>" placeholder="Busque pela Razão Social o CNPJ..."/>
                        </div>
                    </div>
                    <div class="col-sm-2">                  
                    <button type="submit" class="btn btn-info">
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
            $sql = "
                SELECT  chamados_id                                             
                    , c_prioridade
                    , c_status
                    , c_tipo
                    , c_departamento
                    , c_responsavel_id
                    , c_assunto
                    , c_servico
                    , c_anexo
                    , u.user_nome
                    , r.user_nome AS user_nome_r
                    , databrasil(c_data_abertura::date)   AS c_data_abertura
                    , databrasil(c_data_fechamento::date) AS c_data_fechamento
                FROM    t_chamados c 
                INNER JOIN t_user u ON ( u.user_id = c.c_user_id )
                INNER JOIN t_user r ON ( r.user_id = c.c_responsavel_id )
                WHERE ( u.user_id = {$_SESSION['user_id']} OR r.user_id = {$_SESSION['user_id']})
                {$where}
                ORDER BY chamados_id;";

               
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
            <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>                            
                            <th class="text-center" width="05%">Status          </th>                            
                            <th class="text-center" width="05%">ID              </th>                            
                            <th class="text-center" width="15%">Usuário         </th>                            
                            <th class="text-center" width="15%">Responsável     </th>
                            <th class="text-center" width="20%">Detalhe         </th>
                            <th class="text-center" width="10%">Tipo            </th>
                            <th class="text-center" width="10%">Dt Abertura     </th>
                            <th class="text-center" width="10%">Dt Conclusão    </th>
                            <th class="text-center" width="10%" colspan="2">Opções          </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while(!$dados->EOF){
                                if ( $dados->fields['c_status'] == "EM_ANDAMENTO" ){
                                    $status = '<td class="text-center alert-warning" title="EM ANDAMENTO"><span class="fas fa-tags" ></span></td>';
                                    $escondido_view = "";
                                    $escondido_edit = "escondido";
                                }
                                else if ( $dados->fields['c_status'] == "ABERTO" ){
                                    $status = '<td class="text-center alert-info" title="ABERTO"><span class="fas fa-lock-open" ></span></td>';
                                    $escondido_view = "";
                                    $escondido_edit = "escondido";
                                }
                                else if ( $dados->fields['c_status'] == "ENCERRADO" ){
                                    $status = '<td class="text-center alert-success" title="ENCERRADO"><span class="fas fa-lock" ></span></td>';
                                    $escondido_view = "escondido";
                                    $escondido_edit = "";
                                }
                                
                                ?>
                                <tr>                                    
                                    <?php print $status; ?>
                                    <td class="text-center">#<?= $dados->fields['chamados_id']      ?></td>                                    
                                    <td class="text-center"><?= $dados->fields['user_nome']         ?></td>                                    
                                    <td class="text-center"><?= $dados->fields['user_nome_r']       ?></td>                                    
                                    <td class="text-center"><?= $dados->fields['c_assunto']         ?></td>                                    
                                    <td class="text-center"><?= $dados->fields['c_tipo']            ?></td>                                    
                                    <td class="text-center"><?= $dados->fields['c_data_abertura']   ?></td>                                    
                                    <td class="text-center"><?= $dados->fields['c_data_fechamento'] ?></td>
                                    <td class="text-center">
                                        <button class="btn-success <?= $escondido_edit ?>" onclick="movPage('adm_chamados','view','<?= $dados->fields['chamados_id'] ?>', 'movimentacao','','')" title="Clique para visualizar mais.">
                                            <span class="fas fa-plus openDetalhes"></span>
                                        </button>
                                        <button class=" btn-info <?= $escondido_view ?>" onclick="movPage('adm_chamados','edit','<?= $dados->fields['chamados_id'] ?>', 'movimentacao','','')">
                                            <span class="far fa-paper-plane"></span>
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn-default btnImprimir" title="Clique para visualizar mais." data-id="<?= $dados->fields['chamados_id'] ?>">
                                            <span class="fas fa-print openDetalhes"></span>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                $dados->MoveNext();
                            }                            
                        ?>
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
   
  <!-- /.card -->
  <?php } else {

    if ( $_SESSION['id'] != "" ){
        #Monta SQL para busca
        $sql = "SELECT  chamados_id
                    , c_user_id
                    , c_prioridade
                    , c_status
                    , c_tipo
                    , c_departamento
                    , c_responsavel_id
                    , c_assunto
                    , c_servico
                    , c_anexo
                    , u.user_nome
                    , u.user_nome AS user_nome_r
                    , datahorabrasil(c_data_abertura)   AS c_data_abertura
                    , datahorabrasil(c_data_fechamento) AS c_data_fechamento                    
                FROM    t_chamados c 
                INNER JOIN t_user u ON ( u.user_id = c.c_user_id )
                INNER JOIN t_user r ON ( r.user_id = c.c_responsavel_id )
                WHERE    chamados_id = '{$_SESSION['id']}'
                ORDER BY chamados_id;";
       
        $sqlMov = "
            SELECT  movimentacao_id
                , m_chamados_id
                , m_user_id               
                , m_descricao
                , m_visualizado
                , user_nome
                , datahorabrasil(m_data_hora) AS m_data_hora
            FROM    t_chamados_mov m 
            INNER JOIN t_user u ON ( u.user_id = m.m_user_id )
            WHERE m_chamados_id = {$_SESSION['id']}
            ORDER BY movimentacao_id;";
        
        $sqlLog = "SELECT datahorabrasil(l_data_hora) AS data_hora FROM t_chamados_log WHERE l_chamados_id = {$_SESSION['id']} ORDER BY 1 DESC LIMIT 1;";
                
        #Resgata os valores do Banco
        $dados = $bd->Execute($sql);
        $mov   = $bd->Execute($sqlMov);
        $log   = $bd->Execute($sqlLog);
        
        $disabled  = in_array($_SESSION['op'],array("view")) ? "disabled" : "";
        $escondido = in_array($_SESSION['op'],array("view")) ? "escondido" : ""; 
        
//        print "<pre>"; print_r($_SESSION);
//        exit;
    }
            
        #Validamos as funcionalidades          
        if      ( $_SESSION["op"] == "view"   ){ $description = "Visualização dos "; $disabled = "disabled"; }
        else if ( $_SESSION["op"] == "insert" ){ $description = "Enviar uma Solicitação "; }
        else if ( $_SESSION["op"] == "delete" ){ $description = "Deletar esses ";  $disabled = "disabled"; }
        else if ( $_SESSION["op"] == "edit"   ){ $description = "Editar os "; }
    ?>

    <div class="card body-view">
        <div class="card-header escondido">          
          <div class="row">
                <div class="col-sm-12">           
                    <label><?= $description ?></label>
               </div>
          </div>
        </div>
        <div class="card-body">
            <form action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainAdmChamados.php" method="post" id="frmDados">                
                <div class="tab-content">
                    <div class="tab-pane active margin-top-15" id="empresa_geral" role="tabpanel">
                        <div class="row">
                            <?php
                            if ( $_SESSION["op"] == "insert" ){?>
                            <div class="row col-sm-8"> 
                                <div  class="col-sm-6 form-group">
                                    <label for="chamado_tipo" >Tipo:</label>
                                    <select class="form-control requeri" id="chamado_tipo" name="chamado_tipo">
                                        <option value="CHAMADO"   >1 - Chamado</option>
                                        <option value="REQUISICAO">2 - Requisição</option>
                                    </select>
                                </div>                           
                                <div  class="col-sm-6 form-group">
                                    <label for="chamado_departamento" >Para o Departamento de :</label>
                                    <select class="form-control requeri" id="chamado_departamento" name="chamado_departamento">
                                    <?php
                                        $dep = $bd->Execute("SELECT dpto_id , dpto_nome , dpto_descricao FROM t_departamentos td ORDER BY 1;");
                                        while(!$dep->EOF){
                                            print '<option value="'.$dep->fields['dpto_id'].'">'.$dep->fields['dpto_id'].' - '.$dep->fields['dpto_nome'].'</option>';
                                            $dep->MoveNext();
                                        }
                                    ?>    
                                    </select>
                                </div>                           
                                <div  class="col-sm-12  mb-2">
                                    <label for="chamado_responsavel">Responsável:</label>
                                    <input type="text" class="form-control requeri " id="chamado_responsavel" name="chamado_responsavel"/>
                                    <input type="hidden" class="form-control requeri " id="c_reponsavel_id" name="c_reponsavel_id"/>
                                </div>
                                <div  class="col-sm-12  mb-2">
                                    <label for="chamado_assunto">Assunto:</label>
                                    <input type="text" class="form-control requeri " id="chamado_assunto" name="chamado_assunto"/>
                                </div>
                                <div  class="col-sm-12  mb-2">
                                    <label for="chamado_descricao">Descrição:</label>
                                    <textarea rows="6" class="form-control requeri unique" id="chamado_descricao" name="chamado_descricao"></textarea>
                                </div>
                                <div  class="col-sm-12 form-group">
                                    <label for="chamado_servico" >Serviço :</label>
                                    <select class="form-control requeri" id="chamado_servico" name="chamado_servico">
                                    <?php
                                        $serv = $bd->Execute("SELECT t_chamados_servicos_id,t_servico,t_descricao FROM t_chamados_servicos tcs ORDER BY 1;");
                                        while(!$serv->EOF){
                                            print '<option value="'.$serv->fields['t_chamados_servicos_id'].'">'.$serv->fields['t_chamados_servicos_id'].' - '.$serv->fields['t_servico'].'</option>';
                                            $serv->MoveNext();
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>     
                            <?php } else { ?>
                            <div class="col-sm-8"> 
                                <?php while(!$mov->EOF){ 
                                    $visu = $mov->fields['m_visualizado'] == "S" ? "alert-success" : "";    
                                ?>
                                <div class="col-sm-12">     
                                    <div class="form-group <?= $visu ?>">                    
                                    <div  class="col-sm-12 form-group <?= $visu ?>">
                                        <img src="dist/img/user_<?= $mov->fields['m_user_id']?>.jpg" class="img-circle elevation-2" alt="No Image" style="width: 60px; height: 60px;">
                                        <?= $mov->fields['user_nome']?> - <b><?= $mov->fields['m_data_hora'] ?></b>
                                    </div>
                                    <div  class="col-sm-12 <?= $visu ?>">
                                        <?= $mov->fields['m_descricao'] ?>
                                    </div>  
                                    </div>  
                                </div>
                                <div class="col-sm-12"> <hr> </div>
                                <?php $mov->MoveNext();} ?>                                 
                                <div class="col-sm-12 <?= $escondido ?>">                         
                                    <div  class="col-sm-6 form-group">
                                         <img src="dist/img/user_<?= $_SESSION['user_id'] ?>.jpg" class="img-circle elevation-2" alt="No Image" style="width: 40px; height: 40px;">
                                         <button type="button" class="btn btn-success " id="btnGravaConversa" ><!-- onclick="movPage('adm_chamados','','', 'gravaConversa','','')">-->
                                            <span class="fas fa-retweet"></span>
                                            Enviar
                                        </button> 
                                     </div>
                                    <div  class="col-sm-12 form-group">
                                         <textarea rows="2" class="form-control" id="adicao_conversa" name="adicao_conversa" placeholder="Adicionar à conversa"></textarea>
                                     </div>
                                </div>  
                            </div>                            
                            <div class="row col-sm-4 backgroundDescricao"> 
                                <div class="col-sm-4"> 
                                    <div  class="col-sm-12 form-group mb-2"> <label>Solicitante           </label> </div>
                                    <div  class="col-sm-12 form-group mb-2"> <label>Criado                </label> </div>
                                    <div  class="col-sm-12 form-group mb-2"> <label>Última atividade      </label> </div>
                                </div>                                                                                  
                                <div class="col-sm-8"> 
                                    <div  class="col-sm-12 form-group"> <?= $dados->fields['user_nome']         ?> </div>
                                    <div  class="col-sm-12 form-group"> <?= $dados->fields['c_data_abertura']   ?> </div>
                                    <div  class="col-sm-12 form-group"> <?= $log->fields['data_hora'] ?> </div>
                                </div>                            
                                <div class="col-sm-12 form-group"> <hr> </div>                                           
                                <div class="col-sm-4"> 
                                    <div  class="col-sm-12 form-group mb-2"> <label>Atribuído a           </label> </div>
                                    <div  class="col-sm-12 form-group mb-2"> <label>ID                    </label> </div>
                                    <div  class="col-sm-12 form-group mb-2"> <label>Status                </label> </div>
                                    <div  class="col-sm-12 form-group mb-2"> <label>Prioridade            </label> </div>
                                    <div  class="col-sm-12 form-group mb-2"> <label>Serviços              </label> </div>
                                </div>
                                <div class="col-sm-8"> 
                                    <div  class="col-sm-12 form-group"> <?= $dados->fields['user_nome_r']       ?> </div>
                                    <div  class="col-sm-12 form-group"> #<?= $dados->fields['chamados_id']      ?> </div>                                    
                                    <div  class="col-sm-12 form-group">
                                        <select class="requeri" id="chamado_status" name="chamado_status" <?= $disabled ?>>
                                            <option value="ABERTO"       <?=($dados->fields['c_status'] == "ABERTO"       ? "selected" : "")?>> 1 - Aberto         </option>
                                            <option value="EM_ANDAMENTO" <?=($dados->fields['c_status'] == "EM_ANDAMENTO" ? "selected" : "")?>> 2 - Em Andamento   </option>
                                            <option value="ENCERRADO"    <?=($dados->fields['c_status'] == "ENCERRADO"    ? "selected" : "")?>> 3 - Encerrado      </option>
                                        </select>
                                    </div>
                                    <div  class="col-sm-12 form-group"> 
                                        <select class="requeri" id="chamado_prioridade" name="chamado_prioridade" <?= $disabled ?>>
                                            <option value="BAIXA"    <?=($dados->fields['c_prioridade'] == "BAIXA"    ? "selected" : "")?>> 1 - Baixa     </option>
                                            <option value="MODERADA" <?=($dados->fields['c_prioridade'] == "MODERADA" ? "selected" : "")?>> 2 - Moderada  </option>
                                            <option value="ALTA"     <?=($dados->fields['c_prioridade'] == "ALTA"     ? "selected" : "")?>> 3 - Alta      </option>
                                        </select>
                                    </div>
                                    <div  class="col-sm-12 form-group"> <?= $dados->fields['c_servico']         ?> </div>
                                </div>                         
                                <div class="col-sm-12 form-group"> <hr> </div>
                                <div class="col-sm-4"> 
                                    <div class="col-sm-12 form-group mb-2"> 
                                        <label> Anexos </label> 
                                        <?php
                                            $anexos = $bd->Execute("SELECT anexos_id , a_nome , a_caminho FROM t_chamados_anexos tca WHERE chamados_id = {$_SESSION['id']} ORDER BY 1;");
                                            while(!$anexos->EOF){
                                                print '<a href="'. $_SERVER["localhost"].'/mmflow/dist/arq_chamados/'.$anexos->fields['a_nome'].'" target="_blank" title="'.$anexos->fields['a_nome'].'">
                                                        <span class="icone-pdf"></span> <b>'.$anexos->fields['a_nome'].'</b>
                                                       </a>';
                                                $anexos->MoveNext();
                                            }
                                        ?>
                                    </div>                                
                                </div>
                            </div>  
                            <?php } ?>                                       
                        </div>
                    </div>                
                </div>
            </form>
            <div class="col-sm-8 form-group <?= $escondido ?>">  
                <form method="POST" action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainAdmChamados.php" id="fileUpload" name="fileUpload" enctype="multipart/form-data">
                    <input type="hidden" id="op" name="op" value="upload_arquivo" >                                                            
                    <input type="file" id="arquivo" name="arquivo" class="inputfile inputfile-1" style="width:100%;" >                                                            
                    <label for="arquivo" class="fix-center btn btn-warning text-center" style="width:400px;">                                
                        <span class="glyphicon glyphicon-arrow-up margin-right-10"></span>                        
                        <span class="nome-arquivo" id="nome-arquivo" name="nome-arquivo">Adicione um anexo</span>
                    </label>
                    <button type="button" id="btnSubmit" name="btnSubmit" class="escondido"> BTN </button>
                </form>
            </div>   
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
                  <button type="button" class="btn btn-warning" id="btnVoltar" onclick="movPage('adm_chamados','','', 'movimentacao','','')">
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
<?php include_once './_import/modals.php'; ?>
<!--<script type="text/javascript" charset="utf8" src="DataTables/datatables.min.js"></script>-->
<!--<script type="text/javascript" charset="utf8" src="../../DataTables/datatables.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
$(document).ready(function($){
    
    /* aplica DataTable na tabela. */
//    new DataTable('.table',{
//        paging: false,
//        scrollY: 500
//    });

    $("#btnGravaConversa").on("click",function(){
        $.ajax({
            url: $("#frmDados").prop("action"),
            method: "post",
            dataType: "text",
            data: {
                op : "mov",
                adicao_conversa : $("#adicao_conversa").val()
            },
            error: function () {
                $("#mensagem_erro").html("Ocorreu um erro imprevisto ao enviar os dados para o banco. Por favor, contate o administrador do sistema.");
                $("#modal_erro").modal("show");
            },
            success: function (retorno) {
                if (retorno == "OK") {
                    location.reload();
                } else {
                    $("#mensagem_erro").html("Não foi possível completar a operação, tente novamente!<br/><br/>" + retorno.mensagem);
                    $("#modal_erro").modal("show");
                }
            }
        });
        return false;
    });
    
    $(".btnImprimir").on("click",function(){        
        var parametros = {tipo: "pdf",id: $(this).data("id")};
        btnImprimir("report_chamados.php", JSON.stringify(parametros));
    });
    
    $("#chamado_responsavel").autocomplete({                        
        source: function( request, response){
            $.ajax({
                url: "<?= $_SERVER["localhost"] ?>/mmflow/_man/search/_searchData.php",
                type: "post",
                dataType: "json",
                data: { 
                    descricao: request.term,
                    table: "t_user",
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
            $('#c_reponsavel_id').val(ui.item.id);
        },
        open: function() {$(this).removeClass("ui-corner-all").addClass("ui-corner-top");},
        close: function() {$(this).removeClass("ui-corner-top").addClass("ui-corner-all");}
    });
    
    var form;
    //Mostra o nome do arquivo escolhido para o usuário
    $("#arquivo").on("change", function(e){           
        //Obtem nome do arquivo
        var nomeArquivo = "";
        if(e.target.value) nomeArquivo = e.target.value.split("\\").pop();

        //Mostra o nome do arquivo se algo for selecionado
        if(nomeArquivo){
            $("label[for='arquivo']").find(".nome-arquivo").html(nomeArquivo);
            $("#btnProsseguir").removeClass("disabled");
        }
        else{
            $("label[for='arquivo']").find(".nome-arquivo").html("Escolha um arquivo...");
            $("#btnProsseguir").addClass("disabled");
        }        
        
        console.log( "sessionStorage" );
        console.log( sessionStorage );
        
        /* Monta o formulario e manda pra manutenção */        
        form = new FormData();
        form.append('fileUpload', event.target.files[0]); // para apenas 1 arquivo
        form.append('fileUpload',$("#fileUpload").serialize());
        clickButton(form);    
    });
});
function clickButton(form){
    $.ajax({
        url: $("#frmDados").prop("action"), // Url do lado server que vai receber o arquivo
        data: form,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (retorno) {
            if( "<?= $_SESSION['op'] != 'insert' ?>" ){
            if (retorno == "OK") {
                location.reload();
            } else {
                $("#mensagem_erro").html("Não foi possível completar a operação, tente novamente!<br/><br/>" + retorno.mensagem);
                $("#modal_erro").modal("show");
            }
        }
        }
    });
}
</script>
<!-- /.content-wrapper -->