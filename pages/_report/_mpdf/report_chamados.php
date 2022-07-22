<?php 

//Includes gerais
include_once "../../../_conection/_bd.php";    
include_once "../../../_man/_aux.php";
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 400);
date_default_timezone_set('America/Sao_Paulo');

include_once "../../../../mpdf/Relatorio.class.php";

// teste÷
## Inicializando variáveis
$p = json_decode($_POST['parametros']);
$tipo = $p->tipo;
$id = $p->id;

$html = '
    <style>
        body{
            font-size: 12px;
            font-family: "Helvetica", Courier, monospace;
        }               

        .table{       
            width: 100%;               
            border: 0px; 
            border-collapse: collapse;                
            font-size: 11px;
            font-family: "Helvetica," Courier, monospace;
        }

        .table td, .table th{
            border: 1px solid #000;
            padding: 5px;
            vertical-align: middle;
        }
        .text-left  { text-align: left;   }
        .text-center{ text-align: center; }
        .text-rigth { text-align: right;  }

        .background-cinza{ background-color: #CCC; }
        .background-branco{ background-color: #FFF; }   
        
        div.op1 {
            width: 49%;
            float:left;
            background-color: #DCDCDC;

            text-align: center;
            padding: 5vw 0vw 5vw 0vw;
            min-width:40vw;
        }

        div.op2 {
            width: 49%;
            background-color: #DCDCDC;
            float:right;
            margin-right: 0vw;

            text-align: center;
            padding: 5vw 0vw 5vw 0vw;
            min-width:40vw;
            float:right;
        }        
    </style>';

$cham = $bd->Execute("
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
    WHERE chamados_id = {$id}
    ORDER BY chamados_id;");
    
    $html .='
        <div class="op1">
            <table>
                <tbody>
                    <tr>
                        <td width="50%"><b>Solicitante:</b></td>
                        <td width="50%">'. $cham->fields['user_nome'] .'</td>                        
                    </tr>
                    <tr>
                        <td width="50%"><b>Criado:</b></td>
                        <td width="50%">'. $cham->fields['c_data_abertura'] .'</td>                        
                    </tr>
                    <tr>
                        <td width="50%"><b>Fechado:</b></td>
                        <td width="50%">'. $cham->fields['c_data_fechamento'] .'</td>                        
                    </tr>
                    <tr>
                        <td width="50%"><b> &nbsp;</b></td>
                        <td width="50%"> </td>                        
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="op2">
            <table>
                <tbody>
                    <tr>
                        <td width="50%"><b>Atribuído a:</b></td>
                        <td width="50%">'. $cham->fields['user_nome_r'] .'</td>                        
                    </tr>
                    <tr>
                        <td width="50%"><b>Status:</b></td>
                        <td width="50%">'. $cham->fields['c_status'] .'</td>                        
                    </tr>
                    <tr>
                        <td width="50%"><b>Prioridade:</b></td>
                        <td width="50%">'. $cham->fields['c_prioridade'] .'</td>                        
                    </tr>
                    <tr>
                        <td width="50%"><b>Serviço:</b></td>
                        <td width="50%">'. $cham->fields['c_servico'] .'</td>                        
                    </tr>
                </tbody>
            </table>
        </div>
        <br>';

$mov = $bd->Execute("
    SELECT movimentacao_id
        , m_chamados_id
        , m_user_id
        , datahorabrasil(m_data_hora) AS m_data_hora
        , m_descricao
        , user_nome 
    FROM t_chamados_mov m 
    INNER JOIN t_user u ON ( u.user_id = m_user_id )
    WHERE m_chamados_id = {$id}
    ORDER BY movimentacao_id;");      
    
    while(!$mov->EOF){
        $html .='
            <p>
                <b> # '. $mov->fields['user_nome'] .' - '. $mov->fields['m_data_hora'] .'</b>
                <br>'. $mov->fields['m_descricao'] .'
                <br><b> '. str_repeat("_", 110) .'</b>
            </p>';
        $mov->MoveNext();
    }
// print "<pre>"; print $html;
//    print "<pre>"; print $mov->RecordCount();
//    exit;

//$html .= mb_convert_encoding($html, 'UTF-8', 'UTF-8');
$relatorio = new relatorio();
$relatorio->orientacao = "P";
$relatorio->nomeArquivo = "CHAMADO_{$id}.pdf";
$relatorio->textoCabecalho = '<h2 class="text-center">CHAMADO <b> #'.$id.' </b> </h2>';
$relatorio->corpo = $html;
$relatorio->rodape = false;
$relatorio->paginacao = true;
$relatorio->geraRelatorio();