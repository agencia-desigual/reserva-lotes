// PUSH
var pusher = new Pusher('12119d4ea9fa000fbac7');
var atualizaLote = pusher.subscribe('lote_atualiza');


// Obj de dados
var Dados = {
    "Id_negociacao": 0,
    "lote": "",
    "etapa1": "",
    "etapa2": "",
    "cliente": "",
    "documentos": "",
    "financiamento": "",
    "valorEntrada": 0,
    "lote_etapa": "etapa1",
    "modal" : "",
    "tipo" : "",
    "ValorBalao" : 0,
    "ParcelaBalao" : 0,
    "tipoPessoa" : "fisica"
}



// Formata nomero com mascara de moeda
function formatMoney(number, places, symbol, thousand, decimal) {
	places = !isNaN(places = Math.abs(places)) ? places : 2;
	symbol = symbol !== undefined ? symbol : "$";
	thousand = thousand || ",";
	decimal = decimal || ".";
	var negative = number < 0 ? "-" : "",
	    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
	    j = (j = i.length) > 3 ? j % 3 : 0;
	return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
};



// Metodo de apoio, Abre um modal
function modais(modal, acao = null)
{
    if(acao == "fecha")
    {
        if(Dados.lote_etapa == "etapa2")
        {
            // Pergunta se realmente deseja cancelar
            Swal.fire({
                title: 'Deseja Fechar?',
                text: "Você não preencheu todos os dados necessários, deseja mesmo abandonar a reserva? Você poderá continuar de onde parou.",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sim, Desejo Fechar'
            }).then((result) => {
                if (result.value)
                {
                    fechaModal(modal);
                }
            });
        }
        else
        {
            fechaModal(modal);
        }
    }
    else
    {
        Dados.modal = modal;

        $("#" + modal).fadeIn();
    }
}




function fechaModal(modal)
{
    // Fecha as estapas
    $('#' + Dados.lote_etapa).css("display","none");

    $('#topo_etapa1').attr("class","active");
    $('#topo_etapa2').attr("class","");
    $('#topo_etapa3').attr("class","");

    $('#etapa1').css("display","block");


    // ZERA os dados
    Dados.lote = "";
    Dados.etapa1 = "";
    Dados.etapa2 = "";
    Dados.etapa3 = "";
    Dados.cliente = "";
    Dados.documentos = "";
    Dados.financiamento = "";
    Dados.valorEntrada = 0;
    Dados.Id_negociacao = 0;
    Dados.lote_etapa = "etapa1";
    Dados.modal = "";
    Dados.tipo = "";
    Dados.tipoPessoa = "fisica";
    Dados.ParcelaBalao = 0;
    Dados.ValorBalao = 0;


    // Limpa os forms
    $('#form_etapa1').each (function(){
        this.reset();
    });

    $('#form_etapa2').each (function(){
        this.reset();
    });

    // Limpa o modal
    $("#txt_valorFinanciado").html("R$ 0,00");
    $("#txt_valorParcela").html("R$ 0,00");
    $("#campoEntrada").val("");

    // Fecha o modal
    $("#" + modal).fadeOut();
}




function alteraEtapa(etapa)
{
    // Fecha as estapas
    $('#' + Dados.lote_etapa).css("display","none");
    $('#' + etapa).css("display","block");


    $('#topo_' + Dados.lote_etapa).attr("class","done");
    $('#topo_'+ etapa).attr("class","active");

    Dados.lote_etapa = etapa;
}



/** 
 *  ==========================================
 *    MÉTODOS REFERENTES A RESERVA E VENDA
 *  ==========================================
*/



