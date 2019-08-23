$("#formNovoCorretor").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = new FormData(this);

    // Forma os dados a serem enviados
    var salva = {
        "nome": form.get("nome"),
        "email": form.get("email"),
        "senha": form.get("senha"),
        "c_senha": form.get("c_senha"),
        "telefone": form.get("telefone"),
        "celular": form.get("celular"),
        "creci": form.get("creci"),
        "cnpj": form.get("cnpj"),
        "empresa": form.get("empresa"),
        "cep": form.get("cep"),
        "estado": form.get("estado"),
        "cidade": form.get("cidade"),
        "bairro": form.get("bairro"),
        "logradouro": form.get("logradouro"),
        "numero": form.get("numero"),
        "complemento": form.get("complemento"),
        "status": form.get("status"),
        "nivel": form.get("nivel"),
    }



    if (salva.senha == salva.c_senha){

        document.getElementById("btn_cadastrar").disabled = true;
        document.getElementById("btn_cadastrar").innerHTML = "ENVIANDO, AGUARDE...";

        $.ajax({
            type: "POST",
            dataType: 'json',
            mimeType: 'multipart/form-data',
            contentType: false,
            processData: false,
            cache: false,
            url: BASE_URL + 'corretor/insert-corretor',
            data: form, // serializes the form's elements.
            success: function (data) {

                console.log(data);
                if(data.tipo == true){
                    console.log(data);
                    Swal.fire({
                        type: 'success',
                        title: 'Sucesso',
                        text: data.mensagem,
                    })
                    document.getElementById("formNovoCorretor").reset();

                    // Redireciona o usuario
                    setTimeout(() => {
                        location.href = BASE_URL + "corretores";
                    },1500);

                }else {
                    Swal.fire({
                        type: 'error',
                        title: 'Erro...',
                        text: data.mensagem,
                    })
                }
                document.getElementById("btn_cadastrar").disabled = false;
                document.getElementById("btn_cadastrar").innerHTML = "ENVIAR";

            },
            error: function (data) {
                Swal.fire({
                    type: 'error',
                    title: 'Erro...',
                    text: data.mensagem,
                })
                document.getElementById("btn_cadastrar").disabled = false;
                document.getElementById("btn_cadastrar").innerHTML = "ENVIAR";
            }

        });

    } else {
        Swal.fire({
            type: 'error',
            title: 'Erro...',
            text: 'As senha estão diferentes!',
        })
    }


    return false;
});




$("#formAlterarCorretor").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = new FormData(this);

    // Form os dados a serem enviados
    var salva = {
        "nome": form.get("nome"),
        "email": form.get("email"),
        "senha": form.get("senha"),
        "c_senha": form.get("c_senha"),
        "telefone": form.get("telefone"),
        "celular": form.get("celular"),
        "creci": form.get("creci"),
        "cnpj": form.get("cnpj"),
        "empresa": form.get("empresa"),
        "cep": form.get("cep"),
        "estado": form.get("estado"),
        "cidade": form.get("cidade"),
        "bairro": form.get("bairro"),
        "logradouro": form.get("logradouro"),
        "numero": form.get("numero"),
        "complemento": form.get("complemento"),
        "status": form.get("status"),
        "nivel": form.get("nivel"),
    }



    if (salva.senha === salva.c_senha){

        document.getElementById("btn_alterar").disabled = true;
        document.getElementById("btn_alterar").innerHTML = "ALTERANDO, AGUARDE...";

        $.ajax({
            type: "POST",
            dataType: 'json',
            mimeType: 'multipart/form-data',
            contentType: false,
            processData: false,
            cache: false,
            url: BASE_URL + 'corretor/ajaxalterarcorretor',
            data: form, // serializes the form's elements.
            success: function (data) {

                console.log(data);
                if(data.tipo == true){
                    console.log(data);
                    Swal.fire({
                        type: 'success',
                        title: 'Sucesso',
                        text: data.mensagem,
                    })
                    document.getElementById("formAlterarCorretor").reset();

                    // Redireciona o usuario
                    setTimeout(() => {
                        location.reload();
                    }, 1500);

                }else {
                    Swal.fire({
                        type: 'error',
                        title: 'Erro...',
                        text: data.mensagem,
                    })
                }
                document.getElementById("btn_alterar").disabled = false;
                document.getElementById("btn_alterar").innerHTML = "ALTERAR";

            },
            error: function (data) {
                Swal.fire({
                    type: 'error',
                    title: 'Erro...',
                    text: data.mensagem,
                })
                document.getElementById("btn_alterar").disabled = false;
                document.getElementById("btn_alterar").innerHTML = "ALTERAR";
            }

        });

    } else {
        Swal.fire({
            type: 'error',
            title: 'Erro...',
            text: 'As senha estão diferentes!',
        })
    }


    return false;
});







function verCadastroSite(param) {

    $.get(BASE_URL + "cadsite/ajaxbuscacadastro/" + param, function(data){

        // Verifica
        if(data.tipo == true)
        {
            //PASSANDO OS DADOS DO CADASTRO PARA OS CAMPOS CORRETOS
            $("#nomeCadastro").html(data.objeto.nome);
            $("#emailCadastro").html(data.objeto.email);
            $("#rgCadastro").html(data.objeto.rg);
            $("#cpfCadastro").html(data.objeto.cpf);
            $("#cepCadastro").html(data.objeto.cep);
            $("#enderecoCadastro").html(data.objeto.endereco);
            $("#bairroCadastro").html(data.objeto.bairro);
            $("#cidadeCadastro").html(data.objeto.cidade);
            $("#profissaoCadastro").html(data.objeto.profissao);
            $("#trabalhoCadastro").html(data.objeto.trabalho);
            $("#prestacaoCadastro").html(data.objeto.prestacao);
            $("#entradaCadastro").html(data.objeto.entrada);
            $("#rendaCadastro").html(data.objeto.renda);
            $("#intencaoCadastro").html(data.objeto.intencao);
            $("#informacoesCadastro").html(data.objeto.informacoes);
            $("#temCorretorCadastro").html(data.objeto.tem_corretor);
            $("#nomeCorretorCadastro").html(data.objeto.nome_corretor);
            $("#creciCadastro").html(data.objeto.creci);

            //ABRIR A MODAL DO CADASTRO
            $("#verCadastro").modal('show')
        }
        else
        {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: data.mensagem
            });
        }


    },"json");
}


function EscolhaPagamento(select) {
    if(select.options[select.selectedIndex].text == "Depósito Bancário"){
        $("#dadosBancario").css("display","block");
    }else {
        $("#dadosBancario").css("display","none");
    }
}
function TrabalhaImob(select) {
    if(select.options[select.selectedIndex].text == "Sim"){
        $("#nomeImobiliaria").css("display","block");
    }else {
        $("#nomeImobiliaria").css("display","none");
    }
}





function BuscaCEP(cep)
{
    $.post(BASE_URL + "ajax/busca-por-cep", {cep: cep}, function(data) {

        if(data.erro == false)
        {
            $("#input_bairro").val(data.bairro);
            $("#input_cidade").val(data.cidade);
            $("#input_estado").val(data.estado);
            $("#input_logradouro").val(data.logradouro);
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