<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 26/03/2019
 * Time: 18:29
 */

namespace Controller;

use Helper\Seguranca;
use Model\Lote;
use Model\Cliente;
use Model\Corretor;
use Model\Negociacao;
use Model\SiteCadastro;
use Sistema\Controller as CI_controller;


class Principal extends CI_controller
{

    // Objetos Globais na class
    private $ObjHelperSeguranca;
    private $ObjModelNegociacao;
    private $ObjModelCadastro;
    private $ObjModelUsuario;
    private $ObjModelCliente;
    private $ObjModelCorretor;
    private $ObjModelLote;


    // Método construtor
    function __construct()
    {
        // Carrega o contrutor da classe pai
        parent::__construct();

        // Instancia Objs
        $this->ObjHelperSeguranca = new Seguranca();
        $this->ObjModelNegociacao = new Negociacao();
        $this->ObjModelCadastro = new SiteCadastro();
        $this->ObjModelUsuario = new \Model\Usuario();
        $this->ObjModelCliente = new Cliente();
        $this->ObjModelCorretor = new  Corretor();
        $this->ObjModelLote = new Lote();
    }


    /**
     * Método responsável por gerenciar a página inicial,
     * Verifica e redireciona o usuario para a página correta.
     * ---------------------------------------------------------
     * @URL BASE_URL
     */
    public function index()
    {
        // Variaveis
        $usuario = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Verifica se o usuário é admin
        if($usuario->nivel == "administrador")
        {
            // Chama a Dashboard do ADM
            $this->dashboardAdm($usuario);
        }
        else
        {
            // Chama a página de escolher a quadra
            $this->dashboardUser($usuario);
        }

    } // END >> Fun::index()





    /**
     * Método responsável por verificar se o usuário está logado, caso esteja,
     * manda para a página inicial, caso
     */
    public function login()
    {
        // Verifica se está logado
        if(isset($_SERVER["usuario"]))
        {
            // Manda para a página especifica
            header("Location: " . BASE_URL);

            // Mata o código
            exit;
        }

        // Chama a tela de login
        $this->view("login");
    } // END >> Fun::login()






    /**
     * Método responsável por exibir as páginas de quadra e seus determinados
     * lotes.
     * -----------------------------------------------------------------------
     * @URL quadra ou quadra/ID
     */
    public function quadra($id = null)
    {
        // Variaveis
        $usuario = null;
        $dados = null;
        $lotes = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Verifica se informou a quadra
        if($id == null)
        {
            // Chama a view para selecionar a quadra
            $this->view("map/dashboard");
        }
        else
        {
            // Busca os lotes dessa quadra
            $lotes = $this->ObjModelLote->get(["quadra" => $id])->fetchAll(\PDO::FETCH_OBJ);

            // Dados a ser enviados para a view
            $dados = [
                "lotes" => $lotes,
                "usuario" => $usuario,
                "quadra" => $id,
                "corretores" => $this->ObjModelUsuario->get(["status" => true])->fetchAll(\PDO::FETCH_OBJ),
                "imagem" => BASE_STORANGE . "assets/img/map/bloco-" . $id . ".png"
            ];

            $this->view("map/quadra",$dados);
        }

    } // END >> Fun::quadra()






    /**
     * Método responsável por montar a página inicial do administrador
     * ------------------------------------------------------------------
     * @param null $usuario
     */
    private function dashboardAdm($usuario = null)
    {
        // Váriaveis
        $dados = null;
        $lotes = null;
        $cadastros = null;
        $negociacoes = null;
        $valorTotal = 0;
        $vgvTotal = 0;
        $vgvEstoque = 0;
        $vgvReservado = 0;
        $grafico = [];

        // Busca os dados no banco
        $lotes = $this->ObjModelLote->get(["status" => "vendido"])->fetchAll(\PDO::FETCH_OBJ);
        $cadastros = $this->ObjModelCadastro->get(null,"Id_sitecadastro DESC",10)->fetchAll(\PDO::FETCH_OBJ);
        $negociacoes = $this->ObjModelNegociacao->get(null,"Id_negociacao DESC",10)->fetchAll(\PDO::FETCH_OBJ);

        // Realiza a somatoria dos lotes vendidos
        foreach ($lotes as $lt)
        {
            $valorTotal = $valorTotal + $lt->valor;
        }

        // Realiza o grafico de lotes vendidos esse mês
        $lotes = $this->ObjModelLote->vendasMes()->fetchAll(\PDO::FETCH_OBJ);

        // Popula o array do grafico
        for($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); $i++)
        {
            $grafico[$i] = 0;
        }


