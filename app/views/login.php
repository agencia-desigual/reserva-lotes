<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de reserva de loateamentos.">
    <meta name="author" content="Agência desigual">
    <link rel='manifest' href='/manifest.json'>
    <title><?= SITE_NOME; ?> | Gerenciador de Lotes</title>
    <!-- Favicon -->
    <link href="<?= BASE_STORANGE; ?>assets/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="<?= BASE_STORANGE; ?>assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="<?= BASE_STORANGE; ?>assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="<?= BASE_STORANGE; ?>assets/css/argon.css?v=1.0.0" rel="stylesheet">
</head>

<body style="background: #40989c; background-image: url('<?= BASE_STORANGE; ?>assets/img/bg.png'); background-repeat: no-repeat; background-size: auto 120%; height: 100vh;">
    <div class="main-content">
        <!-- Header -->
        <div class="header py-7 py-lg-8" style="background: transparent;">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white" style="opacity: 0;">Login GreenPark!</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">

                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <img src="<?= BASE_STORANGE; ?>assets/img/brand/logo.png" />
                            </div>
                            <form id="formLogin">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="E-mail" type="email" name="email" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Senha" type="password" name="senha" />
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-default my-4" id="btn_form" style="background-color: #2b4c45; border-color: #2b4c45; padding: 10px 50px;">ENTRAR</button>
                                </div>
                                <div class="text-center">
                                    <a href="#" data-toggle="modal" data-target="#novoCorretor">
                                        <button type="button" class="btn btn-default my-4" style="background-color: transparent; color: #2b4c45; border: none; padding: 10px 50px;">Quero ser um corretor</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="novoCorretor" tabindex="-1" role="dialog" aria-labelledby="novoCorretor" aria-hidden="true">
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
                                    <input name="status" type="hidden" value="desativo">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input name="nivel" type="hidden" value="user">
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

    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="<?= BASE_STORANGE; ?>assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?= BASE_STORANGE; ?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Plugins -->
    <script src="<?= BASE_STORANGE; ?>plugins/mascara/mascara.js"></script>
    <script src="<?= BASE_STORANGE; ?>assets/js/custom/global.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>

    <!-- Configurações -->
    <script src="<?= BASE_URL; ?>arquivos/assets/js/custom/global.js"></script>
    <script src="<?= BASE_URL; ?>arquivos/assets/js/custom/painel.js"></script>


    <script src="/pwabuilder-sw.js"></script>
    <script src="/pwabuilder-sw-register.js"></script>

    <script>
        $("#formLogin").on("submit", function(){
            
            // Não carrega 
            event.preventDefault();

            // Pega os dados do form 
            var form = new FormData(this);

            // Bloqueia o Botão
            $("#btn_form").attr("disabled",true);
            $("#btn_form").html("Processando...");

            $.ajaxSetup({
                processData: false,
                contentType: false
            });

            // faz o login
            $.post("<?= BASE_URL; ?>usuario/login", form, (data) => {

                // Verifica se retornou true
                if(data.tipo == true)
                {
                    // Session
                    var session = new Session();

                    // Salva os dados do usuário na session
                    session.set("usuario", data.objeto);

                    // Exibe o alerta de sucesso
                    Swal.fire({
                        type: 'success',
                        title: 'Sucesso!',
                        text: "Aguarde, estamos te redirecionando."
                    });


                    // Redireciona o usuário
                    setTimeout(() => {
                        location.href = "<?= BASE_URL; ?>";
                    }, 2000);
                }
                else
                {
                    // Avisa que deu ruim
                    Swal.fire({
                        type: 'error',
                        title: 'Opss!',
                        text: data.mensagem
                    });
                }

                // Desbloqueia o Botão
                $("#btn_form").attr("disabled",false);
                $("#btn_form").html("ENTRAR");

            }, "json");

            // Não carrega Mesmo!!
            return false;
        });
    </script>
</body>
</html>