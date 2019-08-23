<?php


namespace Controller;

use Helper\Seguranca;
use Model\Endereco;
use Model\Usuario;
use Sistema\Controller as CI_Controller;

class Corretor extends CI_Controller
{

    // Objetos
    private $ObjHelperSeguranca;
    private $ObjModelEndereco;
    private $ObjModelCorretor;
    private $ObjModelUsuario;

    // Método construtor
    public function __construct()
    {
        // Chama o pai
        parent::__construct();

        // Instancia os objs
        $this->ObjHelperSeguranca = new Seguranca();
        $this->ObjModelEndereco = new  Endereco();
        $this->ObjModelCorretor = new \Model\Corretor();
        $this->ObjModelUsuario = new Usuario();

    } // END >> Fun::__construct()



    public function InsertCorretor()
    {
        if(isset($_POST))
        {
            //CAMPOS NÃO OBRIGATORIO
            if($_POST['status'] == "ativo"){ $status = 1; } else { $status = 0;}


            $salvaEndereco = [
                "cep" => $_POST['cep'],
                "cidade" => $_POST['cidade'],
                "estado" => $_POST['estado'],
                "bairro" => $_POST['bairro'],
                "logradouro" => $_POST['logradouro'],
                "numero" => $_POST['numero'],
                "complemento" => null
            ];


            if(isset($_POST['complemento']) && $_POST['complemento'] != '') { $salvaEndereco['complemento'] = $_POST['complemento']; }

            $IdEndereco = $this->ObjModelEndereco->insert($salvaEndereco);


            if($IdEndereco != null || $IdEndereco != false)
            {
                $salvaCorretor = [
                    "Id_endereco" => $IdEndereco,
                    "cnpj" => $_POST['cnpj'],
                    "empresa" => $_POST['empresa'],
                    "telefone" => null,
                    "celular" => null,
                    "creci" => $_POST['creci'],
                ];

                if(isset($_POST['telefone']) && $_POST['telefone'] != ""){ $salvaCorretor['telefone'] = $_POST['telefone']; }
                if(isset($_POST['celular']) && $_POST['celular'] != ""){ $salvaCorretor['celular'] = $_POST['celular']; }

                $IdCorretor = $this->ObjModelCorretor->insert($salvaCorretor);

                if($IdCorretor != null || $IdEndereco != false){

                    $salvaUsuario = [
                        "Id_corretor" => $IdCorretor,
                        "nome" => $_POST['nome'],
                        "email" => $_POST['email'],
                        "senha" => md5($_POST['senha']),
                        "status" => $status,
                        "nivel" => $_POST['nivel'],
                    ];

                    if ($this->ObjModelUsuario->insert($salvaUsuario)){
                        $dados = [
                            'tipo' => true,
                            'mensagem' => 'Corretor cadastrado com sucesso!'
                        ];
                    }else{
                        $dados = [
                            'tipo' => false,
                            'mensagem' => 'Erro, ao cadastrar usuário'
                        ];
                    }

                }else{
                    $dados = [
                        'tipo' => false,
                        'mensagem' => 'Erro, ao salvar corretor'
                    ];
                }


            }else{
                $dados = [
                    'tipo' => false,
                    'mensagem' => 'Erro, ao salvar endereço'
                ];
            }

        }else{
            $dados = [
                'tipo' => false,
                'mensagem' => 'Erro, tente novamente'
            ];
        }


        echo json_encode($dados);
    } // END >> Fun::InsertCorretor()




    public function Editar($IdCorretor)
    {

        // Seguranca
        $usuario = $this->ObjHelperSeguranca->verificaLogin();

        $buscaCorretor = $this->ObjModelCorretor->get(["Id_corretor" => $IdCorretor])->fetchAll(\PDO::FETCH_OBJ);
        $buscaUsuario = $this->ObjModelUsuario->get(["Id_corretor" => $IdCorretor])->fetchAll(\PDO::FETCH_OBJ);
        $buscaEndereco = $this->ObjModelEndereco->get(["Id_endereco" => $buscaCorretor[0]->Id_endereco])->fetchAll(\PDO::FETCH_OBJ);


        if($this->ObjModelCorretor->get(["Id_corretor" => $IdCorretor])->rowCount() == 1 ){

            $lista = [
                "corretor" => $buscaCorretor,
                "user" => $buscaUsuario,
                "endereco" => $buscaEndereco,
                "usuario" => $usuario
            ];

            $this->view("painel/corretores_editar",$lista);

        }
        else
        {
            header("Location: " . BASE_URL);
        }
    }




