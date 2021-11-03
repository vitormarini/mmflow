<?php
include_once '../../../_conection/_bd.php'; 
  
#Preparando as variáveis
$col_codigo = $_GET['col_codigo'];
$sintetico  = $_GET['sintetico_detail'];
$exibe_totais = $_GET['exibe_totais'];


$html = '
<style>

    body{
        font-size: 12px;
        font-family: "Helvetica", Courier, monospace;
    }

    .table{
        width: 90%;
        border-collapse: collapse;
        font-size: 7px;
        font-family: "Helvetica," Courier, monospace;
        margin:auto;
    }
    .tableR{
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        font-family: "Helvetica," Courier, monospace;
        margin:auto;
    }

    .table th{
        border: 1px solid #000;
        padding: 5px;
        vertical-align: middle;
    }
    .table td{
        border: 0.2px solid #000;
        padding: 1.5px;
        vertical-align: middle;
    }

    .background-cinza{
        background-color: #CCC;         
    }
    .background-blue{ 
        background-color: #6495ED; 
        color: #F8F8FF;
    }
    .background-cinza-branco{ 
        background-color: #000000; 
        color: #F8F8FF;
    }
    .background-cinza-linha{ background-color: #F0F8FF; }
    .blacked{ font-weight: bold; }
    .border-larger { border: 2px solid #000;  }
    .border-low { border: 0.2px solid #000;   }
    .border-zero { border: 0px solid #000;    }

</style>';

$itens = $bd->Execute($sql = 
"SELECT  
    item_tipo
  , count(*) AS qtd_itens 
  , CASE 
          WHEN item_tipo = '00' THEN '00 - Mercadoria p/ Revenda'
          WHEN item_tipo = '01' THEN '01 - Matéria Prima'
          WHEN item_tipo = '02' THEN '02 - Embalagem'
          WHEN item_tipo = '03' THEN '03 - Produto em Processo'
          WHEN item_tipo = '04' THEN '04 - Produto Acabado'
          WHEN item_tipo = '05' THEN '05 - Subproduto'
          WHEN item_tipo = '06' THEN '06 - Produto Intermediário'
          WHEN item_tipo = '07' THEN '07 - Material Uso e Consumo'
          WHEN item_tipo = '08' THEN '08 - Ativo Imobilizado'
          WHEN item_tipo = '09' THEN '09 - Serviços'
          WHEN item_tipo = '10' THEN '10 - Outros Insumos'
          WHEN item_tipo = '99' THEN '99 - Outras'
  END AS item_tipo_detail
  FROM t_item ti 
  GROUP BY 1 
  ORDER BY 1;");

$html .= '<table class="table">';
                    
if ( $sintetico == "S" ){ 

    $showCode =  $col_codigo == "S"  ? '<th width="10%">Código          </th>' : '';
    
    $html .=
    '<thead>
        <tr>
            '.$showCode.'
            <th width="30%">Descrição       </th>
            <th width="20%">NCM             </th>
            <th width="10%">Unidade         </th>
            <th width="10%">Tipo            </th>
        </tr>
    </thead>';
}else{ 

    $showCode =  $col_codigo == "S"  ? '<th width="10%">Código          </th>' : '';

    $html .=
    '<thead>
        <tr>
            '.$showCode.'
            <th width="15%">Descrição       </th>
            <th width="15%">NCM             </th>
            <th width="10%">Unidade         </th>
            <th width="10%">Tipo            </th>
            <th width="15%">Cód. Gênero            </th>
            <th width="15%">Cód. LST            </th>
        </tr>
    </thead>';

} 

while ( !$itens->EOF ){
        
    #buscamos os dados
    $sql = "SELECT 
                item_id                         
          ,	item_codigo		
          ,	item_descricao 
          ,	item_codigo_barra 		
          ,	item_und_inv ||' - '||und.unidades_medidas_descricao AS item_und_inv_detail
          ,	item_und_inv
          ,	CASE 
                            WHEN item_tipo = '00' THEN '00 - Mercadoria p/ Revenda'
                            WHEN item_tipo = '01' THEN '01 - Matéria Prima'
                            WHEN item_tipo = '02' THEN '02 - Embalagem'
                            WHEN item_tipo = '03' THEN '03 - Produto em Processo'
                            WHEN item_tipo = '04' THEN '04 - Produto Acabado'
                            WHEN item_tipo = '05' THEN '05 - Subproduto'
                            WHEN item_tipo = '06' THEN '06 - Produto Intermediário'
                            WHEN item_tipo = '07' THEN '07 - Material Uso e Consumo'
                            WHEN item_tipo = '08' THEN '08 - Ativo Imobilizado'
                            WHEN item_tipo = '09' THEN '09 - Serviços'
                            WHEN item_tipo = '10' THEN '10 - Outros Insumos'
                            WHEN item_tipo = '99' THEN '99 - Outras'
                    END AS item_tipo_detail
          ,	item_tipo 		
          ,	item_ex_ipi
          ,	CASE WHEN item_cod_gen IS NOT NULL THEN p_genero_item(item_cod_gen) ELSE '' END AS item_cod_gen_detail
          ,	item_cod_gen      
          ,	CASE WHEN item_cod_lst IS NOT NULL THEN p_codigo_lst(item_cod_lst) ELSE '' END AS item_cod_lst_detail
          ,	item_cod_lst
          ,	item_aliq_icms          
          ,	item_cest 
          ,	t_ncm.ncm_codigo ||' '||t_ncm.ncm_descricao AS item_ncm_detail
          ,	item_ncm 
          FROM t_item ti
          INNER JOIN t_unidades_medidas AS und ON ( und.unidades_medidas_sigla = ti.item_und_inv)
          INNER JOIN t_ncm ON ( replace(t_ncm.ncm_codigo,'.','') = item_ncm ) 
          WHERE item_tipo = '{$itens->fields['item_tipo']}'
            ORDER BY 2;";


    $dados = $bd->Execute($sql);
    
    $html .=
        '<tbody>';
    while ( !$dados->EOF ){
           
        if (  $sintetico == "S" ){
            
            $showCode =  $col_codigo == "S"  ? '<th width="10%">'.$dados->fields['item_codigo'].'          </th>' : '';

            $html .=
            '<tr>
                '.$showCode.'
                <td class="text-left"  >'. $dados->fields['item_descricao']    .'</td>
                <td class="text-left"  >'. $dados->fields['item_ncm']          .'</td>
                <td class="text-left"  >'. $dados->fields['item_und_inv']      .'</td>
                <td class="text-left"  >'. $dados->fields['item_tipo']         .'</td>                
            </tr>';

        } else {

            $showCode =  $col_codigo == "S"  ? '<th width="10%">'.$dados->fields['item_codigo'].'          </th>' : '';

            $html .=
            '<tr>
                '.$showCode.'
                <td class="text-left"  >'. $dados->fields['item_descricao']           .'</td>
                <td class="text-left"  >'. $dados->fields['item_ncm_detail']          .'</td>
                <td class="text-left"  >'. $dados->fields['item_und_inv_detail']      .'</td>
                <td class="text-left"  >'. $dados->fields['item_tipo_detail']         .'</td>
                <td class="text-left"  >'. $dados->fields['item_cod_gen_detail']      .'</td>
                <td class="text-left"  >'. $dados->fields['item_cod_lst_detail']      .'</td>
            </tr>';               
        }
        
        if ( $totais == "S" ){ 
                $html .='<td colspan="7" class="text-left"><h4>Total de Itens Referente - '. $itens->fields['item_tipo_detail'] .' - '. $itens->fields['qtd_itens'] .'</h4></td>';
        } 
                
        $dados->MoveNext();
    }
    $html .=
        '</tbody>';
        
            
    $itens->MoveNext();
}
 $html .=
        '</table>';


    $arquivo = "Listagem_Itens.xls";

    // Configurações header para forçar o download
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header ("Content-Description: PHP Generated Data" );
    // Envia o conteúdo do arquivo
    echo utf8_decode($html);
    exit;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

