<?php
namespace Controller;

use Helper\Seguranca;
use Model\Endereco;
use Sistema\Controller as CI_Controller;

class Cliente extends CI_Controller
{

    // Objetos
    private $ObjHelperSeguranca;
    private $ObjModelCliente;
    private $ObjModelLote;
    private $ObjModelNegociacao;
    private $ObjModelEndereco;
    private $ObjControllerNegociacao;

    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia os objs
        $this->ObjHelperSeguranca = new Seguranca();
        $this->ObjModelCliente = new \Model\Cliente();
        $this->ObjModelLote = new \Model\Lote();
        $this->ObjModelNegociacao = new \Model\Negociacao();
        $this->ObjModelEndereco = new Endereco();
        $this->ObjControllerNegociacao = new Negociacao();

    } // END >> Fun::__construct()


    /**
     * Método responsável por retornar um determinado cliente, buscando o mesmo
     * pelo seu CPF.
     * -----------------------------------------------------------------------
     * @URL cliente/busca-por-cpf/[CPF]
     * @METODO GET
     *
     * @param string $cpf
     */
    public function buscaPorCPF($cpf = null)
    {
        // Variaveis
        $usuario = null;
        $cliente = null;
        $dados = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Limpa o CPF
        $cpf = preg_replace("/[^0-9]/","", $cpf);

        // Busca o Cliente
        $cliente = $this->ObjModelCliente->get(["cpf" => $cpf]);

        // Verifica se encontrou algo
        if($cliente->rowCount() > 0)
        {
            $this->retornoAPI([
                "tipo" => true,
                "objeto" => $cliente->fetch(\PDO::FETCH_OBJ)
            ]);
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Cliente não encontrado"]);
        }

    } // END >> Fun::buscaPorCPF()




    /**
     * Método responsável por receber as informações e a solicitação
     * para adicionar novos clientes no banco de dados ou retornar
     * clientes já cadastados.
     *
     * @param null $idNegociacao
     */
    public function insert($idNegociacao = null)
    {
        // Dados
        $salvaEnd = null;
        $idEndereco = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Post
        $post = $_POST;

        // Verifica se passou o Id de um determinado cliente
        if(isset($post["Id_cliente"]) == true)
        {
            // Busca o Cliente
            $cliente = $this->ObjModelCliente->get(["Id_cliente" => $post["Id_cliente"]]);

            // Verifica se encontrou realmente
            if($cliente->rowCount() > 0)
            {
                // Altera a tabela negociação
                if($this->ObjControllerNegociacao->addClienteEmNegociacao($post["Id_cliente"], $idNegociacao) != false)
                {
                    // Avisa que deu certo
                    $this->retornoAPI([
                        "tipo" => true,
                        "objeto" => $cliente->fetch(\PDO::FETCH_OBJ)
                    ]);
                }
                else
                {
                    // Avisa que deu erro
                    $this->retornoAPI(["mensagem" => "Erro ao alterar negociação."]);
                }
            }
            else
            {
                // Avisa que deu ruim
                $this->retornoAPI(["mensagem" => "Cliente não encontrado."]);
            }
        }
        else
        {
            // Os dados para inserir o endereco
            $salvaEnd = [
                "cep" => preg_replace("/[^0-9]/","",$post["cep"]),
                "bairro" => $post["bairro"],
                "cidade" => $post["cidade"],
                "estado" => $post["estado"],
                "logradouro" => $post["endereco"],
                "numero" => $post["numero"],
                "complemento" => $post["complemento"]
            ];

            // Salva o endereco
            $idEndereco = $this->ObjModelEndereco->insert($salvaEnd);

            // Verifica se o endereço foi inserido
            if($idEndereco != null && $idEndereco != false)
            {
                // Cpf
                $cpf = preg_replace("/[^0-9]/","",$post["cpf"]);

                // Salva o cliente 1
                $salvaCli1 = [
                    "Id_endereco" => $idEndereco,
                    "Id_esposa" => null,
                    "nome" => ucwords(strtolower($post["nome"])),
                    "rg" => $post["rg"],
                    "cpf" => $cpf,
                    "email" => $post["email"],
                    "renda" => preg_replace("/[^0-9]/","", $post["renda"]),
                    "telefone" => $post["telefone"],
                    "celular" => $post["celular"],
                    "dataNascimento" => $post["dataNascimento"],
                    "profissao" => ucfirst(strtolower($post["profissao"])),
                    "localTrabalho" => ucfirst(strtolower($post["localTrabalho"])),
                    "estadoCivil" => $post["estadoCivil"]
                ];


                // -- Verifica se é empresa
                if(isset($post["cnpj"]) == true)
                {
                    // Verifica se o cnpj é valido
                    if($this->validarCNPJ($post["cnpj"]) == true)
                    {
                        $salvaCli1["cnpj"] = preg_replace('/[^0-9]/', '', (string) $post["cnpj"]);
                        $salvaCli1["ie"] = $post["ie"];
                        $salvaCli1["nomeEmpresa"] = $post["nomeEmpresa"];
                    }
                    else
                    {
                        // Envia a mensagem de erro e mata o código
                        $this->retornoAPI([
                            "mensagem" => "CNPJ informado é inválido."
                        ]);
                    }
                }

                // Insere o cliente
                $cliente1 = $this->inserirCliente($salvaCli1,"arquivo");

                // Verifica se foi inserido
                if($cliente1["tipo"] == true)
                {
                    // Verifica se é casado
                    if($post["estadoCivil"] == "casado")
                    {
                        // -- Configura os dados para add a esposa

                        // Cpf
                        $cpf = preg_replace("/[^0-9]/","",$post["esp_cpf"]);

                        // Salva o cliente 2
                        $salvaCli2 = [
                            "Id_endereco" => $idEndereco,
                            "Id_esposa" => $cliente1["objeto"]->Id_cliente,
                            "nome" => ucwords(strtolower($post["esp_nome"])),
                            "rg" => $post["esp_rg"],
                            "cpf" => $cpf,
                            "email" => $post["esp_email"],
                            "renda" => preg_replace("/[^0-9]/","", $post["esp_renda"]),
                            "telefone" => $post["esp_telefone"],
                            "celular" => $post["esp_celular"],
                            "dataNascimento" => $post["esp_dataNascimento"],
                            "profissao" => ucfirst(strtolower($post["esp_profissao"])),
                            "localTrabalho" => ucfirst(strtolower($post["esp_localTrabalho"])),
                            "estadoCivil" => $post["esp_estadoCivil"]
                        ];

                        // Insere o cliente 2
                        $cliente2 = $this->inserirCliente($salvaCli2,"esp_arquivo");

                        // Verifica se deu certo
                        if($cliente2["tipo"] == true)
                        {
                            $cli1 = $cliente1["objeto"];
                            $cli2 = $cliente2["objeto"];

                            // Altera add o Id do cliente 2
                            $this->ObjModelCliente->update(["Id_esposa" => $cli2->Id_cliente],["Id_cliente" => $cli1->Id_cliente]);

                            // Verifica se informou a negociacao
                            if($idNegociacao != null)
                            {
                                // Add o cliente a negociação
                                $this->ObjControllerNegociacao->addClienteEmNegociacao($cli1->Id_cliente, $idNegociacao);
                            }

                            // Add os dados ao retorno
                            $cli1->Id_esposa = $cli2->Id_cliente;
                            $cli1->esposa = $cli2;

                            // retorna
                            $this->retornoAPI([
                                "tipo" => true,
                                "objeto" => $cli1
                            ]);
                        }
                        else
                        {
                            // Deleta o cliente 1
                            $this->ObjModelCliente->delete(["Id_cliente" => $cliente1["objeto"]->Id_cliente]);

                            // Retorna que deu certo
                            $this->retornoAPI($cliente2);
                        }
                    }
                    else
                    {
                        // Verifica se informou a negociacao
                        if($idNegociacao != null)
                        {
                            // Add o cliente a negociação
                            $this->ObjControllerNegociacao->addClienteEmNegociacao($cliente1["objeto"]->Id_cliente, $idNegociacao);
                        }

                        // Retorna que deu certo
                        $this->retornoAPI($cliente1);
                    }
                }
                else
                {
                    $this->retornoAPI($cliente1);
                }
            }
            else
            {
                $this->retornoAPI(["mensagem" => "Erro ao adicionar o endereço."]);
            }
        }

    } // END >> Fun::insert()




    /**
     * Método responsável por fazer a alteração
     * nos dados do clinete incluindo esposa e endereco dos
     * clientes já cadastados.
     *
     * @param null $Id_cliente
     */
    public function update($Id_cliente = null){

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        if(isset($_POST))
        {
            // Variaveis
            $esposa = null;

            // Informações POST
            $post = $_POST;

            // Busca o cliente
            $cliente = $this->ObjModelCliente->get(["Id_cliente" => $Id_cliente])->fetch(\PDO::FETCH_OBJ);

            // Dados da esposa
            $dadosEsposa = [
                "Id_esposa" => $_POST['Id_cliente'],
                "Id_endereco" => $cliente->Id_endereco,
                "nome" => $_POST['esp_nome'],
                "email" => $_POST['esp_email'],
                "cpf" =>  preg_replace("/[^0-9]/","",$_POST['esp_cpf']),
                "rg" => $_POST['esp_rg'],
                "telefone" => $_POST['esp_telefone'],
                "celular" => $_POST['esp_celular'],
                "profissao" => $_POST['esp_profissao'],
                "localTrabalho" => $_POST['esp_localTrabalho'],
                "renda" => preg_replace("/[^0-9]/","",$_POST['esp_renda']),
                "estadoCivil" => $_POST['esp_estadoCivil'],
                "dataNascimento" => null,
            ];


            // Verifica se exite esposa
            if($cliente->Id_esposa == 0 || $cliente->Id_esposa == null || $cliente->Id_esposa == "")
            {
                if($post["estadoCivil"] == "casado")
                {
                    // Data nascimento
                    $corno = $_POST['esp_dataNascimento'];
                    $corno = explode("/",$corno);

                    $dadosEsposa["dataNascimento"] = $corno[2] . "-" . $corno[1] . "-" . $corno[0];

                    $esposa = $this->inserirCliente($dadosEsposa, "esp_arquivo");

                    // Verifica se deu erro
                    if($esposa["tipo"] == false)
                    {
                        // se deu retorna e mata o codigo
                        $this->retornoAPI($esposa);
                    }
                }

            }else{

                // Data nascimento
                $corno = $_POST['esp_dataNascimento'];
                $corno = explode("/",$corno);

                $dadosEsposa["dataNascimento"] = $corno[2] . "-" . $corno[1] . "-" . $corno[0];
                $dadosEsposa["Id_cliente"] = $cliente->Id_esposa;

                $esposa = $this->updateCliente($dadosEsposa, "esp_arquivo");

                // Verifica se deu erro
                if($esposa["tipo"] == false)
                {
                    // se deu retorna e mata o codigo
                    $this->retornoAPI($esposa);
                }
            }

            // Data nascimento
            $corno = $_POST['dataNascimento'];
            $corno = explode("/", $corno);

            $dtCli = $corno[2] . "-" . $corno[1] . "-" . $corno[0];

            $alteraCliente = [
                "Id_cliente" => $_POST['Id_cliente'],
                "nome" => $_POST['nome'],
                "email" => $_POST['email'],
                "cpf" =>  preg_replace("/[^0-9]/","",$_POST['cpf']),
                "rg" => $_POST['rg'],
                "telefone" => $_POST['telefone'],
                "celular" => $_POST['celular'],
                "profissao" => $_POST['profissao'],
                "localTrabalho" => $_POST['localTrabalho'],
                "renda" => preg_replace("/[^0-9]/","",$_POST['renda']),
                "estadoCivil" => $_POST['estadoCivil'],
                "dataNascimento" => $dtCli,
            ];


            // -- Verifica se é empresa
            if(isset($post["cnpj"]) == true)
            {
                // Verifica se o cnpj é valido
                if($this->validarCNPJ($post["cnpj"]) == true)
                {
                    $alteraCliente["cnpj"] = preg_replace('/[^0-9]/', '', (string) $post["cnpj"]);
                    $alteraCliente["ie"] = $post["ie"];
                    $alteraCliente["nomeEmpresa"] = $post["nomeEmpresa"];
                }
                else
                {
                    // Envia a mensagem de erro e mata o código
                    $this->retornoAPI([
                        "mensagem" => "CNPJ informado é inválido."
                    ]);
                }
            }


            if($cliente->Id_esposa != 0 && $cliente->Id_esposa != null && $cliente->Id_esposa != "")
            {
                $alteraCliente["Id_esposa"] = $cliente->Id_esposa;
            }
            else
            {
                if($esposa != null)
                {
                    $alteraCliente["Id_esposa"] = $esposa["objeto"]->Id_cliente;
                }
            }


            $clienteAlterado = $this->updateCliente($alteraCliente, "arquivo");

            // Verifica se deu erro
            if($clienteAlterado["tipo"] == false)
            {
                // se deu retorna e mata o codigo
                $this->retornoAPI($esposa);
            }

            $alteraEndereco = [
                "Id_endereco" => $_POST['Id_endereco'],
                "cep" => $_POST['cep'],
                "cidade" => $_POST['bairro'],
                "estado" => $_POST['estado'],
                "bairro" => $_POST['bairro'],
                "logradouro" => $_POST['endereco'],
                "numero" => $_POST['numero'],
                "complemento" => $_POST['complemento'],
            ];

            if($this->ObjModelEndereco->update($alteraEndereco, ["Id_endereco" => $cliente->Id_endereco])){

                // Avisa que deu erro
                $this->retornoAPI([
                    "tipo" => true,
                    "mensagem" => "Dados alterados com sucesso",
                ]);

            }else{
                // Avisa que deu erro
                $this->retornoAPI([
                    "mensagem" => "Erro ao alterar dados",
                ]);
            }


        }else{
            // Avisa que deu erro
            $this->retornoAPI([
                "mensagem" => "Dados não enviado",
            ]);
        }

    } // END >> Fun::update()




    /**
     * Método responsável por buscar todos os dados de um determinado cliente
     * e retornar no formato JSON
     * ----------------------------------------------------------------------
     * @URL cliente/get/[ID]
     * @METODO GET
     *
     * @param null $idCliente
     */
    public function get($idCliente = null)
    {
        // Variaveis
        $dados = null;
        $cliente = null;
        $endereco = null;
        $usuario = null;
        $esposa = null;

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        // Busca o Cliente
        $cliente = $this->ObjModelCliente->get(["Id_cliente" => $idCliente]);

        // Verifica se encontrou
        if($cliente->rowCount() > 0)
        {
            // Fetch
            $cliente = $cliente->fetch(\PDO::FETCH_OBJ);

            // Arruma os dados
            $cliente->dataNascimento = date("d/m/Y",strtotime($cliente->dataNascimento));
            $cliente->renda = number_format(preg_replace("/[^0-9]/","",$cliente->renda),2,",",".");

            // Add as variaveis a mais
            $cliente->endereco = null;
            $cliente->esposa = null;

            // Verifica se possui endereço
            if($cliente->Id_endereco != null && $cliente->Id_endereco != "")
            {
                // Busca o endereco
                $endereco = $this->ObjModelEndereco->get(["Id_endereco" => $cliente->Id_endereco])->fetch(\PDO::FETCH_OBJ);

                // Add o endereco
                $cliente->endereco = $endereco;
            }

            // Verifica se possui esposa
            if($cliente->Id_esposa != null && $cliente->Id_esposa != "" && $cliente->Id_esposa != 0)
            {
                // Busca a esposa
                $esposa = $this->ObjModelCliente->get(["Id_cliente" => $cliente->Id_esposa])->fetch(\PDO::FETCH_OBJ);

                // Arruma os dados
                $esposa->dataNascimento = date("d/m/Y",strtotime($esposa->dataNascimento));
                $esposa->renda = number_format(preg_replace("/[^0-9]/","",$esposa->renda),2,",",".");

                // Add a esposa
                $cliente->esposa = $esposa;
            }

            // Envia os dados
            $this->retornoAPI([
                "tipo" => true,
                "objeto" => $cliente
            ]);
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Cliente informado não existe."]);
        }

    } // END >> Fun::get()



    /**
     *  ==================================================================
     *                        MÉTODOS PRIVADOS
     *  ==================================================================
     */



    /**
     * Método responsável por realizar todos as validações necessárias
     * para inserir um cliente no banco de dados.
     * ---------------------------------------------------------------
     * @param $cliente array
     * @param $arqPrefixo string
     * @return bool|array
     */
    private function inserirCliente($cliente, $arqPrefixo)
    {
        // Variaveis
        $dados = null;
        $caminho = "./arquivos/storange/documentos/";
        $cpf = null;
        $rg = null;
        $casamento = null;
        $residencia = null;
        $altera = null;

        // Verifica se existe o CPF cadastrado
        if($this->ObjModelCliente->get(["cpf" => $cliente["cpf"]])->rowCount() == 0)
        {
            // Verifica se o cpf é valido
            if($this->validarCPF($cliente["cpf"]) == true)
            {
                // Faz o insert
                $id = $this->ObjModelCliente->insert($cliente);

                // Verifica se inseriu
                if($id != false && $id != null)
                {
                    // Caminho
                    $caminho = $caminho . $id;

                    // Verifica se o caminho existe
                    if(!is_dir($caminho))
                    {
                        // Cria o diretório
                        mkdir($caminho,0777,true);
                    }


                    // Faz o upload dos documentos
                    if(isset($_FILES[$arqPrefixo . "_rg"]))
                    {
                        // Realiza  o upload
                        $rg = $this->uploadFile($_FILES[$arqPrefixo . "_rg"],$caminho, "rg-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                        // Verifica se deu certo
                        if($rg != null && $rg != false)
                        {
                            $altera["img_rg"] = $rg;
                        }
                    }

                    if(isset($_FILES[$arqPrefixo . "_cpf"]))
                    {
                        // Realiza  o upload
                        $cpf = $this->uploadFile($_FILES[$arqPrefixo . "_cpf"],$caminho,"cpf-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                        // Verifica se deu certo
                        if($cpf != null && $cpf != false)
                        {
                            $altera["img_cpf"] = $cpf;
                        }
                    }

                    if(isset($_FILES[$arqPrefixo . "_casamento"]))
                    {
                        // Realiza  o upload
                        $casamento = $this->uploadFile($_FILES[$arqPrefixo . "_casamento"],$caminho,"casamento-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                        // Verifica se deu certo
                        if($casamento != null && $casamento != false)
                        {
                            $altera["img_casamento"] = $casamento;
                        }
                    }

                    if(isset($_FILES[$arqPrefixo . "_residencia"]))
                    {
                        // Realiza  o upload
                        $residencia = $this->uploadFile($_FILES[$arqPrefixo . "_residencia"],$caminho,"residencia-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                        // Verifica se deu certo
                        if($residencia != null && $residencia != false)
                        {
                            $altera["img_residencia"] = $residencia;
                        }
                    }


                    // Verifica se algum documento foi upado
                    if($altera != null)
                    {
                        // Altera
                        $this->ObjModelCliente->update($altera,["Id_cliente" => $id]);
                    }

                    // Busca o cliente e retorna
                    $cliente = $this->ObjModelCliente->get(["Id_cliente" => $id])->fetch(\PDO::FETCH_OBJ);

                    // retorna
                    $dados = [
                        "tipo" => true,
                        "objeto" => $cliente
                    ];
                }
                else
                {
                    $dados = [
                        "tipo" => false,
                        "mensagem" => "Ocorreu um erro ao adicionar usuário."
                    ];
                }
            }
            else
            {
                $dados = [
                    "tipo" => false,
                    "mensagem" => "O CPF informado é inválido."
                ];
            }
        }
        else
        {
            $dados = [
                "tipo" => false,
                "mensagem" => "Já existe um cliente com o CPF informado."
            ];
        }

        return $dados;

    } // END >> Fun::inserirCliente()



    /**
     * Método responsável por realizar todos as validações necessárias
     * para inserir um cliente no banco de dados.
     * ---------------------------------------------------------------
     * @param $cliente array
     * @param $arqPrefixo string
     * @return bool|array
     */
    private function updateCliente($cliente, $arqPrefixo)
    {
        // Variaveis
        $dados = null;
        $caminho = "./arquivos/storange/documentos/";
        $cpf = null;
        $rg = null;
        $casamento = null;
        $residencia = null;
        $altera = null;

        // Verifica se inseriu
        if(isset($cliente['Id_cliente']))
        {
            // Faz o insert
            $id = $cliente['Id_cliente'];

            // Remover o id do cliente de dentro do array
            unset($cliente["Id_cliente"]);

            // Dados a ser alterados
            $altera = $cliente;

            // Caminho
            $caminho = $caminho . $id;

            // Verifica se o caminho existe
            if(!is_dir($caminho))
            {
                // Cria o diretório
                mkdir($caminho,0777,true);
            }

            // Faz o upload dos documentos
            if(isset($_FILES[$arqPrefixo . "_rg"]['name']))
            {
                // Realiza  o upload
                $rg = $this->uploadFile($_FILES[$arqPrefixo . "_rg"],$caminho, "rg-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                // Verifica se deu certo
                if($rg != null && $rg != false)
                {
                    $altera["img_rg"] = $rg;
                }
            }

            if(isset($_FILES[$arqPrefixo . "_cpf"]['name']))
            {
                // Realiza  o upload
                $cpf = $this->uploadFile($_FILES[$arqPrefixo . "_cpf"],$caminho,"cpf-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                // Verifica se deu certo
                if($cpf != null && $cpf != false)
                {
                    $altera["img_cpf"] = $cpf;
                }
            }

            if(isset($_FILES[$arqPrefixo . "_casamento"]['name']))
            {
                // Realiza  o upload
                $casamento = $this->uploadFile($_FILES[$arqPrefixo . "_casamento"],$caminho,"casamento-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                // Verifica se deu certo
                if($casamento != null && $casamento != false)
                {
                    $altera["img_casamento"] = $casamento;
                }
            }

            if(isset($_FILES[$arqPrefixo . "_residencia"]['name']))
            {
                // Realiza  o upload
                $residencia = $this->uploadFile($_FILES[$arqPrefixo . "_residencia"],$caminho,"residencia-" . date("Y-m-d-his"),"jpg|png|jpeg|pdf|doc|docx",5*MB);

                // Verifica se deu certo
                if($residencia != null && $residencia != false)
                {
                    $altera["img_residencia"] = $residencia;
                }
            }


            // Verifica se algum para ser alterado
            if($altera != null)
            {
                // Altera
                $this->ObjModelCliente->update($altera,["Id_cliente" => $id]);

                // Busca o cliente e retorna
                $cliente = $this->ObjModelCliente->get(["Id_cliente" => $id])->fetch(\PDO::FETCH_OBJ);

                // retorna
                $dados = [
                    "tipo" => true,
                    "objeto" => $cliente
                ];
            }
            else
            {
                $dados = [
                    "tipo" => false,
                    "mensagem" => "Nenhum dado informado para ser alterado."
                ];
            }
        }
        else
        {
            $dados = [
                "tipo" => false,
                "mensagem" => "Ocorreu um erro ao adicionar usuário."
            ];
        }


        return $dados;

    } // END >> Fun::inserirCliente()



    /**
     * Método responsável por validar se o CPF do usuário informado é
     * real ou não.
     * --------------------------------------------------------------
     * @param $cpf
     * @return bool
     */
    private function validarCPF($cpf)
    {
        // Verifiva se o número digitado contém todos os digitos
        $cpf = str_pad(preg_replace("/[^0-9]/", "", $cpf), 11, '0', STR_PAD_LEFT);

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
        {
            return false;
        }
        else
        {
            // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }// END >> Fun::validaCPF()





    /**
     * Método responsável por verificar se um CNPJ é válido e retornar
     * True ou False para o mesmo.
     *
     * ---------------------------------------------------------------
     * @author guisehn
     * @license https://gist.github.com/guisehn/3276302
     *
     * @param string|int $cnpj
     * @return bool
     */
    private function validarCNPJ($cnpj)
    {
        // remove supostas mascaras
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);


        // Lista de CNPJs inválidos
        $invalidos = [
            '00000000000000',
            '11111111111111',
            '22222222222222',
            '33333333333333',
            '44444444444444',
            '55555555555555',
            '66666666666666',
            '77777777777777',
            '88888888888888',
            '99999999999999'
        ];


        // Verifica se o CNPJ está na lista de inválidos
        if (in_array($cnpj, $invalidos))
        {
            return false;
        }


        // Valida tamanho
        if (strlen($cnpj) != 14)
        {
            return false;
        }


        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
        {
            return false;
        }


        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
        {
            return false;
        }


        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
        {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);

    } // End >> Fun::validarCNPJ()


} // END >> Class::Cliente