// Metodo chamado ao clicar em um lote
// Verifica qual modal deve ser aberto 
// Adiciona as informações do lote no modal aberto
function abreModal(id) 
{
    // Variaveis
    var lote;

    // Session
    var session = new Session();
    var user = session.get("usuario");

    // Busca as informacoes sobre o lote 
    $.get(BASE_URL + "lote/get/" + id, "", function(data){
        
        if(data.tipo == true)
        {
            lote = data.objeto;
            Dados.lote = lote;

            // Verifica se o lote está livre
            if(lote.status === "livre")
            {
                $("#txt_bloco").html(lote.bloco);
                $("#txt_lote").html(lote.numeroLote);

                $("#txt_valorLote").html(formatMoney(lote.valor, 2,"R$",".",","));

                modais("modal_reserva", "abre");
            }
            else
            {
                Dados.Id_negociacao = lote.negociacao.Id_negociacao;

                if((user.Id_usuario === lote.negociacao.Id_usuario || user.nivel === "administrador") && lote.negociacao.cliente === false)
                {
                    $("#txt_bloco").html(lote.bloco);
                    $("#txt_lote").html(lote.numeroLote);

                    alteraEtapa("etapa2");
                    modais("modal_reserva","abre");
                }
                else
                {
                    $("#txt_bloco_mv").html(lote.bloco);
                    $("#txt_lote_mv").html(lote.numeroLote);
                    $("#txt_status_mv").html(lote.status);
                    $("#txt_medida_mv").html(lote.metragem);

                    $("#txt_valorLote_mv").html(formatMoney(lote.valor, 2,"R$",".",","));
                    $("#txt_corretor_mv").html(lote.negociacao.corretor.nome);
                    $("#txt_data_mv").html(lote.negociacao.dataNegociacao);

                    if(lote.negociacao.cliente === false)
                    {
                        $("#txt_cliente_mv").html("Cliente não Informado");
                        $("#divDownload").css("display","none");
                    }
                    else
                    {
                        $("#txt_cliente_mv").html(lote.negociacao.cliente.nome);

                        if(user.nivel === "administrador")
                        {
                            $("#vizApenasAdm").css("display","block");
                            $("#divDownload").css("display","block");
                            $("#link_contrato_v").attr("href",BASE_URL + "imprimir/contrato/" + Dados.Id_negociacao);
                            $("#link_entrada_v").attr("href",BASE_URL + "imprimir/boleto/entrada/" + Dados.Id_negociacao);
                            $("#link_parcela_v").attr("href",BASE_URL + "imprimir/boleto/parcela/" + Dados.Id_negociacao);
                        }
                        else
                        {
                            if(user.Id_usuario === lote.negociacao.Id_usuario )
                            {
                                $("#vizApenasAdm").css("display","block");
                                $("#divDownload").css("display","block");
                                $("#link_contrato_v").attr("href",BASE_URL + "imprimir/contrato/" + Dados.Id_negociacao);
                                
                                $("#link_entrada_v").css("display","none");
                                $("#link_parcela_v").css("display","none");
                            }
                            else 
                            {
                                $("#divDownload").css("display","none");
                                $("#vizApenasAdm").css("display","none");
                            }
                        }
                    }


                    // Verifica se o cara é adm
                    if(user.nivel === "administrador")
                    {
                        $("#div_btn_mv").css("display","block");

                        // Verifica se está vendido
                        if(lote.status == "vendido")
                        {
                            $("#btn_vender_mv").css("display","none");
                        }
                        else
                        {
                            $("#btn_vender_mv").css("display","inline");
                        }
                    }

                    modais("modal_vizualizar", "abre");
                }
            }
        }
        else 
        {
            // Avisa que o lote não foi encontrado
            Swal.fire({
                type: 'error',
                title: 'Opss!',
                text: data.mensagem
            });
        }

    },"json");
}




