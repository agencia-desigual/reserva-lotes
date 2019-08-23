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
                <h3 class="mb-0"><?= ($usuario->Id_usuario == $user[0]->Id_usuario) ? "Meus Dados" : "Informações do usuário"; ?></h3>
            </div>
        </div>
    </div>

        <div style="padding: 30px" class="row">
            <div class="col-md-12">
                <form id="formAlterarCorretor">
                    <input type="hidden" name="Id_endereco" value="<?= $endereco[0]->Id_endereco ?>">
                    <input type="hidden" name="Id_corretor" value="<?= $corretor[0]->Id_corretor ?>">
                    <input type="hidden" name="Id_usuario" value="<?= $user[0]->Id_usuario ?>">
                    <div class="row">

                        <!-- NOME -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Nome*</label>
                                <input required name="nome" type="text" class="form-control form-control-alternative" value="<?= $user[0]->nome ?>">
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Email*</label>
                                <p><?= $user[0]->email ?></p>
                            </div>
                        </div>

                        <!-- SENHA -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Senha*</label>
                                <input name="senha" type="password" class="form-control form-control-alternative">
                            </div>
                        </div>

                        <!-- CONFIRMAR SENHA -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirmar Senha*</label>
                                <input name="c_senha" type="password" class="form-control form-control-alternative">
                            </div>
                        </div>

                        <!-- TELEFONE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input name="telefone" type="text" class="form-control form-control-alternative maskTel" value="<?= $corretor[0]->telefone ?>">
                            </div>
                        </div>

                        <!-- CELULAR -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Celular</label>
                                <input name="celular" type="text" class="form-control form-control-alternative maskCel" value="<?= $corretor[0]->celular ?>">
                            </div>
                        </div>

                        <!-- CNPJ -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CNPJ</label>
                                <input name="cnpj" type="text" class="form-control form-control-alternative maskCNPJ" value="<?= $corretor[0]->cnpj ?>" />
                            </div>
                        </div>

                        <!-- EMPRESA -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Empresa</label>
                                <input name="empresa" type="text" class="form-control form-control-alternative" value="<?= $corretor[0]->empresa ?>" />
                            </div>
                        </div>

                        <!-- CRECI -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CRECI</label>
                                <input name="creci" type="text" class="form-control form-control-alternative" value="<?= $corretor[0]->creci ?>" />
                            </div>
                        </div>

                        <!-- CEP -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CEP*</label>
                                <input required name="cep" onblur="BuscaCEP(this.value)" id="input_cep" type="text" class="form-control form-control-alternative maskCEP" value="<?= $endereco[0]->cep ?>" >
                            </div>
                        </div>

                        <!-- ESTADO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado*</label>
                                <input required name="estado" id="input_estado" type="text" class="form-control form-control-alternative" value="<?= $endereco[0]->estado ?>" >
                            </div>
                        </div>

                        <!-- CIDADE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cidade*</label>
                                <input required name="cidade" id="input_cidade" type="text" class="form-control form-control-alternative" value="<?= $endereco[0]->cidade ?>">
                            </div>
                        </div>

                        <!-- BAIRRO -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Bairro*</label>
                                <input required name="bairro" id="input_bairro" type="text" class="form-control form-control-alternative" value="<?= $endereco[0]->bairro ?>">
                            </div>
                        </div>

                        <!-- LOGRADOURO -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Logradouro*</label>
                                <input required name="logradouro" id="input_logradouro" type="text" class="form-control form-control-alternative" value="<?= $endereco[0]->logradouro ?>">
                            </div>
                        </div>

                        <!-- NUMERO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Numero*</label>
                                <input required name="numero" type="text" class="form-control form-control-alternative" value="<?= $endereco[0]->numero ?>" >
                            </div>
                        </div>

                        <!-- COMPLEMENTO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Complemento</label>
                                <input name="complemento" type="text" class="form-control form-control-alternative" value="<?= $endereco[0]->complemento ?>">
                            </div>
                        </div>

                        <!-- STATUS -->
                        <?php if($usuario->nivel == "administrador"): ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Status*</label>
                                    <select required name="status" class="form-control">
                                        <option disabled>Selecione</option>
                                        <option value="ativo" <?= ($user[0]->status == true)  ? 'selected' : '' ?>>Ativo</option>
                                        <option value="desativo" <?= ($user[0]->status == false)  ? 'selected' : '' ?>>Inativo</option>
                                    </select>
                                </div>
                            </div>

                            <!-- NÍVEL -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Nível*</label>
                                    <select required name="nivel" class="form-control">
                                        <option disabled>Selecione</option>
                                        <option value="user" <?= ($user[0]->nivel == "user")  ? 'selected' : '' ?>>Corretor</option>
                                        <option value="administrador" <?= ($user[0]->nivel == "administrador")  ? 'selected' : '' ?>>Administrador</option>
                                    </select>
                                </div>
                            </div>
                        <?php else: ?>
                            <input type="hidden" name="nivel" value="<?= $user[0]->nivel ?>" />
                            <input type="hidden" name="status" value="<?= $user[0]->status ?>" />
                        <?php endif; ?>


                        <div class="modal-footer">
                            <button id="btn_alterar" type="submit" class="btn btn-primary">Alterar</button>
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


<?php $this->view("painel/include/footer"); ?>