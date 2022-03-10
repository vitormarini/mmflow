<!-- Modal de Sucesso -->
<div id="modal_success" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_success" aria-hidden="true">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-body">
                <div class="margin-bottom-10">           
                    <h2 class="modal-title text-center text-success" id="titulo_modal_success">Operação realizada com sucesso!</h2>
                </div>
            </div>

        </div>
    </div>
</div>   

<!-- Modal de Erro Personalizado -->
<div id="modal_erro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="titulo_modal_erro" aria-hidden="true">
    <div class="modal-dialog">        
        <div class="modal-content">
            <div class="modal-body">
                <div class="margin-bottom-10">           
                    <h2 class="modal-title text-center" id="titulo_modal_erro">Ops! Parece que temos um problema...</h2>
                </div>
                <div>              
                    <div id="mensagem_erro" class="text-danger text-justify"></div>                
                </div>
                <div class="margin-top-10 text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
</div>    

<!-- MODAL DAS EMPRESAS -->
<div class="modal fade" id="modal_empresas" name="modal_empresas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ESCOLHA EMPRESA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">                
                <div class="col-lg-12">                    
                    <select class="form-control" id="empresa_modal" name="empresa_modal"></select>
                </div>                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="btnContinuar" name="btnContinuar">Continuar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- MODAL PARA AVISOS OU CONFIRMAÇÃO -->
<div class="modal fade" id="modal_geral" name="modal_geral" aria-hidden="true" role="dialog" aria-labelledby="titulo_modal_geral">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center" id="titulo_modal_geral"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="div_body" name="div_body">                
                                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>        
    </div>
</div>

