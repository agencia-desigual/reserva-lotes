<?php

// Unidades de medida
define('KB', 1024);
define('MB', 1048576);
define('GB', 1073741824);
define('TB', 1099511627776);

define('SITE_NOME','GreenPark');

// Configuração de email
define("EMAIL_CONFIG", [
    "host" => "smtp.gmail.com",
    "port" => "465",
    "autenticacao" => true,
    "seguranca" => "ssl",
    "email" => "mail@desigual.com.br",
    "senha" => "Desigu@al#!147",
    "charset" => "UTF-8"
]);



// Push configure
define('pusher_app_id', '470164');
define('pusher_app_key', '12119d4ea9fa000fbac7');
define('pusher_app_secret', '59985abc96a77c088ebf');
define('pusher_debug', false);

define('pusher_scheme', null);
define('pusher_host', null);
define('pusher_port', null);
define('pusher_timeout', null);
define('pusher_encrypted', null);