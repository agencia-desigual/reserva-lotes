<?php
namespace Controller;

use Helper\Seguranca;
use Sistema\Controller as CI_Controller;

class CadSite extends CI_Controller
{

    // Objetos
    private $ObjHelperSeguranca;
    private $ObjModelCadastro;

    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia os objs
        $this->ObjHelperSeguranca = new Seguranca();
        $this->ObjModelCadastro = new \Model\SiteCadastro();

    } // END >> Fun::__construct()



    
    public function ajaxBuscaCadastro($param){

        $this->ObjHelperSeguranca->verificaLogin();

        if($param != null && $param != ""){

            $busca = $this->ObjModelCadastro->get(["Id_sitecadastro" => $param])->fetchAll(\PDO::FETCH_OBJ);

            $this->retornoAPI([
                "tipo" => true,
                "mensagem" => "Cadastro encontrado!",
                "objeto" => $busca[0]
            ]);

        }else{

            $this->retornoAPI(["mensagem" => "Erro ao encontrar cadastro!"]);
        }
    }


} // END >> Class::Cliente