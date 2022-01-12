
<style>
    legend{
        font-size: 13px;                        
        font-weight: bold;
        color: #808080;
        /* style | color */
        border-bottom: 2px outset #DCDCDC;
    }
    .circulo{        
        border-radius: 50%;
        display: inline-block;
        height: 26px;
        width: 26px;
        /* margin: 2px 2px 2px 2px; */
        border: 1px solid #C0C0C0;
        background-color: #C0C0C0;        
    }
</style>
<link rel="stylesheet" type="text/css" href="./DataTables/datatables.min.css"/>
<section class="content">
    <div class="card body-view">
        <div class="card-header">          
            <div class="row">
                <div class="col-sm-12"> 
                    <button class="btn btn-info" id="btnConsultar" name="btnConsultar"><span class="fas fa-cloud-upload-alt"></span> Consultar </button>
                    <button class="btn btn-info" id="btnPesquisas" name="btnPesquisas"><span class="fas fa-search	"></span> Pesquisas </button>
                </div>                
            </div>            
        </div> 
        <div class="card-body">
            <form action="<?= $_SERVER['localhost']?>/mmflow/_man/manutencao/mainAdmSubMenus.php" method="post" id="frmDados">
                <div id="div_pesquisas" name="div_pesquisas" class="escondido">
                    <div class="form-group pull-left col-lg-6 col-md-6 col-sm-6">                    
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default btn-sm">
                                <input type="radio" name="tipo_pesq" value="pesq_simples" autocomplete="off" checked> Pesquisa
                            </label>
                            <label class="btn btn-default btn-sm">
                                <input type="radio" name="tipo_pesq" value="pesq_avancada" autocomplete="off"> Pesquisa Avançada
                            </label>
                        </div>
                    </div>
                    <div class="row form-group div_pesq_simples">
                        <fieldset class="row form-group col-sm-12">
                            <legend > INFORMAÇÕES GERIAS DO DOCUMENTO  </legend>
                            <div class="col-sm-2">
                                <label for="numero_nfe" >Número NFe:</label>
                                <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="Número NFe" />
                            </div>
                            <div class="col-sm-5">
                                <label for="chave_acesso_nfe" >Chave de Acesso:</label>
                                <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="Chave de Acesso" />
                            </div>
                            <div class="col-sm-2">
                                <label for="data_receb_nfe">Data de Recebimento:</label>
                                <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class="btn btn-info" id="btnBusca" style="margin-top:30px;">
                                    <span class="fas fa-search"></span>
                                    Pesquisar
                                </button>                  
                            </div>
                        </fieldset>
                    </div>
                    <div class="row div_pesq_avancada escondido">
                        <fieldset class="row form-group col-sm-12">
                            <legend> INFORMAÇÕES GERIAS DO DOCUMENTO  </legend>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-4">
                                    <label for="chave_acesso_nfe" >Chave de Acesso:</label>
                                    <input type="text" class="form-control" id="chave_acesso_nfe" name="chave_acesso_nfe" placeholder="Chave de Acesso" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Número NFe:</label>
                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Série:</label>
                                    <input type="text" class="form-control" id="numero_nfe" name="numero_nfe" placeholder="" />
                                </div>                            
                                <div class="col-sm-2">
                                    <label for="data_receb_nfe">Data Receb.(Inicial):</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div> 
                                <div class="col-sm-2">
                                    <label for="data_receb_nfe">Data Receb.(Final):</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                            </div>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Ambiente:</label>
                                    <select type="text" class="form-control" id="numero_nfe" name="numero_nfe">
                                        <option>Selecione</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Tipo da Nota:</label>
                                    <select type="text" class="form-control" id="numero_nfe" name="numero_nfe">
                                        <option>Selecione</option>
                                    </select>
                                </div> 
                                <div class="col-sm-4">
                                    <label for="data_receb_nfe">Natureza da Operação:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-2">
                                    <label for="data_receb_nfe">Data Emissão:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>   
                                <div class="col-sm-2">
                                    <label for="numero_nfe">Situação:</label>
                                    <select type="text" class="form-control" id="numero_nfe" name="numero_nfe">
                                        <option>Selecione</option>
                                    </select>
                                </div>                         
                            </div>
                        </fieldset>
                        <fieldset class="row form-group col-sm-12">
                            <legend> EMPRESA </legend>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-4">
                                    <label for="numero_nfe">CPF/CNPJ:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-8">
                                    <label for="numero_nfe">Razão Social:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>                            
                            </div>                                        
                        </fieldset>
                        <fieldset class="row form-group col-sm-12">
                            <legend> TRANSPORTADORA </legend>
                            <div class="row form-group col-lg-12">
                                <div class="col-sm-4">
                                    <label for="numero_nfe">CPF/CNPJ:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>
                                <div class="col-sm-8">
                                    <label for="numero_nfe">Razão Social:</label>
                                    <input type="text" class="form-control" id="data_receb_nfe" name="data_receb_nfe" placeholder="Data Recebimento" />
                                </div>                            
                            </div>                                        
                        </fieldset>
                        <div class="row">                        
                            <button type="submit" class="btn btn-info pull-right" id="btnBusca" style="margin-top:30px;">
                                <span class="fas fa-search"></span>
                                Pesquisar
                            </button>                                          
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped" id="table_lista_notas">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="checkAll" id="checkAll" width="03%"></th>
                            <th class="text-center" width="23%">Emitente        </th>                            
                            <th class="text-center" width="08%">Número/Série    </th>
                            <th class="text-center" width="07%">Valor           </th>
                            <th class="text-center" width="09%">Origem          </th>
                            <th class="text-center" width="09%">Emissão         </th>
                            <th class="text-center" width="10%">Status          </th>
                            <th class="text-center" width="09%">Registro        </th>
                            <th class="text-center" width="09%">Recebimento     </th>
                            <th class="text-center" width="13%">Opções          </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            for ( $x=0; $x <= 50; $x++ ){
                                print '
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="checkbox" class="check_nota"></td>
                                    <td> 466.88.398-07 Tamara Maria  </td>                                    
                                    <td> 99192-123 </td>
                                    <td> R$ 1.000,00</td>
                                    <td>  </td>
                                    <td>  </td>
                                    <td></td>
                                    <td>  </td>
                                    <td>  </td>                                    
                                    <td>
                                        <div class="row col-sm-12">
                                            <div class="col-sm-2 openDetalhes"><span class="fas fa-search openDetalhes"></span></div>
                                            <div class="col-sm-2"><span class="fas fa-tags"></span></div>
                                            <div class="col-sm-2"><span class="far fa-paper-plane"></span></div>
                                            <div class="col-sm-2"><span class="far fa-map"></span></div>
                                            <div class="col-sm-2"><span class="fas fa-cloud-upload-alt"></span></div>
                                            <div class="col-sm-2"><span class="fas fa-heartbeat"></span></div>
                                        </div>
                                    </td>
                                </tr>';
                            }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
      <!-- /.card-body -->
      <div class="card-footer  align-content-center">
          <div class="row">          
              <?php if ( $_SESSION['op'] == "insert" || $_SESSION['op'] == "edit" ){ ?>
              <div class="col-sm-2 ">                  
                <button type="button" class="btn btn-primary form-control" id="btnSalvar">
                    <span class="fas fa-save"></span>
                    Salvar
                </button>                  
             </div>
              <?php } ?>
              <?php if ( $_SESSION['op'] == "delete" ){ ?>
                  <div class="col-sm-2 ">                  
                    <button type="button" class="btn btn-danger form-control" id="btnExcluir">
                        <span class="fas fa-trash"></span>
                        Excluir
                    </button>                  
                 </div>
              <?php } ?>
              <div class="col-sm-2 ">                  
                <button type="button" class="btn btn-warning " id="btnVoltar" onclick="movPage('adm_submenus','','', 'movimentacao','','')">
                    <span class="fas fa-retweet"></span>
                    Voltar
                </button>                  
             </div>                              
        </div>
      </div>
      <!-- /.card-footer-->
    </div>
