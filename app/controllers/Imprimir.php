<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 22/07/2019
 * Time: 10:57
 */


namespace Controller;

use DateTime;
use Dompdf\Dompdf;
use Boleto\Boleto;
use Boleto\Cedente;
use Boleto\Sacado;
use Boleto\GeradorBoleto;
use Boleto\Banco\Sicredi;
use Helper\Seguranca;
use Model\Corretor;
use Model\Endereco;
use Model\ValorFinanciamento;
use Sistema\Controller as CI_Controller;

class Imprimir extends CI_Controller
{
    // Objetos
    private $ObjHelperSeguranca;
    private $ObjModelNegociacao;
    private $ObjModelCliente;
    private $ObjModelLote;
    private $ObjModelUsuario;
    private $ObjModelCorretor;
    private $ObjModelEndereco;
    private $ObjModelFinanciamento;
    private $ObjModelBalao;

    // Método constutor
    public function __construct()
    {
        // Oh Pai!
        parent::__construct();

        // Instancia os Objetos
        $this->ObjHelperSeguranca = new Seguranca();
        $this->ObjModelNegociacao = new \Model\Negociacao();
        $this->ObjModelCliente = new \Model\Cliente();
        $this->ObjModelLote = new \Model\Lote();
        $this->ObjModelUsuario = new \Model\Usuario();
        $this->ObjModelCorretor = new Corretor();
        $this->ObjModelEndereco = new Endereco();
        $this->ObjModelFinanciamento = new ValorFinanciamento();
        $this->ObjModelBalao = new \Model\Balao();

    } // END >> Fun::__construct()




    /**
     * Método responsável por gerar os boletos
     * da entrada e da primeira parcela de uma negociação
     * -----------------------------------------------------
     * @param $tipo
     * @param $idNeg
     */
    public function boleto($tipo, $id, $numItem = null)
    {
        // Variaveis
        $dados = null;
        $cliente = null;
        $negociacao = null;
        $lote = null;

        // Gambiarra suave
        $numItem = ($numItem == null) ? 0 : $numItem - 1;

        // Verifica o tipo
        if($tipo == "balao")
        {
            // Busca o balao
            $balao = $this->ObjModelBalao->get(["Id_balao" => $id])->fetch(\PDO::FETCH_OBJ);

            // Busca a negociação
            $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $balao->Id_negociacao])->fetch(\PDO::FETCH_OBJ);

