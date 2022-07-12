<?php

include_once('../../_man/_aux.php');
include_once('../../_conection/_conect.php');

$caminho = "C:/WebServer/Apache24/htdocs/";
$chave_acesso = "35220357208480000106550010000768581721096617.xml";

//$dados    = loadFile($caminho,$chave_acesso);
$json_nf  = json_encode($dados);

if($dados){
    # valida duplicidade
    if(duplicity($chave_acesso)){
        $bd->Execute("SELECT crud_escrita_fiscal('INSERT_' , '1' , '{$json_nf}');");
    }
}
/* PRINCIPAL */
function loadFile($caminho,$chave_acesso){
    $arquivo = $caminho.$chave_acesso;
    # Verifica se o arquivo é XML
    if(!isXmlFile($chave_acesso)){throw new Exception("Ops! Somente arquivos .xml podem ser carregados.");}
          
    # Verifica se o arquivo existe
    if (file_exists($arquivo)) {
        # Carrega arquivo
        $load_arq = simplexml_load_file($arquivo);         
        
        # Verifica se o xml está autorizado para uso pela sefaz
        if(!findProtocol($load_arq)){throw new Exception("Ops! Não foi possível processar a nota fiscal pois ela não está autorizado pela sefaz.");}
        
        $xml = $load_arq->NFe->infNFe;
        
        # tag @attributes
        $versao = (string) $xml->attributes()->versao;
        $id     = (string) $xml->attributes()->Id;
        
        #tags
        $ide     = $xml->ide;       # Identificação
        $emit    = $xml->emit;      # Emitente
        $dest    = $xml->dest;      # Destinatário 
        $det     = $xml->det;       # Dados Produtos/Serviços 
        $total   = $xml->total;     # Total
        $transp  = $xml->transp;    # Transportadora/Transporte
        $cobr    = $xml->cobr;      # Cobrança
        $pag     = $xml->pag;       # Pagamento
        $infAdic = $xml->infAdic;   # Informações adicionais 
        
        # monta o array da NFe 
        $dados = array(
             'nome_arquivo' => $id
            ,'versao'       => $versao            
            ,'ide'          => dadosIDE($ide)
            ,'emit'         => dadosEMIT($emit)
            ,'dest'         => dadosDEST($dest)
            ,'det'          => dadosDET($det)
            ,'total'        => dadosTOTAL($total)
            ,'transp'       => dadosTRANSP($transp)
            ,'cobr'         => dadosCOBR($cobr)
            ,'pag'          => dadosPAG($pag)
            ,'inf_adic'     => $infAdic
        );
        
        # Retorno 
        return $dados;        
    }else{
        exit("NÃO EXISTENTE");
    }
}

function isXmlFile($chave_acesso){
    if(pathinfo(strtolower($chave_acesso), PATHINFO_EXTENSION) == "xml") return true;
    else false;
}

function findProtocol($nfe){
    foreach($nfe->children() as $child){
        if($child->getName() == "protNFe"){
            return true;
        }
    }          
    return false;        
}

function duplicity($chave_acesso){
    global $bd;
    $chave_acesso = explode(".",$chave_acesso)[0];    
    $nf = $bd->Execute($sql = "SELECT * FROM t_escrita_fiscal WHERE REPLACE(ef_ident,'NFe','') = '{$chave_acesso}'; --ef_num_nf = '76858' AND ef_cnpj_emit = '57208480000106' AND ef_tipo_op = '1';");
    if($nf->RecordCount() > 0)return false;
    
    return true;        
}

# dados de identificação
function dadosIDE($ide){
    $arr = array(
         'cod_uf'                   => (string) $ide->cUF
        ,'cod_nf'                   => (string) $ide->cNF
        ,'nat_op'                   => (string) $ide->natOp
        ,'mod'                      => (string) $ide->mod
        ,'serie'                    => (string) $ide->serie
        ,'num_nf'                   => (string) $ide->nNF
        ,'dt_emissao'               => (string) $ide->dhEmi
        ,'dt_saida'                 => (string) $ide->dhSaiEnt
        ,'tipo'                     => (string) $ide->tpNF
        ,'id_dest'                  => (string) $ide->idDest
        ,'cod_mun'                  => (string) $ide->cMunFG
        ,'tipo_imp'                 => (string) $ide->tpImp
        ,'tipo_emis'                => (string) $ide->tpEmis
        ,'cod_dig_verif'            => (string) $ide->cDV
        ,'tipo_amb'                 => (string) $ide->tpAmb
        ,'fin_nfe'                  => (string) $ide->finNFe
        ,'ind_final'                => (string) $ide->indFinal
        ,'ind_pres'                 => (string) $ide->indPres
        ,'proc_emi'                 => (string) $ide->procEmi
        ,'protocolo'                => (string) $ide->verProc
    );
    return $arr;
}

