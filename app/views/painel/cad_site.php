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

    <div class="row mt-5">
        <div class="col-xl-12 mb-12 mb-xl-12">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Cadastros Site</h3>
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
                                <th scope="col">nome</th>
                                <th scope="col">email</th>
                                <th scope="col">celular</th>
                                <th scope="col">renda</th>
                                <th scope="col">profissão</th>
                                <th scope="col">ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($cadastros as $cadastro): ?>
                                <tr>
                                    <td><?= $cadastro->nome ?></td>
                                    <td><?= $cadastro->email ?></td>
                                    <td><?= $cadastro->celular ?></td>
                                    <td><?= number_format($cadastro->renda, 2, ',', '.'); ?></td>
                                    <td><?= $cadastro->profissao ?></td>
                                    <td class="text-right">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a href="#" onclick="verCadastroSite(<?= $cadastro->Id_sitecadastro ?>)" class="dropdown-item">Visualizar</a>
                                        </div>
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
    <div class="modal fade" id="verCadastro" tabindex="-1" role="dialog" aria-labelledby="verCadastro" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro Site</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="visualizarCadastro">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <p id="nomeCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <p id="emailCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>RG</label>
                                    <p id="rgCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CPF</label>
                                    <p id="cpfCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CEP</label>
                                    <p id="cepCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cidade</label>
                                    <p id="cidadeCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bairro</label>
                                    <p id="bairroCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Profissão</label>
                                    <p id="profissaoCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Trabalho</label>
                                    <p id="trabalhoCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Renda</label>
                                    <p id="rendaCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Intenção</label>
                                    <p id="intencaoCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tem Corretor</label>
                                    <p id="temCorretorCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nome Corretor</label>
                                    <p id="nomeCorretorCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CRECI</label>
                                    <p id="creciCadastro"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Informações</label>
                                    <p id="informacoesCadastro"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->view("painel/include/footer"); ?>