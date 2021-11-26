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