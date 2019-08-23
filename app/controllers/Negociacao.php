<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 18/07/2019
 * Time: 10:36
 */

namespace Controller;


use Model\Cliente;
use Model\ValorFinanciamento;

class Negociacao
{
    private $ObjModelNegociacao;
    private $ObjModelCliente;
    private $ObjModelFinanciamento;
    private $ObjModelUsuario;

    // Método construtor
    public function __construct()
    {
        // Instancia os Objs
        $this->ObjModelNegociacao = new \Model\Negociacao();
        $this->ObjModelCliente = new Cliente();
        $this->ObjModelFinanciamento = new ValorFinanciamento();
        $this->ObjModelUsuario = new \Model\Usuario();

    } // END >> Fun::__construct()


    /**
     * Método responsável por retornar um obj ou array de negociacoe
     * de um determinado lote.
     *
     * @param null $idLote
     * @param bool $ativa
     * @return object|array
     */
    public function getLote($idLote = null, $ativa = true)
    {
        // Variaveis
        $dados = null;
        $aux = null;
        $negociacao = null;

        // Verifica se é para retornar todas as negociações ou apenas a ativa
        if($ativa == true)
        {
            // Busca a negociação ativa
            $negociacao = $this->ObjModelNegociacao->get("SELECT * FROM negociacao
                                                                    WHERE Id_lote = {$idLote}
                                                                      AND status != 'cancelado'")->fetch(\PDO::FETCH_OBJ);

            // Obj a ser retornado
            $dados = $this->buscaNegociacao($negociacao);
        }
        else
        {
            // Busca as negociações deste lote
            $negociacao = $this->ObjModelNegociacao->get(["Id_lote" => $idLote])->fetchAll(\PDO::FETCH_OBJ);

            // percorre todas as negociações
            foreach ($negociacao as $neg)
            {
                // Add o conteudo no array
                $aux[] = $this->buscaNegociacao($neg);
            }

            // Add ao conteudo de retorno
            $dados = $aux;
        }

        return $dados;

    } // END >> Fun::getLote()




    /**
     * Método responsável por add um cliente em uma negociação e retornar true ou false.
     *
     * @param $idCliente
     * @param $idNegociacao
     * @return bool
     */
    public function addClienteEmNegociacao($idCliente, $idNegociacao)
    {
        // Váriaveis
        $dados = null;
        $negociacao = null;
        $return = false;

        // Verifica se o cliente existe
        if($this->ObjModelCliente->get(["Id_cliente" => $idCliente])->rowCount() > 0)
        {
            // Verifica se a negociação existe
            if($this->ObjModelNegociacao->get(["Id_negociacao" => $idNegociacao])->rowCount() > 0)
            {
                // Faz a alteração
                if($this->ObjModelNegociacao->update(["Id_cliente" => $idCliente],["Id_negociacao" => $idNegociacao]) != false)
                {
                    $return = true;
                }
            }
        }

        return $return;

    } // END >> Fun::addClienteEmNegociacao()




    /**
     * ==========================================================
     *                     Métodos Privados
     * ==========================================================
     */



    /**
     * Método responsável por receber um Obj de negociação e buscar todos os seus dados extrangeiros
     * e retornar em formato de objeto
     *
     * @param $negociacao
     * @return mixed
     */
    private function buscaNegociacao($negociacao)
    {
        // Formata as datas
        $negociacao->dataNegociacao = date("d/m/Y",strtotime($negociacao->dataNegociacao));
        $negociacao->dataNegociacao .= " ás " . date("H:i",strtotime($negociacao->dataNegociacao));

        $negociacao->vencimentoEntrada = date("d/m/Y",strtotime($negociacao->vencimentoEntrada));
        $negociacao->vencimentoParcela = date("d/m/Y",strtotime($negociacao->vencimentoParcela));

        // Busca o Corretor
        $corretor = $this->ObjModelUsuario->get(["Id_usuario" => $negociacao->Id_usuario])->fetch(\PDO::FETCH_OBJ);

        // Busca o Cliente
        $cliente = $this->ObjModelCliente->get(["Id_cliente" => $negociacao->Id_cliente])->fetch(\PDO::FETCH_OBJ);

        // Verifica se foi financiado
        if($negociacao->Id_valorFinanciamento != null)
        {
            // Numero escolhido
            $numParcelas = $negociacao->numParcela;

            // Busca o financiamento
            $financiamento = $this->ObjModelFinanciamento
                ->get(["Id_valorFinanciamento" => $negociacao->Id_valorFinanciamento])
                ->fetch(\PDO::FETCH_OBJ);

            // Salva o resultado em um aux e transforma em array
            $finArray = (array) $financiamento;

            // Add o conteudo
            $negociacao->financimento = $financiamento;
            $negociacao->valorParcela = $finArray["parcela_" . $numParcelas];
        }
        else
        {
            $negociacao->financimento = null;
            $negociacao->valorParcela = null;
        }

        // Add os conteudos ao Obj
        $negociacao->cliente = $cliente;
        $negociacao->corretor = $corretor;

        // Retorna
        return $negociacao;

    } // END >> Fun::buscaNegociacao()


} // END >> Class::Negociacao