// Busca as informações de financiamento 
function buscaInfoFinanciamento(valor)
{
    var valorFin, sobra, financiamento;

    if(!Number.isInteger(valor)){
        valor = valor.replace(/[^0-9]/g,'');
        valor = parseInt(valor);
    }

    // Verifica se o valor é multiplo de 100 
    sobra = (valor % 100);

    if(sobra > 0)
    {
        valor = valor - sobra;
        $("#input_valorEntrada").val(valor);
    }

    // Salva o valor da entrada
    Dados.valorEntrada = valor; 

    valorFin = (Dados.lote.valor - valor) - parseInt(Dados.ValorBalao);

    if(valorFin > 0)
    {
        if(valorFin >= 1000)
        {
            // Busca as informações do financiamento 
            $.post(BASE_URL + "lote/retorna-financiamento",{valor: valorFin},function(data){

                // Verifica se ouve retorno 
                if(data.tipo == true)
                {
                    var parcelas = $("#input_parcelas").val();

                    financiamento = data.objeto;
                    Dados.financiamento = financiamento;

                    // Altera os dados do modal
                    $("#txt_valorFinanciado").html(formatMoney(financiamento.valor, 2,"R$",".",","));

                    if(parcelas != "" && parcelas != 0)
                    {
                        selecionaNumParcelas(parcelas);
                    }
                }
                else 
                {
                    $("#input_valorEntrada").val("");

                    // Avisa o errp
                    Swal.fire({
                        type: 'error',
                        title: 'Opss!',
                        text: data.mensagem
                    });
                }

            },"json");
        }
        else 
        {
            $("#input_valorEntrada").val("");

            // Avisa o errp
            Swal.fire({
                type: 'error',
                title: 'Opss!',
                text: "O valor do financiamento deve ser maior ou igual a 1.000"
            });
        }
    }
    else 
    {
        Dados.financiamento = 0;
        $("#txt_valorFinanciado").html("R$0,00");

        if(valorFin != 0)
        {
            $("#input_valorEntrada").val(Dados.lote.valor);
        }
    }
}





// Mostra o valor por parcela, 
// quando o usuário seleciona o numero de parcelas
function selecionaNumParcelas(numero) 
{
    // Verifica se o numero de parcelas é 0 
    if(numero != 0)
    {
        var valor = Dados.financiamento["parcela_" + numero];
        valor = valor.replace(",",".");
        valor = parseFloat(valor);

        $("#txt_valorParcela").html(formatMoney(valor, 2,"R$",".",","));
    }
    else 
    {
        $("#txt_valorParcela").html("R$0,00");
    }
}





function buscaCliente(cpf)
{
    cpf = cpf.replace(/[^0-9]/g,'');

    $.get(BASE_URL + "cliente/busca-por-cpf/" + cpf, {}, (data) => {

        if(data.tipo == true)
        {
            Dados.cliente = data.objeto;

            $("#div_someCliente").css("display", "none");

            // Add o Conteudo
            $("#input_rg").val(data.objeto.rg);
            $("#input_nome").val(data.objeto.nome);
            $("#input_email").val(data.objeto.email);

            $("#input_rg").attr("disabled",true);
            $("#input_nome").attr("disabled",true);
            $("#input_email").attr("disabled",true);
        }
        else
        {
            $("#div_someCliente").css("display", "block");

            $("#input_rg").attr("disabled",false);
            $("#input_nome").attr("disabled",false);
            $("#input_email").attr("disabled",false);
        }

    }, "json");

} // END >> Fun::buscaCliente()






function buscaCEP(cep)
{
    $.post(BASE_URL + "ajax/busca-por-cep", {cep: cep}, function(data) {

        if(data.erro == false)
        {
            $("#input_bairro").val(data.bairro);
            $("#input_cidade").val(data.cidade);
            $("#input_estado").val(data.estado);
            $("#input_endereco").val(data.logradouro);
        }
        else
        {
            $("#input_cep").val("");

            // Avisa que o lote não foi encontrado
            Swal.fire({
                type: 'error',
                title: 'Opss!',
                text: 'CEP informado não existe.'
            });
        }

    }, "json");

} // END >> Fun::buscaCEP




function verificaEstadoCivil(estado)
{
    // Verifica se é casado
    if(estado === "casado")
    {
        $("#div_casado").css("display","block");
        $("#div_certidao").css("display","block");

        if($("#div_casado_add").length)
        {
            $("#div_casado_add").css("display","block");
        }

    }
    else
    {
        $("#div_casado").css("display","none");
        $("#div_certidao").css("display","none");

        if($("#div_casado_add").length)
        {
            $("#div_casado_add").css("display","none");
        }
    }
} // END >> Fun::verificaEstadoCivil()





