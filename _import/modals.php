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
                    <select class="form-control" id="empresa_modal" name="empresa_modal">
                        <option value="1"> 1 - Humana Alimentar </option>                        
                    </select>
                </div>                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnContinuar" name="btnContinuar">Continuar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="dados-gerais-tab" data-toggle="pill" href="#dados-gerais" role="tab" aria-controls="dados-gerais" aria-selected="true"> Dados Gerais </a>
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
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dados-produtos-servicos" role="tabpanel" aria-labelledby="dados-produtos-servicos-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dados-totais" role="tabpanel" aria-labelledby="dados-totais-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dados-transporte" role="tabpanel" aria-labelledby="dados-transporte-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dados-duplicata" role="tabpanel" aria-labelledby="dados-duplicata-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="dados-info-gerais" role="tabpanel" aria-labelledby="dados-info-gerais-tab">
                                        
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