<!-- modal visualiza nota -->
<div class="modal fade" id="modalDetalhesNota" name="modalDetalhesNota">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-center">Detalhes NF-e</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <fieldset>
                            <legend> DADOS GERAIS </legend>
                            <div class="row form-group col-lg-12">                                                
                                <div class="col-sm-9">
                                    <label for="chave_acesso_nfe" >Chave de Acesso:</label>
                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="Chave de Acesso" />
                                </div>
                                <div class="col-sm-3">
                                    <label for="numero_nfe">Número:</label>
                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                </div>                                                
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dados-gerais-tab" data-toggle="pill" href="#dados-gerais" role="tab" aria-controls="dados-gerais" aria-selected="true"> NFe </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-emitente-tab" data-toggle="pill" href="#dados-emitente" role="tab" aria-controls="dados-emitente" aria-selected="false"> Emitente </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-produtos-servicos-tab" data-toggle="pill" href="#dados-produtos-servicos" role="tab" aria-controls="dados-produtos-servicos" aria-selected="false"> Produtos/Serviços </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-totais-tab" data-toggle="pill" href="#dados-totais" role="tab" aria-controls="dados-totais" aria-selected="false"> Totais </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-transporte-tab" data-toggle="pill" href="#dados-transporte" role="tab" aria-controls="dados-transporte" aria-selected="false"> Transporte </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-duplicata-tab" data-toggle="pill" href="#dados-duplicata" role="tab" aria-controls="dados-duplicata" aria-selected="false"> Duplicata </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="dados-info-gerais-tab" data-toggle="pill" href="#dados-info-gerais" role="tab" aria-controls="dados-info-gerais" aria-selected="false"> Informações Gerais </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="dados-gerais" role="tabpanel" aria-labelledby="dados-gerais-tab">
                                        <fieldset>
                                            <legend> Dados da NF-e </legend>
                                            <div class="row form-group col-lg-12">
                                                
                                                <div class="col-sm-2">
                                                    <label for="chave_acesso_nfe"> Modelo: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="numero_nfe">Série:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="numero_nfe">Data de Emissão:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>                            
                                                <div class="col-sm-3">
                                                    <label for="data_receb_nfe">Data Saída/Entrada:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div> 
                                                <div class="col-sm-2">
                                                    <label for="data_receb_nfe">Valor Total da NFe:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <legend> Emitente </legend>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-3">
                                                    <label for="chave_acesso_nfe"> CPF/CNPJ: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="numero_nfe">Nome/Razão Social:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="numero_nfe">Inscrição Estadual:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>                            
                                                <div class="col-sm-1">
                                                    <label for="data_receb_nfe">UF:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                                                                                    
                                            </div>                                            
                                        </fieldset>
                                        <fieldset>
                                            <legend> Destinatário </legend>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-3">
                                                    <label for="chave_acesso_nfe"> CPF/CNPJ: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="numero_nfe">Nome/Razão Social:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="chave_acesso_nfe"> Consumidor final: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-5">
                                                    <label for="chave_acesso_nfe"> Endereço: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="numero_nfe">Bairro/Distrito:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="numero_nfe">CEP:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-5">
                                                    <label for="data_receb_nfe">Município:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>
                                                
                                                <div class="col-sm-2">
                                                    <label for="chave_acesso_nfe"> Telefone: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-1">
                                                    <label for="numero_nfe">UF:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="numero_nfe">País:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>                                                                                                                        
                                            </div>                                             
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-4">
                                                    <label for="data_receb_nfe">Indicador IE:</label>
                                                    <select type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" >
                                                        <option>Selecione</option>
                                                    </select>
                                                </div>                                       
                                                <div class="col-sm-2">
                                                    <label for="data_receb_nfe">Inscrição Estadual:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                             
                                                <div class="col-sm-2">
                                                    <label for="data_receb_nfe">Inscrição SUFRAMA:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                             
                                                <div class="col-sm-4">
                                                    <label for="data_receb_nfe">E-mail:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                             
                                            </div>                                             
                                        </fieldset>
                                        <fieldset>
                                            <legend> Emissão </legend>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-2">
                                                    <label for="chave_acesso_nfe"> Tipo de Emissão: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="numero_nfe"> Finalidade:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="numero_nfe">Natureza de Operação:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>                            
                                                <div class="col-sm-2">
                                                    <label for="data_receb_nfe">Tipo de Operação :</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                                                                                    
                                            </div>                                            
                                        </fieldset>
                                    </div>
                                    <div class="tab-pane fade" id="dados-emitente" role="tabpanel" aria-labelledby="dados-emitente-tab">
                                        <fieldset>
                                            <legend> Emitente </legend>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-3">
                                                    <label for="chave_acesso_nfe"> CPF/CNPJ: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="numero_nfe">Nome/Razão Social:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="numero_nfe">Inscrição Estadual:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>                            
                                                <div class="col-sm-1">
                                                    <label for="data_receb_nfe">UF:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                                                                                    
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-5">
                                                    <label for="chave_acesso_nfe"> Endereço: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="numero_nfe">Bairro/Distrito:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="numero_nfe">CEP:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                            </div>
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-4">
                                                    <label for="data_receb_nfe">Município:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>
                                                
                                                <div class="col-sm-2">
                                                    <label for="chave_acesso_nfe"> Telefone: </label>
                                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-1">
                                                    <label for="numero_nfe">UF:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="numero_nfe">País:</label>
                                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                                </div>                  
                                                <div class="col-sm-2">
                                                    <label for="data_receb_nfe">Inscrição Estadual:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div> 
                                            </div> 
                                            <div class="row form-group col-lg-12">
                                                <div class="col-sm-3">
                                                    <label for="data_receb_nfe">IE do Substituto Tributário:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                                                                                    
                                                <div class="col-sm-3">
                                                    <label for="data_receb_nfe">Inscrição Municipal:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                                                                   
                                                <div class="col-sm-3">
                                                    <label for="data_receb_nfe">CNAE Fiscal:</label>
                                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="" />
                                                </div>                                                                                                    
                                                <div class="col-sm-3">
                                                    <label for="data_receb_nfe">Código de Regime Tributário:</label>
                                                    <select class="form-control" id="data_receb_nfe" name="data_receb_nfe">
                                                        <option value=""> SELECIONE </option>
                                                        <option value="1"> 1 - Simples Nacional </option>
                                                        <option value="2"> 2 - Simples Nacional - excesso de sublimite da receita bruta</option>
                                                        <option value="3"> 3 - Regime Nacional </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>                                    
                                    <div class="tab-pane fade" id="dados-produtos-servicos" role="tabpanel" aria-labelledby="dados-produtos-servicos-tab">
                                        <div class="row form-group col-lg-12">                                            
                                            <div class="header">Aguardando</div>   
                                            <table cellspacing="0" class="table">
                                                <tr>
                                                    <th>Leito</th>
                                                    <th>Acomodação</th>
                                                    <th>Tempo</th>
                                                    <th>Tipo</th>
                                                    <th width="230">Comentário</th>
                                                </tr>
                                                <tr>
                                                    <td style=" font-size: 3em;">321</td>
                                                    <td>Apartamento</td>
                                                    <td>10:01</td>
                                                    <td>Clínico</td>
                                                    <td>TESTE</td>
                                                </tr>
                                                <tr>
                                                    <td style=" font-size: 3em;">412</td>
                                                    <td>Apartamento</td>
                                                    <td>10:01</td>
                                                    <td>Clínico</td>
                                                    <td>TESTE</td>
                                                </tr>
                                                <tr>
                                                    <td style=" font-size: 3em;">110</td>
                                                    <td>Enfermaria</td>
                                                    <td>10:01</td>
                                                    <td>Cirurgico</td>
                                                    <td>TESTE</td>
                                                </tr>      
                                                <tr>
                                                    <td style=" font-size: 3em;">215</td>
                                                    <td>Isolamento</td>
                                                    <td>10:01</td>
                                                    <td>Cirurgico</td>
                                                    <td>TESTE</td>
                                                </tr>
                                            </table>
                                        </div>
                                            
                                            <!--    <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="05%"> #                  </th>
                                                        <th class="text-center" width="10%"> Código             </th>
                                                        <th class="text-center" width="45%"> Descrição          </th>
                                                        <th class="text-center" width="10%"> Unid Comercial     </th>
                                                        <th class="text-center" width="10%"> Quantidade         </th>
                                                        <th class="text-center" width="10%"> Valor Unit.        </th>                                                        
                                                        <th class="text-center" width="10%"> Valor              </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td> 1 </td>
                                                        <td> COD </td>
                                                        <td> COD </td>
                                                        <td> DESC </td>
                                                        <td> UNI </td>
                                                        <td> 10 </td>
                                                        <td> 1 </td>
                                                        <td> 10 </td>
                                                    </tr>
                                                </tbody>
                                            </table>-->
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dados-totais" role="tabpanel" aria-labelledby="dados-totais-tab">
                                        <div class="row form-group col-lg-12">
                                            <fieldset class="col-lg-12">
                                                <legend> ICMS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="m_outras_icms">O. Desp. Acessórias:</label>
                                                        <input type="text" class="form-control" id="m_outras_icms" name="m_outras_icms" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_isento_icms">Valor do Frete:</label>
                                                        <input type="text" class="form-control" id="m_isento_icms" name="m_isento_icms" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_isento_icms">Valor do Seguro:</label>
                                                        <input type="text" class="form-control" id="m_isento_icms" name="m_isento_icms" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_aliq_icms">Valor Total dos Prod.:</label>
                                                        <input type="text" class="form-control" id="m_aliq_icms" name="m_aliq_icms" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_bc_icms"> Valor Total da NFe: </label>
                                                        <input type="text" class="form-control" id="m_bc_icms" name="m_bc_icms" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_valor_icms">V. Aprox  dos Tributos:</label>
                                                        <input type="text" class="form-control" id="m_valor_icms" name="m_valor_icms" placeholder="" />
                                                    </div>
                                                </div>   
                                            </fieldset>
                                            <fieldset class="col-lg-12">
                                                <legend> ICMS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="m_bc_icms"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="m_bc_icms" name="m_bc_icms" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_aliq_icms">Alíquota:</label>
                                                        <input type="text" class="form-control" id="m_aliq_icms" name="m_aliq_icms" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_valor_icms">Valor:</label>
                                                        <input type="text" class="form-control" id="m_valor_icms" name="m_valor_icms" placeholder="" />
                                                    </div>                            
                                                    <div class="col-sm-2">
                                                        <label for="m_outras_icms">Outras:</label>
                                                        <input type="text" class="form-control" id="m_outras_icms" name="m_outras_icms" placeholder="" />
                                                    </div>                                                                                                    
                                                    <div class="col-sm-2">
                                                        <label for="m_isento_icms">Isento:</label>
                                                        <input type="text" class="form-control" id="m_isento_icms" name="m_isento_icms" placeholder="" />
                                                    </div>                                                                                                    
                                                </div>   
                                            </fieldset>
                                            <fieldset class="col-lg-12">
                                                <legend> IPI </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="m_bc_ipi"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="m_bc_ipi" name="m_bc_ipi" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_aliq_ipi">Alíquota:</label>
                                                        <input type="text" class="form-control" id="m_aliq_ipi" name="m_aliq_ipi" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_valor_ipi">Valor:</label>
                                                        <input type="text" class="form-control" id="m_valor_ipi" name="m_valor_ipi" placeholder="" />
                                                    </div>                            
                                                    <div class="col-sm-2">
                                                        <label for="m_outras_ipi">Outras:</label>
                                                        <input type="text" class="form-control" id="m_outras_ipi" name="m_outras_ipi" placeholder="" />
                                                    </div>                                                                                                    
                                                    <div class="col-sm-2">
                                                        <label for="m_isento_ipi">Isento:</label>
                                                        <input type="text" class="form-control" id="m_isento_ipi" name="m_isento_ipi" placeholder="" />
                                                    </div>                                                                                                    
                                                </div>                                            
                                            </fieldset>
                                            <fieldset class="col-lg-6">
                                                <legend> PIS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-4">
                                                        <label for="m_bc_pis"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="m_bc_pis" name="m_bc_pis" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="m_aliq_pis">Alíquota:</label>
                                                        <input type="text" class="form-control" id="m_aliq_pis" name="m_aliq_pis" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-4 fix-right">
                                                        <label for="m_valor_pis">Valor:</label>
                                                        <input type="text" class="form-control" id="m_valor_pis" name="m_valor_pis" placeholder="" />
                                                    </div>
                                                </div>                                            
                                            </fieldset>
                                            <fieldset class="col-lg-6">
                                                <legend> COFINS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-4">
                                                        <label for="m_bc_cofins"> Base de Cálculo: </label>
                                                        <input type="text" class="form-control" id="m_bc_cofins" name="m_bc_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="m_aliq_cofins">Alíquota:</label>
                                                        <input type="text" class="form-control" id="m_aliq_cofins" name="m_aliq_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <label for="m_valor_cofins">Valor:</label>
                                                        <input type="text" class="form-control" id="m_valor_cofins" name="m_valor_cofins" placeholder="" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="col-lg-12">
                                                <legend> OUTROS </legend>
                                                <div class="row form-group col-lg-12">
                                                    <div class="col-sm-2">
                                                        <label for="m_bc_cofins"> ICMS Desonerado: </label>
                                                        <input type="text" class="form-control" id="m_bc_cofins" name="m_bc_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_aliq_cofins"> FCP:</label>
                                                        <input type="text" class="form-control" id="m_aliq_cofins" name="m_aliq_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_valor_cofins"> ICMS FCP:</label>
                                                        <input type="text" class="form-control" id="m_valor_cofins" name="m_valor_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="m_bc_cofins"> ICMS Interestadual UF Destino: </label>
                                                        <input type="text" class="form-control" id="m_bc_cofins" name="m_bc_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="m_aliq_cofins"> ICMS Interestadual UF Rem.:</label>
                                                        <input type="text" class="form-control" id="m_aliq_cofins" name="m_aliq_cofins" placeholder="" />
                                                    </div>
                                                </div>
                                                <div class="row form-group col-lg-12">                                                    
                                                    <div class="col-sm-2">
                                                        <label for="m_valor_cofins">B. de Cálculo ICMS ST:</label>
                                                        <input type="text" class="form-control" id="m_valor_cofins" name="m_valor_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_bc_cofins"> ICMS Substituição: </label>
                                                        <input type="text" class="form-control" id="m_bc_cofins" name="m_bc_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <label for="m_aliq_cofins">FCP retido por ST:</label>
                                                        <input type="text" class="form-control" id="m_aliq_cofins" name="m_aliq_cofins" placeholder="" />
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="m_valor_cofins">FCP retido anteriormente por ST:</label>
                                                        <input type="text" class="form-control" id="m_valor_cofins" name="m_valor_cofins" placeholder="" />
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div> 
                                    </div>
                                    <div class="tab-pane fade" id="dados-transporte" role="tabpanel" aria-labelledby="dados-transporte-tab">
                                        <div class="row form-group col-lg-12">
                                            <fieldset class="col-lg-12">                                                 
                                                <legend class="col-lg-12"> DADOS DO TRANSPORTE </legend>
                                                <div class="row form-group col-lg-12">                                                    
                                                    <div class="col-sm-4">
                                                        <label for="m_mod_frete_transp">Modalidade do Frete:</label>
                                                        <select type="text" class="form-control" id="m_mod_frete_transp" name="m_mod_frete_transp">
                                                            <option value="" > Selecione                                                  </option>
                                                            <option value="0"> 0 - Contratação do Frete por conta do Remetente (CIF);     </option>
                                                            <option value="1"> 1 - Contratação do Frete por conta do Destinatário (FOB);  </option>
                                                            <option value="2"> 2 - Contratação do Frete por conta de Terceiros;           </option>
                                                            <option value="3"> 3 - Transporte Próprio por conta do Remetente;             </option>
                                                            <option value="4"> 4 - Transporte Próprio por conta do Destinatário;          </option>
                                                            <option value="9"> 9 - Sem Ocorrência de Transporte.                          </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="m_cpf_cnpj_transp"> CPF/CNPJ: </label>
                                                        <input type="text" class="form-control" id="m_cpf_cnpj_transp" name="m_cpf_cnpj_transp"/>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <label for="m_razao_social_transp"> Razão Social:</label>
                                                        <input type="text" class="form-control" id="m_razao_social_transp" name="m_razao_social_transp"/>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="dados-duplicata" role="tabpanel" aria-labelledby="dados-duplicata-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dados-info-gerais" role="tabpanel" aria-labelledby="dados-info-gerais-tab">
                                        <div class="row form-group col-lg-12">
                                            <fieldset class="col-lg-12">  
                                                <legend class="col-lg-12"> INFORMAÇÕES ADICIONAIS </legend>                                                                                                    
                                                <textarea type="text" class="form-control" id="m_info_adicionais" name="m_info_adicionais" rows="5"></textarea>                                                                                                 
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->