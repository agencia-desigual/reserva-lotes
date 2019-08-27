<?php $this->view("painel/include/header"); ?>

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

    <!-- VALIDANDO AS VARIAVEIS -->
    <?php

        $dataNegociacao = explode(" ",$negociacoes[0]->dataNegociacao);
        $dataNegociacao = explode("-",$dataNegociacao[0]);
        $dataNegociacao = $dataNegociacao[2].'/'.$dataNegociacao[1].'/'.$dataNegociacao[0];

        if($negociacoes[0]->corretor->status == 1){ $statusCorretor = "Ativo"; }else{ $statusCorretor = "Inativo"; }

    ?>

    <div class="row mt-5">
        <div class="col-xl-12 mb-12 mb-xl-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">

                    </div>
                </div>

                <div style="padding: 30px" class="row">
                    <div class="col-md-12">
                        <form id="formAlteraNegociacao">

                            <h2>Informações do lote</h2>
                            <br>
                            <div class="row">

                                <!-- LOTE -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Lote</label>
                                        <p><?= $negociacoes[0]->lote->bloco ?>-<?= $negociacoes[0]->lote->quadra ?></p>
                                    </div>
                                </div>

                                <!-- METRAGEM -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Metragem</label>
                                        <p><?= $negociacoes[0]->lote->metragem ?>m²</p>
                                    </div>
                                </div>

                                <!-- VALOR -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Valor</label>
                                        <p>R$ <?= number_format($negociacoes[0]->lote->valor, 2, ',', '.') ?></p>
                                    </div>
                                </div>

                            </div>

                            <h2>Dados do corretor</h2>
                            <br>
                            <div class="row">

                                <!-- NOME -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <p><?= $negociacoes[0]->corretor->nome ?></p>
                                    </div>
                                </div>

                                <!-- EMAIL -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <p><?= $negociacoes[0]->corretor->email ?></p>
                                    </div>
                                </div>

                                <!-- STATUS -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <p><?= $statusCorretor ?></p>
                                    </div>
                                </div>

                            </div>

                            <?php if($negociacoes[0]->cliente != "") : ?>

                                <h2>Dados do cliente</h2>
                                <br>
                                <div class="row">

                                    <!-- NOME -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <p><?= $negociacoes[0]->cliente->nome ?></p>
                                        </div>
                                    </div>

                                    <!-- EMAIL -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <p><?= $negociacoes[0]->cliente->email ?></p>
                                        </div>
                                    </div>

                                    <!-- CELULAR -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Celular</label>
                                            <p><?= $negociacoes[0]->cliente->celular ?></p>
                                        </div>
                                    </div>

                                    <!-- PROFISSÃO -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Profissão</label>
                                            <p><?= $negociacoes[0]->cliente->profissao ?></p>
                                        </div>
                                    </div>

                                    <!-- ESTADO CIVIL -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado civil</label>
                                            <p><?= $negociacoes[0]->cliente->estadoCivil ?></p>
                                        </div>
                                    </div>

                                    <!-- RENDA -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Renda</label>
                                            <p><?= number_format($negociacoes[0]->cliente->renda, 2, ',', '.') ?></p>
                                        </div>
                                    </div>



                                </div>

                            <?php endif; ?>

                            <h2>Dados da negociação</h2>
                            <br>
                            <div class="row">

                                <!-- STATUS -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <p><?= $negociacoes[0]->status ?></p>
                                    </div>
                                </div>

                                <!-- DATA DE NEGOCIACAO -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Data da negociação</label>
                                        <p><?= $dataNegociacao ?></p>
                                    </div>
                                </div>

                                <!-- PARCELAS -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Parcelas</label>
                                        <p><?= $negociacoes[0]->numParcela ?> vezes</p>
                                    </div>
                                </div>

                                <!-- VALOR ENTRADA -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor da entrada</label>
                                        <p>R$ <?= number_format($negociacoes[0]->valorEntrada, 2, ',', '.') ?></p>
                                    </div>
                                </div>

                            </div>

                            <?php if($_SESSION['usuario']->nivel == 'administrador'): ?>

                                <h2>Boletos</h2>
                                <br>
                                <div class="row">

                                    <!-- STATUS -->
                                    <div class="col-md-4">
                                            <?php if ($negociacoes[0]->numEntrada == 1): ?>
                                                <a href="#">Boleto entrada 1</a>
                                            <?php elseif ($negociacoes[0]->numEntrada == 2): ?>
                                                <a href="#">Boleto entrada 1</a><br>
                                                <a href="#">Boleto entrada 2</a>
                                            <?php elseif ($negociacoes[0]->numEntrada == 3): ?>
                                                <a href="#">Boleto entrada 1</a><br>
                                                <a href="#">Boleto entrada 2</a><br>
                                                <a href="#">Boleto entrada 3</a>
                                            <?php endif; ?>
                                        </div>

                                    <!-- DATA DE NEGOCIACAO -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <a href="#">Boleto parcela</a>
                                            <p></p>
                                        </div>
                                    </div>

                                    <!-- PARCELAS -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <a href="#">Boleto balão</a>
                                            <p></p>
                                        </div>
                                    </div>

                                </div>

                            <?php endif; ?>

                            <div class="modal-footer">
                                <a href="<?= BASE_URL; ?>negociacaoes" id="btn_voltar" type="button" class="btn btn-primary">Voltar</a>

                                <?php if($_SESSION['usuario']->nivel == 'administrador'): ?>

                                    <?php if($negociacoes[0]->status == "vendido"): ?>
                                        <button  id="btn_cancelar" type="button" class="btn btn-primary" onclick="alteraStatus('cancelar','<?= $negociacoes[0]->Id_negociacao ?>')">Cancelar</button>
                                    <?php elseif($negociacoes[0]->status == "reservado"): ?>
                                        <button id="btn_vender" type="button" class="btn btn-primary" onclick="alteraStatus('vender','<?= $negociacoes[0]->Id_negociacao ?>')" >Vender</button>
                                        <button  id="btn_cancelar" type="button" class="btn btn-primary" onclick="alteraStatus('cancelar','<?= $negociacoes[0]->Id_negociacao ?>')">Cancelar</button>
                                    <?php endif; ?>

                                <?php endif; ?>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div/>
    <div/>


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

    function alteraStatus(tipo, id)
    {
        var url = BASE_URL + "lote/";

        if(tipo == "vender")
        {
            url = url + "vender-negocicao/" + id;
        }
        else
        {
            url = url + "cancelar-negocicao/" + id;
        }


        $.get(url,{},(data) => {

            if(data.tipo === true)
            {
                Swal.fire({
                    type: 'success',
                    title: 'Sucesso!',
                    text: data.mensagem,
                });

                setTimeout(() => {
                    location.reload();
                },1500);
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

</script>
