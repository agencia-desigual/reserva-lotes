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
                            <h3 class="mb-0">Clientes</h3>
                        </div>
                        <button id="btn_adicionar" style="cursor:pointer;" data-toggle="modal" data-target="#modalAdicionar" class="btn btn-primary">Adicionar</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <!-- Projects table -->
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush datatable">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col">CPF</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Celular</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= $cliente->nome ?></td>
                                    <td><?= $cliente->cpf; ?></td>
                                    <td><?= $cliente->email ?></td>
                                    <td><?= $cliente->celular ?></td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a style="cursor:pointer;" class="dropdown-item" onclick="visualizar('<?= $cliente->Id_cliente; ?>')">Visualizar</a>
                                                <a style="cursor:pointer;" class="dropdown-item" onclick="editar('<?= $cliente->Id_cliente; ?>')">Editar</a>
                                            </div>
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



    <div class="modal fade" id="modalVizualizar" tabindex="-1" role="dialog" aria-labelledby="modalVizualizar" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informações do cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="h6"><strong>NOME</strong></p>
                            <p class="h3 font-weight-normal" id="txt_nome"></p>
                        </div>


                        <div class="col-md-12 pt-4">
                            <p class="h6"><strong>E-MAIL</strong></p>
                            <p class="h3 font-weight-normal" id="txt_email"></p>
                        </div>


                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>DATA NASCIMENTO</strong></p>
                            <p class="h3 font-weight-normal" id="txt_datanasc"></p>
                        </div>

                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>ESTADO CIVIL</strong></p>
                            <p class="h3 font-weight-normal" id="txt_estadocivil"></p>
                        </div>


                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>CPF</strong></p>
                            <p class="h3 font-weight-normal" id="txt_cpf"></p>
                        </div>

                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>RG</strong></p>
                            <p class="h3 font-weight-normal" id="txt_rg"></p>
                        </div>


                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>TELEFONE</strong></p>
                            <p class="h3 font-weight-normal" id="txt_telefone"></p>
                        </div>

                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>CELULAR</strong></p>
                            <p class="h3 font-weight-normal" id="txt_celular"></p>
                        </div>

                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>PROFISSÃO</strong></p>
                            <p class="h3 font-weight-normal" id="txt_profissao"></p>
                        </div>

                        <div class="col-md-6 pt-4">
                            <p class="h6"><strong>LOCAL DE TRABALHO</strong></p>
                            <p class="h3 font-weight-normal" id="txt_localtrabalho"></p>
                        </div>

                        <div class="col-md-12 pt-4">
                            <p class="h6"><strong>RENDA</strong></p>
                            <p class="h3 font-weight-normal" id="txt_renda"></p>
                        </div>


                        <div class="col-md-12 pt-4">
                            <p class="h6"><strong>CPF</strong></p>
                            <a href="" id="link_cpf" target="_blank">
                                <p class="h3 font-weight-normal">Download</p>
                            </a>
                        </div>

                        <div class="col-md-12 pt-4">
                            <p class="h6"><strong>RG</strong></p>
                            <a href="" id="link_rg" target="_blank">
                                <p class="h3 font-weight-normal">Download</p>
                            </a>
                        </div>


                        <div class="col-md-12 pt-4">
                            <p class="h6"><strong>COMPROVANTE DE RESIDENCIA</strong></p>
                            <a href="" id="link_residencia" target="_blank">
                                <p class="h3 font-weight-normal">Download</p>
                            </a>
                        </div>


                        <div class="col-md-12 pt-4" id="divCertidao">
                            <p class="h6"><strong>CERTIDÃO DE CASAMENTO</strong></p>
                            <a href="" id="link_certidao" target="_blank">
                                <p class="h3 font-weight-normal">Download</p>
                            </a>
                        </div>


                        <div class="col-12 pt-5" style="padding-left: 0; padding-right: 0px;" id="div_esposa">
                            <div class="col-md-12">
                                <p class="h4"><strong>Informações da(o) esposa(o)</strong></p>
                            </div>

                            <div class="col-md-12  pt-3">
                                <p class="h6"><strong>NOME</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_nome"></p>
                            </div>


                            <div class="col-md-12 pt-4">
                                <p class="h6"><strong>E-MAIL</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_email"></p>
                            </div>


                            <div class="col-md-6  pt-4">
                                <p class="h6"><strong>DATA NASCIMENTO</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_datanasc"></p>
                            </div>

                            <div class="col-md-6  pt-4">
                                <p class="h6"><strong>ESTADO CIVIL</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_estadocivil"></p>
                            </div>


                            <div class="col-md-6 pt-4">
                                <p class="h6"><strong>CPF</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_cpf"></p>
                            </div>

                            <div class="col-md-6 pt-4">
                                <p class="h6"><strong>RG</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_rg"></p>
                            </div>


                            <div class="col-md-6 pt-4">
                                <p class="h6"><strong>TELEFONE</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_telefone"></p>
                            </div>

                            <div class="col-md-6 pt-4">
                                <p class="h6"><strong>CELULAR</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_celular"></p>
                            </div>

                            <div class="col-md-6 pt-4">
                                <p class="h6"><strong>PROFISSÃO</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_profissao"></p>
                            </div>

                            <div class="col-md-6 pt-4">
                                <p class="h6"><strong>LOCAL DE TRABALHO</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_localtrabalho"></p>
                            </div>

                            <div class="col-md-12 pt-4">
                                <p class="h6"><strong>RENDA</strong></p>
                                <p class="h3 font-weight-normal" id="txt_eps_renda"></p>
                            </div>


                            <div class="col-md-12 pt-4">
                                <p class="h6"><strong>CPF</strong></p>
                                <a href="" id="link_eps_cpf" target="_blank">
                                    <p class="h3 font-weight-normal">Download</p>
                                </a>
                            </div>

                            <div class="col-md-12 pt-4">
                                <p class="h6"><strong>RG</strong></p>
                                <a href="" id="link_eps_rg" target="_blank">
                                    <p class="h3 font-weight-normal">Download</p>
                                </a>
                            </div>
                        </div>


                        <div class="col-12 pt-5" style="padding-left: 0; padding-right: 0px;" id="div_endereco">
                            <div class="col-md-12">
                                <p class="h4"><strong>Informações do Endereço</strong></p>
                            </div>

                            <div class="col-md-6 pt-3">
                                <p class="h6"><strong>CEP</strong></p>
                                <p class="h3 font-weight-normal" id="txt_cep"></p>
                            </div>

                            <div class="col-md-6 pt-4">
                                <p class="h6"><strong>CIDADE / ESTADO</strong></p>
                                <p class="h3 font-weight-normal" id="txt_cidade"></p>
                            </div>

                            <div class="col-md-12 pt-4">
                                <p class="h6"><strong>BAIRRO</strong></p>
                                <p class="h3 font-weight-normal" id="txt_bairro"></p>
                            </div>


                            <div class="col-md-12 pt-4">
                                <p class="h6"><strong>LOGRADOURO</strong></p>
                                <p class="h3 font-weight-normal" id="txt_logradouro"></p>
                            </div>

                            <div class="col-md-12 pt-4">
                                <p class="h6"><strong>COMPLEMENTO</strong></p>
                                <p class="h3 font-weight-normal" id="txt_complemento"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="modalEditar" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="formAlterarCliente">

                        <div class="row">
                            <input id="Id_cliente" name="Id_cliente" type="hidden" value="">
                            <input id="Id_endereco" name="Id_endereco" type="hidden" value="">
                            <input id="Id_esposa" name="Id_esposa" type="hidden" value="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CPF</label>
                                    <input type="tel" name="cpf" id="input_cpf" class="maskCPF form-control" />
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
                                        <option disabled>Selecione o estado civil</option>
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
                                        <input type="text" name="dataNascimento" class="form-control maskData" id="input_dataNascimento" />
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
                                            <input type="text" name="esp_dataNascimento" class="form-control" id="input_esp_datanasc" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Local de Trabalho</label>
                                            <input type="text" name="esp_localTrabalho" class="form-control" id="input_esp_localtrabalho" />
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
                                            <label>Foto do RG Esposa(o)</label>
                                            <input type="file" name="esp_arquivo_rg" accept="image/*" capture="camera" class="dropify" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Foto do CPF Esposa(o)</label>
                                            <input type="file" name="esp_arquivo_cpf" accept="image/*" capture="camera" class="dropify" />
                                        </div>
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
                            <button id="btn_alterar" type="submit" class="btn btn-primary">Alterar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdicionar" tabindex="-1" role="dialog" aria-labelledby="modalAdicionar" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Adicionar cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form id="formAdicionarCliente">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>CPF</label>
                                        <input type="tel" name="cpf" class="maskCPF form-control" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>RG</label>
                                        <input type="tel" name="rg" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="nome" class="form-control" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Estado Civil</label>
                                        <select name="estadoCivil" class="form-control" onchange="verificaEstadoCivil(this.value)">
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
                                    <input type="email" class="form-control" name="email" />
                                </div>
                            </div>

                            <div id="div_someCliente" style="display: block; width: 100%;">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Renda</label>
                                            <input type="tel" name="renda" class="maskValor form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Data de Nascimento</label>
                                            <input type="text" name="dataNascimento" class="form-control maskData" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Local de Trabalho</label>
                                            <input type="text" name="localTrabalho" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Profissão</label>
                                            <input type="text" name="profissao" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="tel" name="telefone" class="maskTel form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Celular</label>
                                            <input type="tel" name="celular" class="maskCel form-control" />
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
                                            <input type="tel" name="cep" onblur="buscaCEP(this.value)" class="maskCEP form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bairro</label>
                                            <input type="text" name="bairro" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cidade</label>
                                            <input type="text" name="cidade" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <input type="text" name="estado" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Endereço</label>
                                            <input type="text" name="endereco" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Número</label>
                                            <input type="text" name="numero" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Complemento</label>
                                            <input type="text" name="complemento" class="form-control" />
                                        </div>
                                    </div>
                                </div>

                                <div id="div_casado_add" class="pt-3 pb-3" style="display: none; width: 100%;">
                                    <h4 style="clear: both; padding-top: 30px;">Informações da(o) Esposa(o)</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>CPF</label>
                                                <input type="tel" name="esp_cpf" class="maskCPF form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>RG</label>
                                                <input type="tel" name="esp_rg" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nome</label>
                                                <input type="text" name="esp_nome" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" name="esp_email" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="esp_estadoCivil" value="casado" />

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Renda</label>
                                                <input type="tel" name="esp_renda" class="maskValor form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Data de Nascimento</label>
                                                <input type="text" name="esp_dataNascimento" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Local de Trabalho</label>
                                                <input type="text" name="esp_localTrabalho" class="form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Profissão</label>
                                                <input type="text" name="esp_profissao" class="form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Telefone</label>
                                                <input type="tel" name="esp_telefone" class="maskTel form-control" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Celular</label>
                                                <input type="tel" name="esp_celular" class="maskCel form-control" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto do RG Esposa(o)</label>
                                                <input type="file" name="esp_arquivo_rg" accept="image/*" capture="camera" class="dropify" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Foto do CPF Esposa(o)</label>
                                                <input type="file" name="esp_arquivo_cpf" accept="image/*" capture="camera" class="dropify" />
                                            </div>
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
                                <button id="btn_adicionar" type="submit" class="btn btn-primary">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