# dados do emitentente 
function dadosEMIT($emit){
    global $bd;
    $ender = $emit->enderEmit; # Endereço 
    
    $arr = array(
         'cnpj'                     => (string) $emit->CNPJ
        ,'razao_social'             => (string) $emit->xNome
        ,'n_fantasia'               => (string) $emit->xFant
        ,'insc_estadual'            => (string) $emit->IE
        ,'crt'                      => (string) $emit->CRT
        
        # Endereço 
        ,'ender'                    => (string) $ender->xLgr
        ,'nro'                      => (string) $ender->nro
        ,'bairro'                   => (string) $ender->xBairro
        ,'cod_mun'                  => (string) $ender->cMun
        ,'municipio'                => (string) $ender->xMun
        ,'uf'                       => (string) $ender->UF
        ,'cep'                      => (string) $ender->CEP
        ,'cod_pais'                 => (string) $ender->cPais
        ,'pais'                     => (string) $ender->xPais
        ,'fone'                     => (string) $ender->fone
    );
    
    /* Verifica se o emitente existe, se não existe faz um cadastro "rápido" */
    $part = $bd->Execute("SELECT * FROM t_participante p WHERE participante_codigo = '{$emit->CNPJ}';");
    if( $part->RecordCount() == 0 ){
        $bd->Execute("SELECT crud_participante('INSERT_','1','". json_encode($arr)."');");
    }

    return $arr;
}

# dados destinatario 
function dadosDEST($dest){
    $ender = $dest->enderDest; # Endereço 
    
    $arr = array(
         'cnpj'                     => (string) $dest->CNPJ
        ,'razao_social'             => (string) $dest->xNome
        ,'n_fantasia'               => (string) $dest->xFant
        ,'insc_estadual'            => (string) $dest->IE
        ,'ind_estadual'             => (string) $dest->indIEDest
            
        # Endereço 
        ,'ender'                    => (string) $ender->xLgr
        ,'nro'                      => (string) $ender->nro
        ,'bairro'                   => (string) $ender->xBairro
        ,'cod_mun'                  => (string) $ender->cMun
        ,'municipio'                => (string) $ender->xMun
        ,'uf'                       => (string) $ender->UF
        ,'cep'                      => (string) $ender->CEP
        ,'cod_pais'                 => (string) $ender->cPais
        ,'pais'                     => (string) $ender->xPais
        ,'fone'                     => (string) $ender->fone
    );
    return $arr;
}

# dados DET - itens 
function dadosDET($det){
    $arr = array();    
    foreach($det as $i){
        # Inicializando variáveis
        $prod   = $i->prod;
        $icms   = $i->imposto->ICMS->children()->children();
        $ipi    = $i->imposto->IPI;
        $pis    = $i->imposto->PIS;
        $cofins = $i->imposto->COFINS;
        
        array_push($arr, 
            array(          
                # attributes
                 'num_item'         => (string) $i->attributes()->nItem
                ,'cod_prod'         => (string) $prod->cProd
                ,'cod_ean'          => (string) $prod->cEAN
                ,'descricao'        => (string) $prod->xProd
                ,'ncm'              => (string) $prod->NCM
                ,'cfop'             => (string) $prod->CFOP
                ,'unidade'          => (string) $prod->uCom
                ,'quantidade'       => (string) $prod->qCom
                ,'v_unitario'       => (string) $prod->vUnCom
                ,'v_produto'        => (string) $prod->vProd                
                ,'cod_ean_trib'     => (string) $prod->cEANTrib
                ,'unidade_trib'     => (string) $prod->uTrib
                ,'quantidade_trib'  => (string) $prod->qTrib
                ,'v_unitario_trib'  => (string) $prod->vUnTrib
                ,'v_frete'          => (string) ($item->prod->vFrete            ?? "0.00")
                ,'v_seguro'         => (string) ($item->prod->vSeg              ?? "0.00")
                ,'v_desconto'       => (string) ($item->prod->vDesc             ?? "0.00")
                ,'v_outras'         => (string) ($item->prod->vOutro            ?? "0.00")
                ,'ind_tot'          => (string) $prod->indTot                                                                
                # Impostos
                ,'v_tot_trib'       => (string) ($i->imposto->vTotTrib          ?? "0.00")
                # ICMS
                ,'cst_origem'       => (string) $icms->orig
                ,'cst_trib'         => (string) ($icms->CST                     ?? $icms->children()->CST)
                ,'mod_bc'           => (string) $icms->modBC
                ,'porc_red_bc'      => (string) ($icms->pRedBC                  ?? "0.00")
                ,'bc_icms'          => (string) ($icms->vBC                     ?? "0.00")
                ,'aliq_icms'        => (string) ($icms->pICMS                   ?? "0.00")
                ,'v_icms'           => (string) ($icms->vICMS                   ?? "0.00")
                # IPI
                ,'cod_enquad'       => (string) $ipi->cEnq
                ,'cst_ipi'          => (string) ($ipi->CST                      ?? $ipi->children()->CST)
                ,'bc_ipi'           => (string) ($ipi->vBC                      ?? "0.00")
                ,'aliq_ipi'         => (string) ($ipi->pICMS                    ?? "0.00")
                ,'v_ipi'            => (string) ($ipi->vICMS                    ?? "0.00")
                # PIS                
                ,'cst_pis'          => (string) ($pis->PISAliq->CST             ?? $pis->children()->CST)
                ,'bc_pis'           => (string) ($pis->PISAliq->vBC             ?? "0.00")
                ,'aliq_pis'         => (string) ($pis->PISAliq->pPIS            ?? "0.00")
                ,'v_pis'            => (string) ($pis->PISAliq->vPIS            ?? "0.00")
                # COFINS                
                ,'cst_cofins'       => (string) ($cofins->COFINSAliq->CST       ?? $cofins->children()->CST)
                ,'bc_cofins'        => (string) ($cofins->COFINSAliq->vBC       ?? "0.00")
                ,'aliq_cofins'      => (string) ($cofins->COFINSAliq->pCOFINS   ?? "0.00")
                ,'v_cofins'         => (string) ($cofins->COFINSAliq->vCOFINS   ?? "0.00")
            )
        );
    }

    return $arr;
}