function cancelarReserva()
{
    // Pergunta se realmente deseja cancelar
    Swal.fire({
        title: 'Deseja cancelar?',
        text: "Sua reserva será cancelada, tem certeza que deseja isto?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim, Desejo'
    }).then((result) => {
        if (result.value)
        {
            $.get(BASE_URL + "lote/cancelar-negocicao/" + Dados.Id_negociacao, {}, (data) => {

                if(data.tipo == true)
                {
                    fechaModal(Dados.modal);
                }
                else
                {
                    // Avisa que o lote não foi encontrado
                    Swal.fire({
                        type: 'error',
                        title: 'Opss!',
                        text: data.mensagem
                    });
                }

            }, "json");
        }
    });
}




function venderLote()
{
    // Pergunta se realmente deseja cancelar
    Swal.fire({
        title: 'Vender Lote',
        text: "Deseja setar este lote como vendido?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Não',
        confirmButtonText: 'Sim, Desejo'
    }).then((result) => {
        if (result.value)
        {
            $.get(BASE_URL + "lote/vender-negocicao/" + Dados.Id_negociacao, {}, (data) => {

                if(data.tipo == true)
                {
                    // Avisa que o lote não foi encontrado
                    Swal.fire({
                        type: 'success',
                        title: 'Sucesso!',
                        text: data.mensagem
                    });
                }
                else
                {
                    // Avisa que o lote não foi encontrado
                    Swal.fire({
                        type: 'error',
                        title: 'Opss!',
                        text: data.mensagem
                    });
                }

            }, "json");
        }
    });
}



function alteraJuros(tipo)
{
    if(tipo == "0")
    {
        var numPar = $("#input_parcelas").val();
        var valor = Dados.financiamento.valor;

        // Int
        valor = parseInt(valor);
        numPar = parseInt(numPar);

        // Faz o calculo
        var total = valor / numPar;

        // Exibe
        $("#txt_valorParcela").html(formatMoney(total, 2,"R$",".",","));
    }
    else
    {
        // Numero de parcelas
        var numPar = $("#input_parcelas").val();

        // Manda calculas
        selecionaNumParcelas(numPar);
    }
}




//Função responsavel por pegar a quantidade de parcelas do balão
//E gerar o html dinamico das parcelas
function parcelasBalao(parcelas) {

    //Limpando todos os campos das parcelas
    for (i = 1; i <= 10; i++) {
        $("#balaoParcela"+i).css('display','none');
        $("#input_valorParcelaBalao"+i).val("");
    }

    //Variaveis
    var valorTotal = null;
    var qtdeParcelas = null;
    var valorParcelas = null;
    var i = 0;

    //Pegando a quantidade de parcelas por parametro
    qtdeParcelas = parseInt(parcelas);

    //Pegando o valor total do balão
     valorTotal = parseInt($("#input_valorTotalBalao").val().replace('.',''));

     console.log(valorTotal);

    //Verificando se ele inseriu o valorTotal do balão para
    //Proseguir o calculo.
    if(!Number.isNaN(valorTotal) && valorTotal > 0){

        valorParcelas = valorTotal / qtdeParcelas;
        valorParcelas = formatMoney(parseFloat(valorParcelas), 2,"",".",",");

        //Gerando os campos da parcelas dinamicamente
        for (i = 1; i <= qtdeParcelas; i++) {
            $("#balaoParcela"+i).css('display','block');
            $("#input_valorParcelaBalao"+i).val(valorParcelas);
        }

        //Passando os valores para a global
        Dados.ValorBalao = valorTotal;
        Dados.ParcelaBalao = qtdeParcelas;

        //Calculando o valor a se financiado com o desconto do balão
        buscaInfoFinanciamento(Dados.valorEntrada);

    }else {
        // Avisa o errp
        Swal.fire({
            type: 'error',
            title: 'Opss!',
            text: "Digite um valor para o cálculo"
        });
    }


    // alert(parcelas.options[parcelas.selectedIndex].text);
}


function verificaBalao(valor)
{
    if(valor === "sim")
    {
        $("#telaBalao").css("display","block");
    }
    else
    {
        $("#telaBalao").css("display","none");
    }
}


