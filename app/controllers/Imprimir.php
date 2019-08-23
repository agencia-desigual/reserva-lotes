<?php
/**
 * Created by PhpStorm.
 * User: Igor
 * Date: 22/07/2019
 * Time: 10:57
 */


namespace Controller;

use Dompdf\Dompdf;
use Helper\Seguranca;
use Model\Corretor;
use Model\Endereco;
use Model\SiteCadastro;
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

        require_once ("./app/library/dompdf/autoload.inc.php");

    } // END >> Fun::__construct()


    /**
     * Método responsável por gerar os boletos
     * da entrada e da primeira parcela de uma negociação
     * -----------------------------------------------------
     * @param $tipo
     * @param $idNeg
     */
    public function boleto($tipo, $idNeg)
    {
        // Variaveis
        $dados = null;
        $cliente = null;

        // Busca a negociação
        $negociacao = $this->ObjModelNegociacao->get(["Id_negociacao" => $idNeg])->fetch(\PDO::FETCH_OBJ);

        // Busca o cliente da negociacao
        $cliente = $this->ObjModelCliente->get(["Id_cliente" => $negociacao->Id_cliente])->fetch(\PDO::FETCH_OBJ);
        $endereco = $this->ObjModelEndereco->get(["Id_endereco" => $cliente->Id_endereco])->fetch(\PDO::FETCH_OBJ);


        // --- BOLETO
        $taxa_boleto = 0;

        if($tipo == "entrada")
        {
            $data_venc = date("d/m/Y", strtotime($negociacao->vencimentoEntrada));  // Prazo de X dias OU informe data: "13/04/2006";
            $valor_cobrado = $negociacao->valorEntrada; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
            $valor_cobrado = str_replace(",", ".",$valor_cobrado);
            $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

            $dadosboleto["demonstrativo2"] = "Valor referente a entrada.<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
        }
        else
        {
            // Busca o Financiamento
            $fin = $this->ObjModelFinanciamento->get(["Id_valorFinanciamento" => $negociacao->Id_valorFinanciamento])->fetch(\PDO::FETCH_ASSOC);

            $valor = $fin["parcela_" . $negociacao->numParcela];


            $data_venc = date("d/m/Y", strtotime($negociacao->vencimentoParcela));  // Prazo de X dias OU informe data: "13/04/2006";
            $valor_cobrado = $valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
            $valor_cobrado = str_replace(",", ".",$valor_cobrado);
            $valor_boleto = number_format($valor_cobrado + $taxa_boleto, 2, ',', '');

            $dadosboleto["demonstrativo2"] = "Valor referente a 1ª Parcela.<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
        }


        // DADOS DO BOLETO PARA O SEU CLIENTE

        $dadosboleto["inicio_nosso_numero"] = date("y");	// Ano da geração do título ex: 07 para 2007
        $dadosboleto["nosso_numero"] = $negociacao->Id_negociacao; // Nosso numero (máx. 5 digitos) - Numero sequencial de controle.
        $dadosboleto["numero_documento"] = "27.3050." . $negociacao->Id_negociacao;	// Num do pedido ou do documento
        $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
        $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
        $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
        $dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

        // DADOS DO SEU CLIENTE
        $dadosboleto["sacado"] = $cliente->nome;
        $dadosboleto["endereco1"] = $endereco->logradouro . ", " . $endereco->numero;
        $dadosboleto["endereco2"] = $endereco->cidade . " - " . $endereco->estado . " -  CEP: " . $endereco->cep;

        // INFORMACOES PARA O CLIENTE
        $dadosboleto["demonstrativo1"] = "Pagamento de Compra em GreenPark Araçatuba";
        $dadosboleto["demonstrativo3"] = "GreenPark Araçatuba";

        // INSTRUÇÕES PARA O CAIXA
        $dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
        $dadosboleto["instrucoes2"] = "- Em caso de dúvidas entre em contato conosco: contato@greenparkaracatuba.com.br";
        $dadosboleto["instrucoes3"] = "&nbsp; Emitido pelo sistema da GreenPark Araçatuba";
        $dadosboleto["instrucoes4"] = "";

        // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
        $dadosboleto["quantidade"] = "";
        $dadosboleto["valor_unitario"] = "";
        $dadosboleto["aceite"] = "S";	    // N - remeter cobrança sem aceite do sacado  (cobranças não-registradas)
        // S - remeter cobrança apos aceite do sacado (cobranças registradas)
        $dadosboleto["especie"] = "R$";
        $dadosboleto["especie_doc"] = "A"; // OS - Outros segundo manual para cedentes de cobrança SICREDI


        // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


        // DADOS DA SUA CONTA - SICREDI
        $dadosboleto["agencia"] = "3021"; 	// Num da agencia (4 digitos), sem Digito Verificador
        $dadosboleto["conta"] = "09866"; 	// Num da conta (5 digitos), sem Digito Verificador
        $dadosboleto["conta_dv"] = "3"; 	// Digito Verificador do Num da conta

        // DADOS PERSONALIZADOS - SICREDI
        $dadosboleto["posto"]= "04";      // Código do posto da cooperativa de crédito
        $dadosboleto["byte_idt"]= "2";	  // Byte de identificação do cedente do bloqueto utilizado para compor o nosso número.
        // 1 - Idtf emitente: Cooperativa | 2 a 9 - Idtf emitente: Cedente
        $dadosboleto["carteira"] = "A";   // Código da Carteira: A (Simples)

        // SEUS DADOS
        $dadosboleto["identificacao"] = "GreenPark Araçatuba";
        $dadosboleto["cpf_cnpj"] = "00.858.180/0001-47";
        $dadosboleto["endereco"] = "Rua Afonso Pena, 613";
        $dadosboleto["cidade_uf"] = "Araçatuba / SP";
        $dadosboleto["cedente"] = "PAU BRASIL EMPREENDIMENTOS IMOBILIÁRIOS";


        // Chama os arquivos que vai gerar o boleto ]
        include("./app/helpers/boleto/funcoes_sicredi.php");
        include("./app/helpers/boleto/layout_sicredi.php");

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
    }


} // END >> Class::Imprimir