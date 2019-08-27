<?php
/**
 * ======================================================
 * ======================================================
 * ======================================================
 *
 *  Este arquivo é responsavel por todas as configurações de
 *  rotas do sistema.
 *
 *  ---------------------------------------------------------
 *
 *  - Como criar uma rota?
 *
 *  Todas as rotas são configuradas dentro do array "rotas"
 *
 *
 *  Exemplo:
 *
 *
 *  $rotas [
 *      "PRIMEIRO ITEM DA URL " => [
 *          "controller" => "CONTROLLER QUE DEVE SER CHAMADO",
 *          "metodos" => [
 *              "SEGUNDO ITEM DA URL" => [
 *                  "metodo" => "METODO DO CONTROLLER QUE DEVE SER CHAMADO",
 *                  "parametros" => "QUANTIDADE ITENS QUE DEVE PASSAR POR PARAMETROS"
 *              ],
 *          ],
 *      ]
 * ];
 *
 *
 *  ---------------------------------------------------------
 *
 *  Para configurar a rota da página incial, usa-se no array de rotas
 *  o item default
 *
 *
 *  EXEMPLO:
 *
 *  "default" => [
 *      "controller" => "CONTROLLER DA PAG INICIAL",
 *      "index" => "MÉTODO A SER CHAMADO"
 *  ],
 *
 *  ======================================================
 *  ======================================================
 *  ======================================================
 *
 *  Autor: Igor Cacerez
 *  Data: 17/04/2019
 *
 */

$Rotas->onError("404","Principal::erro404");

// Grupos
$Rotas->group("usuario","usuario","Usuario");
$Rotas->group("cliente","cliente","Cliente");
$Rotas->group("corretor","corretor","Corretor");
$Rotas->group("lote","lote","Lote");
$Rotas->group("imprimir","imprimir","Imprimir");
$Rotas->group("cadsite","cadsite","CadSite");
$Rotas->group("balao","balao","Balao");


// Rotas de Grupos
// -- Usuario
$Rotas->onGroup("usuario","POST","login","login");


// -- Lote
$Rotas->onGroup("lote","GET","get/{p}","get");
$Rotas->onGroup("lote","POST","update/{p}","update");
$Rotas->onGroup("lote","POST","retorna-financiamento","retornaFinanciamento");
$Rotas->onGroup("lote","POST","insert-negocicao","insertNegociacao");
$Rotas->onGroup("lote","GET","cancelar-negocicao/{p}","cancelarNegociacao");
$Rotas->onGroup("lote","GET","vender-negocicao/{p}","venderNegociacao");
$Rotas->onGroup("lote","POST","alterar-valor-todos","alterarValorTodos");
$Rotas->onGroup("lote","GET","retorna-numeros/{p}","retornaNumeros");


// -- Cliente
$Rotas->onGroup("cliente","GET","busca-por-cpf/{p}","buscaPorCPF");
$Rotas->onGroup("cliente","POST","insert/{p}","insert");
$Rotas->onGroup("cliente","POST","insert","insert");
$Rotas->onGroup("cliente","GET","get/{p}","get");
$Rotas->onGroup("cliente","POST","update/{p}","update");


// -- Corretor
$Rotas->onGroup("corretor","POST","insert-corretor","InsertCorretor");
$Rotas->onGroup("corretor","GET","editar/{p}","editar");
$Rotas->onGroup("corretor","POST","ajaxalterarcorretor","ajaxAlterarCorretor");
$Rotas->onGroup("corretor","POST","altera-status","alterarStatus");
$Rotas->onGroup("corretor","GET","get/{p}","get");


// -- Imprimir
$Rotas->onGroup("imprimir","GET","boleto/{p}/{p}/{p}","boleto");
$Rotas->onGroup("imprimir","GET","boleto/{p}/{p}","boleto");
$Rotas->onGroup("imprimir","GET","contrato/{p}","contrato");
$Rotas->onGroup("imprimir","GET","view-contrato/{p}","viewContrato");
$Rotas->onGroup("imprimir","GET","view-boleto/{p}/{p}","viewBoleto");


// -- Cadastro Site
$Rotas->onGroup("cadsite","GET","ajaxbuscacadastro/{p}","ajaxBuscaCadastro");


// -- Balao
$Rotas->onGroup("balao","GET","insert/{p}","insert");



// Rotas Diretas
$Rotas->on("GET","","Principal::index");
$Rotas->on("GET","login","Principal::login");
$Rotas->on("GET","quadra","Principal::quadra");
$Rotas->on("GET","quadra/{p}","Principal::quadra");
$Rotas->on("GET","sair","Principal::sair");

$Rotas->on("POST","ajax/busca-por-cep","Principal::buscaPorCEP");


$Rotas->on("GET","negociacaoes","Principal::negociacaoes");
$Rotas->on("GET","corretores","Principal::corretores");
$Rotas->on("GET","clientes","Principal::clientes");
$Rotas->on("GET","lotes","Principal::lotes");
$Rotas->on("GET","cadastros-site","Principal::cadSite");
$Rotas->on("GET","perfil","Principal::perfil");
$Rotas->on("GET","reserva","Principal::reserva");