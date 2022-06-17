<?php
/* Descrição: Back-End adm_empresas.php
 * Author: Vitor Hugo Marini
 * Data: 16/02/2022
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';

session_start();
$post = $_POST;
try {
    if($post['xOp'] == "return_mov"){

        $chamado = $bd->Execute("
            SELECT c.chamados_id AS id
                , c.c_assunto 
                , c.c_user_id 
                , c.c_responsavel_id 
                , COUNT(m.*) AS qtde
                , CASE 
                    WHEN COUNT(m.*) > 0 THEN COUNT(m.*) ||' NOVAS MENSAGENS!'
                    ELSE COUNT(m.*) ||' NOVA MENSAGEM!'
                  END AS descricao
                , ARRAY_AGG(m.movimentacao_id) AS mov_ids
            FROM t_chamados c
            INNER JOIN t_chamados_mov m ON (m.m_chamados_id = c.chamados_id AND m.m_visualizado = 'N' AND m.m_user_id != {$_SESSION['user_id']})
            WHERE (c.c_user_id = {$_SESSION['user_id']} OR c.c_responsavel_id = {$_SESSION['user_id']})
            GROUP BY 1
            ORDER BY 1;");
            
        while(!$chamado->EOF){
            $div_toast .='
                <div class="toast" data-autohide="false">
                    <div class="toast-header">
                        <strong class="me-auto">'. $chamado->fields['descricao'] .'</strong>
                    </div>
                    <div class="toast-body">
                    <a>'. $chamado->fields['c_assunto'] .'</a>
                    <div class="mt-2 pt-2 border-top ">
                        <button type="button" class="btn btn-primary btn-sm col-sm-12 pull-right bntOk" data-id="'. $chamado->fields['id'] .'" data-ids_mov="'. $chamado->fields['mov_ids'] .'">OK</button>
                    </div>
                    </div>
                </div>';
            $chamado->MoveNext();
        }

        print $div_toast;
        exit;
    }
} catch (\Throwable $th) {
    //throw $th;
}


// <div class="toast" data-autohide="false">
//                     <div class="toast-header">
//                         <strong class="me-auto">'. $chamado->fields['descricao'] .'</strong>
//                     </div>
//                     <div class="toast-body">
//                     <a>'. $chamado->fields['c_assunto'] .'</a>
//                     <div class="mt-2 pt-2 border-top ">
//                         <button type="button" class="btn btn-primary btn-sm col-sm-12 pull-right bntOk" data-ids="'. $chamado->fields['mov_ids'] .'">OK</button>
//                     </div>
//                     </div>
//                 </div>