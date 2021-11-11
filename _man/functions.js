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

    $.ajax({
        url: "./_man/validateData.php",
        method: "post",
        dataType: "text",
        data: {
            dados: $(".requeri").serialize(),
            validate: "liberaBtnSalvar"
        },
        success: function (retorno) {

            if (retorno == "OK") {
                salvar(page);
            } else {
                $("#titulo_modal_erro").html("Ainda faltam itens a serem preenchidos!");
                $("#modal_erro").modal("show");
            }

        }
    });

}

function login() {
    $.ajax({
        url: $("#frmDados").prop("action"),
        method: "post",
        dataType: "text",
        data: $("#frmDados").serialize(),
        success: function (retorno) {
            if (retorno == "OK") {
                location.href = "menu_sys.php";
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