#dados total 
function dadosTOTAL($total){
    $total = $total->ICMSTot->children();
    $arr = array(
         'bc'                       => (string) $total->vBC
        ,'v_icms'                   => (string) $total->vICMS
        ,'v_icms_deson'             => (string) $total->vICMSDeson      # Valor Desoneração do ICMS
        ,'v_fcp'                    => (string) $total->vFCP            # Valor Fundo de Combate à Pobreza
        ,'bc_sit_trib'              => (string) $total->vBCST           # Base de Cálculo Situação Tributária
        ,'v_sit_trib'               => (string) $total->vST             # Valor Situação Tributária
        ,'v_fcp_st'                 => (string) $total->vFCPST          # Valor do FCP retido por Substituição Tributária
        ,'v_fcp_st_ret'             => (string) $total->vFCPSTRet       # Valor Total do FCP retido anteriormente por Substituição Tributária
        ,'v_produtos'               => (string) $total->vProd
        ,'v_frete'                  => (string) $total->vFrete
        ,'v_seguro'                 => (string) $total->vSeg
        ,'v_desconto'               => (string) $total->vDesc
        ,'v_impost_import'          => (string) $total->vII
        ,'v_ipi'                    => (string) $total->vIPI
        ,'v_ipi_dev'                => (string) $total->vIPIDevol       # Valor IPI Devolução
        ,'v_pis'                    => (string) $total->vPIS
        ,'v_cofins'                 => (string) $total->vCOFINS
        ,'v_outros'                 => (string) $total->vOutro
        ,'v_nf'                     => (string) $total->vNF
        ,'v_trib'                   => (string) $total->vTotTrib
    );
    return $arr;
}


# dados da transportadora 
function dadosTRANSP($transp){
    $arr = array(
         'modo_frete'               => (string) $transp->modFrete                      
        ,'cnpj'                     => (string) $transp->transporta->CNPJ
        ,'razao_social'             => (string) $transp->transporta->xNome
        ,'insc_estadual'            => (string) $transp->transporta->IE
        ,'endereco'                 => (string) $transp->transporta->xEnder
        ,'municipio'                => (string) $transp->transporta->xMun
        ,'uf'                       => (string) $transp->transporta->UF
        
        # Veículo
        ,'placa_veiculo'            => (string) $transp->veicTransp->placa
        ,'uf_veiculo'               => (string) $transp->veicTransp->UF
            
        # Volume
        ,'quantidade'               => (string) $transp->vol->qVol
        ,'especie'                  => (string) $transp->vol->esp
        ,'marca'                    => (string) $transp->vol->marca
        ,'peso_liquido'             => (string) $transp->vol->pesoL
        ,'peso_bruto'               => (string) $transp->vol->pesoB        
    );    
    return $arr;
}

function dadosCOBR($cobr){
    $arr = array();
    foreach($cobr as $c){
        array_push($arr, 
            array(
                # Duplicata
                 'num_dupl'         => (string) $c->dup->nDup
                ,'dt_venc'          => (string) $c->dup->dVenc
                ,'v_dup'            => (string) $c->dup->vDup  
                # Fatura
                ,'num_fat'          => (string) $c->fat->nFat
                ,'v_orig'           => (string) $c->fat->vOrig
                ,'v_desc'           => (string) $c->fat->vDesc
                ,'v_liq'            => (string) $c->fat->vLiq
            )
        );
    }
    return $arr;
}

function dadosPAG($pag){
    $pag = $pag->detPag;
    $arr = array(
        't_pag'                     => (string) $pag->tPag
        ,'v_pag'                    => (string) $pag->vPag
    );
    return $arr;
}

function dadosinfAdic($infAdic){
    $arr = $infAdic->infCpl;
    return $arr;
}               