<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 18/07/2019
 * Time: 09:20
 */

namespace Controller;

use Helper\Seguranca;
use Sistema\Controller as CI_Controller;

class Usuario extends CI_Controller
{
    private $ObjHelperSeguranca;
    private $ObjModelUsuario;

    // Método construtor
    function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia os Objs
        $this->ObjHelperSeguranca = new Seguranca();
        $this->ObjModelUsuario = new \Model\Usuario();

    } // END >> Fun::__construct()



    /**
     * Método responsável por receber os dados de acesso do usuário
     * via POST, verificar se o mesmo está cadastro e ativo,
     * caso tiver realiza uma session do mesmo e retorna seus dados na view.
     * ---------------------------------------------------------------
     * @URL usuario/login
     * @METODO POST
     * @RETURN JSON
     */
    public function login()
    {
        // Variaveis
        $dados = null;
        $email = null;
        $senha = null;
        $usuario = null;

        // Pega os dados post
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        // Criptografa a senha
        $senha = md5($senha);

        // Busca o usuário
        $usuario = $this->ObjModelUsuario->get(["email" => $email, "senha" => $senha]);

        // Verifica se encontrou
        if($usuario->rowCount() == 1)
        {
            // Fetch
            $usuario = $usuario->fetch(\PDO::FETCH_OBJ);

            // Salva a session
            $_SESSION["usuario"] = $usuario;

            // Retorna o usuário
            $dados = [
                "tipo" => true,
                "objeto" => $usuario
            ];

            $this->retornoAPI($dados);
        }
        else
        {
            // Avisa que deu ruim
            $this->retornoAPI(["mensagem" => "E-mail ou senha estão incorretos."]);
        }

    } // END >> Fun::login()




} // END >> Class::Usuario