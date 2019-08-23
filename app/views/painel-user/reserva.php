<?php $this->view("painel-user/include/header"); ?>


    <!-- Header -->
    <div class="header bg-gradient-red pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">

                <!-- Card stats -->
                <div class="row">


                </div>
            </div>
        </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--7">

    <div class="row mt-5">
    <div class="col-xl-12 mb-12 mb-xl-12">
    <div class="card shadow">
    <div class="card-header border-0">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Reservar um lote</h3>
            </div>
        </div>
    </div>

        <div style="padding: 30px" class="row">
            <div class="col-md-12">
                <div class="row">

                    <div style="width: 100%;">
                        <form>
                            <div class="row">
                                <!-- NOME -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Bloco*</label>
                                        <select name="bloco" required class="form-control" onchange="buscaNumeroLotes(this.value)">
                                            <option selected disabled>Selecione o bloco</option>
                                            <?php foreach ( $blocos as $bl): ?>
                                                <option value="<?= $bl->bloco; ?>"><?= $bl->bloco; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lote*</label>
                                        <select name="numeroLote" id="input_numeroLote" required class="form-control" onchange="buscaLote(this.value)">
                                            <option selected disabled>Selecione o lote</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <!-- Etapa 1 -->
                    <div id="etapa1" style="display: none; width: 100%;">
                        <form id="form_etapa1_2">

                            <div class="row">
                                <!-- Valor do Lote -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Valor do Lote</label>
                                        <p id="txt_valorLote">R$200.000,00</p>
                                    </div>
                                </div>

                                <!-- Vendedor -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Corretor Responsável</label>
                                        <select name="corretor" id="input_corretor" class="form-control" required>
                                            <option selected value="<?= $_SESSION["usuario"]->Id_usuario; ?>"><?= $_SESSION["usuario"]->nome; ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Valor do Lote -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Valor da Entrada</label>
                                        <input type="tel" class="maskValor form-control" onblur="buscaInfoFinanciamento(this.value)" id="input_valorEntrada" name="valorEntrada" />
                                    </div>
                                </div>

                                <!-- Vendedor -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vencimento Entrada</label>
                                        <input type="date" class="form-control" id="input_vencimentoEntrada" name="vencimentoEntrada" min="<?= date("Y-m-d"); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Valor do Lote -->
                                <div class="col-md-12">
                                    <label>Valor a ser financiado</label>
                                    <p id="txt_valorFinanciado">R$0,00</p>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Valor do Lote -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Quantidade de Parcelas</label>
                                        <select name="parcelas" class="form-control" id="input_parcelas" onchange="selecionaNumParcelas(this.value)">
                                            <option value="0" selected>Pagamento á vista</option>
                                            <option value="12">12 Messes</option>
                                            <option value="24">24 Messes</option>
                                            <option value="36">36 Messes</option>
                                            <option value="48">48 Messes</option>
                                            <option value="60">60 Messes</option>
                                            <option value="72">72 Messes</option>
                                            <option value="84">84 Messes</option>
                                            <option value="96">96 Messes</option>
                                            <option value="108">108 Messes</option>
                                            <option value="120">120 Messes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Valor do Lote -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Valor da Parcela</label>
                                        <p id="txt_valorParcela">R$0,00</p>
                                    </div>
                                </div>

                                <!-- Vendedor -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Vencimento 1ª Parcela</label>
                                        <input type="date" class="form-control" name="vencimentoParcela" id="input_vencimentoParcela" min="<?= date("Y-m-d"); ?>" />
                                    </div>
                                </div>
                            </div>



                            <div class="modal-footer">
                                <button id="btn_etapa1" type="submit" class="btn btn-primary">Continuar</button>
                            </div>
                        </form>
                    </div>


                    <!-- Etapa 2 -->
                    <div id="etapa2" style="display: none; width: 100%;">
                        <h4>Informações do Cliente</h4>

                        <form id="form_etapa2_2">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>CPF</label>
                                        <input type="tel" name="cpf" id="input_cpf" onblur="buscaCliente(this.value)" class="maskCPF form-control" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>RG</label>
                                        <input type="tel" name="rg" id="input_rg" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="nome" class="form-control" id="input_nome" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estado Civil</label>
                                        <select name="estadoCivil" class="form-control" onchange="verificaEstadoCivil(this.value)" id="input_estadoCivil">
                                            <option selected disabled>Selecione o estado civil</option>
                                            <option value="solteiro">Solteiro</option>
                                            <option value="casado">Casado</option>
                                            <option value="divorciado">Divorciado</option>
                                            <option value="viúvo">Viúvo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" id="input_email" />
                                </div>
                            </div>

                            <div id="div_someCliente" style="display: block; width: 100%;">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Renda</label>
                                            <input type="tel" name="renda" class="maskValor form-control" id="input_renda" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Data de Nascimento</label>
                                            <input type="date" name="dataNascimento" class="form-control" id="input_dataNascimento" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Local de Trabalho</label>
                                            <input type="text" name="localTrabalho" class="form-control" id="input_localTrabalho" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Profissão</label>
                                            <input type="text" name="profissao" class="form-control" id="input_profissao" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="tel" name="telefone" class="maskTel form-control" id="input_telefone" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Celular</label>
                                            <input type="tel" name="celular" class="maskCel form-control" id="input_celular" />
                                        </div>
                                    </div>
                                </div>


                                <div id="div_casado" class="pt-3 pb-3" style="display: none; width: 100%;">
                                    <h4 style="clear: both; padding-top: 30px;">Informações da(o) Esposa(o)</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>CPF</label>
                                                <input type="tel" name="esp_cpf" id="input_esp_cpf" class="maskCPF form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>RG</label>
                                                <input type="tel" name="esp_rg" id="input_esp_rg" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nome</label>
                                                <input type="text" name="esp_nome" id="input_esp_nome" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" name="esp_email" id="input_esp_email" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="esp_estadoCivil" value="casado" />

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Renda</label>
                                                <input type="tel" name="esp_renda" class="maskValor form-control" id="input_esp_renda" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Data de Nascimento</label>
                                                <input type="date" name="esp_dataNascimento" class="form-control" id="input_esp_dataNascimento" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Local de Trabalho</label>
                                                <input type="text" name="esp_localTrabalho" class="form-control" id="input_esp_localTrabalho" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profissão</label>
                                                <input type="text" name="esp_profissao" class="form-control" id="input_esp_profissao" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telefone</label>
                                                <input type="tel" name="esp_telefone" class="maskTel form-control" id="input_esp_telefone" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Celular</label>
                                                <input type="tel" name="esp_celular" class="maskCel form-control" id="input_esp_celular" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto do RG</label>
                                                <input type="file" name="esp_arquivo_rg" accept="image/*" capture="camera" class="dropify" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto do CPF</label>
                                                <input type="file" name="esp_arquivo_cpf" accept="image/*" capture="camera" class="dropify" />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 style="clear: both; padding-top: 30px; padding-bottom: 20px; width: 100%;">Informações do Endereço</h4>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CEP</label>
                                            <input type="tel" name="cep" id="input_cep" onblur="buscaCEP(this.value)" class="maskCEP form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bairro</label>
                                            <input type="text" name="bairro" class="form-control" id="input_bairro" />
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cidade</label>
                                            <input type="text" name="cidade" class="form-control" id="input_cidade" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <input type="text" name="estado" class="form-control" id="input_estado" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Endereço</label>
                                            <input type="text" name="endereco" class="form-control" id="input_endereco" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Número</label>
                                            <input type="text" name="numero" class="form-control" id="input_numero" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Complemento</label>
                                            <input type="text" name="complemento" class="form-control" id="input_complemento" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Foto do RG</label>
                                            <input type="file" name="arquivo_rg" accept="image/*" capture="camera" class="dropify" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Foto do CPF</label>
                                            <input type="file" name="arquivo_cpf" accept="image/*" capture="camera" class="dropify" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="div_certidao" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Foto da Certidão de Casamento</label>
                                            <input type="file" name="arquivo_casamento" accept="image/*" capture="camera" class="dropify" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Foto do Comprovante de Residencia</label>
                                            <input type="file" name="arquivo_residencia" accept="image/*" capture="camera" class="dropify" />
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button id="btn_etapa2" type="submit" class="btn btn-primary">Continuar</button>
                            </div>
                        </form>
                    </div>

                    <!-- Etapa 3 -->
                    <div id="etapa3" style="display: none; width: 100%;">
                        <h4 class="text-center">Etapa Final <br> Download dos arquivos</h4>

                        <div class="row pt-4">
                            <div class="col-md-4 text-center">
                                <a href="" id="link_entrada" class="text-align-center" target="_blank">
                                    <img src="<?= BASE_STORANGE; ?>assets/img/boleto.png" />
                                    <p style="color:#000; padding-top: 10px;">Entrada</p>
                                </a>
                            </div>

                            <div class="col-md-4 text-center">
                                <a href="" id="link_parcela" target="_blank">
                                    <img src="<?= BASE_STORANGE; ?>assets/img/boleto.png" />
                                    <p style="color:#000; padding-top: 10px;">1ª Parcela</p>
                                </a>
                            </div>

                            <div class="col-md-4 text-center">
                                <a href="" id="link_contrato" target="_blank">
                                    <img src="<?= BASE_STORANGE; ?>assets/img/download.png" />
                                    <p style="color:#000; padding-top: 10px;">Contrato</p>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <div/>
    <div/>