    public function ajaxAlterarCorretor(){

        if(isset($_POST)){

            //CAMPOS NÃO OBRIGATORIO
            if($_POST['status'] == "ativo"){ $status = 1; } else { $status = 0; }

            $updateEndereco = [
                "cep" => $_POST['cep'],
                "cidade" => $_POST['cidade'],
                "estado" => $_POST['estado'],
                "bairro" => $_POST['bairro'],
                "logradouro" => $_POST['logradouro'],
                "numero" => $_POST['numero'],
                "complemento" => null
            ];


            if(isset($_POST['complemento']) && $_POST['complemento'] != '') { $updateEndereco['complemento'] = $_POST['complemento']; }

            if($this->ObjModelEndereco->update($updateEndereco,["Id_endereco" => $_POST['Id_endereco']])){

                $updateCorretor = [
                    "telefone" => null,
                    "celular" => null,
                    "cnpj" => $_POST['cnpj'],
                    "empresa" => $_POST['empresa'],
                    "creci" => $_POST['creci'],
                ];

                if(isset($_POST['telefone']) && $_POST['telefone'] != ""){ $updateCorretor['telefone'] = $_POST['telefone']; }
                if(isset($_POST['celular']) && $_POST['celular'] != ""){ $updateCorretor['celular'] = $_POST['celular']; }


                if($this->ObjModelCorretor->update($updateCorretor,["Id_corretor" => $_POST['Id_corretor']])){

                    $updateUsuario = [
                        "nome" => $_POST['nome'],
                        "status" => $status,
                        "nivel" => $_POST['nivel'],
                    ];

                    if(isset($_POST['senha']) && $_POST['senha'] != ""){ $updateUsuario['senha'] = md5($_POST['senha']); }


                    if ($this->ObjModelUsuario->update($updateUsuario,["Id_usuario" => $_POST['Id_usuario']])){
                        $dados = [
                            'tipo' => true,
                            'mensagem' => 'Corretor alterado com sucesso!'
                        ];
                    }else{
                        $dados = [
                            'tipo' => false,
                            'mensagem' => 'Erro, ao cadastrar usuário'
                        ];
                    }

                }else{
                    $dados = [
                        'tipo' => false,
                        'mensagem' => 'Erro, ao salvar corretor'
                    ];
                }


            }else{
                $dados = [
                    'tipo' => false,
                    'mensagem' => 'Erro, ao salvar endereço'
                ];
            }

        }else{
            $dados = [
                'tipo' => false,
                'mensagem' => 'Erro, tente novamente'
            ];
        }


        echo json_encode($dados);
    }




    public function alterarStatus()
    {
        // Variaveis
        $dados = null;
        $salva = null;
        $usuario = null;
        $altera = null;

        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // POST
        $post = $_POST;

        // Busca o usuario
        $usuario = $this->ObjModelUsuario->get(["Id_usuario" => $post["Id_usuario"]])->fetch(\PDO::FETCH_OBJ);

        // Verifica se achou
        if($usuario != null && $usuario != false)
        {
            if($usuario->status != $post["status"])
            {
                $altera["status"] = $post["status"];
            }

            if($usuario->nivel != $post["nivel"])
            {
                $altera["nivel"] = $post["nivel"];
            }

            // Verifica se vai alterar algo
            if($altera != null)
            {
                if($this->ObjModelUsuario->update($altera,["Id_usuario" => $post["Id_usuario"]]) != false)
                {
                    $this->retornoAPI(["mensagem" => "Usuário alterado com sucesso.", "tipo" => true]);
                }
                else
                {
                    $this->retornoAPI(["mensagem" => "Ocorreu um erro ao alterar usuário."]);
                }
            }
            else
            {
                $this->retornoAPI(["mensagem" => "Nenhum campo foi alterado."]);
            }
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Usuário não encontrado."]);
        }

    } // END >> Fun::alterarStatus()




    public function get($id = null)
    {
        // Variaveis
        $dados = null;
        $corretor = null;
        $usuario = null;
        $endereco = null;

        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // Busca o corretor
        $corretor = $this->ObjModelCorretor->get(["Id_corretor" => $id]);

        // Verifica
        if($corretor->rowCount() > 0)
        {
            // Fetch
            $corretor = $corretor->fetch(\PDO::FETCH_OBJ);

            // Retorna
            $this->retornoAPI([
                "tipo" => true,
                "objeto" => $corretor
            ]);
        }
        else
        {
            $this->retornoAPI(["mensagem" => "Corretor não encontrado"]);
        }

    } // END >> Fun::get()

} // END >> Class::Corretor