        // Add o conteudo ao array do grafico
        foreach ($lotes as $lt)
        {
            // Pega o dia
            $dia = date("d",strtotime($lt->data));

            // Add o conteudo ao array
            $grafico[$dia - 1] = $grafico[$dia - 1] + 1;
        }


        // Busca os dados principais para exibir as negociações
        foreach ($negociacoes as $neg)
        {
            // Busca os Dados
            $lt = $this->ObjModelLote->get(["Id_lote" => $neg->Id_lote])->fetch(\PDO::FETCH_OBJ);

            // Add o lote
            $neg->lote = $lt->bloco . "-" . $lt->numeroLote;
            $neg->loteValor = $lt->valor;
        }


        // Busca todos os lotes do sistema
        $lotesTodos = $this->ObjModelLote->get();
        $lotesTodosObj = $lotesTodos->fetchAll(\PDO::FETCH_OBJ);

        foreach ($lotesTodosObj as $lts)
        {
            $vgvTotal = $vgvTotal + $lts->valor;

            if($lts->status == "reservado")
            {
                $vgvReservado = $vgvReservado + $lts->valor;
            }
        }

        $vgvEstoque = $vgvTotal - $valorTotal;


        // Dados a serem exibidos para na view
        $dados = [
            "total_lotes" => $lotesTodos->rowCount(),
            "total_vendidos" => $this->ObjModelLote->get(["status" => "vendido"])->rowCount(),
            "total_reservados" => $this->ObjModelLote->get(["status" => "reservado"])->rowCount(),
            "total_valor" => $this->formatNumero($valorTotal),
            "vgv_total" => $this->formatNumero($vgvTotal),
            "vgv_estoque" => $this->formatNumero($vgvEstoque),
            "vgv_reservado" => $this->formatNumero($vgvReservado),
            "grafico" => $grafico,
            "negociacoes" => $negociacoes,
            "cadastros" => $cadastros,
            "usuario" => $usuario
        ];