<?php $this->view("painel-user/include/footer"); ?>

<script src="<?= BASE_URL; ?>arquivos/assets/js/funcoes.js"></script>

<script>
    function buscaNumeroLotes(bloco)
    {
        $.get(BASE_URL + "lote/retorna-numeros/" + bloco, {}, (data) => {

            if(data.tipo === true)
            {
                var nums = data.objeto;
                var html = "<option selected disabled>Selecione o lote</option>";


                nums.forEach((x) => {
                    html += "<option value='"+ x.Id_lote +"'>"+ x.numeroLote +"</option>";
                });

                $("#input_numeroLote").html(html);
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Opss!',
                    text: data.mensagem
                });
            }

        }, "json");
    }



    function buscaLote(id)
    {
        $.get(BASE_URL + "lote/get/" + id, {}, (data) => {

            if(data.tipo === true)
            {
                // Lote
                var lote = data.objeto;
                Dados.lote = lote;
                Dados.lote_etapa = "etapa1";

                $("#txt_valorLote").html(formatMoney(lote.valor, 2,"R$",".",","));


                $("#etapa1").css("display","block");
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Opss!',
                    text: data.mensagem
                });
            }

        }, "json");
    }


    $("#form_etapa1_2").on("submit",function () {

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
            "vencimentoParcela": form.get("vencimentoParcela"),
            "status": "reservado",
            "Id_valorFinanciamento": 0
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

                // Pula para a etapa 2
                $('#' + Dados.lote_etapa).css("display","none");
                $('#etapa2').css("display","block");

                Dados.lote_etapa = 'etapa2';
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



    $("#form_etapa2_2").on("submit", function () {

        // Nao Carrega
        event.preventDefault();

        // Bloqueia o Botao
        $("#btn_etapa2").html("Processando...");
        $("#btn_etapa2").attr("disabled",true);

        // Pega o formulário
        var form = new FormData(this);

        if(Dados.cliente != "")
        {
            form.set("Id_cliente", Dados.cliente.Id_cliente);
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
                    $("#link_entrada").attr("href",BASE_URL + "imprimir/boleto/entrada/" + Dados.Id_negociacao);
                    $("#link_parcela").attr("href",BASE_URL + "imprimir/boleto/parcela/" + Dados.Id_negociacao);

                    // Altera
                    // Pula para a etapa 2
                    $('#' + Dados.lote_etapa).css("display","none");
                    $('#etapa3').css("display","block");

                    Dados.lote_etapa = 'etapa3';
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


    $(document).ready(function () {
        $('.dropify').dropify({
            messages: {
                'default': 'Arraste o arquivo ou click aqui',
                'replace': 'Arraste o arquivo ou click aqui',
                'remove':  'Remover',
                'error':   'Ooops, ocorreu um erro.'
            }
        });
    });
</script>

</body>
</html>