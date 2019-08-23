<?php
/**
 * =======================================================
 *
 *  Exemplo de Model a ser seguido pelo usuário,
 *  este simples exemplo já possui os métodos principais de
 *  um CRUD.
 *
 *  insert, update, get, delete
 *
 * =======================================================
 *
 * Autor: Igor Cacerez
 * Date: 04/04/2019
 * Time: 12:22
 *
 */

namespace Model;

use Sistema\Database;


class Lote extends Database
{
    private $conexao;

    // Método construtor
    public function __construct()
    {
        // Carrega o construtor da class pai
        parent::__construct();

        // Retorna a conexao
        $this->conexao = parent::getConexao();

        // Seta o nome da tablea
        parent::setTable("lote");

    } // END >> Fun::__construct()


    public function vendasMes()
    {
        $mes = date("m");
        $ano = date("Y");

        $sql = "SELECT l.*, n.dataNegociacao as data 
                  FROM lote l, negociacao n
                    WHERE n.Id_lote = l.Id_lote
                      AND MONTH(n.dataNegociacao) = '{$mes}'
                      AND YEAR(n.dataNegociacao) = '{$ano}'
                      AND l.status = 'vendido'
                      GROUP BY l.Id_lote";

        return $this->get($sql);
    }

} // END >> Class::Curso