        // Chama a view
        $this->view("painel/dashboard", $dados);

    } // END >> Fun::dashboardAdm()



    /**
     * Método responspavel por montar á página inicial dos corretores
     * ------------------------------------------------------------------
     * @param null $usuario
     */
    private function dashboardUser($usuario = null)
    {
        // Váriaveis
        $dados = null;
        $lotes = null;
        $cadastros = null;
        $negociacoes = null;
        $valorTotal = 0;
        $totalVendas = 0;
        $grafico = [];

        // Busca os dados no banco
        $negociacoesObj = $this->ObjModelNegociacao->get(["Id_usuario" => $usuario->Id_usuario],"Id_negociacao DESC");
        $negociacoes = $negociacoesObj->fetchAll(\PDO::FETCH_OBJ);

        // Realiza a somatoria da comissão do usuário
        foreach ($negociacoes as $neg)
        {
            // Busca os Dados
            $lt = $this->ObjModelLote->get(["Id_lote" => $neg->Id_lote])->fetch(\PDO::FETCH_OBJ);

            // Add o lote
            $neg->cliente = " - ";
            $neg->lote = $lt->bloco . "-" . $lt->numeroLote;
            $neg->loteValor = $lt->valor;

            // Varifica se possui cliente
            if($neg->Id_cliente != null && $neg->Id_cliente != 0)
            {
                $cli = $this->ObjModelCliente->get(["Id_cliente" => $neg->Id_cliente])->fetch(\PDO::FETCH_OBJ);
                $neg->cliente = $cli->nome;
            }

            // verifica se foi vendido
            if($neg->status == "vendido")
            {
                // Valor
                $valorTotal = $valorTotal + ($lt->valor * 0.05);
                $totalVendas++;
            }
        }



        // Popula o array do grafico
        for($i = 0; $i < cal_days_in_month(CAL_GREGORIAN, date("m"), date("Y")); $i++)
        {
            $grafico[$i] = 0;
        }


        // Busca os lotes vendidos nesse mes
        $where = [
            "Id_usuario" => $usuario->Id_usuario,
            "status" => "vendido",
            "YEAR(dataNegociacao)" => date("Y"),
            "MONTH(dataNegociacao)" => date("m")
        ];

        $negociacoesGraf = $this->ObjModelNegociacao->get($where)->fetchAll(\PDO::FETCH_OBJ);


        // Add o conteudo ao array do grafico
        foreach ($negociacoesGraf as $lt)
        {
            // Pega o dia
            $dia = date("d",strtotime($lt->dataNegociacao));

            // Add o conteudo ao array
            $grafico[$dia - 1] = $grafico[$dia - 1] + 1;
        }



        // Dados a serem exibidos para na view
        $dados = [
            "total_negociacoes" => $negociacoesObj->rowCount(),
            "total_vendidos" => $totalVendas,
            "total_valor" => number_format($valorTotal,2,",","."),
            "grafico" => $grafico,
            "negociacoes" => $negociacoes,
            "usuario" => $usuario
        ];


        // Chama a view
        $this->view("painel-user/dashboard", $dados);
    } // END >> Fun::dashboardUser()



    /**
     *  ==========================================================
     *                      MÉTEDOS PAINEL ADM
     *  ==========================================================
     */


    /**
     * Método responsável por montar a página onde os corretores
     * poderão reservar lotes sem a necessidade de entrar no mapa.
     */
    public function reserva()
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $blocos = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca os blocos existentes
        $blocos = $this->ObjModelLote->get("SELECT bloco FROM lote GROUP BY bloco")->fetchAll(\PDO::FETCH_OBJ);

        // Dados a ser enviados para a view
        $dados = [
            "blocos" => $blocos,
            "usuario" => $usuario
        ];

        // Chama a view
        $this->view("painel-user/reserva", $dados);

    } // END >> Fun::reserva()



    /**
     * Método responsavel por exibir uma página com as negociações.
     */
    public function negociacaoes()
    {
        // Variaveis
        $negociacoes = null;
        $dados = null;
        $corretor = null;
        $cliente = null;
        $lote = null;
        $where = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Verifica se o usuário é adm
        if($usuario->nivel == "user")
        {
            $where["Id_usuario"] = $usuario->Id_usuario;
        }


        // Busca as negociacoes
        $negociacoes = $this->ObjModelNegociacao->get($where,"Id_negociacao DESC")->fetchAll(\PDO::FETCH_OBJ);

        // Busca os dados principais para exibir as negociações
        foreach ($negociacoes as $neg)
        {
            // Limpa os dados
            $corretor = null;
            $cliente = null;
            $lote = null;

            // Busca o lote
            $lote = $this->ObjModelLote->get(["Id_lote" => $neg->Id_lote])->fetch(\PDO::FETCH_OBJ);

            // Verifica se possui cliente
            if($neg->Id_cliente != null && $neg->Id_cliente != 0 && $neg->Id_cliente != "")
            {
                // Busca o cliente
                $cliente = $this->ObjModelCliente->get(["Id_cliente" => $neg->Id_cliente])->fetch(\PDO::FETCH_OBJ);
            }

            // Busca o corretor
            $corretor = $this->ObjModelUsuario->get(["Id_usuario" => $neg->Id_usuario])->fetch(\PDO::FETCH_OBJ);

            // Add os objetos
            $neg->lote =  $lote;
            $neg->corretor = $corretor;
            $neg->cliente = $cliente;
        }

        // Array de exibição
        $dados = [
            "negociacoes" => $negociacoes,
            "usuario" => $usuario
        ];

        // Chama a view
        $this->view("painel/negociacoes",$dados);

    } // END >> Fun::negociacoes()



    /**
     * Método responsavel por exibir a paginas de detalhes das
     * neociações.
     */
    public function detalhesNegociacoes($param = null)
    {
        // Variaveis
        $negociacoes = null;
        $dados = null;
        $corretor = null;
        $cliente = null;
        $lote = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();


        // Busca as negociacoes
        $negociacoes = $this->ObjModelNegociacao->get(['Id_negociacao' => $param],"Id_negociacao DESC")->fetchAll(\PDO::FETCH_OBJ);

        // Busca os dados principais para exibir as negociações
        foreach ($negociacoes as $neg)
        {
            // Limpa os dados
            $corretor = null;
            $cliente = null;
            $lote = null;

            // Busca o lote
            $lote = $this->ObjModelLote->get(["Id_lote" => $neg->Id_lote])->fetch(\PDO::FETCH_OBJ);

            // Verifica se possui cliente
            if($neg->Id_cliente != null && $neg->Id_cliente != 0 && $neg->Id_cliente != "")
            {
                // Busca o cliente
                $cliente = $this->ObjModelCliente->get(["Id_cliente" => $neg->Id_cliente])->fetch(\PDO::FETCH_OBJ);
            }

            // Busca o corretor
            $corretor = $this->ObjModelUsuario->get(["Id_usuario" => $neg->Id_usuario])->fetch(\PDO::FETCH_OBJ);

            // Add os objetos
            $neg->lote =  $lote;
            $neg->corretor = $corretor;
            $neg->cliente = $cliente;
        }

        // Array de exibição
        $dados = [
            "negociacoes" => $negociacoes,
            "usuario" => $usuario
        ];

        // Chama a view
        $this->view("painel/negociacoes_detalhes",$dados);

    } // END >> Fun::negociacoes()



    /**
     * Método responsavel por exibir uma página com os corretores
     * cadastrados no sistema.
     */
    public function corretores()
    {
        // Variaveis
        $dados = null;
        $buscaCorretor = null;
        $user = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca os corretores
        $buscaCorretor = $this->ObjModelCorretor->get()->fetchAll(\PDO::FETCH_OBJ);

        // Percorre os corretoes
        foreach ($buscaCorretor as $cor)
        {
            // Busca o usuário vinculado
            $user = $this->ObjModelUsuario->get(["Id_corretor" => $cor->Id_corretor])->fetch(\PDO::FETCH_OBJ);

            // Add o nome, email, nivel e status
            $cor->Id_usuario = $user->Id_usuario;
            $cor->nome = $user->nome;
            $cor->email = $user->email;
            $cor->nivel = $user->nivel;
            $cor->status = $user->status;
        }

        $dados = [
            "corretores" => $buscaCorretor,
            "usuario" => $usuario
        ];

        // Chama a view
        $this->view("painel/corretores",$dados);

    } // END >> Fun::corretores()




    /**
     * Método responsavel por exibir uma página com os clientes
     * cadastrados no sistema.
     */
    public function clientes()
    {
        // Variaveis
        $dados = null;
        $buscaCliente = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca os clientes
        $buscaCliente = $this->ObjModelCliente->get()->fetchAll(\PDO::FETCH_OBJ);

        $dados = [
            "clientes" => $buscaCliente,
            "usuario" => $usuario
        ];

        // CHama a view
        $this->view("painel/clientes",$dados);

    } // END >> Fun::clientes()




    /**
     * Método responsavel por exibir uma página com os lotes
     * cadastrados no sistema.
     */
    public function lotes()
    {
        // Variaveis
        $dados = null;
        $buscaLotes = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca os lotes
        $buscaLotes = $this->ObjModelLote->get()->fetchAll(\PDO::FETCH_OBJ);

        $dados = [
            "lotes" => $buscaLotes,
            "usuario" => $usuario
        ];

        // Chama a view
        $this->view("painel/lotes",$dados);

    } // END >> Fun::lotes()




    /**
     * Método responsavel por exibir uma página com os cadastros no site.
     */
    public function cadSite()
    {
        // Variaveis
        $dados = null;
        $buscaCadastro = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca os cadastros
        $buscaCadastro = $this->ObjModelCadastro->get()->fetchAll(\PDO::FETCH_OBJ);

        $dados = [
            "cadastros" => $buscaCadastro,
            "usuario" => $usuario
        ];

        // Chama a view
        $this->view("painel/cad_site",$dados);

    } // END >> Fun::cadSite()





    /**
     * Método responsável por chamar o método que cria a página de editar os
     * dados do usuário logado
     */
    public function perfil()
    {
        // Obj
        $Corretor = new \Controller\Corretor();

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Chama o método
        $Corretor->Editar($usuario->Id_usuario);

    } // END >> Fun::perfil()



    /**
     *  ==========================================================
     *                      MÉTEDOS SECUNDÁRIOS
     *  ==========================================================
     */



    /**
     * Método responsável por encerrar as sessions ativa para o usuário logado
     * e enviar o mesmo para a página de login.
     * ---------------------------------------------------
     * @URL: sair
     */
    public function sair()
    {
        // Mata a session
        session_destroy();

        // Redireciona para a pag de login
        header("Location: " . BASE_URL . "login");

    } // END >> Fun::sair()



    /**
     * Método responsável por exibir uma página de erro 404.
     */
    public function erro404()
    {
        $this->view("erro/404");
    } // END >> Fun::erro404()


    /**
     * Método responsável por retornar o endereço atraves
     * do CEP
     */
    public function buscaPorCEP()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        // Dados recebidos via post
        $cep = $_POST["cep"];
        $cep = preg_replace("/[^0-9]/","", $cep);

        $json_file = file_get_contents("https://viacep.com.br/ws/{$cep}/json/");
        $resultado = json_decode($json_file, true);

        if(isset($resultado['erro']))
        {
            $dados = array("erro" => true);
        }
        else
        {
            $dados = array(
                "logradouro" => $resultado['logradouro'],
                "bairro" => $resultado['bairro'],
                "cidade" => $resultado['localidade'],
                "estado" => $resultado['uf'],
                "erro" => false
            );
        }

        // Manda o retorno
        echo json_encode($dados);
    } // END >> Fun::buscaPorCEP()

} // END::Class Principal