function verificaPessoa(valor)
{
    if(valor === "juridica")
    {
        $("#divEmpresa").css("display","block");
    }
    else
    {
        $("#divEmpresa").css("display","none");
    }

    Dados.tipoPessoa = valor;
}



/**
 *  ---------------------------------
 *         Envio de Formulários
 *  ---------------------------------
 */


$("#form_etapa1").on("submit",function () {

    // Não Carrega
    event.preventDefault();

    // Pega os dados
    var form = new FormData(this);

    // Bloqueia o Botao
    $("#btn_etapa1").html("Processando...");
    $("#btn_etapa1").attr("disabled",true);

    // Forma os dados a serem enviados
    var salva = {
        "Id_lote": Dados.lote.Id_lote,
        "Id_corretor": form.get("corretor"),
        "valorEntrada": Dados.valorEntrada,
        "vencimentoEntrada": form.get("vencimentoEntrada"),
        "numParcela": form.get("parcelas"),
        "numEntrada": form.get("numEntrada"),
        "vencimentoParcela": form.get("vencimentoParcela"),
        "status": "reservado",
        "Id_valorFinanciamento": 0,
        "valorBalao": Dados.ValorBalao,
        "juros": form.get("juros")
    }

    // Verifica se possui
    if(Dados.financiamento != 0)
    {
        salva.Id_valorFinanciamento = Dados.financiamento.Id_valorFinanciamento;
    }


    // Cadastra
    $.post(BASE_URL + "lote/insert-negocicao",salva, (data) => {

        // Verifica se deu certo
        if(data.tipo == true)
        {
            // Salva o conteudo
            Dados.Id_negociacao = data.objeto.Id_negociacao;

            // Verifica se possui balao
            if(Dados.ValorBalao > 0)
            {
                // Salva balao obj
                var salvaBalao = {
                    numParcelaBalao: Dados.ParcelaBalao
                }

                // Percorre o formulario do balao
                for(var i = 1; i <= Dados.ParcelaBalao; i++)
                {
                    salvaBalao["valor_" + i] = ($("#input_valorParcelaBalao" + i).val().replace(".","")).replace(",",".");
                    salvaBalao["data_" + i] = $("#input_dataParcela" + i).val();
                }

                // Envia para cadastrar
                $.post(BASE_URL + "balao/insert/" + Dados.Id_negociacao, salvaBalao, (data2) => {

                    if(data2.tipo == true)
                    {
                        // Pula para a etapa 2
                        alteraEtapa("etapa2");
                    }
                    else
                    {
                        // Avisa que deu erro no balao
                        Swal.fire({
                            type: 'error',
                            title: 'Opss!',
                            text: data2.mensagem
                        })
                    }

                }, "json");

            }
            else
            {
                // Pula para a etapa 2
                alteraEtapa("etapa2");
            }
        }
        else
        {
            // Avisa que o lote não foi encontrado
            Swal.fire({
                type: 'error',
                title: 'Opss!',
                text: data.mensagem
            });
        }


        // Bloqueia o Botao
        $("#btn_etapa1").html("Continuar");
        $("#btn_etapa1").attr("disabled",false);

    }, "json");


    // Não carrega
    return false;
});



