<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema automatizador de posts.">
    <meta name="author" content="Agência desigual">
    <title>Sistema de Lotes | GrennPark</title>
    <!-- Favicon -->
    <link href="<?= BASE_URL; ?>arquivos/assets/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="<?= BASE_URL; ?>arquivos/assets/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="<?= BASE_URL; ?>arquivos/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>arquivos/plugins/datatables/css/css.css" />
    <link rel="stylesheet" href="<?= BASE_URL; ?>arquivos/plugins/selectize/css/selectize.default.css" />
    <link type="text/css" href="<?= BASE_URL; ?>arquivos/assets/css/argon.css?v=1.0.0" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
</head>

<body>



<!-- Sidenav -->
<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Botão do Menu">
            <span class="navbar-toggler-icon"></span>
        </button>


        <!-- Brand -->
        <a class="navbar-brand pt-0" href="<?= BASE_URL; ?>">
            <img src="<?= BASE_URL; ?>arquivos/assets/img/brand/logo.png" class="navbar-brand-img" alt="Green Park" />
        </a>


        <!-- User -->
        <ul class="nav align-items-center d-md-none">

            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                      <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="<?= BASE_URL; ?>arquivos/assets/img/brand/perfil.jpg">
                      </span>
                    </div>
                </a>

                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Olá, <?= $usuario->nome; ?></h6>
                    </div>
                    <a href="<?= BASE_URL; ?>perfil" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>Meu Perfil</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="<?= BASE_URL; ?>sair" class="dropdown-item">
                        <i class="ni ni-user-run"></i>
                        <span>Sair</span>
                    </a>
                </div>
            </li>
        </ul>


        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="<?= BASE_URL; ?>">
                            <img src="<?= BASE_URL; ?>arquivos/assets/img/brand/logo.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL; ?>">
                        <i class="ni ni-planet text-primary"></i> Início
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL; ?>reserva">
                        <i class="ni ni-button-play text-red"></i> Reservar Lote
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL; ?>quadra">
                        <i class="ni ni-map-big text-blue"></i> Vizualizar Mapa
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL; ?>negociacaoes">
                        <i class="ni ni-check-bold text-blue"></i> Minhas Negociações
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL; ?>lotes">
                        <i class="ni ni-pin-3 text-primary"></i> Lotes
                    </a>
                </li>

                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>sair" class="dropdown-item">
                        <i style="margin-right: 15px;" class="ni ni-user-run text-primary"></i> Sair
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>




<!-- Main content -->
<div class="main-content">
    <!-- Top navbar -->
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Form -->
            <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto"></form>

            <!-- User -->
            <ul class="navbar-nav align-items-center d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                  <img alt="Image placeholder" src="<?= BASE_URL; ?>arquivos/assets/img/brand/perfil.jpg">
                </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold"><?= $usuario->nome; ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Olá, <?= $usuario->nome; ?></h6>
                        </div>
                        <a href="<?= BASE_URL; ?>perfil" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>Meu Perfil</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?= BASE_URL; ?>sair" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Sair</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>