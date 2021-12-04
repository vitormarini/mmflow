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
      $title = "ERP  SYS - Tema";
  }
?>
    <title> <?= $title ?></title>
</head>
<style>
    .escondido{display:none;}
</style>
<!-- CSS -->
<link rel="stylesheet" href="build/scss/jquery-ui-1.11.4.min.css">

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

  <!-- Preloader -->
<!--  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/linofavic.png" alt="ERP-Gestao" height="60" width="60">
  </div>-->

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
      <!-- Navbar Search -->
      <!--<li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->

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
      <!--<img src="dist/img/linofavic.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
      <span class="brand-text font-weight-light">SYS - Tema</span>
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

      <!-- SidebarSearch Form -->
<!--      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>-->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
<!--          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./menu_sys.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>
          </li>-->
          <li class="nav-header">Navegação</li>
<!--          <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendar
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Agenda
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/kanban.html" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Kanban Board
              </p>
            </a>
          </li>          -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Menus
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <!-- Inserir os menus -->
            <ul class="nav nav-treeview">
                <?php while ( !$dadosMenu->EOF ){
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
              <ul class="nav nav-treeview text-left">
                  <?php while ( !$sm_cadastro->EOF ){
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
              <ul class="nav nav-treeview text-left">
                  <?php while ( !$sm_movimento->EOF ){
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
    <strong>Copyright &copy; 2019-2021 <a href="https://github.com/vitormarini">SYS Tema - ERP</a>.</strong>
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
            validateSave('index.php');
        });

        $("#btnEmpresa").on("click",function(){
            $("#empresa_modal").val( $(this).data("empresa") );
            $("#modal_empresas").modal("show");
        });

        $("#btnContinuar").on("click",function() {
            selecionaEmpresa("troca_empresa");
        });

    });

</script>
</body>
</html>
