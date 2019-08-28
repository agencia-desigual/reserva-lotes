<?php
/**
 * Created by PhpStorm.
 * User: igorcacerez
 * Date: 27/08/2019
 *
 * ======================================================================
 * Classe responsável por realizar todas os métodos relacionados ao uso
 * de balões nas negociações.
 * ======================================================================
 *
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
     * Método responsável por retornar os boloes de uma
     * determinada negociacao
     *
     * ---------------------------------------------------------
     * @author igorcacerez
     * ---------------------------------------------------------
     *
     * @param int|null $idNegociacao
     * @url balao/get/[ID]
     * @method GET
     *
     */
    public function get($idNegociacao = null)
    {
        // Variaveis
        $dados = null;
        $baloes = null;
        $negociacao = null;

        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // Busca a negociacao
        $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $idNegociacao]);

        // Verifica se encontrou a negociação informada
        if($negociacao->rowCount() > 0)
        {
            // Busca os baloes
            $baloes = $this->ObjModelBalao->get(["Id_negociacao" => $idNegociacao]);

            // Monta os dados a serem retornados a view
            $dados = [
                "baloes" => $baloes->fetchAll(\PDO::FETCH_OBJ),
                "total" => $baloes->rowCount(),
                "negociacao" => $negociacao->fetch(\PDO::FETCH_OBJ)
            ];

            // Retorna os dados
            $this->retornoAPI([
                "tipo" => true,
                "objeto" => $dados
            ]);
        }
        else
        {
            // Avisa que deu erro
            $this->retornoAPI(["mensagem" => "A negociação informada não foi encontrada."]);
        }

    } // End >> Fun::get()




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
     * @method POST
     */
    public function insert($idNegociacao = null)
    {
        // Váriavel
        $dados = null;
        $baloes = null;
        $post = null;
        $negociacao = null;
        $numParcela = null;
        $salva = null;


        // Segurança
        $this->ObjHelperSeguranca->verificaLogin();

        // Pega os dados enviados por post
        $post = $_POST;

        // Busca a negociação informada
        $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $idNegociacao]);

        // Verifica se encontrou a negociação
        if($negociacao->rowCount() > 0)
        {
            // Fetch da negociacao
            $negociacao = $negociacao->fetch(\PDO::FETCH_OBJ);

            // Numero de parcelas
            $numParcela = $post["numParcelaBalao"];

            // Percorre todas as parcelas para realizar a inserção
            for($i = 1; $i <= $numParcela; $i++)
            {
                // Dados a serem inseridos
                $salva = [
                    "Id_negociacao" => $idNegociacao,
                    "valor" => number_format($post["valor_{$i}"],2,".",""),
                    "data" => date("Y-m-d", strtotime($post["data_{$i}"])),
                ];

                // Realiza a inserção
                if($this->ObjModelBalao->insert($salva) == false)
                {
                    // Deleta os balões inseridos
                    $this->ObjModelBalao->delete(["Id_negociacao" => $$idNegociacao]);

                    // Retorna o erro
                    $this->retornoAPI(["mensagem" => "Erro ao inserir o balão de parcela: {$i}"]);
                }

            } // End >> for::($i = 1; $i <= $numParcela; $i++)

            // Se chegou aqui é pq tudo deu certo
            $this->retornoAPI([
                "tipo" => true,
                "mensagem" => "Balões adicionado com sucesso."
            ]);
        }
        else
        {
            // Avisa de não encontrou a neg
            $this->retornoAPI(["mensagem" => "Negociação informada não encontrada"]);
        }

    } // End >> Fun::insert()



    /**
     * Método responsável por alterar alguma informação
     * de uma tabela especifica de algum balão
     *
     * ---------------------------------------------------------
     * @author igorcacerez
     * ---------------------------------------------------------
     *
     * @param int|null $idBalao
     * @url balao/update/[ID]
     * @method POST
     */
    public function update($idBalao = null)
    {
        // Varaives
        $dados = null;
        $salva = null;
        $balaoAntes = null;
        $balaoAlterado = null;
        $post = null;

        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // Recupera os dados enviados por post
        $post = $_POST;

        // Busca o balão informado
        $balaoAntes = $this->ObjModelBalao->get(["Id_balao" => $idBalao]);

        // Verifica se encontrou alguma coisa
        if($balaoAntes->rowCount() > 0)
        {
            // Fetche do balao
            $balaoAntes = $balaoAntes->fetch(\PDO::FETCH_OBJ);

            // -- Monta o array de alteração

            // Verifica se o valor foi alterado
            if(isset($post["valor"]))
            {
                if($balaoAntes->valor != number_format($post["valor"], 2, ".", ""))
                {
                    // Add ao array
                    $salva["valor"] = number_format($post["valor"], 2, ".", "");
                }
            }


            // Verifica se a data foi alterada
            if(isset($post["data"]))
            {
                if($balaoAntes->data != date("Y-m-d", strtotime($post["data"])))
                {
                    // Add ao array
                    $salva["data"] = date("Y-m-d", strtotime($post["data"]));
                }
            }


            // Verifica se alguma coisa foi alterada
            if($salva == null)
            {
                // Avisa que nada foi alterado
                $this->retornoAPI(["mensagem" => "Nenhum campo foi alterado."]);
            }
            else
            {
                // Altera o balao e verifica se deu certo
                if($this->ObjModelBalao->update($salva, ["Id_balao" => $idBalao]) != false)
                {
                    // Busca o balao alterado
                    $balaoAlterado = $this->ObjModelBalao->get(["Id_balao" => $idBalao])->fetch(\PDO::FETCH_OBJ);

                    // Monta os dados a ser enviados
                    $dados = [
                        "alterado" => $balaoAlterado,
                        "antes" => $balaoAntes
                    ];

                    // Retorna para a view
                    $this->retornoAPI([
                        "tipo" => true,
                        "mensagem" => "Balão alterado com sucesso.",
                        "objeto" => $dados
                    ]);
                }
                else
                {
                    // Avisa que deu erro
                    $this->retornoAPI(["mensagem" => "Ocorreu um erro ao alterar balão"]);
                }
            }
        }
        else
        {
            // Avisa que não encontrou o balao
            $this->retornoAPI(["mensagem" => "O balão informado não existe"]);
        }

    } // End >> Fun::update()



    /**
     * Método responsável por deletar uma determinada parcela
     * de algum balão
     *
     * ---------------------------------------------------------
     * @author igorcacerez
     * ---------------------------------------------------------
     *
     * @param int|null $idBalao
     * @url balao/delete/[ID]
     * @method GET
     */
    public function delete($idBalao = null)
    {
        // Variaveis
        $dados = null;
        $balao = null;

        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // Busca o balão solicitado
        $balao = $this->ObjModelBalao->get(["Id_balao" => $idBalao]);

        // Verifica se encontrou alguma coisa
        if($balao->rowCount() > 0)
        {
            // Deleta o balão e verifica se deu certo
            if($this->ObjModelBalao->delete(["Id_balao" => $idBalao]) != false)
            {
                // Monta os dados a serem enviados
                $dados = $balao->fetch(\PDO::FETCH_OBJ);

                // Avisa a view que tudo deu certo
                $this->retornoAPI([
                    "tipo" => true,
                    "mensagem" => "Parcela do balão foi deletada com sucesso",
                    "objeto" => $dados
                ]);
            }
            else
            {
                // Avisa que deu erro
                $this->retornoAPI(["mensagem" => "Ocorreu um erro ao deletar o balão"]);
            }
        }
        else
        {
            // Avisa que não encontrou nada
            $this->retornoAPI(["mensagem" => "O balão informado não foi encontrado"]);
        }

    } // End >> Fun::delete()




    /**
     * Método responsável por deletar todos os baloes de uma
     * determinada negociação
     *
     * ---------------------------------------------------------
     * @author igorcacerez
     * ---------------------------------------------------------
     *
     * @param null $idNegociacao
     * @url balao/delete-negociacao/[ID]
     * @method GET
     */
    public function deleteAll($idNegociacao = null)
    {
        // Variaveis
        $dados = null;
        $baloes = null;
        $negociacao = null;

        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // Busca a negociação
        $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $idNegociacao]);

        // Verifica se encontrou alguma coisa
        if($negociacao->rowCount() > 0)
        {
            // Busca todos os baloes dessa negociacao
            $baloes = $this->ObjModelBalao->get(["Id_negociacao" => $idNegociacao]);

            // Verifica se encontrou algum balão
            if($baloes->rowCount() > 0)
            {
                // Deleta os baloes e verifica se deu certo
                if($this->ObjModelBalao->delete(["Id_negociacao" => $idNegociacao]) != false)
                {
                    // Monta os dados a serem enviados
                    $dados = $baloes->fetchAll(\PDO::FETCH_OBJ);

                    // Avisa a view que tudo deu certo
                    $this->retornoAPI([
                        "tipo" => true,
                        "mensagem" => "Balões deletados com sucesso",
                        "objeto" => $dados
                    ]);
                }
                else
                {
                    // Avisa que deu erro
                    $this->retornoAPI(["mensagem" => "Ocorreu um erro ao deletar os balões"]);
                }
            }
            else
            {
                // Avisa que não encontrou nada
                $this->retornoAPI(["mensagem" => "A negociação informado não possui nenhum balão associado."]);
            }
        }
        else
        {
            // Avisa que não encontrou nada
            $this->retornoAPI(["mensagem" => "A negociação informado não foi encontrado"]);
        }

    } // End >> Fun::deleteAll()


} // END >> Class::Balao