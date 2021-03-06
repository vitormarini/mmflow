<?php
/* Descrição: Back-End adm_empresas.php
 * Author: Vitor Hugo Marini
 * Data: 16/02/2022
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';

session_start();

$op         = $_SESSION['op'];          //Ação
$p          = $_SESSION['p'];           //Página da Busca
$r          = $_SESSION['tela_atual'];  //Tela Atual
$b          = $_SESSION['buscas'];      //Filtros de buscas
$id         = $_SESSION['id'];          //Filtros de buscas
$user_id    = $_SESSION['user_id'];     //usuário
$dados      = $_POST;
$retorno    = "ERRO";
$files_arq  = "";

if( !empty($_FILES) ){
    $_SESSION['files'] = $_FILES ;
    $retorno    = "OK";
}

#Validando os dados Cadastrais
$c_tipo         = $dados['chamado_tipo'];
$c_departamento = $dados['chamado_departamento'];
$c_responsavel  = trim($dados['c_reponsavel_id']);
$c_assunto      = trim($dados['chamado_assunto']);
$c_servico      = trim($dados['chamado_servico']);
$m_descricao    = trim($dados['chamado_descricao']);
$data_atual     = date("Y-m-d H:s:i");
$empresa        = $_SESSION['empresa'];

#INSERT
if ( $op == "insert" ){

    $sql = "
    INSERT INTO t_chamados (
          c_user_id             , c_data_abertura       , c_status          , c_tipo
        , c_departamento        , c_responsavel_id      , c_assunto         , c_servico   
        , c_ciente              , empresa_id
    )VALUES(
          {$user_id}            , '{$data_atual}'       , 'ABERTO'          , '{$c_tipo}'
        , '{$c_departamento}'   , '{$c_responsavel}'    , '{$c_assunto}'    , '{$c_servico}'
        , 'N'                   , '{$empresa}'
    );";                

    if ( $bd->Execute(replaceEmptyFields($sql)) ){
        $id = $bd->Insert_ID();
        
        $l_query .= $sql;
        
        $sqlMov = "
        INSERT INTO t_chamados_mov (
              m_chamados_id     , m_user_id         , m_data_hora           , m_descricao
        )VALUES(            
              {$id}             , {$user_id}        , '{$data_atual}'       , '{$m_descricao}'  
        );";
        
        $l_query .= $sqlMov;      
        $bd->Execute(replaceEmptyFields($sqlMov));
    }
    anexo($_SESSION['files']['fileUpload'],$id,$user_id);
    functionLog($id, $data_atual, "INSERT", $l_query, $user_id);
    
    $session_op = $session_id = "";
    $retorno = "OK";
}

if( $op == "edit" && empty($_FILES)){
    if( $_POST['op'] == "mov"){
        $sql = "
        INSERT INTO t_chamados_mov (
              m_chamados_id     , m_user_id         , m_data_hora           , m_descricao
        )VALUES(            
              {$id}             , {$user_id}        , '{$data_atual}'       , '{$_POST['adicao_conversa']}'  
        );";
              
        $l_operacao = "MOVIMENTACAO";
        $session_op = $op; $session_id = $id;
    }else{
        $sql = "UPDATE t_chamados SET c_status = '{$dados['chamado_status']}', c_prioridade = '{$dados['chamado_prioridade']}' WHERE chamados_id = {$id};";
        $session_op = $session_id = "";
    }
            
    $l_query .= $sql;      
    if($bd->Execute(replaceEmptyFields($sql))){        
        $retorno = "OK";        
        functionLog($id, $data_atual, $l_operacao, $l_query, $user_id);
    }        
}

if( $_POST['fileUpload'] == "op=upload_arquivo" && $op == "edit" ){
    $session_op = $op; $session_id = $id;
    $files_arq = $_FILES['fileUpload'];
    anexo($files_arq,$id,$user_id);
}

if( $dados['xOp'] == "ciencia" ){
    $verif = $bd->Execute("
        SELECT c.chamados_id 
            , c.c_status 
            , COUNT(m.*) AS qtde
        FROM t_chamados c
        INNER JOIN t_chamados_mov m ON (m.m_chamados_id = c.chamados_id AND m.m_visualizado = 'N' AND m.m_user_id != {$user_id} )
        WHERE c.chamados_id = {$dados['xId']}
            AND c.c_ciente = 'N'
            AND c.c_responsavel_id = {$user_id}
        GROUP BY 1,2;");

    if( $verif->fields['qtde'] >= 1 ){
        $sql = "UPDATE t_chamados SET c_ciente = 'S' WHERE chamados_id = {$dados['id']};";
    }

    if($bd->Execute("UPDATE t_chamados_mov SET m_visualizado = 'S' WHERE movimentacao_id IN ({$dados['xId_mov']});")){
        $session_op = $op; $session_id = $id;
        $retorno = "OK";                
    }
}

print $retorno;

if ( $retorno == "OK" ){
    //Trantando essa excessão para não modificar a página
    if ( !isset($_POST["exception"]) && $_POST['exception'] !== "update_permissoes" ){    
        #Modificando o Session
        $_SESSION['op'] = $session_op;
        $_SESSION['id'] = $session_id;        
    }
}

function functionLog($id, $l_data_hora, $l_operacao, $l_query, $l_user_id){
    global $bd;    
    
    $l_query = str_replace("'",'"', $l_query);
    
    $bd->Execute("
    INSERT INTO t_chamados_log(
        l_chamados_id   , l_data_hora         , l_operacao       , l_query          , l_user_id
    )VALUES(
        {$id}           , '{$l_data_hora}'    , '{$l_operacao}'  , '{$l_query}'     , {$l_user_id}
    );");
}

function anexo($files_arq,$id,$user_id){
    global $bd;    
    global $data_atual;

    if(isset($files_arq)){
        
        $name = $files_arq['name'];
        $dir  = "{$_SERVER["DOCUMENT_ROOT"]}/mmflow/dist/arq_chamados/{$name}";  
        copy($files_arq['tmp_name'], $dir);
        
        if( !empty($name) ){
            $sql = "INSERT INTO t_chamados_anexos(chamados_id, a_nome, a_caminho)VALUES('{$id}', '{$name}', '{$dir}');";        
            
            if($bd->Execute(replaceEmptyFields($sql))){                                
                $retorno = "OK";
                $id_anexo = $bd->Insert_ID();
                functionLog($id, $data_atual, "ANEXO_ARQUIVO-{$id_anexo}", $sql, $user_id);
            }
        }
    }
}