</section>

<!-- /.modal -->
<?php include_once './_import/modals.php'; ?>
<script type="text/javascript" charset="utf8" src="./DataTables/datatables.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){    
    /* valida método de pesquisa */
    $("[name='tipo_pesq']").on("change", function(){         
        if( $(this).val() == "pesq_simples" ){
            $(".div_pesq_avancada").hide();             
            $(".div_pesq_simples").show();                               
        }
        else{
            $(".div_pesq_simples").hide();             
            $(".div_pesq_avancada").show();            
        }
    });

    /* aplica DataTable na tabela. */
    new DataTable( '#table_lista_notas', {
        paging: false,
        scrollY: 500
    } );

    /* valida checkbox "checkar/descheckar" */
    $("#checkAll").on("click",function(){
        if($(this).is(":checked")){
            $(".check_nota").prop("checked",true);
        }else{
            $(".check_nota").prop("checked",false);
        }
    });

    $(document).on("click", ".openDetalhes", function (){
        $("#modalDetalhesNota").modal("show");
    });

    /** validação btnPesquisas */
    $("#btnPesquisas").on("click",function(){
        if($("#div_pesquisas").hasClass('escondido')){
            $("#div_pesquisas").removeClass("escondido");
        }else{         
            $("#div_pesquisas").addClass("escondido");
        }
    });
    //$("#modalDetalhesNota").modal("show");
});    
</script>