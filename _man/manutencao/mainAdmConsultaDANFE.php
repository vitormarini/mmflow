<?php

/* 
 * TAMARA VINDILINO
 * Data: 05/04/2022
 */

include_once '../../_conection/_conect.php';
include_once '../../_man/_aux.php';
include_once '../../response/_readerXML/readerDANFE.php';

session_start();

# Inicializando variáveis
$op      = $_SESSION['op'];          //Ação
$p       = $_SESSION['p'];           //Página da Busca
$r       = $_SESSION['tela_atual'];  //Tela Atual
$b       = $_SESSION['buscas'];      //Filtros de buscas

$dados   = $_POST;


$id      = !empty($_SESSION['id']) ? $_SESSION['id'] : $dados['id'];          //ID
$retorno = "ERRO";

if( $dados['op'] == "retorna_detalhes" ){
    # Carrega nota 
    # Carrega nota 
    $nfe = $bd->Execute("
        SELECT ef_id                    , ef_data_hora                  , ef_status                     , ef_versao
            , ef_ident                  , ef_cod_uf                     , ef_cod_nf                     , ef_nat_op
            , ef_mod                    , ef_serie                      , ef_num_nf                     , ef_dt_emissao
            , ef_dt_saida               , ef_tipo_op                    , ef_id_dest                    , ef_cod_mun
            , ef_tipo_imp               , ef_tipo_emis                  , ef_cod_dig_verif              , ef_tipo_amb
            , ef_fin_nfe                , ef_ind_final                  , ef_ind_pres                   , ef_proc_emi
            , ef_protocolo              , ef_cnpj_emit                  , ef_razao_social_emit          , ef_n_fantasia_emit
            , ef_insc_estadual_emit     , ef_crt_emit                   , ef_ender_emit                 , ef_nro_emit
            , ef_bairro_emit            , ef_cod_mun_emit               , ef_municipio_emit             , ef_uf_emit
            , ef_cep_emit               , ef_cod_pais_emit              , ef_pais_emit                  , ef_fone_emit
            , ef_cnpj_dest              , ef_razao_socil_dest           , ef_n_fantasia_dest            , ef_insc_estadual_dest
            , ef_ind_estadual_dest      , ef_ender_dest                 , ef_nro_dest                   , ef_bairro_dest
            , ef_cod_mun_dest           , ef_municipio_dest             , ef_uf_dest                    , ef_cep_dest
            , ef_cod_pais_dest          , ef_pais_dest                  , ef_fone_dest                  , ef_modo_frete
            , ef_cnpj_transp            , ef_razao_social_transp        , ef_insc_estadual_transp       , ef_endereco_transp
            , ef_municipio_transp       , ef_uf_transp                  , ef_placa_veiculo_transp       , ef_uf_veiculo_transp
            , ef_quantidade_transp      , ef_especie_transp             , ef_marca_transp               , ef_peso_liquido_transp
            , ef_peso_bruto_transp      , ef_bc                         , ef_v_icms                     , ef_v_icms_deson
            , ef_v_fcp                  , ef_bc_sit_trib                , ef_v_sit_trib                 , ef_v_fcp_st               
            , ef_v_fcp_st_ret           , ef_v_produtos                 , ef_v_frete                    , ef_v_seguro
            , ef_v_desconto             , ef_v_impost_import            , ef_v_ipi                      , ef_v_ipi_dev
            , ef_v_pis                  , ef_v_cofins                   , ef_v_outros                   , ef_v_nf
            , ef_v_trib                 , ef_inf_adic
        FROM t_escrita_fiscal ef
        WHERE ef_id = {$id};");

    $item = $bd->Execute("
        SELECT efi_id               , efi_ef_id             , efi_num_item              , efi_cod_prod              , efi_cod_ean
            , efi_descricao         , efi_ncm               , efi_cfop                  , efi_unidade               , efi_quantidade
            , efi_v_unitario        , efi_v_produto         , efi_cod_ean_trib          , efi_unidade_trib          , efi_quantidade_trib
            , efi_v_unitario_trib   , efi_v_frete           , efi_v_seguro              , efi_v_desconto            , efi_v_outras
            , efi_ind_tot           , efi_v_tot_trib        , efi_cst_origem            , efi_cst_trib              , efi_mod_bc
            , efi_porc_red_bc       , efi_bc_icms           , efi_aliq_icms             , efi_v_icms                , efi_cod_enquad
            , efi_cst_ipi           , efi_bc_ipi            , efi_aliq_ipi              , efi_v_ipi                 , efi_cst_pis
            , efi_bc_pis            , efi_aliq_pis          , efi_v_pis                 , efi_cst_cofins            , efi_bc_cofins
            , efi_aliq_cofins       , efi_v_cofins
        FROM t_escrita_fiscal_item i
        WHERE efi_ef_id = {$id}
        ORDER BY 1;");

    $arr_item = array();
    while(!$item->EOF){
        array_push($arr_item, 
            array(          
                # attributes
                 'num_item'         => $item->fields['efi_num_item']
                ,'cod_prod'         => $item->fields['efi_cod_prod']
                ,'cod_ean'          => $item->fields['efi_cod_ean']
                ,'descricao'        => $item->fields['efi_descricao']
                ,'ncm'              => $item->fields['efi_ncm']
                ,'cfop'             => $item->fields['efi_cfop']
                ,'unidade'          => $item->fields['efi_unidade']
                ,'quantidade'       => $item->fields['efi_quantidade']
                ,'v_unitario'       => $item->fields['efi_v_unitario']
                ,'v_produto'        => $item->fields['efi_v_produto']
                ,'cod_ean_trib'     => $item->fields['efi_cod_ean_trib']
                ,'unidade_trib'     => $item->fields['efi_unidade_trib']
                ,'quantidade_trib'  => $item->fields['efi_quantidade_trib']
                ,'v_unitario_trib'  => $item->fields['efi_v_unitario_trib']
                ,'v_frete'          => $item->fields['efi_v_frete']
                ,'v_seguro'         => $item->fields['efi_v_seguro']
                ,'v_desconto'       => $item->fields['efi_v_desconto']
                ,'v_outras'         => $item->fields['efi_v_outras']
                ,'ind_tot'          => $item->fields['efi_ind_tot']
                # Impostos
                ,'v_tot_trib'       => $item->fields['v_tot_trib']
                # ICMS
                ,'cst_origem'       => $item->fields['efi_cst_origem']
                ,'cst_trib'         => $item->fields['efi_cst_trib']
                ,'mod_bc'           => $item->fields['efi_mod_bc']
                ,'porc_red_bc'      => $item->fields['efi_porc_red_bc']
                ,'bc_icms'          => $item->fields['efi_bc_icms']
                ,'aliq_icms'        => $item->fields['efi_aliq_icms']
                ,'v_icms'           => $item->fields['efi_v_icms']
                # IPI
                ,'cod_enquad'       => $item->fields['efi_cod_enquad']
                ,'cst_ipi'          => $item->fields['efi_cst_ipi']
                ,'bc_ipi'           => $item->fields['efi_bc_ipi']
                ,'aliq_ipi'         => $item->fields['efi_aliq_ipi']
                ,'v_ipi'            => $item->fields['efi_v_ipi']
                # PIS                
                ,'cst_pis'          => $item->fields['efi_cst_pis']
                ,'bc_pis'           => $item->fields['efi_bc_pis']
                ,'aliq_pis'         => $item->fields['efi_aliq_pis']
                ,'v_pis'            => $item->fields['efi_v_pis']
                # COFINS                
                ,'cst_cofins'       => $item->fields['efi_cst_cofins']
                ,'bc_cofins'        => $item->fields['efi_bc_cofins']
                ,'aliq_cofins'      => $item->fields['efi_aliq_cofins']
                ,'v_cofins'         => $item->fields['efi_v_cofins']
            )
        );
        $item->MoveNext();
    }

    
    $return = array(
         "chave_acesso_"             => $nfe->fields['ef_ident']
        ,"numero_nfe_"               => $nfe->fields['ef_num_nf']
        ,"modelo_"                   => $nfe->fields['ef_mod']
        ,"serie_"                    => $nfe->fields['ef_serie']
        ,"dt_emissao_"               => $nfe->fields['ef_dt_emissao']
        ,"dt_saida_entr_"            => $nfe->fields['ef_dt_saida']
        ,"vl_total_"                 => $nfe->fields['ef_v_nf']
        ,"cpf_cnpj_dest_"            => $nfe->fields['ef_cnpj_dest']
        ,"razao_social_dest_"        => $nfe->fields['ef_razao_socil_dest']
        ,"consumidor_final_dest_"    => ""
        ,"endereco_dest_"            => $nfe->fields['ef_ender_dest']
        ,"bairro_dest_"              => $nfe->fields['ef_bairro_dest']
        ,"cep_dest_"                 => $nfe->fields['ef_cep_dest']
        ,"municipio_dest_"           => $nfe->fields['ef_municipio_dest']
        ,"telefone_dest_"            => $nfe->fields['ef_fone_dest']
        ,"uf_dest_"                  => $nfe->fields['ef_uf_dest']
        ,"pais_dest_"                => $nfe->fields['ef_cod_pais_dest']
        ,"indicador_ie_dest_"        => ""
        ,"insc_estadual_dest_"       => $nfe->fields['ef_insc_estadual_dest']
        ,"insc_suframa_dest_"        => ""
        ,"email_dest_"               => ""
        ,"tipo_emissao_"             => $nfe->fields['ef_tipo_emis']
        ,"finalidade_"               => $nfe->fields['ef_fin_nfe']
        ,"nat_oper_"                 => $nfe->fields['ef_nat_op']
        ,"tipo_operacao_"            => $nfe->fields['ef_tipo_op']
        ,"cpf_cnpj_emit_"            => $nfe->fields['ef_cnpj_emit']
        ,"razao_social_emit_"        => $nfe->fields['ef_razao_social_emit']
        ,"endereco_emit_"            => $nfe->fields['ef_ender_emit']
        ,"bairro_emit_"              => $nfe->fields['ef_bairro_emit']
        ,"cep_emit_"                 => $nfe->fields['ef_cep_emit']
        ,"municipio_emit_"           => $nfe->fields['ef_municipio_emit']
        ,"telefone_emit_"            => $nfe->fields['ef_fone_emit']
        ,"uf_emit_"                  => $nfe->fields['ef_uf_emit']
        ,"pais_emit_"                => $nfe->fields['ef_pais_emit']
        ,"insc_estadual_emit_"       => $nfe->fields['ef_insc_estadual_emit']
        ,"ie_subst_tribu_emit_"      => ""
        ,"insc_municipal_emit_"      => ""
        ,"cnae_fiscal_emit_"         => ""
        ,"cod_regime_trib_emit_"     => ""
        ,"vl_desp_acessor_"          => $nfe->fields['ef_v_outros']
        ,"vl_frete_"                 => $nfe->fields['ef_v_frete']
        ,"vl_seguro_"                => $nfe->fields['ef_v_seguro']
        ,"vl_total_prod_"            => $nfe->fields['ef_v_produtos']
        ,"vl_total_nf_"              => $nfe->fields['ef_v_nf']
        ,"vl_aprox_tributos_"        => $nfe->fields['ef_v_trib']
        ,"vl_bc_icms_"               => $nfe->fields['ef_bc']
        ,"vl_aliq_icms_"             => "0,00"
        ,"vl_icms_"                  => $nfe->fields['ef_v_icms']
        ,"vl_outras_icms_"           => "0,00"
        ,"vl_isento_icms_"           => "0,00"
        ,"vl_bc_ipi_"                => $nfe->fields['ef_bc']
        ,"vl_aliq_ipi_"              => "0,00"
        ,"vl_ipi_"                   => $nfe->fields['ef_v_ipi']
        ,"vl_outras_ipi_"            => "0,00"
        ,"vl_isento_ipi_"            => "0,00"
        ,"vl_bc_pis_"                => $nfe->fields['ef_bc']
        ,"vl_aliq_pis_"              => "0,00"
        ,"vl_pis_"                   => $nfe->fields['ef_v_pis']
        ,"vl_bc_cofins_"             => $nfe->fields['ef_bc']
        ,"vl_aliq_cofins_"           => "0,00"
        ,"vl_cofins_"                => $nfe->fields['ef_v_cofins']
        ,"vl_icms_deson_"            => $nfe->fields['ef_v_icms_deson']
        ,"vl_fcp_"                   => $nfe->fields['ef_v_fcp']
        ,"vl_icms_fcp_"              => "0,00"
        ,"vl_icms_inter_uf_dest_"    => "0,00"
        ,"vl_icms_inter_uf_rem_"     => "0,00"
        ,"vl_bc_icms_st_"            => $nfe->fields['ef_bc_sit_trib']
        ,"vl_icms_subst_"            => $nfe->fields['ef_v_sit_trib']
        ,"vl_fcp_retido_st_"         => "0,00"
        ,"vl_retido_ant_st_"         => "0,00"
        ,"mod_frete_transp_"         => $nfe->fields['ef_modo_frete']
        ,"cpf_cnpj_transp_"          => $nfe->fields['ef_cnpj_transp']
        ,"razao_social_transp_"      => $nfe->fields['ef_razao_social_transp']
        ,"info_adicionais_"			 => $nfe->fields['ef_inf_adic']
        ,"item"                      => $arr_item
    );
    
    print json_encode($return);
}

//print "<pre>"; print_r($nfe);
//exit;