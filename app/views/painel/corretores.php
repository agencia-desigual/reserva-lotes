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
                            <h3 class="mb-0">Corretores</h3>
                        </div>
                        <div class="col">
                            <button style="float: right;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#adicionarCorretor">
                                Adicionar
                            </button>
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
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Empresa</th>
                                <th scope="col">CNPJ</th>
                                <th scope="col">Nivel</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($corretores as $corretor): ?>
                                <tr>
                                    <td><?= $corretor->Id_corretor; ?></td>
                                    <td><?= $corretor->nome ?></td>
                                    <td><?= $corretor->empresa ?></td>
                                    <td><?= $corretor->cnpj; ?></td>
                                    <td><?= ($corretor->nivel == "user") ? "Corretor" : "Administrador"; ?></td>
                                    <td><span class='badge badge-pill<?= ($corretor->status == true) ? " badge-success'>Ativo" : " badge-warning'>Inativo"; ?></span></td>
                                    <td class="text-right">
                                        <?php if($usuario->nivel == "administrador"): ?>
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a style="cursor:pointer;" class="dropdown-item" onclick="alterarStatus('<?= $corretor->Id_usuario; ?>')">Alterar Status</a>
                                                    <a href="<?= BASE_URL; ?>corretor/editar/<?= $corretor->Id_corretor; ?>" class="dropdown-item">Alterar Dados</a>
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




    <div class="modal fade" id="alterarUsuario" tabindex="-1" role="dialog" aria-labelledby="alterarUsuario" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_alterarUsuario">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Nível do usuário</label>
                                <select required="true" id="input_nivel" class="form-control">
                                    <option disabled selected>Selecione o nível</option>
                                    <option value="user">Corretor</option>
                                    <option value="corretor">Administrador</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Status</label>
                                <select id="input_status" required="true" class="form-control">
                                    <option disabled selected>Selecione o status</option>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="Id_usuario" id="idUsuario" />

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




    <div class="modal fade" id="adicionarCorretor" tabindex="-1" role="dialog" aria-labelledby="adicionarCorretor" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de corretor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formNovoCorretor">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nome*</label>
                                    <input required name="nome" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email*</label>
                                    <input required name="email" type="email" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Senha*</label>
                                    <input required name="senha" type="password" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirmar Senha*</label>
                                    <input required name="c_senha" type="password" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input name="telefone" type="text" class="form-control form-control-alternative maskTel">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Celular</label>
                                    <input name="celular" type="text" class="form-control form-control-alternative maskCel">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CNJP*</label>
                                    <input required name="cnpj" type="text" class="form-control form-control-alternative maskCNPJ">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Empresa*</label>
                                    <input required name="empresa" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CRECI*</label>
                                    <input required name="creci" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>




                            <!-- ENDEREÇO -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CEP*</label>
                                    <input required name="cep" onblur="BuscaCEP(this.value)" id="input_cep" type="text" class="form-control form-control-alternative maskCEP">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Estado*</label>
                                    <input required name="estado" id="input_estado" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cidade*</label>
                                    <input required name="cidade" id="input_cidade" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Bairro*</label>
                                    <input required name="bairro" id="input_bairro" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Logradouro*</label>
                                    <input required name="logradouro" id="input_logradouro" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Numero*</label>
                                    <input required name="numero" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Complemento</label>
                                    <input name="complemento" type="text" class="form-control form-control-alternative">
                                </div>
                            </div>

                            <!-- FIM ENDEREÇO -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Status*</label>
                                    <select required name="status" class="form-control">
                                        <option disabled selected>Selecione</option>
                                        <option value="ativo">Ativo</option>
                                        <option value="desativo">Inativo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Nível*</label>
                                    <select required name="nivel" class="form-control">
                                        <option disabled selected>Selecione</option>
                                        <option value="user">Corretor</option>
                                        <option value="administrador">Administrador</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button id="btn_cadastrar" type="submit" class="btn btn-primary">Cadastrar</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




<?php $this->view("painel/include/footer"); ?>



<script>

    function alterarStatus(id)
    {
        $("#idUsuario").val(id);

        $("#alterarUsuario").modal("show");
    }



    $("#form_alterarUsuario").on("submit", function () {

        // n carrega
        event.preventDefault();

        var form = {
            "Id_usuario": $("#idUsuario").val(),
            "nivel" : $("#input_nivel").val(),
            "status" : $("#input_status").val()
        }

        $.post(BASE_URL + "corretor/altera-status",form,(data) => {

            if(data.tipo === true)
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
                    title: 'Erro...',
                    text: data.mensagem,
                })
            }

        }, "json");


        // Nao carrega
        return false;
    });

</script>
