<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 18/07/2019
 * Time: 10:18
 */

namespace Controller;

use Helper\Push;
use Helper\Seguranca;
use Model\Negociacao;
use Model\ValorFinanciamento;
use Sistema\Controller as CI_Controller;

class Lote extends CI_Controller
{
    // Objetos
    private $ObjHelperSeguranca;
    private $ObjControllerNegociacao;
    private $ObjModelLote;
    private $ObjModelFinanciamento;
    private $ObjModelNegociacao;

    
    // Método construtor
    public function __construct()
    {
        // Chama o pai 
        parent::__construct();
        
        // Instancia os Objs
        $this->ObjHelperSeguranca = new Seguranca();
        $this->ObjControllerNegociacao = new \Controller\Negociacao();
        $this->ObjModelLote = new \Model\Lote();
        $this->ObjModelFinanciamento = new ValorFinanciamento();
        $this->ObjModelNegociacao = new Negociacao();

    } // END >> Fun::__construct()


    /**
     * Método responsável por retornar os dados de um determinado lote
     * e caso o mesmo esteja vinculado a uma negociação retornará os dados
     * da mesma.
     * -----------------------------------------------------------------
     * @URL lote/get/[ID]
     * @METODO GET
     * @RETORNO JSON
     */
    public function get($id = null)
    {
        // Variaveis
        $dados = null;
        $usuario = null;
        $lote = null;
        $negociacao = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca o lote
        $lote = $this->ObjModelLote->get(["Id_lote" => $id]);

        // Verifica se encontrou
        if($lote->rowCount() > 0)
        {
            // Fetch
            $lote = $lote->fetch(\PDO::FETCH_OBJ);

            // Verifica se o lote possui negociação em andamento
            if($lote->status != "livre")
            {
                // Busca a negociação ativa deste lote
                $negociacao = $this->ObjControllerNegociacao->getLote($id);
            }

            // Add a negociação no lote
            $lote->negociacao = $negociacao;
            $lote->valor = number_format($lote->valor,2,".","");

            // Dados para retorno
            $dados = [
                "tipo" => true,
                "objeto" => $lote
            ];

            // Retorna
            $this->retornoAPI($dados);
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Lote não encontrado."]);
        }

    } // END >> Fun::get()



    public function update($id = null)
    {
        // Variaveis
        $dados = null;
        $post = $_POST;

        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // Altera
        if($this->ObjModelLote->update($post,["Id_lote" => $id]) != false)
        {
            $this->retornoAPI(["tipo" => true, "mensagem" => "Lote alterado com sucesso."]);
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Ocorreu um erro ao alterar o lote."]);
        }
    }



    /**
     * Método resposável por retornar o financiamento para um determinado
     * valor informado.
     * ------------------------------------------------------------
     * @URL lote/retorna-financiamento
     * @METODO POST
     * @RETORNO JSON
     */
    public function retornaFinanciamento()
    {
        // Variaveis
        $valor = $_POST["valor"];
        $sobra = 0;
        $financiamento = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Verifica se o valor está na formatação correta
        if($valor >= 1000)
        {
            // verifica se o valor é multiplo de 100
            $sobra = ($valor % 100);

            if($sobra == 0)
            {
                // Busca o financiamento
                $financiamento = $this->ObjModelFinanciamento->get(["valor" => $valor]);

                // verifica se o financiamento existe
                if($financiamento->rowCount() > 0)
                {
                    // Retorna
                    $this->retornoAPI([
                        "tipo" => true,
                        "objeto" => $financiamento->fetch(\PDO::FETCH_OBJ)
                    ]);
                }
                else
                {
                    $this->retornoAPI(["mensagem" => "Erro! O valor financiado não foi encontrado."]);
                }
            }
            else
            {
                $this->retornoAPI(["mensagem" => "Erro! O valor financiado deve ser multiplo de 100"]);
            }
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Erro! O valor financiado deve ser maior ou igual a 1.000"]);
        }

    } // END >> Fun::retornaFinanciamento()





