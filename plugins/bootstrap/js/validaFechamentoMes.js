/*
 * Criado por: Tamara Vindilino
 * Data: 16/06/2020
 * Rotina onde retorna as validações da pagina em relação a data do fechamento do mês;
 */

function validaFechamentoMes( rotina, url, data, operacao , tipo, nome_data){
    
//    console.log( "rotina - "    + rotina );
//    console.log( "url - "       + url );
//    console.log( "data - "      + data );
//    console.log( "operacao - "  + operacao );
//    console.log( "tipo - "      + tipo );
//    console.log( "nome_data - " + nome_data );
    
    if( tipo === "retorna_parametros" ){
        var data = "";
        var nome_data = "";
        
        /* ENTRADA NOTA */
        if( nome[0] === "entrada_nota_new" ){
            if( $("#data_fechamento").val() !== "" && $("#op").val() == "v" ){
                data    = $("#data_fechamento").val();    
                nome_data = "data_fechamento";
                validaFechamentoMes("fechamento_notas", "entrada_nota", data, "v", "", nome_data);
            }
            
            $("#data_digitacao").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("fechamento_notas", "entrada_nota", data, "i", "", nome_data);
            });            
        }
        /* NOTA SERVIÇO */
        else if( nome[0] === "cadastro_nota_servico" || nome[0] === "cadastro_nota_servico_new"  ){
            if( $("#data_fechamento").val() !== "" && $("#op").val() == "v" ){
                data    = $("#data_fechamento").val();    
                nome_data = "data_fechamento";
                validaFechamentoMes("fechamento_notas", "nota_servico", $("#data_fechamento").val(), "v", "", nome_data);
            }

            $("#data_digitacao").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("fechamento_notas", "nota_servico", $("#data_digitacao").val(), "i", "", nome_data);
            });
        }
        /* NOTA DEVOLUCAO_SIMPLES */
        else if( nome[0] === "nota_devolucao_simples" ){
            $("#data_entrada").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;                
                validaFechamentoMes("fechamento_notas", "nota_devolucao_simples", data, "i", "", nome_data);
                console.log(data);
            });
        }
        /* NOTA DEVOLUÇÃO SEM ESTOQUE */
        else if( nome[0] === "notas_devolucao_s_estoque" ){
            if( $("#data_fechamento").val() !== "" && $("#op").val() == "v" ){     
                data    = $("#data_fechamento").val();    
                nome_data = "data_fechamento";
                validaFechamentoMes("fechamento_notas", "notas_devolucao_s_estoque", $("#data_fechamento").val(), "v", "", nome_data);
            }
        }
        /* NOTA GENERALIZADA */
        else if( nome[0] === "nota_generalizada" ){
            $("#data_emissao, #data_entrada_saida").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("fechamento_notas", "nota_generalizada", data, "i", "", nome_data);
            });
        }
        /* EMISSÃO NOTA COMPLEMENTAR */
        else if( nome[0] === "emissao_nota_complementar" ){
            $("#data_emissao, #data_entrada_saida, #data_digitacao").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;  
                validaFechamentoMes("fechamento_notas", "emissao_nota_complementar", data, "i", "", nome_data);
            });
        }        
        /* NOTA GENERALIZADA */
        else if( nome[0] === "emissao_nota_ciap" ){
            $("#data_emissao, #data_entrada_saida").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("fechamento_notas", "emissao_nota_ciap", data, "i", "", nome_data);
            });
        }
        /* EMISSAO NOTA VENDA MAT PRIMA */
        else if( nome[0] === "emissao_nota_venda_mat_prima" ){
            $("#data_emissao, #data_entrada_saida").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("fechamento_notas", "emissao_nota_venda_mat_prima", data, "i", "", nome_data);
            });
        }
        /* FATURAMENTOS */
        else if( nome[0] === "faturamento_compra" || nome[0] === "faturamento_venda" || nome[0] === "faturamento_devolucao" || nome[0] === "faturamento_importacao" || nome[0] === "faturamento_entrada" ){
            $("#data_emissao, #data_saida").on("change",function(e){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("fechamento_notas", "faturamento", data, "i", "", nome_data);
            });
        }
        /* TÍTULOS A RECEBER ---- VERIFICAR */
        else if( nome[0] === "cadastro_titulo_a_receber" ){
            $("#data_emissao").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("titulo", "cadastro_titulo_a_receber", data, "i", "", nome_data);
            });
        }
        /* TÍTULOS A PAGAR ---- VERIFICAR */
        else if( nome[0] === "cadastro_titulo_a_pagar" ){
            $("#data_emissao").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("titulo", "cadastro_titulo_a_pagar", data, "i", "", nome_data);
            });
        }
        /* LANÇAMENTO ---- VERIFICAR */
        else if( nome[0] === "lancamento_bancario" ){
            $("#data_lancamento,#data_ticagem").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                validaFechamentoMes("titulo", "lancamento_bancario", data, "i", "", nome_data);
            });
        }
        /* REQUISIÇÃO MATÉRIA PRIMA ---- VERIFICAR */
        else if( nome[0] === "cadastro_requisicao_materia_prima" ){
            if( $("#data_fechamento").val() !== "" && $("#op").val() == "v" ){
                data    = $("#data_fechamento").val();                                                   
                nome_data = "data_fechamento";
                validaFechamentoMes("requisicao", "cadastro_requisicao_materia_prima", data, "v", "", nome_data);
            }
            $("#data_cadastro").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                
                validaFechamentoMes("requisicao", "cadastro_requisicao_materia_prima", data, "i", "", nome_data);
            });
        }
        /* AJUSTE MATÉRIA PRIMA ---- VERIFICAR */
        else if( nome[0] === "ajuste_estoque_materia_prima" ){
            if( $("#data_fechamento").val() !== "" && $("#op").val() == "v" ){
                data    = $("#data_fechamento").val();                                                   
                nome_data = "data_fechamento";
                validaFechamentoMes("requisicao", "ajuste_estoque_materia_prima", data, "v", "", nome_data);
            }
            $("#data_cadastro").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                
                validaFechamentoMes("requisicao", "ajuste_estoque_materia_prima", data, "i", "", nome_data);
            });
        }
        /* TICAGEM TÍTULOS A PAGAR */
        else if( nome[0] === "ticagemTitulosAutomatica" ){
            $("#data_ticagem").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                
                validaFechamentoMes("titulo", "ticagemTitulosAutomatica", data, "i", "", nome_data);
            });
        }
        /* BAIXA TITULOS A PAGAR */
        else if( nome[0] === "baixa_titulo_a_pagar" || nome[0] === "baixa_total_titulo_a_pagar" ){
            $("#data_pagamento,#data_movimentacao").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                
                validaFechamentoMes("baixa_titulo_a_pagar", "baixa_titulo_a_pagar", data, "i", "", nome_data);
            });
        }        
        /* BAIXA TITULOS A RECEBER */
        else if( nome[0] === "baixa_titulo_a_receber" || nome[0] === "baixa_total_titulo_a_receber" ){
            $("#data_pagamento,#data_movimentacao").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                
                validaFechamentoMes("baixa_titulo_a_receber", "baixa_titulo_a_receber", data, "i", "", nome_data);
            });
        }
        /* BOLETIM  ---- VERIFICAR  */ 
        else if( nome[0] === "cadastro_boletim" ){
            $("#data_boletim_").on("change",function(){
                data    = $(this).val();    
                nome_data = this.id;
                
                validaFechamentoMes("boletim", "cadastro_boletim", data, "i", "", nome_data);
            });
        }
        
    }else{
        var op = $("#exclusao").val() == "S" ? "d" : "e";        
        /* VALIDA AS ROTINAS DAS NOTAS */
        if( rotina === "fechamento_notas" ){
            if( operacao === "v" ){
                if(url === "entrada_nota")                              redirecionamento = "entrada_nota_new&origem="+ $("#origem").val() +"&op=e&id=" + $("#id").val();
                else if(url === "nota_servico" )                        redirecionamento = "cadastro_nota_servico_new&origem="+ $("#origemEstoque").val() +"&op=c&id=" + $("#id_nota").val();
                else if(url === "notas_devolucao_s_estoque" )           redirecionamento = "notas_devolucao_s_estoque&op="+ op +"&id="+ $("#id").val() +"&filtro="+$("#filtro").val();                 
                
                $("#redirecionamento").val(redirecionamento);
                $("#modal_fechamento").modal("show");                
            }
        }else if( rotina === "requisicao" ){
            console.log("1 ");
            if( operacao === "v" ){
                if(url === "cadastro_requisicao_materia_prima" )   redirecionamento = "cadastro_requisicao_materia_prima&op=e&id="+ $("#id").val() ; 
                else if(url === "ajuste_estoque_materia_prima" )   redirecionamento = "ajuste_estoque_materia_prima&op=e&id="+ $("#id").val() ; 
                
                $("#redirecionamento").val(redirecionamento);
                $("#modal_fechamento").modal("show");
            }
        }
            
        
        $("#data").val(nome_data);
        $.ajax({
            url      : "manutencaoFechamentoMes.php",
            method   : "post",
            dataType : "json",
            data     : {
                op              : "verifica_fechamento",
                data_fechamento : data,
                rotina          : rotina,
                url             : nome[0]
            },
            success: function(retorno){
                if(retorno.status == "ERRO") {
//                    $("#redirecionamento").val("");
                    $("#modal_fechamento").modal("show");
                } 
            }
        });
    }
}