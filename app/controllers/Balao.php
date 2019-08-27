<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 27/08/2019
 * Time: 15:04
 */

namespace Controller;

use Helper\Seguranca;
use Sistema\Controller as CI_controller;

class Balao extends CI_controller
{
    // Objetos
    private $ObjModelBalao;
    private $ObjModelNegociacao;
    private $ObjHelperSeguranca;


    // Método construtor
    public function __construct()
    {
        // Instancia os Objetos
        $this->ObjModelBalao = new \Model\Balao();
        $this->ObjModelNegociacao = new \Model\Negociacao();
        $this->ObjHelperSeguranca = new Seguranca();

    } // End >> Fun::__construct()


    /**
     * Método responsável por inserir parcelas de balão para uma
     * determinada negociação.
     *
     * ---------------------------------------------------------
     * @author igorcacerez
     * ---------------------------------------------------------
     *
     * @param int|null $idNegociacao
     * @url balao/insert/[ID]
     * @method GET
     */
    public function insert($idNegociacao = null)
    {
        // -- Classe responsável sobre o balão

    } // End >> Fun::insert()


} // END >> Class::Balao