            // Seta o valor e de vencimento
            $valor = number_format($balao->valor, 2, ",", "");
            $dataVencimento = DateTime::createFromFormat("Y-m-d", $balao->data);
        }
        else
        {
            // Busca a negociação
            $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $id])->fetch(\PDO::FETCH_OBJ);

            // Verifica se é entrada ou parcela
            if($tipo == "entrada")
            {
                // Valor da entrada
                $valor = number_format(($negociacao->valorEntrada / $negociacao->numEntrada), 2, ",", "");

                // Seta a data de vencimento
                $dataVencimento = date('Y-m-d', strtotime("+{$numItem} months",strtotime($negociacao->vencimentoEntrada)));
                $dataVencimento = DateTime::createFromFormat("Y-m-d", $negociacao->vencimentoEntrada);
            }
            else
            {
                // Busca o lote
                $lote = $this->ObjModelLote->get(["Id_lote" => $negociacao->Id_lote])->fetch(\PDO::FETCH_OBJ);

                // Verifica se possui juros
                if($negociacao->juros == true)
                {
                    // Busca o financiamento
                    if($negociacao->Id_valorFinanciamento == 0)
                    {
                        $valor = $lote->valor;
                    }
                    else
                    {
                        $financiamento = $this->ObjModelFinanciamento->get(["Id_valorFinanciamento" => $negociacao->Id_valorFinanciamento])->fetch(\PDO::FETCH_ASSOC);
                        $finValor = $financiamento["parcela_" . $negociacao->numParcela];

                        // Seta o valor
                        $valor = str_replace(",",".",$finValor);
                    }
                }
                else
                {
                    $valor = ($lote->valor - $negociacao->valorEntrada) / $negociacao->numParcela;
                }

                // Valor
                $valor = number_format($valor, 2, ",", "");

                // Dara vencimento
                $dataVencimento = date('Y-m-d', strtotime("+{$numItem} months",strtotime($negociacao->vencimentoParcela)));
                $dataVencimento = DateTime::createFromFormat("Y-m-d", $dataVencimento);
            }
        }


        // Busca o cliente da negociacao
        $cliente = $this->ObjModelCliente->get(["Id_cliente" => $negociacao->Id_cliente])->fetch(\PDO::FETCH_OBJ);
        $endereco = $this->ObjModelEndereco->get(["Id_endereco" => $cliente->Id_endereco])->fetch(\PDO::FETCH_OBJ);

        $logradouro = explode(" ", $endereco->logradouro);
        $end = str_replace($logradouro[0],"", $endereco->logradouro);


        // -- Gera o Boleto
        $Boleto = new Boleto();

        //Configurações do banco
        $Sicredi = new Sicredi();
        $Sicredi->setCarteira('A');//C - Sem registro | A - Com Registro
        $Sicredi->setPosto("04");
        $Sicredi->setByte("2");

        //Dados do Boleto
        $Boleto->setBanco($Sicredi);
        $Boleto->setNumeroMoeda("9");
        $Boleto->setDataVencimento($dataVencimento);
        $Boleto->setDataDocumento(DateTime::createFromFormat('d/m/Y', date("d/m/Y")));
        $Boleto->setDataProcessamento(DateTime::createFromFormat('d/m/Y', date("d/m/Y")));
        $Boleto->addInstrucao("- Sr. Caixa, não receber após o vencimento");
        $Boleto->addInstrucao("- Após o vencimento cobrar mora diária de 0,33%");
        $Boleto->addDemonstrativo("Orçamento realizado em " . date("d/m/Y"));
        $Boleto->addDemonstrativo("Execução de serviços diversos");
        $Boleto->setValorBoleto($valor);
        $Boleto->setNossoNumero(str_pad($negociacao->Id_negociacao, 5, "0", STR_PAD_LEFT));

        //Dados do Cendente
        $Cedente = new Cedente();
        $Cedente->setNome("PAU BRASIL EMPREENDIMENTOS IMOBILIÁRIOS LTDA");
        $Cedente->setAgencia("3021");
        $Cedente->setDvAgencia("04");
        $Cedente->setConta("09866");
        $Cedente->setDvConta("3");
        $Cedente->setEndereco("Rua Afonso Pena, N&ordm; 613, Centro");
        $Cedente->setCidade("Araçatuba");
        $Cedente->setUf("SP");
        $Cedente->setCpfCnpj("00.858.180/0001-47");
        $Cedente->setCodigoCedente("09866");
        $Boleto->setCedente($Cedente);

        //Dados do Sacado
        $Sacado = new Sacado();
        $Sacado->setNome($cliente->nome);
        $Sacado->setTipoLogradouro($logradouro[0]);
        $Sacado->setEnderecoLogradouro($end);
        $Sacado->setNumeroLogradouro($endereco->numero);
        $Sacado->setCidade($endereco->cidade);
        $Sacado->setUf($endereco->estado);
        $Sacado->setCpfCnpj($cliente->cpf);
        $Sacado->setCep($endereco->cep);
        $Boleto->setSacado($Sacado);

        //Gera nosso número padrão sicredi
        $Sicredi->setNossoNumeroFormatado($Boleto);

        //Gera boleto em PDF
        $GeradorBoleto = new GeradorBoleto();
        $GeradorBoleto->gerar($Boleto)->Output('boleto.pdf', 'I');

    } // END >> Fun::boleto()




    /**
     * Método responsável por gerar o contrato de venda
     * de um determinado lote.
     * -------------------------------------------------
     * @param $idNeg
     */
    public function contrato($idNeg)
    {
        // Seguranca
        $this->ObjHelperSeguranca->verificaLogin();

        // Pega o conteudo
        $html = file_get_contents(BASE_URL . "imprimir/view-contrato/" . $idNeg);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $dompdf->loadHtml($html,'UTF-8');

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream("contrato.pdf", array("Attachment" => 1));

    } // END >> Fun::contrato()


    // Metodo responsável por criar a tela de exibição do contrato
    public function viewContrato($idNeg)
    {
        // Variaveis
        $dados = null;
        $negociacao = null;
        $corretor = null;
        $cliente = null;
        $lote = null;
        $esposa = null;
        $meses = ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"];

        // Busca os dados necessarios
        $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $idNeg])->fetch(\PDO::FETCH_OBJ);

        $usuario =  $this->ObjModelUsuario->get(["Id_usuario" => $negociacao->Id_usuario])->fetch(\PDO::FETCH_OBJ);
        $corretor = $this->ObjModelCorretor->get(["Id_corretor" => $usuario->Id_corretor])->fetch(\PDO::FETCH_OBJ);
        $corretor->email = $usuario->email;
        $corretor->nome = $usuario->nome;

        $lote = $this->ObjModelLote->get(["Id_lote" => $negociacao->Id_lote])->fetch(\PDO::FETCH_OBJ);
        $cliente = $this->ObjModelCliente->get(["Id_cliente" => $negociacao->Id_cliente])->fetch(\PDO::FETCH_OBJ);

        // Verifica se é casado
        if($cliente->Id_esposa != null)
        {
            $esposa = $this->ObjModelCliente->get(["Id_cliente" => $cliente->Id_esposa])->fetch(\PDO::FETCH_OBJ);
        }

        $endereco = $this->ObjModelEndereco->get(["Id_endereco" => $cliente->Id_endereco])->fetch(\PDO::FETCH_OBJ);


        $financiamento = $this->ObjModelFinanciamento->get(["Id_valorFinanciamento" => $negociacao->Id_valorFinanciamento])->fetch(\PDO::FETCH_ASSOC);
        $valorParcela = $financiamento["parcela_" . $negociacao->numParcela];

        // Add o valor a negociacao
        $negociacao->valorParcela = str_replace(",",".",$valorParcela);

        // Dados da view
        $dados = [
            "corretor" => $corretor,
            "negociacao" => $negociacao,
            "lote" => $lote,
            "cliente" => $cliente,
            "endereco" => $endereco,
            "esposa" => $esposa,
            "mes" => $meses
        ];

        // Pega o html
        $this->view("contrato",$dados);
    } // END >> Fun::viewContrato()




    /*****************************************
     *
     *           MÉTODOS PRIVADOS
     *
     *****************************************/





} // END >> Class::Imprimir