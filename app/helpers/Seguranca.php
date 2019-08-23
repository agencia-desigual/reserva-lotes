<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 17/07/2019
 * Time: 08:49
 */

namespace Helper;


class Seguranca
{

    /**
     * Método responsável por verificar se o usuário está logado.
     * Caso esteja os dados do mesmo é retornado,
     * Em caso negativo é redirecionado para a página de login.
     */
    public function verificaLogin()
    {
        // Verifica se está logado
        if(isset($_SESSION["usuario"]))
        {
            return $_SESSION["usuario"];
        }
        else
        {
            header("Location: " . BASE_URL . "login");
        }

    } // END >> Fun::verificaLogin()

} // END >> Class::Seguranca