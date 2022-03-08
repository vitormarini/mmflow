<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?php
    session_start();
    include_once './_import/link_title.php';
    include './_man/_aux.php';
    include_once './_conection/_bd.php';
    include_once './_conection/_verifyLogin.php';

    $dadosMenu = $bd->Execute($sql= "
        SELECT  menu_id, menu_descricao, menu_icon, menu_url
        FROM    t_menu
        WHERE   menu_id IN (SELECT id_menu FROM user_permission WHERE id_user = {$_SESSION['user_id']} GROUP BY 1)
        ORDER BY 2;");

    $sm_cadastro = $bd->Execute($sql = "
       SELECT menu_sub_id, menu_id, menu_submenu_categoria, menu_submenu_descricao, menu_submenu_url, menu_submenu_icon
        FROM t_menu_sub LIMIT 0;");

    $sm_report = $bd->Execute($sql = "
        SELECT menu_sub_id, menu_id, menu_submenu_categoria, menu_submenu_descricao, menu_submenu_url, menu_submenu_icon
        FROM t_menu_sub LIMIT 0;");

    $sm_movimento = $bd->Execute($sql = "
        SELECT menu_sub_id, menu_id, menu_submenu_categoria, menu_submenu_descricao, menu_submenu_url, menu_submenu_icon
        FROM t_menu_sub LIMIT 0;");
    
    $chamado = $bd->Execute("
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
            , databrasil(c_data_abertura::date)   AS c_data_abertura                        
        FROM t_chamados c
        INNER JOIN t_user u ON ( u.user_id = c.c_user_id )
        WHERE c_responsavel_id = 3 
            AND c_ciente != 'S';");    
     
                
    while(!$chamado->EOF){
        $tr_chamados .= '\n\
            <tr>\n\
                <td class="text-center">#'. $chamado->fields["chamados_id"]     .'</td>\n\
                <td class="text-left  ">'. $chamado->fields["user_nome"]        .'</td>\n\
                <td class="text-left"  >'. $chamado->fields["c_assunto"]        .'</td>\n\
                <td class="text-center">'. $chamado->fields["c_tipo"]           .'</td>\n\
                <td class="text-center">'. $chamado->fields["c_data_abertura"]  .'</td>\n\
                <td class="text-center"><button class="btn-info btnCiencia" title="Dar ciência."><span class="far fa-paper-plane"></span></button></td>\n\
            </tr>';
        $chamado->MoveNext();
    }

  if ( $_SESSION['menu_atual'] != "" ){

    $menuAtual = $bd->Execute("
        SELECT  menu_id, menu_descricao, menu_icon, menu_url
        FROM    t_menu WHERE menu_id = {$_SESSION['menu_atual']} ORDER BY 2;");
    $title = "> ".$menuAtual->fields['menu_descricao'];

    $sm_cadastro = $bd->Execute($sql = "
        SELECT  menu_sub_id, menu_id, menu_submenu_categoria, menu_submenu_descricao, menu_submenu_url , menu_submenu_icon
        FROM    t_menu_sub
        WHERE   menu_id = {$_SESSION['menu_atual']}
            AND menu_sub_id IN ( SELECT id_item FROM user_permission WHERE id_user = {$_SESSION['user_id']} GROUP BY 1 )
            AND menu_submenu_categoria = 'CADASTROS'
        ORDER BY 4;");

    $sm_movimento = $bd->Execute($sql = "
        SELECT  menu_sub_id, menu_id, menu_submenu_categoria, menu_submenu_descricao, menu_submenu_url , menu_submenu_icon
        FROM    t_menu_sub
        WHERE   menu_id = {$_SESSION['menu_atual']}
            AND menu_sub_id IN ( SELECT id_item FROM user_permission WHERE id_user = {$_SESSION['user_id']} GROUP BY 1 )
            AND menu_submenu_categoria = 'MOVIMENTO'
        ORDER BY 4;");

    $sm_report = $bd->Execute($sql = "
        SELECT  menu_sub_id, menu_id, menu_submenu_categoria, menu_submenu_descricao, menu_submenu_url , menu_submenu_icon
        FROM    t_menu_sub
        WHERE   menu_id = {$_SESSION['menu_atual']}
            AND menu_sub_id IN ( SELECT id_item FROM user_permission WHERE id_user = {$_SESSION['user_id']} GROUP BY 1 )
            AND menu_submenu_categoria = 'RELATORIO'
        ORDER BY 4;");

    $local = $bd->Execute("
        SELECT  t_menu.menu_descricao AS menu
            ,	CASE
                    WHEN menu_submenu_categoria = 'CADASTROS' THEN 'Cadastros'
                    WHEN menu_submenu_descricao = 'RELATORIO' THEN 'Relatórios'
                    WHEN menu_submenu_categoria = 'MOVIMENTO' THEN 'Movimentação'
                END AS categoria
            ,	t_menu_sub.menu_submenu_descricao AS sub
        FROM t_menu_sub
        INNER JOIN t_menu ON ( t_menu.menu_id = t_menu_sub.menu_id )
        WHERE menu_submenu_url  = '{$_SESSION['tela_atual']}';");
  }else{
      $title = "Flow";
  }
?>
    <title> <?= $title ?></title>
</head>
<style>
    .escondido{display:none;}
</style>
<!-- CSS -->
<link rel="stylesheet" href="build/scss/jquery-ui-1.11.4.min.css">
<!--<link rel="stylesheet" href="./DataTables/datatables.min.css"/>-->

<script src="./plugins/jquery/jquery-1.12.1.min.js"></script>
<script src="./plugins/jquery/jquery-ui-1.11.4.min.js"></script>
<script src="./plugins/jquery/jquery.ui.datepicker-pt-BR.js"></script>
<script src="./plugins/jquery/jquery.maskedinput.min.js"></script>
<script src="./plugins/jquery/jquery.price_format.1.8.min.js"></script>
<script src="./plugins/jquery/jquery.limit-1.2.source.js"></script>
<script src="./plugins/jquery/jquery.scrollbar.min.js"></script>
<!-- Scripts de validação de formulários -->
<script src="./plugins/jquery/jquery-validate-1.15.0.min.js"></script>
<script src="./plugins/jquery/jquery-validate-additional-methods-1.15.0.min.js"></script>
<script src="./plugins/jquery/jquery-validate-messages-ptbr-1.15.0.min.js"></script>
<script src="./plugins/jquery/jquery-1.9.1.js"></script>
<script src="./plugins/jquery/jquery.min.js" type="text/javascript"></script>
<script src="./plugins/jquery/jquery.mask.min.js" type="text/javascript"></script>
<script src="./plugins/jquery/jquery.mask.min_1.js" type="text/javascript"></script>
<script src="./plugins/jquery/jquery.mask.min_2.js" type="text/javascript"></script>
<script src="./plugins/ajax/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" src="./plugins/bootstrap/js/bootstrap.js"></script>

<body class="hold-transition sidebar-mini layout-fixed">
    <style>
        .requi {
            color: #bf2718;
        }
    </style>
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <button class="btn" onclick="movPage('VAZIO','','', 'movimentacao')">
              <i class="fas fa-home"></i>
               Home
          </button>
        <!--<a onclick="movPage('VAZIO','','', 'movimentacao')" class="nav-link">Home</a>-->
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
        
    </ul>    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item alert-danger">
            <a class="btn btn-danger" data-widget="navbar-search" role="button" id="btnEmpresa" name="btnEmpresa" data-empresa="<?= $_SESSION['empresa'] ?>">
                <?= $_SESSION['empresa_desc'] ?>
            </a>        
        </li>
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <div class="info">
            <button type="button" class="btn btn-danger" title="Clique para sair do Programa" onclick="exit()">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </div>
    </ul>
  </nav>  
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="menu_sys.php" class="brand-link">      
      <span class="brand-text font-weight-light"><b>Flow</b> Gestão</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="dist/img/user_<?=$_SESSION['user_id']?>.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $_SESSION['user_nickname'] ?></a>
            </div>
        </div>
      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">Navegação</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menus
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                  <!-- Inserir os menus -->
                  <?php $exibeNav = 'nav nav-treeview'; while ( !$dadosMenu->EOF ){  $exibeNav = $_SESSION['menu_atual'] == $dadosMenu->fields['menu_id'] ? "" : $exibeNav;  $dadosMenu->MoveNext(); } ?>
                    <ul class="<?= $exibeNav ?>">
                        <?php $dadosMenu->MoveFirst();while ( !$dadosMenu->EOF ){
                            $selectMenu = $_SESSION['menu_atual'] == $dadosMenu->fields['menu_id'] ? "btn btn-info" : "";
                        ?>
                        <li class="nav-item">
                            <button class="<?= $selectMenu ?> text-left " onclick="movPage('VAZIO','','', 'movim_menu', '<?= $dadosMenu->fields['menu_id'] ?>', '')" style="width: 100%; height: 30px; padding-bottom: 20px;">
                                <label class="text-center">
                                  <span class="fas <?php print $dadosMenu->fields['menu_icon'] ?> nav-icon"></span>
                                          <?= $dadosMenu->fields['menu_descricao'] ?>
                              </label>
                            </button>
                        </li>
                      <?php  $dadosMenu->MoveNext(); } ?>
                    </ul>
                </li>
              <?php
              if ( $sm_cadastro->RecordCount() > 0 ){ ?>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-edit"></i>
                    <p>
                      CADASTROS
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <!-- Inserir os menus -->
                <?php $exibeNav = 'nav nav-treeview';  while ( !$sm_cadastro->EOF ){  $exibeNav = $_SESSION['tela_atual'] == $sm_cadastro->fields['menu_submenu_url'] ? "" : $exibeNav ;  $sm_cadastro->MoveNext(); } ?>                
                <ul class="nav-tree<?= $exibeNav ?> text-left">
                      <?php  $sm_cadastro->MoveFirst();
                       while ( !$sm_cadastro->EOF ){
                          $selectSubMenu = $_SESSION['tela_atual'] == $sm_cadastro->fields['menu_submenu_url'] ? "btn btn-info" : ""; ?>


                      <li class="nav-item text-left">
                          <button class="<?= $selectSubMenu ?> text-left" onclick="movPage('<?= $sm_cadastro->fields['menu_submenu_url'] ?>','','', 'movimentacao', '<?= $sm_cadastro->fields['menu_id'] ?>', '<?= $sm_cadastro->fields['menu_sub_id'] ?>')" style="width: 100%; height: 30px; padding-bottom: 20px;">
                              <label class="text-left">
                                <span class="fas <?php print $sm_cadastro->fields['menu_submenu_icon'] ?> nav-icon"></span>
                                        <?= $sm_cadastro->fields['menu_submenu_descricao'] ?>
                            </label>
                          </button>
                      </li>
                    <?php  $sm_cadastro->MoveNext(); } ?>
                  </ul>
                </li>
                <?php
                }
              ?>
              <?php
              if ( $sm_movimento->RecordCount() > 0 ){ ?>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      MOVIMENTAÇÃO
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <!-- Inserir os menus -->
                    <?php $exibeNav = 'nav nav-treeview';  while ( !$sm_movimento->EOF ){  $exibeNav = $_SESSION['tela_atual'] == $sm_movimento->fields['menu_submenu_url'] ? "" : $exibeNav ;  $sm_movimento->MoveNext(); } ?>
                    <ul class="<?= $exibeNav ?>  text-right">
                      <?php  $sm_movimento->MoveFirst();
                      while ( !$sm_movimento->EOF ){
                          $selectSubMenu = $_SESSION['tela_atual'] == $sm_movimento->fields['menu_submenu_url'] ? "btn btn-info" : ""; ?>


                      <li class="nav-item text-left">
                          <button class="<?= $selectSubMenu ?> text-left" onclick="movPage('<?= $sm_movimento->fields['menu_submenu_url'] ?>','','', 'movimentacao', '<?= $sm_movimento->fields['menu_id'] ?>', '<?= $sm_movimento->fields['menu_sub_id'] ?>')" style="width: 100%; height: 30px; padding-bottom: 20px;">
                              <label class="text-left">
                                <span class="fas <?php print $sm_movimento->fields['menu_submenu_icon'] ?> nav-icon"></span>
                                        <?= $sm_movimento->fields['menu_submenu_descricao'] ?>
                            </label>
                          </button>
                      </li>
                    <?php  $sm_movimento->MoveNext(); } ?>
                  </ul>
                </li>
                <?php
                }
              ?>
              <?php
              if ( $sm_report->RecordCount() > 0 ){ ?>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-bars"></i>
                    <p>
                      RELATÓRIOS
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <!-- Inserir os menus -->
                  <ul class="nav nav-treeview text-left">
                      <?php while ( !$sm_report->EOF ){
                          $selectSubMenu = $_SESSION['tela_atual'] == $sm_report->fields['menu_submenu_url'] ? "btn btn-info" : ""; ?>


                      <li class="nav-item text-left">
                          <button class="<?= $selectSubMenu ?> text-left" onclick="movPage('<?= $sm_report->fields['menu_submenu_url'] ?>','','', 'movimentacao', '<?= $sm_report->fields['menu_id'] ?>', '<?= $sm_report->fields['menu_sub_id'] ?>')" style="width: 100%; height: 30px; padding-bottom: 20px;">
                              <label class="text-left">
                                <span class="fas <?php print $sm_report->fields['menu_submenu_icon'] ?> nav-icon"></span>
                                        <?= $sm_report->fields['menu_submenu_descricao'] ?>
                            </label>
                          </button>
                      </li>
                    <?php  $sm_report->MoveNext(); } ?>
                  </ul>
                </li>
                <?php
                }
              ?>
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!-- INPUTS DE VERIFICAÇÃO NO JS -->
        <input type="text" id="qtde_chamados" name="qtde_chamados" value="<?= $chamado->RecordCount(); ?>" >
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  <h4><?= $local->fields['sub'] ?></h4>
                </div>
                <?php if(!empty($local->fields['sub'])){ ?>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="menu_sys.php">Home</a></li>
                        <li class="breadcrumb-item active"> <b><?= $local->fields['menu']?></b> > <i><?=$local->fields['categoria']?></i> > <u><?= $local->fields['sub'] ?></u></li>
                    </ol>
                </div>
                <?php } ?>
            </div>
        </div><!-- /.container-fluid -->
    </section>
  <?php

  if ( $_SESSION['tela_atual'] != "VAZIO" ){
    if (file_exists('./pages/_view/'.$_SESSION['tela_atual'].'.php') ){
        include_once './pages/_view/'.$_SESSION['tela_atual'].'.php';
    }
    else if (file_exists('./pages/_report/'.$_SESSION['tela_atual'].'.php') ){
        include_once './pages/_report/'.$_SESSION['tela_atual'].'.php';
    }
  }
  ?>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer fixed-bottom escondido">
    <strong>Copyright &copy; 2019-2021 <a href="https://github.com/vitormarini"><b>Flow</b> - ERP</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.<?php print date("m") ?>.01
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php include_once './_import/scripts.php'; ?>
<?php include_once './_import/modals.php'; ?>

<script src="<?=$_SERVER['localhost']?>/mmflow/_man/functions.js"></script>
<script type="text/javascript" charset="utf8" src="DataTables/datatables.min.js"></script>
<script type="text/javascript">
    function movPage(destino, op, id, tipo, menu, submenu){
      $.ajax({
          url     : './_man/movePages.php',
          method  : "post",
          dataType: "text",
          data    : {
              xDestino: destino,
              xOp :op,
              xId: id,
              tipo: tipo,
              xMenu: menu,
              xSubmenu: submenu,
              xBuscas: $(".buscas").serialize()
          },
          success: function(retorno){
              location.reload();
          }
      });
    }
    $(document).ready( function(){

        function atualizaContador() {
            $.ajax({
                url         : "./_conection/_conectado.php",
                dataType    : "json",
                success     : function ( retorno ) {
                    if ( retorno.status == "ERRO" ) {
                        alert( retorno.mensagem );
                    }
                }
            });
        }
        window.setInterval( atualizaContador, 600000 );

        //Função para registrar evendo no banco de dados.
        $("#btnSalvar").on("click", function(){
            $(this).prop("disabled",true);
            validateSave('index.php');
        });

        $("#btnEmpresa").on("click",function(){
            var cnpj = $(this).text().trim().split(" - ")[0];
            retornaEmpresas(cnpj);
            
            $("#empresa_modal").val( $(this).data("empresa") );
            $("#modal_empresas").modal("show");
        });

        $("#btnContinuar").on("click",function() {
            selecionaEmpresa("troca_empresa");
        });
        
        if( parseInt($("#qtde_chamados").val()) > 0 ){
            var tr = '<?= $tr_chamados ?>';
            $(".modal-title").html("CHAMADOS");
            $(".modal-body").append('\
            <div class="col-lg-12">\n\
                <table class="table table-bordered">\n\
                    <thead>\n\
                        <tr>\n\
                            <th class="text-center" width="05%"> ID             </th>\n\
                            <th class="text-center" width="20%"> Usuário        </th>\n\
                            <th class="text-center" width="40%"> Detalhe        </th>\n\
                            <th class="text-center" width="10%"> Tipo           </th>\n\
                            <th class="text-center" width="10%"> Dt Abertura    </th>\n\
                            <th class="text-center" width="10%"> Opção          </th>\n\
                        <tr>\n\
                    </thead>\n\
                    <tbody>'+ tr +'</tbody>\n\
                </table>\n\
            </div>');
            $("#modal_geral").modal("show");
        }
        
        $(".btnCiencia").on("click",function(){
            var id = $(this).closest("tr").find("td:eq(0)").text().replace("#","").trim();            
            var parametros = {op: "ciencia",id: id};
            
            btnSalvar("mainAdmChamados.php",parametros,"chamados");
        });
    });


</script>
</body>
</html>