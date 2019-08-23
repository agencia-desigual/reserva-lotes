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
                            <h3 class="mb-0">Negociações</h3>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <!-- Projects table -->
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush datatable">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Lote</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Corretor</th>
                                <th scope="col">Status</th>
                                <th scope="col">Data</th>
                                <?php if($usuario->nivel == "administrador"): ?>
                                    <th scope="col"></th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($negociacoes as $mes => $negociacoes): ?>
                                <tr>
                                    <td>#<?= $negociacoes->Id_negociacao; ?></td>
                                    <td><?= $negociacoes->lote->bloco; ?>-<?= $negociacoes->lote->numeroLote; ?></td>

                                    <td><?= $negociacoes->cliente->nome; ?></td>
                                    <td><?= $negociacoes->corretor->nome; ?></td>

                                    <?php if($negociacoes->status == "reservado"): ?>
                                        <td><span class="badge badge-pill badge-info">Reservado</span></td>
                                    <?php elseif($negociacoes->status == "vendido"): ?>
                                        <td><span class="badge badge-pill badge-success">Vendido</span></td>
                                    <?php else: ?>
                                        <td><span class="badge badge-pill badge-danger">Cancelado</span></td>
                                    <?php endif; ?>
                                    <td><?= date("d/m/Y",strtotime($negociacoes->dataNegociacao)); ?> ás <?= date("H:i",strtotime($negociacoes->dataNegociacao)); ?></td>


                                    <?php if($usuario->nivel == "administrador"): ?>
                                        <td class="text-right">
                                            <?php if($negociacoes->status != "cancelado"): ?>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a style="cursor:pointer;" class="dropdown-item" onclick="alteraStatus('cancelar','<?= $negociacoes->Id_negociacao ?>')">Cancelar</a>

                                                    <?php if($negociacoes->status == "reservado"): ?>
                                                        <a style="cursor:pointer;" class="dropdown-item" onclick="alteraStatus('vender','<?= $negociacoes->Id_negociacao ?>')">Vender</a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>

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
