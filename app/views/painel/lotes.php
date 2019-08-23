<?php

if($usuario->nivel == "user")
{
    $this->view("painel-user/include/header");
}
else
{
    $this->view("painel/include/header");
}

?>

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
                            <h3 class="mb-0">Lotes</h3>
                        </div>

                        <?php if($usuario->nivel == "administrador"): ?>
                            <div class="col">
                                <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#alterarLoteTodos">
                                    Alterar o valor de Todos
                                </button>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="table-responsive">
                    <!-- Projects table -->
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush datatable">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Lote</th>
                                <th scope="col">Metragem</th>
                                <th scope="col">Staus</th>
                                <th scope="col">Valor</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($lotes as $mes => $lote): ?>
                                <tr>
                                    <td><?= $lote->bloco ?>-<?= $lote->numeroLote ?></td>
                                    <td><?= $lote->metragem ?>m²</td>

                                    <?php if($lote->status == "reservado"): ?>
                                        <td><span class="badge badge-pill badge-info">Reservado</span></td>
                                    <?php elseif($lote->status == "vendido"): ?>
                                        <td><span class="badge badge-pill badge-warning">Vendido</span></td>
                                    <?php else: ?>
                                        <td><span class="badge badge-pill badge-success">livre</span></td>
                                    <?php endif; ?>

                                    <td id="vl_<?= $lote->Id_lote; ?>">R$<?= number_format($lote->valor, 2, ',', '.'); ?></td>

                                    <td class="text-right">
                                        <?php if($usuario->nivel == "administrador"): ?>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a style="cursor:pointer;" class="dropdown-item" onclick="alterarLote('<?= $lote->Id_lote ?>')">Alterar</a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div/>
    <div/>


    <!-- Modal -->
    <div class="modal fade" id="alterarLote" tabindex="-1" role="dialog" aria-labelledby="alterarLote" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Lote</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_alterarLote">
                        <div class="row">


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Lote</label>
                                    <p id="txt_lote"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Metragem</label>
                                    <p><span id="txt_metragem"></span>m²</p>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Valor</label>
                                    <input required id="valor" name="valor" type="text" class="form-control form-control-alternative maskValorVigula" />
                                </div>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button id="btn" type="submit" class="btn btn-primary">Alterar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="alterarLoteTodos" tabindex="-1" role="dialog" aria-labelledby="alterarLoteTodos" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar todos os lote</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_alterarLoteTodos">
                        <div class="row">


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de alteração</label>
                                    <select class="form-control" required name="tipo">
                                        <option selected disabled>Selecione</option>
                                        <option value="porcentagem">Porcentagem (%)</option>
                                        <option value="valorFixo">Valor em Real (R$)</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ação a executar</label>
                                    <select class="form-control" required name="acao">
                                        <option selected disabled>Selecione</option>
                                        <option value="adicao">Aumentar o valor</option>
                                        <option value="subtracao">Diminuir o valor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Valor a ser modificado</label>
                                    <input required name="valor" type="text" class="form-control form-control-alternative maskValorVigula" />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button id="btnTodos" type="submit" class="btn btn-primary">Alterar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php

if($usuario->nivel == "user")
{
    $this->view("painel-user/include/footer");
}
else
{
    $this->view("painel/include/footer");
}

?>

<script>

    var DadosLote = {
        "idLote" : 0,
        "lote" : ""
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


    function alterarLote(id)
    {
        // Busca Lote
        $.get(BASE_URL + "lote/get/" + id, {}, (data) => {

            // Verifica se trouxe
            if(data.tipo == true)
            {
                // Verifica se o lote está em negociacao ou vendido
                if(data.objeto.status == "livre")
                {
                    var lote = data.objeto;

                    // Salva os dados do lote
                    DadosLote.idLote = id;
                    DadosLote.lote = lote;

                    // Add os dados no modal
                    $("#txt_lote").html(lote.bloco + "-" + lote.numeroLote);
                    $("#txt_metragem").html(lote.metragem);
                    $("#valor").val(formatMoney(lote.valor, 2,"",".",","));

                    $("#alterarLote").modal("show");
                }
                else
                {
                    Swal.fire({
                        type: 'error',
                        title: 'Opss!',
                        text: "Este lote está Vendido ou Reservado! Não é possivel editar lotes com negociações ativas.",
                    });
                }
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Opss!',
                    text: data.mensagem,
                });
            }

        }, "json");
    }



    $("#form_alterarLote").on("submit", function () {

        event.preventDefault();

        var id = DadosLote.idLote;
        var valor = $("#valor").val();
        valor = valor.replace(".","");

        // Pergunta se realmente deseja cancelar
        Swal.fire({
            title: 'Deseja alterar?',
            text: "Você deseja alterar o valor do lote para R$" + valor + "?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim, Desejo'
        }).then((result) => {
            if (result.value)
            {
                valor = valor.replace(",",".");

                $.post(BASE_URL + "lote/update/" +id, {"valor": valor}, (data) => {

                    // Verifica
                    if(data.tipo == true)
                    {
                        Swal.fire({
                            type: 'success',
                            title: 'Sucesso!',
                            text: data.mensagem,
                        });

                        setTimeout(() => {
                            location.reload();
                        },2000);
1                    }
                    else
                    {
                        Swal.fire({
                            type: 'error',
                            title: 'Opss!',
                            text: data.mensagem,
                        });
                    }

                }, "json");
            }
        });

        return false;

    });



    $("#form_alterarLoteTodos").on("submit", function () {

        // Não carrega
        event.preventDefault();

        // Form
        var form = new FormData(this);

        // Bloqueia o botão
        $("#btnTodos").html("Processando...");
        $("#btnTodos").attr("disabled", true);

        var txt = "Você realmente deseja ";

        if(form.get("acao") === "adicao")
        {
            txt += "aumentar o valor de todos os lotes em ";
        }
        else
        {
            txt += "diminuir o valor de todos os lotes em ";
        }


        if(form.get("tipo") === "porcentagem")
        {
            txt += form.get("valor") + "%";
        }
        else
        {
            txt += "R$" + form.get("valor");
        }


        // Pergunta se realmente deseja cancelar
        Swal.fire({
            title: 'Deseja alterar?',
            text: txt,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Não',
            confirmButtonText: 'Sim, Desejo'
        }).then((result) => {
            if (result.value)
            {
                var valor = form.get("valor");
                valor = valor.replace(".","");
                valor = valor.replace(",",".");

                form.set("valor",valor);

                $.ajax({
                    url: BASE_URL + "lote/alterar-valor-todos",
                    type: 'POST',
                    dataType: 'JSON',
                    data:  form,
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
                                text: data.mensagem,
                            });

                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                        else
                        {
                            Swal.fire({
                                type: 'error',
                                title: 'Opss!',
                                text: data.mensagem,
                            });
                        }

                        // Desbloqueia o botão
                        $("#btnTodos").html("Alterar");
                        $("#btnTodos").attr("disabled", false);
                    }
                });
            }
        });


        // Não carrega mesmo
        return false;

    });

</script>
</body>
</html>