$("#form_etapa2").on("submit", function () {

    // Nao Carrega
    event.preventDefault();

    // Bloqueia o Botao
    $("#btn_etapa2").html("Processando...");
    $("#btn_etapa2").attr("disabled",true);

    // Pega o formulário
    var form = new FormData(this);

    var session = new Session();
    var user = session.get("usuario");


    if(Dados.cliente != "")
    {
        form.set("Id_cliente", Dados.cliente.Id_cliente);
    }

    if(Dados.tipoPessoa == "fisica")
    {
        form.delete("cnpj");
        form.delete("ie");
        form.delete("nomeEmpresa");
    }


    $.ajax({
        url: BASE_URL + "cliente/insert/" + Dados.Id_negociacao,
        type: 'POST',
        dataType: 'JSON',
        data: form,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {

            // Verifica
            if(data.tipo == true)
            {
                // Altera
                Dados.cliente = data.objeto;

                // Altera os Links
                $("#link_contrato").attr("href",BASE_URL + "imprimir/contrato/" + Dados.Id_negociacao);

                if(user.nivel === "administrador")
                {
                    $("#link_entrada").attr("href",BASE_URL + "imprimir/boleto/entrada/" + Dados.Id_negociacao);
                    $("#link_parcela").attr("href",BASE_URL + "imprimir/boleto/parcela/" + Dados.Id_negociacao);

                    $("#link_entrada").css("display","block");
                    $("#link_parcela").css("display","block");
                }
                else
                {
                    $("#link_entrada").css("display","none");
                    $("#link_parcela").css("display","none");
                }


                // Altera
                alteraEtapa("etapa3");
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: data.mensagem
                });
            }

            // Bloqueia o Botao
            $("#btn_etapa2").html("Continuar");
            $("#btn_etapa2").attr("disabled",false);
        }
    });


    // Nao carrega mesmo
    return false;
});





$("#formAdicionarCliente").on("submit", function () {

    // Nao Carrega
    event.preventDefault();

    // Bloqueia o Botao
    $("#btn_adicionar").attr("disabled",true);
    $("#btn_adicionar").html("Processando...");

    // Pega o formulário
    var form = new FormData(this);

    var renda = form.get("renda");
    renda = renda.replace(".","");

    form.set("renda", renda);

    if(form.get("esp_renda") !== null && form.get(renda) !== undefined) {
        var rendaEsp = form.get("esp_renda");
        rendaEsp = rendaEsp.replace(".", "");

        form.set("esp_renda", rendaEsp);
    }


    $.ajax({
        url: BASE_URL + "cliente/insert",
        type: 'POST',
        dataType: 'JSON',
        data: form,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {

            // Verifica
            if(data.tipo == true)
            {
                Swal.fire({
                    type: 'success',
                    title: 'Sucesso!',
                    text: 'Cliente adicionado com sucesso.'
                });

                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: data.mensagem
                });
            }

            // Desbloqueia o Botao
            $("#btn_adicionar").html("Alterar");
            $("#btn_adicionar").attr("disabled",false);
        }
    });


    // Nao carrega mesmo
    return false;
});




$("#formAlterarCliente").on("submit", function () {

    // Nao Carrega
    event.preventDefault();

    // Bloqueia o Botao
    $("#btn_alterar").attr("disabled",true);
    $("#btn_alterar").html("Processando...");

    // Pega o formulário
    var form = new FormData(this);
    var id_cliente = form.get('Id_cliente')

    var renda = form.get("renda");
    renda = renda.replace(".","");

    form.set("renda", renda);

    if(form.get("esp_renda") !== null && form.get(renda) !== undefined) 
    {
        var rendaEsp = form.get("esp_renda");
        rendaEsp = rendaEsp.replace(".","");

        form.set("esp_renda", rendaEsp);
    }


    $.ajax({
        url: BASE_URL + "cliente/update/" + id_cliente,
        type: 'POST',
        dataType: 'JSON',
        data: form,
        mimeType:"multipart/form-data",
        contentType: false,
        cache: false,
        processData:false,
        success: function (data) {

            // Verifica
            if(data.tipo == true)
            {
                Swal.fire({
                    type: 'success',
                    title: 'Sucesso!',
                    text: data.mensagem
                });

                setTimeout(() => {
                    location.reload();
                }, 2000);
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: data.mensagem
                });
            }

            // Desbloqueia o Botao
            $("#btn_alterar").html("Alterar");
            $("#btn_alterar").attr("disabled",false);
        }
    });


    // Nao carrega mesmo
    return false;
});





// Metodo chamado quando um lote é alterado
// Em tempo Real
atualizaLote.bind('atualizarStatus_gp', function (data) {

    // Verifica se existe o objt 
    if(document.getElementById('lt_' + data.Id_lote))
    {
        var classe = "lote";

        if(data.status != "livre")
        {
            classe += " " + data.status;
        }

        // Altera o status 
        document.getElementById('lt_' + data.Id_lote).className = classe;
    }

});