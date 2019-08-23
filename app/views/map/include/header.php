<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= SITE_NOME ?> | Sistema de Vendas </title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Icones -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css"
          integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_STORANGE; ?>assets/css/map.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_STORANGE; ?>plugins/toastr.js/toastr.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= BASE_STORANGE; ?>plugins/dropify/css/dropify.css" />

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<header>
    <a href="<?= BASE_URL; ?>">
        <img src="<?= BASE_STORANGE; ?>assets/img/brand/logo.png" />
    </a>


    <?php if(isset($quadra)): ?>
        <a href="<?= BASE_URL; ?>quadra">
            <button class="closed">
                <i class="fas fa-arrow-left"></i>
            </button>
        </a>
    <?php else: ?>
        <a href="<?= BASE_URL; ?>sair">
            <button class="closed">
                <i class="fas fa-power-off"></i>
            </button>
        </a>
    <?php endif; ?>

</header>