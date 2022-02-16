<?php
/*
 * Desenvolvido por Tamara Vindilino
 * Data: 26/08/2021
 */

include_once( "{$_SERVER['DOCUMENT_ROOT']}/gestao/funcoes.php" );
include_once( "{$_SERVER['DOCUMENT_ROOT']}/gestao/bd.php" );
error_reporting( E_ERROR );

# Variaveis
$retorno      = array();
$chave_acesso = $_POST['chave_acesso'];
$array_cancel = array();
$x            = 0;

$dados = $bd->Execute($sql = "
    SELECT  doc.id_t_dfe_service_docs 
        ,   tpevento
        ,   doc.xevento
        ,   doc.cstat 
        ,   doc.status         
        ,   doc.xmotivo 
        ,   doc.chnfe 
        ,   datahorabrasil(dhregevento::date) AS data_evento
    FROM    t_dfe_service_docs doc
    WHERE   doc.cstat IN ('135','101','151','653') 
        AND doc.tipo = 'procEv'
        AND tpevento NOT IN ('210210','210200','210240')
        AND xevento != '' 
        AND doc.chnfe = '{$chave_acesso}'
    GROUP BY 1,2,3,4,5,6,7,8
    ORDER BY data_evento;");    


while( !$dados->EOF ){
    array_push($array_cancel,$dados->fields['status']);
    $html .= '
        <tr>
            <td class="text-center">'. $x                           .'</td>
            <td class="text-center">'. $dados->fields['xevento']    .'</td>
            <td class="text-center">'. $dados->fields['xmotivo']    .'</td>
            <td class="text-center">'. $dados->fields['status']     .'</td>
        </tr>
    ';
    $x++;
    $dados->MoveNext();
}
$doc_cancelado = in_array("CANCELADA", $array_cancel) ? "SIM" : "NAO";
array_push($retorno, 
    array(
        "status"    => "OK",
        "html"      => $html,
        "cancelado" => $doc_cancelado
    )
);

 # RETORNA AS INFORMAÇÕES 
print json_encode($retorno);    