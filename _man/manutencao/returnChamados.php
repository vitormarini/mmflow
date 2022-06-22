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
                --, datahorabrasil(m.m_data_hora) AS m_data_hora
                , COUNT(m.*) AS qtde
                , CASE 
                    WHEN COUNT(m.*) > 0 THEN COUNT(m.*) ||' NOVAS MENSAGENS!'
                    ELSE COUNT(m.*) ||' NOVA MENSAGEM!'
                  END AS descricao
                , ARRAY_AGG(m.movimentacao_id) AS mov_ids
            FROM t_chamados c
            INNER JOIN t_chamados_mov m ON (m.m_chamados_id = c.chamados_id AND m.m_visualizado = 'N' AND m.m_user_id != {$_SESSION['user_id']})
            WHERE (c.c_user_id = {$_SESSION['user_id']} OR c.c_responsavel_id = {$_SESSION['user_id']})
            GROUP BY 1--,m_data_hora
            ORDER BY 1;");
            
        while(!$chamado->EOF){
            $div_toast .='
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                    <div class="toast-header">
                        <strong class="me-auto">'. $chamado->fields['descricao'] .'</strong>
                    </div>
                    <div class="toast-body">
                        <p><strong class="me-auto">'. $chamado->fields['id'] .' - '. $chamado->fields['c_assunto'] .'<strong></p>
                        <div class="row border-top mt-2 pt-2">
                            <div class="col-sm-4">
                            <button type="button" class="btn btn-primary btn-sm input-sm pull-right bntOk" data-id="'. $chamado->fields['id'] .'" data-value="CIENTE" d data-ids_mov="'. $chamado->fields['mov_ids'] .'">Ciente</button>
                            </div>
                            <div class="col-sm-8">
                            <button type="button" class="btn btn-info btn-sm input-sm pull-right bntOk" data-id="'. $chamado->fields['id'] .'" data-value="CIENTE_REDIRECIONAR" data-ids_mov="'. $chamado->fields['mov_ids'] .'">Ciente/Redirecionar</button>
                            </div>
                        </div>
                    </div>
                </div>
                ';
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