<?php $this->view("painel/include/footer"); ?>

        <script src="<?= BASE_STORANGE; ?>assets/js/funcoes.js"></script>

<script>

    function visualizar(id)
    {
        // Busca o cliente
        $.get(BASE_URL + "cliente/get/" + id, {}, (data) => {

            // Verifica
            if(data.tipo == true)
            {
                // Pega os dados
                var cliente = data.objeto;
                var esposa = cliente.esposa;
                var endereco = cliente.endereco;

                // Add os dados do cliente
                $("#txt_nome").html(cliente.nome);
                $("#txt_email").html(cliente.email);
                $("#txt_datanasc").html(cliente.dataNascimento);
                $("#txt_telefone").html(cliente.telefone);
                $("#txt_celular").html(cliente.celular);
                $("#txt_cpf").html(cliente.cpf);
                $("#txt_rg").html(cliente.rg);
                $("#txt_profissao").html(cliente.profissao);
                $("#txt_localtrabalho").html(cliente.localTrabalho);
                $("#txt_renda").html(cliente.renda.replace(',00',''));
                $("#txt_estadocivil").html(cliente.estadoCivil);
                $("#link_cpf").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_cpf);
                $("#link_rg").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_rg);
                $("#link_residencia").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_residencia);

                // Verifica se é casado
                if(esposa != null && esposa != "" && esposa != undefined)
                {
                    $("#link_certidao").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_casamento);

                    $("#div_esposa").css("display","block");
                    $("#divCertidao").css("display","block");

                    $("#txt_eps_nome").html(esposa.nome);
                    $("#txt_eps_email").html(esposa.email);
                    $("#txt_eps_datanasc").html(esposa.dataNascimento);
                    $("#txt_eps_telefone").html(esposa.telefone);
                    $("#txt_eps_celular").html(esposa.celular);
                    $("#txt_eps_cpf").html(esposa.cpf);
                    $("#txt_eps_rg").html(esposa.rg);
                    $("#txt_eps_profissao").html(esposa.profissao);
                    $("#txt_eps_localtrabalho").html(esposa.localTrabalho);
                    $("#txt_eps_renda").html(esposa.renda.replace(',00',''));
                    $("#txt_eps_estadocivil").html(esposa.estadoCivil);
                    $("#link_eps_cpf").attr("href",BASE_URL + "arquivos/storange/documentos/" + esposa.Id_cliente + "/" + esposa.img_cpf);
                    $("#link_eps_rg").attr("href",BASE_URL + "arquivos/storange/documentos/" + esposa.Id_cliente + "/" + esposa.img_rg);
                }
                else
                {
                    $("#divCertidao").css("display","none");
                    $("#div_esposa").css("display","none");
                }

                // Verifica se possui endereco
                if(endereco != null && endereco != "" && endereco != undefined)
                {
                    $("#div_endereco").css("display","block");

                    $("#txt_cep").html(endereco.cep);
                    $("#txt_cidade").html(endereco.cidade + "/" + endereco.estado);
                    $("#txt_logradouro").html(endereco.logradouro + ", Nº " + endereco.numero);
                    $("#txt_bairro").html(endereco.bairro);
                    $("#txt_complemento").html(endereco.complemento);
                }
                else
                {
                    $("#div_endereco").css("display","none");
                }

                $("#modalVizualizar").modal("show");
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Erro...',
                    text: data.mensagem,
                });
            }

        }, "json");

    } // END >> Fun::visualizar()

    function editar(id)
    {
        // Busca o cliente
        $.get(BASE_URL + "cliente/get/" + id, {}, (data) => {

            // Verifica
            if(data.tipo == true)
            {
                // Pega os dados
                var cliente = data.objeto;
                var esposa = cliente.esposa;
                var endereco = cliente.endereco;
                var estado_civil = "";

                // Add os dados do cliente
                $("#Id_cliente").val(cliente.Id_cliente);
                $("#Id_endereco").val(cliente.Id_endereco);
                $("#input_email").val(cliente.email);
                $("#input_nome").val(cliente.nome);
                $("#input_dataNascimento").val(cliente.dataNascimento);
                $("#input_telefone").val(cliente.telefone);
                $("#input_celular").val(cliente.celular);
                $("#input_cpf").val(cliente.cpf);
                $("#input_rg").val(cliente.rg);
                $("#input_profissao").val(cliente.profissao);
                $("#input_localTrabalho").val(cliente.localTrabalho);
                $("#input_renda").val(cliente.renda.replace(',00',''));
                $("#input_estadoCivil").val(cliente.estadoCivil);
                $("#link_cpf_editar").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_cpf);
                $("#link_rg_editar").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_rg);
                $("#link_residencia_editar").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_residencia);

                // Verifica se é casado
                if(esposa != null && esposa != "" && esposa != undefined)
                {
                    verificaEstadoCivil('casado');

                    $("#Id_esposa").val(cliente.Id_esposa);

                    $("#link_certidao_editar").attr("href",BASE_URL + "arquivos/storange/documentos/" + cliente.Id_cliente + "/" + cliente.img_casamento);

                    $("#div_esposa").css("display","block");
                    $("#divCertidaoEditar").css("display","block");

                    $("#input_esp_nome").val(esposa.nome);
                    $("#input_esp_email").val(esposa.email);
                    $("#input_esp_datanasc").val(esposa.dataNascimento);
                    $("#input_esp_telefone").val(esposa.telefone);
                    $("#input_esp_celular").val(esposa.celular);
                    $("#input_esp_cpf").val(esposa.cpf);
                    $("#input_esp_rg").val(esposa.rg);
                    $("#input_esp_profissao").val(esposa.profissao);
                    $("#input_esp_localtrabalho").val(esposa.localTrabalho);
                    $("#input_esp_renda").val(esposa.renda.replace(',00',''));
                    $("#input_esp_estadocivil").val(esposa.estadoCivil);
                    $("#link_eps_cpf").attr("href",BASE_URL + "arquivos/storange/documentos/" + esposa.Id_cliente + "/" + esposa.img_cpf);
                    $("#link_eps_rg").attr("href",BASE_URL + "arquivos/storange/documentos/" + esposa.Id_cliente + "/" + esposa.img_rg);
                }
                else
                {
                    $("#divCertidao").css("display","none");
                    $("#div_esposa").css("display","none");
                }

                // Verifica se possui endereco
                if(endereco != null && endereco != "" && endereco != undefined)
                {
                    $("#div_endereco").css("display","block");

                    $("#input_cep").val(endereco.cep);
                    $("#input_cidade").val(endereco.cidade);
                    $("#input_estado").val(endereco.estado);
                    $("#input_endereco").val(endereco.logradouro);
                    $("#input_numero").val(endereco.numero);
                    $("#input_bairro").val(endereco.bairro);
                    $("#input_complemento").val(endereco.complemento);
                }
                else
                {
                    $("#div_endereco").css("display","none");
                }

                $("#modalEditar").modal("show");
            }
            else
            {
                Swal.fire({
                    type: 'error',
                    title: 'Erro...',
                    text: data.mensagem,
                });
            }

        }, "json");

    } // END >> Fun::editar()

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
