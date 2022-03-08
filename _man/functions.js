function salvar(ret) {
    $.ajax({
        url: $("#frmDados").prop("action"),
        method: "post",
        dataType: "text",
        data: $("#frmDados").serialize(),
        error: function () {
            $("#mensagem_erro").html("Ocorreu um erro imprevisto ao enviar os dados para o banco. Por favor, contate o administrador do sistema.");
            $("#modal_erro").modal("show");
        },
        success: function (retorno) {                        
            if (retorno == "OK") {
                $("#modal_success").modal("show");
                setTimeout(function () {
                    $("#modal_success").modal("hide");
                    location.href = "" + ret;
                }, 500);
            } else {
                $("#mensagem_erro").html("Não foi possível completar a operação, tente novamente!<br/><br/>" + retorno.mensagem);
                $("#modal_erro").modal("show");
            }
        }
    });
    return false;
}

/**
 * Conferimos os valores que serão enviados para o banco
 * @returns {String}
 */
function validateSave(page) {
    $(this).prop("disabled",true);
    $.ajax({
        url: "./_man/validateData.php",
        method: "post",
        dataType: "text",
        data: {
            dados: $(".requeri").serialize(),
            validate: "liberaBtnSalvar"
        },
        success: function (retorno) {
            console.log( retorno );
            if (retorno == "OK") {
                
                console.log( "retorno " + retorno );
                
                salvar(page);
            } else {
                $("#titulo_modal_erro").html("Ainda faltam itens a serem preenchidos!");
                $("#modal_erro").modal("show");
            }
        }
    });
}

function retornaEmpresas(cnpj){    
    $.ajax({
        url: "/mmflow/_man/search/_searchSelect.php",
        method: "post",
        dataType: "json",
        data: {
            busca : "t_empresas",
            cnpj  : cnpj
        },
        success: function (retorno) {
            if (retorno.dados[0]['status'] == "OK") {
                $("#empresa_modal").html(retorno.dados[0]['html']);                
            }
       }
    });
    return false;   
}

function login() {
    $.ajax({
        url: $("#frmDados").prop("action"),
        method: "post",
        dataType: "text",
        data: $("#frmDados").serialize(),
        success: function (retorno) {
            
            retornaEmpresas($("#cnpj").val());
            
            if (retorno == "OK") {
                //location.href = "menu_sys.php";                
                $("#modal_empresas").modal("show");
            } else {
                alert('Usuario e/ou senha incorreto(s)');
                location.href = "index.php";
            }
        }
    });
    return false;
}

function movPage(destino, op, id, tipo, menu, submenu) {
    $.ajax({
        url: './_man/movePages.php',
        method: "post",
        dataType: "text",
        data: {
            xDestino: destino,
            xOp: op,
            xId: id,
            tipo: tipo,
            xMenu: menu,
            xSubmenu: submenu,
            xBuscas: $(".buscas").serialize()
        },
        success: function (retorno) {
            location.reload();
        }
    });
    return false;
}

function exit() {
    $.ajax({
        url: 'sair.php',
        method: "post",
        dataType: "text",
        success: function () {
            location.reload();
        }
    });
    return false;
}

function validaData(v1, v2, v3, v4, v) {
    $.ajax({
        url: './_man/validateData.php',
        method: "post",
        dataType: "text",
        data: {
            table: v1,
            params: v2,
            method: v3,
            data: v4,
            validate: v
        },
        success: function (retorno) {
            if (retorno == 0) {
                $("input, button").prop("disabled", false);
            } else {
                $("input, button").prop("disabled", true);
                $("#" + v2).prop("disabled", false);
                $("#titulo_modal_erro").text("Registro em duplicidade!")
                $("#modal_erro").modal("show");
                confirm("Registro em Duplicidade, corrija!");
            }
        }
    });
}

function selecionaEmpresa(retorno) {
    
    retornaEmpresas(retorno);
    
    $.ajax({
        url: "./_man/validaLogin.php",
        method: "post",
        dataType: "text",
        data: {
            op: "troca_empresa",
            empresas: $("#empresa_modal option:selected").val(),
            empresas_desc: $("#empresa_modal option:selected").text(),
        },
        success: function (retorno) {
            console.log( retorno );
            if (retorno == "login") {
                setTimeout(function () {
                    $("#modal_empresas").modal("hide");
                    location.href = "menu_sys.php";
                }, 500);
            } else {
                location.reload();
            }

        }
    });
    return false;
}

/* Inicializa a mascara de telefone */
function mphone(v) {    
    var r = v.replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
      r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (r.length > 5) {
      r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (r.length > 2) {
      r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
    } else {
      r = r.replace(/^(\d*)/, "($1");
    }
    return r;
}

function maskphone(o, f) {
    setTimeout(function() {
        var v = mphone(o.value);
        if (v != o.value) {
          o.value = v;
        }
    }, 1);
}
/* Fim */

/* Inicializa a mascara de cpf ou cnpj */
function mcpfcnpj(v) {
    var r = v.replace(/\D/g, "");
    r = r.replace(/^/, "");
    
    if (r.length > 11) {
        r = r.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2}).*/, "$1.$2.$3/$4-$5");
    } else  {
        r = r.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, "$1.$2.$3-$4");
    }
    return r;
}

function maskcpfcnpj(o, f) {
    setTimeout(function() {
        var v = mcpfcnpj(o.value);
        if (v != o.value) {
          o.value = v;
        }
    }, 1);
}
/* Fim */

function btnSalvar(manutencao,parametros,pagina){
    $.ajax({
        url: './_man/manutencao/'+manutencao,
        method: "post",
        dataType: "text",
        data: parametros,
        success: function (data) {
            retorno(pagina);
        }
    });
}

function retorno(pagina){
    if( pagina == "chamados" ){
        location.reload();
    }
}