    /**
     * Método responsável por adicionar uma determinada negociação em um determinado
     * Lote.
     * ------------------------------------------------------------
     * @URL lote/insert-negocicao
     * @METODO POST
     * @RETORNO JSON
     */
    public function insertNegociacao()
    {
        // Variaveis
        $dados = null;
        $salva = null;
        $post = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Post
        $post = $_POST;


        // busca as negociações ativas do usuario
        $negAtiva = $this->ObjModelNegociacao->get(["Id_usuario" => $post["Id_corretor"], "status" => "reservado"]);

        // Verifica se extourou o numero de reservas
        if($negAtiva->rowCount() >= 2)
        {
            $this->retornoAPI(["mensagem" => "É permitido apenas 2 reservas por corretor. Você já possui o número máximo de lotes reservados."]);
        }
        else
        {
            // Salva
            $salva = [
                "Id_usuario" => $post["Id_corretor"],
                "Id_lote" => $post["Id_lote"],
                "Id_valorFinanciamento" => ($post["Id_valorFinanciamento"] == 0) ? null : $post["Id_valorFinanciamento"],
                "valorEntrada" => $post["valorEntrada"],
                "numParcela" => $post["numParcela"],
                "vencimentoParcela" => $post["vencimentoParcela"],
                "vencimentoEntrada" => $post["vencimentoEntrada"],
                "status" => $post["status"]
            ];

            // salva
            $idSalva = $this->ObjModelNegociacao->insert($salva);

            // Verifica se deu certo
            if($idSalva != null && $idSalva != false)
            {
                // Altera o banco
                $this->ObjModelLote->update(["status" => $post["status"]],["Id_lote" => $post["Id_lote"]]);

                // Dispara o Push
                $push = [
                    "Id_lote" => $post["Id_lote"],
                    "status" => $post["status"]
                ];

                $this->disparaPush($push);

                // Avisa que deu bom
                $this->retornoAPI([
                    "tipo" => true,
                    "mensagem" => "Reservado com sucesso",
                    "objeto" => $this->ObjModelNegociacao->get(["Id_negociacao" => $idSalva])->fetch(\PDO::FETCH_OBJ)
                ]);
            }
            else
            {
                $this->retornoAPI(["mensagem" => "Erro ao inserir negociação"]);
            }
        }

    } // END >> Fun::insertNegociacao()





    /**
     * Método responsável por receber o ID de uma determinada negociação e
     * vender a mesma, disparando um push caso de certo.
     * --------------------------------------------------------------
     * @URL lote/vender-negocicao/[ID NEG]
     * @METODO GET
     * @param $idNeg
     */
    public function venderNegociacao($idNeg)
    {
        // Variaveis
        $dados = null;
        $negociacao = null;
        $lote = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca a negociação
        $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $idNeg])->fetch(\PDO::FETCH_OBJ);

        // Verifica se achou
        if($negociacao != null)
        {
            // Busca o lote
            $lote = $this->ObjModelLote->get(["Id_lote" => $negociacao->Id_lote])->fetch(\PDO::FETCH_OBJ);

            // Altera a negociação
            $this->ObjModelNegociacao->update(["status" => "vendido"],["Id_negociacao" => $idNeg]);

            // Altera o lote
            if($this->ObjModelLote->update(["status" => "vendido"],["Id_lote" => $lote->Id_lote]) != false)
            {
                // Dispara o push
                $push = [
                    "Id_lote" => $lote->Id_lote,
                    "status" => "vendido"
                ];

                $this->disparaPush($push);

                // Avisa que deu certo
                $this->retornoAPI([
                    "tipo" => true,
                    "mensagem" => "Lote vendido com sucesso."
                ]);
            }
            else
            {
                $this->retornoAPI(["mensagem" => "Ocorreu um erro ao vender lote."]);
            }
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Negociação não encontrada"]);
        }

    } // END >> Fun::venderNegociacao()




    /**
     * Método responsável por receber o ID de uma determinada negociação e
     * cancelar a mesma, disparando um push caso de certo.
     * --------------------------------------------------------------
     * @URL lote/cancelar-negocicao/[ID NEG]
     * @METODO GET
     * @param $idNeg
     */
    public function cancelarNegociacao($idNeg)
    {
        // Variaveis
        $dados = null;
        $negociacao = null;
        $lote = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca a negociação
        $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $idNeg])->fetch(\PDO::FETCH_OBJ);

        // Verifica se achou
        if($negociacao != null)
        {
            // Busca o lote
            $lote = $this->ObjModelLote->get(["Id_lote" => $negociacao->Id_lote])->fetch(\PDO::FETCH_OBJ);

            // Altera a negociação
            $this->ObjModelNegociacao->update(["status" => "cancelado"],["Id_negociacao" => $idNeg]);

            // Altera o lote
            if($this->ObjModelLote->update(["status" => "livre"],["Id_lote" => $lote->Id_lote]) != false)
            {
                // Dispara o push
                $push = [
                    "Id_lote" => $lote->Id_lote,
                    "status" => "livre"
                ];

                $this->disparaPush($push);

                // Avisa que deu certo
                $this->retornoAPI([
                    "tipo" => true,
                    "mensagem" => "Negociação cancelada com sucesso."
                ]);
            }
            else
            {
                $this->retornoAPI(["mensagem" => "Ocorreu um erro ao cancelar negociação."]);
            }
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Negociação não encontrada"]);
        }

    } // END >> Fun::cancelarNegociacao()





    /**
     * Método responsável por alterar o valor de todos os lotes
     * de uma vez, sendo por porcentagem ou por valor fixo.
     * ------------------------------------------------------------
     * @URL lote/alterar-valor-todos
     * @METODO GET
     */
    public function alterarValorTodos()
    {
        // Variaveis
        $dados = null;
        $salva = null;
        $lotes = null;
        $altera = null;
        $get = $_POST;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Verifica se é adm
        if($usuario->nivel == "administrador")
        {
            if(isset($get["acao"]) == true && isset($get["tipo"]) == true && isset($get["valor"]) == true)
            {
                // Altera os lotes
                if($get["tipo"] == "porcentagem")
                {
                    if($get["valor"] > 100)
                    {
                        $this->retornoAPI(["mensagem" => "Impossivel modificar mais do que 100% do valor atual"]);
                    }
                    else
                    {
                        if($get["acao"] == "adicao")
                        {
                            $altera = "UPDATE lote SET valor = (valor + (valor * ({$get['valor']} / 100))) WHERE status = 'livre'";
                        }
                        else
                        {
                            $altera = "UPDATE lote SET valor = (valor - (valor * ({$get['valor']} / 100))) WHERE status = 'livre'";
                        }
                    }
                }
                else
                {
                    if($get["acao"] == "adicao")
                    {
                        $altera = "UPDATE lote SET valor = (valor + {$get['valor']}) WHERE status = 'livre'";
                    }
                    else
                    {
                        $altera= "UPDATE lote SET valor = (valor - {$get['valor']}) WHERE status = 'livre'";
                    }
                }

                // Altera os lotes
                $lotes = $this->ObjModelLote->get($altera);

                // Verifica se alterou
                if($lotes != null && $lotes != "")
                {
                    $this->retornoAPI([
                        "tipo" => true,
                        "mensagem" => "Valor alterado com sucesso."
                    ]);
                }
                else
                {
                    $this->retornoAPI(["mensagem" => "Ocorreu um erro ao alterar valores."]);
                }
            }
            else
            {
                $this->retornoAPI(["mensagem" => "Campos obrigatórios não informados"]);
            }
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Usuário sem permissão para execultar está ação"]);
        }

    } // END >> Fun::alterarValor()




    public function retornaNumeros($bloco = null)
    {
        // Variaveis
        $dados = null;
        $lotes = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Verifica se informou o bloco
        if(isset($bloco) == true && $bloco != null)
        {
            // Busca os lotes desse bloco
            $lotes = $this->ObjModelLote->get(["bloco" => $bloco])->fetchAll(\PDO::FETCH_OBJ);

            // retorna
            $this->retornoAPI([
                "tipo" => true,
                "objeto" => $lotes
            ]);
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Bloco não informado"]);
        }

    } // END >> Fun::retornaNumeros()



    /**
     * ========================================================
     *                    MÉTODOS PRIVADOS
     * ========================================================
     */



    /**
     * Método responsável por disparar informações push
     * para a View. O que é responsável de fazer as comunicações
     * em tempo real
     * ------------------------------------------------------------
     * @param null $envia
     */
    private function disparaPush($envia = null)
    {
        // Carrega o Obj
        $ObjPusher = new Push();

        // Inicia o Pusher
        $pusher = $ObjPusher->get_pusher();

        // ! IMPORTANTE !
        // Responsavel por engatilhar a função certa de acordo com o projeto.
        $pusher->trigger("lote_atualiza", "atualizarStatus_gp", $envia);

    } // END >> Fun::disparaPush

} // END >> Class::Lote